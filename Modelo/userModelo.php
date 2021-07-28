<?php
require_once "errorModelo.php";
require_once "../dbConexion.php";
require_once "../Modelo/userModelo.php";
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
            $query = "INSERT INTO `user`(`cedula`, `nameUser`, 
            `lastName`, `email`, `userName`, `password`, `idRol`, `createdAt`, `enable`)
            VALUES (:cedula, :nameUser, :lastName, :email, :userName, :password, 
            :idRol, :createdAt, :enable)";
            $stmt = $db->prepare($query);
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
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Usuario agregado correctamente";
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
    public static function ConsultarTodosUsuario(){
        try {
            $listaUsuarios =[];
            $db=dbConexion::getConnect();
            $select=$db->query('SELECT `idUser`, `cedula`, `nameUser`, `lastName`, 
            `email`, `userName`, `idRol`, `createdAt`, `enable` FROM user order by `enable` DESC');
            //asignarlo al objeto 
            $UsersDb=$select->fetchAll();
            // carga en la $listaUsuarios cada registro desde la base de datos
            foreach ($UsersDb as $usuario) {
                $listaUsuarios[]= new UserModelo($usuario['idUser'], $usuario['cedula'], 
                $usuario['nameUser'], $usuario['lastName'], $usuario['email'],
                $usuario['userName'], null, $usuario['idRol'], $usuario['createdAt'], $usuario['enable']);
            }
            return $listaUsuarios;
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
        }
       
    }
    public static function ConsultarTodosUsuarioHabilitado(){
        try {
            $listaUsuarios =[];
            $db=dbConexion::getConnect();
            $select=$db->query('SELECT `idUser`, `cedula`, `nameUser`, `lastName`, 
            `email`, `userName`, `idRol`, `createdAt`, `enable` FROM user order by `enable` DESC');
            //asignarlo al objeto 
            $UsersDb=$select->fetchAll();
        
            return $UsersDb;
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
        }
       
    }
    public static function ConsultarUsuario($userId){
        try {
            $db=dbConexion::getConnect();
            
            $select=$db->prepare('SELECT `idUser`, `cedula`, `nameUser`, `lastName`, 
            `email`, `userName`, `idRol`, `createdAt`, `enable` FROM `user` WHERE `idUser` = :userId');
            $select->bindValue('userId',$userId);
            $select->execute();
            //asignarlo al objeto 
            $usuario=$select->fetch();
            $usuarioSeleccionado= new UserModelo($usuario['idUser'], $usuario['cedula'], 
            $usuario['nameUser'], $usuario['lastName'], $usuario['email'],
            $usuario['userName'], null, $usuario['idRol'], $usuario['createdAt'], $usuario['enable']);
            if($usuario === false){
                return "Usuario no encontrado, intentelo nuevamente";
            } else {
                return $usuarioSeleccionado;
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
    public static function borrarUser($idUser){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `user` SET `enable`= 0 WHERE 
            `idUser` = :id';
            $select = $db->prepare($query);
            $select->bindValue ('id', $idUser);
            $select->execute();
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Usuario eliminado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Usuario no eliminado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function updateUser(UserModelo $userUpd ){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `user` SET `cedula`=:cedula,
            `nameUser`=:nameU,`lastName`=:lastN,`email`=:email,
            `idRol`=:idRol,`enable`=:enab WHERE `idUser` = :idUser';
            $select = $db->prepare($query);
            $select->bindValue ('cedula', $userUpd->cedula);
            $select->bindValue ('nameU', $userUpd->nameUser);
            $select->bindValue ('lastN', $userUpd->lastName);
            $select->bindValue ('email', $userUpd->email);
            $select->bindValue ('idRol', $userUpd->idRol);
            $select->bindValue ('enab', $userUpd->enable);
            $select->bindValue ('idUser', $userUpd->idUser);
            $select->execute();
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Usuario actualizado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Usuario no actualizado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function devolverRoles(){
        try {
            $db=dbConexion::getConnect();
            $select=$db->query('SELECT `idRol`, `nameRol` FROM `rol`');
            //asignarlo al objeto
            $rolesDb=$select->fetchAll();
            
            return $rolesDb;
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
        }
    }
}
?>