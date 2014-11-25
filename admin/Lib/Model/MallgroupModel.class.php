<?php
class MallgroupModel extends CommonModel {
    // 自动验证设置
    protected $_validate=array(
        array('groupname','require','分组名称必填'),
    );
    // 自动填充设置
    protected $_auto=array(
        array('status','1',self::MODEL_INSERT),
        array('create_time','time',self::MODEL_BOTH,'function'),
    );
    function getMyGroup(){
        $map['status']  = array('egt',0);
        $Group = D('Mallgroup');
        //查找满足条件的列表数据
        $list= $Group->where($map)->field('id,groupname')->select();
        return $list;
    }
}
?>