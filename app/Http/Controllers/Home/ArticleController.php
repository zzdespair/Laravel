<?php
namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controllers;

class ArticleController extends CommentController
{
	public function index(Request $request)
	{
		// dd($request->all());
		$where = null;
		if (!empty($request->all())) {
			$where = $request->all();	
			if (!empty($where['title'])) {
				$article = DB::table("article")->join("label_gl","article.arid","=","label_gl.lgarid")->join("label","label_gl.lglaid","=","label.laid")->where(["arstatus"=>1])->where("artitle","like","%".$where['title']."%")->orderBy("arid","desc")->select("article.arid","article.artitle","article.arftitle","article.arcreatetime","article.arcomcount","article.arbrowse","article.arauthod","label.laname")->get();
			}else if(!empty($where['arcaid'])){
				$article = DB::table("article")->join("label_gl","article.arid","=","label_gl.lgarid")->join("label","label_gl.lglaid","=","label.laid")->where(["arstatus"=>1])->where("arcaid",$where['arcaid'])->orderBy("arid","desc")->select("article.arid","article.artitle","article.arftitle","article.arcreatetime","article.arcomcount","article.arbrowse","article.arauthod","label.laname")->get();
			}
		}else{
			$article = DB::table("article")->join("label_gl","article.arid","=","label_gl.lgarid")->join("label","label_gl.lglaid","=","label.laid")->where(["arstatus"=>1])->orderBy("arid","desc")->select("article.arid","article.artitle","article.arftitle","article.arcreatetime","article.arcomcount","article.arbrowse","article.arauthod","label.laname")->get();
		}

		$notice = null;
		$casual = null;
		
		if ($article->isEmpty()) {
			if (!empty($where['title'])) {
				$notice = $where['title'];
			}else if(!empty($where['arcaid'])){
				$notice = DB::table("category")->where("caid",$where['arcaid'])->select("caname")->first()->caname;
			}
			$casual = DB::table("article")->join("label_gl","article.arid","=","label_gl.lgarid")->join("label","label_gl.lglaid","=","label.laid")->where(["arstatus"=>1])->orderBy(\DB::raw('RAND()'))->take(10)->select("article.arid","article.artitle","article.arftitle","article.arcreatetime","article.arcomcount","article.arbrowse","article.arauthod","label.laname")->get();
			if ($casual->isEmpty()) {
				$casual = null;
			}else{
				foreach ($casual as $key => $val) {
					$img = DB::table("arimg")->where("aiarid",$val->arid)->select("aiimg")->first();
					if ($img) {
						$casual[$key]->img = $img->aiimg;
					}else{
						$casual[$key]->img = null;
					}
				}
			}
		}else{
			foreach ($article as $key => $val) {
				$img = DB::table("arimg")->where("aiarid",$val->arid)->select("aiimg")->first();
				if ($img) {
					$article[$key]->img = $img->aiimg;
				}else{
					$article[$key]->img = null;
				}
			}
		}
			
		$category = $this->getCategory();
		// dd($category);
		$remmend = $this->getRemmend();
		
		if (empty($remmend)) {
			$remmend = null;
		}
		$casuallook = $this->getCasualLook(10);
		if (empty($casuallook)) {
			$casuallook = null;
		}
		return view("home.article",[
			'title' => "文章列表 --遇见的博客网站",
			'category' => $category,
			'article' => $article,
			'notice' => $notice,
			'casual' => $casual,
			'remmend' => $remmend,
			'casuallook' => $casuallook,
		]);
	}
}