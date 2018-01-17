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
    时光轴管理
@endsection

@section('setitle')
    时光轴编辑
@endsection

@section("content")

    <fieldset id="dataConsole" class="layui-elem-field layui-field-title">
        <legend>时光轴编辑</legend>
    </fieldset>
    <form class="layui-form" action="" id="timeline">
        <input type="hidden" name="_method" value="put" />
        <div class="layui-form-item">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-block">
              <input type="text" name="tidesc" lay-verify="title" autocomplete="on" placeholder="请输入时光轴描述" class="layui-input" style="width:50%;" value="{{$data->tidesc}}">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">时间</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="titime" value="{{$data->titime}}" id="test5">
            </div>
        </div>

        <script type="text/javascript">
            layui.use('laydate', function(){
                var laydate = layui.laydate;
                //执行一个laydate实例
                laydate.render({
                    elem: '#test5', //指定元素
                    type: 'datetime'
                });
            });
        </script>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" @if($data->tistatus == 1)checked=""@endif name="tistatus" lay-skin="switch" lay-filter="switchTest" lay-text="启用|禁用">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn btn" lay-submit="" id="btn" lay-filter="demo1">立即提交</button>
            </div>
        </div>
    </form>
    
    <script>
        $(function(){
            $(document).on('click','button[class*=btn]',function(){
                var $_this = $(this);
                $_this.removeClass('btn');
                var formData = $('#timeline').serialize();
                $.ajax({
                    url:"{{action('Admin\TimelineController@update',['id'=>$data->tiid])}}",
                    type:'post',
                    data:formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data.code == 200){
                            layer.msg('编辑成功', { icon: 6 });
                            setTimeout(function () {
                                location.href = "/admin/timeline";
                            }, 1000);
                        }else{
                            $_this.addClass('btn');
                            layer.msg('编辑失败', { icon: 5 });
                        }
                    },
                    error:function(data){
                        console.log(data);
                        $_this.addClass('btn');
                        layer.msg('服务器错误', { icon: 5 });
                    }
                });

                return false;
            })
        })
    </script>
    <!-- layui.js -->

    <!-- layui规范化用法 -->
    <!-- <script type="text/javascript">
        layui.config({
            base: '../../../admins/js/'
        }).use('datalist');
    </script> -->
@endsection