<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:wb="http://open.weibo.com/wb"><head><title><?php echo ($sitename); ?>-<?php echo ($title); ?></title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="keywords" content="<?php echo ($keywords); ?>" /><meta name="description" content="<?php echo ($description); ?>" /><link href="../Public/css/style.css" rel="stylesheet" type="text/css" /><link href="../Public/css/hoverex-all.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="../Public/js/jquery-1.7.2.min.js"></script><script type="text/javascript" src="../Public/js/jquery.hoverex.js"></script><script type="text/javascript" src="../Public/js/jquery.form.js"></script><script src="http://l.tbcdn.cn/apps/top/x/sdk.js?appkey=21732232"></script><style type="text/css">    #nav_<?php echo ($position[0]['id']); ?>{background-color:#ED165C;}
    </style></head><body><div class="onqrcode"><div class="qrcode_img"><img src="../Public/images/wxshow.jpg" /></div><div class="qrcode" style="display: none;"><img src="Uploads<?php $set=$_result=M('Set')->getField('qrcode',1); echo $set;?>" width="200" height="200" /><div style="font-size:14px; text-align: center; padding-bottom:10px;">微信公众号:大家买什么</div></div></div><!-- 
    <div class="member"><div class="member_content"><ul><?php if($_SESSION['account']!= null): ?><li class="huany">欢迎您:&nbsp;<a href="<?php echo U('Member/space',array('u'=>session('account')));?>"><?php echo (session('account')); ?></a></li><li class="tuichu"><a href="<?php echo U('Member/logout');?>" target='_top'>退出</a></li><?php else: ?><li class="zz"><a href="<?php echo U('Member/register');?>">注册</a></li><li  class="zz"><a href="<?php echo U('Member/login');?>">登录</a></li><?php endif; ?><!-- 
                &nbsp;&nbsp;<a href="<?php echo U('Content/index',array('id'=>52));?>">手机客户端</a></ul></div></div>     --><!--顶部logo--><div class="logo"><div class="logo_left"><a href="http://www.djmsm.com/"><img src="../Public/images/logo.png"></a></div><div class="logo_right">&nbsp;</div></div><!--顶部logo结束--><div id="header"><div class="header_box"><!-- 系统配置的logo
        	 
            <a href="__APP__"><img src="__ROOT__/Uploads<?php $set=$_result=M('Set')->getField('logo',1); echo $set;?>" width="234" height="55" /></a>             --><!-- 导航banner --><ul><li><a href="__APP__" id="nav_0">首页</a></li><?php if(is_array($nav_list)): $i = 0; $__LIST__ = $nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li ><a href="<?php echo ($vo["url"]); ?>" id="nav_<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><!-- 导航banner结束 --><!-- 
            <div class="search"><form action="<?php echo U('Product/index',array('id'=>61));?>" method="post"><input type="text" name='search'><input type="submit" class="button" value='搜索' ></form></div>             --></div></div><!--主体内容--><div class="main"><div class="container"><!--主体左边--><div class="course-sidebar" id="J_BdSide"><div class="course-sidebar-type"><div class="course-sidebar-menu"><ul><li><a class="curr" href="#">分类导航</a></li></ul><div class="dot-curr"></div></div><div class="course-sidebar-tabs"><ul class="js-sidebar-lang"><li><a href="<?php echo U('Tuan/index',array('id'=>$position[0]['id']));?>" <?php if(($id) == $position[0]['id']): ?>class="cur"<?php endif; ?>>所有</a></li><?php if(is_array($categorylist)): $i = 0; $__LIST__ = $categorylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category1): $mod = ($i % 2 );++$i; if($category1['id'] == $position[0]['id']): if(is_array($category1["pid"])): $i = 0; $__LIST__ = $category1["pid"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category2): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Tuan/index',array('id'=>$category2['id']));?>" title="<?php echo ($category2['catname']); ?>" <?php if(($id) == $category2['id']): ?>class="cur"<?php endif; ?>><?php echo ($category2['catname']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?></ul></div><dl class="course-sidebar-level js-sidebar-level"><dt>其他主题导航</dt><?php if(is_array($nav_list)): $i = 0; $__LIST__ = $nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dd style="margin-right:8px"><a href="<?php echo ($vo["url"]); ?>" id="nav_<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></a></dd><?php endforeach; endif; else: echo "" ;endif; ?></dl></div><!-- 
            <div  class="course-sidebar-search"><form action="<?php echo U('Tuan/index',array('id'=>53));?>" method="post"><input type="text" name='search' class="js-keyword"  placeholder="商品搜索"></form></div>             --></div><!--主体左边结束--><!--主体右边--><!-- 
    	<div id="main">    	广告banner
        <div class="ad_position_id" style="padding: 0 20px;"><?php $advert=$_result=M('Advert')->where('adtag="tuan_list_top"')->find(); if($advert['timelimit']==0):echo $advert['adcontent'];else:if($advert['endtime']>=1416932985):echo $advert['adcontent'];else:echo $advert['adpastcontent'];endif;endif;?></div>         --><!-- 分类 --><!--主体右边--><div class="course-content"><div class="course-tools"  id="kechencc"><img alt="" src="../Public/images/two11.gif"></div><!--产品图--><div id="myboxcc"><!--产品模块--><div class="pagec a_slow elasticInLeft"><!-- 一行 --><div class="demowrap cf"><!-- 一个 --><?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="box"><div class="he-wrap tpl2"><img src="<?php echo (str_replace('.jpg','.jpg_300x300.jpg',$vo['thumb'][0])); ?>" width="320px" height="320px"/><div class="he-view"><div class="bg a0"  data-animate="fadeIn"><div class="center-bar"><a href="<?php echo U('Tuan/link',array('id'=>$vo['id']));?>" class="twitter a0" data-animate="rotateInLeft" target="_blank"></a></div></div></div><div><ul><li style="width:315px;"><a href="<?php echo U('Tuan/show',array('id'=>$vo['id']));?>" target="_blank"><?php echo ($vo["title"]); ?></a></li><li><!-- <?php echo number_format($vo['hdprice']/$vo['price'],2)*10 ?>折 --><!--    原价：￥<del><?php echo (round($vo['price'],2)); ?></del>&nbsp;&nbsp;节省：￥<?php echo ($vo['price']-$vo['hdprice']); ?>				￥
				 -->				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;双11价格:&nbsp;<span style="font-size:18px;color:#E22261;"><?php echo (round($vo["hdprice"],3)); ?>元</span><a href="<?php if(empty($vo["buyurl"])): echo ($vo["sourceurl"]); else: echo ($vo["buyurl"]); endif; ?>" target="_blank"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;折扣力度:&nbsp;<span style="font-size:16px;color:#E22261;"><?php echo ($vo["sitetitle"]); ?></span></li></ul></div></div></div><div></div><?php endforeach; endif; else: echo "" ;endif; ?><!-- 一个 --></div><!-- 一行 --></div><!--产品模块--><!-- 分页 --><div class="page"><?php echo ($page); ?></div></div><!--产品图结束--></div><!--主体左边结束--></div></div><!--主体内容-->﻿<div id="footer"><div class="waper"><div class="footerwaper"><div class="footer_intro"><div class="footer_logo"></div><p>Copyright &#169; 2014 djmsm.com 备案号：粤ICP备13074847<br /></p></div><div class="footer_link"><ul><li><a href="index.html">网站首页</a></li><li><a href="index.html">关于我们</a></li><li><a href="index.html">联系我们</a></li><li><a href="index.html">意见反馈</a></li><li><a href="index.html">卖家报名</a></li><li><a href="index.html">站点地图</a></li><li><a href="index.html">友情链接</a></li></ul></div><div class="attention">                在这里关注我们的动向
                <br/><a id="qzone" href="http://user.qzone.qq.com/891639397" target="_blank" title="QQ空间">QQ空间</a><a id="sinaweibo" href="http://weibo.com/gztaojz"  target="_blank" title="新浪微博">新浪微博</a><a id="qqweibo" href="http://t.qq.com/cyangbo"  target="_blank" title="腾讯微博">腾讯微博</a></div></div></div><!--页脚结束--><script language="javascript" type="text/javascript" src="http://js.users.51.la/17440234.js"></script><noscript><a href="http://www.51.la/?17440234" target="_blank"><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/17440234.asp" style="border:none" /></a></noscript><script type="text/javascript">    $(function(){
       $('.qrcode_img').mousemove(function(){
           $('.qrcode').show();
       }).mouseleave(function(){
           $('.qrcode').hide();
       });
    });
</script></div><script>			//监听window滚定时间,取得window对象,取得scroll事件
			$(window).scroll(function() {
				//
				var windowHeight = $(window).scrollTop();
				//sideHeight窗口的滚动距离
				var sideHeight = $('#J_BdSide').height();
				var ccc = '195';
				if (windowHeight > ccc) {
					$('#J_BdSide').css({
						'position' : 'fixed',
						left: '26px',
						top : 0
					});
					$('#kechen').css({
						'position' : 'fixed',
						
						top : 0
					});
					$('#mybox').css({
						
						'margin-top':'55px'
					});
				} else {
					$('#J_BdSide').css({
						'position' : 'static'
					});
					$('#kechen').css({
						'position' : 'inherit'
						
					});
					$('#mybox').css({
						
						'margin-top':'0px'
					});
				}
				
			});
		</script></body></html>