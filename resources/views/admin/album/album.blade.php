@extends("admin.header")

@section("style")
    <script src="{{URL::asset('admins/js/album/album.js')}}"></script>
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
            .layui-laypage .pagination{
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
    相册分类
@endsection

@section("content")

    <fieldset id="dataConsole" class="layui-elem-field layui-field-title">
        <legend>相册分类</legend>
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
                                <a href="{{action('Admin\AlbumController@create')}}" id="addArticle" class="layui-btn layui-btn-normal">添加分类</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </fieldset>
    <fieldset id="dataList" class="layui-elem-field layui-field-title sys-list-field" style="display:block;">
        <legend style="text-align:center;">分类列表</legend>
        <div class="layui-field-box">
            <div id="dataContent" class="">
                <!--内容区域 ajax获取-->
                <table style="" class="layui-table" lay-even="">
                    <thead>
                        <tr>
                            <th>分类名</th>
                            <th>状态</th>
                            <th>添加时间</th>
                            <th>修改时间</th>
                            <th colspan="2">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($album as $item)
                            <tr>
                                <td>{{$item->alname}}</td>
                                <td>
                                    <form class="layui-form" action="">
                                        <div class="layui-form-item status" style="margin:0;">
                                            <input type="checkbox" class="check" name="status" title="启用" lay-filter="top" @if($item->alstatus == 1) checked @endif>
                                            <input type="hidden" name="id" value="{{$item->alid}}">
                                        </div>
                                    </form>
                                </td>
                                <td>{{date("Y-m-d H:i:s",$item->alcreatetime)}}</td>
                                <td>@if($item->alupdatetime){{date("Y-m-d H:i:s",$item->alupdatetime)}}@else无@endif</td>
                                <td>
                                    <a href="{{route('album.edit',$item->alid)}}">    
					                   <button class="layui-btn layui-btn-small layui-btn-normal"><i class="layui-icon">&#xe642;</i></button>
                                    </a>
				                </td>
                                <td>
				                    <a href="{{action('Admin\AlbumController@destroy',['id'=>$item->alid])}}" class="delete">
                                        <button class="layui-btn layui-btn-small layui-btn-danger"><i class="layui-icon">&#xe640;</i></button>
				                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="pageNav">
                    <div class="layui-box layui-laypage layui-laypage-default" id="layui-laypage-0">
                        {{$album->links()}}
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
