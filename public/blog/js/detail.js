/*

@Name：遇见博客
@Author：ZhuXv 
@Site：http://blog.zhuxv.com

*/

prettyPrint();
layui.use(['form', 'layedit'], function () {
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
            if (value == "") return "至少得有一个字吧";
            layedit.sync(editIndex);
        }
    });

    //监听评论提交
    form.on('submit(formRemark)', function (data) {
        var index = layer.load(1);
        //模拟评论提交
        
        
        var content = data.field.editorContent;
        var arid = $("#arid").val();
        $.ajax({
            url:"/detail/comment/id/"+arid,
            type:"post",
            data:{comcomment:content},
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