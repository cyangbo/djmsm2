<?php

class SetAction extends CommonAction {
    public function index() {
        //加载用户配置文件信息
//        require HOME_PATH."Conf/config.php";
        require "../config.ini.php";
        $user_config = $array;
        
        //模板路径
        $templateDir = HOME_PATH."Tpl/";
        $templateList = array();
        if (is_dir($templateDir)) {
            if ($dh = opendir($templateDir)) {
                while (($template = readdir($dh)) !== false) {
                    if($template != "." && $template != ".." && filetype($templateDir.$template) == "dir")
                    $templateList[$template] = $template;
                }
                closedir($dh);
            }
        }
        //登录安全设置
        $set=D('Set')->find();
        $this->set=$set;
        $this->user_config=$user_config;
        $this->templateList=$templateList;
        $this->display();  
    }
    public function save() {
//        require HOME_PATH."Conf/config.php";
        require "../config.ini.php";
        $user_config = $array;
        
        $user_config["SITE_NAME"] = $_POST["SITE_NAME"];
        $user_config["DOMAIN_NAME"] = $_POST["DOMAIN_NAME"];
        $user_config["SITE_TITLE"] = $_POST["SITE_TITLE"];
        $user_config["SITE_KEYWORDS"] = $_POST["SITE_KEYWORDS"];
        $user_config["SITE_DESCRIPTION"] = $_POST["SITE_DESCRIPTION"];
        $user_config["URL_MODEL"] = $_POST["URL_MODEL"];
        $user_config["DEFAULT_THEME"] = $_POST["DEFAULT_THEME"];
        if(empty($_POST["TAOKEAPI"])){
            $user_config["TAOKEAPI"] =0;
            
        }else{
            $user_config["TAOKEAPI"] = 1;
        }
        $user_config["APPKEY"] = $_POST["APPKEY"];
        $user_config["SECRET"] = $_POST["SECRET"];
        
        $config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = array(\r\n";
        foreach($user_config as $key=>$value)
        {
            if($value === true)
                    $config .= "\t'".$key."'=>true,\r\n";
            else if($value === false)
                    $config .= "\t'".$key."'=>false,\r\n";
            else if(is_numeric($value))
                    $config .= "\t'".$key."'=>$value,\r\n";
            else
                    $config .= "\t'".$key."'=>'$value',\r\n";
        }
        $config .= ");\r\n?>";
        
        //保存配置
//        file_put_contents(HOME_PATH."Conf/config.php",$config);
        file_put_contents("../config.ini.php",$config);
        //清空前台缓存
        clearCache();
        
        //登录安全设置
        $this->_upload();
        $model = D('Set');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        // 更新数据
        $list = $model->save();
        
        $this->success("设置成功");
    }
}

?>
