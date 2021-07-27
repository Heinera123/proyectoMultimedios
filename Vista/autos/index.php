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
        require_once "../Controlador/autoController.php";
        $autos = autoController::ConsuTodosauto();
    ?>
    <div class="mt-4 mb-3" id="consultar">
        <div class="card card-body text-center bg-transparent">
            <h2>Consulta autos</h2>
            <div class="row">
                <div class="col-12">
                <table class="mb-3 table table-sm table-bordered table-dark table-responsive">
                    <thead>
                        <tr>
                        <th scope="col">Id auto</th>
                        <th scope="col">placa</th>
                        <th scope="col">marca</th>
                        <th scope="col">modelo</th>
                        <th scope="col">precio</th>
                        <th scope="col">enabled</th>
                        <th scope="col">created_at</th>
                        <th scope="col">update_at</th>
                        <th colspan="2" scope="col">Acciones</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php 
                                foreach ($autos as $auto) {
                            ?>
                            <tr class="<?php if($auto->enabled == 0){echo 'bg-danger';}else{echo 'bg-success';}?>">
                            <th scope="col"><?php echo $auto->id?></th>
                            <th scope="col"><?php echo $auto->placa?></th>
                            <th scope="col"><?php echo $auto->marca?></th>
                            <th scope="col"><?php echo $auto->modelo;?></th>
                            <th scope="col"><?php echo $auto->precio?></th>
                            <th scope="col"><?php echo $auto->enabled?></th>
                            <th scope="col"><?php echo $auto->created_at?></th>
                            <th scope="col"><?php echo $auto->update_at?></th>
                            <td><a role="button" href="?controller=auto&action=update&id=<?php echo $auto->id ?>" class="btn btn-secondary">Actualizar</a> </td>
                            <td><a role="button" class="btn btn-secondary" href="?controller=auto&action=delete&id=<?php echo $auto->id ?>">Eliminar</a> </td>
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