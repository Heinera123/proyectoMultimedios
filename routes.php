<?php
	//función que llama al controlador y su respectiva acción, que son pasados como parámetros
	function call( $controller, $action ){
		//importa el controlador desde la carpeta Controllers
		require_once('../Controlador/' . $controller . 'Controller.php');
		//crea el controlador
		switch( $controller ){
			case 'user':
				require_once('Controlador/userController.php');
				$controller = new userController();
				break; 
			case 'rol':
				require_once('Controlador/rolController.php');
				$controller = new rolController();
				break;
			case 'menu':
				require_once('Controlador/menuController.php');
				$controller = new menuController();
				break;
				case 'controller':
					require_once('Controlador/controllerController.php');
					$controller = new controllerController();
					break;
				case 'relacionesMenu':
					require_once('Controlador/relacionesMenuController.php');
					$controller = new relacionesMenCon();
					break;
				case 'auto':
					require_once('Controlador/autoController.php');
					$controller = new autoController();
					break;
			case 'controller':
				require_once('Controlador/controllerController.php');
				$controller = new controllerController();
				break;
			case 'sucursales':
				require_once('Controlador/sucursalesController.php');
				$controller = new sucursalesController();
				break;	
			case 'relacionesMenu':
				require_once('Controlador/relacionesMenuController.php');
				$controller = new relacionesMenCon();
				break;
		}
		$controller->{ $action }();
	}
	//array con los controladores y sus respectivas acciones
	$controllers= array(
						'user'=>['index','register', 'update', 'delete'],
						'rol'=>['index','register', 'update', 'delete'],
						'menu'=>['index','register', 'update', 'delete'],
						'controller'=>['index','register', 'update', 'delete'],
						'relacionesMenu'=>['index']
						);
	//verifica que el controlador enviado desde index.php esté dentro del arreglo controllers
	if ( array_key_exists( $controller, $controllers ) ) {
		//verifica que el arreglo controllers con la clave que es la variable controller del index exista la acción
		if ( in_array( $action, $controllers[$controller]) ) {
			//llama  la función call y le pasa el controlador a llamar y la acción (método) que está dentro del controlador
			call( $controller, $action );
		}else{
			call( $controller, 'error' );
			//hacer pagina de error
		}
	}else{// le pasa el nombre del controlador y la pagina de error
		call ( $controller, 'error' ) ;
	}
?>