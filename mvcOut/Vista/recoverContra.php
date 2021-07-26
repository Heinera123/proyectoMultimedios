<?php
require_once "Componentes/headerF.php"
?>
<body class="recu">
    <center class="margin-top-3">
        <img src="https://img.icons8.com/fluent/144/000000/re-enter-pincode.png" alt="Imagen logo de recuperacion"/>
    </center>   
    <form method="POST" action="../Controlador/userController.php" >
    <input type='hidden' name='action' value='recuperar'>
        <div class="grid-container margin-top-2">
            <div class="grid-x grid-padding-x text-center">
                <div class="cell text-center margin-bottom-2">
                    <h4>Ingrese el dato con el que desea recuperar su información</h4>
                </div>
            <div class="medium-4 cell text-center">
                <label>Ingrese su Cédulas
                <input type="text" name="cedula" class="margin-top-1" placeholder="Cédula">
                </label>
            </div>
            <div class="medium-4 cell text-center">
                <label>Ingrese su Email
                <input type="text" name="email" class="margin-top-1" placeholder="Email">
                </label>
            </div>
            <div class="medium-4 cell text-center">
                <label>Ingrese su Usuario
                <input type="text" name="user" class="margin-top-1" placeholder="Usuario">
                </label>
            </div>
            <div class="cell text-center margin-bottom-2">
                    <button class="hollow button secondary large success" type="submit">Recuperar</button>
                </div>
            </div>
        </div>
    </form>
    <?php
        require_once "Componentes/footer.php"
    ?>
</body>