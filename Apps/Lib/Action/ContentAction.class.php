<?php

class ContentAction extends CommonAction{
    public function index() {
        
        $id = $_GET['id'];
        $catdata = D('Category')->where('status=1')->find($id);
        $this->assign("data", $catdata);
        
        $this->seo(($catdata['title'])?$catdata['title']:C(SITE_NAME), ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), D('Common')->getPosition($id));

        $this->display(); 
    }
 
}

?>
