$(function(){
	$("#push").click(function(){
		$.ajax({
      		type:'get',
      		url:"/admin/push",
      		beforeSend:function(){
      			$("#push").html("正在推送...");
      		},
      		success:function(data){
      			// alert("成功推送"+data.success+"条站点");
      			layer.msg('推送成功',{icon:6});
      			console.log(data);
      		},
      		complete:function(){
                $("#push").html("站点推送");
            },
      	})
		return false;
	})
})