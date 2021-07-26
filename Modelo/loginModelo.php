<?php
session_start();
require_once "../dbConexion.php";
require_once "errorModelo.php";
    class loginModelo{
            public $idUser;
            public $username;
            public $password;
            public $enab;
            public $idRol;
            //constructor
            function __construct($idUser, $uname, $paw, $enab, $idRol)
            {
                $this->idUser=$idUser;
                $this->username=$uname;
                $this->password=$paw;
                $this->enab=$enab;
                $this->idRol=$idRol;
            }
        //funcion para consultar datos de inicio de sesion
        public static function loginFuncion( string $user, string $pswd, bool $enab = true ){	
            try {
                $db=dbConexion::getConnect();
                $query = '"SELECT idUser, userName, `password`, idRol, `enable` 
                FROM user WHERE userName = :user AND `password`=:pswd AND `enable` = :enab"';
                $select=$db->prepare('SELECT idUser, userName, `password`, idRol, `enable` 
                FROM user WHERE userName = :user AND `password`=:pswd AND `enable` = :enab');
                $select->bindValue('user',$user);
                $select->bindValue('pswd',$pswd);
                $select->bindValue('enab',$enab);
                $select->execute();
                //asignarlo al objeto 
                $UserDb=$select->fetch();
                if($UserDb === false){
                    return "Datos incorrectos, intentelo nuevamente";
                  } else {
                    $login= new loginModelo($UserDb['idUser'], $UserDb['userName'], $UserDb['password'], $UserDb['idRol'], $UserDb['enable'] );
                    $_SESSION["idUser"] = $login->idUser;
                    $_SESSION["userName"] = $login->username;
                    $_SESSION["idRol"] = $login->idRol;
                    header ("Location: ../Vista/inicio.php");
                    ErrorModelo::ConsultarRelacionMenuControlador($login->idUser);
                    ErrorModelo::agregarBitacoraBD("Login: " .$query);
                  }
            } catch(Exception $ex) {
                $code = $ex->getCode();
                $message = $ex->getMessage();
                $file = $ex->getFile();
                $line = $ex->getLine();
                $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";
                ErrorModelo::agregarErroresBD($mensajeError, $file);
                return "Error inesperado, contacte al administrador";
            }            	
        }
    }//fin de la clase
?>