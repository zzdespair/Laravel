@extends("home.header")

@section("style")
    <!-- 比较好用的代码着色插件 -->
    <link href="{{URL::asset('blog/css/prettify.css')}}" rel="stylesheet" />
    <!-- 本页样式表 -->
    <link href="{{URL::asset('blog/css/detail.css')}}" rel="stylesheet" />
    <script src="{{URL::asset('blog/js/prettify.js')}}"></script>
    <style>
        img{
            max-width:100%;
        }
    </style>
@endsection

@section("content")
    <!-- 主体（一般只改变这里的内容） -->
    <div class="blog-body">
        <div class="blog-container">
            <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
                <a href="http://blog.zhuxv.com" title="网站首页">网站首页</a>
                <a href="#" title="文章专栏">{{$detaile->cate}}</a>
                <a><cite>{{$detaile->artitle}}</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="blog-main-left">
                    <!-- 文章内容（使用Kingeditor富文本编辑器发表的） -->
                    <input type="hidden" id="arid" value="{{$detaile->arid}}">
                    <div class="article-detail shadow">
                        <div class="article-detail-title">
                            {{$detaile->artitle}}
                        </div>
                        <div class="article-detail-info">
                            <span>编辑时间：{{date("Y-m-d H:i:s",$detaile->arcreatetime)}}</span>
                            <span>作者：@if($detaile->arauthod) {{$detaile->arauthod}} @else 遇见博客 @endif</span>
                            <span>浏览量：{{$detaile->arbrowse}}</span>
                        </div>
                        <div class="article-detail-content">
                            <p style="text-align:center;">
                                <strong><span style="font-size:18px;">{{$detaile->artitle}}</span></strong>
                            </p>
                            <p style="text-align:center;">
                                <strong>
                                    <span style="font-size:18px;">
                                        <br />
                                    </span>
                                </strong>
                            </p>
                            @if($detaile->img)
                                <p style="text-align:center;">
                                    <img src="http://qiniu.zhuxv.com/{{$detaile->img}}" width="100%" height="auto" title="{{$detaile->artitle}}" alt="{{$detaile->artitle}}" />
                                </p>
                            @endif
                            <p style="text-align:left;">
                                <br />
                            </p>
                            <hr />
                            <p>
                                <br />
                            </p>
                            {!!$detaile->accontent!!}
                            <hr />
                            @if(!empty($shang))
                                <div style="float:left;"><a href="{{action('Home\DetailController@index',['id'=>$shang->arid])}}" title="{{$shang->artitle}}">上一篇</a></div>
                            @endif
                            @if(!empty($xia))
                                <div style="float:right;"><a href="{{action('Home\DetailController@index',['id'=>$xia->arid])}}" title="{{$xia->artitle}}">下一篇</a></div>
                            @endif
                            <p>
                                <br />
                            </p>
                            <hr />
                            &nbsp; &nbsp; 出自：@if($detaile->arauthod){{$detaile->arauthod}} @else 遇见博客 @endif
                            <p>
                                &nbsp; &nbsp; 地址：<a href="http://blog.zhuxv.com" target="_blank">{{$url}}</a>
                            </p>
                            <p>
                                &nbsp; &nbsp; 转载请注明出处！<img src="http://www.lyblogs.cn/kindeditor/plugins/emoticons/images/0.gif" border="0" alt="" />
                            </p>
                            <p>
                                <br />
                            </p>
                        </div>
                    </div>
                    <!-- 评论区域 -->
                    <div class="blog-module shadow" style="box-shadow: 0 1px 8px #a6a6a6;">
                        <fieldset class="layui-elem-field layui-field-title" style="margin-bottom:0">
                            <legend>来说两句吧</legend>
                            <div class="layui-field-box">
                                <form class="layui-form blog-editor" action="">
                                    <div class="layui-form-item">
                                        <textarea name="editorContent" lay-verify="content" id="remarkEditor" placeholder="请输入内容" class="layui-textarea layui-hide"></textarea>
                                    </div>
                                    <div class="layui-form-item">
                                        <button class="layui-btn" lay-submit="formRemark" lay-filter="formRemark">提交评论</button>
                                    </div>
                                </form>
                            </div>
                        </fieldset>
                        <div class="blog-module-title">最新评论</div>
                        <ul class="blog-comment">
                            <li>
                                @foreach($comment as $com)
                                    <div class="comment-parent">
                                        <img src="{{$com->qifigureurl_qq_1}}" alt="{{$com->qqnickname}}" />
                                        <div class="info">
                                            <span class="username">{{$com->qqnickname}}</span>
                                            <span class="time">{{date("Y-m-d H:i:s",$com->comcreatetime)}}</span>
                                        </div>
                                        <div class="content">
                                            {!!$com->comcomment!!}
                                        </div>
                                    </div>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="blog-main-right">
                    <!--右边悬浮 平板或手机设备显示-->
                    <div class="category-toggle"><i class="fa fa-chevron-left"></i></div><!--这个div位置不能改，否则需要添加一个div来代替它或者修改样式表-->
                    <div class="article-category shadow">
                        <div class="article-category-title">分类导航</div>
                        <!-- 点击分类后的页面和artile.html页面一样，只是数据是某一类别的 -->
                        @foreach($category as $cate)
                            <a href="{{action('Home\ArticleController@index',['arcaid'=>$cate->caid])}}">{{$cate->caname}}</a>
                        @endforeach
                        <div class="clear"></div>
                    </div>
                    @if(!empty($similar))
                        <div class="blog-module shadow">
                            <div class="blog-module-title">相似文章</div>
                            <ul class="fa-ul blog-module-ul">
                                @foreach($similar as $simi)    
                                    <li><i class="fa-li fa fa-hand-o-right"></i><a href="{{action('Home\DetailController@index',['id'=>$simi->arid])}}">{{$simi->artitle}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(!empty($casuallook))
                        <div class="blog-module shadow">
                            <div class="blog-module-title">随便看看</div>
                            <ul class="fa-ul blog-module-ul">
                                @foreach($casuallook as $calook)
                                    <li><i class="fa-li fa fa-hand-o-right"></i><a href="{{action('Home\DetailController@index',['id'=>$calook->arid])}}">{{$calook->artitle}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <script src="{{URL::asset('blog/js/detail.js')}}"></script>
@endsection

