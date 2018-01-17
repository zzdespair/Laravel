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
    <script src="{{URL::asset('admins/js/uploadPreview.min.js')}}"></script>
    <script src="{{URL::asset('admins/js/uploadPreview.js')}}"></script>
    <script src="{{URL::asset('admins/js/upload.js')}}"></script>
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
    友链管理
@endsection

@section('setitle')
    友链添加
@endsection

@section("content")

    <fieldset id="dataConsole" class="layui-elem-field layui-field-title">
        <legend>标签添加</legend>
    </fieldset>
    <form class="layui-form" action="" id="links" empty="multipart/form-data">
    {{ csrf_field() }}
        <div class="layui-upload" style="margin-left:7%;">
            <input class="layui-btn" type="file" id="scroll_img" name="lilogo">
            <div class="layui-upload-list">
                <img class="layui-upload-img" id="imgShow" style="width:200px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">友链名称</label>
            <div class="layui-input-block">
              <input type="text" name="liname" lay-verify="title" autocomplete="on" placeholder="请输入友链名称" class="layui-input" style="width:50%;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">友链链接</label>
            <div class="layui-input-block">
              <input type="text" name="lilink" lay-verify="title" autocomplete="on" placeholder="示例:http://blog.zhuxv.com" class="layui-input" style="width:50%;" id="linkes">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" checked="" name="listatus" lay-skin="switch" lay-filter="switchTest" lay-text="启用|禁用">
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
                var formData = new FormData(document.getElementById('links'));
                if (isURL($.trim($('#linkes').val())) === false) {
                    layer.msg("您的网址不符合规则,应加http或https", { icon: 5 });
                    layer.close(index);
                    return false;
                }
                $.ajax({
                    url:"{{action('Admin\ExtendController@store')}}",
                    type:'post',
                    data:formData,
                    dataType: 'json',
                    async:true,
                    cache:false,
                    contentType:false,
                    processData:false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        layer.close(index);
                        console.log(data);
                        if(data.code == 200){
                            layer.msg('添加成功', { icon: 6 });
                            setTimeout(function () {
                                location.href = "/admin/extend";
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
            function isURL(card){
                var pattern = /((http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?)/;
                return pattern.test(card);
            }
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