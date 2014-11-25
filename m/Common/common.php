<?php
//将数组转化为树形数组   
 function arrToTree($data,$pid){  
        foreach($data as $k => $v){  
            if($v['pid'] == $pid){  
                $id.=arrToTree($data,$v['id']);  
                $id.=$v['id'].',';                

            }  
        }  
         return $id;
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
//公共函数
function toDate($time, $format = 'Y-m-d H:i:s') {
	if (empty ( $time )) {
		return '';
	}
	$format = str_replace ( '#', ':', $format );
	return date ($format, $time );
}
