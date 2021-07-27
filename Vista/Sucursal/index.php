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
    <?php
        require_once "../Controlador/sucursalesController.php";
        $sucursales = sucursalesController::ConsuTodosSucursal();
    ?>
    <div class="mt-4 mb-3" id="consultar">
        <div class="card card-body text-center bg-transparent">
            <h2>Consulta Sucursales</h2>
            <div class="row text-center">
                <div class="col-12 text-center">
                <table class="mb-3 text-center table table-sm table-bordered table-dark table-responsive">
                    <thead>
                        <tr>
                        <th scope="col">Id Sucursal</th>
                        <th scope="col">Provincia</th>
                        <th scope="col">Canton</th>
                        <th scope="col">direccion</th>
                        <th scope="col">Canton</th>
                        <th scope="col">Fecha creación</th>
                        <th scope="col">Fecha modificación</th>
                        <th scope="col">Habilitado</th>
                        <th colspan="2" scope="col">Acciones</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php 
                                foreach ($sucursales as $sucursal) {
                            ?>
                            <tr class="<?php if($sucursal->enabled == 0){echo 'bg-danger';}else{echo 'bg-success';}?>">
                            <th scope="col"><?php echo $sucursal->id?></th>
                            <th scope="col"><?php echo $sucursal->provincia?></th>
                            <th scope="col"><?php echo $sucursal->canton?></th>
                            <th scope="col"><?php echo $sucursal->distrito?></th>
                            <th scope="col"><?php echo $sucursal->direccion?></th>
                            <th scope="col"><?php echo $sucursal->createdAt;?></th>
                            <th scope="col"><?php echo $sucursal->updatedAt?></th>
                            <th scope="col"><?php echo $sucursal->enabled?></th>
                            <td><a role="button" href="?controller=sucursales&action=update&id=<?php echo $sucursal->id ?>" class="btn btn-secondary">Actualizar</a> </td>
                            <td><a role="button" class="btn btn-secondary" href="?controller=sucursales&action=delete&id=<?php echo $sucursal->id ?>">Eliminar</a> </td>
                            </tr>
                            <?php } ?>                                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once "Componentes/footer.php";
include_once "../routes.php";
?>