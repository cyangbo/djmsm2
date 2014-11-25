得到商品数据表
--
-- 表的结构 `yufu_tuan`
--

INSERT INTO `yufu_tuan` (`id`,`catid`, `keywords`,`description`,`title`,`price`,`hdprice`,`starttime`,`endtime`,`buyurl`,`thumb`,`monthsale`,`create_time`,`update_time`)VALUES(162,54,'关键词','描述','标题标题标题标题',222,111,1414941360,1419941360,'http://detail.tmall.com/item.htm?id=41014369486',553,1419041360,1419041360);
CREATE TABLE IF NOT EXISTS `yufu_tuan` (
  `id` int(11) NOT NULL auto_increment COMMENT '//产品ID',
  `catid` int(11) default NULL COMMENT '//类目的ID',
  `mallid` int(11) default NULL COMMENT '//1,不知道',
  `sitetitle` varchar(255) default NULL COMMENT '//自定义title：如果title为空，默认用标题作为title内容',
  `keywords` varchar(80) default NULL  COMMENT '//关键词1,关键词2 关键词3',
  `description` text  COMMENT '//网页Meta标签的description处显示,此处会显示在商品页的本商品页面!',
  `title` varchar(255) default NULL  COMMENT '//标题',
  `sourceurl` varchar(500) default NULL  COMMENT '//输入商品链接地址',
  `price` float(13,2) default NULL  COMMENT '//原价',
  `hdprice` float(13,2) default NULL  COMMENT '//折扣价',
  `starttime` int(11) default NULL  COMMENT '//开始时间',
  `endtime` int(11) default NULL  COMMENT '//结束时间',
  `buyurl` varchar(500) default NULL  COMMENT '//淘宝客购买链接',
  `buynum` int(11) default NULL  COMMENT '//不知道',
  `thumb` text  COMMENT '//上传的地址/2014/11/02/54564b7e30cb0.jpg',
  `monthsale` int(11) default NULL  COMMENT '//月销量数字',
  `brand` varchar(25) default NULL  COMMENT '//品牌用来保存商品淘宝id字符串',
  `content` text  COMMENT '//页面里面的内容',
  `xihuan` int(11) default NULL  COMMENT '//喜欢',
  `ding` int(11) default NULL  COMMENT '//不知道',
  `cai` int(11) default NULL  COMMENT '//1,不知道',
  `chaozhi` int(11) default NULL  COMMENT '//1,不知道',
  `yibanzhi` int(11) default NULL  COMMENT '//1,不知道',
  `buzhi` int(11) default NULL  COMMENT '//1,不知道',
  `baoyou` tinyint(4) default NULL  COMMENT '//包邮',
  `qtth` tinyint(4) default NULL  COMMENT '//七天退换',
  `asfh` tinyint(4) default NULL  COMMENT '//按时发货',
  `jfbgwdx` tinyint(4) default NULL  COMMENT '//集分宝购物抵现',
  `yfx` tinyint(4) default NULL  COMMENT '//运费险',
  `jstk` tinyint(4) default NULL  COMMENT '//极速退款',
  `thbzk` tinyint(4) default NULL  COMMENT '//退货保障卡',
  `smth` tinyint(4) default NULL  COMMENT '//上门退货',
  `hits` int(11) default '0'  COMMENT '//1,不知道',
  `listorder` int(11) default '0'  COMMENT '//1,不知道',
  `status` tinyint(1) default NULL  COMMENT '//1,不知道',
  `create_time` int(11) default NULL  COMMENT '//创建时间',
  `update_time` int(11) default NULL  COMMENT '//修改时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=160 ;

--
-- 转存表中的数据 `yufu_tuan`
--

分析数据表,修改字段属性

功能分析:展示规定时间内的商品
	时间:now - 上架时间:time  >  5天
	那么不展示
	
分析插入语句:insert
INSERT INTO `yufu_tuan` (
`id`, 
`catid`, 
`mallid`, 
`sitetitle`, 
`keywords`, 
`description`, 
`title`, 
`sourceurl`, 
`price`, 
`hdprice`, 
`starttime`, 
`endtime`, 
`buyurl`, 
`buynum`, 
`thumb`, 
`monthsale`, 
`brand`, 
`content`, 
`xihuan`, 
`ding`, 
`cai`, 
`chaozhi`, 
`yibanzhi`, 
`buzhi`, `baoyou`, `qtth`, `asfh`, `jfbgwdx`, `yfx`, `jstk`, `thbzk`, `smth`, `hits`, `listorder`, `status`, `create_time`, `update_time`) VALUES
(158, 54, 1, '', '', '', '映之妮2014圆领早秋新款女修身韩版大码女装上衣中袖雪纺衫潮', 'http://detail.tmall.com/item.htm?spm=a1z10.1.w5003-8086907850.8.KUFLcz&id=38855649316&rn=fdcf9471587ff8877341eae7a7f40f90&scene=taobao_shop', 333.00, 222.00, 0, 0, '', NULL, '/2014/10/21/54461ea3ae315.jpg', 0, '映之妮', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 4, 0, 1, 1413881507, 1413881507),
(159, 54, 1, '', '', '', '映之妮2014圆领早秋新款女修身韩版大码女装上衣中袖雪纺衫潮', 'http://detail.tmall.com/item.htm?spm=a1z10.1.w5003-8086907850.8.KUFLcz&id=38855649316&rn=fdcf9471587ff8877341eae7a7f40f90&scene=taobao_shop', 333.00, 222.00, 0, 0, '', NULL, '/2014/10/21/54461ea3ae315.jpg', 0, '映之妮', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 0, 1, 1413881507, 1413881507),
(
160, 
54, 
1, 
'自定义title：如果title为空，默认用标题作为title内容', 
'关键词1,关键词2 关键词3', 
'网页Meta标签的description处显示,此处会显示在商品页的本商品页面!', 
'这里是标题这里是标题这里是标题这里是标题', 
'http://detail.tmall.com/item.htm?spm=a1z10.1002.w4949-9186599678.3.BmbHyf&id=41014369486', 
333.00, 
2222.00, 
1414941360, 
1415546160, 
'http://detail.tmall.com/item.htm?id=41014369486', 
NULL, 
'/2014/11/02/54564b7e30cb0.jpg', 
987, 
'INSUN/恩裳', 
'<p class="attr-list-hd tm-clear" style="padding:5px 20px;line-height:22px;color:#999999;font-family:tahoma, arial, 微软雅黑, sans-serif;font-size:12px;background-color:#ffffff;margin-top:0px;margin-bottom:0px;"><p class="attr-list-hd tm-clear" style="padding:5px 20px;line-height:22px;color:#999999;font-family:tahoma, arial, 微软雅黑, sans-serif;font-size:12px;background-color:#ffffff;margin-top:0px;margin-bottom:0px;"><span style="margin:0px;padding:0px;font-weight:700;float:left;">产品参数：</span></p><ul id="J_AttrUL" style="margin:0px;padding:0px 20px 18px;list-style:none;zoom:1;border-top-width:1px;border-top-style:solid;border-top-color:#ffffff;color:#404040;font-family:tahoma, arial, 微软雅黑, sans-serif;font-size:12px;line-height:18px;background-color:#ffffff;"><li title=" 是" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>是否商场同款: 是</p></li><li title=" 自主实拍图" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>主图来源: 自主实拍图</p></li><li title=" 94270585" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>货号: 94270585</p></li><li title=" 修身" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>服装版型: 修身</p></li><li title=" 通勤" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>风格: 通勤</p></li><li title=" OL风格" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>通勤: OL风格</p></li><li title=" 七分袖" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>袖长: 七分袖</p></li><li title=" 蝙蝠袖" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>袖型: 蝙蝠袖</p></li><li title=" 圆领" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>领型: 圆领</p></li><li title=" 套头" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>衣门襟: 套头</p></li><li title=" 纯色" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>图案: 纯色</p></li><li id="J_attrBrandName" title=" INSUN/恩裳" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>品牌: INSUN/恩裳</p></li><li title=" 30%及以下" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>成分含量: 30%及以下</p></li><li title=" 其他" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>质地: 其他</p></li><li title=" 2014年秋季" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>年份季节: 2014年秋季</p></li><li title=" 白色 红色 黑色 粉色" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>颜色分类: 白色 红色 黑色 粉色</p></li><li title=" 36 38 40 42 44" style="margin:10px 15px 0px 0px;padding:0px;display:inline;float:left;width:220px;height:18px;overflow:hidden;vertical-align:top;text-overflow:ellipsis;color:#666666;"><p>尺码: 36 38 40 42 44</p></li></ul><span style="margin:0px;padding:0px;font-weight:700;float:left;"><br /></span></p>'
, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 
1414941566, 
1414941566);


(
161, 
55, 
1, '自定义title：如果title为空，默认用标题作为title内容', '关键词1,关键词2 关键词3', '网页Meta标签的description处显示,此处会显示在商品页的本商品页面!', '女短靴艾欧兰2014秋冬新款磨砂真皮甜美马丁靴简约女鞋粗高跟靴子', 'http://detail.tmall.com/item.htm?spm=a1z10.1002.w4946-8864426498.3.odGl30&id=40211881632', 333.00, 222.00, 1414941780, 1415546580, 'http://detail.tmall.com/item.htm?spm=a1z10.1002.w4946-8864426498.3.odGl30&id=40211881632', NULL, '/2014/11/02/54564d267176b.jpg', 0, 'INSUN/恩裳', '<p><span style="margin:0px;padding:0px;font-weight:700;color:#999999;font-family:tahoma, arial, 微软雅黑, sans-serif;font-size:12px;line-height:22px;background-color:#ffffff;">产品参数：</span><br /></p><p><span style="margin:0px;padding:0px;font-weight:700;color:#999999;font-family:tahoma, arial, 微软雅黑, sans-serif;font-size:12px;line-height:22px;background-color:#ffffff;"><img src="http://img02.taobaocdn.com/imgextra/i2/1646548397/TB2sEAvaFXXXXbfXpXXXXXXXXXX_!!1646548397.jpg_.webp" /><br /></span></p>', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1414941990, 1414941990);

分析页面:tuan/index.html
	图片链接到--淘客链接
		淘客链接通过:商品详情页得到

修改图片链接地址:
	将本地uploads的链接改为数据库中的链接(图片外链)
