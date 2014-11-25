<?php
    $config=  require 'config.ini.php';
    $array= array(
            'APP_AUTOLOAD_PATH'=>'@.TagLib',
            'TAGLIB_PRE_LOAD'=>'yufu',
            'TMPL_ACTION_ERROR'=>'Public:error',
            'TMPL_ACTION_SUCCESS'=>'Public:success',
    );
    return array_merge($config,$array);
?>