<?php
require_once "errorModelo.php";
require_once "../dbConexion.php";
//clase para administrar los controllers
class controllerModelo{
    public $idController;
    public $nameControllerView;
    public $createdAt;
    public $updatedAt;
    public $enabled;
    //funion constructor
    function __construct($idController, $nameControllerView,
     $createdAt, $updatedAt, $enabled){
        $this->idController=$idController; 
        $this->nameControllerView=$nameControllerView; 
        $this->createdAt=$createdAt;
        $this->updatedAt=$updatedAt;  
        $this->enabled=$enabled;
    }
    //funciones a controllers en bd
    public static function guardarcontroller(controllerModelo $controller){
        $re = "";
        try {           
            $db=dbConexion::getConnect();
            $query = "INSERT INTO `controller`(`nameControllerView`, 
            `createdAt`, `enabled`)
           VALUES (:nameControllerView, :createdAt, :enable)";
            $stmt = $db->prepare($query);
            $stmt -> bindParam('nameControllerView', $controller->nameControllerView);						        
            $stmt -> bindParam('createdAt', $controller->createdAt);
            $stmt -> bindParam('enable', $controller->enabled);
            $stmt->execute();//Execute stmt
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Controlador agregado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Controlador no agregado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function ConsultarTodoscontroller(){
        try {
            $listacontrollers =[];
            $db=dbConexion::getConnect();
            $query = 'SELECT `idController`, `nameControllerView`, 
            `createdAt`, `updatedAt`, `enabled` FROM `controller` order by
             `enabled` DESC';
            $select=$db->query($query);
            //asignarlo al objeto 
            $controllersDb=$select->fetchAll();
            // carga en la $listacontrollers cada registro desde la base de datos
            foreach ($controllersDb as $controller) {
                $listacontrollers[]= new controllerModelo($controller['idController'],
                $controller['nameControllerView'], $controller['createdAt'],$controller['updatedAt'], $controller['enabled']);
            }
            ErrorModelo::agregarBitacoraBD($query);
            return $listacontrollers;
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
        }
       
    }
    public static function Consultarcontroller($controllerId){
        try {
            $db=dbConexion::getConnect();
            $query = 'SELECT `idController`, `nameControllerView`,
            `createdAt`, `updatedAt`, `enabled` FROM `controller` 
            WHERE `idController` = :controllerId';
            $select=$db->prepare($query);
            $select->bindValue('controllerId',$controllerId);
            $select->execute();
            //asignarlo al objeto 
            $controller=$select->fetch();
            $controllerSeleccionado= new controllerModelo($controller['idController'], $controller['nameControllerView'],
             $controller['createdAt'], $controller['updatedAt'], $controller['enabled']);
            if($controller === false){
                return "Controlador no encontrado, intentelo nuevamente";
            } else {
                ErrorModelo::agregarBitacoraBD($query);
                return $controllerSeleccionado;
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
    public static function borrarcontroller($idController){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `controller` SET `enabled`= 0 
            WHERE `idController` = :id';
            $select = $db->prepare($query);
            $select->bindValue ('id', $idController);
            $select->execute();
            ErrorModelo::ConsultarRelacionMenuControlador($_SESSION["idUser"]);
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Controlador eliminado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Controlador no eliminado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function updatecontroller(controllerModelo $controllerUpd ){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `controller` SET `nameControllerView`=:nameMen,
            `enabled`=:enab WHERE `idController` = :idController';
            $select = $db->prepare($query);
            $select->bindValue ('nameMen', $controllerUpd->nameControllerView);
            $select->bindValue ('enab', $controllerUpd->enabled);
            $select->bindValue ('idController', $controllerUpd->idController);
            $select->execute();
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Controlador actualizado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = $mensajeError;
            //$re = "controller no actualizado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    //////*********************/
    public static function devolverRoles(){
        try {
            $db=dbConexion::getConnect();
            $query = 'SELECT `idRol`, `nameRol` FROM `rol`';
            $select=$db->query($query);
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