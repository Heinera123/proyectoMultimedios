<?php
if (!isset($_SESSION)) { session_start(); }
require "../Modelo/userModelo.php";
require "../encrypt.php";
class userController {
  public function __construct(){}
  public function index(){
    require_once '../Vista/Usuario/index.php';
  }
  public function register(){
    require_once('../Vista/Usuario/register.php');
  }
  public function update(){
    require_once('../Vista/Usuario/update.php');
  }
  public function delete(){
    $UController = new userController();
    $UController->borraruser();
  }
    public function agregarUsuario(){
        $pasw = encrypt::encryptar($_POST["passwUser"]);
        $usuario = new UserModelo(0, $_POST["cedulaUser"], $_POST["nameUser"], $_POST["lastNameUser"],
        $_POST["emailUser"], $_POST["userName"],$pasw, $_POST["rolUser"], date("Y-m-d h:i:s"),
        $_POST["habiliUser"]);
        $respuesta = UserModelo::guardarUser($usuario);
        echo '<script language="javascript">alert("'. $respuesta .'");
        window.location= "../Vista/inicio.php?controller=user&action=register";</script>';					        
    }
    public function borraruser(){
      $respuesta = UserModelo::borrarUser($_GET["id"]);
      echo '<script language="javascript">alert("'. $respuesta .'");
      window.location= "../Vista/inicio.php?controller=user&action=index";</script>';
    }
    public static function ConsuTodosUser(){
      return UserModelo::ConsultarTodosUsuario();
    }
    public static function devolverconsultarUser($id){
      //ErrorModelo::ConsultarRelacionMenuControlador($_SESSION["idUser"]);////************** */
      return UserModelo::ConsultarUsuario($id);
    }
    public static function modificarUsuario(){
      $usuario = new UserModelo($_POST['id'], $_POST["cedulaUser"], $_POST["nameUser"], 
      $_POST["lastNameUser"],
      $_POST["emailUser"],null,null, $_POST["rolUser"], null,
      $_POST["habiliUser"]);
      $respuesta = UserModelo::updateUser($usuario);
      echo '<script language="javascript">alert("'. $respuesta .'");
      window.location= "../Vista/inicio.php?controller=user&action=index";</script>';					        
    }
    public static function delverRoles(){
      return UserModelo::devolverRoles();
    }
}
//comprobaciones de las acciones a relizar, post desde form registro
  if (isset($_POST['action'])){
    $UController = new userController();
    if($_POST['action']=='registrar'){
      $UController->agregarUsuario();
    }
    if($_POST['action']=='update'){
      $UController->modificarUsuario();
    }        
  }
?>