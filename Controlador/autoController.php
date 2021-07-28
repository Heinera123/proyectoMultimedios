<?php
if (!isset($_SESSION)) { session_start(); }
require_once "../Modelo/autoModelo.php";
require_once "../encrypt.php";
class autoController {
  public function __construct(){}
  public function index(){
    require_once '../Vista/autos/index.php';
  }
  public function register(){
    require_once('../Vista/autos/register.php');
  }
  public function update(){
    require_once('../Vista/autos/update.php');
  }
  public function delete(){
    $UController = new autoController();
    $UController->borrarauto();
  }
    public function agregarauto(){
        $auto = new autoModelo(0, $_POST["placa"], 
        $_POST["marca"], $_POST["modelo"],
        $_POST["precio"], $_POST["enabled"], "", "");
        $respuesta = autoModelo::guardarauto($auto);
        echo '<script language="javascript">alert("'. $respuesta .'");
        window.location= "../Vista/inicio.php?controller=auto&action=register";</script>';					        
    }
    public function borrarauto(){
      $respuesta = autoModelo::borrarauto($_GET["id"]);
      echo '<script language="javascript">alert("'. $respuesta .'");
      window.location= "../Vista/inicio.php?controller=auto&action=index";</script>';
    }
    public static function ConsuTodosauto(){
      return autoModelo::ConsultarTodosauto();
    }
    public static function devolverconsultarauto($id){
      //ErrorModelo::ConsultarRelacionMenuControlador($_SESSION["idauto"]);////************** */
      return autoModelo::Consultarauto($id);
    }
    public static function modificarauto(){
      $auto = new autoModelo($_POST["id"], $_POST["placa"], 
        $_POST["marca"], $_POST["modelo"],
        $_POST["precio"], $_POST["enabled"], "", "");
      $respuesta = autoModelo::updateauto($auto);
      echo '<script language="javascript">alert("'. $respuesta .'");
      window.location= "../Vista/inicio.php?controller=auto&action=index";</script>';					        
    }
    public static function devolverAutosHabilitados(){
      return AutoModelo::ConsultarTodosautosHabilitados();
    }
}
//comprobaciones de las acciones a relizar, post desde form registro
  if (isset($_POST['action'])){
    $UController = new autoController();
    if($_POST['action']=='registrar'){
      $UController->agregarauto();
    }
    if($_POST['action']=='update'){
      $UController->modificarauto();
    }        
  }
?>