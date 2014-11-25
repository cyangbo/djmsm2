<?php
/**
 * 自动获取商品信息
 */
class Autogetinfo {
    private $_mallid = 0;
    private $_url="";
            
    function __construct($mallid,$url)
    {
        $this->_mallid=$mallid;
        $this->_url=$url;
    }
   
    function getInfo()
    {
        
        //方法1
        $contents = file_get_contents(htmlspecialchars_decode($this->_url)); 
        switch ($this->_mallid) {
            case 1:
                //如果出现中文乱码使用下面代码 
                $contents = iconv("gbk", "utf-8",$contents);  //把gbk 转化为utf-8
                
                //标题
                preg_match('/<h3 data-spm="\d+">[\w\W]*?(?=<\/h3>)/i',$contents,$title);
                $title=preg_replace('/<h3.*?>/i',"", $title);
                $title=preg_replace('/<a.*?>|<\/a>/i',"", $title);
                $title=trim($title[0]);

                //图片
                preg_match_all('/(?<=\<li class=\"tb-selected\" style\=\"background-image:url\().*(?=\))/i',$contents,$img);
                foreach ($img as $value) {
                    $imgarr[]=str_replace("_60x60.jpg","", $value);//图片
                }
                
                preg_match_all('/(?<=\<li  style\=\"background-image:url\().*(?=\))/i',$contents,$img1);
                foreach ($img1 as $value) {
                    $imgarr1[]=str_replace("_60x60.jpg","", $value);//图片
                }
                $imglist=  array_merge($imgarr[0],$imgarr1[0]);

                //原价格
                preg_match('/(?<=<strong id="J_StrPrice" >).*?(?=<\/strong>)/i',$contents,$price);
                $price=trim($price[0]);
                
                //促销价格
                preg_match('/(?<=id="J_SpanLimitProm">).*?(?=<\/strong>)/i',$contents,$hdprice);
                $hdprice=trim($hdprice[0]);
                
                //月销量
                preg_match('/(?<=<span>月 销 量：<\/span><em>)\d+(?=<\/em>)/i', $contents,$sale);
                $sale=trim($sale[0]);
                
                //品牌
                preg_match('/(?<=品牌:)[\w\W]*?(?=<\/li>)/i', $contents,$brand);
                $brand=preg_replace('/&nbsp;/i',"", $brand);
                $brand=mb_decode_numericentity($brand[0] ,array(0,0xffffff,0,0xffffff),'utf-8');
                $brand=trim($brand);
                
                //按时发货
                preg_match('/<em>商品:<\/em>[\w\W]*?<\/a>/i', $contents,$asfh);
                if(strpos( $asfh[0],'按时发货')){
                    $asfh=  'true';
                }else{
                    $asfh=  'false';
                }
                
                //极速退款
                preg_match('/<em>退款:<\/em>[\w\W]*?<\/li>/i', $contents,$jstk);
                if(strpos( $jstk[0],'极速退款')){
                    $jstk=  'true';
                }else{
                    $jstk=  'false';
                }
                
                //退货保障卡
                preg_match('/<em>退货:<\/em>[\w\W]*?<\/li>/i', $contents,$thbzk);
                if(strpos( $thbzk[0],'退货保障卡')){
                    $thbzk=  'true';
                }else{
                    $thbzk=  'false';
                }
                
                //上门退货
                preg_match('/<em>退货:<\/em>[\w\W]*?<\/li>/i', $contents,$smth);
                if(strpos( $smth[0],'上门退货')){
                    $smth=  'true';
                }else{
                    $smth=  'false';
                }
                $qtth=  'false';
                $yfx=  'false';
                $jfbgwdx=  'false';
                
                break;
            case 2:
                //如果出现中文乱码使用下面代码 
                $contents = iconv("gbk", "utf-8",$contents);  //把gbk 转化为utf-8
                
                //标题
                preg_match('/<div class=\"tb-detail-hd\">\s*<h3>[\w\W]*?(?=<\/h3>)/i',$contents,$title);
                $title=preg_replace('/<div class=\"tb-detail-hd\">\s*<h3>/i',"", $title);
                $title=preg_replace('/<span class=\"tb-double-tag\">.*?<\/span>/i',"", $title);
                $title=  trim($title[0]);
                
                //图片
                preg_match_all('/<a href=\"#\"><img\s*src=\"[\w\W]*?(?=\")/i',$contents,$img);
                foreach ($img as $value) {
                    $value=str_replace("<a href=\"#\"><img src=\"","", $value);//图片
                    $imglist=str_replace("_40x40.jpg","", $value);//图片
                }
                $buyurl="";
                //原价格
                preg_match('/(?<=<strong id=\"J_StrPrice\" ><em class=\"tb-rmb\">&yen;<\/em><em class=\"tb-rmb-num\">).*?(?=<\/em>)/i',$contents,$price);
                $price=  trim($price[0]);
                
                //促销价格
                preg_match('/(?<=id="J_SpanLimitProm">).*?(?=<\/strong>)/i',$contents,$hdprice);
                $hdprice=  trim($hdprice[0]);
                
                //月销量
                preg_match('/(?<=<span>月 销 量：<\/span><em>)\d+(?=<\/em>)/i', $contents,$sale);
                if(!empty($sale[0])){
                    $sale=  trim($sale[0]);
                }else{
                    $sale=  0;
                }
                
                //品牌
                preg_match('/(?<=品牌:)[\w\W]*?(?=<\/li>)/i', $contents,$brand);
                $brand=preg_replace('/&nbsp;/i',"", $brand);
                $brand=  trim($brand[0]);
                
                $asfh=  'false';
                $jstk=  'false';
                $thbzk=  'false';
                $smth=  'false';
                
                //七天退换
                preg_match('/<dt>服务:<\/dt>[\w\W]*?<\/p>/i', $contents,$qtth);
                if(strpos($qtth[0],'七天退换')){
                    $qtth=  'true';
                }else{
                    $qtth=  'false';
                }
                
                //运费险
                preg_match('/<dt>服务:<\/dt>[\w\W]*?<\/p>/i', $contents,$yfx);
                if(strpos( $yfx[0],'tb-service-traffic')){
                    $yfx=  'true';
                }else{
                    $yfx=  'false';
                }
                
                //支持集分宝购物抵现
                preg_match('/<dt>服务:<\/dt>[\w\W]*?<\/p>/i', $contents,$jfbgwdx);
                if(strpos( $jfbgwdx[0],'支持集分宝购物抵现')){
                    $jfbgwdx=  'true';
                }else{
                    $jfbgwdx=  'false';
                }
                
                
                break;
            case 3:

                break;

            default:
                break;
        }
        
        $arr = array (
            'title'=>$title,
            'webimglist'=>$imglist,//数组形式
            'buyurl'=>$buyurl,
            'price'=>$price,
            'hdprice'=>$hdprice,
            'sale'=>$sale,
            'brand'=>$brand,
            'asfh'=>$asfh,
            'jstk'=>$jstk,
            'thbzk'=>$thbzk,
            'smth'=>$smth,
            'qtth'=>$qtth,
            'yfx'=>$yfx,
            'jfbgwdx'=>$jfbgwdx,
        );
        return $arr;
    }
    
    
    
    
    
}

?>
