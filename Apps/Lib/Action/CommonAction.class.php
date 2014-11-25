<?php
/*前台动作基类*/
class CommonAction extends Action {
    //初始化
    function _initialize(){
        header("Content-Type:text/html; charset=utf-8");
        import('@.ORG.Util.Cookie');
        
        //栏目导航
        $nav_list = D('Category')->where('pid=0 AND status=1')->order('listorder')->select();
        if(is_array($nav_list)){
            foreach ($nav_list as $key=>$val){
                
                $nav_list[$key] = $this->changurl($val,$val['catdir']);//地址转化
                $nav_list[$key]['sub_nav'] = D('Category')->where('pid='.$val['id'].' AND status=1')->select();
                foreach ($nav_list[$key]['sub_nav'] as $key2=>$val2){
                    $nav_list[$key]['sub_nav'][$key2] = $this->changurl($val2,$val2['catdir']);
                }
            }
        }
        $this->assign('nav_list',$nav_list);
        
        //每日流量统计
        $tjdate=D('Tjdate');
        $map['create_date']=array('eq',date('Ymd',time()));
        $vl=$tjdate->where($map)->find();
        if($vl){
            $tjdate->id=$vl['id'];
            $tjdate->create_num=$vl['create_num']+1;
            $tjdate->save();
        }else{
            $tjdate->create_date=date('Ymd',time());
            $tjdate->create_num=1;
            $tjdate->add();
        }
        
        //页面流量统计
        $tjurl=D('Tjurl');
        $map['create_url']=__SELF__;
        $vla=$tjurl->where($map)->find();
        if($vla){
            $tjurl->id=$vla['id'];
            $tjurl->create_num=$vla['create_num']+1;
            $tjurl->save();
        }else{
            $tjurl->create_url=__SELF__;
            $tjurl->create_num=1;
            $tjurl->add();
        }
        //获取用户
        if(isset($_GET['u'])){
            $u=  $this->_get('u');
            if(!empty($u)){
                $this->u=$u;
                
                //记录访客
                if(session('?account')){
                    $membername=$u;
                    $visitname=session('account');
                    if(!empty($membername)&&!empty($visitname)&&$membername!=$visitname){
                        
                        $mapvisit["membername"]=array('eq',$membername);
                        $mapvisit["visitname"]=array('eq',$visitname);
                        $Membervisit=M('Membervisit');
                        $mvInfo=$Membervisit->where($mapvisit)->find();
                        
                        $mvvo['membername']=$membername;
                        $mvvo['visitname']=$visitname;
                        $mvvo['create_time']=time();
                        
                        if($mvInfo){
                            $mvvo['id']=$mvInfo['id'];
                            $mvvo['visitnum']=$mvInfo['visitnum']+1;
                            $mvresult = $Membervisit->save($mvvo);
                        }else{
                            $mvvo['visitnum']=1;
                            $mvresult = $Membervisit->add($mvvo);
                        }
                        
                    }
                }
                
                //显示最近访客
                $tablePrefix= C(DB_PREFIX);//表前缀
                $Membervisit=M('Membervisit');
                $mapmembervisit['membername']=array('eq',$u);
                $mvlist=$Membervisit->join(array($tablePrefix.'member ON '.$tablePrefix.'member.account = '.$tablePrefix.'membervisit.visitname'))->where($mapmembervisit)->order($tablePrefix.'membervisit.create_time desc')->select();
                $this->mvlist=$mvlist;
                
                //显示个性签名
                $mapmember['account']=array('eq',$u);
                $Member=M('Member');
                $memberdata=$Member->where($mapmember)->find();
                $this->memberdata=$memberdata;

            }
        }
        
        //印象码
        define("PRIVATE_KEY","f8e0e8a892f46bfddff0255da50fd46e");
        $this->YXM_PUBLIC_KEY="b20672750e25c094064ddc29ec6b8de9";
        $this->YXM_localsec_url=(is_ssl()?'https://':'http://').$_SERVER['HTTP_HOST'].__ROOT__."/Data/localsec/";
        //站点设置
        $this->sitename=C(SITE_NAME);//站点名称
        $this->domain=C(DOMAIN_NAME);//站点域名
        $this->time=  time();

    }
   
    //SEO赋值
    public function seo($title,$keywords,$description,$positioin){
    	$this->assign('title',$title);
    	$this->assign('keywords',$keywords);
    	$this->assign('description',$description);
    	$this->assign('position',$positioin);
    }

    //URL转换
    public function changurl($ary,$catdir){
    	if(is_array($ary)){
            if(key_exists('modelname', $ary)){
                if(empty($catdir)){
                    $ary['url']=U($ary['modelname'].'/index/',array('id'=>$ary['id']));
                }else{
                    $ary['url']=U($ary['modelname'].'/'.$catdir.'/',array('id'=>$ary['id']));
                }
                
            }
            return $ary;
        }		
    }
    
    public function index() {
        
        //所有分类
        $node = D ( "Category" );  
        $mapcat ['status'] =array("egt",0); 
        $allcatlist = $node->where($mapcat)->order( 'level,listorder' )->select();
        $categorylist=arrToTree($allcatlist,0);
        $this->categorylist=$categorylist;
        
        //所有商家
        $Mall= D ( "Mall" );  
        $mapmall ['status'] =array("egt",0); 
        $malllist = $Mall->where($mapmall)->order( 'listorder' )->select();
        $this->malllist=$malllist;
        
        //where条件
        if(method_exists($this, '_filter')){
            $this->_filter($map);
        }

        //获取分类
        $id = $this->_get('id');
        $catdata = D('Category')->where('status=1')->find($id);	

        //获取所有子类id
        $catlist = D('Category')->where('status=1')->select();	
        $idlist = $id.','.getChildId($catlist,$id);  
        $idlist= substr($idlist, 0, strlen($idlist)-1);
        $map['catid'] = array('in',$idlist);

        //排序
        if(isset($_GET['sort'])){
            $sort=  $this->_get('sort');
            if(!empty($sort)){
                switch ($sort) {
                    case 'pop':
                        
                        $order="tuijian desc, id desc";
                        break;
                    case 'news':
                        $order="update_time desc,create_time desc";
                        break;
                    case 'hot':
                        $order="hits desc";
                        break;
                    
                }
            }
        }
        $order=!empty($order)?$order:"id desc";
        
        //筛选
        if(isset($_GET['price'])){
            $price=  $this->_get('price');
            if(!empty($price)){
                if($price!='all'){
                    $pricelist=  explode(',', $price);
                    $minprice=$pricelist[0];
                    
                    $maxprice=$pricelist[1];
                    if(!empty($minprice)&&!empty($maxprice)){
                        $map['price']=array(array('gt',$minprice),array('lt',$maxprice));
                    }else if(!empty($minprice)&&empty($maxprice)){
                        $map['price']=array('gt',$minprice);
                    }else if(empty($minprice)&&!empty($maxprice)){
                        $map['price']=array('lt',$maxprice);
                    }
                    
                }
            }
        }
        //商家
        if(isset($_GET['mallid'])){
            $mallid=  $this->_get('mallid');
            if(!empty($mallid)){
                $map['mallid']=array('eq',$mallid);
                $this->mallid=$mallid;
            }
        }
        
        
        $name = $this->getActionName();
        
        //获取分页设置
        $Model=M('Model');
        $map['table']=array('eq',$name);
        $pageinfo=$Model->where($map)->find();

        $Form   =   M($name);
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数
        $Page = new Page($count, $pageinfo['listrows']);
        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order($order)->select();

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
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();
        
        $position=D('Common')->getPosition($id);
        foreach ($position as $value) {
            $title=$value['catname']."_".$title;
        }
        $title=  substr($title, 0, strlen($title)-1);
        
        $this->seo(($catdata['title'])?$catdata['title']:$title, ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), $position);
        
        $this->assign("id", $id);
        $this->assign("sort", $sort);
        $this->assign("price", $price);
        $this->assign("data", $catdata);
        $this->assign("page", $page);
        $this->assign("list", $list);
        Cookie::set('_curUrl_', __SELF__);
        session('_curUrl_', __SELF__);
        $this->display(); 
    }
    public function show()
    {
        $id= $this->_get('id');
        $name = $this->getActionName();
        
        $map['id']=array('eq',$id);
        
        D($name)->where($map)->setInc('hits',1);//浏览次数
       
        //where条件
        if(method_exists($this, '_filter')){
            $this->_filter($map);
        }
        
        $model=M($name);
        //当前记录
        $data=$model->where($map)->find();

        if(isset($data["thumb"])){
            $data["thumb"]=explode("#", $data["thumb"]);
        }
        
        $map['id']=array('lt',$id);
        //上一条记录
        $prevdata=$model->where($map)->order('id desc')->limit('1')->find();
        $map['id']=array('gt',$id);
        //下一条记录
        $nextdata=$model->where($map)->order('id asc')->limit('1')->find();

        //内链
        $Chain=D('Chain');
        $ChainMap['status']=array('eq',1);
        $Chainlist=$Chain->where($ChainMap)->select();
        foreach ($Chainlist as $value) {
            $data['content']=preg_replace('/'.$value['keyword'].'/i',"<a href=".$value['url']." target=".$value['target'].">".$value['keyword']."</a>", $data['content'],$value['number']);
        }

        //显示评论
        $Form = M("Comment");
        $Formmap['catid']=array('eq',$data['catid']);
        $Formmap['objectid']=array('eq',$id);
        $Formmap['status']=array('eq',1);
        
        $list = $Form->where($Formmap)->order('id desc')->limit(10)->select();  // 按照id排序显示前5条记录
        $this->assign('list', $list);
        $this->nowtime=  time();
        $this->data=$data;
        $this->prevdata=$prevdata;
        $this->nextdata=$nextdata;
        
        $position=D('Common')->getPosition($data['catid']);
        //SEO标题、关键字、描述
        if(isset($data['sitetitle'])){
            if(!empty($data['sitetitle'])){
                $title=$data['sitetitle'];
            }  else {
                $title=$data['title'];
            }
        }else{
            $title=$data['title'];
        }
        
        $this->seo($title, $data['keywords'], $data['description'], $position);
        Cookie::set('_curUrl_', __SELF__);
        session('_curUrl_', __SELF__);
        $this->display(); 
    }
    
    //隐藏其他域名使链接跳转
    public function link() {
        
        $id= $this->_get('id');
        if(!empty($id)){
            $name = $this->getActionName();
            $map['id']=array('eq',$id);

            $model=M($name);
            //当前记录
            $data=$model->where($map)->find();
            if(empty($data['buyurl'])){
                header('Location: '.$data['sourceurl']);
            }else{
                header('Location: '.$data['buyurl']);
            }
        }
        

    }
    
    //添加评论
    public function addcomment() {
        if(IS_POST){
            //登录检查
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
            foreach ($Badwordlist as $value) {
                if($value['level']==1){
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['content']);
                }else{
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i','', $_POST['content']);
                }
                
            }
            //站点设置
            $Set=D('Set')->find();
            
            //评论
            if($_POST['reply']==='0'){
                $_POST['pid']=0;
            }else{
                $_POST['pid']=$_POST['pid'];
            }
            
            $name = $this->getActionName();
            
            $_POST['memberid']=  session('id');
            $_POST['membername']=  session('account');
            $_POST['ip']=get_client_ip();
            $_POST['create_time']=time();
            
            $_POST['modelname']=$name;
            
            $model = D('Comment');
            $vo=$model->create();
            if (false=== $vo) {
                $this->ajaxReturn($model->getError(), '非法操作', 0);
            }
           
            if($Set['comment']){
                $model->status=  2;
                $info=",您发表的评论需要审核才能显示";
            }else{
                $model->status=  1;
                $info='';
            }
            //保存当前数据对象
            $list = $model->add();
            if ($list !== false) { 
                $vo['memberid'] = getMemberLogo($vo['memberid']);
                $vo['create_time'] = date('m月d日 H:i', $vo['create_time']);
                $vo['content'] = nl2br($vo['content']);
                //成功提示
                $this->ajaxReturn($vo, $info, 1);
            } else {
                //失败提示
                $this->ajaxReturn('提交失败', '提交失败', 0);
          
            }
        }
        
    }
    //删除图片
    public function delfile(){
        if(isset($_GET['id'])&&isset($_GET['file'])){
            $id = $_GET['id'];	
            $file=$_GET['file'];
            
            $name = $this->getActionName();
            $model = D($name);
            
            $src = '../Uploads/'.$model->where('id='.$id)->getField($file);
            $model->where('id='.$id)->setField($file,'');
            
            if(is_file($src))unlink($src);
            $this->success('操作成功');
        }
    }
    //加为收藏
    public function addCollect() {
        if(isset($_GET['id'])&&isset($_GET['catid'])){
            $id=  $this->_get('id');
            $catid=  $this->_get('catid');
            if(!empty($id)&&!empty($catid)){
                //登录检测
                if(!session('?account')){
                    $this->ajaxReturn(U('Member/login'),'未登录',0);
                }
                
                $name = $this->getActionName();
                
                $data['objectid']=$id;
                $data['catid']=$catid;
                $data['memberid']=  session('id');
                $data['membername']=  session('account');
                $data['ip']=get_client_ip();
                $data['create_time']=time();
                $data['status']=1;
                $data['modelname']=$name;

                $model = D('Collect');
                
                $map['modelname']=array('eq',$name);
                $map['objectid']=array('eq',$id);
                $dataCollect=$model->where($map)->find();
                if($dataCollect!==FALSE){
                    if(empty($dataCollect)){
                        //保存当前数据对象
                        $list = $model->add($data);
                        if ($list !== false) { 
                            //成功提示
                            $this->ajaxReturn('', '收藏成功', 1);
                        } else {
                            //失败提示
                            $this->ajaxReturn('', '收藏失败', 0);
                        }
                    }else{
                        $this->ajaxReturn('', '已收藏', 0);
                    }
                }else{
                    //失败提示
                    $this->ajaxReturn('', '收藏失败', 0);
                }  
            }
            
        }

    }
    //加关注
    public function addfollow() {
        //获取用户
        if(isset($_GET['u'])){
            $u=  $this->_get('u');
            if(!empty($u)){
                //登录检测
                if(!session('?account')){
                    $this->ajaxReturn(U('Member/login'),'未登录',0);
                }
                $membername=session('account');
                $followname=$u;
                if(!empty($membername)&&!empty($followname)){

                    if($membername!=$followname){
                        $mapfollow["membername"]=array('eq',$membername);
                        $mapfollow["followname"]=array('eq',$followname);
                        $Memberfollow=M('Memberfollow');
                        $mvInfo=$Memberfollow->where($mapfollow)->find();

                        $mvvo['membername']=$membername;
                        $mvvo['followname']=$followname;
                        $mvvo['create_time']=time();
                        
                        if(empty($mvInfo)){
                            
                            $mvresult = $Memberfollow->add($mvvo);
                            if ($mvresult !== false) { 
                                //成功提示
                                $this->ajaxReturn('', '关注成功', 1);
                            } else {
                                //失败提示
                                $this->ajaxReturn('', '关注失败', 0);
                            }
                        }else{
                  
                            $this->ajaxReturn('', '已关注', 0);
                        }
                    }else{
                        $this->ajaxReturn('', '自己', 0);
                    }
                    

                }
              
                

            }
        }

    }
    //喜欢
    public function xh() {
        if(isset($_GET['id'])){
            $id= $this->_get('id');
            if(!empty($id)){
                $map['id']=array('eq',$id);
                $name=  $this->getActionName();
                $result=D($name)->where($map)->setInc('xihuan',1);//更新喜欢人数
                if($result){
                    $num=D($name)->where($map)->getField('xihuan');//喜欢人数
                    $this->ajaxReturn($num);
                } 
            }
        }
    }
    //值不值
    public function zhi() {
        if(isset($_GET['id'])){
            $id= $this->_get('id');
            if(!empty($id)){
                $map['id']=array('eq',$id);
                if(isset($_GET['zt'])){
                    $zt=  $this->_get('zt');
                    $name=  $this->getActionName();
                    switch ($zt) {
                        case "chaozhi":
                            $result=D($name)->where($map)->setInc('chaozhi',1);
                            break;
                        case "yibanzhi":
                            $result=D($name)->where($map)->setInc('yibanzhi',1);
                            break;
                        case "buzhi":
                            $result=D($name)->where($map)->setInc('buzhi',1);
                            break;
                    }
                    if($result){
                        $data=D($name)->find($id);
                        $this->ajaxReturn($data);
                    } 
                }
            }
        }
    }
    
     //上传图片
    public function _upload(){

        if(!empty($_FILES))
        {
            import("@.ORG.Util.Image");
            import("@.ORG.UploadFile");
            //导入上传类
            $upload = new UploadFile();
            //设置上传文件大小
            $upload->maxSize = 524288;
            //设置上传文件类型
            $upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
            //设置附件上传目录
            $y = date('Y',time());
            $m = date('m',time());
            $d = date('d',time());
            
            $dir='./Uploads';
            
            if (!is_dir($dir)) {
                mkdir($dir, 0777);
            }
            $dir.='/'.$y;
            if (!is_dir($dir)) {
                mkdir($dir, 0777);
            }
            $dir.='/'.$m;
            if (!is_dir($dir)) {
                mkdir($dir, 0777);
            }
            $dir.='/'.$d;
            if (!is_dir($dir)) {
                mkdir($dir, 0777);
            }
            $dir.='/';
            $upload->savePath =$dir;//'../Uploads/';
            
            // 设置引用图片类库包路径
            $upload->imageClassPath = '@.ORG.Util.Image';
            //设置需要生成缩略图，仅对图像文件有效
            //$upload->thumb = true;
            //设置需要生成缩略图的文件后缀
            //$upload->thumbPrefix = 'm_,s_';  //生产2张缩略图
            //设置缩略图最大宽度
            //$upload->thumbMaxWidth = '150';
            //设置缩略图最大高度
            //$upload->thumbMaxHeight = '150';
            //设置上传文件规则
            $upload->saveRule = uniqid;
            //删除原图
            $upload->thumbRemoveOrigin = false;
            
            if (!$upload->upload()) {
                //捕获上传异常
                $strerror=$upload->getErrorMsg();
                if($strerror!="没有选择上传文件"){
                    $this->error($strerror);
                }
                
            } else {
                //取得成功上传的文件信息
                $uploadList = $upload->getUploadFileInfo();
                foreach ($uploadList as $key => $value) {
                    foreach ($_FILES as $key1 => $value1) {
                        if($value['name']===$value1['name']){

                            $_POST[$key1] = '/'.$y.'/'.$m.'/'.$d.'/'.$value['savename'];
                            
                        }
                    }
                    
                }

                
            }      
        }
    }
    /**
     * 印象码
     * @param type $YinXiangMaToken
     * @param type $level
     * @param type $YXM_input_result
     * @return string
     */
    function YinXiangMa_ValidResult($YinXiangMaToken,$level,$YXM_input_result){	
            if($YXM_input_result==md5("true".PRIVATE_KEY.$YinXiangMaToken)) { $result= "true"; }
            else { $result= "false"; }
            return $result;
    }
    //验证码
    public function verify() {
        $type=isset($_GET['type'])?$_GET['type']:'gif';
        import("@.ORG.Util.Image");
        Image::buildImageVerify(4,1,$type);
    }
    
    
    
}