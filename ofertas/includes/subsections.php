<?php

require_once LIB_DIR.SD.'database.php';

class subsections extends database_table{

	public $id;
	public $seccion_id;
	public $menu_id;
	public $nombre;
	public $estado;
	
	protected static $nombre_tabla = "subsecciones";
	protected static $campos_tabla = array('seccion_id','menu_id','nombre','estado');
	
	public function subsecciones_por_seccion($seccion_id){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE seccion_id={$seccion_id} ORDER BY nombre ASC";
		return $resultado = subsections::buscar_por_sql($sql);
	}
	
	public function subsecciones_por_menu($menu_id){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE menu_id={$menu_id} ORDER BY nombre ASC";
		return $resultado = subsections::buscar_por_sql($sql);
	}
	
	public function subsecciones_activas(){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='activo'";
		return $resultado = subsections::buscar_por_sql($sql);
	}
	
	public function subsecciones_bloq(){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='bloq'";
		return $resultado = subsections::buscar_por_sql($sql);
	}
	
	/*
		/* FRONT-END
	*/
	
	public function obtener_subsecciones_por_seccion($seccion_id){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE seccion_id={$seccion_id} AND estado='activo' ORDER BY nombre ASC";
		return $resultado = subsections::buscar_por_sql($sql);
	}
		
}

?>