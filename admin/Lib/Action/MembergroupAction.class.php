<?php

class MembergroupAction extends CommonAction {
    function _filter(&$map){
        $map['status'] = array('egt',0);
        $map['name'] = array('like',"%".$_POST['name']."%");
    }
    
    public function add() {
        if (IS_POST) {
            $name = $this->getActionName();
            $model = D($name);
            if (false === $model->create()) {
                //IS_AJAX && $this->ajaxReturn(0, $model->getError());
                $this->error($model->getError());
            }
            //保存当前数据对象
            $list = $model->add();
            if ($list !== false) { //保存成功
                //IS_AJAX && $this->ajaxReturn(1,'新增成功!', '', 'add');
                $this->assign('jumpUrl', Cookie::get('_currentUrl_'));
                $this->success('新增成功!');
            } else {
                //IS_AJAX && $this->ajaxReturn(0, '新增失败!');
                //失败提示
                $this->error('新增失败!');
            }

        }else{
            
            if (IS_AJAX) { 
                $response = $this->fetch();
                $data['status'] = 1;
                $data['data'] = $response;
                $this->ajaxReturn($data,'JSON');

            } else {
                $this->display();
            }
        }
                 
    }
    public function _before_edit(){
        $Group = D('Membergroup');
        //查找满足条件的列表数据
        $list= $Group->field('id,name')->select();
        $this->assign('list',$list);
    }
    
    
}
?>