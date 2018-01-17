<!--

 @Name：不落阁后台模板源码
 @Author：Absolutely
 @Site：http://www.lyblogs.cn

 -->


<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>遇见*博客后台管理系统</title>
    <link rel="shortcut icon" href="{{URL::asset('favicon.ico')}}" type="image/x-icon">
    <!-- layui.css -->
    <link href="{{URL::asset('admins/plugin/layui/css/layui.css')}}" rel="stylesheet" />
    <!-- font-awesome.css -->
    <link href="{{URL::asset('admins/plugin/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
    <!-- animate.css -->
    <link href="{{URL::asset('admins/css/animate.min.css')}}" rel="stylesheet" />
    <!-- 本页样式 -->
    <link href="{{URL::asset('admins/css/main.css')}}" rel="stylesheet" />
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('admins/plugin/layui/layui.js')}}"></script>
    @section("style")

    @show
</head>
<body>
    <div class="layui-layout layui-layout-admin">
        <!--顶部-->
        <div class="layui-header">
            <div class="ht-console">
                <div class="ht-user">
                    <img src="{{URL::asset('admins/images/Logo_40.png')}}" />
                    <a class="ht-user-name">超级管理员</a>
                </div>
            </div>
            <span class="sys-title">遇见*博客后台管理系统</span>
            <ul class="ht-nav">
                <li class="ht-nav-item">
                    <a target="_blank" href="http://blog.zhuxv.com">前台入口</a>
                </li>
                <li class="ht-nav-item">
                    <a href="javascript:;" id="individuation"><i class="fa fa-tasks fa-fw" style="padding-right:5px;"></i>个性化</a>
                </li>
                <li class="ht-nav-item">
                    <a href="javascript:;" id="logout"><i class="fa fa-power-off fa-fw"></i>注销</a>
                </li>
                <script>
                    $(function(){
                        $("#logout").click(function(){
                            layer.msg('已退出，正在跳转......', { icon: 6 });
                            setTimeout(function () {
                                $.get("/admin/logout", function(){
                                    location.href = "/admin/login";
                                });
                            }, 1000);
                            return false;
                        })
                    })
                </script>
            </ul>
        </div>
        <!--侧边导航-->
        <div class="layui-side">
            <div class="layui-side-scroll">
                <ul class="layui-nav layui-nav-tree" lay-filter="leftnav">
                    <li class="layui-nav-item @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\IndexController') layui-this @endif">
                        <a href="{{action('Admin\IndexController@index')}}"><i class="fa fa-home"></i>首页</a>
                    </li>
                    <li class="layui-nav-item @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\ArticleController') layui-nav-itemed @endif">
                        <a href="javascript:;"><i class="fa fa-file-text"></i>文章相关</a>
                        <dl class="layui-nav-child">
                            <dd @if(explode('@',Route::current()->getActionName())[1] == 'index') class="layui-this" @endif><a href="{{action('Admin\ArticleController@index')}}">文章管理</a></dd>
                            <dd @if(explode('@',Route::current()->getActionName())[1] == 'create') class="layui-this" @endif><a href="{{action('Admin\ArticleController@create')}}" data-url="datalist.html" data-id="2">文章添加</a></dd>
                            <dd @if(explode('@',Route::current()->getActionName())[1] == 'listrecycle') class="layui-this" @endif><a href="{{action('Admin\ArticleController@listrecycle')}}" data-url="datalist.html" data-id="3">文章回收站</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\CategoryController' || explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\LabelController') layui-nav-itemed @endif">
                        <a href="javascript:;"><i class="fa fa-file-text"></i>分类标签</a>
                        <dl class="layui-nav-child">
                            <dd @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\CategoryController') class="layui-this" @endif><a href="{{action('Admin\CategoryController@index')}}">分类管理</a></dd>
                            <dd @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\LabelController') class="layui-this" @endif><a href="{{action('Admin\LabelController@index')}}" data-id="5">标签管理</a></dd>
                            <dd @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\NavigationController') class="layui-this" @endif><a href="javascript:;" data-url="{{action('Admin\ArticleController@index')}}" data-id="6">导航管理</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\QquserController') layui-nav-itemed @endif">
                        <a href="javascript:;"><i class="fa fa-user"></i>用户管理</a>
                        <dl class="layui-nav-child">
                            <dd @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\QquserController') class="layui-this" @endif><a href="{{action('Admin\QquserController@index')}}">全部用户</a></dd>
                            <dd><a href="javascript:;">黑名单管理</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\AlbumController' || explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\PhotoController') layui-nav-itemed @endif">
                        <a href="javascript:;"><i class="fa fa-photo"></i>相册管理</a>
                        <dl class="layui-nav-child">
                            <dd @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\AlbumController') class="layui-this" @endif><a href="{{action('Admin\AlbumController@index')}}">相册分类</a></dd>
                            <dd @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\PhotoController') class="layui-this" @endif><a href="{{action('Admin\PhotoController@index')}}">照片管理</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\ExtendController' || explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\NoticeController' || explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\TimelineController') layui-nav-itemed @endif">
                        <a href="javascript:;"><i class="fa fa-wrench"></i>扩展管理</a>
                        <dl class="layui-nav-child">
                            <dd @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\ExtendController') class="layui-this" @endif><a href="{{action('Admin\ExtendController@index')}}">友情链接</a></dd>
                            <dd><a href="javascript:;">博主信息</a></dd>
                            <dd><a href="javascript:;">网站信息</a></dd>
                            <dd @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\NoticeController') class="layui-this" @endif><a href="{{action('Admin\NoticeController@index')}}">网站公告</a></dd>
                            <dd @if(explode('@',Route::current()->getActionName())[0] == 'App\Http\Controllers\Admin\TimelineController') class="layui-this" @endif><a href="{{action('Admin\TimelineController@index')}}">更新日志</a></dd>
                            <dd><a href="javascript:;" data-url="datalist.html" data-id="7">留言管理</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="fa fa-cog"></i>系统配置</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;">SEO配置</a></dd>
                            <dd><a href="javascript:;">QQ互联</a></dd>
                            <dd><a href="javascript:;">数据库配置</a></dd>
                            <dd><a href="javascript:;">站点地图</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="fa fa-info-circle"></i>其他信息</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;">操作日志</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>
        <!--收起导航-->
        <div class="layui-side-hide layui-bg-cyan">
            <i class="fa fa-long-arrow-left fa-fw"></i>收起导航
        </div>
        <!--主体内容-->
        <div class="layui-body">
            <div style="margin:0;position:absolute;top:4px;bottom:0px;width:100%;" class="layui-tab layui-tab-brief" lay-filter="tab" lay-allowclose="true">
                <ul class="layui-tab-title">
                    <li lay-id="0" @if(explode('@',Route::current()->getActionName())[1] == 'index') class="layui-this" @endif @if(explode('@',Route::current()->getActionName())[1] == 'listrecycle') class="layui-this" @endif>@section("stitle")首页@show</li>
                    @if(explode('@',Route::current()->getActionName())[1] != 'index')
                        @if(explode('@',Route::current()->getActionName())[1] != 'listrecycle')
                            <li lay-id="1" class="layui-this">
                                @section("setitle") @show
                            </li>
                        @endif
                    @endif
                </ul>
                @yield('content')
                
            </div>
        </div>
        <!--底部信息-->
        <div class="layui-footer">
            <p style="line-height:44px;text-align:center;">遇见*博客后台管理系统 - Design By LY</p>
        </div>
        <!--快捷菜单-->
        <div class="short-menu" style="display:none">
            <fieldset class="layui-elem-field layui-field-title">
                <legend style="color:#fff;padding-top:10px;padding-bottom:10px;">快捷菜单</legend>
                <div class="layui-field-box">
                    <div style="width:832px;margin:0 auto;">
                        <div class="windows-tile windows-two">
                            <i class="fa fa-file-text"></i>
                            <span data-url="datalist.html" data-id="1">文章管理</span>
                        </div>
                        <div class="windows-tile windows-one">
                            <i class="fa fa-volume-up"></i>
                            <span data-url="datalist.html" data-id="2">网站公告</span>
                        </div>
                        <div class="windows-tile windows-one">
                            <i class="fa fa-comments-o"></i>
                            <span data-url="datalist.html" data-id="3">留言管理</span>
                        </div>
                        <div class="windows-tile windows-two">
                            <i class="fa fa-handshake-o"></i>
                            <span data-url="datalist.html" data-id="4">友情链接</span>
                        </div>
                        <div class="windows-tile windows-one">
                            <i class="fa fa-arrow-circle-right"></i>
                            <span data-url="datalist.html" data-id="5">更新日志</span>
                        </div>
                        <div class="windows-tile windows-one">
                            <i class="fa fa-wrench"></i>
                            <span data-url="datalist.html" data-id="6">操作日志</span>
                        </div>
                        <div class="windows-tile windows-one">
                            <i class="fa fa-tags"></i>
                            <span data-url="datalist.html" data-id="7">资源管理</span>
                        </div>
                        <div class="windows-tile windows-one">
                            <i class="fa fa-pencil-square-o"></i>
                            <span data-url="datalist.html" data-id="8">笔记管理</span>
                        </div>
                        <div class="windows-tile windows-two">
                            <i class="fa fa-hourglass-half"></i>
                            <span data-url="datalist.html" data-id="9">时光轴管理</span>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                </div>
            </fieldset>

        </div>
        <!--个性化设置-->
        <div class="individuation animated flipOutY layui-hide">
            <ul>
                <li><i class="fa fa-cog" style="padding-right:5px"></i>个性化</li>
            </ul>
            <div class="explain">
                <small>从这里进行系统设置和主题预览</small>
            </div>
            <div class="setting-title">设置</div>
            <div class="setting-item layui-form">
                <span>侧边导航</span>
                <input type="checkbox" lay-skin="switch" lay-filter="sidenav" lay-text="ON|OFF" checked>
            </div>
            <div class="setting-item layui-form">
                <span>管家提醒</span>
                <input type="checkbox" lay-skin="switch" lay-filter="steward" lay-text="ON|OFF" checked>
            </div>
            <div class="setting-title">主题</div>
            <div class="setting-item skin skin-default" data-skin="skin-default">
                <span>低调优雅</span>
            </div>
            <div class="setting-item skin skin-deepblue" data-skin="skin-deepblue">
                <span>蓝色梦幻</span>
            </div>
            <div class="setting-item skin skin-pink" data-skin="skin-pink">
                <span>姹紫嫣红</span>
            </div>
            <div class="setting-item skin skin-green" data-skin="skin-green">
                <span>一碧千里</span>
            </div>
        </div>
    </div>
    <!-- layui.js -->
    
    
    <!-- layui规范化用法 -->
    <script type="text/javascript">
        layui.config({
            base: '../../../admins/js/'
        }).use('main');
    </script>
</body>
</html>