<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResourceController extends CommentController
{
	public function index(Request $request)
	{
		// return redirect()->back()->withErrors(['该模块正在开发']);
		$photo = DB::table("photo")->where('phstatus',1)->select("phid","phphoto","phtitle")->orderBy("phid",'desc')->get();
		$album = DB::table("album")->where("alstatus",1)->select("alid","alname")->get();
	 	return view("home.resource",[
	 		'title' => "瀑布流 --遇见的博客网站",
	 		'photo' => $photo,
	 		'album' => $album,
	 	]);
	}

	public function data($id)
	{
		if ($id == 0) {
			$album = DB::table("photo")->where(['phstatus'=>1])->select("phid","phphoto","phtitle")->get();
		}else{
			$album = DB::table("photo")->where(['phstatus'=>1,'phalid'=>$id])->select("phid","phphoto","phtitle")->get();
		}
		if ($album->isEmpty())
			return $this->json_error("暂无照片");
		return $this->json_success("查询成功",$album);
	}
}