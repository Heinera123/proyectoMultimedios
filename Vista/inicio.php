<?php
session_start();
if (!isset($_SESSION['userName']) ) {
    // header('location: login.php');
     echo '<script type="text/javascript">
       alert("Disculpes las molestia debes de autenticarte!!!");
       window.location.href="../index.php";
        </script>';
 }
include_once "Componentes/header.php";
include_once "Componentes/nav.php";
?>
<body class="FondoIni">
</body>
<?php
// la variable controller guarda el nombre del controlador y action guarda la acción por ejemplo registrar 
//si la variable controller y action son pasadas por la url desde layout.php entran en el if
if ( isset( $_GET['controller'] ) && isset( $_GET['action'] ) ) {
  $controller = $_GET['controller'];
  $action = $_GET['action'];		
} else {
  $controller='user';
  $action='index';
}
require_once '../routes.php';
require_once "Componentes/footer.php";
?>