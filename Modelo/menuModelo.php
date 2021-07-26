<?php
require_once "errorModelo.php";
require_once "../dbConexion.php";
//clase para administrar los Menus
class menuModelo{
    public $idmenu;
    public $nameMenu;
    public $idCatalogoMenu;
    public $createdAt;
    public $updatedAt;
    public $enable;
    //funion constructor
    function __construct($idmenu, $nameMenu, $idCatalogoMenu,
     $createdAt, $updatedAt, $enable){
        $this->idmenu=$idmenu; 
        $this->nameMenu=$nameMenu;
        $this->idCatalogoMenu=$idCatalogoMenu;
        $this->createdAt=$createdAt;
        $this->updatedAt=$updatedAt;  
        $this->enable=$enable;
    }
    //funciones a Menus en bd
    public static function guardarMenu(menuModelo $menu){
        $re = "";
        try {           
            $db=dbConexion::getConnect();
            $query = "INSERT INTO `menu`(`nameMenu`, 
            `idCatalogoMenu`, `createdAt`, `enable`)
            VALUES (:nameMenu, :idCatalogoMenu, :createdAt, :enable)";
            $stmt = $db->prepare($query);
            $stmt -> bindParam('nameMenu', $menu->nameMenu);						        
            $stmt -> bindParam('namemenu', $menu->namemenu);
            $stmt -> bindParam('idCatalogoMenu', $menu->idCatalogoMenu);						        
            $stmt -> bindParam('createdAt', $menu->createdAt);
            $stmt -> bindParam('enable', $menu->enable);
            $stmt->execute();//Execute stmt
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Menu agregado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Menu no agregado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function ConsultarTodosMenu(){
        try {
            $listaMenus =[];
            $db=dbConexion::getConnect();
            $select=$db->query('SELECT `idMenu`, `nameMenu`, `idCatalogoMenu`, `createdAt`, `updatedAt`, `enabled` FROM `menu` order by `enabled` DESC');
            //asignarlo al objeto 
            $menusDb=$select->fetchAll();
            // carga en la $listaMenus cada registro desde la base de datos
            foreach ($menusDb as $Menu) {
                $listaMenus[]= new menuModelo($Menu['idMenu'],
                $Menu['nameMenu'], $Menu['idCatalogoMenu'], $Menu['createdAt'],$Menu['updatedAt'], $Menu['enabled']);
            }
            return $listaMenus;
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
        }
       
    }
    public static function ConsultarMenu($menuId){
        try {
            $db=dbConexion::getConnect();
            
            $select=$db->prepare('SELECT `idMenu`, `nameMenu`, `idCatalogoMenu`,
             `createdAt`, `updatedAt`, `enabled` FROM `menu` WHERE `idmenu` = :menuId');
            $select->bindValue('menuId',$menuId);
            $select->execute();
            //asignarlo al objeto 
            $Menu=$select->fetch();
            $MenuSeleccionado= new menuModelo($Menu['idMenu'], $Menu['nameMenu'], $Menu['idCatalogoMenu'],
             $Menu['createdAt'], $Menu['updatedAt'], $Menu['enabled']);
            if($Menu === false){
                return "Menu no encontrado, intentelo nuevamente";
            } else {
                return $MenuSeleccionado;
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
    public static function borrarMenu($idmenu){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `menu` SET `enabled`= 0
            WHERE `idMenu` = :id';
            $select = $db->prepare($query);
            $select->bindValue ('id', $idmenu);
            $select->execute();
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Menu eliminado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Menu no eliminado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function updateMenu(menuModelo $menuUpd ){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `menu` SET `nameMenu`=:nameMen,
            `idCatalogoMenu`=:idCatalogoMen,`enabled`=:enab WHERE `idMenu` = :idmenu';
            $select = $db->prepare($query);
            $select->bindValue ('nameMen', $menuUpd->nameMenu);
            $select->bindValue ('idCatalogoMen', $menuUpd->idCatalogoMenu);
            $select->bindValue ('enab', $menuUpd->enable);
            $select->bindValue ('idmenu', $menuUpd->idmenu);
            $select->execute();
            ErrorModelo::agregarBitacoraBD($query);
            $re = "Menu actualizado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "Menu no actualizado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    //////******************** */
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