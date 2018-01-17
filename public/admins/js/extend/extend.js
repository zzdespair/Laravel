/**
 * 	@Name：遇见博客 
 *  @Author：ZhuXv
 *  @Site：http://blog.zhuxv.com
 */

$(function(){
	$('.status').click(function(){
		$_this = $(this);
		var formData;
		formData = $_this.parent().serialize();
		$.ajax({
			url:"/admin/linkstatus",
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
					if (status == false) {
						check.attr('checked',true);
					}else if(status == true){
						check.attr("checked",false);
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

	$(".delete").click(function(){
		if (!confirm("是否删除友链,删除后不可恢复")) {
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
					layer.msg('删除失败', { icon: 5 });
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