<?php

class controller_specialists{

  public function __construct() {
      include(FUNCTIONS_SPECIALISTS . "utils.inc.php");

    $_SESSION['module'] = "specialists";
  }

  public function list_specialists() {

    require_once(VIEW_PATH_INC."header.php");
    require_once(VIEW_PATH_INC."menu.php");

    loadView('modules/specialists/view/','list_specialists.php');

    require_once(VIEW_PATH_INC."footer.html");

  }

  public function autocomplete(){
    if ((isset($_POST["autocomplete"])) && ($_POST["autocomplete"] === "true")) {
        set_error_handler('ErrorHandler');
        try {
            $nameProducts = loadModel(MODEL_SPECIALISTS, "products_model", "select_column_products", "name_prod");
        } catch (Exception $e) {
            showErrorPage(2, "ERROR - 503 BD", 'HTTP/1.0 503 Service Unavailable', 503);
        }
        restore_error_handler();

        if ($nameProducts) {
            $jsondata["nom_productos"] = $nameProducts;
            echo json_encode($jsondata);
            exit;
        } else {
            showErrorPage(2, "ERROR - 404 NO DATA", 'HTTP/1.0 404 Not Found', 404);
        }
    }
  }

  public function name_specialists(){
    if (($_POST["name_products"])) {
        //filtrar $_GET["nom_product"]
        $result = filter_string($_POST["name_products"]);
        if ($result['resultado']) {
            $criteria = $result['datos'];
        } else {
            $criteria = '';
        }
        set_error_handler('ErrorHandler');
        try {

            $arrArgument = array(
                "column" => "name",
                "like" => $criteria
            );
            $producto = loadModel(MODEL_SPECIALISTS, "products_model", "select_like_products", $arrArgument);

            //throw new Exception(); //que entre en el catch
        } catch (Exception $e) {
            showErrorPage(2, "ERROR - 503 BD", 'HTTP/1.0 503 Service Unavailable', 503);
        }
        restore_error_handler();

        if ($producto) {
            $jsondata["product_autocomplete"] = $producto;
            echo json_encode($jsondata);
            exit;
        } else {
            showErrorPage(2, "ERROR - 404 NO DATA", 'HTTP/1.0 404 Not Found', 404);
        }
    }
  }

  public function count_specialists(){
    if (isset($_POST["count_product"])) {

        $result = filter_string($_POST["count_product"]);
        if ($result['resultado']) {
            $criteria = $result['datos'];
        } else {
            $criteria = '';
        }
        set_error_handler('ErrorHandler');
        try {

            $arrArgument = array(
                "column" => "name",
                "like" => $criteria
            );
            $result = loadModel(MODEL_SPECIALISTS, "products_model", "count_like_products", $arrArgument);
            //throw new Exception(); //que entre en el catch
        } catch (Exception $e) {
            showErrorPage(2, "ERROR - 503 BD", 'HTTP/1.0 503 Service Unavailable', 503);
        }
        restore_error_handler();

        if ($result) {
            $jsondata["num_products"] = $result[0]["total"];
            echo json_encode($jsondata);
            exit;
        } else {
            //if($total_rows){ //que lance error si no existe el producto
            showErrorPage(2, "ERROR - 404 NO DATA", 'HTTP/1.0 404 Not Found', 404);
        }
      }
    }

    public function num_pages(){
      //obtain num total pages
      if ((isset($_POST["num_pages"])) && ($_POST["num_pages"] === "true")) {

          if (isset($_POST['keyword'])) {
            $result = filter_string($_POST['keyword']);
            if ($result['resultado']) {
              $criteria = $result['datos'];
            } else {
              $criteria = '';
            }
          } else {
            $criteria = '';
          }

          $item_per_page = 6;

          //change work error apache
          set_error_handler('ErrorHandler');
          try {
              $arrArgument = array(
                  "column" => "name",
                  "like" => $criteria
              );
              //throw new Exception();
              $result = loadModel(MODEL_SPECIALISTS, "products_model", "count_like_products", $arrArgument);
              $get_result = $result[0]["total"]; //total records
              $pages = ceil($get_result / $item_per_page); //break total records into pages
              //ceil redondea fracciones hacia arriba
          } catch (Exception $e) {
              showErrorPage(2, "ERROR - 503 BD", 'HTTP/1.0 503 Service Unavailable', 503);
          }
          //change to defualt work error apache
          restore_error_handler();

          if ($get_result) {
              $jsondata["pages"] = $pages;
              echo json_encode($jsondata);
              exit;
          } else {
              showErrorPage(2, "ERROR - 404 NO DATA", 'HTTP/1.0 404 Not Found', 404);
          }
      }/////END num_pages
    }

    public function view_error_true(){
      if ((isset($_POST["view_error"])) && ($_POST["view_error"] === "true")) {
          showErrorPage(0, "ERROR - 503 BD Unavailable", 503);
      }
    }

    public function view_error_false(){
      if ((isset($_POST["view_error"])) && ($_POST["view_error"] === "false")) {
          showErrorPage(3, "RESULTS NOT FOUND <br> Please, check over if you misspelled any letter of the search word");
      }
    }

    public function id(){
      ///Coge el cod_prod
      if ($_POST["idProducto"]) {

          $result = filter_num_int($_POST["idProducto"]);
          if ($result['resultado']) {
              $id = $result['datos'];
          } else {
              $id = 1;
          }
          set_error_handler('ErrorHandler');
          try {
              $producto = false;

              $producto = loadModel(MODEL_SPECIALISTS, "products_model", "details_products", $id);
          } catch (Exception $e) {
              //header('HTTP/1.0 503 Service Unavailable', true, 503);
              // loadView("503");
              showErrorPage(2, "ERROR - 503 BD", 'HTTP/1.0 503 Service Unavailable', 503);
          }
          restore_error_handler();
          if ($producto) {
              $jsondata["product"] = $producto[0];
              echo json_encode($jsondata);
              exit;
          } else {
              showErrorPage(2, "ERROR - 404 NO DATA", 'HTTP/1.0 404 Not Found', 404);
          }
      }
    }

    public function obtain_specialists(){
      if (isset($_POST["page_num"])) {
          $result = filter_num_int($_POST["page_num"]);
          if ($result['resultado']) {
              $page_number = $result['datos'];
          }
      } else {
          $page_number = 1;
      }
      $item_per_page = 6;

      if (isset($_POST["keyword"])) {
          $result = filter_string($_POST["keyword"]);
          if ($result['resultado']) {
              $criteria = $result['datos'];
          } else {
              $criteria = '';
          }
      } else {
          $criteria = '';
      }

      if (isset($_POST["keyword"])) {
          $result = filter_string($_POST["keyword"]);
          if ($result['resultado']) {
              $criteria = $result['datos'];
          } else {
              $criteria = '';
          }
      }

      $position = (($page_number - 1) * $item_per_page);

      $limit = $item_per_page;
      $arrArgument = array(
          "column" => "name",
          "like" => $criteria,
          "position" => $position,
          "limit" => $limit
      );
      set_error_handler('ErrorHandler');

      try {

          $resultado = loadModel(MODEL_SPECIALISTS, "products_model", "select_like_limit_products", $arrArgument);

          } catch (Exception $e) {

          showErrorPage(0, "ERROR - 503 BD Unavailable", 503);
      }
      restore_error_handler();

      if ($resultado) {
          paint_template_products($resultado);
      } else {
          showErrorPage(0, "ERROR - 404 NO PRODUCTS", 404);
      }
      }
    }
