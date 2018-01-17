<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DB;

class AlbumController extends IndexController
{
	public function index()
	{
        $album = DB::table("album")->paginate(15);
        return view('admin.album.album',[
            'album' => $album,
        ]);
	}

	public function create()
    {
        return view("admin.album.adds");
    }

    //文章添加数据库
    public function store(Request $request)
    {
        $list = $request->all();
        if (!empty($list['alstatus'])) {
            $list['alstatus'] = 1;
        }else{
            $list['alstatus'] = 2;
        }
        $list['alcreatetime'] = time();

        $album = DB::table("album")->insert($list);
        if ($album) {
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
        $data = DB::table('album')->where("alid",$id)->first();
        
        return view("admin.album.edit",compact('data'));
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
        $list = $request->all();
        if (!empty($list['alstatus'])) {
            $list['alstatus'] = 1;
        }else{
            $list['alstatus'] = 2;
        }
        $list['alupdatetime'] = time();
        $album = DB::table("album")->where("alid",$id)->update($list);
        if ($album) {
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
        if (DB::table("photo")->where('phalid',$id)->first()) {
            return $this->json_error("此相册分类下有照片,请先删除照片","",301);
        }

        $list = DB::table("album")->where('alid',$id)->delete();
        if ($list) {
            return $this->json_success("删除成功");
        }else{
            return $this->json_error("删除失败");
        }
    }

    public function status(Request $request)
    {
    	$data = $request->all();
    	$status['alstatus'] = 2;
    	if (!empty($data['status']))
    		$status['alstatus'] = 1;
    	
    	$list = DB::table("album")->where('alid',$data['id'])->update($status);
    	if ($list) {
            if ($status['alstatus'] == 1) {
                return $this->json_success("分类启用");
            }
    	    return $this->json_success("分类禁用");
    	
        }else{
    		return $this->json_error("修改失败");
    	}
    }
}
