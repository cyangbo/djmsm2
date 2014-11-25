<?php
// 后台用户模块
class MemberAction extends CommonAction {
    
    //空间主页
    public function space() {
        
        if(isset($_GET['u'])){
            $u=  $this->_get('u');
            if(!empty($u)){
                
                $map['membername']=array('eq',$u);
                $map['modelname']=array('eq','Product');
                $tablePrefix= C(DB_PREFIX);//表前缀
                
                //Ta的评论
                $Comment  =   M('Comment');
                $commentlist   = $Comment->where($map)->group('modelname,objectid')->order($tablePrefix.'comment.create_time desc')->join(array($tablePrefix.'product ON '.$tablePrefix.'product.id = '.$tablePrefix.'comment.objectid'))->select();
                foreach ($commentlist as $key => $value) {
                    if(isset($value["thumb"])){
                        $commentlist[$key]["thumb"]=explode("#", $value["thumb"]);
                    }
                    if(isset($value['chaozhi'])){
                        $commentlist[$key]["zongzhi"]=$value['chaozhi']+$value['yibanzhi']+$value['buzhi'];
                        $commentlist[$key]["zhi"]=$value['chaozhi']+$value['yibanzhi'];
                    }
                }
                $this->assign("commentlist", $commentlist);
                
                //Ta的收藏
                $Collect   =   M('Collect');
                $collectlist   = $Collect->where($map)->group('modelname,objectid')->order($tablePrefix.'collect.create_time desc')->join(array($tablePrefix.'product ON '.$tablePrefix.'product.id = '.$tablePrefix.'collect.objectid'))->select();
                foreach ($collectlist as $key => $value) {
                    if(isset($value["thumb"])){
                        $collectlist[$key]["thumb"]=explode("#", $value["thumb"]);
                    }
                    if(isset($value['chaozhi'])){
                        $collectlist[$key]["zongzhi"]=$value['chaozhi']+$value['yibanzhi']+$value['buzhi'];
                        $collectlist[$key]["zhi"]=$value['chaozhi']+$value['yibanzhi'];
                    }
                }
                $this->assign("collectlist", $collectlist);
                
                
            }
        }
        
        $this->seo('Ta的首页','','', $position);
        $this->display();
    }
    //Ta的评论
    public function tacomment() {
     
        if(isset($_GET['u'])){
            $u=  $this->_get('u');
            if(!empty($u)){
                $map['membername']=array('eq',$u);
                $map['modelname']=array('eq','Product');
                $name = 'Comment';

                //获取分页设置
                $Model=M('Model');
                $map['table']=array('eq',$name);
                $pageinfo=$Model->where($map)->find();

                $Form   =   M($name);
                import("@.ORG.Page");       //导入分页类
                $count  = $Form->where($map)->count();    //计算总数
        //        $Page = new Page($count, $pageinfo['listrows']);

                $Page = new Page($count, 20);

                $tablePrefix= C(DB_PREFIX);//表前缀
                $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->group('modelname,objectid')->order($tablePrefix.'comment.create_time desc')->join(array($tablePrefix.'product ON '.$tablePrefix.'product.id = '.$tablePrefix.'comment.objectid'))->select();
             
                foreach ($list as $key => $value) {
                    if(isset($value["thumb"])){
                        $list[$key]["thumb"]=explode("#", $value["thumb"]);
                    }
                    if(isset($value['chaozhi'])){
                        $list[$key]["zongzhi"]=$value['chaozhi']+$value['yibanzhi']+$value['buzhi'];
                        $list[$key]["zhi"]=$value['chaozhi']+$value['yibanzhi'];
                    }
                }

                // 设置分页显示
                $page = $Page->show();

                $this->assign("page", $page);
                $this->assign("list", $list);

            }
        }
        
        $this->seo('Ta的评论','','', $position);
        $this->display();
    }
    //Ta的收藏
    public function tacollect() {
        if(isset($_GET['u'])){
            $u=  $this->_get('u');
            if(!empty($u)){
                $map['membername']=array('eq',$u);
                $map['modelname']=array('eq','Product');
                $name = 'Collect';

                //获取分页设置
                $Model=M('Model');
                $map['table']=array('eq',$name);
                $pageinfo=$Model->where($map)->find();

                $Form   =   M($name);
                import("@.ORG.Page");       //导入分页类
                $count  = $Form->where($map)->count();    //计算总数
        //        $Page = new Page($count, $pageinfo['listrows']);

                $Page = new Page($count, 20);

                $tablePrefix= C(DB_PREFIX);//表前缀
                $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->group('modelname,objectid')->order($tablePrefix.'collect.create_time desc')->join(array($tablePrefix.'product ON '.$tablePrefix.'product.id = '.$tablePrefix.'collect.objectid'))->select();

                foreach ($list as $key => $value) {
                    if(isset($value["thumb"])){
                        $list[$key]["thumb"]=explode("#", $value["thumb"]);
                    }
                    if(isset($value['chaozhi'])){
                        $list[$key]["zongzhi"]=$value['chaozhi']+$value['yibanzhi']+$value['buzhi'];
                        $list[$key]["zhi"]=$value['chaozhi']+$value['yibanzhi'];
                    }
                }

                // 设置分页显示
                $page = $Page->show();

                $this->assign("page", $page);
                $this->assign("list", $list);

            }
        }
        
        $this->seo('Ta的收藏','','', $position);
        $this->display();
    }
    //Ta的主题
    public function tasubject() {
        if(isset($_GET['u'])){
            $u=  $this->_get('u');
            if(!empty($u)){
                $map['membername']=array('eq',$u);
                $map['modelname']=array('eq','Subject');
                $map['status']=array('eq',1);
                $name = 'Subject';

                $Form   =   M($name);
                import("@.ORG.Page");       //导入分页类
                $count  = $Form->where($map)->count();    //计算总数

                $Page = new Page($count, 20);

                $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('create_time desc')->select();

            
                // 设置分页显示
                $page = $Page->show();

                $this->assign("page", $page);
                $this->assign("list", $list);

            }
        }
        Cookie::set('_curUrl_', __SELF__);
        session('_curUrl_', __SELF__);
        $this->seo('Ta的主题','','', $position);
        $this->display();
    }
    //Ta的关注
    public function tafollow() {
        if(isset($_GET['u'])){
            $u=  $this->_get('u');
            if(!empty($u)){
                $map['membername']=array('eq',$u);
                $name = 'Memberfollow';

                $Form   =   M($name);
                import("@.ORG.Page");       //导入分页类
                $count  = $Form->where($map)->count();    //计算总数
                
                $Page = new Page($count, 40);

                $tablePrefix= C(DB_PREFIX);//表前缀
                $list   = $Form->join(array($tablePrefix.'member ON '.$tablePrefix.'member.account = '.$tablePrefix.'memberfollow.followname'))->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order($tablePrefix.'memberfollow.create_time desc')->select();

                // 设置分页显示
                $page = $Page->show();

                $this->assign("page", $page);
                $this->assign("list", $list);

            }
        }
        
        $this->seo('Ta的关注','','', $position);
        $this->display();
    }
    //Ta的访客
    public function tavisit() {
        if(isset($_GET['u'])){
            $u=  $this->_get('u');
            if(!empty($u)){
                $map['membername']=array('eq',$u);
                $name = 'Membervisit';

                $Form   =   M($name);
                import("@.ORG.Page");       //导入分页类
                $count  = $Form->where($map)->count();    //计算总数
                
                $Page = new Page($count, 40);

                $tablePrefix= C(DB_PREFIX);//表前缀
                $list   = $Form->join(array($tablePrefix.'member ON '.$tablePrefix.'member.account = '.$tablePrefix.'membervisit.visitname'))->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order($tablePrefix.'membervisit.create_time desc')->select();

                // 设置分页显示
                $page = $Page->show();

                $this->assign("page", $page);
                $this->assign("list", $list);

            }
        }
        
        $this->seo('Ta的访客','','', $position);
        $this->display();
    }
    
    // 会员登录
    public function login() {
        if(session('?account')) {
            $this->redirect('Member/index');
        }else{
            $this->seo('会员登录', '', '', $positioin);
            $this->display();
        }
    }
     //登录验证
    public function checkLogin() {
        //验证码
        if(isset($_POST['verify'])){
           if($_SESSION['verify'] != md5($_POST['verify'])) {
                $this->error('验证码错误！');
            } 
        }else{
            //印象码
            $YinXiangMa_response=  $this->YinXiangMa_ValidResult(@$_POST['YinXiangMa_challenge'],@$_POST['YXM_level'][0],@$_POST['YXM_input_result']);
            if($YinXiangMa_response !== "true") {
                $this->ajaxReturn('验证码错误','验证码错误',0);
            }
        }
        
        //生成认证条件
        $map=array();
        // 支持使用绑定帐号登录
        $map['account']	= $_POST['account'];
        $map["status"]=array('eq',1);
        
        $Member=M('Member');
        $authInfo=$Member->where($map)->find();
        
        //使用用户名、密码和状态的方式进行认证
        if(false == $authInfo) {
            $this->error('用户名或密码错误！');
        }else {
            if($authInfo['password'] != md5($_POST['password'])) {
                $this->error('用户名或密码错误！');
            }
            $_SESSION['id']=$authInfo['id'];
            $_SESSION['account']=$authInfo['account'];
            $_SESSION['nickname']=$authInfo['nickname'];
            $_SESSION['email']=$authInfo['email'];
            $_SESSION['lastLoginTime']=$authInfo['last_login_time'];
            $_SESSION['login_count']=$authInfo['login_count'];

            //保存登录信息
            $User=M('Member');
            $ip=get_client_ip();
            $time=time();
            $data = array();
            $data['id']=$authInfo['id'];
            $data['last_login_time']=$time;
            $data['login_count']=array('exp','login_count+1');
            $data['last_login_ip']=$ip;
            $User->save($data);
            
            if(session('?_curUrl_')){
                $this->success('登录成功！', session('_curUrl_'));
            }else{
                $this->success('登录成功！', Cookie::get('_curUrl_'));
            }
            

        }
    }
    //会员退出
    public function logout() {
        if(isset($_SESSION['account'])) {
            unset($_SESSION['account']);
//            $this->redirect('Member/index');
            $this->success('退出成功！', U('Index/index'));
        }else {
            $this->error('已经退出！');
        }
    }
     //会员注册
    public function register() {
        if(session('?account')) {
            $this->redirect('Member/index');
        }else{
            $this->seo('会员注册', '', '', $positioin);
            $this->display();
        }
    }
    //注册验证
    public function checkRegister() {
        //印象码
        $YinXiangMa_response=  $this->YinXiangMa_ValidResult(@$_POST['YinXiangMa_challenge'],@$_POST['YXM_level'][0],@$_POST['YXM_input_result']);
        if($YinXiangMa_response !== "true") {
            $this->ajaxReturn('验证码错误','验证码错误',0);
        }

        if(!preg_match('/^[a-zA-Z0-9_]{3,30}$/i',$_POST['account'])) {
            $this->error( '用户名必须是字母、下划线、数字组成，且3位以上！');
        }
        // 创建数据对象
        $User=D("Member");
        if(!$User->create()) {
            $this->error($User->getError());
        }else{
            $User->password	=md5($_POST['password']);
            //写入帐号数据
            if($result =$User->add()) {
                $this->success('注册成功！');
            }else{
                $this->error('注册失败！');
            }
        }
    }
    //帐号验证
    public function checkAccount() {

        if(!preg_match('/^[a-zA-Z0-9_]{3,30}$/i',$_POST['account'])) {
            $this->error( '用户名必须是字母、下划线、数字组成，且3位以上！');
        }
        
        $User = M("Member");
        //检测用户名是否冲突
        $name  =  $_REQUEST['account'];
        $result  =  $User->getByAccount($name);
        if($result) {
            $this->error('很抱歉，用户名已经存在！');
        }else {
            $this->success('恭喜您，用户名可以使用！');
        }
    }
    //验证登录状态
    protected function checkUser() {
        if(!session('?account')) {
            $this->assign('jumpUrl','Member/login');
            $this->error('没有登录');
        }
    }
     //会员中心
    public function index() {
        $this->checkUser();
        $map['id']=array('eq',$_SESSION['id']);
        $Member=M('Member');
        $data=$Member->where($map)->find();
        $this->data=$data;

        $this->seo('会员中心', '', '', $positioin);
        $this->display();
        
    }
    //会员资料显示
    public function information() {
        $this->checkUser();
        $User=M("Member");
        $udata=$User->getById($_SESSION['id']);
        $this->assign('udata',$udata);
       
        $this->seo('修改资料', '', '', $positioin);
        $this->display();
    }
    //修改资料
    public function checkInformation() {
        $this->checkUser();
        $this->_upload();
        $id=I('id',0,'intval');
        $thumb=I('thumb');
        $nickname=I('nickname');
        $email=I('email');
        $sign=I('sign');
        
        
        $User=D("Member");
        $data=array(
            'thumb'=>$thumb,
            'nickname'=>$nickname,
            'email'=>$email,
            'sign'=>$sign
        );
        $result	=$User->where(array('id'=>$id))->save($data);
        if(false !== $result) {
            $this->success('资料修改成功！');
        }else{
            $this->error('资料修改失败!');
        }
    }
    //修改密码
    public function password() {
        $this->seo('修改密码', '', '', $positioin);
        $this->display();
    }
    //更换密码
    public function checkPassword() {
	$this->checkUser();
    
        //印象码
        $YinXiangMa_response=  $this->YinXiangMa_ValidResult(@$_POST['YinXiangMa_challenge'],@$_POST['YXM_level'][0],@$_POST['YXM_input_result']);
        if($YinXiangMa_response !== "true") {
            $this->ajaxReturn('验证码错误','验证码错误',0);
        }
        
        $map=array();
        $map['password']= pwdHash($_POST['oldpassword']);
        if(isset($_SESSION['id'])) {
            $map['id']=$_SESSION['id'];
        }
        //检查用户
        $User=M("Member");
        if(!$User->where($map)->field('id')->find()) {
            $this->error('旧密码输入错误！');
        }else {
            $User->password=pwdHash($_POST['password']);
            $User->save();
            $this->success('密码修改成功！');
         }
    }
    //验证码
    public function verify() {
        $type=isset($_GET['type'])?$_GET['type']:'gif';
        import("@.ORG.Util.Image");
        Image::buildImageVerify(4,1,$type);
    }
    

}
?>