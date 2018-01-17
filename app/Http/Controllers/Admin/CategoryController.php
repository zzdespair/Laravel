<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Model\Category;
use DB;

class CategoryController extends IndexController
{
	public function index()
	{
        $category = DB::table('category')->paginate(10);
        // $category = Category::paginate(1);
        foreach ($category as $key => $val) {
        	if ($val->capid != 0) {
        		$capid = $val->capid;
        		$category[$key]->capid = DB::table('category')->where("caid",'=',$capid)->select('caname')->first()->caname;
        	}else{
        		$category[$key]->capid = "无";
        	}
        }
        
      
		// return view('admin.category.category',['category'=>$category]);
        return view('admin.category.category',compact('category'));
	}

	public function create()
    {
        return view("admin.category.adds");
    }

    //文章添加数据库
    public function store(CategoryRequest $request)
    {
        $list = $request->all();
        if (!empty($list['castatus'])) {
            $list['castatus'] = 1;
        }else{
            $list['castatus'] = 2;
        }
        $list['capid'] = 0;
        $list['cacreatetime'] = time();

        $cate = DB::table("category")->insert($list);
        if ($cate) {
            self::$redis->del("category");
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
        $data = DB::table('category')->where("caid",$id)->first();
        
        return view("admin.category.edit",compact('data'));
    }

    /**
     * 在存储器中更新指定文章
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $list = $request->all();
        if (!empty($list['castatus'])) {
            $list['castatus'] = 1;
        }else{
            $list['castatus'] = 2;
        }
        $list['capid'] = 0;
        $list['caupdatetime'] = time();

        $cate = DB::table("category")->where("caid",$id)->update($list);
        if ($cate) {
            self::$redis->del("category");
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
        if (DB::table("category")->where('capid',$id)->first()) {
            return $this->json_error("此分类下有子分类,删除失败","",301);
        }

        $list = DB::table("category")->where('caid',$id)->delete();
        if ($list) {
            self::$redis->del("category");
            return $this->json_success("删除成功");
        }else{
            return $this->json_error("删除失败");
        }
    }

    public function status(Request $request)
    {
    	$data = $request->all();
    	$status['castatus'] = 2;
    	if (!empty($data['status']))
    		$status['castatus'] = 1;
    	
    	$list = DB::table("category")->where('caid',$data['id'])->update($status);
    	if ($list) {
            self::$redis->del("category");
    		return $this->json_success("修改成功");
    	}else{
    		return $this->json_error("修改失败");
    	}
    }
}
