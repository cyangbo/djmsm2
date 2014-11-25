/*
 * jQuery yufu5 Plugin
 * version: 1.0-2013.05.17
 * http://www.yufu5.com http://www.yufu5.net
 */
$(function(){
    //喜欢
    $('.xh').click(function(){
        $.get(likeUrl,function(data){
             $('.xh span').html("("+data+")");
        }) ;
     });
     //收藏
     $('.collect').click(function(){
         $.get(collectUrl,function(data){

            if (data.status===1){
                alert('收藏成功！');
            }else{
                if(data.info==='未登录'){
                    showBg();
                }else if(data.info==='已收藏'){
                    alert('已收藏过啦！');
                }else{
                    alert('收藏失败，请重试！');
                }
            }

        }) ;
     });

     //小图切换大图
     $('.product_img li img').mouseenter(function(){
         $("#maximg").attr("src",$(this).attr("src").replace('_100x100.jpg','.jpg'));
     });
});