<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class IndexController extends CommentController
{
	public function index()
	{

		$log = $this->getLoginDetail();
		$statistics = $this->getStatisticsData();
		// dd($this->getResCount());
		return view('admin.index.index',[
			'log' => $log,
			'statistics' => $statistics,
		]);
	}

	private function getStatisticsData()
	{
		$statistics = (array)json_decode(self::$redis->get("statistics"));
		if (empty($statistics)) {
			$list['user'] = DB::table("qq_user")->count();
			$list['register'] = $this->getResCount();
			$list['login'] = $statistics['user']/2;
			$list['article'] = DB::table("article")->count();
			$list['resource'] = DB::table("photo")->count();
			$list['note'] = 321;
			self::$redis->set("statistics",43200,json_encode($list));
			$statistics = $list;
		}

		return $statistics;
	}

	private function getResCount()
	{
		$time = strtotime(date("Y-m-d",strtotime("+1 day")).' '.'00:00:00');
		$times = strtotime(date("Y-m-d",time()).' '.'00:00:00');
		$count = DB::table("qq_user")->whereBetween("qqcreatetime",[$times,$time])->count();
		return $count;
	}

	private function getLoginDetail()
	{
		$me = $this->getSessionData();
		$id = DB::table("login_detaile")->orderBy("zlid","desc")->where(["zlstatus"=>1,"zladid"=>$me['adid']])->select("zlid")->first()->zlid;

		$loid = $this->logDetId($id,$me['adid']);
		
		$logDet = DB::table("login_detaile")->where(["zlid"=>$loid,"zlstatus"=>1,"zladid"=>$me['adid']])->first();
		$ip = $logDet->zlip;
		$url = "http://api.map.baidu.com/location/ip?ak=w0onIEmMuG5lGkksaBILqzKF2gEb3645&ip=".$ip."&coor=bd09ll";
		$info = $this->curl($url);
		$infos['ip'] = $ip;
		$infos['logtime'] = $logDet->zltime;
		$infos['address'] = $info['content']['address_detail']['city']." ".$info['content']['address_detail']['province'];
		$infos['x'] = $info['content']['point']['x'];
		$infos['y'] = $info['content']['point']['y'];
		return $infos;
	}

	private function logDetId($id,$adid)
	{
		$list = DB::table("login_detaile")->where(["zlid"=>$id-1,"zladid"=>$adid,"zlstatus"=>1])->select("zlid")->first();
		if (empty($list)) {
			$list = $this->logDetId($id-1);
		}
		return $list->zlid;
	}
}