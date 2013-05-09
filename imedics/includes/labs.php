<?php

require_once LIB_DIR.SD.'database.php';

class lab extends database_table
{
	public $id;
	public $id_rol;
	public $nombre;
	public $correo;
	public $telefono;
	public $clave;
	public $fregistro;
	public $estado;
	
	protected static $nombre_tabla = 'laboratorios';
	protected static $campos_tabla = array('id_rol','nombre','correo','telefono','clave','fregistro','estado');
	
	public function lab_activos(){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='activo' ORDER BY nombre ASC";
		return $resultado = lab::buscar_por_sql($sql);
	}
	
}

?>