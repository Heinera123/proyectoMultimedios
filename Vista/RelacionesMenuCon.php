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
        require_once "../Controlador/relacionesMenuController.php";
        $roles = relacionesMenCon::devolverRelaciones();
    ?>
    <div class="mt-4 mb-5" id="consultar">
        <div class="card card-body text-center bg-transparent">
            <h2>Consulta Relaciones menu-controlador</h2>
            <div class="row">
                <div class="col-12">
                <table class="mb-5 table table-sm table-bordered table-dark table-responsive">
                    <thead>
                        <tr>
                        <th scope="col">Id Relación</th>
                        <th scope="col">Id menu</th>
                        <th scope="col">Id controlador</th>
                        <th scope="col">Fecha creación</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php 
                                foreach($roles as $rol) {
                            ?>
                            <tr>
                            <th scope="col"><?php echo $rol->idCatalogoMenu?></th>
                            <th scope="col"><?php echo $rol->idMenu?></th>
                            <th scope="col"><?php echo $rol->idController?></th>
                            <th scope="col"><?php echo $rol->createdAt?></th>
                            </tr>
                            <?php } ?> 
                            <tr>
                            </tr>                                      
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