<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\LabelRequest;
use App\Model\Label;
use DB;

class LabelController extends IndexController
{
	public function index()
	{
        $label = DB::table('label')->paginate(15);
        
        return view('admin.label.label',compact('label'));
	}

	public function create()
    {
        return view("admin.label.adds");
    }

    //文章添加数据库
    public function store(LabelRequest $request)
    {
        $list = $request->all();
        if (!empty($list['lastatus'])) {
            $list['lastatus'] = 1;
        }else{
            $list['lastatus'] = 2;
        }

        $list['lacreatetime'] = time();

        $label = DB::table('label')->insert($list);
        if ($label) {
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
        $data = DB::table('label')->where("laid",$id)->first();
        
        return view("admin.label.edit",compact('data'));
    }

    /**
     * 在存储器中更新指定文章
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(LabelRequest $request, $id)
    {
        $list = $request->all();
        if (!empty($list['lastatus'])) {
            $list['lastatus'] = 1;
        }else{
            $list['lastatus'] = 2;
        }
        $list['laupdatetime'] = time();

        $label = DB::table("label")->where("laid",$id)->update($list);
        if ($label) {
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
        $list = DB::table("label")->where('laid',$id)->delete();
        if ($list) {
            return $this->json_success("删除成功");
        }else{
            return $this->json_error("删除失败");
        }
    }

    public function status(Request $request)
    {
    	$data = $request->all();
    	$status['lastatus'] = 2;
    	if (!empty($data['status']))
    		$status['lastatus'] = 1;
    	
    	$list = DB::table("label")->where('laid',$data['id'])->update($status);
    	// $list = false;
    	if ($list) {
    		return $this->json_success("修改成功");
    	}else{
    		return $this->json_error("修改失败");
    	}
    }
}
