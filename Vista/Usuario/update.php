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
$usuarioConsultado = null;
require_once "../Controlador/userController.php";
$usuarioConsultado = userController::devolverconsultarUser($_GET["id"]);
?>
<div class="col-12">
    <div class="" id="update">
        <div class="card card-body text-center bg-transparent">
            <h2>Modificar usuario</h2>                        
            <div class="container-fluid text-center login mt-1">
                <div class="card-form card mx-auto w-100 mt-4">
                    <div class="row mx-auto mt-3">
                        <div class="col-12 mt-4">
                            <form action="../Controlador/userController.php" class="row mx-auto" method="POST">
                                <input type='hidden' name='action' value='update'>
                                    <div class="col-6">
                                        <div class="form-group row">
                                            <label for="iduser" class="col-sm-4 col-form-label">ID Usuario:</label>
                                            <div class="col-sm-8">
                                            <input require readonly type="number" class="form-control" name="id" id="idUser" value="<?php echo $usuarioConsultado->idUser?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cedula" class="col-sm-4 col-form-label">Cédula:</label>
                                            <div class="col-sm-8">
                                            <input require type="text" class="form-control" name="cedulaUser" id="cedulaUser" value="<?php echo $usuarioConsultado->cedula?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-4 col-form-label">Nombre:</label>
                                            <div class="col-sm-8">
                                            <input require type="text" class="form-control" name="nameUser" id="nameUser" value="<?php echo $usuarioConsultado->nameUser?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lastName" class="col-sm-4 col-form-label">Apellidos:</label>
                                            <div class="col-sm-8">
                                            <input require type="text" class="form-control" name="lastNameUser" id="lastNameUser" value="<?php echo $usuarioConsultado->lastName?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-4 col-form-label">Email:</label>
                                            <div class="col-sm-8">
                                            <input require type="email" class="form-control" name="emailUser" id="emailUser" value="<?php echo $usuarioConsultado->email?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                            <div class="form-group row">
                                            <label for="userName" class="col-sm-4 col-form-label">Nombre de usuario:</label>
                                            <div class="col-sm-8">
                                            <input require type="text" class="form-control" disabled name="userName" id="userName" value="<?php echo $usuarioConsultado->userName?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="passw" class="col-sm-4 col-form-label">Contraseña:</label>
                                            <div class="col-sm-8">
                                            <input require type="password" class="form-control" name="passwUser" id="passwUser" value="**********" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="idRol" class="col-sm-4 col-form-label">Rol:</label>
                                            <div class="col-sm-8">
                                                <select name="rolUser" id="rolUser" class="form-control" >
                                                    <option value="">Seleccione:</option>
                                                    <?php
                                                    require_once "../Controlador/userController.php";
                                                    $data = userController::delverRoles();
                                                    foreach ($data as $valores):
                                                        if($usuarioConsultado->idRol == $valores["idRol"]){
                                                            echo '<option selected value="'.$valores["idRol"].'">'.$valores["nameRol"].'</option>';
                                                        }else {
                                                            echo '<option value="'.$valores["idRol"].'">'.$valores["nameRol"].'</option>';
                                                        }                                                  
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="enable" class="col-sm-4 col-form-label">Habilitado:</label>
                                            <div class="col-sm-8">
                                            <input require type="number" class="form-control" name="habiliUser" id="habiliUser" value="<?php echo $usuarioConsultado->enable?>">
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