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
<div class="col-12">
    <div class="" id="registrar">
        <div class="card card-body text-center bg-transparent">
            <h2>Registrar Sucursal</h2>
            <div class="container-fluid text-center login mt-1">
                <div class="card-form card mx-auto w-100">
                    <div class="row mx-auto mt-3">
                        <div class="col-12 mt-4">
                            <form action="../Controlador/sucursalesController.php" class="row mx-auto" method="POST">
                                <input type='hidden' name='action' value='registrar'>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-4 col-form-label">Provincia:</label>
                                            <div class="col-sm-8">
                                            <input require type="text" class="form-control" name="provincia" id="provincia">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-4 col-form-label">Canton:</label>
                                            <div class="col-sm-8">
                                            <input require type="text" class="form-control" name="canton" id="canton">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-4 col-form-label">Distrito:</label>
                                            <div class="col-sm-8">
                                            <input require type="text" class="form-control" name="distrito" id="distrito">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-4 col-form-label">Direccion:</label>
                                            <div class="col-sm-8">
                                            <input require type="text" class="form-control" name="direccion" id="direccion">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lastName" class="col-sm-4 col-form-label">Fecha Creación:</label>
                                            <div class="col-sm-8">
                                            <input readonly require type="text" value="<?php echo date("Y-m-d H:i:s"); ?>" class="form-control" name="fechaCrea" id="fechaCrea">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="habil" class="col-sm-4 col-form-label">Habilitado:</label>
                                            <div class="col-sm-8">
                                            <input require type="number" class="form-control" name="habilidato" id="habilidato">
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