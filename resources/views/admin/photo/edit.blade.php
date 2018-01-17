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

            .layui-upload-img {
                width: 92px;
                height: 92px;
                margin: 0 10px 10px 0;
            }
    </style>
@endsection

@section("stitle")
    照片管理
@endsection

@section('setitle')
    照片编辑
@endsection

@section("content")

    <fieldset id="dataConsole" class="layui-elem-field layui-field-title">
        <legend>照片编辑</legend>
    </fieldset>
    
    <form class="layui-form" action="" id="photo" empty="multipart/form-data">
    <input type="hidden" name="_method" value="put">
        <div class="layui-upload" style="margin-left:7%;">
            <input class="layui-btn" type="file" id="scroll_img" name="phphoto">
            <div class="layui-upload-list">
                <img class="layui-upload-img" @if(!empty($data->phphoto)) src="http://qiniu.zhuxv.com/{{$data->phphoto}}" @endif id="imgShow" style="width:200px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="phtitle" lay-verify="title" autocomplete="on" placeholder="请输入照片标题" class="layui-input" style="width:50%;" value="{{$data->phtitle}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">相册分类</label>
            <div class="layui-input-block" style="width:45%;">
                <select name="phalid" lay-filter="aihao">
                    @foreach($album as $item)
                        <option value="{{$item->alid}}" @if($data->phalid == $item->alid) selected  @endif>{{$item->alname}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="phstatus" lay-skin="switch" lay-filter="switchTest" lay-text="启用|禁用" @if($data->phstatus == 1) checked @endif>
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
                var formData = new FormData(document.getElementById('photo'));
                $.ajax({
                    url:"{{action('Admin\PhotoController@update',['id'=>$data->phid])}}",
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
                            layer.msg(data.message, { icon: 6 });
                            setTimeout(function () {
                                location.href = "/admin/photo";
                            }, 1000);
                        }else{
                            console.log(data);
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
    
    <!-- layui规范化用法 -->
    <!-- <script type="text/javascript">
        layui.config({
            base: '../../../admins/js/'
        }).use('datalist');
    </script> -->
@endsection