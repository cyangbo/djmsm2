<?php
class TuanModel extends CommonModel {
    // 自动验证设置
    protected $_validate =array(
        array('title','require','标题必填！',1),
//        array('content','require','内容必填'),
        array('title','','标题已经存在',0,'unique',self::MODEL_INSERT),
    );
    // 自动填充设置
    protected $_auto=array(
        array('xihuan','0',self::MODEL_INSERT),
        array('ding','0',self::MODEL_INSERT),
        array('cai','0',self::MODEL_INSERT),
        array('chaozhi','0',self::MODEL_INSERT),
        array('yibanzhi','0',self::MODEL_INSERT),
        array('buzhi','0',self::MODEL_INSERT),
        array('hits','0',self::MODEL_INSERT),
        array('status','1',self::MODEL_INSERT),
        array('create_time','time',self::MODEL_INSERT,'function'),
        array('update_time','time',self::MODEL_BOTH,'function'),
    );
    

}
?>