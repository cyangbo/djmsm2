<?php
$config=  require '../config.ini.php';
$array= array(
	'APP_AUTOLOAD_PATH'=>'@.TagLib',
	'TAGLIB_PRE_LOAD'=>'yufu',
	'DEFAULT_THEME'=>'default',
);

return array_merge($config,$array);
?>