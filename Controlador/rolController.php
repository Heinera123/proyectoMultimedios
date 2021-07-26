<?php
if (!isset($_SESSION)) { session_start(); }
require "../Modelo/rolModelo.php";
require "../encrypt.php";
if (!isset($_SESSION)) { session_start(); }
class rolController{
    function __construct(){}
    public function index(){
        require_once '../Vista/Rol/index.php';
      }
      public function register(){
        require_once '../Vista/Rol/register.php';
      }
      public function update(){
        require_once '../Vista/Rol/update.php';
      }
      public function delete(){
        $UController = new rolController();
        $UController->borrarRol();
      }
    public function agregarRol(){
        $rol = new rolModelo(0, $_POST["nombreRol"], $_POST["idMenu"], $_POST["fechaCrea"],"",
        $_POST["habilidato"]);
        $respuesta = rolModelo::guardarRol($rol);
        echo '<script language="javascript">alert("'. $respuesta .'");
        window.location= "../Vista/inicio.php?controller=rol&action=register";</script>';			        
    }
    public function borrarRol(){
        $respuesta = RolModelo::borrarRol($_GET['id']);
        echo '<script language="javascript">alert("'. $respuesta .'");
        window.location= "../Vista/inicio.php?controller=rol&action=index";</script>';
    }
    public static function ConsuTodosRol(){
        return RolModelo::ConsultarTodosRol();
    }
    public static function devolverconsultarRol($id){
        return RolModelo::ConsultarRol($id);
    }
    public static function modificarRol(){
        $rol = new rolModelo($_POST["idRol"], $_POST["nombreRol"], $_POST["idMenu"],"","",
        $_POST["habilidato"]);
        $respuesta = rolModelo::updateRol($rol);
        echo '<script language="javascript">alert("'. $respuesta .'");
        window.location= "../Vista/inicio.php?controller=rol&action=index";</script>';					        
    }
    public static function devolverMenus(){
        return RolModelo::devolverMenus();
    }
}
    //comprobaciones de las acciones a relizar, post desde form registro
    if (isset($_POST['action'])){
        $UController = new rolController();
        if($_POST['action']=='registrar'){
        $UController->agregarRol();
        }
        if($_POST['action']=='update'){
        $UController->modificarRol();
        }        
    }
?>