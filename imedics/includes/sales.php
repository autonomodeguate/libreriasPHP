<?php

require_once LIB_DIR.SD.'database.php';

class sales extends database_table{
	
	public $id;
	public $nombre;
	public $estado;
	
	protected static $nombre_tabla = "sales";
	protected static $campos_tabla = array('nombre','estado');
	
	public function sales_activas(){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='activo' ORDER BY nombre ASC";
		return $resultado = sales::buscar_por_sql($sql);
	}
	
	public function sales_inactivas(){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='bloq' ORDER BY nombre ASC";
		return $resultado = sales::buscar_por_sql($sql);
	}
		
}

?>