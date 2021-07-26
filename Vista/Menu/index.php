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
?>
<div class="col-12">
    <?php
        require_once "../Controlador/menuController.php";
        $menus = menuController::ConsuTodosmenu();
    ?>
    <div class="mt-4 mb-3" id="consultar">
        <div class="card card-body text-center bg-transparent">
            <h2>Consulta menus</h2>
            <div class="row">
                <div class="col-12">
                <table class="mb-3 table table-sm table-bordered table-dark table-responsive">
                    <thead>
                        <tr>
                        <th scope="col">Id menu</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Id Catalogo Menu</th>
                        <th scope="col">Fecha creación</th>
                        <th scope="col">Fecha última modificación</th>
                        <th scope="col">Habilitado</th>
                        <th colspan="2" scope="col">Acciones</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php 
                                foreach($menus as $menu) {
                            ?>
                            <tr class="<?php if($menu->enable == 0){echo 'bg-danger';}else{echo 'bg-success';}?>">
                            <th scope="col"><?php echo $menu->idmenu?></th>
                            <th scope="col"><?php echo $menu->nameMenu?></th>
                            <th scope="col"><?php echo $menu->idCatalogoMenu?></th>
                            <th scope="col"><?php echo $menu->createdAt?></th>
                            <th scope="col"><?php echo $menu->updatedAt?></th>
                            <th scope="col"><?php echo $menu->enable?></th>
                            <td><a role="button" href="?controller=menu&action=update&id=<?php echo $menu->idmenu ?>" class="btn btn-secondary">Actualizar</a> </td>
                            <td><a role="button" class="btn btn-secondary" href="?controller=menu&action=delete&id=<?php echo $menu->idmenu ?>">Eliminar</a> </td>
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