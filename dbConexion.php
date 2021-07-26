<?php
	/*Conexión a la base de datos*/
	class dbConexion
	{
		private static $instance=NULL;
		private function __construct(){}
		private function __clone(){}
		public static function getConnect(){
			if (!isset(self::$instance)) {
				$pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
				self::$instance= new PDO('mysql:host=localhost;dbname=proyecto_personal','root','',$pdo_options);
			}
			return self::$instance;
		}
	}
?>