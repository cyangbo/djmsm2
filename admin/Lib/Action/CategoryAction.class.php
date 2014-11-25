<?php

class CategoryAction extends CommonAction{
    //过滤查询字段
    function _filter(&$map){
        $map['catname'] = array('like',"%".$_POST['name']."%");
    }
    public function index() {
        //列表过滤器，生成查询Map对象
        $map = $this->_search();
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        
        $cate=new CategoryModel();
        $menu =$cate->getMyCategory1(); //加载栏目
        $menu = arrToMenu($menu,0);  
        $this->list=$menu;
        Cookie::set('_currentUrl_', __SELF__);
        $this->display();  
    }
    public function _before_add() {
        if(isset($_GET['id'])){
            $current_pid=$_GET['id'];
        }
        if(isset($_GET['model'])){
            $current_modelname=$_GET['model'];
        }
        $cate=new CategoryModel();
        $menu =$cate->getMyCategory1(); //加载栏目
        $menu = arrToMenu($menu,0);  
        $this->list=$menu;
        $this->mdldata=$cate->getMyModel();//加载模型
        
        $this->current_pid=$current_pid;
        $this->current_modelname=$current_modelname;
    }
    public function _before_edit() {
        $cate=new CategoryModel();
        $menu =$cate->getMyCategory1(); //加载栏目
        $menu = arrToMenu($menu,0);  
        $this->list=$menu;
        $this->mdldata=$cate->getMyModel();//加载模型
        
    }
    function insert() {
        $this->_upload();
        
        $name = $this->getActionName();
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $map['id'] = $_POST['pid'];
        $level=$model->where($map)->getField('level');
        $model->level = $level+1;
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
    function update() {
        $this->_upload();
        
        $name = $this->getActionName();
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        
       
        
//        $model->level = $level+1;
        
        // 更新数据
        $list = $model->save();
        if (false !== $list) {
            
            //获取它的父级的层级
            $map['id'] = $_POST['pid'];
            $level=$model->where($map)->getField('level');
       
            //在父级的层级上加1就是子级的层级
            $mapid['id'] = $_POST['id'];
            $model->where($mapid)->setField('level', $level+1);

            //循环当前分类的所以子级
            $cate=new CategoryModel();
            $menu =$cate->getMyCategory1(); //加载栏目
            $menu = arrToMenu($menu,$_POST['id']);  
            foreach ($menu as $value) {
                
                $map['id'] = $value['pid'];
                $level=$model->where($map)->getField('level');
                
                $mapid['id'] = $value['id'];
                $model->where($mapid)->setField('level', $level+1);
            }
            
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
