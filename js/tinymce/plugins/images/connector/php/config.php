<?php

//Корневая директория сайта
define('DIR_ROOT',		$_SERVER['DOCUMENT_ROOT']);
//Директория с изображениями (относительно корневой)
//echo $_SERVER['DOCUMENT_ROOT'];
define('DIR_IMAGES',	'/ci_new/images');
//Директория с файлами (относительно корневой)
define('DIR_FILES',		'/ci_new/files');


//Высота и ширина картинки до которой будет сжато исходное изображение и создана ссылка на полную версию
define('WIDTH_TO_LINK', 500);
define('HEIGHT_TO_LINK', 500);

//Атрибуты которые будут присвоены ссылке (для скриптов типа lightbox)
define('CLASS_LINK', 'lightview');
define('REL_LINK', 'lightbox');

date_default_timezone_set('Asia/Yekaterinburg');

?>
