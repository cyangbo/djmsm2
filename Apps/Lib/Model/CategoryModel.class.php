<?php
class CategoryModel extends CommonModel {
    //获取栏目菜单
    public function getMyCategory1() {
        //读取数据库模块列表生成菜单项   
        $node = D ( "Category" );  
        $map ['status'] =array("egt",0); 
        $list = $node->where($map)->order( 'level,listorder' )->select();  
        return $list;
    }

}
?>