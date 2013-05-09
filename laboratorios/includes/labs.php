<?php

require_once LIB_DIR.SD.'database.php';

class lab extends database_table
{
	public $id;
	public $id_rol;
	public $nombre;
	public $correo;
	public $telefono;
	public $direccion;
	public $clave;
	public $fregistro;
	public $estado;
	public $tipo;
	
	protected static $nombre_tabla = 'laboratorios';
	protected static $campos_tabla = array('id_rol','nombre','correo','telefono','direccion','clave','fregistro','estado','tipo');
	
	public static function autenticar_laboratorio($usuario='',$clave=''){
		global $bd;
		$usuario = $bd->preparar_consulta($usuario);
		$clave = $bd->preparar_consulta(sha1($clave));
		$sql = "SELECT * FROM laboratorios 
				WHERE correo='{$usuario}' 
				AND clave='{$clave}' 
				LIMIT 1";
		$matriz = lab::buscar_por_sql($sql);
		return (!empty($matriz)) ? array_shift($matriz) : false;
	}
	
}

?>