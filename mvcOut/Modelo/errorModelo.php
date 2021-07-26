<?php
require_once "../../dbConexion.php";
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
            $db=dbConexion::getConnect();
            $stmt = $db->prepare( "INSERT INTO `error`(`sentencia`, `controller`, `idUser`)
            VALUES (:sentencia, :controller, :idUser)");
            $stmt -> bindParam('sentencia', $sentencia); 						        
            $stmt -> bindParam('controller', $controller);
            $stmt -> bindParam('idUser', 0);
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
}
?>