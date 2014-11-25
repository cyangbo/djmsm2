<?php

class ProductAction extends CommonAction{
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
        }
        if(isset($_POST['catid'])){
            $map['catid']=  array('eq',$_POST['catid']);
        }
        
        $map['title'] = array('like',"%".$_POST['name']."%");
    }
    public function _before_index() {
        if(isset($_GET['catid'])){
            $this->catid=$_GET['catid'];
        }
        if(isset($_POST['catid'])){
            $this->catid=$_POST['catid'];
        }
    }
    public function _before_add() {
        if(isset($_GET['id'])){
            $this->catid=$_GET['id'];
        }
        $Mall=new MallModel();
        $this->malllist=$Mall->getMyMall();//加载商家
        //淘客验证
        $this->loadtk();
    }
     function edit() {
        $name = $this->getActionName();
        $model = M($name);
        $id = $_REQUEST [$model->getPk()];
        $vo = $model->getById($id);
        if(!empty($vo['thumb'])){
            $vo['thumb']=explode('#',$vo['thumb']);
        }

        $Mall=new MallModel();
        $this->malllist=$Mall->getMyMall();//加载商家
        
        //淘客验证
        $this->loadtk();
        
        $this->assign('vo', $vo);
        $this->display();
    }
    public function insert() {
        //包邮
        if(empty($_POST['baoyou'])){
            $_POST['baoyou']=0;
        }else{
            $_POST['baoyou']=1;
        }
        
        //按时发货
        if(empty($_POST['asfh'])){
            $_POST['asfh']=0;
        }else{
            $_POST['asfh']=1;
        }
        //极速退款
        if(empty($_POST['jstk'])){
            $_POST['jstk']=0;
        }else{
            $_POST['jstk']=1;
        }
        //退货保障卡
        if(empty($_POST['thbzk'])){
            $_POST['thbzk']=0;
        }else{
            $_POST['thbzk']=1;
        }
        //上门退货
        if(empty($_POST['smth'])){
            $_POST['smth']=0;
        }else{
            $_POST['smth']=1;
        }
        //七天退换
        if(empty($_POST['qtth'])){
            $_POST['qtth']=0;
        }else{
            $_POST['qtth']=1;
        }
        //集分宝购物抵现
        if(empty($_POST['jfbgwdx'])){
            $_POST['jfbgwdx']=0;
        }else{
            $_POST['jfbgwdx']=1;
        }
        //运费险
        if(empty($_POST['yfx'])){
            $_POST['yfx']=0;
        }else{
            $_POST['yfx']=1;
        }
        //推荐位
        if(empty($_POST['tuijian'])){
            $_POST['tuijian']=0;
        }else{
            $_POST['tuijian']=1;
        }
        if(empty($_POST['zhiding'])){
            $_POST['zhiding']=0;
        }else{
            $_POST['zhiding']=1;
        }

        //活动时间
        $_POST['starttime']=strtotime($_POST['starttime']);
        $_POST['endtime']=strtotime($_POST['endtime']);
        
        
        //敏感词过滤
        
        $Badword=D('Badword');
        $Badwordlist=$Badword->select();
        foreach ($Badwordlist as $key => $value) {
            if($value['level']==1){
                $_POST['content']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['content']);
            }else{
                $_POST['content']=preg_replace('/'.$value['badword'].'/i','', $_POST['content']);
            }

        }
        $_POST['content']= str_replace(__ROOT__.'/admin/Tpl/Public/ueditor/php/../../../../../Uploads/', __ROOT__.'/Uploads/', $_POST['content']);
        
        //上传图片
        $this->_uploadthumb();

        //本地图片
        foreach ($_POST['thumb'] as $key => $value) {
            $thumb.=$value."#";
        }
        if(strlen($thumb)>0){
            $thumb=  substr($thumb, 0,  strlen($thumb)-1);
            $_POST['thumb']=$thumb;
        }else{
            $_POST['thumb']="";
        }

        $name = $this->getActionName();
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        //保存当前数据对象
        $list = $model->add();
        if ($list !== false) { //保存成功
            $this->assign('jumpUrl', Cookie::get('_currentUrl_'));
            $this->success('新增成功!');
        } else {
            //失败提示
            $this->error('新增失败!');
        }
    }
    public function update() {

        //包邮
        if(empty($_POST['baoyou'])){
            $_POST['baoyou']=0;
        }else{
            $_POST['baoyou']=1;
        }
        
        //按时发货
        if(empty($_POST['asfh'])){
            $_POST['asfh']=0;
        }else{
            $_POST['asfh']=1;
        }
        //极速退款
        if(empty($_POST['jstk'])){
            $_POST['jstk']=0;
        }else{
            $_POST['jstk']=1;
        }
        //退货保障卡
        if(empty($_POST['thbzk'])){
            $_POST['thbzk']=0;
        }else{
            $_POST['thbzk']=1;
        }
        //上门退货
        if(empty($_POST['smth'])){
            $_POST['smth']=0;
        }else{
            $_POST['smth']=1;
        }
        //七天退换
        if(empty($_POST['qtth'])){
            $_POST['qtth']=0;
        }else{
            $_POST['qtth']=1;
        }
        //集分宝购物抵现
        if(empty($_POST['jfbgwdx'])){
            $_POST['jfbgwdx']=0;
        }else{
            $_POST['jfbgwdx']=1;
        }
        //运费险
        if(empty($_POST['yfx'])){
            $_POST['yfx']=0;
        }else{
            $_POST['yfx']=1;
        }
        
        //推荐位
        if(empty($_POST['tuijian'])){
            $_POST['tuijian']=0;
        }else{
            $_POST['tuijian']=1;
        }
        if(empty($_POST['zhiding'])){
            $_POST['zhiding']=0;
        }else{
            $_POST['zhiding']=1;
        }
        
        //活动时间
        $_POST['starttime']=strtotime($_POST['starttime']);
        $_POST['endtime']=strtotime($_POST['endtime']);
        
        
        //敏感词过滤
        
        $Badword=D('Badword');
        $Badwordlist=$Badword->select();
        foreach ($Badwordlist as $key => $value) {
            if($value['level']==1){
                $_POST['content']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['content']);
            }else{
                $_POST['content']=preg_replace('/'.$value['badword'].'/i','', $_POST['content']);
            }

        }
        $_POST['content']= str_replace(__ROOT__.'/admin/Tpl/Public/ueditor/php/../../../../../Uploads/', __ROOT__.'/Uploads/', $_POST['content']);
       
        //上传图片
        $this->_uploadthumb();
        
        //本地图片
        foreach ($_POST['thumb'] as $key => $value) {
            $thumb.=$value."#";
        }
        if(strlen($thumb)>0){
            $thumb=  substr($thumb, 0,  strlen($thumb)-1);
            $_POST['thumb']=$thumb;
        }else{
            $_POST['thumb']="";
        }

        $name = $this->getActionName();
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        // 更新数据
        $list = $model->save();
        if (false !== $list) {
            //成功提示
            $this->assign('jumpUrl', Cookie::get('_currentUrl_'));
            $this->success('编辑成功!');
        } else {
            //错误提示
            $this->error('编辑失败!');
        }
    }
    
    
    
    
}

?>
