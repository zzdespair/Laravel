/*

@Name：不落阁后台模板源码 
@Author：Absolutely 
@Site：http://www.lyblogs.cn

*/

layui.define(['element', 'layer', 'form'], function (exports) {
    var form = layui.form;
    var $ = layui.jquery;
    //自定义验证
    form.verify({
        passWord: [/^[\S]{6,12}$/, '密码必须6到12位'],
        account: function (value) {
            if (value.length <= 0 || value.length > 10) {
                return "账号必须1到10位"
            }
            var reg = /^[a-zA-Z0-9]*$/;
            if (!reg.test(value)) {
                return "账号只能为英文或数字";
            }
        },
        result_response: function (value) {
            if (value.length < 1) {
                return '请点击人机识别验证';
            }
        },
    });
    //监听登陆提交
    form.on('submit(login)', function (data) {
        var index = layer.load(1);
        var formData = $('#forms').serialize();
        $.ajax({
            url:"/admin/log",
            type:"post",
            data:formData,
            dataType: 'json',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success:function(data){
                layer.close(index);
                if (data == 1) {
                    layer.msg('登陆成功，正在跳转......', { icon: 6 });
                    layer.closeAll('page');
                    setTimeout(function () {
                        location.href = "/admin";
                    }, 1000);
                }else if(data == 2) {
                    layer.msg('密码解析错误', { icon: 5 });
                }else if(data == 3) {
                    layer.msg('密码错误', { icon: 5 });
                }else if(data == 4) {
                    layer.msg('您在30分钟内多次密码错误,账户已被锁定', { icon: 5 });
                }else if(data == 5) {
                    layer.msg('您的账户已被锁定', { icon: 5 });
                }else if(data == 6) {
                    layer.msg('您的账户已被禁用', { icon: 5 });
                }else if(data == 7) {
                    layer.msg('您的账户状态异常,已禁止登录', { icon: 5 });
                }else if(data == 8) {
                    layer.msg('账号不存在', { icon: 5 });
                }else{
                    layer.msg('未知错误', { icon: 5 });
                }
            },
            error:function(data){
                layer.msg('服务器错误', { icon: 5 });
            }
        });
        // var index = layer.load(1);

        // setTimeout(function () {
        //     //模拟登陆
        //     layer.close(index);
        //     if (data.field.account != 'lyblogscn' || data.field.password != '111111') {
        //         layer.msg('账号或者密码错误', { icon: 5 });
        //     } else {
        //         layer.msg('登陆成功，正在跳转......', { icon: 6 });
        //         layer.closeAll('page');
        //         setTimeout(function () {
        //             location.href = "../html/main.html";
        //         }, 1000);
        //     }
        // }, 400);
        return false;
    });
    //检测键盘按下
    $('body').keydown(function (e) {
        if (e.keyCode == 13) {  //Enter键
            if ($('#layer-login').length <= 0) {
                login();
            } else {
                $('button[lay-filter=login]').click();
            }
        }
    });

    $('.enter').on('click', login);

    function login() {
        var loginHtml = ''; //静态页面只能拼接，这里可以用iFrame或者Ajax请求分部视图。html文件夹下有login.html

        loginHtml += '<form class="layui-form" id="forms" action="">';
        loginHtml += '<div class="layui-form-item">';
        loginHtml += '<label class="layui-form-label">账号</label>';
        loginHtml += '<div class="layui-input-inline pm-login-input">';
        loginHtml += '<input type="text" name="admin_number" lay-verify="account" placeholder="请输入账号" value="" autocomplete="off" class="layui-input">';
        loginHtml += '</div>';
        loginHtml += '</div>';
        loginHtml += '<div class="layui-form-item">';
        loginHtml += '<label class="layui-form-label">密码</label>';
        loginHtml += '<div class="layui-input-inline pm-login-input">';
        loginHtml += '<input type="password" name="password" lay-verify="passWord" placeholder="请输入密码" value="" autocomplete="off" class="layui-input">';
        loginHtml += '</div>';
        loginHtml += '</div>';
        // loginHtml += '<div class="layui-form-item">';
        // loginHtml += '<label class="layui-form-label">人机验证</label>';
        // loginHtml += '<div class="layui-input-inline pm-login-input">';
        // loginHtml += '<input type="text" name="result_response" placeholder="人机验证，百度螺丝帽" value="" autocomplete="off" class="layui-input">';
        // loginHtml += '</div>';
        // loginHtml += '</div>';
        loginHtml += '<div class="layui-form-item" style="margin-top:25px;margin-bottom:0;">';
        loginHtml += '<div class="layui-input-block">';
        loginHtml += ' <button class="layui-btn" style="width:230px;" lay-submit="" lay-filter="login">立即登录</button>';
        loginHtml += ' </div>';
        loginHtml += ' </div>';
        loginHtml += '</form>';

        layer.open({
            id: 'layer-login',
            type: 1,
            title: false,
            shade: 0.4,
            shadeClose: true,
            area: ['480px', '270px'],
            closeBtn: 0,
            anim: 1,
            skin: 'pm-layer-login',
            content: loginHtml
        });
        layui.form.render('checkbox');
    }

    exports('index', {});
});

