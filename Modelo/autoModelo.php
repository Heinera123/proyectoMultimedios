<?php
require_once "errorModelo.php";
require_once "../dbConexion.php";
//clase para administrar los autos
class AutoModelo{
    public $id;
    public $placa;
    public $marca;
    public $modelo;
    public $precio;
    public $enabled;
    public $created_at;
    public $update_at;

    //funion constructor
    function __construct($id,$placa,$marca,$modelo,$precio,$enabled,$created_at,$update_at){
        $this->id=$id; 
        $this->placa=$placa; 
        $this->marca=$marca;
        $this->modelo=$modelo;
        $this->precio=$precio; 
        $this->enabled = $enabled; 
        $this->created_at=$created_at; 
        $this->update_at = $update_at;
    }
    //funciones a autos en bd
    public static function guardarauto(autoModelo $auto){
        $re = "";
        try {           
            $db=dbConexion::getConnect();
            $query = "INSERT INTO `auto`(`placa`, `marca`, 
            `modelo`, `precio`, `enabled`)
            VALUES (:placa, :marca, :modelo, :precio, 
            :enabled)";
            $stmt = $db->prepare($query);
            $stmt -> bindParam('placa', $auto->placa);						        
            $stmt -> bindParam('marca', $auto->marca);
            $stmt -> bindParam('modelo', $auto->modelo);
            $stmt -> bindParam('precio', $auto->precio);
            $stmt -> bindParam('enabled', $auto->enabled);						        
            //$stmt -> bindParam('createdAt', $auto->created_at);
            //$stmt -> bindParam('updateAt', $auto->update_at);
            $stmt->execute();//Execute stmt
            ErrorModelo::agregarBitacoraBD($query);
            $re = "auto agregado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "auto no agregado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function ConsultarTodosauto(){
        try {
            $listaautos =[];
            $db=dbConexion::getConnect();
            $select=$db->query('SELECT `id`, `placa`, `marca`, `modelo`, 
            `precio`, `enabled`, `created_at`, `update_at` FROM auto order by `enabled` DESC');
            //asignarlo al objeto 
            $autosDb=$select->fetchAll();
            // carga en la $listaautos cada registro desde la base de datos
            foreach ($autosDb as $auto) {
                $listaautos[]= new autoModelo($auto['id'], $auto['placa'], 
                $auto['marca'], $auto['modelo'], $auto['precio'],
                 $auto['enabled'], $auto['created_at'],
                 $auto['update_at']);
            }
            return $listaautos;
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
        }
       
    }
    public static function ConsultarTodosautosHabilitados($idAuto){
        try {
            $db=dbConexion::getConnect();
            $query = ('SELECT `id`, `placa`, `marca`, `modelo`, 
            `precio`, `enabled`, `created_at`, `update_at` FROM auto where `enabled` = 1 
            or `id` = :idAuto');
            $select=$db->Prepare($query);
            // $stmt = $db->prepare($query);
            $select -> bindParam('idAuto', $idAuto);
            $select->execute();//Execute stmt
            //asignarlo al objeto 
            $autosDb=$select->fetchAll();
            
            return $autosDb;
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
        }       
    }
    public static function Consultarauto($autoId){
        try {
            $db=dbConexion::getConnect();
            
            $select=$db->prepare('SELECT `id`, `placa`, `marca`, `modelo`, 
            `precio`, `enabled`, `created_at`, `update_at` FROM `auto` WHERE `id` = :autoId');
            $select->bindValue('autoId',$autoId);
            $select->execute();
            //asignarlo al objeto 
            $auto=$select->fetch();
            $autoSeleccionado= new autoModelo($auto['id'], $auto['placa'], 
            $auto['marca'], $auto['modelo'], $auto['precio'],
             $auto['enabled'], $auto['created_at'], $auto['update_at']);
            if($auto === false){
                return "auto no encontrado, intentelo nuevamente";
            } else {
                return $autoSeleccionado;
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
    public static function borrarauto($id){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `auto` SET `enabled`= 0 WHERE 
            `id` = :id';
            $select = $db->prepare($query);
            $select->bindValue ('id', $id);
            $select->execute();
            ErrorModelo::agregarBitacoraBD($query);
            $re = "auto eliminado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "auto no eliminado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function habilitarauto($id){
        try {
            $re = null;
            $db = dbConexion::getConnect();
            $query = 'UPDATE `auto` SET `enabled`= 1 WHERE 
            `id` = :id';
            $select = $db->prepare($query);
            $select->bindValue ('id', $id);
            $select->execute();
            $re = "auto habilitado correctamente";
            ErrorModelo::agregarBitacoraBD($query);
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "auto no habilitado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function updateauto(autoModelo $autoUpd ){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `auto` SET `placa`=:placa,
            `marca`=:marca,`modelo`=:modelo,`precio`=:precio,
            `enabled`=:enabled WHERE `id` = :id';
            $select = $db->prepare($query);
            $select->bindValue ('placa', $autoUpd->placa);
            $select->bindValue ('marca', $autoUpd->marca);
            $select->bindValue ('modelo', $autoUpd->modelo);
            $select->bindValue ('precio', $autoUpd->precio);
            $select->bindValue ('enabled', $autoUpd->enabled);
            $select->bindValue ('id', $autoUpd->id);
            $select->execute();
            ErrorModelo::agregarBitacoraBD($query);
            $re = "auto actualizado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "auto no actualizado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
}
?>