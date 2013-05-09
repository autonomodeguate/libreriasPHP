<?php

require_once LIB_DIR.SD.'database.php';

class register extends database_table{

	public $id;
	public $nombre;
	public $telefono;
	public $cupon;
	public $fregistro;
	
	protected static $nombre_tabla = "usuarios_cupones";
	protected static $campos_tabla = array('nombre','telefono','cupon','fregistro');
	
	public function verificar_cupon($cupon){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE cupon={$cupon} LIMIT 1";
		$matriz = register::buscar_por_sql($sql);
		return (!empty($matriz)) ? array_shift($matriz) : false;
	}
	
}

?>