<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class NoticeController extends IndexController
{
	public function index()
	{
        $notice = DB::table('notice')->paginate(10);

        return view('admin.notice.notice',[
            'notice' => $notice,
        ]);
	}

	public function create()
    {
        return view("admin.notice.adds");
    }

    //文章添加数据库
    public function store(Request $request)
    {
        $notice = $request->all();

        unset($notice['_token']);
        if (!empty($notice['nostatus'])) {
            $notice['nostatus'] = 1;
        }else{
            $notice['nostatus'] = 2;
        }
        $notice['nocreatetime'] = time();
        $bool = DB::table("notice")->insert($notice);
        if ($bool) {
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
        $notice = DB::table("notice")->where("noid",$id)->select("noid","notitle","nostatus")->first();

        return view("admin.notice.edit",[
            'notice' => $notice,
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
        $notice = $request->all();

        unset($notice['_token']);
        unset($notice['_method']);
        
        if (!empty($notice['nostatus'])){
            $notice['nostatus'] = 1;
        }else{
            $notice['nostatus'] = 2;
        }
        $notice['noupdatetime'] = time();

        $notices = DB::table("notice")->where("noid",$id)->update($notice);
        if ($notices) {
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
        $bool = DB::table("notice")->where("noid",$id)->delete();
        if ($bool) {
            return $this->json_success("删除成功");
        }else{
            return $this->json_error("删除失败");
        }
    }

    public function status(Request $request)
    {
    	$data = $request->all();
        $status['nostatus'] = 2;
        if (!empty($data['status']))
            $status['nostatus'] = 1;
        
        $list = DB::table("notice")->where('noid',$data['id'])->update($status);
        // $list = false;
        if ($list) {
            return $this->json_success("修改成功");
        }else{
            return $this->json_error("修改失败");
        }
    }
}
