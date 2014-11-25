<?php
class QuanModel extends CommonModel {
    // 自动验证设置
    protected $_validate=array(
        array('title','require','标题必填'),
        array('buyurl','require','优惠券链接必填'),
    );
    // 自动填充设置
    protected $_auto=array(
        array('create_time','time',self::MODEL_BOTH,'function'),
    );
    

}
?>