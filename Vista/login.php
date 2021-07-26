<?php
    // header('location: login.php'); 
 ?>
<body class="body-login mt-4">
    <div class="container-fluid text-center login mt-xl-5">
        <div class="card mx-auto w-50">
            <div class="row mx-auto mt-3">
                <div class="col-12 ">
                    <img src="Vista\Recursos\imgLogin.png" class="img-fluid" alt="Imagen de login">
                </div>
                <div class="col-12 mt-4 border-top">
                <a href="mvcOut/Vista/register.php" class="btn btn-dark mt-2 mb-2">Registrarse</a>
                    <form action="Controlador\loginControlador.php" class="mx-auto w-75" method="POST">
                    <input type='hidden' name='action' value='login'>
                        <div class="form-group">
                            <label for="userName">Nombre de usuario</label>
                            <input type="text" class="form-control" required placeholder="Ingrese su nombre de usuario" id="userName" name="userName">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Contraseña:</label>
                            <input type="password" class="form-control" required name="pasw" placeholder="Ingrese su contraseña" id="pwd">
                        </div>
                        <button type="submit" class="btn btn-dark mb-4">Ingresar</button>
                    </form>
                        <div class="form-group">
                            <a href="mvcOut/Vista/recoverContra.php" for="userName">¿Olvidaste tu contraseña?</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>