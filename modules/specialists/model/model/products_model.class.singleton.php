<?php
/*
$path = $_SERVER['DOCUMENT_ROOT'] . '/proyecto_v3/';
define('SITE_ROOT', $path);
require(SITE_ROOT . "modules/products_frontend/model/BLL/products_bll.class.singleton.php");
*/
class products_model {

    private $bll;
    static $_instance;

    private function __construct() {
        $this->bll = products_bll::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function details_products($id) {
        return $this->bll->details_products_BLL($id);
    }

    public function select_column_products($arrArgument){
        return $this->bll->select_column_products_BLL($arrArgument);
    }
    public function select_like_products($arrArgument){
        return $this->bll->select_like_products_BLL($arrArgument);
    }
    public function count_like_products($arrArgument){

        return $this->bll->count_like_products_BLL($arrArgument);
    }
    public function select_like_limit_products($arrArgument){

         return $this->bll->select_like_limit_products_BLL($arrArgument);
    }
}
