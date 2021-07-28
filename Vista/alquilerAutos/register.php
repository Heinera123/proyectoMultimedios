<?php
if(isset($_SESSION)){    
    if ( !isset($_SESSION['userName'])) {
        // header('location: login.php');
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
?>
<!-- collapse de form registro-->
<div class="col-12">
    <div class="" id="registrar">
        <div class="card card-body text-center bg-transparent">
            <h2>Registrar Alquiler</h2>
            <div class="container-fluid text-center login mt-1">
                <div class="card-form card mx-auto w-100">
                    <div class="row mx-auto mt-3">
                        <div class="col-12 mt-4">
                            <form action="../Controlador/alquilerAutosController.php" class="row mx-auto" method="POST">
                                <input type='hidden' name='action' value='registrar'>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <label for="idRol" class="col-sm-4 col-form-label">Auto:</label>
                                            <div class="col-sm-8">
                                                <select name="idAuto" id="idAuto" class="form-control" >
                                                    <option value="">Seleccione:</option>
                                                        <?php
                                                        require_once "../Controlador/alquilerAutosController.php";
                                                        $data = alquilerAutoController::devolverAutos(0);
                                                        foreach ($data as $valores):
                                                            echo '<option value="'.$valores["id"].'">'.$valores["marca"]."-".$valores["modelo"].'</option>';
                                                        endforeach;
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">    
                                        <div class="form-group row">
                                            <label for="idRol" class="col-sm-4 col-form-label">Cliente:</label>
                                            <div class="col-sm-8">
                                                <select name="idUser" id="idUser" class="form-control">
                                                    <option value="">Seleccione:</option>
                                                        <?php
                                                        require_once "../Controlador/alquilerAutosController.php";
                                                        $data = alquilerAutoController::delverCliente();
                                                        foreach ($data as $valores):
                                                            echo '<option value="'.$valores["idUser"].'">'.$valores["nameUser"]." ".$valores["lastName"].'</option>';
                                                        endforeach;
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="col-12">  
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-4 col-form-label">Email:</label>
                                            <div class="col-sm-8">
                                            <input require type="email" class="form-control" name="email" id="email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-4 col-form-label">Fecha Alquiler:</label>
                                            <div class="col-sm-8">
                                            <input require type="date" class="form-control" name="FechaAlquiler" id="FechaAlquiler">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-4 col-form-label">Fecha Devolucion:</label>
                                            <div class="col-sm-8">
                                            <input require type="date" class="form-control" name="fechaDevolucion" id="fechaDevolucion">
                                            </div>
                                        </div>
<!-- 
                                        <div class="form-group row">
                                            <label for="lastName" class="col-sm-4 col-form-label">Monto Pagar:</label>
                                            <div class="col-sm-8">
                                            <input readonly require type="text" value="1" class="form-control" name="montoPagar" id="montoPagar">
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <label for="enable" class="col-sm-4 col-form-label">Cancelado:</label>
                                            <div class="col-sm-8">
                                            <input require type="number" class="form-control" name="cancelado" id="cancelado">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn-block btn-lg btn btn-dark mb-4">Registrar</button>
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