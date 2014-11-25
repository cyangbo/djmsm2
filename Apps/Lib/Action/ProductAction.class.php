<?php

class ProductAction extends CommonAction{

    //过滤查询字段
    function _filter(&$map){
        
        if(isset($_GET['keyword'])){
            $keyword=  $this->_get('keyword');
            if(!empty($keyword)){
                $map['title']=array('like','%'.$keyword.'%');
            }
        }
        if(isset($_POST['search'])){
            $keyword=  $this->_post('search');
            if(!empty($keyword)){
                $map['title']=array('like','%'.$keyword.'%');
            } 
        }
        
        if(!empty($keyword)){
            //搜索词处理
            $mapsearch["search"]=array('eq',$keyword);
            $Search=M('Search');
            $searchInfo=$Search->where($mapsearch)->find();

            if($searchInfo){
                D('Search')->where($mapsearch)->setInc('hits',1);//浏览次数
            }else{
               $searchvo=$Search->create();

                if (false === $searchvo) {
                    $this->error($Search->getError());
                }

                $Search->hits=1;
                $Search->status=1;
                $Search->create_time=time();
                //保存当前数据对象
                $searchList = $Search->add();
            }
        }

    }
    public function _before_index() {
        if(!isset($_GET['sort'])){
            $_GET['sort']='pop';
        }
        if(!isset($_GET['price'])){
            $_GET['price']=all;
        }
            
    }
    
    
    
    
}

?>
