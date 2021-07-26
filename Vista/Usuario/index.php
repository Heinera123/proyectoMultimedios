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
        require_once "../Controlador/userController.php";
        $usuarios = userController::ConsuTodosUser();
    ?>
    <div class="mt-4 mb-3" id="consultar">
        <div class="card card-body text-center bg-transparent">
            <h2>Consulta Usuarios</h2>
            <div class="row">
                <div class="col-12">
                <table class="mb-3 table table-sm table-bordered table-dark table-responsive">
                    <thead>
                        <tr>
                        <th scope="col">Id Usuario</th>
                        <th scope="col">Cédula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nombre usuario</th>
                        <th scope="col">id Rol</th>
                        <th scope="col">Fecha última modificación</th>
                        <th scope="col">Habilitado</th>
                        <th colspan="2" scope="col">Acciones</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php 
                                foreach ($usuarios as $usuario) {
                            ?>
                            <tr class="<?php if($usuario->enable == 0){echo 'bg-danger';}else{echo 'bg-success';}?>">
                            <th scope="col"><?php echo $usuario->idUser?></th>
                            <th scope="col"><?php echo $usuario->cedula?></th>
                            <th scope="col"><?php echo $usuario->nameUser?></th>
                            <th scope="col"><?php echo $usuario->lastName;?></th>
                            <th scope="col"><?php echo $usuario->email?></th>
                            <th scope="col"><?php echo $usuario->userName?></th>
                            <th scope="col"><?php echo $usuario->idRol?></th>
                            <th scope="col"><?php echo $usuario->createdAt?></th>
                            <th scope="col"><?php echo $usuario->enable?></th>
                            <td><a role="button" href="?controller=user&action=update&id=<?php echo $usuario->idUser ?>" class="btn btn-secondary">Actualizar</a> </td>
                            <td><a role="button" class="btn btn-secondary" href="?controller=user&action=delete&id=<?php echo $usuario->idUser ?>">Eliminar</a> </td>
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