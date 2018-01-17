<!--
    
 @Name：遇见博客
 @Author：ZhuXv
 @Site：http://blog.zhuxv.com

 -->

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; Charset=gb2312">
    <meta http-equiv="Content-Language" content="zh-CN">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>{{$title}}</title>
    <!-- <link rel="shortcut icon" href="{{URL::asset('blog/images/Logo_40.png')}}" type="image/x-icon"> -->
    <!--Layui-->
    <link href="{{URL::asset('blog/plug/layui/css/layui.css')}}" rel="stylesheet" />
    <!--font-awesome-->
    <link href="{{URL::asset('blog/plug/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
    <!--全局样式表-->
    <link href="{{URL::asset('blog/css/global.css')}}" rel="stylesheet" />
    <!-- 本页样式表 -->
    <script src="{{URL::asset('blog/plug/layui/layui.js')}}"></script>
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    
    @section("style")

    @show
</head>
<body>
    <!-- 导航 -->
    <nav class="blog-nav layui-header">
        <div class="blog-container">
            <!-- QQ互联登陆 -->
            <div class="site-demo-button" id="layerDemo" style="margin-bottom: 0;">
                @if(empty($_SESSION['qqlogin']))
                    <a data-method="offset" data-type="auto" class="layui-btn layui-btn-normal" style="float:left;background-color:#393D49;line-height: 64px;position: absolute;z-index: 10;">
                        <i class="fa fa-qq"></i>
                    </a>
                @else
                    <li class="layui-nav-item" lay-unselect="">
                        <a href="javascript:;"><img src="{{$_SESSION['qqlogin']['userimg']['qifigureurl_qq_1']}}" class="layui-nav-img" style="margin-top:15px;position: absolute;"></a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;">修改信息</a></dd>
                            <dd><a href="javascript:;">安全管理</a></dd>
                            <dd><a href="javascript:;">退了</a></dd>
                        </dl>
                    </li>
                @endif
            </div>
            <!-- <a href="javascript:;" class="blog-user layui-hide">
                <img src="{{URL::asset('blog/images/Absolutely.jpg')}}" alt="Absolutely" title="Absolutely" />
            </a> -->
            
            <!-- <ins class="adsbygoogle" style="display:inline-block;width:970px;height:90px" data-ad-client="ca-pub-6111334333458862" data-ad-slot="3820120620"></ins> -->
            <!-- 不落阁 -->
            <a class="blog-logo" href="{{action('Home\IndexController@index')}}">遇见</a>
            <!-- 导航菜单 -->
            <ul class="layui-nav" lay-filter="nav">
                <li class="layui-nav-item @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Home\IndexController') layui-this @endif ">
                    <a href="{{action('Home\IndexController@index')}}"><i class="fa fa-home fa-fw"></i>&nbsp;网站首页</a>
                </li>
                <li class="layui-nav-item @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Home\ArticleController') layui-this @endif">
                    <a href="{{action('Home\ArticleController@index')}}"><i class="fa fa-file-text fa-fw"></i>&nbsp;文章专栏</a>
                </li>
                <li class="layui-nav-item @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Home\ResourceController') layui-this @endif">
                    <a href="{{action('Home\ResourceController@index')}}"><i class="fa fa-tags fa-fw"></i>&nbsp;瀑布流</a>
                </li>
                <li class="layui-nav-item @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Home\TimelineController') layui-this @endif">
                    <a href="{{action('Home\TimelineController@index')}}"><i class="fa fa-hourglass-half fa-fw"></i>&nbsp;点点滴滴</a>
                </li>
                <li class="layui-nav-item @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Home\AboutController') layui-this @endif">
                    <a href="{{action('Home\AboutController@index')}}"><i class="fa fa-info fa-fw"></i>&nbsp;关于本站</a>
                </li>
            </ul>
            <!-- 手机和平板的导航开关 -->
            <a class="blog-navicon" href="javascript:;">
                <i class="fa fa-navicon"></i>
            </a>
        </div>
    </nav>

    @yield('content')

    <!-- 底部 -->
    <footer class="blog-footer">
        <p><span>Copyright</span><span>&copy;</span><span>2017</span><a href="http://blog.zhuxv.com">遇见</a><span>Design By LY</span></p>
        <p><a href="http://www.miibeian.gov.cn/" target="_blank">皖ICP备17020314号-1</a></p>
    </footer>
    <!--侧边导航-->
    <ul class="layui-nav layui-nav-tree layui-nav-side blog-nav-left layui-hide" lay-filter="nav">
        <li class="layui-nav-item layui-this">
            <a href="http://blog.zhuxv.com"><i class="fa fa-home fa-fw"></i>&nbsp;网站首页</a>
        </li>
        <li class="layui-nav-item">
            <a href="{{action('Home\ArticleController@index')}}"><i class="fa fa-file-text fa-fw"></i>&nbsp;文章专栏</a>
        </li>
        <li class="layui-nav-item">
            <a href="{{action('Home\ResourceController@index')}}"><i class="fa fa-tags fa-fw"></i>&nbsp;瀑布流</a>
        </li>
        <li class="layui-nav-item">
            <a href="{{action('Home\TimelineController@index')}}"><i class="fa fa-road fa-fw"></i>&nbsp;点点滴滴</a>
        </li>
        <li class="layui-nav-item">
            <a href="{{action('Home\AboutController@index')}}"><i class="fa fa-info fa-fw"></i>&nbsp;关于本站</a>
        </li>
    </ul>
    <!--分享窗体-->
    <div class="blog-share layui-hide">
        <div class="blog-share-body">
            <div style="width: 200px;height:100%;">
                <div class="bdsharebuttonbox">
                    <a class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                    <a class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                    <a class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                    <a class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a>
                </div>
            </div>
        </div>
    </div>
    <!--遮罩-->
    
    <div class="blog-mask animated layui-hide"></div>
    
    <script>
        @if(count($errors)>0)
            @foreach($errors->all() as $key => $error)
                layui.use('layer',function(){
                    layer.msg('{{$error}}', { icon: 5 });
                });
            @endforeach
        @endif
    </script>
    <!-- <script src="{{URL::asset('blog/js/log.js')}}"></script> -->
    <script src="{{URL::asset('blog/js/global.js')}}"></script>
        
    <!-- <script src="{{URL::asset('blog/js/baidu.js')}}"></script> -->
</body>
</html>