<?php

require_once LIB_DIR.SD.'database.php';

class speciality extends database_table{
	
	public $id;
	public $nombre;
	public $estado;
	
	protected static $nombre_tabla = "especialidades";
	protected static $campos_tabla = array('nombre','estado');
	
	public function obtener_especialidades_activas(){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='activo' ORDER BY nombre ASC";
		return $resultado = speciality::buscar_por_sql($sql);
	}
	
	public function obtener_especialidades_bloq(){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='bloq' ORDER BY nombre ASC";
		return $resultado = speciality::buscar_por_sql($sql);
	}
	
}

?>