<?php

class MessageAction extends CommonAction{
    public function index() {
       if(IS_POST){
           
            $ip=get_client_ip();
            $time=time();
            $map['ip']=array('eq',$ip);
            
            $Set=D('Set')->find();
            
            $model = D('Message');
            $Message=$model->where($map)->order('id desc')->find();
            if($time-$Message['create_time']<$Set['messageinterval']){
                $this->error('每条留言需间隔'.($Set['messageinterval']/60).'分钟!');
            }
            
            if ($vo = $model->create()) {
                
                //保存当前数据对象
                $list = $model->add();
                if ($list !== false) { 
                    $this->ajaxReturn($vo,'留言成功！', 1);
                } else {
                    //失败提示
                    $this->error('留言失败!');
                }
            }else{
                $this->error($model->getError());
            }
            
       }else{
           $this->display();
       }
    }
}

?>
