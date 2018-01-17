/*

@Name：不落阁整站模板源码 
@Author：Absolutely 
@Site：http://www.lyblogs.cn

*/

layui.use(['element', 'jquery', 'form', 'layedit'], function () {
    var element = layui.element;
    var form = layui.form;
    var $ = layui.jquery;
    var layedit = layui.layedit;

    //评论和留言的编辑器
    var editIndex = layedit.build('remarkEditor', {
        height: 150,
        tool: ['face', '|', 'left', 'center', 'right', '|', 'link'],
    });
    //评论和留言的编辑器的验证
    layui.form.verify({
        content: function (value) {
            value = $.trim(layedit.getText(editIndex));
            if (value == "") return "自少得有一个字吧";
            layedit.sync(editIndex);
        }
    });

    //Hash地址的定位
    var layid = location.hash.replace(/^#tabIndex=/, '');
    if (layid == "") {
        element.tabChange('tabAbout', 1);
    }
    element.tabChange('tabAbout', layid);

    element.on('tab(tabAbout)', function (elem) {
        location.hash = 'tabIndex=' + $(this).attr('lay-id');
    });

    //监听留言提交
    form.on('submit(formLeaveMessage)', function (data) {
        var index = layer.load(1);
    
        layer.close(index);
        var content = data.field.editorContent;
        $.ajax({
            url:"/about/message",
            type:"post",
            data:{mecomment:content},
            dataType:'json',
            cache:false,
            headers:{
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success:function(data){
                layer.close(index);
                if (data.code == 200) {
                    location.reload();
                }else if (data.code == 301) {
                    layer.msg("请登录",{icon:5});
                    return false;
                }else{
                    layer.msg("评论失败",{icon:5});
                    return false;
                }
            },
            error:function(data){
                layer.close(index);
                layer.msg("服务器错误",{icon:5});
                console.log(data);
                return false;
            }
        })
        return false;
    });

    //监听留言回复提交
    form.on('submit(formReply)', function (data) {
        var index = layer.load(1);
        //模拟留言回复
        layer.close(index);
        var content = data.field.replyContent;
        if (!content) {
            layer.msg("至少要有一个字吧!",{icon:5});
        }
        var pid = data.field.pid;
        $.ajax({
            url:"/about/message",
            type:"post",
            data:{mecomment:content,mepid:pid},
            dataType:'json',
            cache:false,
            headers:{
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success:function(data){
                layer.close(index);
                if (data.code == 200) {
                    location.reload();
                }else if (data.code == 301) {
                    layer.msg("请登录",{icon:5});
                    return false;
                }else{
                    layer.msg("评论失败",{icon:5});
                    return false;
                }
            },
            error:function(data){
                layer.close(index);
                layer.msg("服务器错误",{icon:5});
                console.log(data);
                return false;
            }
        })
        return false;
    });
});
function btnReplyClick(elem) {
    var $ = layui.jquery;
    $(elem).parent('p').parent('.comment-parent').siblings('.replycontainer').toggleClass('layui-hide');
    if ($(elem).text() == '回复') {
        $(elem).text('收起')
    } else {
        $(elem).text('回复')
    }
}
systemTime();

function systemTime() {
    //获取系统时间。
    var dateTime = new Date();
    var year = dateTime.getFullYear();
    var month = dateTime.getMonth() + 1;
    var day = dateTime.getDate();
    var hh = dateTime.getHours();
    var mm = dateTime.getMinutes();
    var ss = dateTime.getSeconds();

    //分秒时间是一位数字，在数字前补0。
    mm = extra(mm);
    ss = extra(ss);

    //将时间显示到ID为time的位置，时间格式形如：19:18:02
    document.getElementById("time").innerHTML = year + "-" + month + "-" + day + " " + hh + ":" + mm + ":" + ss;
    //每隔1000ms执行方法systemTime()。
    setTimeout("systemTime()", 1000);
}

//补位函数。
function extra(x) {
    //如果传入数字小于10，数字前补一位0。
    if (x < 10) {
        return "0" + x;
    }
    else {
        return x;
    }
}