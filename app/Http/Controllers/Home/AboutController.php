<?php
namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AboutController extends CommentController
{
	public function index(Request $request)
	{
		$message = $this->getMessageData();
		$messdata = $this->getMessUser($message);
		$links = $this->getLinkData(true);
		if (empty($links)) {
			$links = null;
		}

		return view("home.about",[
			'title' => '关于我们 --遇见的博客网站',
			'messdata' => $messdata,
			'links'	=>$links,
		]);
	}

	private function getMessageData()
	{
		$message = DB::table("message")->where(["mestatus"=>1,"mepid"=>0])->select("meid","meuid","mepid","mecomment","mecreatetime")->orderBy("mecreatetime","desc")->get();
		return $this->getMessageZi($message);
	}

	private function getMessageZi($message,$name="child")
	{
		$arr = array();
		foreach ($message as $key => $val) {
			$mess = DB::table("message")->where("mepid",$val->meid)->select("meid","meuid","mepid","mecomment","mecreatetime")->orderBy("mecreatetime","desc")->get();
			if ($mess) {
				$val->$name = $this->getMessageZi($mess);
				$arr[] = $val;
			}
		}
		return $arr;
	}

	private function getMessUser($message,$name="child")
	{
		$arr = array();
		foreach ($message as $key => $val) {
			$user = DB::table("qq_user")->where("qqid",$val->meuid)->join("qq_img","qq_user.qqid","=","qq_img.qiqqid")->select("qq_user.qqnickname","qq_img.qifigureurl_qq_1")->first();
			$val->user = $user;
			$arr[] = $val;
			if ($message[$key]->$name != []) {
				$this->getMessUser($val->$name);
			}
		}
		return $arr;
	}

	public function message(Request $request)
	{
		$qqid = $this->getLoginId();
		if (empty($qqid)) {
			return $this->json_error("请登录","",301);
		}
		$message = $request->all();
		$message['mecomment'] = str_replace('script','js',$message['mecomment']);
		$message['mecomment'] = str_replace('php','p',$message['mecomment']);
		$message['mecomment'] = str_replace('iframe','gsq',$message['mecomment']);
		$message['meuid'] = $qqid;
		$message['mecreatetime'] = time();

		$bool = DB::table("message")->insert($message);
		if ($bool) {
			return $this->json_success("留言成功");
		}else{
			return $this->json_error("留言失败");
		}
	}
}