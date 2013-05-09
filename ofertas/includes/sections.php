<?php

require_once LIB_DIR.SD.'database.php';

class sections extends database_table{

	public $id;
	public $menu_id;
	public $nombre;
	public $estado;
	
	protected static $nombre_tabla = "secciones";
	protected static $campos_tabla = array('menu_id','nombre','estado');
	
	public function secciones_activas(){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='activo'";
		return $resultado = sections::buscar_por_sql($sql);
	}
	
	public function secciones_inactivas(){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='bloq'";
		return $resultado = sections::buscar_por_sql($sql);
	}
	
	public function secciones_por_iteam($i){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE menu_id={$i}";
		return $resultado = sections::buscar_por_sql($sql);
	}
	
	/*
		/* FRONT-END
	*/
	
	public function secciones_activas_por_iteam($iteam){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE menu_id={$iteam} ";
		$sql .= "AND estado='activo' ORDER BY nombre ASC";
		return $resultado = sections::buscar_por_sql($sql);
	}
		
}

?>