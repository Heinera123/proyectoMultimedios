<?php
if(isset($_SESSION)){    
    if ( !isset($_SESSION['userName'])) {
         echo '<script type="text/javascript">
           alert("Disculpes las molestia debes de autenticarte!!!");
           window.location.href="../../index.php";
            </script>';
     }
}else{
    echo '<script type="text/javascript">
           alert("Disculpes las molestia debes de autenticarte!!!");
           window.location.href="../../index.php";
            </script>';
}
include_once "Componentes/header.php";
include_once "Componentes/nav.php";
$controllerConsultado = null;
require_once "../Controlador/controllerController.php";
$controllerConsultado = controllerController::devolverconsultarcontroller($_GET["id"]);
?>
<div class="col-12">
    <div class="" id="update">
        <div class="card card-body text-center bg-transparent">
            <h2>Modificar usario</h2>                        
            <div class="container-fluid text-center login mt-1">
                <div class="card-form card mx-auto w-100 mt-4">
                    <div class="row mx-auto mt-3">
                        <div class="col-12 mt-4">
                            <form action="../Controlador/controllerController.php" class="row mx-auto" method="POST">
                                <input type='hidden' name='action' value='update'>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <label for="idcontroller" class="col-sm-4 col-form-label">ID controller:</label>
                                            <div class="col-sm-8">
                                            <input require readonly type="number" class="form-control" name="idcontroller" id="idcontroller" value="<?php echo $controllerConsultado->idController?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cedula" class="col-sm-4 col-form-label">Nombre controller:</label>
                                            <div class="col-sm-8">
                                            <input require type="text" class="form-control" name="nameControllerView" id="nameControllerView" value="<?php echo $controllerConsultado->nameControllerView?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="enable" class="col-sm-4 col-form-label">Habilitado:</label>
                                            <div class="col-sm-8">
                                            <input require type="number" class="form-control" name="enabled" id="enabled" value="<?php echo $controllerConsultado->enabled?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn-block btn-lg btn btn-dark mb-4">Actualizar</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once "Componentes/footer.php";
?>