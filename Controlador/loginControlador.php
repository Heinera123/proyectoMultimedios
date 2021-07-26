<?php
require "../Modelo/loginModelo.php";
require "../encrypt.php";
class loginControlador {
  public function __construct(){}
    public function consultarLogin(){
        $pasw = encrypt::encryptar($_POST["pasw"]);
        $usuarios=loginModelo::loginFuncion($_POST["userName"], $pasw);
        echo '<script language="javascript">alert("'. $usuarios .'");window.location= "../index.php";</script>'; // 						        
    }
}
if ($_POST['action']=='login'){
  $loController = new loginControlador();
  $loController->consultarLogin();
}
?>