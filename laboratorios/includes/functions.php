<?php

function redireccionar_a($url){
	header("Location: {$url}");
	exit();
}

function __autoload($nombre_clase){
	die("No se definio la clase: {$nombre_clase}");
}

function incluir_plantilla($nombre)
{
	include(RAIZ_DIR.SD."public".SD."layouts".SD.$nombre);
}

function grabar_acciones($accion,$mensaje)
{
	$ruta_archivo = RAIZ_DIR.SD."logs".SD."log.txt";
	if($archivo = fopen($ruta_archivo,"at"))
	{
		$tiempo = date("Y-m-d");
		$cadena = $tiempo . " | " . $accion . " | " . $mensaje ."\n";
		fwrite($archivo,$cadena);
		fclose($archivo);
	}
}

?>