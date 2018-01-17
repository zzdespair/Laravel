<!--

 @Name：不落阁后台模板源码
 @Author：Absolutely
 @Site：http://www.lyblogs.cn

 -->


<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>遇见*博客后台管理系统</title>
    <link rel="shortcut icon" href="{{URL::asset('favicon.ico')}}" type="image/x-icon">
    <!-- layui.css -->
    <link href="{{URL::asset('admins/plugin/layui/css/layui.css')}}" rel="stylesheet" />
    <!-- 本页样式 -->
    <link href="{{URL::asset('admins/css/index.css')}}" rel="stylesheet" />
</head>
<body>
    
    <div class="mask"></div>
    <div class="main">
        <h1><span style="font-size: 84px;">B</span><span style="font-size:30px;">log</span></h1>
        <p id="time"></p>
        <div class="enter">
            Please&nbsp;&nbsp;Click&nbsp;&nbsp;Enter
        </div>
    </div>
    <!-- layui.js -->
    <script src="{{URL::asset('admins/plugin/layui/layui.js')}}"></script>
    <script>
        @if(count($errors)>0)
            @foreach($errors->all() as $key => $error)
                layui.use('layer',function(){
                    layer.msg('{{$error}}', { icon: 5 });
                });
            @endforeach
        @endif
    </script>
    <!-- layui规范化用法 -->
    <script type="text/javascript">
        layui.config({
            base: "../../../admins/js/"
        }).use('index');
    </script>
</body>
</html>