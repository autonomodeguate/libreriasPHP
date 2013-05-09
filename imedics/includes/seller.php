<?php

require_once LIB_DIR.SD.'database.php';

class seller extends database_table{
	public $id;
	public $nombre;
	public $usuario;
	public $clave;
	public $estado;
	
	protected static $nombre_tabla = 'vendedor';
	protected static $campos_tabla = array('nombre','usuario','clave','estado');
	
	public static function autenticar($usuario='',$clave=''){
		global $bd;
		$usuario = $bd->preparar_consulta($usuario);
		$clave = $bd->preparar_consulta(sha1($clave));
		$sql = "SELECT * FROM vendedor 
				WHERE usuario='{$usuario}' 
				AND clave='{$clave}' 
				LIMIT 1";
		$matriz = seller::buscar_por_sql($sql);
		return (!empty($matriz)) ? array_shift($matriz) : false;
	}
}

?>