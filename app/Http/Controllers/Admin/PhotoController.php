<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Model\Qiniu;
use App\Http\Controllers\Controller;
use DB;

class PhotoController extends IndexController
{
	public function index()
	{
        $photo = DB::table("photo")->join("album","photo.phalid","=","album.alid")->select("photo.*","album.alname")->paginate(15);

        return view('admin.photo.photo',[
            'photo' => $photo,
        ]);
	}

	public function create()
    {
        $album = DB::table("album")->where("alstatus",1)->get();

        return view("admin.photo.adds",[
            'album' => $album,
        ]);
    }

    //文章添加数据库
    public function store(Request $request)
    {
        $file = $request->file("phphoto");
        if (empty($file)) {
            return $this->json_error("找不到文件或没有文件被上传","",406);
        }
        $title = $request->phtitle;
        $alid = $request->phalid;
        if (empty($alid))
            return $this->json_error("请选择分类","",305);
        if (strlen($title) >= 254)
            return $this->json_error("标题过长","",301);
        $filePath = [];
        foreach ($file as $key => $val) {
            if (!$val->isValid()) {
                return $this->json_error("图片上传出错,请重试","",307);
            }
            if (!empty($val)) { //此处防止没有多文件上传的情况
                $allowed_extensions = ['png', 'jpg', 'jpeg', 'gif'];
                if ($val->getClientOriginalExtension() && !in_array($val->getClientOriginalExtension(),$allowed_extensions)) {
                    return $this->json_error("仅支持jpg,png,jpeg,gif格式文件上传","",301);
                }
                $config = Config::get('config.qiniu');
                $qiniu = new Qiniu;

                list($ret,$err) = $qiniu->imge_upload($config['imge_policy']['cover'],$val);
                if ($err !== null) {
                    return $this->json_error("图片上传七牛云出错");
                }
            }
            $filePath[] = $ret['key'];
        }

        
        $data['phstatus'] = 2;
        if (!empty($request->phstatus));
            $data['phstatus'] = 1;
        $data['phtitle'] = $title;
        $data['phalid'] = $alid;
        $data['phcreatetime'] = time();
        foreach ($filePath as $key => $val) {
            $data['phphoto'] = $val;
            $list = DB::table("photo")->insert($data);
            if (empty($list)) {
                return $this->json_error("存储数据库失败");
            }
        }
        return $this->json_success("上传成功");
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
        $data = DB::table('photo')->where("phid",$id)->select("phid","phtitle","phalid","phphoto","phstatus")->first();
        $album = DB::table("album")->where("alstatus",1)->select("alid","alname")->get();
        return view("admin.photo.edit",[
            'data' => $data,
            'album' => $album,
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
        $config = Config::get('config.qiniu');
        $qiniu = new Qiniu;
        
        if ($request->hasFile('phphoto')) {
            $delimg = DB::table("photo")->where("phid",$id)->select("phphoto")->first();

            list($ret,$err) = $qiniu->imge_upload($config['imge_policy']['cover'],$request->file('phphoto'));
            if ($err !== null) {
                return $this->json_success('图片上传失败');
            }else{
                if ($delimg) {
                    $error = $qiniu->delete($config['imge_bucket'],$delimg->phphoto);
                }
            }
        }

        $photo = $request->all();
        unset($photo['_method']);
        if (strlen($photo['phtitle']) >= 254) {
            if (!empty($ret['key']))
            $qiniu->delete($config['imge_bucket'],$delimg->phphoto);
            return $this->json_error("标题过长","",301);
        }
        if (!empty($photo['phstatus'])) {
            $photo['phstatus'] = 1;
        }else{
            $photo['phstatus'] = 2;
        }

        if (!empty($ret['key'])) {
            $photo['phphoto'] = $ret['key'];
        }
        $photo['phupdatetime'] = time();
        $list = DB::table("photo")->where("phid",$id)->update($photo);
        if ($list) {
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
        $delimg = DB::table("photo")->where("phid",$id)->select("phphoto")->first();
        $list = DB::table("photo")->where("phid",$id)->delete();
        if (empty($list)) {
            return $this->json_error("删除失败");
        }
        $config = Config::get('config.qiniu');
        $qiniu = new Qiniu;
        $error = $qiniu->delete($config['imge_bucket'],$delimg->phphoto);
        return $this->json_success("删除成功");
    }

    public function status(Request $request)
    {
    	$data = $request->all();
    	$status['phstatus'] = 2;
    	if (!empty($data['status']))
    		$status['phstatus'] = 1;
    	
    	$list = DB::table("photo")->where('phid',$data['id'])->update($status);
    	if ($list) {
    		return $this->json_success("修改成功");
    	}else{
    		return $this->json_error("修改失败");
    	}
    }
}
