<?php
//创建订单
function createOrderId(){
    $time=date('YmdHis',time());
    $radnum=mt_rand(100,999);
    return $time.$radnum;
}
//ip定位
function IP($ip = '', $file = 'UTFWry.dat') {
    $_ip = array ();
    if (isset ( $_ip [$ip] )) {
            return $_ip [$ip];
    } else {
            import ( "ORG.Net.IpLocation" );
            $iplocation = new IpLocation ( $file );
            $location = $iplocation->getlocation ( $ip );
            $_ip [$ip] = $location ['country'] . $location ['area'];
    }
    return $_ip [$ip];
}
//获取所有子id
 function getChildId($data,$pid){  
    foreach($data as $k => $v){  
        if($v['pid'] == $pid){  
            $id.=getChildId($data,$v['id']);  
            $id.=$v['id'].','; 
        }  
    }  
    return $id;
 } 
 //使用递归将多维数组转化为一维数组
 function arrToMenu($data,$pid){  
    static $menu = array();  
    foreach($data as $k => $v){  
        if($v['pid'] == $pid){  
            $menu[] = $v; 
            $v['pid'] = arrToMenu($data,$v['id']);  
        }  
    }
    return $menu;  
 }
 //将数组转化为树形数组
 function arrToTree($data,$pid){  
    $tree = array();  
    foreach($data as $k => $v){  
        if($v['pid'] == $pid){  
            $v['pid'] = arrToTree($data,$v['id']);  
            $tree[] = $v;  
        }  
    }     

    return $tree;  
 } 
//根据ID获得分类名
function getCategoryName($id){
    if (empty ( $id )) {
            return '顶级分类';
    }
    $Category = D ( "Category" );
    $list = $Category->getField ( 'id,catname' );
    $name = $list [$id];
    return $name;
}
//根据ID获得模型名
function getModuleById($id){
    $Category = D ( "Category" );
    $list = $Category->getField ( 'id,modelname' );
    $module = $list [$id];
    return $module;
}
//根据会员ID获取会员名称
function getMemberName($id){
    if($id==0){
        $name = '游客';
    }else{
        $Member = D ( "Member" );
        $list = $Member->getField ( 'id,name' );
        $name = $list [$id];
    }
    return $name;
}
//根据会员ID获取会员头像
function getMemberLogo($id) {
    if($id==0){
        $name = '';
    }else{
        $Mall = D ( "Member" );
        $list = $Mall->getField ( 'id,thumb' );
        $name = $list [$id];
    }
    return $name;
}
//根据会员ID获取会员头像
function getMemberULogo($u) {
    
    if(empty($u)){
        $name = '';
    }else{
        $Mall = D ( "Member" );
        $map['account']=array('eq',$u);
        $list = $Mall->where($map)->find();
        
        $name = $list['thumb'];
    }
    return $name;
}

//根据ID获取商家名称
function getMallName($id){
    if($id==0){
        $name = '未知商家';
    }else{
        $Mall = D ( "Mall" );
        $list = $Mall->getField ( 'id,mallname' );
        $name = $list [$id];
    }
    return $name;
}
function getMallLogo($id) {
    if($id==0){
        $name = '';
    }else{
        $Mall = D ( "Mall" );
        $list = $Mall->getField ( 'id,thumb' );
        $name = $list [$id];
    }
    return $name;
}
//根据ID获取评论数
function getCommentCount($id,$table){
    $count=0;
    if(!empty($id)&&!empty($table)){
        $map['objectid']=array('eq',$id);
        $map['modelname']=array('eq',$table);
        $Comment = D ("Comment");
        $count = $Comment->where($map)->count();
    }
    return $count;
}
//根据用户名获取评论数
function getCommentNum($name,$table){
    $count=0;
    if(!empty($name)&&!empty($table)){
        $map['membername']=array('eq',$name);
        $map['modelname']=array('eq',$table);
        $Comment = D ("Comment");
        $count = $Comment->where($map)->count();
    }
    return $count;
}
//根据用户名获取收藏数
function getCollectNum($name,$table){
    $count=0;
    if(!empty($name)&&!empty($table)){
        $map['membername']=array('eq',$name);
        $map['modelname']=array('eq',$table);
        $Collect = D ("Collect");
        $count = $Collect->where($map)->count();
    }
    return $count;
}

//根据用户名获取访客数
function getSubjectNum($name){
    $count=0;
    if(!empty($name)){
        $map['membername']=array('eq',$name);
        $Subject = D ("Subject");
        $count = $Subject->where($map)->count();
        
    }
    return $count;
}
//根据用户名获取关注数
function getFollowNum($name){
    $count=0;
    if(!empty($name)){
        $map['followname']=array('eq',$name);
        $Memberfollow = D ("Memberfollow");
        $count = $Memberfollow->where($map)->count();
        
    }
    return $count;
}
//根据用户名获取访客数
function getVisitNum($name){
    $count=0;
    if(!empty($name)){
        $map['membername']=array('eq',$name);
        $Membervisit = D ("Membervisit");
        $count = $Membervisit->where($map)->count();
        
    }
    return $count;
}

//获取评论信息
function getCommentInfo($id,$table,$num){
    if(!empty($id)&&!empty($table)){
        $map['objectid']=array('eq',$id);
        $map['modelname']=array('eq',$table);
        $Comment = D ("Comment");
        if(!empty($num)){
           $list = $Comment->where($map)->order('create_time desc')->limit($num)->select();
        }else{
           $list = $Comment->where($map)->order('create_time desc')->select();
        }
    }
    return $list;
}
//公共函数
function toDate($time, $format = 'Y-m-d H:i:s') {
    if (empty ( $time )) {
            return '';
    }
    $format = str_replace ( '#', ':', $format );
    return date ($format, $time );
}
//MD5
function pwdHash($password, $type = 'md5') {
    return hash ( $type, $password );
}
//订单状态
function getOrderStatus($status, $imageShow = false) {
    switch ($status) {
        case - 1 :
                $showText = '删除';
                $showImg = '<img src="__PUBLIC__/Images/del.gif" width="20" height="20" border="0" alt="删除">';
                break;
        case 0 :
                $showText = '退货';
                $showImg = '<img src="__PUBLIC__/Images/locked.gif" width="20" height="20" border="0" alt="退货">';
                break;
        case 1 :
                $showText = '<span style="color:#0066CC;">已发货</span>';
                $showImg = '<img src="__PUBLIC__/Images/ok.gif" width="20" height="20" border="0" alt="已发货">';
                break;
        case 2 :
                $showText = '<strong style="color:#0066CC;">未发货</strong>';
                $showImg = '<img src="__PUBLIC__/Images/prected.gif" width="20" height="20" border="0" alt="未发货">';
                break;
        case 3 :
                $showText = '<strong style="color:#487C09;">交易完成</strong>';
                $showImg = '<img src="__PUBLIC__/Images/prected.gif" width="20" height="20" border="0" alt="交易完成">';
                break;
        default :
                $showText = '<span style="color:#0066CC;">已发货</span>';
                $showImg = '<img src="__PUBLIC__/Images/ok.gif" width="20" height="20" border="0" alt="已发货">';

    }
    return ($imageShow === true) ?  $showImg  : $showText;

}




