<?php

require_once LIB_DIR.SD.'database.php';

class user extends database_table
{
	public $id;
	public $nombre;
	public $usuario;
	public $clave;
	public $correo;
	public $fregistro;
	public $permisos;
	public $estado;
	
	protected static $nombre_tabla = 'usuarios';
	protected static $campos_tabla = array('nombre','usuario','clave','correo','fregistro','permisos','estado');
	
	public static function autenticar($usuario='',$clave=''){
		global $bd;
		$usuario = $bd->preparar_consulta($usuario);
		$clave = $bd->preparar_consulta(sha1($clave));
		$sql = "SELECT * FROM usuarios 
				WHERE usuario='{$usuario}' 
				AND clave='{$clave}' 
				LIMIT 1";
		$matriz = user::buscar_por_sql($sql);
		return (!empty($matriz)) ? array_shift($matriz) : false;
	}
}

?>