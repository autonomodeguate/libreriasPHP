<?php

require_once('../includes/initialize.php');


$usuario = new user();
$usuario->nombre = "Luis Barrera";
$usuario->usuario = "adminimedics";
$usuario->clave = sha1("54990219");
$usuario->correo = "webmaster@guatemedica.net";
$usuario->fregistro = date("Y-m-d");
$usuario->permisos = "admin";
$usuario->estado = "activo";

if($usuario->guardar()){
	echo "Se guardo correctamente";
}else{
	echo "Ocurrio un error";
}

/*
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
*/

/*
$medicamento = new medicament();
$medicamento->sal_id = 1;
$medicamento->imagen = "pediatria-clavulin-c12.jpg";
$medicamento->tipo = "image/jpeg";
$medicamento->peso = "47037";
$medicamento->nombre = "CLAVULIN C12 400MG SUSP 70ML";
$medicamento->nombre_generico = "";
$medicamento->indicaciones = "";
$medicamento->efectos_adversos = "";
$medicamento->dosificaciones = "";
$medicamento->especialidad_id = 1;
$medicamento->laboratorio_id = 1;
$medicamento->fagregado = date("Y-m-d");;
$medicamento->estado = "activo";
$medicamento->pagina =  "www.guatemedica.net";
$medicamento->bonificacion = 1;
$medicamento->bonificacion_visita = 1;

if($medicamento->guardar()){
	echo "Se guardo correctamente.";
}else{
	echo "Ocurrio un error al guardar.";
}
*/


?>