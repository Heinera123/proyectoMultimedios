<?php
require_once "errorModelo.php";
require_once "../dbConexion.php";
//clase para administrar los roles
class SucursalModelo{
    public $id;
    public $provincia;
    public $canton;
    public $distrito;
    public $direccion;
    public $createdAt;
    public $updatedAt;
    public $enabled;
    //funion constructor
    function __construct($id, $provincia, $canton, $distrito, $direccion, $createdAt, $updatedAt, $enabled){
        $this->id=$id; 
        $this->provincia=$provincia; 
        $this->canton=$canton;
        $this->distrito=$distrito;
        $this->direccion=$direccion;
        $this->createdAt=$createdAt;
        $this->updatedAt=$updatedAt;
        $this->enabled=$enabled;
    }
    //funciones a sucursal en bd
    public static function guardarSucusal(SucursalModelo $sucursal){
        $re = "";
        try {   
            $db=dbConexion::getConnect();
            $query = "INSERT INTO `sucursal`(`provincia`, `canton`, `distrito`, `direccion`,
            `createdAt`, `enabled`) VALUES (:provincia, :canton, :distrito, 
            :direccion, :createdAt, :enabled)";
            $stmt = $db->prepare($query);					        
            $stmt -> bindParam('provincia', $sucursal->provincia);
            $stmt -> bindParam('canton', $sucursal->canton);
            $stmt -> bindParam('distrito', $sucursal->distrito);
            $stmt -> bindParam('direccion', $sucursal->direccion);
            $stmt -> bindParam('createdAt', $sucursal->createdAt);						        
            $stmt -> bindParam('enabled', $sucursal->enabled);
            $stmt->execute();//Execute stmt
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Sucursal agregado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = $mensajeError;//= "Sucursal no agregado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function ConsultarTodasSucursales(){
        try {
            $listaSucursales =[];
            $db=dbConexion::getConnect();
            $select=$db->query('SELECT `id`, `provincia`, `canton`, `distrito`, `direccion`, `createdAt`, `updatedAt`, `enabled` FROM `sucursal` order by `enabled` DESC');
            //asignarlo al objeto 
            $SucursalDb=$select->fetchAll();
            // carga en la $listaSucursales cada registro desde la base de datos
            foreach ($SucursalDb as $sucursal) {
                $listaSucursales[]= new SucursalModelo($sucursal['id'],
                $sucursal['provincia'], $sucursal['canton'], $sucursal['distrito'], $sucursal['direccion'], $sucursal['createdAt'], $sucursal['updatedAt'], $sucursal['enabled']);
            }
            return $listaSucursales;
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
        }
       
    }
    public static function ConsultarSucursal($id){
        try {
            $db=dbConexion::getConnect();
            $select=$db->prepare('SELECT `id`, `provincia`, `canton`, `distrito`, `direccion`, `createdAt`, `updatedAt`, `enabled` 
            FROM `sucursal`  WHERE `id` = :id');
            $select->bindValue('id',$id);
            $select->execute();
            //asignarlo al objeto 
            $sucursal=$select->fetch();
            $sucursalSeleccionado=new SucursalModelo($sucursal['id'],
            $sucursal['provincia'], $sucursal['canton'], $sucursal['distrito'], $sucursal['direccion'], $sucursal['createdAt'], $sucursal['updatedAt'], $sucursal['enabled']);

            if($sucursal === false){
                return "Sucursal no encontrada, intentelo nuevamente";
            } else {
                return $sucursalSeleccionado;
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
    public static function borrarSucursal($id){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `sucursal` SET `enabled`= 0 WHERE 
            `id` = :id';
            $select = $db->prepare($query);
            $select->bindValue ('id', $id);
            $select->execute();
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Sucursal eliminada correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Sucursal no eliminado correctamente, revise las asignacioes de roles o contacte al administrador";
        }
        return $re;
    }
    public static function updateSucursal(SucursalModelo $sucursalUpd){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `sucursal` SET
            `provincia`=:provincia,`canton`=:canton,`distrito`=:distrito,`direccion`=:direccion,`enabled`=:enabled 
            WHERE `id` = :id';
            $stmt = $db->prepare($query);		
            $stmt -> bindParam('id', $sucursalUpd->id);				        
            $stmt -> bindParam('provincia', $sucursalUpd->provincia);
            $stmt -> bindParam('canton', $sucursalUpd->canton);
            $stmt -> bindParam('distrito', $sucursalUpd->distrito);
            $stmt -> bindParam('direccion', $sucursalUpd->direccion);				        
            $stmt -> bindParam('enabled', $sucursalUpd->enabled);
            $stmt->execute();//Execute stmt
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Sucursal actualizada correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Sucursal no actualizada correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
}
?>