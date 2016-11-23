<?php
//SITE_ROOT
$path=$_SERVER['DOCUMENT_ROOT'].'/Strongertogether/';
define('SITE_ROOT', $path);

//SITE_PATH
   define('SITE_PATH','http://'.$_SERVER['HTTP_HOST'].'/Strongertogether/');

//CSS
define('CSS_PATH', SITE_PATH . 'view/css/');

//IMG
define('IMG_PATH', SITE_PATH . 'view/images/');

//JS
define('JS_PATH', SITE_PATH . 'view/js/');

//log
define('LOG_DIR',SITE_ROOT.'classes/log.class.singleton.php');
define('PRODUCTS_LOG_DIR',SITE_ROOT.'log/products/Site_Products_errors.log');
define('GENERAL_LOG_DIR',SITE_ROOT.'log/general/Site_General_errors.log');

//production
define('PRODUCTION',true);

//model
define('MODEL_PATH',SITE_ROOT.'model/');
//view
define('VIEW_PATH_INC',SITE_ROOT.'view/inc/');
define('VIEW_PATH_INC_ERROR',SITE_ROOT.'view/inc/templates_error/');
//modules
define('MODULES_PATH',SITE_ROOT.'modules/');

//resources
define('RESOURCES',SITE_ROOT.'resources/');
//media
define('MEDIA_PATH',SITE_ROOT.'media/');
//utils
define('UTILS',SITE_ROOT.'utils/');

//amigables
define('URL_AMIGABLES', TRUE);

//model specialists
define('FUNCTIONS_SPECIALISTS',SITE_ROOT.'modules/specialists/utils/');
define('MODEL_PATH_SPECIALISTS',SITE_ROOT.'modules/specialists/model/');
define('DAO_SPECIALISTS',SITE_ROOT.'modules/specialists/model/DAO/');
define('BLL_SPECIALISTS',SITE_ROOT.'modules/specialists/model/BLL/');
define('MODEL_SPECIALISTS',SITE_ROOT.'modules/specialists/model/model/');
define('SPECIALISTS_JS_PATH', SITE_PATH . 'modules/specialists/view/js/');
define('SPECIALISTS_JS_LIB_PATH', SITE_PATH . 'modules/specialists/view/lib/');
