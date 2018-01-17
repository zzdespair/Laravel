<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Model\Qiniu;
use App\Http\Controllers\Controller;
use DB;

class ExtendController extends IndexController
{
	public function index()
	{
        $links = DB::table('link')->paginate(10);

        return view('admin.extend.extend',[
            'links' => $links,
        ]);
	}

	public function create()
    {
        return view("admin.extend.adds");
    }

    //文章添加数据库
    public function store(Request $request)
    {
       if ($request->hasFile('lilogo')) {
            $config = Config::get('config.qiniu');
            $qiniu = new Qiniu;

            list($ret,$err) = $qiniu->imge_upload($config['imge_policy']['cover'],$request->file('lilogo'));
            if ($err !== null) {
                return $this->json_success('图片上传失败');
            }
        }

        if (empty($ret['key'])) {
            return $this->json_error("LOGO必须上传","",306);
        }

        $link = $request->all();
        unset($link['_token']);
        
        if (!empty($link['listatus'])){
            $link['listatus'] = 1;
        }else{
            $link['listatus'] = 2;
        }
        $link['licreatetime'] = time();
        $link['lilogo'] = $ret['key'];

        $links = DB::table("link")->insert($link);
        if ($links) {
            return $this->json_success("添加成功");
        }else{
            return $this->json_error("添加失败");
        }
    }

     /**
     * 显示指定文章
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 显示编辑指定文章的表单页面
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $links = DB::table("link")->where("liid",$id)->select("liid","liname","listatus","lilink","lilogo")->first();

        return view("admin.extend.edit",[
            'links' => $links,
        ]);
    }

    /**
     * 在存储器中更新指定文章
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if ($request->hasFile('lilogo')) {
            $config = Config::get('config.qiniu');
            $qiniu = new Qiniu;

            list($ret,$err) = $qiniu->imge_upload($config['imge_policy']['cover'],$request->file('lilogo'));
            if ($err !== null) {
                return $this->json_error('图片上传失败');
            }
        }

        $link = $request->all();

        unset($link['_token']);
        unset($link['_method']);
        
        if (!empty($link['listatus'])){
            $link['listatus'] = 1;
        }else{
            $link['listatus'] = 2;
        }
        $link['liupdatetime'] = time();
        if (!empty($ret['key'])) {
            $link['lilogo'] = $ret['key'];
            $delimg = DB::table("link")->where("liid",$id)->select("lilogo")->first();
            if ($delimg) {
                $error = $qiniu->delete($config['imge_bucket'],$delimg->lilogo);
            }
        }

        $links = DB::table("link")->where("liid",$id)->update($link);
        if ($links) {
            return $this->json_success("编辑成功");
        }else{
            return $this->json_error("编辑失败");
        }
    }

    /**
     * 从存储器中移除指定文章
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $delimg = DB::table("link")->where("liid",$id)->select("lilogo")->first();
        $img = $delimg->lilogo;
        $bool = DB::table("link")->where("liid",$id)->delete();
        if ($bool) {
            $config = Config::get('config.qiniu');
            $qiniu = new Qiniu;
            $error = $qiniu->delete($config['imge_bucket'],$img);
            return $this->json_success("删除成功");
        }else{
            return $this->json_error("删除失败");
        }
    }

    public function status(Request $request)
    {
    	$data = $request->all();
        $status['listatus'] = 2;
        if (!empty($data['status']))
            $status['listatus'] = 1;
        
        $list = DB::table("link")->where('liid',$data['id'])->update($status);
        // $list = false;
        if ($list) {
            return $this->json_success("修改成功");
        }else{
            return $this->json_error("修改失败");
        }
    }
}
