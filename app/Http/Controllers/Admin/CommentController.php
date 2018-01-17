<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Model\Qiniu;

class CommentController extends Controller
{
    public static $redis;

    public function __construct()
    {
        self::$redis = new \Redis();
        self::$redis->connect("127.0.0.1",6379);
    }

	public function index()
	{
		
	}

    /*
        状态码
        number       message
        200          成功
        300          数据库操作失败
        301          不允许操作
        305          参数错误
        306          操作无效    
        307          上传失败
        406          找不到文件
    */

	public function json_success($message,$da='',$code='200')
    {
        $data = [
            'code'=>$code,                                  //
            'data'=>$da,                                    //数据
            'resultCode'=>true,                            //返回码
            'message'=>$message                             //提示
        ];
        return response()->json($data);
    }

    public function json_error($message,$da='',$code='300')
    {
        $data = [
            'code'=>$code,                                  //
            'data'=>$da,                                    //数据
            'resultCode'=>true,                            //返回码
            'message'=>$message                             //提示
        ];
        return response()->json($data);
    }

    protected function getSessionData()
    {
        $data = session("admin_info");
        return $data;
    }

    protected function curl($url)
    {
         $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        if(curl_errno($ch))
        { echo 'CURL ERROR Code: '.curl_errno($ch).', reason: '.curl_error($ch);}
        curl_close($ch);
        $info = json_decode($output, true);
        return $info;
    }

    public function qiniuUploads(Request $request)
    {
        $file = $request->file("phphoto");
        if (empty($file)) {
            return 406;
        }
        $filePath = [];
        foreach ($file as $key => $val) {
            if (!$val->isValid()) {
                return 307;
            }
            if (!empty($val)) { //此处防止没有多文件上传的情况
                $allowed_extensions = ['png', 'jpg', 'jpeg', 'gif'];
                if ($val->getClientOriginalExtension() && !in_array($val->getClientOriginalExtension(),$allowed_extensions)) {
                    return $this->json_error(301);
                }
                $config = Config::get('config.qiniu');
                $qiniu = new Qiniu;

                list($ret,$err) = $qiniu->imge_upload($config['imge_policy']['cover'],$val);
                if ($err !== null) {
                    return 300;
                }
            }
            $filePath[] = $ret['key'];
        }
        return $filePath;
    }
}