<?php
require_once "../dbConexion.php";
class ErrorModelo{
    public $sentencia;
    public $controller;
    public $createdAt;
    public $idUser;
    function __construct($sentencia, $controller, $createdAt, $idUser){
        $this->sentencia = $sentencia;
        $this->controller = $controller;
        $this->createdAt = $createdAt;
        $this->idUser = $idUser;
    }
    //funcion para agregar los errores a la bd
    public static function agregarErroresBD($sentencia, $controller)
    {
        try {
            if ( !isset($_SESSION["idUser"]) ) {
                $idUser = 0;
             } else {
                $idUser = $_SESSION["idUser"];
             }            
            $db=dbConexion::getConnect();
            $query = "INSERT INTO `error`(`sentencia`, `controller`, 
            `idUser`)
            VALUES (:sentencia, :controller, :idUser)";
            $stmt = $db->prepare($query);
            $stmt -> bindParam('sentencia', $sentencia); 						        
            $stmt -> bindParam('controller', $controller);
            $stmt -> bindParam('idUser', $idUser);
            $stmt->execute();//Execute stmt
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            //ErrorModelo::agregarErroresBD($mensajeError, $file);
        }        
    }
    public static function agregarBitacoraBD($sentencia)
    {
        try {
            if ( !isset($_SESSION["idUser"]) ) {
                $idUser = 0;
             } else {
                $idUser = $_SESSION["idUser"];
             }
             $idc = $_SESSION["idController"];
             $idm = $_SESSION["idMenu"];
             //$a = 2;
            $db=dbConexion::getConnect();
            $stmt = $db->prepare('INSERT INTO `auditoria`(`sentencia`,
            `controller`, `idMenu`, `idUser`)
            VALUES ( :sentenci, :controlle, :idMen, :idUse)');
           // $stmt -> bindParam('id', $a);
            $stmt -> bindParam('sentenci', $sentencia); 						        
            $stmt -> bindParam('controlle', intval($idc)) ;
            $stmt -> bindParam('idMen', intval($idm)) ;
            $stmt -> bindParam('idUse', intval($idUser));
            $stmt->execute();//Execute stmt
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
        }        
    }
    public static function ConsultarRelacionMenuControlador($userId){
        try {
            $db=dbConexion::getConnect();
            
            $select=$db->prepare('SELECT U.nameUser, U.idRol, R.idMenu, 
            M.idCatalogoMenu, C.idController FROM user U, rol R, menu M, 
            relacionesmenu C WHERE U.idUser = :userId and R.idRol = U.idRol and 
            M.idMenu = R.idMenu and C.idCatalogoMenu = M.idCatalogoMenu');
            $select->bindValue('userId',$userId);
            $select->execute();
            //asignarlo al objeto 
            $menuCon=$select->fetch();            
            if($menuCon === false){
                return "Usuario no encontrado, intentelo nuevamente";
            } else {
                $_SESSION["idMenu"] =  $menuCon["idMenu"];
                $_SESSION["idController"] =  $menuCon["idController"];
                $_SESSION["idReMenCon"] =  $menuCon["idCatalogoMenu"];
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
    /*SELECT U.nameUser, U.idRol, R.idMenu, M.idCatalogoMenu, M.idMenu, 
    C.idController FROM user U, rol R, menu M, relacionesmenu C WHERE 
    U.idUser = 6 and R.idRol = U.idRol and M.idMenu = R.idMenu and 
    C.idCatalogoMenu = M.idCatalogoMenu*/
}
?>