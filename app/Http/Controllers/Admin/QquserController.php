<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DB;

class QquserController extends IndexController
{
	public function index()
	{
        $qquser = DB::table('qq_user')->join("qq_img","qq_user.qqid","=","qq_img.qiqqid")->select("qq_user.qqnickname","qq_user.qqgender","qq_user.qqprovince","qq_user.qqcity","qq_user.qqyear","qq_user.qq_yellow_vip_level","qq_user.qq_level","qq_img.qifigureurl_qq_1")->paginate(15);
        
        return view('admin.qquser.qquser',['qquser'=>$qquser]);
	}
}
