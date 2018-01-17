<?php
namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DetailController extends CommentController
{
	public function index(Request $request,$id)
	{
		$detaile = DB::table("article")->where(["arid"=>$id,"arstatus"=>'1'])->join("article_content","article.arid", "=","article_content.acarid")->join("label_gl","article.arid","=","label_gl.lgarid")->select("article.arid","article.arcaid","article.artitle","article.arcreatetime","article.arauthod","article_content.accontent","article.arbrowse","label_gl.lglaid")->first();
		if (empty($detaile)) {
			return redirect()->back()->withErrors(['文章不存在或已被禁用']);
		}else{
			$ip = $request->getClientIp();
			$this->browse($detaile->arid,$ip);
		}
		$img = DB::table("arimg")->where("aiarid",$detaile->arid)->select("aiimg")->first();
		if ($img) {
			$detaile->img = $img->aiimg;
		}else{
			$detaile->img = "";
		}
		$detaile->arbrowse = $detaile->arbrowse+1;
		$detaile->accontent = htmlspecialchars_decode($detaile->accontent);
		$detaile->cate = DB::table("category")->where("caid",$detaile->arcaid)->select("caname")->first()->caname;
		$category = $this->getCategory();
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $comment = DB::table("comment")->where(["comarid"=>$id,"comstatus"=>1])->join("qq_user","comment.comuid","=","qq_user.qqid")->join("qq_img","comment.comuid","=","qq_img.qiqqid")->select("comment.comid","comment.comuid","comment.comcomment","comment.comcreatetime","qq_user.qqnickname","qq_img.qifigureurl_qq_1")->get();
        $casuallook = $this->getCasualLook(10);
		if (empty($casuallook)) {
			$casuallook = null;
		}
        
		$similar = $this->getSimilarData($detaile->lglaid,$detaile->arid);
		if (empty($similar)) {
			$similar = null;
		}

		$shang = DB::table("article")->where('arstatus',1)->where("arid",">",$detaile->arid)->orderBy("arid","asc")->select("arid","artitle")->first();
		if (empty($shang)) {
			$shang = null;
		}
		$xia = DB::table("article")->where('arstatus',1)->where("arid","<",$detaile->arid)->orderBy("arid","desc")->select("arid","artitle")->first();
		if (empty($xia)) {
			$xia = null;
		}

		return view("home.detail",[
			'title' => $detaile->artitle." -- 遇见博客",
			'detaile' => $detaile,
			'category' => $category,
			'url' => $url,
			'comment' => $comment,
			'casuallook' => $casuallook,
			'similar' => $similar,
			'shang' => $shang,
			'xia' => $xia,
		]);
	}

	private function browse($id,$ip)
	{
		$browse['brarid'] = $id;
		$browse['brip'] = $ip;
		$browse['brcreatetime'] = time();
		DB::table("browse")->insert($browse);
		DB::table("article")->where("arid",$id)->increment("arbrowse");
	}

	public function comment(Request $request,$id)
	{
		if (empty($_SESSION['qqlogin']['userdata']['qqid'])) {
			return $this->json_error("请登录",'',301);
		}
		$comment = $request->all();
		$comment['comuid'] = $_SESSION['qqlogin']['userdata']['qqid'];
		$comment['comcreatetime'] = time();
		$comment['comarid'] = $id;
		$message['comcomment'] = str_replace('script','js',$comment['comcomment']);
		$message['comcomment'] = str_replace('php','p',$message['comcomment']);
		$comment['comcomment'] = str_replace('iframe','gsq',$message['comcomment']);
		$boolea = DB::table("comment")->insert($comment);
		if ($boolea) {
			DB::table("article")->where("arid",$id)->increment("arcomcount");
			return $this->json_success("评论成功");
		}else{
			return $this->json_error("评论失败");
		}
	}

	private function getSimilarData($laid,$id)
	{
		$labelList = DB::table("label_gl")->where("lglaid",$laid)->select("lgarid")->limit(10)->orderBy("lgid","desc")->get();
		if ($labelList->isEmpty()) {
			return false;
		}
		foreach ($labelList as $key => $val) {
			if ($val->lgarid != $id) {
				$article[] = DB::table("article")->where(["arid"=>$val->lgarid,"arstatus"=>1])->select("arid","artitle")->first();
			}	
		
		}
		if (!empty($article)) {
			return $article;
		}else{
			return false;	
		}
	}
}