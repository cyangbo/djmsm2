<?php

class IndexAction extends CommonAction {

    public function index(){
        $this->sitename=C(SITE_NAME);
        $this->display();
    }
 
}