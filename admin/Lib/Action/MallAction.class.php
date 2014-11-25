<?php
class MallAction extends CommonAction {
    //过滤查询字段
    function _filter(&$map){
        $map['mallname'] = array('like',"%".$_POST['name']."%");
    }
    
    public function _before_edit(){
        $Group=new MallgroupModel();
        $this->assign('grouplist',$Group->getMyGroup());
    }
    public function _before_add(){
        $Group=new MallgroupModel();
        $this->assign('grouplist',$Group->getMyGroup());
    }
    public function _before_insert() {
        //自动匹配商家网站域名
        $_POST['malldomain']=  get_domain($this->_post('mallurl'));
        //title标签默认设置
        if(empty($_POST['title'])){
            $_POST['title']=  $this->_post('mallname');
        }
    }
    public function _before_update() {
        //自动匹配商家网站域名
        $_POST['malldomain']=  get_domain($this->_post('mallurl'));
        //title标签默认设置
        if(empty($_POST['title'])){
            $_POST['title']=  $this->_post('mallname');
        }
        //处理删除logo
        $src='../Uploads'.$_POST['thumbdel'];
        if(is_file($src)){
            unlink($src);
            $_POST['thumb']="";
        }
    }
    
}
?>