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
        require_once "../Controlador/alquilerAutosController.php";
        $alquileres = alquilerAutoController::ConsuTodosalquilerAuto();
    ?>
    <div class="mt-4 mb-3" id="consultar">
        <div class="card card-body text-center bg-transparent">
            <h2>Consulta Alquileres</h2>
            <div class="row">
                <div class="col-12">
                <table class="mb-3 table table-sm table-bordered table-dark table-responsive">
                    <thead>
                        <tr>
                        <th scope="col">Id Alquiler</th>
                        <th scope="col">Id Auto</th>
                        <th scope="col">Id User</th>
                        <th scope="col">Fecha Alquiler</th>
                        <th scope="col">Email</th>
                        <th scope="col">Fecha Devolucion</th>
                        <th scope="col">Monto Pagar</th>
                        <th scope="col">Cancelado</th>
                        <th scope="col">Fecha Creacion</th>
                        <th scope="col">Fecha última modificación</th>
                        <th colspan="2" scope="col">Acciones</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php 
                                foreach ($alquileres as $alquiler) {
                            ?>
                            <tr class="<?php if($alquiler->cancelado == 0){echo 'bg-danger';}else{echo 'bg-success';}?>">
                            <th scope="col"><?php echo $alquiler->id?></th>
                            <th scope="col"><?php echo $alquiler->idAuto?></th>
                            <th scope="col"><?php echo $alquiler->idUser?></th>
                            <th scope="col"><?php echo $alquiler->fechaAlquiler?></th>
                            <th scope="col"><?php echo $alquiler->email?></th>
                            <th scope="col"><?php echo $alquiler->fechaDevolucion?></th>
                            <th scope="col"><?php echo $alquiler->montoPagar?></th>
                            <th scope="col"><?php echo $alquiler->cancelado?></th>
                            <th scope="col"><?php echo $alquiler->created_At?></th>
                            <th scope="col"><?php echo $alquiler->update_at?></th>
                            <td><a role="button" href="?controller=alquilerAutos&action=update&id=<?php echo $alquiler->id ?>" class="btn btn-secondary">Actualizar</a> </td>
                            <td><a role="button" class="btn btn-secondary" href="?controller=alquilerAutos&action=delete&id=<?php echo $alquiler->id ?>&idAuto=<?php echo $alquiler->idAuto ?>">Eliminar</a> </td>
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