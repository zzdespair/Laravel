/*

@Name：遇见博客网站
@Author：ZhuXv 
@Site：http://blog.zhuxv.com

*/

$(function(){
    var p=2;// 初始化页面，点击事件从第二页开始
    var flag=false;
    // var caid = $("#caid").val();
    // console.log($('#content'));
   $("#pagesend").click(function(){
    // console.log($("#content p").size());
        send();
    })

 function send(){
    // alert(flag);
    if(flag){
        return false;
    }
    // ===============用ajax方法处理数据加载=================
    $.ajax({
        type:'post',
        url:"/send",
        data:{k:p},
        headers:{
            'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
        },
        beforeSend:function(){
          $("#pagesend").val('加载中...');
        },
        success:function(data){
            // console.log(data);return false;
            if(data.code == 200){
                article = data.data;
                $.each(article,function(i){
                    // console.log(b);
                    // $("div[id=jiaa]").append("<p style='float:right;width:50%;'><a href='../../../Detaile/index/id/"+a+"'><b>.&nbsp;</b>"+data[i]['artitle']+"</a></p>");
                    console.log(article[i]['img']);
                    if (!article[i]['img']) {
                        $("div[id=jiazai]").before('<div class="article shadow"><div class="article-left"><div></div></div><div class="article-right"><div class="article-title"><a href="/detail/id/'+article[i]['arid']+'">'+article[i]['artitle']+'</a></div><div class="article-abstract">'+article[i]['arftitle']+'</div></div><div class="clear"></div><div class="article-footer"><span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;'+article[i]["arcreatetime"]+'</span><span class="article-author"><i class="fa fa-user"></i>&nbsp;&nbsp;'+article[i]["arauthod"]+'</span><span><i class="fa fa-tag"></i>&nbsp;&nbsp;<a href="#">'+article[i]['laname']+'</a></span><span class="article-viewinfo"><i class="fa fa-eye"></i>&nbsp;'+article[i]["arbrowse"]+'</span><span class="article-viewinfo"><i class="fa fa-commenting"></i>&nbsp;'+article[i]["arcomcount"]+'</span></div></div>');
                    }else{
                        $("div[id=jiazai]").before('<div class="article shadow"><div class="article-left"><img src="http://qiniu.zhuxv.com/'+article[i]['img']+'" alt="'+article[i]['artitle']+'" /></div><div class="article-right"><div class="article-title"><a href="/detail/id/'+article[i]['arid']+'">'+article[i]['artitle']+'</a></div><div class="article-abstract">'+article[i]['arftitle']+'</div></div><div class="clear"></div><div class="article-footer"><span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;'+article[i]["arcreatetime"]+'</span><span class="article-author"><i class="fa fa-user"></i>&nbsp;&nbsp;'+article[i]["arauthod"]+'</span><span><i class="fa fa-tag"></i>&nbsp;&nbsp;<a href="#">'+article[i]['laname']+'</a></span><span class="article-viewinfo"><i class="fa fa-eye"></i>&nbsp;'+article[i]["arbrowse"]+'</span><span class="article-viewinfo"><i class="fa fa-commenting"></i>&nbsp;'+article[i]["arcomcount"]+'</span></div></div>');
                    }
                        
                });
                if (data.data.length < 5) {
                    $("#jiazai").remove();
                }else{
                    $("#pagesend").val('加载更多');
                }
            
            }else{
                    $("#jiazai").remove();
                    flag=true;
            }
        },
        complete:function(){
           $("#pagesend").val('加载更多');
        },
        dataType:'json'});
    p++;
 }

})