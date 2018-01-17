<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class TimelineController extends IndexController
{
	public function index()
	{
        $timeline = DB::table('timeline')->paginate(10);

        return view('admin.timeline.timeline',compact('timeline'));
	}

	public function create()
    {
        return view("admin.timeline.adds");
    }

    //文章添加数据库
    public function store(Request $request)
    {
        $list = $request->all();
        if (!empty($list['tistatus'])) {
            $list['tistatus'] = 1;
        }else{
            $list['tistatus'] = 2;
        }
        $list['titime'] = strtotime($list['titime']);
        $list['ticreatetime'] = time();

        $timeline = DB::table("timeline")->insert($list);
        if ($timeline) {
            self::$redis->del("timeline");
            self::$redis->del("timelines");
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
        $data = DB::table('timeline')->where("tiid",$id)->first();
        $data->titime = date("Y-m-d H:i:s",$data->titime);
        return view("admin.timeline.edit",compact('data'));
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
        if (!empty($list['tistatus'])) {
            $list['tistatus'] = 1;
        }else{
            $list['tistatus'] = 2;
        }
        $list['titime'] = strtotime($list['titime']);
        $list['tiupdatetime'] = time();
        unset($list['_method']);
        $timeline = DB::table("timeline")->where("tiid",$id)->update($list);
        if ($timeline) {
            return $this->json_success("添加成功");    
        }else{
            return $this->json_error("添加失败");
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
        $list = DB::table("timeline")->where('tiid',$id)->delete();
        if ($list) {
            self::$redis->del("timeline");
            self::$redis->del("timelines");
            return $this->json_success("删除成功");
        }else{
            return $this->json_error("删除失败");
        }
    }

    public function status(Request $request)
    {
    	$data = $request->all();
    	$status['tistatus'] = 2;
    	if (!empty($data['status']))
    		$status['tistatus'] = 1;
    	
    	$list = DB::table("timeline")->where('tiid',$data['id'])->update($status);
    	if ($list) {
            self::$redis->del("timeline");
            self::$redis->del("timelines");
    		return $this->json_success("修改成功");
    	}else{
    		return $this->json_error("修改失败");
    	}
    }
}
