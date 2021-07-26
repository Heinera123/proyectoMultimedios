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
        require_once "../Controlador/rolController.php";
        $roles = rolController::ConsuTodosRol();
    ?>
    <div class="mt-4 mb-3" id="consultar">
        <div class="card card-body text-center bg-transparent">
            <h2>Consulta Roles</h2>
            <div class="row text-center">
                <div class="col-12 text-center">
                <table class="mb-3 text-center table table-sm table-bordered table-dark table-responsive">
                    <thead>
                        <tr>
                        <th scope="col">Id Rol</th>
                        <th scope="col">Nombre rol</th>
                        <th scope="col">ID menu</th>
                        <th scope="col">Fecha creación</th>
                        <th scope="col">Fecha modificación</th>
                        <th scope="col">Habilitado</th>
                        <th colspan="2" scope="col">Acciones</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php 
                                foreach ($roles as $rol) {
                            ?>
                            <tr class="<?php if($rol->enabled == 0){echo 'bg-danger';}else{echo 'bg-success';}?>">
                            <th scope="col"><?php echo $rol->idRol?></th>
                            <th scope="col"><?php echo $rol->nameRol?></th>
                            <th scope="col"><?php echo $rol->idMenu?></th>
                            <th scope="col"><?php echo $rol->createdAt;?></th>
                            <th scope="col"><?php echo $rol->updatedAt?></th>
                            <th scope="col"><?php echo $rol->enabled?></th>
                            <td><a role="button" href="?controller=rol&action=update&id=<?php echo $rol->idRol ?>" class="btn btn-secondary">Actualizar</a> </td>
                            <td><a role="button" class="btn btn-secondary" href="?controller=rol&action=delete&id=<?php echo $rol->idRol ?>">Eliminar</a> </td>
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