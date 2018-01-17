@extends("home.header")

@section("style")
    <link href="{{URL::asset('blog/css/about.css')}}" rel="stylesheet" />
    
@endsection

@section("content")
    <!-- 主体（一般只改变这里的内容） -->
    <div class="blog-body">
        <div class="blog-container">
            <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
                <a href="http://blog.zhuxv.com" title="网站首页">网站首页</a>
                <a><cite>关于本站</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="layui-tab layui-tab-brief shadow" lay-filter="tabAbout">
                    <ul class="layui-tab-title">
                        <li lay-id="1">关于博客</li>
                        <li lay-id="2">关于作者</li>
                        <li lay-id="3" id="frinedlink">友情链接</li>
                        <li lay-id="4" class="layui-this">留言墙</li>
                    </ul>
                    <div class="layui-tab-content">
                        <div class="layui-tab-item">
                            <div class="aboutinfo">
                                <div class="aboutinfo-figure">
                                    <img src="{{URL::asset('blog/images/Logo_100.png')}}" alt="遇见" />
                                </div>
                                <p class="aboutinfo-nickname">遇见</p>
                                <p class="aboutinfo-introduce">一个PHP程序猿的个人博客，记录博主学习和成长之路，分享PHP方面技术和源码</p>
                                <p class="aboutinfo-location"><i class="fa fa-link"></i>&nbsp;&nbsp;<a target="_blank" href="http://blog.zhuxv.com">blog.zhuxv.com</a></p>
                                <hr />
                                <div class="aboutinfo-contact">
                                    <a target="_blank" title="网站首页" href="http://blog.zhuxv.com"><i class="fa fa-home fa-2x" style="font-size:2.5em;position:relative;top:3px"></i></a>
                                    <a target="_blank" title="文章专栏" href="{{action('Home\ArticleController@index')}}"><i class="fa fa-file-text fa-2x"></i></a>
                                    <a target="_blank" title="资源分享" href="{{action('Home\ResourceController@index')}}"><i class="fa fa-tags fa-2x"></i></a>
                                    <a target="_blank" title="点点滴滴" href="{{action('Home\TimelineController@index')}}"><i class="fa fa-hourglass-half fa-2x"></i></a>
                                </div>

                                <fieldset class="layui-elem-field layui-field-title">
                                    <legend>简介</legend>
                                    <div class="layui-field-box aboutinfo-abstract">
                                        <p style="text-align:center;">遇见是基于PHP.LARAVEL开发的个人博客网站，诞生于2018年01月01日，暂且称为遇见1.0。</p>
                                        <h1>第一个版本</h1>
                                        <p>诞生的版本，采用PHP MVC LARAVEL5.5作为后台框架，前端摘自 <a href="http://www.lyblogs.cn/">不落阁</a>，用了Bootstrap的栅格系统来布局！起初并没有注意美工，只打算完成基本的功能，故视觉体验是比较差的。</p>
                                        <h1 style="text-align:center;">The End</h1>
                                    </div>
                                </fieldset>
                            </div>
                        </div><!--关于网站End-->
                        <div class="layui-tab-item">
                            <div class="aboutinfo">
                                <div class="aboutinfo-figure">
                                    <img src="{{URL::asset('blog/images/Absolutely.jpg')}}" alt="Absolutely" />
                                </div>
                                <p class="aboutinfo-nickname">ZHUXV</p>
                                <p class="aboutinfo-introduce">一枚90后程序员，PHP开发攻城狮，主攻PHP+MYSQL，略懂Web前端</p>
                                <p class="aboutinfo-location"><i class="fa fa-location-arrow"></i>&nbsp;安徽 - 淮北</p>
                                <hr />
                                <div class="aboutinfo-contact">
                                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1071786204&site=qq&menu=yes"><i class="fa fa-qq fa-2x"></i></a>
                                    <a target="_blank" title="给我写信" href="javascript:layer.msg('启动邮我窗口')"><i class="fa fa-envelope fa-2x"></i></a>
                                    <a target="_blank" title="新浪微博" href="https://weibo.com/6109486745/profile?topnav=1&wvr=6&is_all=1')"><i class="fa fa-weibo fa-2x"></i></a>
                                    <a target="_blank" title="码云" href="javascript:layer.msg('转到你的github主页')"><i class="fa fa-git fa-2x"></i></a>
                                </div>
                                <fieldset class="layui-elem-field layui-field-title">
                                    <legend>简介</legend>
                                    <div class="layui-field-box aboutinfo-abstract abstract-bloger">
                                        <p style="text-align:center;">ZHUXV，诞生于1996年4月13日，目前是一个码农，从事PHP开发。</p>
                                        <h1>个人信息</h1>
                                        <p>暂无</p>
                                        <h1>个人介绍</h1>
                                        <p>一个没有故事的男同学，没什么介绍......</p>
                                        <h1 style="text-align:center;">The End</h1>
                                    </div>
                                </fieldset>
                            </div>
                        </div><!--关于作者End-->
                        <div class="layui-tab-item">
                            <div class="aboutinfo">
                                <div class="aboutinfo-figure">
                                    <img src="{{URL::asset('blog/images/handshake.png')}}" alt="友情链接" />
                                </div>
                                <p class="aboutinfo-nickname">友情链接</p>
                                <p class="aboutinfo-introduce">Name：遇见&nbsp;&nbsp;&nbsp;&nbsp;Site：blog.zhuxv.com</p>
                                <p class="aboutinfo-location">
                                    <i class="fa fa-close"></i>经常宕机&nbsp;
                                    <i class="fa fa-close"></i>不合法规&nbsp;
                                    <i class="fa fa-close"></i>插边球站&nbsp;
                                    <i class="fa fa-close"></i>红标报毒&nbsp;
                                    <i class="fa fa-check"></i>原创优先&nbsp;
                                    <i class="fa fa-check"></i>技术优先
                                </p>
                                <hr />
                                <div class="aboutinfo-contact">
                                    <p style="font-size:2em;">互换友链，携手并进！</p>
                                </div>
                                @if(!empty($links))
                                    <fieldset class="layui-elem-field layui-field-title">
                                        <legend>Friend Link</legend>
                                        <div class="layui-field-box">
                                            <ul class="friendlink">
                                                @foreach($links as $lin)
                                                    <li>
                                                        <a target="_blank" href="{{$lin->lilink}}" title="Layui" class="friendlink-item">
                                                            <p class="friendlink-item-pic"><img src="http://qiniu.zhuxv.com/{{$lin->lilogo}}" alt="{{$lin->liname}}" /></p>
                                                            <p class="friendlink-item-title">{{$lin->liname}}</p>
                                                            <p class="friendlink-item-domain">{{$lin->lilink}}</p>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </fieldset>
                                @endif
                            </div>
                        </div><!--友情链接End-->
                        <div class="layui-tab-item  layui-show">
                            <div class="aboutinfo">
                                <div class="aboutinfo-figure">
                                    <img src="{{URL::asset('blog/images/messagewall.png')}}" alt="留言墙" />
                                </div>
                                <p class="aboutinfo-nickname">留言墙</p>
                                <p class="aboutinfo-introduce">本页面可留言、吐槽、提问。欢迎灌水，杜绝广告！</p>
                                <p class="aboutinfo-location">
                                    <i class="fa fa-clock-o"></i>&nbsp;<span id="time"></span>
                                </p>
                                <hr />
                                <div class="aboutinfo-contact">
                                    <p style="font-size:2em;">沟通交流，拉近你我！</p>
                                </div>
                                <fieldset class="layui-elem-field layui-field-title">
                                    <legend>Leave a message</legend>
                                    <div class="layui-field-box">
                                        <div class="leavemessage" style="text-align:initial">
                                            <form class="layui-form blog-editor" action="">
                                                <div class="layui-form-item">
                                                    <textarea name="editorContent" lay-verify="content" id="remarkEditor" placeholder="请输入内容" class="layui-textarea layui-hide"></textarea>
                                                </div>
                                                <div class="layui-form-item">
                                                    <button class="layui-btn" lay-submit="formLeaveMessage" lay-filter="formLeaveMessage">提交留言</button>
                                                </div>
                                            </form>
                                            <ul class="blog-comment">
												@foreach($messdata as $key => $item)
	                                                <li>
	                                                    <div class="comment-parent">
	                                                        <img src="{{$item->user->qifigureurl_qq_1}}" alt="遇见博客" />
	                                                        <div class="info">
	                                                            <span class="username">{!!$item->user->qqnickname!!}</span>
	                                                        </div>
	                                                        <div class="content">
	                                                            {!!$item->mecomment!!}
	                                                        </div>
	                                                        <p class="info info-footer"><span class="time">{{date("Y-m-d H:i:s",$item->mecreatetime)}}</span><a class="btn-reply" href="javascript:;" onclick="btnReplyClick(this)">回复</a></p>
	                                                    </div>
	                                                    <hr />
	                                                    @if($item->child)
	                                                    	@foreach($item->child as $val)
			                                                    <div class="comment-child">
															        <img src="{{$val->user->qifigureurl_qq_1}}" alt="遇见博客" />
															        <div class="info">
															            <span class="username">{{$val->user->qqnickname}}</span><span>{!!$val->mecomment!!}</span>
															        </div>
															        <p class="info"><span class="time">{{date("Y-m-d H:i",$val->mecreatetime)}}</span></p>
															    </div>
															@endforeach
														@endif
	                                                    <!-- 回复表单默认隐藏 -->
	                                                    <div class="replycontainer layui-hide">
	                                                        <form class="layui-form" action="">
	                                                            <div class="layui-form-item">
	                                                            	<input type="hidden" name="pid" value="{{$item->meid}}">
	                                                                <textarea name="replyContent" lay-verify="replyContent" placeholder="请输入回复内容" class="layui-textarea" style="min-height:80px;"></textarea>
	                                                            </div>
	                                                            <div class="layui-form-item">
	                                                                <button class="layui-btn layui-btn-mini" lay-submit="formReply" lay-filter="formReply">提交</button>
	                                                            </div>
	                                                        </form>
	                                                    </div>
	                                                </li>
												@endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div><!--留言墙End-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{URL::asset('blog/js/about.js')}}"></script>
    <!-- <div class="comment-child">
        <img src="{{URL::asset('blog/images/Absolutely.jpg')}}" alt="Absolutely" />
        <div class="info">
            <span class="username">Absolutely</span><span>这是用户回复内容</span>
        </div>
        <p class="info"><span class="time">2017-03-18 18:26</span></p>
    </div>
    <div class="comment-child">
        <img src="{{URL::asset('blog/images/Absolutely.jpg')}}" alt="Absolutely" />
        <div class="info">
            <span class="username">Absolutely</span><span>这是第二个用户回复内容</span>
        </div>
        <p class="info"><span class="time">2017-03-18 18:26</span></p>
    </div> -->
@endsection