<?php
/*前台动作基类*/
class CommonAction extends Action {
    //初始化
    function _initialize(){
        header("Content-Type:text/html; charset=utf-8");
        
        //栏目导航
        $nav_list = D('Category')->where('pid=0 AND status=1')->order('listorder')->select();
        if(is_array($nav_list)){
                foreach ($nav_list as $key=>$val){
                        $nav_list[$key] = $this->changurl($val);
                        $nav_list[$key]['sub_nav'] = D('Category')->where('pid='.$val['id'].' AND status=1')->select();
                        foreach ($nav_list[$key]['sub_nav'] as $key2=>$val2){
                                $nav_list[$key]['sub_nav'][$key2] = $this->changurl($val2);
                        }
                }
        }
        $this->assign('nav_list',$nav_list);
        
    }
   
    //SEO赋值
    public function seo($title,$keywords,$description,$positioin){
    	$this->assign('title',$title);
    	$this->assign('keywords',$keywords);
    	$this->assign('description',$description);
    	$this->assign('position',$positioin['id']);
        $this->assign('positionname',$positioin['catname']);
    }
    //URL转换
    public function changurl($ary){
    	if(is_array($ary)){
            if(key_exists('modelname', $ary)){
                $ary['url']=U($ary['modelname'].'/index/',array('id'=>$ary['id']));
            }
            return $ary;
        }		
    }
    public function index() {
        
        $id = $_GET['id'];
        $catdata = D('Category')->where('status=1')->find($id);	
        
        //获取所有子类id
        $catlist = D('Category')->where('status=1')->select();	
        $idlist = $id.','.arrToTree($catlist,$id);  
        $idlist= substr($idlist, 0, strlen($idlist)-1);
        $map['catid'] = array('in',$idlist);
        
        $name = $this->getActionName();
        
        //获取分页设置
        $Model=M('Model');
        $map['table']=array('eq',$name);
        $pageinfo=$Model->where($map)->find();

        $Form   =   M($name);
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数
        $Page = new Page($count, $pageinfo['listrows']);

        $list   = $Form->where($map)->limit('0,' . $Page->nowPage*$Page->listRows)->order('id desc')->select();//$Page->firstRow. 

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

        $Page->setConfig('next', '查看更多');
        $Page->setConfig('theme','%downPage%');
        $downPage= $Page->show();
        
        $this->assign("catdata", $catdata);
        $this->assign("page", $page);

        $this->assign("downPage", $downPage);
        $this->assign("list", $list);
        $this->seo(($catdata['title'])?$catdata['title']:C(SITE_NAME), ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), D('Common')->getPosition($id));
        
        $this->display(); 
    }
    public function show()
    {
        $id= $_GET['id'];
        $name = $this->getActionName();
        
        D($name)->where('id='.$id)->setInc('hits',1);//浏览次数
       
        $model=M($name);

        //当前记录
        $data=$model->find($id);
        if(isset($data["thumb"])){
            $data["thumb"]=explode("#", $data["thumb"]);
        }
        
        //上一条记录
        $prevdata=$model->where('id<'.$id)->order('id desc')->limit('1')->find();
        
        //下一条记录
        $nextdata=$model->where('id>'.$id)->order('id asc')->limit('1')->find();
        
        $this->seo($data['title'], $data['keywords'], $data['description'], D('Common')->getPosition($data['catid']));
        $this->data=$data;
        $this->prevdata=$prevdata;
        $this->nextdata=$nextdata;
        $this->display(); 
    }
    
    
    
}