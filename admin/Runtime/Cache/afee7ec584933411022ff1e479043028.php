<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><link rel='stylesheet' type="text/css" href="../Public/css/style.css" /><script type="text/javascript" src="../Public/js/jquery-2.1.1.min.js"></script><style>            html{overflow-x : hidden;}
        </style><base target="main" /></head><body><?php if(($_GET['title']== '') OR ($_GET['title']== '内容管理')): ?><div class="box"><div class="box_tit"><em class="hopen"></em><h2><?php if(isset($_GET['title'])): echo ($_GET['title']); endif; if(!isset($_GET['title'])): ?>内容管理<?php endif; ?></h2></div><div class="box_list"><ul class="m-treeview"><?php echo ($tree); ?></ul></div></div><div class="box"><div class="box_tit" style="border-top:1px solid #D4D4D4;"><em class="hopen"></em><h2>快捷操作</h2></div><div class="box_list"><ul><li><a href="<?php echo U('Comment/index');?>">评论管理</a></li><li><a href="<?php echo U('Mall/index');?>">商家管理</a></li><li><a href="<?php echo U('Advert/index');?>">广告管理</a></li><li><a href="<?php echo U('Announce/index');?>">公告管理</a></li><li><a href="<?php echo U('Link/index');?>">友情链接</a></li><li><a href="<?php echo U('Other/index');?>">扩展功能</a></li><li><a href="<?php echo U('Clearcache/index');?>">清除缓存</a></li></ul></div></div><?php else: ?><div class="box"><div class="box_tit"><em class="hopen"></em><h2><?php if(isset($_GET['title'])): echo ($_GET['title']); endif; if(!isset($_GET['title'])): ?>内容管理<?php endif; ?></h2></div><div class="box_list"><ul><?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if(($item['pid']) == $menuTag): if((strtolower($item['name'])) != "public"): if((strtolower($item['name'])) != "index"): if(($item['access']) == "1"): ?><li><a href="<?php echo U($item['name'].'/index');?>"><?php echo ($item['title']); ?></a></li><?php endif; endif; endif; endif; endforeach; endif; else: echo "" ;endif; ?></ul></div></div><?php endif; ?><script type="text/javascript">    $(function(){
        $(".m-treeview .m-expanded ul").hide();
        $(".m-treeview .m-expanded span").click(function(){

            var $ul=$(this).siblings("ul");
            if($ul.is(":visible")){
                $(this).parent().attr("class","m-collapsed");
                $ul.hide(); 
            }else{

                $(this).parent().attr("class","m-expanded");
                $ul.show();
            }
        }); 
    });
</script><script type="text/javascript">    $(document).ready(function(){
        /*点击展开与收缩栏目*/
        $(".box_tit").click(function(){
            $(this).next().slideToggle();
            $(this).children("em").toggleClass("cur");
        });
        /*点击选择菜单*/
        $(".box_list li a").click(function(){
            $(".box_list li").removeClass("on"); 
            $(this).parent().addClass("on"); 
        })
    });   
</script></body></html>