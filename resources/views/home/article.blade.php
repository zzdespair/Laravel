@extends("home.header")

@section("style")
    <link href="{{URL::asset('blog/css/article.css')}}" rel="stylesheet" />
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
        <div class="blog-container">
            <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
                <a href="http://blog.zhuxv.com" title="网站首页">网站首页</a>
                <a><cite>文章专栏</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="blog-main-left">
                    @if(!empty($notice))
                        <div class="shadow" style="text-align:center;font-size:16px;padding:40px 15px;background:#fff;margin-bottom:15px;">
                            未搜索到与【<span style="color: #FF5722;">{{$notice}}</span>】有关的文章，随便看看吧！
                        </div>
                        @foreach($casual as $look)
                            <div class="article shadow">
                                <div class="article-left">
                                    @if(!empty($look->img))    
                                        <img src="http://qiniu.zhuxv.com/{{$look->img}}" alt="{{$look->artitle}}" />
                                    @else
                                        <div></div>
                                    @endif
                                </div>
                                <div class="article-right">
                                    <div class="article-title">
                                        <a href="{{action('Home\DetailController@index',['id'=>$look->arid])}}">{{$look->artitle}}</a>
                                    </div>
                                    <div class="article-abstract">{{$look->arftitle}}</div>
                                </div>
                                <div class="clear"></div>
                                <div class="article-footer">
                                    <span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{date("Y-m-d",$look->arcreatetime)}}</span>
                                    <span class="article-author"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$look->arauthod}}</span>
                                    <span><i class="fa fa-tag"></i>&nbsp;&nbsp;<a href="#">{{$look->laname}}</a></span>
                                    <span class="article-viewinfo"><i class="fa fa-eye"></i>&nbsp;{{$look->arcomcount}}</span>
                                    <span class="article-viewinfo"><i class="fa fa-commenting"></i>&nbsp;{{$look->arbrowse}}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @foreach($article as $list)
                        <div class="article shadow">
                            <div class="article-left">
                                @if($list->img)
                                    <img src="http://qiniu.zhuxv.com/{{$list->img}}" alt="{{$list->artitle}}" />
                                @else
                                    <div></div>
                                @endif
                            </div>
                            <div class="article-right">
                                <div class="article-title">
                                    <a href="{{action('Home\DetailController@index',['id'=>$list->arid])}}">{{$list->artitle}}</a>
                                </div>
                                <div class="article-abstract">{{$list->arftitle}}</div>
                            </div>
                            <div class="clear"></div>
                            <div class="article-footer">
                                <span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{date("Y-m-d",$list->arcreatetime)}}</span>
                                <span class="article-author"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$list->arauthod}}</span>
                                <span><i class="fa fa-tag"></i>&nbsp;&nbsp;<a href="#">{{$list->laname}}</a></span>
                                <span class="article-viewinfo"><i class="fa fa-eye"></i>&nbsp;{{$list->arcomcount}}</span>
                                <span class="article-viewinfo"><i class="fa fa-commenting"></i>&nbsp;{{$list->arbrowse}}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="blog-main-right">
                    <div class="blog-search">
                        <form class="layui-form" action="{{action('Home\ArticleController@index')}}">
                            <div class="layui-form-item">
                                <div class="search-keywords  shadow">
                                    <input type="text" name="title" lay-verify="required" placeholder="输入关键词搜索" autocomplete="off" class="layui-input">
                                </div>
                                <div class="search-submit  shadow">
                                    <input type="submit" class="search-btn" lay-submit="formSearch" lay-filter="formSearch" value="搜索">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="article-category shadow">
                        <div class="article-category-title">分类导航</div>
                        @foreach($category as $cate)    
                            <a href="{{action('Home\ArticleController@index',['arcaid'=>$cate->caid])}}">{{$cate->caname}}</a>
                        @endforeach
                        <div class="clear"></div>
                    </div>
                    @if(!empty($remmend))
                        <div class="blog-module shadow">
                            <div class="blog-module-title">作者推荐</div>
                            <ul class="fa-ul blog-module-ul">
                                @foreach($remmend as $remm)
                                    <li><i class="fa-li fa fa-hand-o-right"></i><a href="{{action('Home\DetailController@index',['id'=>$remm->arid])}}">{{$remm->artitle}}</a></li>
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
                    <!--右边悬浮 平板或手机设备显示-->
                    <div class="category-toggle"><i class="fa fa-chevron-left"></i></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
@endsection