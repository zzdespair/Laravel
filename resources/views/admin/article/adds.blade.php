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
    <script type="text/javascript" charset="utf-8" src="{{URL::asset('admins/js/fuwenben/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{URL::asset('admins/js/fuwenben/ueditor.all.min.js')}}"> </script>
    <script type="text/javascript" charset="utf-8" src="{{URL::asset('admins/js/fuwenben/lang/zh-cn/zh-cn.js')}}"></script>
    <script src="{{URL::asset('admins/js/editor/editor.js')}}"></script>
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

            .layui-upload-img {
                width: 92px;
                height: 92px;
                margin: 0 10px 10px 0;
            }
    </style>
@endsection

@section("stitle")
    文章管理
@endsection

@section('setitle')
    文章添加
@endsection

@section("content")

    <fieldset id="dataConsole" class="layui-elem-field layui-field-title">
        <legend>文章添加</legend>
    </fieldset>
    
    <form class="layui-form" action="" id="article" empty="multipart/form-data">
        {{ csrf_field() }}
        <div class="layui-upload" style="margin-left:7%;">
            <input class="layui-btn" type="file" id="scroll_img" name="aiimg">
            <div class="layui-upload-list">
                <img class="layui-upload-img" id="imgShow" style="width:200px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">文章标题</label>
            <div class="layui-input-block">
                <input type="text" name="article[artitle]" lay-verify="title" autocomplete="on" placeholder="请输入文章标题" class="layui-input" style="width:50%;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">文章副标题</label>
            <div class="layui-input-block">
                <input type="text" name="article[arftitle]" lay-verify="title" autocomplete="on" placeholder="请输入文章副标题" class="layui-input" style="width:50%;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">文章分类</label>
            <div class="layui-input-block" style="width:45%;">
                <select name="article[arcaid]" lay-filter="aihao">
                    @foreach($list['category'] as $itemc)
                        <option value="{{$itemc->caid}}">{{$itemc->caname}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">文章标签</label>
            <div class="layui-input-block" style="width:45%;">
                <select name="label[lglaid]" lay-filter="aihao" multiple="multiple">
                    @foreach($list['label'] as $iteml)
                        <option value="{{$iteml->laid}}" selected>{{$iteml->laname}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">作者|出处</label>
            <div class="layui-input-block">
                <input type="text" name="article[arauthod]" lay-verify="title" autocomplete="on" placeholder="请标明文章出处" class="layui-input" style="width:50%;">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">文章</label>
            <div class="layui-input-block">
                <script id="editor" type="text/plain" name="article_content[accontent]" style="width:85%;height:400px;z-index:998px;"></script>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" id="btn" lay-filter="demo1">立即提交</button>
            </div>
        </div>
    </form>
    <script src="{{URL::asset('admins/plugin/layui/layui.js')}}"></script>
    
    <script>
        $(function(){
            $("#btn").click(function(){
                var index = layer.load(1);
                var formData = new FormData(document.getElementById('article'));
                $.ajax({
                    url:"{{action('Admin\ArticleController@store')}}",
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
                        if(data.code == 200){
                            layer.msg('添加成功', { icon: 6 });
                            setTimeout(function () {
                                location.href = "/admin/article";
                            }, 1000);
                        }else{
                            console.log(data);
                            layer.msg('添加失败', { icon: 5 });
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
    
    <!-- layui规范化用法 -->
    <!-- <script type="text/javascript">
        layui.config({
            base: '../../../admins/js/'
        }).use('datalist');
    </script> -->
@endsection