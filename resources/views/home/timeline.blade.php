@extends("home.header")

@section("style")
    <link href="{{URL::asset('blog/css/timeline.css')}}" rel="stylesheet" />
@endsection

@section("content")
    <!-- 主体（一般只改变这里的内容） -->
    <div class="blog-body">
        <div class="blog-container">
            <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
                <a href="home.html" title="网站首页">网站首页</a>
                <a href="timeline.html" title="点点滴滴">点点滴滴</a>
                <a><cite>时光轴</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="child-nav shadow">
                    <span class="child-nav-btn child-nav-btn-this">时光轴</span>
                    <!-- <span class="child-nav-btn">笔记墙</span> -->
                </div>
                <div class="timeline-box shadow">
                    <div class="timeline-main">
                        <h1><i class="fa fa-clock-o"></i>时光轴<span> —— 记录生活点点滴滴</span></h1>
                        <div class="timeline-line"></div>
                        @foreach($timeline as $key => $val)
                            <div class="timeline-year">
                                <h2><a class="yearToggle" href="javascript:;">{{$key}}</a><i class="fa fa-caret-down fa-fw"></i></h2>
                                @foreach($val as $k => $v)
                                    <div class="timeline-month">
                                        <h3 class=" animated fadeInLeft"><a class="monthToggle" href="javascript:;">{{$k}}</a><i class="fa fa-caret-down fa-fw"></i></h3>
                                        <ul>
                                            @foreach($v as $va)
                                                <li class=" ">
                                                    <div class="h4  animated fadeInLeft">
                                                        <p class="date">{{$va->april}} {{$va->time}}</p>
                                                    </div>
                                                    <p class="dot-circle animated "><i class="fa fa-dot-circle-o"></i></p>
                                                    <div class="content animated fadeInRight">{{$va->tidesc}}</div>
                                                    <div class="clear"></div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <h1 style="padding-top:4px;padding-bottom:2px;margin-top:40px;"><i class="fa fa-hourglass-end"></i>THE END</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 本页脚本 -->
    <script type="text/javascript">
        layui.use('jquery', function () {
            var $ = layui.jquery;

            $(function () {
                $('.monthToggle').click(function () {
                    $(this).parent('h3').siblings('ul').slideToggle('slow');
                    $(this).siblings('i').toggleClass('fa-caret-down fa-caret-right');
                });
                $('.yearToggle').click(function () {
                    $(this).parent('h2').siblings('.timeline-month').slideToggle('slow');
                    $(this).siblings('i').toggleClass('fa-caret-down fa-caret-right');
                });
            });
        });
    </script>
@endsection