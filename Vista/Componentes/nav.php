<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
<a class="navbar-brand"><?php
if (isset($_SESSION['userName']) ) {
  echo "Usuario: " .$_SESSION["userName"] .""; 
}
?></a>
<a class="navbar-brand"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="?controller=user&action=index">Inicio <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuarios</a>
        <div class="dropdown-menu bg-dark">
          <a class="nav-link dropdown-item" href="?controller=user&action=register">Registrar Usuario</a>
          <a class="nav-link dropdown-item" href="?controller=user&action=index">Ver Usuarios</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Roles</a>
        <div class="dropdown-menu bg-dark">
          <a class="nav-link dropdown-item" href="?controller=rol&action=register">Registrar Rol</a>
          <a class="nav-link dropdown-item" href="?controller=rol&action=index">Ver Roles</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" 
        aria-haspopup="true" aria-expanded="false">Menus</a>
        <div class="dropdown-menu bg-dark">
          <a class="nav-link dropdown-item" href="?controller=menu&action=register">Registrar menu</a>
          <a class="nav-link dropdown-item" href="?controller=menu&action=index">Ver menus</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" 
        aria-haspopup="true" aria-expanded="false">Controladores</a>
        <div class="dropdown-menu bg-dark">
          <a class="nav-link dropdown-item" href="?controller=controller&action=register">Registrar controlador</a>
          <a class="nav-link dropdown-item" href="?controller=controller&action=index">Ver controladores</a>
        </div>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="?controller=relacionesMenu&action=index">Relaciones menu</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-danger" href="../index.php">Salir</a>
      </li>
    </ul>
  </div>
</nav>