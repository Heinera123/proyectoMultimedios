<?php
require_once "../Modelo/errorModelo.php";
require_once "../../dbConexion.php";
require_once "../../encrypt.php";
//clase para administrar los usuarios
class UserModelo{
    public $idUser;
    public $cedula;
    public $nameUser;
    public $lastName;
    public $email;
    public $userName;
    public $password;
    public $idRol;
    public $createdAt;
    public $enable;
    //funion constructor
    function __construct($idUser, $cedula, $nameUser, $lastName, $email, 
    $userName, $password, $idRol, $createdAt, $enable){
        $this->idUser=$idUser; 
        $this->cedula=$cedula; 
        $this->nameUser=$nameUser;
        $this->lastName=$lastName;
        $this->email=$email; 
        $this->userName=$userName; 
        $this->password=$password; 
        $this->idRol=$idRol;
        $this->createdAt=$createdAt; 
        $this->enable=$enable;
    }
    //funciones a usuarios en bd
    public static function guardarUser(UserModelo $user){
        $re = "";
        try {           
            $db=dbConexion::getConnect();
            $stmt = $db->prepare( "INSERT INTO `user`(`cedula`, `nameUser`, 
            `lastName`, `email`, `userName`, `password`, `idRol`, `createdAt`, `enable`)
            VALUES (:cedula, :nameUser, :lastName, :email, :userName, :password, 
            :idRol, :createdAt, :enable)");
            $stmt -> bindParam('cedula', $user->cedula);						        
            $stmt -> bindParam('nameUser', $user->nameUser);
            $stmt -> bindParam('lastName', $user->lastName);
            $stmt -> bindParam('email', $user->email);						        
            $stmt -> bindParam('userName', $user->userName);
            $stmt -> bindParam('password', $user->password);
            $stmt -> bindParam('idRol', $user->idRol);						        
            $stmt -> bindParam('createdAt', $user->createdAt);
            $stmt -> bindParam('enable', $user->enable);
            $stmt->execute();//Execute stmt
            $re = "Usuario agregado correctamente, puedes iniciar sesión";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Usuario no agregado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function verificarDatos($ced, $name, $email){
        $re = false;
        try {           
            $db=dbConexion::getConnect();
            $stmt = $db->prepare( "SELECT `idUser`, `cedula`, `nameUser`, `lastName`, 
            `email`, `userName`, `password`, `idRol`, `createdAt`, `updatedAt`, 
            `enable` FROM `user` WHERE `cedula` = :ced or `userName` = :nam or `email` = :ema ");
            $stmt -> bindParam('ced', $ced);
            $stmt -> bindParam('nam', $name);						        
            $stmt -> bindParam('ema', $email);
            $stmt->execute();//Execute stmt
            $resp = $stmt->fetch();
            if($resp === false) {
                $re = true;
            }            
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
        }
        return $re;
    }
    public static function consultarParaRecuperar($ced, $email, $name){
        try {
            $db=dbConexion::getConnect();
            $stmt = $db->prepare( "SELECT `idUser`, `cedula`, `nameUser`, `lastName`, 
            `email`, `userName`, `password`, `idRol`, `createdAt`, `updatedAt`, 
            `enable` FROM `user` WHERE `cedula` = :ced or `userName` = :nam or `email` = :ema ");
            $stmt -> bindParam('ced', $ced);
            $stmt -> bindParam('ema', $email);
            $stmt -> bindParam('nam', $name);			        
            $stmt->execute();//Execute stmt
            $resp = $stmt->fetch();
            if($resp === false) {
                echo '<script language="javascript">alert("Falló intento de recuperación");
                    window.location= "../Vista/RecoverContra.php";</script>';
            }else{
                if($resp["enable"] == 0){
                    echo '<script language="javascript">alert("Su usuario esta deshabilidato, contacte al administrador para habilitarlo.");
                    window.location= "../../index.php";</script>';
                } else{
                    UserModelo::actualizarPassw($resp["idUser"], $resp["userName"], $resp["email"]);
                    echo '<script language="javascript">alert("Puede iniciar sesion");
                    window.location= "../../index.php";</script>';
                }
            }
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = false;
        }
    }
    public static function actualizarPassw($IdUser, $user, $mail){
            $contraNsf = UserModelo::crearContraseña($user);
            $contrasf = userController::encriptar($contraNsf);
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `user` SET `password`= :pdw
            WHERE `idUser` = :id ';
            $select = $db->prepare($query);
            $select->bindValue ('pdw', $contrasf);
            $select->bindValue ('id', $IdUser);
            $select->execute();
            //ErrorModelo::agregarBitacoraBD($query);
            //envio de email
            $smod = new UserModelo(1,1,1,1,1,1,1,1,1,1,1);
            $smod->EnviarMail($mail, $contraNsf);
            $re = "Pass actualizada";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Pass no actualizada";
        }
        return $re;
    }
    public static function crearContraseña($text){
        $a = rand(1, 10);
        $num = "";
        for($i = 0; $i < $a; $i++){
            $num .= strval(rand(0, 10));
        }
        $pass = $text ."&" .$num;
        return $pass;
    }
    public function EnviarMail($des, $pasw){
        try {
            $destinatario = $des;
            $contra = $pasw;
            $titulo = "Recuparación de contraseña";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $mensaje = '
            <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    <meta name="viewport" content="width=device-width">
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundation-emails/2.2.1/foundation-emails.min.css" rel="stylesheet">
                    <title>My Password Reset</title>
                </head>
                <body>
                    <span class="preheader"></span>
                    <table class="body">
                        <tr>
                            <td align="center" class="center" valign="top">
                                <center data-parsed="">
                                    <style class="float-center" type="text/css">
                                        body,
                                        html,
                                        .body {
                                            background: #f3f3f3 !important;
                                        }
                                        
                                        .header {
                                            background: #f3f3f3;
                                        }
                                    </style>
                                    <!-- move the above styles into your custom stylesheet -->
                                    <table class="spacer float-center">
                                        <tbody>
                                            <tr>
                                                <td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table align="center" class="container float-center">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table class="row">
                                                        <tbody>
                                                            <tr>
                                                                <th class="small-12 large-12 columns first last">
                                                                    <table>
                                                                        <tr>
                                                                            <th>
                                                                                <table class="spacer">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td height="32px" style="font-size:32px;line-height:32px;">&#xA0;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <center data-parsed="">
                                                                                    <img src="https://img.icons8.com/fluent/96/000000/re-enter-pincode.png" />
                                                                                </center>
                                                                                <table class="spacer">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <h1 class="text-center">Su nueva contraseña</h1>
                                                                                <table class="spacer">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <table class="button large expand">
                                                                                    <tr>
                                                                                        <td>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <center class="float-center">
                                                                                                        <a class="primary float-center text-center">'.$contra.'</a>
                                                                                                    </center>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                        <td class="expander"></td>
                                                                                    </tr>
                                                                                </table>
                                                                                <hr>
                                                                                <p class="float-center"><small>Gracias por preferirinos</small></p>
                                                                            </th>
                                                                            <th class="expander"></th>
                                                                        </tr>
                                                                    </table>
                                                                </th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="spacer">
                                                        <tbody>
                                                            <tr>
                                                                <td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                            </td>
                        </tr>
                    </table>
                    <!-- prevent Gmail on iOS font size manipulation -->
                    <div style="display:none; white-space:nowrap; font:15px courier; line-height:0;"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </div>
                </body>
            </html>
            ';
            try {
                if (mail($destinatario, $titulo, $mensaje, $headers)){
                    echo '<script language="javascript">alert("Contraseña enviada a su correo con exito.");</script>';
                }
                else {
                    echo '<script language="javascript">alert("Contraseña no enviada a su correo intentelo nuevamente.");</script>';
                }
            } catch (\Throwable $th) {
                echo $th;
            }
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = false;
        }
    }
}
?>