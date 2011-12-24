<?php

//Site root dir
//define('DIR_ROOT',	 preg_replace('/^(.*)\/[^\/]+\.php$/','$1',$_SERVER["SCRIPT_FILENAME"]));
define('DIR_ROOT',	 preg_replace('/^(.*)\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\.php$/','$1',$_SERVER["SCRIPT_FILENAME"]));
define('ABSOLUTE_ROOT', 'http://127.0.0.1:8888/pcm-ensemblier.com/cakephp');
//define('ABSOLUTE_ROOT', 'http://www.pcm-ensemblier.com');
define('DIR_PLUGIN', '/js/tiny_mce/plugins/files');
//Images dir (root relative)
define('DIR_IMAGES',	'/storage/images');
//Files dir (root relative)
define('DIR_FILES',		'/storage/files');

// preg_replace('/^(.*)\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\.php$/','$1',$_SERVER["SCRIPT_FILENAME"]));

//Width and height of resized image
define('WIDTH_TO_LINK', 500);
define('HEIGHT_TO_LINK', 500);

//Additional attributes class and rel
define('CLASS_LINK', 'lightview');
define('REL_LINK', 'lightbox');

date_default_timezone_set('Asia/Yekaterinburg');
?>
