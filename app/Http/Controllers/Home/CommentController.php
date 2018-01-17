<?php
namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    protected $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect("127.0.0.1",6379);
    }

    /*
        状态码
        number       message
        200          成功
        300          数据库操作失败
        301          不允许操作
        305          参数错误
        306          操作无效    
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

    private function getJson($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        // curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }

        public function curl($url,$type,$data='')
    {
        $c = curl_init(); 
        curl_setopt($c, CURLOPT_URL, $url); //请求地址
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); //不输出数据
        //curl_setopt($c, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:200.98.182.163', 'CLIENT-IP:203.98.182.163')); //构造IP 
        //curl_setopt($ch, CURLOPT_REFERER, "http://www.baidu.com/ "); //构造来路 
        //curl_setopt($c, CURLOPT_HEADER, 0);//如果你想把一个头包含在输出中，设置这个选项为一个非零值。
        curl_setopt($c, CURLOPT_POST, $type);//如果你想PHP去做一个正规的HTTP POST，设置这个选项为一个非零值。这个POST是普通的 application/x-www-from-urlencoded 类型，多数被HTML表单使用。
        if($type == 1){
            curl_setopt($c, CURLOPT_POSTFIELDS, $data);//传递一个作为HTTP “POST”操作的所有数据的字符串。['name'=>'张三']也行
        }
        $out = curl_exec($c); //执行 cURL 会话
        curl_close($c); //关闭 cURL 会话
        
        return $out;
    }

    public function send_post($url, $post_data) {
 
        $postdata = http_build_query($post_data);
        $options = array(
                'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
     
        return $result;
    }

    protected function getLoginId() //获取当前用户id
    {
        
        $qqloginid = empty($_SESSION['qqlogin']['userdata']['qqid'])?false:$_SESSION['qqlogin']['userdata']['qqid'];
        if ($qqloginid) {
            return $qqloginid;
        }else{
            return false;
        }
    }

    protected function getCategory() //获取右侧分类导航栏
    {
        $list = $this->redis->get("category");
        if (!$list) {
            $list = $category = json_encode(DB::table("category")->where("castatus",1)->select("caid","caname")->get());
            $this->redis->setex("category",86400,$category);
        }
        return json_decode($list);
    }

    protected function getRemmend() //获取作者推荐
    {
        $list = $this->redis->get("remmend");
        if (!$list) {
            $list = $remmend = json_encode(DB::table("article")->where(['arstatus'=>1,'arremmend'=>2])->select("arid","artitle")->orderBy("arid","desc")->get());
            $this->redis->setex("remmend",86400,$remmend);
        }

        return json_decode($list);
    }

    protected function getCasualLook($count) //获取随便看看
    {
        $list = $this->redis->get("look");
        if (!$list) {
            $list = $look = json_encode(DB::table("article")->where("arstatus",1)->orderBy(\DB::raw('RAND()'))->take($count)->select("arid","artitle")->get());
            $this->redis->setex("look",3600,$list);
        }
        
        return json_decode($list);
    }

    protected function getLinkData($isImg=false) //获取友情链接
    {
        if ($isImg) {
            $list = $this->redis->get("linkimg");
            if (!$list) {
                $list = $links = json_encode(DB::table("link")->where("listatus",1)->select("liname","lilogo","lilink")->get());
                $this->redis->set("linkimg",$links);
            }
        }else{
            $list = $this->redis->get("linknoimg");
            if (!$list) {
                $list = $links = json_encode(DB::table("link")->where("listatus",1)->select("liname","lilink")->get());
                $this->redis->set("linknoimg",$links);
            }
        }
        return json_decode($list);
    }

    protected function getTimeLine($list = 0)
    {
        if (!empty($list)) {
            $timeline = json_decode($this->redis->get("timeline"));
            if (empty($timeline)) {
                $timeline = $arr = DB::table("timeline")->orderBy("titime","desc")->where("tistatus",1)->limit($list)->select("titime","tidesc")->get();
                foreach ($timeline as $key => $val) {
                    $timeline[$key]->titime = date("Y年m月d日",$timeline[$key]->titime);
                }
                $this->redis->set("timeline",json_encode($arr));
            }
        }else{
            $timeline = json_decode($this->redis->get("timelines"));
            if (empty($timeline)) {
                $arr = DB::table("timeline")->orderBy("titime","desc")->where("tistatus",1)->select("titime","tidesc")->get();
                foreach ($arr as $key => $val) {
                    $arr[$key]->year = date("Y年",$arr[$key]->titime);
                    $arr[$key]->mouth = date("m月",$arr[$key]->titime);
                    $arr[$key]->april = date("m月d日",$arr[$key]->titime);
                    $arr[$key]->time = date("H:i",$arr[$key]->titime);
                }
                foreach ((array)$arr as $key => $value) {
                    $arr = $value;
                }
                // return $arr;
                $abc = [$arr[0]->year=>[$arr[0]->mouth=>[$arr[0]]]];
                foreach ((array)$arr as $key => $val) {
                    // return $val['mouth'];
                    foreach ($abc as $k => $v) {
                        if (in_array($k,(array)$val)) {
                            foreach ($v as $ke => $va) {
                                if (in_array($ke,(array)$val)) {
                                    $abc[$k][$ke][$key] = $val;
                                }else{
                                    $abc[$k][$val->mouth][$key] = $val;
                                }
                            }
                        }else{
                            foreach ($v as $keys => $vals) {
                                $abc[$val->year][$val->mouth][$key] = $val;
                            }
                        }
                    }
                }
                $this->redis->set("timelines",json_encode($abc));
                $timeline = $abc;
            }
            
        }

        return $timeline;
    }
}