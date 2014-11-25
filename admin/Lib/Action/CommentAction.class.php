<?php
class CommentAction extends CommonAction {
	//过滤查询字段
	function _filter(&$map){
            
            if(!empty($_POST['name'])){
                $map['content'] = array('like',"%".$_POST['name']."%");
            }
            if(isset($_POST['zt'])&&$_POST['zt']!=-2){
                $map['status'] = array('eq',$_POST['zt']);
                $this->zt=$_POST['zt'];
            }
	}
}
?>