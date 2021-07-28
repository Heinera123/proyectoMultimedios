<?php
if (!isset($_SESSION)) { session_start(); }
require "../Modelo/alquilerAutosModelo.php";
require "../encrypt.php";
require "../Modelo/userModelo.php";
require_once "../Modelo/autoModelo.php";
class alquilerAutoController {
  public function __construct(){}
  public function index(){
    require_once '../Vista/alquilerAutos/index.php';
  }
  public function register(){
    require_once('../Vista/alquilerAutos/register.php');
  }
  public function update(){
    require_once('../Vista/alquilerAutos/update.php');
  }
  public function delete(){
    $UController = new alquilerAutoController();
    $UController->borraralquilerAuto();
  }
    public function agregaralquilerAuto(){
        $alquilerAuto = new alquilerAutoModelo(0, 
        $_POST["idAuto"], $_POST["idUser"], 
        $_POST["FechaAlquiler"],
        $_POST["email"], $_POST["fechaDevolucion"],
        alquilerAutoModelo::devolverMontoPagar($_POST["idAuto"],$_POST["FechaAlquiler"],$_POST["fechaDevolucion"]),
        $_POST["cancelado"], null, null);
        $respuesta = alquilerAutoModelo::guardaralquilerAuto($alquilerAuto);
        echo '<script language="javascript">alert("'. $respuesta .'");
        window.location= "../Vista/inicio.php?controller=alquilerAutos&action=register";</script>';					        
    }
    public function borraralquilerAuto(){
      $respuesta = alquilerAutoModelo::borraralquilerAuto($_GET["id"], $_GET["idAuto"]);
      echo '<script language="javascript">alert("'. $respuesta .'");
      window.location= "../Vista/inicio.php?controller=alquilerAutos&action=index";</script>';
    }
    public static function ConsuTodosalquilerAuto(){
      return alquilerAutoModelo::ConsultarTodosalquilerAuto();
    }
    public static function devolverconsultaralquilerAuto($id){
      //ErrorModelo::ConsultarRelacionMenuControlador($_SESSION["idalquilerAuto"]);////************** */
      return alquilerAutoModelo::ConsultaralquilerAuto($id);
    }
    public static function modificaralquilerAuto(){
      $alquilerAuto = new alquilerAutoModelo($_POST["id"], 
        $_POST["idAuto"], 
        $_POST["idUser"], 
        $_POST["FechaAlquiler"],
        $_POST["email"], 
        $_POST["fechaDevolucion"],
        alquilerAutoModelo::devolverMontoPagar($_POST["idAuto"],$_POST["FechaAlquiler"],$_POST["fechaDevolucion"]),
        $_POST["cancelado"], null, null);
      $respuesta = alquilerAutoModelo::updatealquilerAuto($alquilerAuto);
      echo '<script language="javascript">alert("'. $respuesta .'");
      window.location= "../Vista/inicio.php?controller=alquilerAutos&action=index";</script>';					        
    }
    public static function devolverAutos($id){
      //return AutoModelo::ConsultarTodosautosHabilitados();
      //var_dump(autoController::devolverAutosHabilitados());
      return AutoModelo::ConsultarTodosautosHabilitados($id);
    }
    public static function delverCliente(){
      return UserModelo::ConsultarTodosUsuarioHabilitado();
    }
}
//comprobaciones de las acciones a relizar, post desde form registro
  if (isset($_POST['action'])){
    $UController = new alquilerAutoController();
    if($_POST['action']=='registrar'){
      $UController->agregaralquilerAuto();
    }
    if($_POST['action']=='update'){
      $UController->modificaralquilerAuto();
    }        
  }
?>