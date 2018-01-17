<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Model\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use App\Model\Qiniu;

class ArticleController extends IndexController
{
	public function index()
	{
		$article = DB::table('article')->join('label_gl','article.arid','=','label_gl.lgarid')->where("arstatus",1)->select("article.*","label_gl.lglaid")->paginate(15);
		foreach ($article as $key => $val) {
			$article_img = DB::table("arimg")->where("aiarid",$val->arid)->select("aiimg")->first();
			if (!empty($article_img)) {
				$article[$key]->arimg = $article_img->aiimg;
			}else{
				$article[$key]->arimg = null;
			}
			$article[$key]->arcaid = DB::table("category")->where("caid",$val->arcaid)->select("caname")->first()->caname;
			$article[$key]->arrelease = DB::table("label")->where("laid",$val->lglaid)->select("laname")->first()->laname;
			$article[$key]->arcreatetime = date("Y-m-d H:i",$val->arcreatetime);
		}
		
		return view('admin.article.article',compact("article"));
	}

	public function create()
	{
		$list['category'] = DB::table('category')->where('castatus','1')->select('caid','caname')->get();
		$list['label'] = DB::table('label')->where('lastatus','1')->select('laid','laname')->get();
		return view("admin.article.adds",['list'=>$list]);
	}

	public function store(Request $request)
	{
		if ($request->hasFile('aiimg')) {
			$config = Config::get('config.qiniu');
			$qiniu = new Qiniu;

			list($ret,$err) = $qiniu->imge_upload($config['imge_policy']['cover'],$request->file('aiimg'));
			if ($err !== null) {
				return $this->json_success('图片上传失败');
			}
		}
		
		$article = $request->article;
		$article["arrelease"] = session('admin_info.adid');
		$article["arcreatetime"] = time();

		$arid = DB::table('article')->insertGetId($article);
		
		if ($arid) {
			$article_content['accontent'] = htmlspecialchars($request->article_content['accontent']);
			$article_content['acarid'] = $arid;
			$acid = DB::table('article_content')->insert($article_content);
			if (empty($acid)) {
				DB::table('article')->where("arid",$arid)->delete();
				return $this->json_error("文章内容添加失败");
			}else{
				$label_gl = $request->label;
				$label_gl['lgarid'] = $arid;
				$laargl = DB::table("label_gl")->insert($label_gl);
				if (empty($laargl)) {
					DB::table('article_content')->where("acid",$arid)->delete();
					DB::table('article')->where("arid",$arid)->delete();
					return $this->json_error("文章添加失败");
				}
			}

			if (!empty($ret['key'])) {
				$arimg['aiarid'] = $arid;
				$arimg['aiimg'] = $ret['key'];
				$img = DB::table('arimg')->insert($arimg);
				if (!$img) {
					return $this->json_error("图片名称保存失败");
				}
			}
		}

		

		return $this->json_success("添加成功");
	}

	public function recycle($id,$recycle)
	{
		$status['arstatus'] = $recycle == 1?2:1;
	
		$list = DB::table("article")->where("arid",$id)->update($status);
		if ($list) {
			return $this->json_success("已加入回收站");
		}else{
			return $this->json_error("加入回收站失败");
		}
	}

	public function edit($id)
	{
		$data = DB::table("article")->join('article_content','article.arid','=','article_content.acarid')->join('label_gl','article.arid','=','label_gl.lgarid')->where("arid",$id)->select('article.*','article_content.accontent','label_gl.lglaid')->first();
		$img = DB::table("arimg")->where("aiarid",$id)->select("aiimg")->first();
		if ($img) {
			$data->arimg = $img->aiimg;
		}
		$data->accontent = htmlspecialchars_decode($data->accontent);
		
		$list['category'] = DB::table('category')->where('castatus','1')->select('caid','caname')->get();
		$list['label'] = DB::table('label')->where('lastatus','1')->select('laid','laname')->get();
		return view("admin.article.edit",['data'=>$data,'list'=>$list]);
	}

	public function update(Request $request, $id)
	{
		if ($request->hasFile('aiimg')) {
			
			$config = Config::get('config.qiniu');
			$qiniu = new Qiniu;

			list($ret,$err) = $qiniu->imge_upload($config['imge_policy']['cover'],$request->file('aiimg'));
			if ($err !== null) {
				return $this->json_success('图片上传失败');

			}else{
				$delimg = DB::table("arimg")->where("aiarid",$id)->select("aiimg")->first();
				if ($delimg) {
					$arimg['aiimg'] = $ret['key'];
					$img = DB::table('arimg')->where("aiarid",$id)->update($arimg);
					if (!$img) {
						$error = $qiniu->delete($config['imge_bucket'],$ret['key']);
						return $this->json_error("图片名称保存失败");
					}
					$error = $qiniu->delete($config['imge_bucket'],$delimg->aiimg);
				}else{
					$arimg['aiimg'] = $ret['key'];
					$arimg['aiarid'] = $id;
					$img = DB::table('arimg')->insert($arimg);

					if (!$img) {
						$error = $qiniu->delete($config['imge_bucket'],$ret['key']);
						return $this->json_error("图片名称保存失败");
					}
				}
			}
		}

		$article = $request->article;
		$article["arupdatetime"] = time();

		$list = DB::table('article')->where("arid",$id)->update($article);
	
		if ($list) {
			$article_content['accontent'] = htmlspecialchars($request->article_content['accontent']);
			$acid = DB::table('article_content')->where("acarid",$id)->update($article_content);
			
			$label_gl = $request->label;
			$laargl = DB::table("label_gl")->where("lgarid",$id)->update($label_gl);
		}else{
			return $this->json_error("修改失败");
		}

		return $this->json_success("修改成功");
	}

	public function listrecycle()
	{
		$article = DB::table('article')->join('label_gl','article.arid','=','label_gl.lgarid')->where("arstatus",2)->select("article.*","label_gl.lglaid")->paginate(15);
		foreach ($article as $key => $val) {
			$article_img = DB::table("arimg")->where("aiarid",$val->arid)->select("aiimg")->first();
			if (!empty($article_img)) {
				$article[$key]->arimg = $article_img->aiimg;
			}else{
				$article[$key]->arimg = null;
			}
			$article[$key]->arcaid = DB::table("category")->where("caid",$val->arcaid)->select("caname")->first()->caname;
			$article[$key]->arrelease = DB::table("label")->where("laid",$val->lglaid)->select("laname")->first()->laname;
			$article[$key]->arcreatetime = date("Y-m-d H:i",$val->arcreatetime);
		}
		
		return view('admin.article.recycle',compact("article"));
	}

	public function destroy($id)
	{
		$status = DB::table("article")->where('arid',$id)->select("arstatus")->first()->arstatus;
		if ($status == 1) {
			return $this->json_error("请先放到回收站",'',301);
		}
		$bool = DB::table("article")->where("arid",$id)->delete();
		if ($bool) {
			$img = DB::table("arimg")->where("aiarid",$id)->select("aiimg")->first();
			if ($img) {
				DB::table("arimg")->where("aiarid",$id)->delete();
				$config = Config::get('config.qiniu');
				$qiniu = new Qiniu;
				$error = $qiniu->delete($config['imge_bucket'],$img->aiimg);
			}
			DB::table("article_content")->where("acarid",$id)->delete();
			DB::table("label_gl")->where("lgarid",$id)->delete();
			DB::table("browse")->where("brarid",$id)->delete();
			return $this->json_success("删除成功");
		}else{
			return $this->json_error("删除失败");
		}
	}

	public function alldel()
	{
		$arrid = DB::table("article")->where("arstatus",2)->select("arid")->get();
		$config = Config::get('config.qiniu');
		$qiniu = new Qiniu;
		if (empty($arrid->first())) {
			return $this->json_error("回收站暂无文章",'',306);
		}
		foreach ($arrid as $key => $val) {
			$img[] = DB::table('arimg')->where("aiarid",$val->arid)->select("aiimg","aiid")->first();
			foreach ($img as $k => $v) {
				if ($v->aiimg) {
					$error = $qiniu->delete($config['imge_bucket'],$v->aiimg);
					DB::table("arimg")->where("aiid",$v->aiid)->delete();
				}
			}
			DB::table("article_content")->where("acarid",$val->arid)->delete();
			DB::table("label_gl")->where("lgarid",$val->arid)->delete();
			DB::table("article")->where("arid",$val->arid)->delete();
		}
		return $this->json_success("文章已删除");
	}

	public function remmend(Request $request)
	{
		$data = $request->all();
		
		if (!empty($data['arremmend'])){
			$remmend['arremmend'] = 2;
			$count = DB::table("article")->where(["arremmend"=>2,"arstatus"=>1])->count();
			if ($count > 10) {
				return $this->json_error("只允许推荐10篇文章","",301);
			}
		}else{
			$remmend['arremmend'] = 1;
		}
		$list = DB::table("article")->where("arid",$data['id'])->update($remmend);
		if ($list) {
			if ($remmend['arremmend'] == 2) {
				return $this->json_success("推荐成功");
			}else{
				return $this->json_success("推荐取消");
			}
		}else{
			return $this->json_error("推荐失败");
		}
	}
}