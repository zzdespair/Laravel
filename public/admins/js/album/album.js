/*

@Name：遇见博客 
@Author：ZhuXv
@Site：http://blog.zhuxv.com

*/

$(function(){
	$(".status").click(function(){
		$_this = $(this);
		var formData;
		formData = $_this.parent().serialize();
		$.ajax({
			url:"/admin/albumstatus",
			type:"post",
			data:formData,
			dataType:'json',
			headers:{
				'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
			},
			success:function(data){
				console.log(data);
				if (data.code != 200) {
					var check = $_this.find("input").first();
					var status = check.is(":checked");
					if (status == true) {
						check.attr('checked',false);
					}else{
						check.attr('checked',true);
					}
					layer.msg('状态更改失败', { icon: 5 });
				}
			},
			error:function(data){
				console.log(data);
				layer.msg('服务器错误', { icon: 5 });
			}
		})
		return false;
	});

	$(".delete").click(function(){
		if (!confirm("是否要删除分类")) {
			return false;
		}
		$_this = $(this);
		$.ajax({
			url:$_this.attr("href"),
			type:"delete",
			dataType:'json',
			headers:{
				'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
			},
			success:function(data){
				if (data.code == 200) {
					$_this.parent().parent().remove();
				}else{
					layer.msg(data.message, { icon: 5 });
				}
			},
			error:function(data){
				console.log(data);
				layer.msg('服务器错误', { icon: 5 });
			}
		})

		return false;
	})
})