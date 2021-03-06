<?php
include_once "../../Vista/Componentes/header.php";
?>
<!-- collapse de form registro-->
<div class="col-12">
    <div class="" id="registrar">
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
                                            <input required type="text" class="form-control" name="cedulaUser" id="cedulaUser">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-4 col-form-label">Nombre:</label>
                                            <div class="col-sm-8">
                                            <input required type="text" class="form-control" name="nameUser" id="nameUser">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lastName" class="col-sm-4 col-form-label">Apellidos:</label>
                                            <div class="col-sm-8">
                                            <input required type="text" class="form-control" name="lastNameUser" id="lastNameUser">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-4 col-form-label">Email:</label>
                                            <div class="col-sm-8">
                                            <input required type="email" class="form-control" name="emailUser" id="emailUser">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                            <div class="form-group row">
                                            <label for="userName" class="col-sm-4 col-form-label">Nombre de usuario:</label>
                                            <div class="col-sm-8">
                                            <input required type="text" class="form-control" name="userName" id="userName">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="passw" class="col-sm-4 col-form-label">Contraseña:</label>
                                            <div class="col-sm-8">
                                            <input required type="password" class="form-control" name="passwUser" id="passwUser">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="enable" class="col-sm-4 col-form-label">Habilitado:</label>
                                            <div class="col-sm-8">
                                            <input required readonly type="number" value="1" class="form-control" name="habiliUser" id="habiliUser">
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