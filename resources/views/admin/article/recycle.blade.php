<!--

 @Name：不落阁后台模板源码
 @Author：Absolutely
 @Site：http://www.lyblogs.cn

 -->
@extends("admin.header")

@section("style")
    <script src="{{URL::asset('admins/js/article/article.js')}}"></script>
    <script>
        // console.log(  .;$$                     
        //                 ....:;$$$$$$$   $                     
        //             ..;;;$$$            $:..                  
        //          .:$$$$$$               $$$$$:.               
        //        .;$$$$$$$3             $$$$$$$$$;.             
        //      .;$$$$$$$$$$      $$$$$$$;$$$$$$$$$$;.           
        //     ;$$$$$$$$$$$$$    $$;$$$$$$$$$$$$$$$$$$;          
        //    ;$$$$$$$$$$$$$$$$    $$$$$$$$$$$$$$$$$$$$$         
        //   $$$$$$$$$$$$$$$$$$$    $$$$$$$$$$$$$$$$$$$$$        
        //  :$$$$$$$$$$$$$$$$$$$$    $$$$$$$$$$$$$$$$$$$$;       
        // .$$$$$$$$$$$$$$$$$$$$$$$   $$$$$$$$$$$$$$$$$$$$.      
        // :$$$$$$$$$$$$$$$$$$$$$$$$   $$$$$$$$$$$$$$$$$$$:      
        // ;$$$$$$$$$$$$$$$$$$$$$$$$$$  $$$$$$$$$$$$$$$$$$;      
        // ;$$$$$$$$$$$$$$$$$$$$$$$$$$$   $$$$$$$$$$$$$$$$;      
        // :$$$$$$$$$$$$$$$$$$             $$$$$$$$$$$$$$$:      
        // .$$$$$$$$$$$$$$$                 $$$$$$$$$$$$$$.      
        //  ;$$$$$$$$$$$$$                   $$$$$$$$$$$$;       
        //   $$$$$$$$$$$$                     $$$$$$$$$$$        
        //    $$$$$$$$$$                      $$$$$$$$$$         
        //     ;$$$$$$$$                     $$$$$$$$$;          
        //      .$$$$$$$$                   $$$$$$$$$.           
        //        .$$$$$$$$               $$$$$$$$$:             
        //          .;$$$$$$$$          $$$$$$$$;.               
        //             .:$$$$$$$$$$$$$$$$$$$$:.                  
        //                 ...:;;;;;;;;:... );
    </script>
    <style>
        .layui-btn-small {
            padding: 0 15px;
        }

        .layui-form-checkbox {
            margin: 0;
        }

        tr td:not(:nth-child(0)),
        tr th:not(:nth-child(0)) {
            text-align: center;
        }

        #dataConsole {
            text-align: center;
        }
        /*分页页容量样式*/
        /*可选*/
        .layui-laypage {
            display: block;
        }

            /*可选*/
            .layui-laypage > * {
                float: left;
            }
            /*可选*/
            .layui-laypage .pagination {
                float: right;
            }
            /*可选*/
            .layui-laypage:after {
                content: ".";
                display: block;
                height: 0;
                clear: both;
                visibility: hidden;
            }

            /*必须*/
            .layui-laypage .pagination {
                height: 30px;
                line-height: 30px;
                margin: 0px;
                border: none;
                font-weight: 400;
            }
            li{
                float:left;
            }
        /*分页页容量样式END*/
    </style>
@endsection

@section("stitle")
    回收站管理
@endsection

@section("setitle")
    文章回收站
@endsection

@section("content")

    <fieldset id="dataConsole" class="layui-elem-field layui-field-title">
        <legend>回收站管理</legend>
        <div class="layui-field-box">
            <div id="articleIndexTop">
                <form class="layui-form layui-form-pane" action="">
                    <div class="layui-form-item" style="margin:0;margin-top:15px;">
                        <div class="layui-inline">
                            <label class="layui-form-label">分类</label>
                            <div class="layui-input-inline">
                                <select name="city">
                                    <option value="0"></option>
                                    <option value="1">类别1</option>
                                    <option value="2">类别2</option>
                                    <option value="3">类别3</option>
                                </select>
                            </div>
                            <label class="layui-form-label">关键词</label>
                            <div class="layui-input-inline">
                                <input type="text" name="keywords" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-input-inline" style="width:auto">
                                <button class="layui-btn" lay-submit lay-filter="formSearch">搜索</button>
                                <button class="layui-btn layui-btn-danger" title="清空回收站" id="alldel"><i class="layui-icon">&#xe640;</i>清空回收站</button>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" style="width:auto">
                                <a id="addArticle" class="layui-btn layui-btn-normal" href="{{action('Admin\ArticleController@create')}}">发表文章</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </fieldset>
    <fieldset id="dataList" class="layui-elem-field layui-field-title sys-list-field" style="display:block;">
        <legend style="text-align:center;">文章列表</legend>
        <div class="layui-field-box">
            <div id="dataContent" class="">
                <!--内容区域 ajax获取-->
                <table style="" class="layui-table" lay-even="">
                    <!-- <colgroup>
                        <col width="180">
                        <col>
                        <col width="150">
                        <col width="180">
                        <col width="90">
                        <col width="90">
                        <col width="50">
                        <col width="50">
                    </colgroup> -->
                    <thead>
                        <tr>
                            <th>封面</th>
                            <th>标题</th>
                            <th>副标题</th>
                            <th>来源</th>
                            <th>分类</th>
                            <th>标签</th>
                            <th>添加时间</th>
                            <th>编辑时间</th>
                            <th colspan="2">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($article as $item)
                            <tr>
                                <td>
                                    @if($item->arimg)
                                        <img src="http://oreytk5v9.bkt.clouddn.com/{{$item->arimg}}" style="max-height:30px;">
                                    @else
                                        暂无图片
                                    @endif
                                </td>
                                <td>{{$item->artitle}}</td>
                                <td>{{$item->arftitle}}</td>
                                <td>{{$item->arauthod}}</td>
                                <td>{{$item->arcaid}}</td>
                                <td>{{$item->arrelease}}</td>
                                <td>{{$item->arcreatetime}}</td>
                                <td>
                                    @if($item->arupdatetime)
                                        {{date("Y-m-d H:i",$item->arupdatetime)}}
                                    @else
                                        无
                                    @endif
                                </td>
                                <td>
                                    <a href="{{action('Admin\ArticleController@recycle',['id'=>$item->arid,'recycle'=>$item->arstatus])}}" class="recycle">
                                        <button class="layui-btn layui-btn-small"><i class="layui-icon"></i>恢复</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{action('Admin\ArticleController@destroy',['id'=>$item->arid])}}" class="delarticle">
                                        <button class="layui-btn layui-btn-small layui-btn-danger" title="彻底删除"><i class="layui-icon">&#xe640;</i>删除</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="pageNav">
                    <div class="layui-box layui-laypage layui-laypage-default" id="layui-laypage-0">
                        {{$article->links()}}
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <!-- layui.js -->
    <script src="{{URL::asset('admins/plugin/layui/layui.js')}}"></script>
    <!-- layui规范化用法 -->
    <!-- <script type="text/javascript">
        layui.config({
            base: '../../../admins/js/'
        }).use('datalist');
    </script> -->
@endsection