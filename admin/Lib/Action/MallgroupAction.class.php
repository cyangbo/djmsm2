<?php
class MallgroupAction extends CommonAction {
	//过滤查询字段
	function _filter(&$map){
            $map['groupname'] = array('like',"%".$_POST['name']."%");
	}
        
}
?>