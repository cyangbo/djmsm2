<?php

class SubjectAction extends CommonAction{
    function _initialize() {
        import('@.ORG.Util.Cookie');
        //检查认证识别号
        if (!$_SESSION [C('USER_AUTH_KEY')]) {
            //跳转到认证网关
            redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
        }
    }
    //过滤查询字段
    function _filter(&$map){
        if(isset($_GET['catid'])){
            $map['catid']=  array('eq',$_GET['catid']);
            $this->catid=$_GET['catid'];
        }
        if(isset($_POST['catid'])){
            $map['catid']=  array('eq',$_POST['catid']);
            $this->catid=$_POST['catid'];
        }
        
        if(!empty($_POST['name'])){
            $map['title'] = array('like',"%".$_POST['name']."%");
        }
        if(isset($_POST['zt'])&&$_POST['zt']!=-2){
            $map['status'] = array('eq',$_POST['zt']);
            $this->zt=$_POST['zt'];
        }
    }
    public function _before_index() {
        if(isset($_GET['catid'])){
            $this->catid=$_GET['catid'];
        }
    }
    public function _before_add() {
        if(isset($_GET['id'])){
            $this->catid=$_GET['id'];
        }
    }
    

   
    
}

?>
