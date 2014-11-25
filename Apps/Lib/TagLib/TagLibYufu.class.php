<?php
//import('TagLib');
class TagLibYufu extends TagLib {
   //标签定义
   protected $tags=array(
       'category'=>array('attr'=>'catid,result','level'=>1),
       'content'=>array('attr'=>'catid,result','level'=>1),
       'article'=>array('attr'=>'catid,field,order,num,result','level'=>1),
       'product'=>array('attr'=>'catid,field,order,num,result','level'=>1),
       'download'=>array('attr'=>'catid,field,order,num,result','level'=>1),
       'photo'=>array('attr'=>'catid,field,order,num,result','level'=>1),
       'other'=>array('attr'=>'settag,result','close'=>0),
       'set'=>array('attr'=>'settag,result','close'=>0),
       'advert'=>array('attr'=>'settag,result','close'=>0),
       'announce'=>array('attr'=>'catid,field,order,num,result','level'=>1),
       'search'=>array('attr'=>'field,order,num,result','level'=>1),
       'tuan'=>array('attr'=>'catid,field,order,num,result','level'=>1),
       'quan'=>array('attr'=>'catid,field,order,num,result','level'=>1),
       'slide'=>array('attr'=>'field,order,num,result','level'=>1),
       'subject'=>array('attr'=>'catid,field,order,num,result','level'=>1),
   );
    //栏目分类标签
   public function _category($attr,$content) {
        $tag=$this->parseXmlAttr($attr, 'category');
        $result= !empty($tag['result'])?$tag['result']: 'category';
        
        if(isset($tag['catid'])){
            $catid=$tag['catid'];
            $catlist = D('Category')->where('status=1')->select();	
            $idlist = $catid.','.getChildId($catlist,$catid);  
            $idlist= substr($idlist, 0, strlen($idlist)-1);
        }
        
        $map="'status=1";
        $map.=($catid)?" and id in ($idlist)'":"'";
        $sql ='M(\'Category\')->where('.$map.')->order(\'level,listorder\')->select()';

        //下面拼接输出语句
        $parsestr = '<?php $_result='.$sql.';';
        $parsestr .= 'foreach($_result as $key=>$'.$result.'):?>';
        $parsestr .= $content;//解析在article标签中的内容
        $parsestr .= '<?php endforeach;?>';
        return  $parsestr;

   }
   //单页内容标签
   public function _content($attr,$content) {
        $tag=$this->parseXmlAttr($attr, 'content');
       
        $result= !empty($tag['result'])?$tag['result']: 'content';
        
        $map.="'status=1";
        $map.=($tag['catid'])?" and id={$tag['catid']}'":"'";
        
        $sql ="M('Category')->";
        $sql.="where({$map})->";
        $sql.="find()";

        //下面拼接输出语句
        $parsestr  = '<?php $'.$result.'=$_result='.$sql.';?>';
        $parsestr .= $content;//解析在article标签中的内容
        return  $parsestr;

   }
   //文章模型标签
   public function _article($attr,$content) {
        $tag=$this->parseXmlAttr($attr, 'article');
       
        $result= !empty($tag['result'])?$tag['result']: 'article';
        
        $catlist = D('Category')->where('status=1')->select();	
        $idlist = $tag['catid'].','.getChildId($catlist,$tag['catid']);  
        $idlist= substr($idlist, 0, strlen($idlist)-1);
        
        
        $map.="'status=1";
        $map.=($tag['catid'])?" and catid in ($idlist)'":"'";
        
        $sql ="M('Article')->";
        $sql.="where({$map})->";
        $sql.=($tag['field'])?"field('{$tag['field']}')->":"";
        $sql.=($tag['order'])?"order('{$tag['order']}')->":"";
        $sql.=($tag['num'])?"limit({$tag['num']})->":"";
        $sql.="select()";

        //下面拼接输出语句
        $parsestr  = '<?php $_result='.$sql.';';
        $parsestr .= 'foreach($_result as $key=>$'.$result.'):?>';
        $parsestr .= '<?php $'.$result.'["thumb"]=explode("#", $'.$result.'["thumb"]); ?>';
        $parsestr .= $content;//解析在article标签中的内容
        $parsestr .= '<?php endforeach;?>';
        return  $parsestr;

   }
   
   //产品模型标签
   public function _product($attr,$content) {
        $tag=$this->parseXmlAttr($attr, 'product');
     
        $result= !empty($tag['result'])?$tag['result']: 'product';
        
        $catlist = D('Category')->where('status=1')->select();	
        $idlist = $tag['catid'].','.getChildId($catlist,$tag['catid']);  
        $idlist= substr($idlist, 0, strlen($idlist)-1);
        
        $map.="'status=1";
        $map.=($tag['catid'])?" and catid in ($idlist)'":"'";
        
        $sql ="M('Product')->";
        $sql.="where({$map})->";
        $sql.=($tag['field'])?"field('{$tag['field']}')->":"";
        $sql.=($tag['order'])?"order('{$tag['order']}')->":"";
        $sql.=($tag['num'])?"limit({$tag['num']})->":"";
        $sql.="select()";

        //下面拼接输出语句
        $parsestr  = '<?php $_result='.$sql.';';
        $parsestr .= 'foreach($_result as $key=>$'.$result.'):?>';
        $parsestr .= '<?php $'.$result.'["thumb"]=explode("#", $'.$result.'["thumb"]); ?>';
        $parsestr .= $content;//解析在article标签中的内容
        $parsestr .= '<?php endforeach;?>';
        return  $parsestr;
        
   }
   //产品模型标签
   public function _tuan($attr,$content) {
        $tag=$this->parseXmlAttr($attr, 'tuan');
     
        $result= !empty($tag['result'])?$tag['result']: 'tuan';
        
        $catlist = D('Category')->where('status=1')->select();	
        $idlist = $tag['catid'].','.getChildId($catlist,$tag['catid']);  
        $idlist= substr($idlist, 0, strlen($idlist)-1);
        
        $map.="'status=1";
        $map.=($tag['catid'])?" and catid in ($idlist)'":"'";
        
        $sql ="M('Tuan')->";
        $sql.="where({$map})->";
        $sql.=($tag['field'])?"field('{$tag['field']}')->":"";
        $sql.=($tag['order'])?"order('{$tag['order']}')->":"";
        $sql.=($tag['num'])?"limit({$tag['num']})->":"";
        $sql.="select()";

        //下面拼接输出语句
        $parsestr  = '<?php $_result='.$sql.';';
        $parsestr .= 'foreach($_result as $key=>$'.$result.'):?>';
        $parsestr .= '<?php $'.$result.'["thumb"]=explode("#", $'.$result.'["thumb"]); ?>';
        $parsestr .= $content;//解析在article标签中的内容
        $parsestr .= '<?php endforeach;?>';
        return  $parsestr;
        
   }
   //产品模型标签
   public function _quan($attr,$content) {
        $tag=$this->parseXmlAttr($attr, 'quan');
     
        $result= !empty($tag['result'])?$tag['result']: 'quan';
        
        $catlist = D('Category')->where('status=1')->select();	
        $idlist = $tag['catid'].','.getChildId($catlist,$tag['catid']);  
        $idlist= substr($idlist, 0, strlen($idlist)-1);
        
        $map.="'status=1";
        $map.=($tag['catid'])?" and catid in ($idlist)'":"'";
        
        $sql ="M('Quan')->";
        $sql.="where({$map})->";
        $sql.=($tag['field'])?"field('{$tag['field']}')->":"";
        $sql.=($tag['order'])?"order('{$tag['order']}')->":"";
        $sql.=($tag['num'])?"limit({$tag['num']})->":"";
        $sql.="select()";

        //下面拼接输出语句
        $parsestr  = '<?php $_result='.$sql.';';
        $parsestr .= 'foreach($_result as $key=>$'.$result.'):?>';
        $parsestr .= '<?php $'.$result.'["thumb"]=explode("#", $'.$result.'["thumb"]); ?>';
        $parsestr .= $content;//解析在article标签中的内容
        $parsestr .= '<?php endforeach;?>';
        return  $parsestr;
        
   }
   //下载模型标签
   public function _download($attr,$content) {
        $tag=$this->parseXmlAttr($attr, 'download');
       
        $result= !empty($tag['result'])?$tag['result']: 'download';
        
        $catlist = D('Category')->where('status=1')->select();	
        $idlist = $tag['catid'].','.getChildId($catlist,$tag['catid']);  
        $idlist= substr($idlist, 0, strlen($idlist)-1);
        
        
        $map.="'status=1";
        $map.=($tag['catid'])?" and catid in ($idlist)'":"'";
        
        $sql ="M('Dowonload')->";
        $sql.="where({$map})->";
        $sql.=($tag['field'])?"field('{$tag['field']}')->":"";
        $sql.=($tag['order'])?"order('{$tag['order']}')->":"";
        $sql.=($tag['num'])?"limit({$tag['num']})->":"";
        $sql.="select()";

        //下面拼接输出语句
        $parsestr  = '<?php $_result='.$sql.';';
        $parsestr .= 'foreach($_result as $key=>$'.$result.'):?>';
        $parsestr .= $content;//解析在article标签中的内容
        $parsestr .= '<?php endforeach;?>';
        return  $parsestr;

   }
   //图片模型标签
   public function _photo($attr,$content) {
        $tag=$this->parseXmlAttr($attr, 'photo');
       
        $result= !empty($tag['result'])?$tag['result']: 'photo';
        
        $catlist = D('Category')->where('status=1')->select();	
        $idlist = $tag['catid'].','.getChildId($catlist,$tag['catid']);  
        $idlist= substr($idlist, 0, strlen($idlist)-1);
        
        
        $map.="'status=1";
        $map.=($tag['catid'])?" and catid in ($idlist)'":"'";
        
        $sql ="M('Photo')->";
        $sql.="where({$map})->";
        $sql.=($tag['field'])?"field('{$tag['field']}')->":"";
        $sql.=($tag['order'])?"order('{$tag['order']}')->":"";
        $sql.=($tag['num'])?"limit({$tag['num']})->":"";
        $sql.="select()";

        //下面拼接输出语句
        $parsestr  = '<?php $_result='.$sql.';';
        $parsestr .= 'foreach($_result as $key=>$'.$result.'):?>';
        $parsestr .= $content;//解析在article标签中的内容
        $parsestr .= '<?php endforeach;?>';
        return  $parsestr;

   }
  
   //扩展功能标签
   public function _other($attr) {

        $tag=$this->parseXmlAttr($attr, 'other');
       
        $result= !empty($tag['result'])?$tag['result']: 'other';

        $map.=($tag['settag'])?"settag=\"{$tag['settag']}\"":"'";
        
        $sql ="M('Other')->";
        $sql.="where('{$map}')->";
        $sql.="find()";

        //下面拼接输出语句
        $parsestr  = '<?php $'.$result.'=$_result='.$sql.'; echo $'.$result.'[\'setvalue\'];?>';
        //$parsestr .= $content;//解析在article标签中的内容
        return  $parsestr;

   }
      //定义查询数据库标签
   public function _set($attr) {

        $tag=$this->parseXmlAttr($attr, 'set');
       
        $result= !empty($tag['result'])?$tag['result']: 'set';

//        $map.=($tag['settag'])?"settag=\"{$tag['settag']}\"":"'";
        $Field=($tag['settag'])?"{$tag['settag']}":"id";
        
        $sql ="M('Set')->";
        $sql.="getField('{$Field}',1)";
        //下面拼接输出语句
        $parsestr  = '<?php $'.$result.'=$_result='.$sql.'; echo $'.$result.';?>';
        //$parsestr .= $content;//解析在article标签中的内容
        return  $parsestr;

   }
   //广告标签
   public function _advert($attr) {

        $tag=$this->parseXmlAttr($attr, 'settag');
       
        $result= !empty($tag['result'])?$tag['result']: 'advert';
        
        $map.=($tag['settag'])?"adtag=\"{$tag['settag']}\"":"'";
        
        $sql ="M('Advert')->";
        $sql.="where('{$map}')->";
        $sql.="find()";

        $time=time();
        
        //下面拼接输出语句
        $parsestr  = '<?php $'.$result.'=$_result='.$sql.'; ';
        $parsestr  .= 'if($'.$result.'[\'timelimit\']==0):';
            $parsestr  .= 'echo $'.$result.'[\'adcontent\'];';
         $parsestr  .= 'else:';
            $parsestr  .= 'if($'.$result.'[\'endtime\']>='.$time.'):';
            $parsestr  .= 'echo $'.$result.'[\'adcontent\'];';
            $parsestr  .= 'else:';
            $parsestr  .= 'echo $'.$result.'[\'adpastcontent\'];';
            $parsestr  .= 'endif;';
        $parsestr  .= 'endif;';

        $parsestr  .= '?>';
        //$parsestr .= $content;//解析在article标签中的内容
        return  $parsestr;

   }
    //公告标签
   public function _announce($attr,$content) {
        $tag=$this->parseXmlAttr($attr, 'announce');
        
        $result= !empty($tag['result'])?$tag['result']: 'announce';
        
        $time=date('Y-m-d H:i:s',time());
        $map.="status=1";
        $map.=(" and endtime >= \"$time\"");
        $sql ="M('Announce')->";
        $sql.="where('{$map}')->";
        $sql.=($tag['field'])?"field('{$tag['field']}')->":"";
        $sql.=($tag['order'])?"order('{$tag['order']}')->":"";
        $sql.=($tag['num'])?"limit({$tag['num']})->":"";
        $sql.="select()";

        //下面拼接输出语句
        $parsestr  = '<?php $_result='.$sql.';';
        $parsestr .= 'foreach($_result as $key=>$'.$result.'):?>';
        $parsestr .= $content;//解析在article标签中的内容
        $parsestr .= '<?php endforeach;?>';
        return  $parsestr;

   }
   //定义查询数据库标签
   public function _search($attr,$content) {
        $tag=$this->parseXmlAttr($attr, 'search');
       
        $result= !empty($tag['result'])?$tag['result']: 'search';

        $map.="'status=1'";

        $sql ="M('Search')->";
        $sql.="where({$map})->";
        $sql.=($tag['field'])?"field('{$tag['field']}')->":"";
        $sql.=($tag['order'])?"order('{$tag['order']}')->":"";
        $sql.=($tag['num'])?"limit({$tag['num']})->":"";
        $sql.="select()";

        //下面拼接输出语句
        $parsestr  = '<?php $_result='.$sql.';';
        $parsestr .= 'foreach($_result as $key=>$'.$result.'):?>';
        $parsestr .= $content;//解析在article标签中的内容
        $parsestr .= '<?php endforeach;?>';
        return  $parsestr;

   }
   //定义查询数据库标签
   public function _slide($attr,$content) {
        $tag=$this->parseXmlAttr($attr, 'slide');
       
        $result= !empty($tag['result'])?$tag['result']: 'slide';

        $map.="'status=1'";

        $sql ="M('Slide')->";
        $sql.="where({$map})->";
        $sql.=($tag['field'])?"field('{$tag['field']}')->":"";
        $sql.=($tag['order'])?"order('{$tag['order']}')->":"";
        $sql.=($tag['num'])?"limit({$tag['num']})->":"";
        $sql.="select()";

        //下面拼接输出语句
        $parsestr  = '<?php $_result='.$sql.';';
        $parsestr .= 'foreach($_result as $key=>$'.$result.'):?>';
        $parsestr .= $content;//解析在article标签中的内容
        $parsestr .= '<?php endforeach;?>';
        return  $parsestr;

   }
   
   //主题模型标签
   public function _subject($attr,$content) {
        $tag=$this->parseXmlAttr($attr, 'subject');
       
        $result= !empty($tag['result'])?$tag['result']: 'subject';
        
        $catlist = D('Category')->where('status=1')->select();	
        $idlist = $tag['catid'].','.getChildId($catlist,$tag['catid']);  
        $idlist= substr($idlist, 0, strlen($idlist)-1);
        
        
        $map.="'status=1";
        $map.=($tag['catid'])?" and catid in ($idlist)'":"'";
        
        $sql ="M('subject')->";
        $sql.="where({$map})->";
        $sql.=($tag['field'])?"field('{$tag['field']}')->":"";
        $sql.=($tag['order'])?"order('{$tag['order']}')->":"";
        $sql.=($tag['num'])?"limit({$tag['num']})->":"";
        $sql.="select()";

        //下面拼接输出语句
        $parsestr  = '<?php $_result='.$sql.';';
        $parsestr .= 'foreach($_result as $key=>$'.$result.'):?>';
        $parsestr .= $content;//解析在article标签中的内容
        $parsestr .= '<?php endforeach;?>';
        return  $parsestr;

   }
   
   
   
   
}

?>
