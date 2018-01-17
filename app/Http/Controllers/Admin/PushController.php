<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PushController extends CommentController
{
	public function push()
	{
		$list = $this->getArticleId();
		if ($list->isEmpty()) {
			return $this->json_error("暂无可推送文章");
		}
		foreach ($list as $key => $val) {
			$urls[] = 'http://blog.zhuxv.com/detail/id/'.$val->arid;
		}
		
		$api = 'http://data.zz.baidu.com/urls?site=blog.zhuxv.com&token=TuDwB5DYVGyWTIrx';
		$ch = curl_init();
		$options =  array(
		    CURLOPT_URL => $api,
		    CURLOPT_POST => true,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POSTFIELDS => implode("\n", $urls),
		    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
		);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		return $result;
	}

	private function getArticleId()
	{
		$list = DB::table("article")->where("arstatus",1)->select("arid")->get();
		return $list;
	}
}