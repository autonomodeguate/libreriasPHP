<?php

require_once LIB_DIR.SD.'database.php';

class visit extends database_table
{
	public $id;
	public $producto_id;
	public $medico_id;
	public $laboratorio_id;
	public $bonificacion;
	public $fecha;
	
	protected static $nombre_tabla = 'visitas_productos';
	protected static $campos_tabla = array('producto_id','medico_id','laboratorio_id','bonificacion','fecha');
	
	public function visitas_por_medico($medico){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE medico_id={$medico} ORDER BY fecha ASC";
		return $resultado = visit::buscar_por_sql($sql);
	}
}

?>