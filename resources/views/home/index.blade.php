@extends("home.header")

@section("style")
<link href="{{URL::asset('blog/css/home.css')}}" rel="stylesheet" />
<style>
    .article > .article-left > div{
        height:120px;
    }

    @media (max-width: 949px){
        .article > .article-left > div{
            height:110px;
        }
    }
    
    @media (max-width: 767px) {
        .article > .article-left > div{
            height:90px;
        }
    }

    @media (max-width: 479px) {
        .article > .article-left > div{
            height:60px;
        }
    }
</style>

@endsection

@section("content")
    <!-- 主体（一般只改变这里的内容） -->
    <div class="blog-body">
        <!-- canvas -->
        <canvas id="canvas-banner" style="background: #393D49;"></canvas>
        <!--为了及时效果需要立即设置canvas宽高，否则就在home.js中设置-->
        <script type="text/javascript">
            var canvas = document.getElementById('canvas-banner');
            canvas.width = window.document.body.clientWidth - 10;//减去滚动条的宽度
            if (screen.width >= 992) {
                canvas.height = window.innerHeight * 1 / 3;
            } else {
                canvas.height = window.innerHeight * 2 / 7;
            }
        </script>
        <!-- 这个一般才是真正的主体内容 -->
        <div class="blog-container">
            <div class="blog-main">
                <!-- 网站公告提示 -->
                @if($notice)
                    <div class="home-tips shadow">
                        <i style="float:left;line-height:17px;" class="fa fa-volume-up"></i>
                        <div class="home-tips-container">
                            @foreach($notice as $not)        
                                <span style="color: #009688">{!!$not->notitle!!}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                <!--左边文章列表-->
                <div class="blog-main-left" id="send">
                    @foreach($list as $item)
                        <div class="article shadow">
                            <div class="article-left">
                                @if($item->img)    
                                    <img src="http://qiniu.zhuxv.com/{{$item->img}}" alt="{{$item->artitle}}" />
                                @else
                                    <div></div>
                                @endif
                            </div>
                            <div class="article-right">
                                <div class="article-title">
                                    <a href="{{action('Home\DetailController@index',['id'=>$item->arid])}}">{{$item->artitle}}</a>
                                </div>
                                <div class="article-abstract">{{$item->arftitle}}</div>
                            </div>
                            <div class="clear"></div>
                            <div class="article-footer">
                                <span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{date("Y-m-d",$item->arcreatetime)}}</span>
                                <span class="article-author"><i class="fa fa-user"></i>&nbsp;&nbsp;@if($item->arauthod) {{$item->arauthod}} @else 遇见博客 @endif</span>
                                <span><i class="fa fa-tag"></i>&nbsp;&nbsp;<a href="#">{{$item->laname}}</a></span>
                                <span class="article-viewinfo"><i class="fa fa-eye"></i>&nbsp;{{$item->arbrowse}}</span>
                                <span class="article-viewinfo"><i class="fa fa-commenting"></i>&nbsp;{{$item->arcomcount}}</span>
                            </div>
                        </div>
                    @endforeach
                    @if(count($list) >= 5)
                        <div class="article shadow" style="text-align:center;cursor:pointer;" id="jiazai">
                            <p id="pagesend">加载更多</p>
                        </div>
                    @endif
                </div>

                <!--右边小栏目-->
                <div class="blog-main-right">
                    <div class="blogerinfo shadow">
                        <div class="blogerinfo-figure">
                            <img src="{{URL::asset('blog/images/Absolutely.jpg')}}" alt="Absolutely" />
                        </div>
                        <p class="blogerinfo-nickname">遇见</p>
                        <p class="blogerinfo-introduce">PHP开发攻城狮</p>
                        <p class="blogerinfo-location"><i class="fa fa-location-arrow"></i>&nbsp;安徽 - 淮北</p>
                        <hr />
                        <div class="blogerinfo-contact">
                            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1071786204&site=qq&menu=yes"><i class="fa fa-qq fa-2x"></i></a>
                            <a target="_blank" title="给我写信" href="javascript:layer.msg('启动邮我窗口')"><i class="fa fa-envelope fa-2x"></i></a>
                            <a target="_blank" title="新浪微博" href="https://weibo.com/6109486745/profile?topnav=1&wvr=6&is_all=1')"><i class="fa fa-weibo fa-2x"></i></a>
                            <a target="_blank" title="码云" href="javascript:layer.msg('转到你的github主页')"><i class="fa fa-git fa-2x"></i></a>
                        </div>
                    </div>
                    <div></div><!--占位-->
                    <div class="blog-module shadow">
                        <div class="blog-module-title">热文排行</div>
                        <ul class="fa-ul blog-module-ul">
                            @foreach($hot as $h)
                                <li><i class="fa-li fa fa-hand-o-right"></i><a href="{{action('Home\DetailController@index',['id'=>$h->arid])}}">{{$h->artitle}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="blog-module shadow">
                        <div class="blog-module-title">最近分享</div>
                        <ul class="fa-ul blog-module-ul">
                            <li><i class="fa-li fa fa-hand-o-right"></i><a href="#" target="_blank">Canvas</a></li>
                            <li><i class="fa-li fa fa-hand-o-right"></i><a href="#" target="_blank">pagesize.js</a></li>
                            <li><i class="fa-li fa fa-hand-o-right"></i><a href="#" target="_blank">时光轴</a></li>
                            <li><i class="fa-li fa fa-hand-o-right"></i><a href="#" target="_blank">图片轮播</a></li>
                        </ul>
                    </div>
                    <div class="blog-module shadow">
                        <div class="blog-module-title">一路走来</div>
                        <dl class="footprint">
                            @foreach($timeline as $line)
                                <dt>{{$line->titime}}</dt>
                                <dd>{{$line->tidesc}}</dd>
                            @endforeach
                        </dl>
                    </div>
                    @if(!empty($links))
                        <div class="blog-module shadow">
                            <div class="blog-module-title">友情链接</div>
                            <ul class="blogroll">
                                @foreach($links as $li)
                                    <li><a target="_blank" href="{{$li->lilink}}" title="{{$li->liname}}">{{$li->liname}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <script src="{{URL::asset('blog/js/home.js')}}"></script>
    <script src="{{URL::asset('blog/js/index.js')}}"></script>
@endsection
