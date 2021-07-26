<?php
if (!isset($_SESSION)) { session_start(); }
require "../Modelo/controllerModelo.php";
require "../encrypt.php";
class ControllerController {
  public function __construct(){}
  public function index(){
    require_once '../Vista/Controller/index.php';
  }
  public function register(){
    require_once('../Vista/Controller/register.php');
  }
  public function update(){
    require_once('../Vista/Controller/update.php');
  }
  public function delete(){
    $UController = new controllerController();
    $UController->borrarcontroller();
  }
    public function agregarcontroller(){
        $controller = new controllerModelo(0, $_POST["nameControllerView"], $_POST["createdAt"],"",
        $_POST["enabled"]);
        $respuesta = controllerModelo::guardarcontroller($controller);
        echo '<script language="javascript">alert("'. $respuesta .'");
        window.location= "../Vista/inicio.php?controller=controller&action=register";</script>';					        
    }
    public function borrarcontroller(){
      $respuesta = controllerModelo::borrarcontroller($_GET["id"]);
      echo '<script language="javascript">alert("'. $respuesta .'");
      window.location= "../Vista/inicio.php?controller=controller&action=index";</script>';
    }
    public static function ConsuTodoscontroller(){
      return controllerModelo::ConsultarTodoscontroller();
    }
    public static function devolverconsultarcontroller($id){
      return controllerModelo::Consultarcontroller($id);
    }
    public static function modificarcontroller(){
      $controller = new controllerModelo($_POST["idcontroller"], $_POST["nameControllerView"], 
       "","",
        $_POST["enabled"]);
      $respuesta = controllerModelo::updatecontroller($controller);
      echo '<script language="javascript">alert("'. $respuesta .'");
      window.location= "../Vista/inicio.php?controller=controller&action=index";</script>';					        
    }
    ///**********************/
    public static function delverRoles(){
      return controllerModelo::devolverRoles();
    }
}
//comprobaciones de las acciones a relizar, post desde form registro
  if (isset($_POST['action'])){
    $UController = new controllerController();
    if($_POST['action']=='registrar'){
      $UController->agregarcontroller();
    }
    if($_POST['action']=='update'){
      $UController->modificarcontroller();
    }        
  }
?>