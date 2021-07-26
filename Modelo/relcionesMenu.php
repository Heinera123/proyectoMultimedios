<?php
require_once "errorModelo.php";
require_once "../dbConexion.php";
//clase para administrar los roles
class relacionesMenu{
    public $idCatalogoMenu;
    public $idMenu;
    public $idController;
    public $createdAt;
    //funion constructor
    function __construct($idCatalogoMenu, $idMenu, $idController, $createdAt){
        $this->idCatalogoMenu=$idCatalogoMenu; 
        $this->idMenu=$idMenu; 
        $this->idController=$idController;
        $this->createdAt=$createdAt;
    }
    public static function consutarRelaciones(){
            try {
                $relaciones=[];
                $db=dbConexion::getConnect();
                $select=$db->prepare('SELECT `idCatalogoMenu`, `idMenu`, `idController`, 
                `createdAt` FROM `relacionesmenu`');
                $select->execute();
                //asignarlo al objeto 
                $rela=$select->fetchAll();                
                if($rela === false){
                    return "Rol no encontrado, intentelo nuevamente";
                } else {
                    foreach ($rela as $relacion) {
                        $relaciones[] = new relacionesMenu($relacion['idCatalogoMenu'],
                        $relacion['idMenu'], $relacion['idController'], $relacion['createdAt']);
                    }
                    return $relaciones;
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

}
?>