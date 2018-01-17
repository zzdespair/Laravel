@extends("home.header")

@section("style")
    <link rel="stylesheet" type="text/css" href="{{URL::asset('pubu/css/normalize.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset('pubu/css/default.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('pubu/css/styles.css')}}">
    <style>
      nav{
        left:0;
      }
    </style>
@endsection

@section("content")
    <!-- 主体（一般只改变这里的内容） -->
    <div style="margin-top:100px;"></div>
    <fieldset class="layui-elem-field site-demo-button">
      <div>
        <a href="{{action('Home\ResourceController@data',['id'=>0])}}" class="layui-btn layui-btn-disabled">
          全部照片
        </a>
        @foreach($album as $alb)
          <a href="{{action('Home\ResourceController@data',['id'=>$alb->alid])}}" class="layui-btn layui-btn-primary">
            {{$alb->alname}}
          </a>
        @endforeach
      </div>
    </fieldset>
    <article class="htmleaf-container">
        <div class="wall" >
          @foreach($photo as $item)
            <a class="article">
              <img data-src="http://qiniu.zhuxv.com/{{$item->phphoto}}" alt="下拉加载图片" />
              <h2>{{$item->phtitle}}</h2>
            </a>
          @endforeach
        </div>
    </article>
    <script src="{{URL::asset('blog/js/resource.js')}}"></script>
    <script>window.jQuery || document.write('<script src="{{URL::asset('pubu/js/jquery-2.1.1.min.js')}}"><\/script>')</script>
    <script type="text/javascript" src="{{URL::asset('pubu/js/jaliswall.js')}}"></script>
    <script type="text/javascript">
    $(function(){
        $('.wall').jaliswall({ item: '.article' });
    });
    </script>
@endsection