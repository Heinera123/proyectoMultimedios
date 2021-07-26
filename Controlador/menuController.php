<?php
if (!isset($_SESSION)) { session_start(); }
require "../Modelo/menuModelo.php";
require "../encrypt.php";
class menuController {
  public function __construct(){}
  public function index(){
    require_once '../Vista/Menu/index.php';
  }
  public function register(){
    require_once('../Vista/Menu/register.php');
  }
  public function update(){
    require_once('../Vista/Menu/update.php');
  }
  public function delete(){
    $UController = new menuController();
    $UController->borrarmenu();
  }
    public function agregarMenu(){
        $menu = new menuModelo(0, $_POST["nameMenu"], $_POST["idCatalogoMenu"], $_POST["createdAt"],"",
        $_POST["enabled"]);
        $respuesta = menuModelo::guardarmenu($menu);
        var_dump($menu);
        echo '<script language="javascript">alert("'. $respuesta .'");
        window.location= "../Vista/inicio.php?controller=menu&action=register";</script>';					        
    }
    public function borrarmenu(){
      $respuesta = menuModelo::borrarmenu($_GET["id"]);
      echo '<script language="javascript">alert("'. $respuesta .'");
      window.location= "../Vista/inicio.php?controller=menu&action=index";</script>';
    }
    public static function ConsuTodosmenu(){
      return menuModelo::ConsultarTodosMenu();
    }
    public static function devolverconsultarmenu($id){
      return menuModelo::ConsultarMenu($id);
    }
    public static function modificarMenu(){
      $menu = new menuModelo($_POST["idMenu"], $_POST["nameMenu"], 
      $_POST["idCatalogoMenu"], "","",
        $_POST["enabled"]);
      $respuesta = menuModelo::updatemenu($menu);
      echo '<script language="javascript">alert("'. $respuesta .'");
      window.location= "../Vista/inicio.php?controller=menu&action=index";</script>';					        
    }
    ///**********************/
    public static function delverRoles(){
      return menuModelo::devolverRoles();
    }
}
//comprobaciones de las acciones a relizar, post desde form registro
  if (isset($_POST['action'])){
    $UController = new menuController();
    if($_POST['action']=='registrar'){
      $UController->agregarMenu();
    }
    if($_POST['action']=='update'){
      $UController->modificarMenu();
    }        
  }
?>