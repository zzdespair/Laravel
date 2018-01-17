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
    公告管理
@endsection

@section('setitle')
    公告添加
@endsection

@section("content")

    <fieldset id="dataConsole" class="layui-elem-field layui-field-title">
        <legend>公告添加</legend>
    </fieldset>
    <form class="layui-form" action="" id="notice">
    {{ csrf_field() }}
        <div class="layui-form-item">
            <label class="layui-form-label">公告标题</label>
            <div class="layui-input-block">
              <input type="text" name="notitle" lay-verify="title" autocomplete="on" placeholder="请输入公告" class="layui-input" style="width:50%;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" checked="" name="nostatus" lay-skin="switch" lay-filter="switchTest" lay-text="启用|禁用">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" id="btn" lay-filter="demo1">立即提交</button>
            </div>
        </div>
    </form>
    <script>
        $(function(){
            $("#btn").click(function(){
                var index = layer.load(1);
                var formData = $('#notice').serialize();
                $.ajax({
                    url:"{{action('Admin\NoticeController@store')}}",
                    type:'post',
                    data:formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        layer.close(index);
                        console.log(data);
                        if(data.code == 200){
                            layer.msg('添加成功', { icon: 6 });
                            setTimeout(function () {
                                location.href = "/admin/notice";
                            }, 1000);
                        }else{
                            layer.msg(data.message, { icon: 5 });
                        }
                    },
                    error:function(data){
                        layer.close(index);
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