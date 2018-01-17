/*

@Name：遇见博客 
@Author：ZhuXv
@Site：http://blog.zhuxv.com

*/

$(function(){
	$(".recycle").click(function(){
		$_this = $(this);
		$.ajax({
			url:$_this.attr("href"),
			type:"get",
			dataType:'json',
			headers:{
				'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
			},
			success:function(data){
				if (data.code == 200) {
					$_this.parent().parent().remove();
					layer.msg('操作成功', { icon: 6 });
					return false;
				}else{
					layer.msg('操作失败', { icon: 5 });
					return false;
				}
			},
			error:function(data){
				console.log(data);
				layer.msg('服务器错误', { icon: 5 });
				return false;
			}
		})
		return false;
	})

	$(".delarticle").click(function(){
		if (!confirm("是否要彻底删除文章,删除后不可恢复")) {
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
					return false;
				}else if(data.code == 301){
					layer.msg('请先移入回收站删除', { icon: 5 });
					return false;
				}else{
					layer.msg('删除失败', { icon: 5 });
					return false;
				}
			},
			error:function(data){
				console.log(data);
				layer.msg("服务器错误",{ icon: 5 });
			}
		});
		return false;
	})

	$("#alldel").click(function(){
		if (!confirm("是否要清空回收站,清空后不可恢复")) {
			return false;
		}
		var index = layer.load(1);
		$.ajax({
			url:"/admin/alldel",
			type:"get",
			dataType:'json',
			async:true,
			headers:{
				'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
			},
			success:function(data){
				layer.close(index);
				if (data.code == 200) {
					location.reload();
				}else if(data.code == 306){
					layer.msg(data.message,{ icon: 5 });
				}else{
					layer.msg("清空失败",{ icon: 5 });
				}
			},
			error:function(data){
				console.log(data);
				layer.msg("服务器错误",{ icon: 5 });
			}
		})
		return false;
	})

	$(".remmend").click(function(){
		$_this = $(this);
		var formData;
		formData = $_this.parent().serialize();
		$.ajax({
			url:"/admin/remmend",
			type:"post",
			data:formData,
			dataType:'json',
			headers:{
				'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
			},
			success:function(data){
				console.log(data);
				if (data.code == 301) {
					layer.msg(data.message, { icon: 5 });
					check.attr('checked',false);
					return false;
				}
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
	})
})