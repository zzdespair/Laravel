@extends("admin.header")

@section("style")
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
    <script src="{{URL::asset('admins/js/album/album.js')}}"></script>
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
            .layui-laypage .laypage-extend-pagesize {
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
            .layui-laypage .laypage-extend-pagesize {
                height: 30px;
                line-height: 30px;
                margin: 0px;
                border: none;
                font-weight: 400;
            }
        /*分页页容量样式END*/
    </style>
@endsection

@section("stitle")
    相册分类
@endsection

@section('setitle')
    分类编辑
@endsection

@section("content")

    <fieldset id="dataConsole" class="layui-elem-field layui-field-title">
        <legend>分类编辑</legend>
    </fieldset>
    <form class="layui-form" action="{{route('album.update',$data->alid)}}" method="post" id="album">
        <div class="layui-form-item">
            <label class="layui-form-label">分类名称</label>
            <div class="layui-input-block">
              <input type="text" name="alname" lay-verify="title" autocomplete="on" placeholder="请输入分类名称" class="layui-input" style="width:50%;" value="{{$data->alname}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" @if($data->alstatus == 1) checked @else @endif name="alstatus" lay-skin="switch" lay-filter="switchTest" lay-text="启用|禁用">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" type="submit" lay-submit="" id="bianji" lay-filter="demo1">立即提交</button>
            </div>
        </div>
    </form>
    <script>
        $(function(){
            $("#bianji").click(function(){
                var formData = $('#album').serialize();
                $.ajax({
                    url:"{{action('Admin\AlbumController@update',['id'=>$data->alid])}}",
                    type:'put',
                    data:formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data.code == 200){
                            layer.msg('编辑成功', { icon: 6 });
                            setTimeout(function () {
                                location.href = "/admin/album";
                            }, 1000);
                        }else{
                            layer.msg('编辑失败', { icon: 5 });
                        }
                    },
                    error:function(data){
                        console.log(data);
                        layer.msg('服务器错误', { icon: 5 });
                    }
                });
                return false;
            })
        })
    </script>
    <!-- layui.js -->
    <script src="{{URL::asset('admins/plugin/layui/layui.js')}}"></script>
    <!-- layui规范化用法 -->
    <!-- <script type="text/javascript">
        layui.config({
            base: '../../../admins/js/'
        }).use('datalist');
    </script> -->
@endsection
