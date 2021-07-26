<?php
session_start();
if ( !isset($_SESSION['userName']) ) {
    // header('location: login.php');
     echo '<script type="text/javascript">
       alert("Disculpes las molestia debes de autenticarte!!!");
       window.location.href="../index.php";
        </script>';
 }
include_once "Componentes/header.php";
include_once "Componentes/nav.php";
?>
<body class="adminUser">
    <div class="container aling-middle">
    <!-- botones para control colapse -->
        <div class="row text-center ">
            <div class="col">
                <button class="col btn-lg btn btn-dark" data-toggle="collapse" href="#registrar" role="button" aria-expanded="false" aria-controls="registrar">Registrar</button>
            </div>
            <div class="col">
                <button class="btn-lg col btn btn-dark" data-toggle="collapse" href="#consultar" role="button" aria-expanded="false" aria-controls="consultar">Consultar</button>
            </div>
        </div>
        <div class="row mt-4">
            <!-- collapse de form registro-->
            <div class="col-12">
                <div class="collapse multi-collapse" id="registrar">
                    <div class="card card-body text-center bg-transparent">
                        <h2>Registrar Usuarios</h2>
                        <div class="container-fluid text-center login mt-1">
                            <div class="card-form card mx-auto w-100">
                                <div class="row mx-auto mt-3">
                                    <div class="col-12 mt-4">
                                        <form action="../Controlador/userController.php" class="row mx-auto" method="POST">
                                            <input type='hidden' name='action' value='registrar'>
                                                <div class="col-6">
                                                        <div class="form-group row">
                                                        <label for="cedula" class="col-sm-4 col-form-label">Cédula:</label>
                                                        <div class="col-sm-8">
                                                        <input require type="text" class="form-control" name="cedulaUser" id="cedulaUser">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="name" class="col-sm-4 col-form-label">Nombre:</label>
                                                        <div class="col-sm-8">
                                                        <input require type="text" class="form-control" name="nameUser" id="nameUser">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="lastName" class="col-sm-4 col-form-label">Apellidos:</label>
                                                        <div class="col-sm-8">
                                                        <input require type="text" class="form-control" name="lastNameUser" id="lastNameUser">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="email" class="col-sm-4 col-form-label">Email:</label>
                                                        <div class="col-sm-8">
                                                        <input require type="email" class="form-control" name="emailUser" id="emailUser">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                        <div class="form-group row">
                                                        <label for="userName" class="col-sm-4 col-form-label">Nombre de usuario:</label>
                                                        <div class="col-sm-8">
                                                        <input require type="text" class="form-control" name="userName" id="userName">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="passw" class="col-sm-4 col-form-label">Contraseña:</label>
                                                        <div class="col-sm-8">
                                                        <input require type="password" class="form-control" name="passwUser" id="passwUser">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="idRol" class="col-sm-4 col-form-label">Rol:</label>
                                                        <div class="col-sm-8">
                                                        <input require type="number" class="form-control" name="rolUser" id="rolUser">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="enable" class="col-sm-4 col-form-label">Habilitado:</label>
                                                        <div class="col-sm-8">
                                                        <input require type="number" class="form-control" name="habiliUser" id="habiliUser">
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
            <!--collapse de Tabla de todos los usuarios y acciones-->            
            <div class="col-12">
                <?php
                    require_once "../Controlador/userController.php";
                    $usuarios = userController::ConsuTodosUser();
                ?>
                <div class="collapse multi-collapse" id="consultar">
                    <div class="card card-body text-center bg-transparent">
                        <h2>Consulta Usuarios</h2>
                        <div class="row">
                            <div class="col-12">
                            <table class="table table-sm table-bordered table-dark table-responsive mt-3">
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
                                        <tr>
                                        <th scope="col"><?php echo $usuario->idUser?></th>
                                        <th scope="col"><?php echo $usuario->cedula?></th>
                                        <th scope="col"><?php echo $usuario->nameUser?></th>
                                        <th scope="col"><?php echo $usuario->lastName;?></th>
                                        <th scope="col"><?php echo $usuario->email?></th>
                                        <th scope="col"><?php echo $usuario->userName?></th>
                                        <th scope="col"><?php echo $usuario->idRol?></th>
                                        <th scope="col"><?php echo $usuario->createdAt?></th>
                                        <th scope="col"><?php echo $usuario->enable?></th>
                                        <td><a role="button" href="../Controlador/userController.php?action=update&id=<?php echo $usuario->idUser ?>" class="btn btn-secondary">Actualizar</a> </td>
				                        <td><a role="button" class="btn btn-secondary" href="../Controlador/userController.php?action=delete&id=<?php echo $usuario->idUser ?>">Eliminar</a> </td>
                                        </tr>
                                        <?php } ?>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- collapse de form de update-->
            <?php
            $usuarioConsultado = null;
            $colap = false;
                if(isset($_GET['action'])){
                    if($_GET['action'] == "udp"){
                        require_once "../Controlador/userController.php";
                        $usuarioConsultado = userController::devolverconsultarUser($_GET['user']);
                        $colap = true;
                    }                    
                  }
            ?>
            <div class="col-12">
                <div class="" <?php if($colap){}else{echo "hidden";}?> id="update">
                    <div class="card card-body text-center bg-transparent">
                        <h2>Modificar usario</h2>                        
                        <div class="container-fluid text-center login mt-1">
                        <button class="btn-lg btn btn-dark" data-toggle="collapse" href="#update" 
                        role="button" aria-expanded="false" aria-controls="update">Cerrar</button>
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
                                                        <input require type="number" class="form-control" name="rolUser" id="rolUser" value="<?php echo $usuarioConsultado->idRol?>">
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
        </div>
    </div>
</body>
<?php
include_once "Componentes/footer.php";
?>