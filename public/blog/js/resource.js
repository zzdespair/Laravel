/*

@Name：遇见博客网站
@Author：ZhuXv 
@Site：http://blog.zhuxv.com

*/

$(function(){
      $(document).on("click","a[class*=primary]",function(){
            var $_this = $(this);
            $.ajax({
                  url:$_this.attr('href'),
                  type:'post',
                  dataType: 'json',
                  headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success:function(data){
                  console.log(data);
                  if (data.code == 200) {
                        $(".wall").empty();
                        var photo = data.data;
                        $.each(photo,function(i){
                              $("div[class=wall]").append('<a class="article" ><img alt="下拉加载图片" data-src="http://qiniu.zhuxv.com/'+photo[i]["phphoto"]+'" /><h2>'+photo[i]["phtitle"]+'</h2></a>')
                        });
                        $('.wall').jaliswall({ item: '.article' });
                        $('a[class*=disabled]').removeClass("layui-btn-disabled").addClass("layui-btn-primary");
                        $_this.removeClass("layui-btn-primary").addClass("layui-btn-disabled");
                        lazyRender ();
                        return false;
                  }else if(data.code == 300){
                        $_this.removeClass("layui-btn-primary").addClass("layui-btn-disabled");
                        layer.msg(data.message,{icon:5});
                  }else{
                        layer.msg(data.message,{icon:5});
                  }
            },
            error:function(data){
                  console.log(data);
                  layer.msg("服务器错误",{icon:5});
            }
            })
            return false;
      })

	$(document).on("click","a[class*=disabled]",function(){
		return false;
	});

      //图片懒加载
      // 先进行一次检查
      lazyRender ();
      //为了不在滚轮滚动过程中就一直判定，设置个setTimeout,等停止滚动后再去判定是否出现在视野中。
      var clock; //这里的clock为timeID，
      $(window).on('scroll',function () {//当页面滚动的时候绑定事件
            lazyRender();
            if (clock) { // 如果在300毫秒内进行scroll的话，都会被clearTimeout掉，setTimeout不会执行。
                    //如果有300毫秒外的操作，会得到一个新的timeID即clock，会执行一次setTimeout,然后保存这次setTimeout的ID，
                      //对于300毫秒内的scroll事件，不会生成新的timeID值，所以会一直被clearTimeout掉，不会执行setTimeout.
                  clearTimeout(clock);
            }
            clock = setTimeout(function () {
                  console.log('运行了一次');
                  lazyRender();
            },300)
      })

      function checkShow($img) { // 传入一个img的jq对象
            var scrollTop = $(window).scrollTop();  //即页面向上滚动的距离
            var windowHeight = $(window).height(); // 浏览器自身的高度
            var offsetTop = $img.offset().top;  //目标标签img相对于document顶部的位置

            if (offsetTop < (scrollTop + windowHeight) && offsetTop > scrollTop) { //在2个临界状态之间的就为出现在视野中的
                  console.log(offsetTop);
                  console.log((scrollTop + windowHeight));
                  console.log(scrollTop);
                  return true;
            }
            return false;
      }
      function isLoaded ($img) {
            return $img.attr('data-src') === $img.attr('src'); //如果data-src和src相等那么就是已经加载过了
      }
      function loadImg ($img) {
            $img.attr('src',$img.attr('data-src')); // 加载就是把自定义属性中存放的真实的src地址赋给src属性
      }

      function lazyRender () {
            $('.wall img').each(function () {//遍历所有的img标签
                  if (checkShow($(this)) && !isLoaded($(this)) ){
                        // 需要写一个checkShow函数来判断当前img是否已经出现在了视野中
                        //还需要写一个isLoaded函数判断当前img是否已经被加载过了
                        loadImg($(this));//符合上述条件之后，再写一个加载函数加载当前img
                  }
            })
      }

})