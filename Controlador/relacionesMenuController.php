<?php
if (!isset($_SESSION)) { session_start(); }
require "../Modelo/relcionesMenu.php";
class relacionesMenCon {
  public function __construct(){}
  public function index(){
    require_once '../Vista/RelacionesMenuCon.php';
  }
  public static function devolverRelaciones(){
    return relacionesMenu::consutarRelaciones();
}
}