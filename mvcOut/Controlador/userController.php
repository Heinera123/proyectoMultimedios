<?php
require_once "../Modelo/userModelo.php";
require_once "../../encrypt.php";
class userController {
  public function __construct(){}
    public function agregarUsuario(){
        $pasw = encrypt::encryptar($_POST["passwUser"]);
        $usuario = new UserModelo(0, $_POST["cedulaUser"], $_POST["nameUser"], 
        $_POST["lastNameUser"],
        $_POST["emailUser"], $_POST["userName"],$pasw, 0, 
        date("Y-m-d h:i:s"),
        $_POST["habiliUser"]);
        $respuesta = UserModelo::guardarUser($usuario);
        echo '<script language="javascript">alert("'. $respuesta .'");
       window.location= "../../index.php";</script>';					        
    }
    public function verificarDatos(){
      if(UserModelo::verificarDatos($_POST["cedulaUser"], $_POST["userName"], $_POST["emailUser"])){
        $UController = new userController();
        $UController->agregarUsuario();
      }else {
        echo '<script language="javascript">alert("Cedula, Nombre Usuario o Email ya registrados en el sistema. Por favor inicie Sesión");
        window.location= "../../index.php";</script>';
      }
    }
    public function recoverContra(){
      
      if($_POST["cedula"] != null){
        UserModelo::consultarParaRecuperar($_POST["cedula"], 0 , 0);
      }else if ($_POST["email"] != null){
        UserModelo::consultarParaRecuperar(0, $_POST["email"] , 0);
      }else if($_POST["user"] != null){
        UserModelo::consultarParaRecuperar(0, 0 , $_POST["user"]);
      } else {
        echo '<script language="javascript">alert("No puede hacer la consulta con datos vacios");
        window.location= "../Vista/recoverContra.php";</script>';
      }
    }
    public static function encriptar($ps){
      return encrypt::encryptar($ps);
    }
}
//comprobaciones de las acciones a relizar, post desde form registro
  if (isset($_POST)){
    $UController = new userController();
    if($_POST['action']=='registrar'){
      $UController->verificarDatos();
    }
    if($_POST['action']=='recuperar'){
      $UController->recoverContra();
    }        
  }
?>