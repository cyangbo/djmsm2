<?php

class SubjectAction extends CommonAction{
    //过滤查询字段
    function _filter(&$map){
        $map['status']=array('eq',1);
    }

    public function add() {
        if($_POST){
            
            //判断登录状态
            if(!session('?account')){
                $this->ajaxReturn(U('Member/login'),'未登录',0);
            }
            
            //印象码
            $YinXiangMa_response=  $this->YinXiangMa_ValidResult(@$_POST['YinXiangMa_challenge'],@$_POST['YXM_level'][0],@$_POST['YXM_input_result']);
            if($YinXiangMa_response !== "true") {
                $this->ajaxReturn('验证码错误','验证码错误',0);
            }
            
            //敏感词过滤
            $Badword=D('Badword');
            $Badwordlist=$Badword->select();
            foreach ($Badwordlist as $key => $value) {
                if($value['level']==1){
                    $_POST['title']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['title']);
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['content']);
                }else{
                    $_POST['title']=preg_replace('/'.$value['badword'].'/i','', $_POST['title']);
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i','', $_POST['content']);
                }

            }
            //站点设置
            $Set=D('Set')->find();
            
            
            $name = $this->getActionName();
            $model = D($name);
            if (false === $model->create()) {
                $this->ajaxReturn($model->getError(),'发表失败',0);
            }
            $model->memberid=  session('id');
            $model->membername=  session('account');
            if($Set['subject']){
                $model->status=  2;
                $info=",您发表的主题需要审核才能显示";
            }else{
                $model->status=  1;
                $info='';
            }
            //保存当前数据对象
            $list = $model->add();
            if ($list !== false) { //保存成功
                
                if(session('?_curUrl_')){
                    $this->ajaxReturn(session('_curUrl_'),$info,1);
                }else{
                    $this->ajaxReturn(Cookie::get('_curUrl_'),$info,1);
                }
                
            } else {
                //失败提示
                $this->ajaxReturn('','发表失败',0);
            }
            
            
        }else{
            $cate=new CategoryModel();
            $menu =$cate->getMyCategory1(); //加载栏目
            $menu = arrToMenu($menu,80);  
            $this->list=$menu;
            
            $this->seo('发表主题', '', '', $positioin);
            $this->display();
        }
        
    }
    //编辑
    public function edit() {
        if($_POST){
            
            //判断登录状态
            if(!session('?account')){
                $this->ajaxReturn(U('Member/login'),'未登录',0);
            }
            
            //印象码
            $YinXiangMa_response=  $this->YinXiangMa_ValidResult(@$_POST['YinXiangMa_challenge'],@$_POST['YXM_level'][0],@$_POST['YXM_input_result']);
            if($YinXiangMa_response !== "true") {
                $this->ajaxReturn('验证码错误','验证码错误',0);
            }
            
            //敏感词过滤
            $Badword=D('Badword');
            $Badwordlist=$Badword->select();
            foreach ($Badwordlist as $key => $value) {
                if($value['level']==1){
                    $_POST['title']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $this->_post('title'));
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $this->_post('content'));
                }else{
                    $_POST['title']=preg_replace('/'.$value['badword'].'/i','', $this->_post('title'));
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i','', $this->_post('content'));
                }

            }
            //站点设置
            $Set=D('Set')->find();
            
            $name = $this->getActionName();
            $model = D($name);
            if (false === $model->create()) {
                $this->ajaxReturn($model->getError(),'发表失败',0);
            }
            if($Set['subject']){
                $model->status=  2;
                $info=",您发表的主题需要审核才能显示";
            }else{
                $model->status=  1;
                $info='';
            }
            //保存当前数据对象
            $list = $model->save();
            if ($list !== false) { //保存成功
                
                if(session('?_curUrl_')){
                    $this->ajaxReturn(session('_curUrl_'),$info,1);
                }else{
                    $this->ajaxReturn(Cookie::get('_curUrl_'),$info,1);
                }
                
            } else {
                //失败提示
                $this->ajaxReturn('','发表失败',0);
            }
            
            
        }else{
            $cate=new CategoryModel();
            $menu =$cate->getMyCategory1(); //加载栏目
            $menu = arrToMenu($menu,80);  
            $this->list=$menu;
            $map['status']=array('eq',1);
            $name = $this->getActionName();
            $model = M($name);
            $id = $_REQUEST [$model->getPk()];
            $vo = $model->where($map)->getById($id);
            $this->assign('data', $vo);
            
            $this->seo('发表主题', '', '', $positioin);
            $this->display();
        }
    }
    //删除
    public function del() {
        //删除指定记录
        $name = $this->getActionName();
        $model = M($name);
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];
            if (isset($id)) {
                $condition = array($pk => array('in', explode(',', $id)));
                $list = $model->where($condition)->setField('status', - 1);
                if ($list !== false) {
                    if(session('?_curUrl_')){
                        $this->success('删除成功！',session('_curUrl_'));
                    }else{
                        $this->success('删除成功！',Cookie::get('_curUrl_'));
                    }
                } else {
                    $this->error('删除失败！');
                }
            } else {
                $this->error('非法操作');
            }
        }
    }
    
}

?>
