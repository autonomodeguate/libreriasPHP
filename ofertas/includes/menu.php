<?php

require_once LIB_DIR.SD.'database.php';

class menu extends database_table{

	public $id;
	public $nombre;
	public $estado;
	
	protected static $nombre_tabla = "menu";
	protected static $campos_tabla = array('nombre','estado');
	
	public function obtener_menus(){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='activo'";
		return $resultado = menu::buscar_por_sql($sql);
	}
	
	public function menus_activos(){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='activo'";
		return $resultado = menu::buscar_por_sql($sql);
	}
	
	public function menus_inactivos(){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='bloq'";
		return $resultado = menu::buscar_por_sql($sql);
	}
	
}

?>