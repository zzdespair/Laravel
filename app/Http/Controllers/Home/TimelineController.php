<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TimelineController extends CommentController
{
	public function index(Request $request)
	{
		// return redirect()->back()->withErrors(['该模块正在开发']);
		$timeline = $this->getTimeLine();
		// dd($timeline);
	 	return view("home.timeline",[
	 		'title' => "时光轴 --遇见的博客网站",
	 		'timeline' => $timeline,
	 	]);
	}
}