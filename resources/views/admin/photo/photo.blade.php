<!--

 @Name：不落阁后台模板源码
 @Author：Absolutely
 @Site：http://www.lyblogs.cn

 -->
@extends("admin.header")

@section("style")
    <script src="{{URL::asset('admins/js/photo/photo.js')}}"></script>
    <script>
        // console.log(                .;$$                     
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
    照片管理
@endsection

@section("setitle")
    照片添加
@endsection

@section("content")

    <fieldset id="dataConsole" class="layui-elem-field layui-field-title">
        <legend>照片管理</legend>
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
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" style="width:auto">
                                <a id="addArticle" class="layui-btn layui-btn-normal" href="{{action('Admin\PhotoController@create')}}">上传照片</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </fieldset>
    <fieldset id="dataList" class="layui-elem-field layui-field-title sys-list-field" style="display:block;">
        <legend style="text-align:center;">照片列表</legend>
        <div class="layui-field-box">
            <div id="dataContent" class="">
                <!--内容区域 ajax获取-->
                <table style="" class="layui-table" lay-even="">
                    <thead>
                        <tr>
                            <th>照片</th>
                            <th width=250>标题</th>
                            <th>分类</th>
                            <th>状态</th>
                            <th>添加时间</th>
                            <th>编辑时间</th>
                            <th colspan="2">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($photo as $item)
                            <tr>
                                <td>
                                    <img src="http://qiniu.zhuxv.com/{{$item->phphoto}}" style="max-height:30px;">
                                </td>
                                <td>{{$item->phtitle}}</td>
                                <td>{{$item->alname}}</td>
                                <td>
                                    <form class="layui-form" action="">
                                        <div class="layui-form-item status" style="margin:0;">
                                            <input type="checkbox" class="check" name="status" title="启用" lay-filter="top" @if($item->phstatus == 1) checked @endif>
                                            <input type="hidden" name="id" value="{{$item->phid}}">
                                        </div>
                                    </form>
                                </td>
                                <td>{{date("Y-m-d H:i",$item->phcreatetime)}}</td>
                                <td>
                                    @if($item->phupdatetime)
                                        {{date("Y-m-d H:i",$item->phupdatetime)}}
                                    @else
                                        无
                                    @endif
                                </td>
                                <td>
                                    <a href="{{action('Admin\PhotoController@edit',['id'=>$item->phid])}}">
                                        <button class="layui-btn layui-btn-small layui-btn-normal"><i class="layui-icon">&#xe642;</i></button>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{action('Admin\PhotoController@destroy',['id'=>$item->phid])}}" class="delete">
                                        <button class="layui-btn layui-btn-small layui-btn-danger" title="删除"><i class="layui-icon">&#xe640;</i></button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="pageNav">
                    <div class="layui-box layui-laypage layui-laypage-default" id="layui-laypage-0">
                        {{$photo->links()}}
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