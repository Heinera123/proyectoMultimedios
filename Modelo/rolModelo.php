<?php
require_once "errorModelo.php";
require_once "../dbConexion.php";
//clase para administrar los roles
class RolModelo{
    public $idRol;
    public $nameRol;
    public $idMenu;
    public $createdAt;
    public $updatedAt;
    public $enabled;
    //funion constructor
    function __construct($idRol, $nameRol, $idMenu, $createdAt, $updatedAt, $enabled){
        $this->idRol=$idRol; 
        $this->nameRol=$nameRol; 
        $this->idMenu=$idMenu;
        $this->createdAt=$createdAt;
        $this->updatedAt=$updatedAt;
        $this->enabled=$enabled;
    }
    //funciones a rol en bd
    public static function guardarRol(RolModelo $rol){
        $re = "";
        try {           
            $db=dbConexion::getConnect();
            $query = "INSERT INTO `rol`(`nameRol`, `idMenu`,
            `createdAt`, `enabled`) VALUES (:nameR, 
            :idMen, :createdA, :enable)";
            $stmt = $db->prepare($query);					        
            $stmt -> bindParam('nameR', $rol->nameRol);
            $stmt -> bindParam('idMen', $rol->idMenu);
            $stmt -> bindParam('createdA', $rol->createdAt);						        
            $stmt -> bindParam('enable', $rol->enabled);
            $stmt->execute();//Execute stmt
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Rol agregado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = $mensajeError;//= "Rol no agregado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function ConsultarTodosRol(){
        try {
            $listaRoles =[];
            $db=dbConexion::getConnect();
            $select=$db->query('SELECT `idRol`, `nameRol`, `idMenu`, `createdAt`, `updatedAt`, `enabled` FROM `rol` order by `enabled` DESC');
            //asignarlo al objeto 
            $RolDb=$select->fetchAll();
            // carga en la $listaroless cada registro desde la base de datos
            foreach ($RolDb as $rol) {
                $listaRoles[]= new RolModelo($rol['idRol'],
                $rol['nameRol'], $rol['idMenu'], $rol['createdAt'], $rol['updatedAt'], $rol['enabled']);
            }
            return $listaRoles;
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
        }
       
    }
    public static function ConsultarRol($RolId){
        try {
            $db=dbConexion::getConnect();
            
            $select=$db->prepare('SELECT `idRol`, `nameRol`, `idMenu`, `createdAt`, `updatedAt`, 
            `enabled` FROM `rol` WHERE `idRol` = :rolId');
            $select->bindValue('rolId',$RolId);
            $select->execute();
            //asignarlo al objeto 
            $rol=$select->fetch();
            $rolSeleccionado=new RolModelo($rol['idRol'],
            $rol['nameRol'], $rol['idMenu'], $rol['createdAt'], $rol['updatedAt'], $rol['enabled']);
            if($rol === false){
                return "Rol no encontrado, intentelo nuevamente";
            } else {
                return $rolSeleccionado;
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
    public static function borrarRol($idRol){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `rol` SET `enabled`= 0 WHERE 
            `idRol` = :id';
            $select = $db->prepare($query);
            $select->bindValue ('id', $idRol);
            $select->execute();
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Rol eliminado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Rol no eliminado correctamente, revise las asignacioes de roles o contacte al administrador";
        }
        return $re;
    }
    public static function updateRol(RolModelo $rolUpd){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `rol` SET
            `nameRol`=:nameRol,`idMenu`=:idMenu,`enabled`=:enabled 
            WHERE `idRol` = :idRol';
            $stmt = $db->prepare($query);						        
            $stmt -> bindParam('nameRol', $rolUpd->nameRol);
            $stmt -> bindParam('idMenu', $rolUpd->idMenu);					        
            $stmt -> bindParam('enabled', $rolUpd->enabled);
            $stmt -> bindParam('idRol', $rolUpd->idRol);
            $stmt->execute();//Execute stmt
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Rol actualizado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Rol no actualizado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function devolverMenus(){
        try {
            $db=dbConexion::getConnect();
            $select=$db->query('SELECT `idMenu`, `nameMenu` FROM `menu`');
            //asignarlo al objeto
            $menusDb=$select->fetchAll();            
            return $menusDb;
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