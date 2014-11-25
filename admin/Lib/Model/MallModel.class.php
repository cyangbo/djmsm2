<?php
class MallModel extends CommonModel {
    // 自动验证设置
    protected $_validate=array(
        array('mallname','require','商家名称必填'),
        array('mallurl','require','商家网址必填'),
    );
    // 自动填充设置
    protected $_auto=array(
        array('create_time','time',self::MODEL_BOTH,'function'),
    );
    //获取商家
    public function getMyMall(){
        $map['status']=array('egt',0);
        $Mall=D('Mall');
        $list=$Mall->where($map)->select();
        return $list;
    }

}
?>