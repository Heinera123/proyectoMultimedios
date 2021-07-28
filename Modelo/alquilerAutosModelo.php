<?php
require_once "errorModelo.php";
require_once "../dbConexion.php";
require_once "AutoModelo.php";
//clase para administrar los alquilerAutos
class alquilerAutoModelo{
    public $id;
    public $idAuto;
    public $idUser;
    public $fechaAlquiler;
    public $email;
    public $fechaDevolucion;
    public $montoPagar;
    public $cancelado;
    public $created_At;
    public $update_at;
    //funion constructor
    function __construct($id, $idAuto, $idUser, $fechaAlquiler, $email, 
    $fechaDevolucion, $montoPagar, $cancelado, $created_At, $update_at){
        $this->id=$id; 
        $this->idAuto=$idAuto; 
        $this->idUser=$idUser;
        $this->fechaAlquiler=$fechaAlquiler;
        $this->email=$email; 
        $this->fechaDevolucion=$fechaDevolucion; 
        $this->montoPagar=$montoPagar; 
        $this->cancelado=$cancelado;
        $this->created_At=$created_At; 
        $this->update_at=$update_at;
    }
    //funciones a alquilerAutos en bd
    public static function guardaralquilerAuto(alquilerAutoModelo $alquilerAuto){
        $re = "";
        try {           
            $db=dbConexion::getConnect();
            $query = "INSERT INTO `alquilerAuto`(`idAuto`, `idUser`, 
            `fechaAlquiler`, `email`, `fechaDevolucion`, `montoPagar`, `cancelado`)
            VALUES (:idAuto, :idUser, :fechaAlquiler, :email, 
            :fechaDevolucion, :montoPagar, 
            :cancelado)";
            $stmt = $db->prepare($query);
            $stmt -> bindParam('idAuto', $alquilerAuto->idAuto);						        
            $stmt -> bindParam('idUser', $alquilerAuto->idUser);
            $stmt -> bindParam('fechaAlquiler', $alquilerAuto->fechaAlquiler);
            $stmt -> bindParam('email', $alquilerAuto->email);						        
            $stmt -> bindParam('fechaDevolucion', $alquilerAuto->fechaDevolucion);
            $stmt -> bindParam('montoPagar', $alquilerAuto->montoPagar);
            $stmt -> bindParam('cancelado', $alquilerAuto->cancelado);
            $stmt->execute();//Execute stmt
            autoModelo::borrarauto($alquilerAuto->idAuto);
            ErrorModelo::agregarBitacoraBD($query);
            $re = "alquilerAuto agregado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "alquilerAuto no agregado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function ConsultarTodosalquilerAuto(){
        try {
            $listaalquilerAutos =[];
            $db=dbConexion::getConnect();
            $select=$db->query('SELECT `id`, `idAuto`, `idUser`, `fechaAlquiler`, 
            `email`, `fechaDevolucion`,`montoPagar`,  `cancelado`, `created_at`, `update_at` FROM alquilerAuto 
            order by `FechaAlquiler` DESC');
            //asignarlo al objeto 
            $alquilerAutosDb=$select->fetchAll();
            // carga en la $listaalquilerAutos cada registro desde la base de datos
            foreach ($alquilerAutosDb as $alquilerAuto) {
                $listaalquilerAutos[]= new alquilerAutoModelo($alquilerAuto['id'], $alquilerAuto['idAuto'], 
                $alquilerAuto['idUser'], $alquilerAuto['fechaAlquiler'], $alquilerAuto['email'],
                $alquilerAuto['fechaDevolucion'], $alquilerAuto['montoPagar'], $alquilerAuto['cancelado'], 
                $alquilerAuto['created_at'], $alquilerAuto['update_at']);
            }
            return $listaalquilerAutos;
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
        }
       
    }
    public static function ConsultaralquilerAuto($alquilerAutoId){
        try {
            $db=dbConexion::getConnect();
            
            $select=$db->prepare('SELECT `id`, `idAuto`, `idUser`, `fechaAlquiler`, 
            `email`, `fechaDevolucion`, `montoPagar`, `cancelado`, `created_at`, `update_at` FROM 
            `alquilerAuto` WHERE `id` = :alquilerAutoId');
            $select->bindValue('alquilerAutoId',$alquilerAutoId);
            $select->execute();
            //asignarlo al objeto 
            $alquilerAuto=$select->fetch();
            $alquilerAutoSeleccionado= new alquilerAutoModelo($alquilerAuto['id'], $alquilerAuto['idAuto'], 
            $alquilerAuto['idUser'], $alquilerAuto['fechaAlquiler'], $alquilerAuto['email'],
            $alquilerAuto['fechaDevolucion'], $alquilerAuto['montoPagar'], $alquilerAuto['cancelado'], 
            $alquilerAuto['created_at'], $alquilerAuto['update_at']);
            if($alquilerAuto === false){
                return "alquilerAuto no encontrado, intentelo nuevamente";
            } else {
                return $alquilerAutoSeleccionado;
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
    public static function borraralquilerAuto($id, $idAuto){
        try {
            $db = dbConexion::getConnect();
            $query = 'UPDATE `alquilerAuto` SET `cancelado`= 0 WHERE 
            `id` = :id';
            $select = $db->prepare($query);
            $select->bindValue ('id', $id);
            $select->execute();
            autoModelo::habilitarauto($idAuto);
            ErrorModelo::agregarBitacoraBD($query);
            $re = "alquilerAuto eliminado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "alquilerAuto no eliminado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function updatealquilerAuto(alquilerAutoModelo $alquilerAutoUpd ){
        try {
            $db = dbConexion::getConnect();
            $query = " UPDATE `alquilerauto` SET `idAuto` = :idAuto, `idUser` = :idUser, 
            `fechaAlquiler` = :fechaAlquiler, `email` = :email, `fechaDevolucion` = :fechaDevolucion,
             `montoPagar` = :montoPagar, 
            `cancelado` = :cancelado WHERE  `id` = :id";
            $stmt = $db->prepare($query);
            $stmt -> bindParam('idAuto', $alquilerAutoUpd->idAuto);						        
            $stmt -> bindParam('idUser', $alquilerAutoUpd->idUser);
            $stmt -> bindParam('fechaAlquiler', $alquilerAutoUpd->fechaAlquiler);
            $stmt -> bindParam('email', $alquilerAutoUpd->email);						        
            $stmt -> bindParam('fechaDevolucion', $alquilerAutoUpd->fechaDevolucion);
            $stmt -> bindParam('montoPagar', $alquilerAutoUpd->montoPagar);
            $stmt -> bindParam('cancelado', $alquilerAutoUpd->cancelado);
            $stmt -> bindParam('id', $alquilerAutoUpd->id);
            $stmt->execute();
            ErrorModelo::agregarBitacoraBD($query);
            $re = "alquilerAuto actualizado correctamente";
        } catch (\Throwable $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $mensajeError = "Exception thrown in $file on line $line: [Code $code] $message";            
            ErrorModelo::agregarErroresBD($mensajeError, $file);
            $re = "alquilerAuto no actualizado correctamente, intentelo de nuevo o contacte al administrador";
        }
        return $re;
    }
    public static function devolverMontoPagar($idAuto, $fechaAlquiler, $fechaDevolucion){
        try {
            $db=dbConexion::getConnect();
            require_once "autoModelo.php";
            $autoCon = AutoModelo::Consultarauto($idAuto);
            $a = new DateTime($fechaAlquiler);
            $b = new DateTime($fechaDevolucion);
            $f = ($b->diff(($a)));
            //echo $f->days;
            $cobro = $autoCon->precio;
            $montoPagar = $cobro * $f->days;
            return $montoPagar;
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
