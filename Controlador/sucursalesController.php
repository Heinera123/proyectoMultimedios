<?php
if (!isset($_SESSION)) { session_start(); }
require "../Modelo/sucursalesModelo.php";
require "../encrypt.php";
if (!isset($_SESSION)) { session_start(); }
class sucursalesController{
    function __construct(){}
    public function index(){
        require_once '../Vista/Sucursal/index.php';
      }
      public function register(){
        require_once '../Vista/Sucursal/register.php';
      }
      public function update(){
        require_once '../Vista/Sucursal/update.php';
      }
      public function delete(){
        $UController = new sucursalesController();
        $UController->borrarSucursal();
      }
    public function agregarSucursal(){
        $sucursal = new SucursalModelo(0, $_POST["provincia"], $_POST["canton"], $_POST["distrito"], $_POST["direccion"], $_POST["fechaCrea"],"",
        $_POST["habilidato"]);
        $respuesta = SucursalModelo::guardarSucusal($sucursal);
        echo '<script language="javascript">alert("'. $respuesta .'");
        window.location= "../Vista/inicio.php?controller=sucursales&action=register";</script>';			        
    }
    public function borrarSucursal(){
        $respuesta = SucursalModelo::borrarSucursal($_GET['id']);
        echo '<script language="javascript">alert("'. $respuesta .'");
        window.location= "../Vista/inicio.php?controller=sucursales&action=index";</script>';
    }
    public static function ConsuTodosSucursal(){
        return SucursalModelo::ConsultarTodasSucursales();
    }
    public static function devolverconsultarSucursal($id){
        return SucursalModelo::ConsultarSucursal($id);
    }
    public static function modificarSucursal(){
        $sucursal = new SucursalModelo($_POST["id"], $_POST["provincia"], $_POST["canton"], $_POST["distrito"], $_POST["direccion"],"","",
        $_POST["habilidato"]);
        $respuesta = SucursalModelo::updateSucursal($sucursal);
        echo '<script language="javascript">alert("'. $respuesta .'");
        window.location= "../Vista/inicio.php?controller=sucursales&action=index";</script>';					        
    }
    public static function devolverSucursales(){
        return SucursalModelo::devolverMenus();
    }
}
    //comprobaciones de las acciones a relizar, post desde form registro
    if (isset($_POST['action'])){
        $UController = new sucursalesController();
        if($_POST['action']=='registrar'){
        $UController->agregarSucursal();
        }
        if($_POST['action']=='update'){
        $UController->modificarSucursal();
        }        
    }
?>