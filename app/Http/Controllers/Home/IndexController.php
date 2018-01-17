<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Model\Article;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Redis;

class IndexController extends CommentController
{
	public function index(Request $request)
	{
		// $this->redis->hSet('list','name','value');
		// $this->redis->hSet('list','name1','value1');
		// $list = $this->redis->hVals('list');
		// dd($list);
	 // if(isset($_SERVER)){
	 //        if($_SERVER['SERVER_ADDR']){
	 //            $server_ip=$_SERVER['SERVER_ADDR'];
	 //        }else{
	 //            $server_ip=$_SERVER['LOCAL_ADDR'];
	 //        }
	 //    }else{
	 //        $server_ip = getenv('SERVER_ADDR');
	 //    }
	 //    dump($server_ip);exit;
	//  $ip = $_SERVER['REMOTE_ADDR'];
	//  // $ip = '183.57.53.222';
	//  $url = "http://api.map.baidu.com/location/ip?ak=w0onIEmMuG5lGkksaBILqzKF2gEb3645&ip=".$ip."&coor=bd09ll";
	// $ch = curl_init();
	// curl_setopt($ch, CURLOPT_URL, $url);
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// $output = curl_exec($ch);
	// if(curl_errno($ch))
	// { echo 'CURL ERROR Code: '.curl_errno($ch).', reason: '.curl_error($ch);}
	// curl_close($ch);
	// $info = json_decode($output, true);
	// // echo "<pre>";
	// // var_dump($info);
	// // echo "</pre>";
	// // exit;
	// if($info['status'] == "0"){
	//     $lotx = $info['content']['point']['y'];
	//     $loty = $info['content']['point']['x'];
	//     $citytemp = $info['content']['address_detail']['city'];
	//     $keywords = explode("市",$citytemp);
	//     $city = $keywords[0];
	// }
	// else{
	//     $lotx = "34.2597";
	//     $loty = "108.9471";
	//     $city = "西安";
	// }
	 
	
	// var_dump($lotx);//x坐标  纬度
	// var_dump($loty);//y坐标  经度
	// var_dump($city);//用户Ip所在城市
	// return;
	// dump(empty(DB::table("fang")->where('ip','!=',$_SERVER['REMOTE_ADDR'])->first()));exit;
	// if (DB::table("fang")->where('ip','!=',$_SERVER['REMOTE_ADDR'])->first()) {
	// 	$bloo = DB::table('fang')->insert(['ip'=>$_SERVER['REMOTE_ADDR'],'http_user_agent'=>$_SERVER['HTTP_USER_AGENT'],'ctime'=>date("Y-m-d H:i:s",time()),'address'=>$city,'lotx'=>$lotx,'loty'=>$loty]);
	// }
		// return;
		$state = $request->state;
		if (empty($_SESSION['qqlogin'])) {
			if ($state == 'qqlogin') {
				$code = $request->code;
				$threeLogin = $this->qqlogin($code);
				session('threeLogin',$threeLogin);
				$qq = explode("&",$threeLogin);
				foreach ($qq as $key => $val) {
					$access_token[] = explode("=",$val);
					foreach ($access_token as $k => $v) {
						$_SESSION['qqlogin'][$v[0]] = $v[1];
					}
				}
				$qqData = $this->getQqData();
				
				$qqOpenid = (array)json_decode(substr($qqData,strpos($qqData,'(')+1,-3));
				$_SESSION['qqlogin']['openid'] = $qqOpenid['openid'];
				$exis_openid = DB::table("qq_user")->where("qqopenid",$qqOpenid['openid'])->first();
				if (!$exis_openid) {
					$getQq = (array)json_decode($this->getQ($qqOpenid['openid']));
					if ($getQq['ret'] == 0) {
						$qqdata = array();
						$qqimgdata = array();
						$qqdata = [
							'qqopenid' => $_SESSION['qqlogin']['openid'],
							'qqis_lost' => $getQq['is_lost'],
							'qqnickname' => $getQq['nickname'],
							'qqgender' => $getQq['gender'],
							'qqprovince' => $getQq['province'],
							'qqcity' => $getQq['city'],
							'qqyear' => $getQq['year'],
							'qq_is_yellow_vip' => $getQq['is_yellow_vip'],
							'qq_vip' => $getQq['vip'],
							'qq_yellow_vip_level' => $getQq['yellow_vip_level'],
							'qq_level' => $getQq['level'],
							'qq_is_yellow_year_vip' => $getQq['is_yellow_year_vip'],
							'qqcreatetime' => time(),
						];
						$qqimgdata = [
							'qifigureurl' => $getQq['figureurl'],
							'qifigureurl_1' => $getQq['figureurl_1'],
							'qifigureurl_2' => $getQq['figureurl_2'],
							'qifigureurl_qq_1' => $getQq['figureurl_qq_1'],
							'qifigureurl_qq_2' => $getQq['figureurl_qq_2'],
						];
						$_SESSION['qqlogin']['userdata'] = $qqdata;
						$_SESSION['qqlogin']['userimg'] = $qqimgdata;
						$qquserid = DB::table("qq_user")->insertGetId($qqdata);
						if ($qquserid) {
							$_SESSION['qqlogin']['userdata']['qqid'] = $qquserid;
							$qqimgdata['qiqqid'] = $qquserid;
							$bool = DB::table("qq_img")->insert($qqimgdata);
							if (!$bool) {
								DB::table("qq_user")->where("qqid",$qquserid)->delete();
								return redirect()->action('Home\IndexController@index')->withErrors(['登陆失败,请重新登录']);
							}

						}
					}
				}else{
					$_SESSION['qqlogin']['userdata']=(array)$exis_openid;
					$_SESSION['qqlogin']['userimg']=(array)DB::table("qq_img")->where("qiqqid",$exis_openid->qqid)->first();
				}
			}else if($state == 'weibologin'){
				$code = $request->code;
				// var_dump($code);exit;
				if ($code) {
					$access_token = $this->weibo($code);
					echo "<pre>";
					var_dump($access_token);
					echo "</pre>";exit;
				}
			}
		}
		
		$list = json_decode($this->redis->hGet("index","index1")); //获取首页当前加载的文章
		if (empty($list)) {
			$list = $index1 = json_encode(DB::table('article')->orderBy('arid','desc')->where("arstatus",'1')->join("label_gl","article.arid", "=","label_gl.lgarid")->join("label", "label_gl.lglaid", "=","label.laid")->select("article.arid","article.artitle","article.arftitle","article.arcreatetime","article.arauthod","label.laname","article.arbrowse","article.arcomcount")->limit(5)->get());
			$this->redis->hSet("index","index1",$index1);
			$list = json_decode($list);
		}
		// dd($list);
		foreach ($list as $key => $val) {
			$img = DB::table("arimg")->where("aiarid",$val->arid)->select("aiimg")->first();
			if ($img) {
				$list[$key]->img = $img->aiimg;
			}else{
				$list[$key]->img = "";
			}
		}
			
		$hot = $this->hot();
		
		$links = $this->getLinkData();
		if (empty($links)) {
			$links = null;
		}

		$notice = json_decode($this->redis->get("notice"));
		if (empty($notice)) {
			$notices = json_encode(DB::table("notice")->where("nostatus",1)->select("notitle")->get());
			$this->redis->set("noticle",$notices);
			$notice = json_decode($notices);
		}

		$timeline = $this->getTimeLine(5);
		// dd($timeline);

		return view('home.index',[
			'title' => "遇见的博客网站",
			'list'	=> $list,
			'hot'	=> $hot,
			'links' => $links,
			'notice'=> $notice,
			'timeline' => $timeline,
		]);
	}

	// private function weibo($code)
	// {
	// 	$url = 'https://api.weibo.com/oauth2/access_token?client_id=873023586&client_secret=3598a034aebe9df25b90650b170574e7&grant_type=authorization_code&redirect_uri=http://blog.zhuxv.com&code='.$code;

	// 	return $this->send_post($url,array());

	// }
	
	// private function qqlogin($code)
	// {
	// 	$url = 'https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id=101439614&client_secret=91e6d50a7062e9cf1e231e531f358597&code='.$code.'&redirect_uri=http://blog.zhuxv.com/';

	// 	$token = $this->getJson($url);

	// 	return $token;
	// }
	
	private function qqlogin($code)
	{
		$url = "https://graph.qq.com/oauth2.0/token";
		$data['grant_type'] = 'authorization_code';
		$data['client_id'] = '101439614';
		$data['client_secret'] = '91e6d50a7062e9cf1e231e531f358597';
		$data['code'] = $code;
		$data['redirect_uri'] = "http://blog.zhuxv.com/";

		$qq = $this->curl($url,1,$data);
		return $qq;
	}

	private function getQqData()
	{
		$url = 'https://graph.qq.com/oauth2.0/me';
		$data['access_token'] = $_SESSION['qqlogin']['access_token'];

		$qqData = $this->curl($url,1,$data);

		return $qqData;
	}

	private function getQ($openid)
	{
		$url = "https://graph.qq.com/user/get_user_info";
		$data['access_token'] = $_SESSION['qqlogin']['access_token'];
		$data['oauth_consumer_key'] = '101439614';
		$data['openid'] = $openid;

		$getQ = $this->curl($url,1,$data);

		return $getQ;
	}

	private function weibo($code)
	{
		$url = "https://api.weibo.com/oauth2/access_token/";
		$data['client_id'] = 873023586;
		$data['client_secret'] = '3598a034aebe9df25b90650b170574e7';
		$data['grant_type'] = 'authorization_code';
		$data['redirect_uri'] = 'http://blog.zhuxv.com/index.php';


		$C = $this->curl($url,1,$data);
		dd($C);
	}

	private function hot() //获取热文排行
	{
		$list = json_decode($this->redis->get("hot"));
		if (empty($list)) {
			$list = $hot = DB::table("article")->orderBy("arbrowse","desc")->limit(8)->select("arid","artitle")->get();
			$this->redis->setex("hot",86400,json_encode($hot));
		}
		return $list;
	}

	public function send()
	{
		$p = isset($_POST['k'])?intval(trim($_POST['k'])):2;
		
		$data = json_decode($this->redis->hGet("index","index".$p));
		if (empty($data)) {
			$total = DB::table("article")->where("arstatus",1)->count();
			$num = 5;
			$totalpage=ceil($total/$num);
			$limitpage=($p-1)*$num;
			if ($p>$totalpage) {
				return $this->json_error("暂无数据");
			}
			$list = DB::table("article")->where("arstatus",1)->offset($limitpage)->limit($num)->orderBy('arid','desc')->join("label_gl","article.arid", "=","label_gl.lgarid")->join("label", "label_gl.lglaid", "=","label.laid")->select("article.arid","article.artitle","article.arftitle","article.arcreatetime","article.arauthod","label.laname","article.arbrowse","article.arcomcount")->get();	
			foreach ($list as $key => $val) {
				$img = DB::table("arimg")->where("aiarid",$val->arid)->select("aiimg")->first();
				if ($img) {
					$list[$key]->img = $img->aiimg;
				}else{
					$list[$key]->img = "";
				}
				if (empty($list[$key]->arauthod)) {
					$list[$key]->arauthod = '遇见博客';
				}
				$list[$key]->arcreatetime = date("Y-m-d",$list[$key]->arcreatetime);
			}
			$this->redis->hSet("index","index".$p,json_encode($list));
			$data = $list;
		}
		
		if (count($data)>0) {
			return $this->json_success("查询".count($data)."条数据",$data);
		}else{
			return $this->json_error("暂无数据");
		}
	}
}