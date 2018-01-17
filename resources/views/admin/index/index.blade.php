<!--

 @Name：不落阁后台模板源码
 @Author：Absolutely
 @Site：http://www.lyblogs.cn

 -->

@extends('admin.header')

@section('content')
	<div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <p style="padding: 10px 15px; margin-bottom: 20px; margin-top: 10px; border:1px solid #ddd;display:inline-block;">
                上次登陆
                <span style="padding-left:1em;">IP：{{$log['ip']}}</span>
                <span style="padding-left:1em;">地点：{{$log['address']}}</span>
                <span style="padding-left:1em;">时间：{{date("Y-m-d H:i",$log['logtime'])}}</span>
                <span style="padding-left:1em;">坐标：横纬{{$log['x']}} 纵经{{$log['y']}}</span>
            </p>
            <fieldset class="layui-elem-field layui-field-title">
                <legend>统计信息</legend>
                <div class="layui-field-box">
                    <div style="display: inline-block; width: 100%;">
                        <div class="ht-box layui-bg-blue">
                            <p>{{$statistics['user']}}</p>
                            <p>用户总数</p>
                        </div>
                        <div class="ht-box layui-bg-red">
                            <p>{{$statistics['register']}}</p>
                            <p>今日注册</p>
                        </div>
                        <div class="ht-box layui-bg-green">
                            <p>{{$statistics['login']}}</p>
                            <p>今日登陆</p>
                        </div>
                        <div class="ht-box layui-bg-orange">
                            <p>{{$statistics['article']}}</p>
                            <p>文章总数</p>
                        </div>
                        <div class="ht-box layui-bg-cyan">
                            <p>{{$statistics['resource']}}</p>
                            <p>照片总数</p>
                        </div>
                        <div class="ht-box layui-bg-black">
                            <p>{{$statistics['note']}}</p>
                            <p>笔记总数</p>
                        </div>
                    </div>
                </div>
            </fieldset>
            <a href="{{action('Admin\PushController@push')}}" id="push">站点推送</a>
            <script src="{{URL::asset('admins/js/index/index.js')}}"></script>
        </div>
    </div>
@endsection