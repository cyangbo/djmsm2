<?php

class WxapiAction extends CommonAction{
   
    public function mapi(){
        
        define("TOKEN", C(WX_TOKEN));
        $this->valid();
        
    }
    public function valid(){
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            $this->responseMsg();
            exit;
        }
    }
    //回复消息
    public function responseMsg(){
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        
      	//extract post data
        if (!empty($postStr)){
            
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();

            if(!empty($keyword)){
                $resultStr =$this->voperate($fromUsername,$toUsername,$keyword);
                echo $resultStr;
            }else{
                $set=D("Set")->find();
                $textTpl="<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName> 
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>1</FuncFlag>
                </xml>";
                $msgType = "text";
                $contentStr = $set['welcomeinfo'];
                echo $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            }

        }else {
        	echo "";
        	exit;
        }
    }
    //验证
    private function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
                return true;
        }else{
                return false;
        }
    }
    public function voperate($fromUsername,$toUsername,$keyword){

        if(empty($keyword)){
            return '请输入关键词';
        }
        $map['status']=array('eq',1);
        $map['title']=array('like','%'.$keyword.'%');
        $weixin=M('Product');
        $count=$weixin->where($map)->count();

        $textTpl="<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName> 
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        <FuncFlag>1</FuncFlag>
        </xml>";
        $msgType = "text";
        if($count>0){
            $url=U('Wxapi/msearch',array('keyword'=>$keyword),'','',true);
            $contentStr = "搜索到关于【".$keyword."】的商品（".$count."）个，【<a href=\"".$url."\">查看详细</a>】";
        }else{
            $set=D("Set")->find();
            $defaultreply = $set['defaultreply'];
            $url=U('Wxapi/msearch','','','',true);
            $contentStr = "抱歉，未搜索到相关商品！【<a href=\"".$url."\">查看精品推荐</a>】\r\n\r\n".$defaultreply."";
        }
        
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);

        return $resultStr;
    }
    //手机搜索
    public function msearch() {
        $keyword=$this->_get('keyword');
        $map['status']=array('eq',1);
        if(!empty($keyword)){
            $map['title']=array('like','%'.$keyword.'%');
            $this->keyword=$keyword;
        }else{
            $map['tuijian']=array('eq',1);
        }
        $Form=M('Product');
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数
        $Page = new Page($count, 10);
        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order($order)->select();
        // 设置分页显示
        $Page->setConfig('prev', "上一组宝贝");
        $Page->setConfig('next', "下一组宝贝");
        $Page->setConfig('theme','<div class="prev">%upPage%</div><div class="next">%downPage%</div>');
        $page = $Page->show();
        
        
//        $list=$weixin->where($map)->order('hits desc')->select();
        $this->assign("page", $page);
        $this->list=$list;
        $this->display();
    }
    
}

?>
