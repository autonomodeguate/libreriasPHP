<?php

require_once LIB_DIR.SD.'database.php';

class prescription extends database_table
{
	public $id;
	public $medico_id;
	public $medicamento_id;
	public $laboratorio_id;
	public $paciente;
	public $dosis;
	public $fecha;
	public $bonificacion;
	
	protected static $nombre_tabla = 'recetas';
	protected static $campos_tabla = array('medico_id','medicamento_id','laboratorio_id','paciente','dosis','fecha','bonificacion');
	
	public function recetas_por_medico($medico){		
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE medico_id={$medico} ORDER BY id ASC";
		return $resultado = prescription::buscar_por_sql($sql);		
	}
	
	public function recetas_por_producto($fecha_ini,$fecha_fin,$producto,$lab){
		$sql = "SELECT * FROM ".static::$nombre_tabla." WHERE fecha between '{$fecha_ini}' and '{$fecha_fin}'";
		$sql .= " AND laboratorio_id={$lab} AND medicamento_id={$producto} ORDER BY fecha ASC";
		return $resultado = prescription::buscar_por_sql($sql);
	}
	
	public function recetas_por_laboratorio($fecha_ini,$fecha_fin,$lab){
		$sql = "SELECT * FROM ".static::$nombre_tabla." WHERE fecha between '{$fecha_ini}' and '{$fecha_fin}'";
		$sql .= " AND laboratorio_id={$lab} ORDER BY fecha ASC";
		return $resultado = prescription::buscar_por_sql($sql);
	}
	
}

?>