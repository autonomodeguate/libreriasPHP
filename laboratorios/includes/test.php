<?php

require_once("initialize.php");

/*
$usuario = new user();
$usuario->nombre = "Luis Barrera";
$usuario->usuario = "adminofertas";
$usuario->clave = sha1("Admin_Ofertas");
$usuario->correo = "webmaster@ofertaschapinas.com";
$usuario->fregistro = date("Y-m-d");
$usuario->permisos = "admin";
$usuario->estado = "activo";
$usuario->guardar();
*/

/*
$usuario = user::buscar_por_id(1);
$usuario->nombre = "Juan Mayor";
$usuario->guardar();
*/
/*
$usuario = user::buscar_por_id(5);
$usuario->eliminar();
*/
/*
$usuario = medic::buscar_por_id(1);
echo $usuario->nombre ."<br />";
echo $usuario->especialidad;
*/

$laboratorio = new lab();
$laboratorio->nombre = "Stein";
$laboratorio->correo = "stein@gmail.com";
$laboratorio->telefono = "26569878";
$laboratorio->clave = sha1("000000");
$laboratorio->fregistro = date('Y-m-d');
$laboratorio->estado = "activo";

if($laboratorio->guardar()){
	echo "Se guardo correctamente";
}else{
	echo "Ocurrio un error";
}

?>