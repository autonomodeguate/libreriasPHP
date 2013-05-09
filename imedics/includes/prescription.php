<?php

require_once LIB_DIR.SD.'database.php';

class prescription extends database_table
{
	public $id;
	public $medico_id;
	
	public $medicamento1_id;
	public $laboratorio1_id;
	public $medicacion1;
	
	public $medicamento2_id;
	public $laboratorio2_id;
	public $medicacion2;
	
	public $medicamento3_id;
	public $laboratorio3_id;
	public $medicacion3;
	
	public $medicamento4_id;
	public $laboratorio4_id;
	public $medicacion4;
	
	public $paciente;
	public $telefono;
	public $correo;
	public $fecha;
	public $bonificacion;
	public $estado;
	public $observaciones;
	
	protected static $nombre_tabla = 'recetas';
	protected static $campos_tabla = array('medico_id','medicamento1_id','laboratorio1_id','medicacion1','medicamento2_id','laboratorio2_id','medicacion2','medicamento3_id','laboratorio3_id','medicacion3','medicamento4_id','laboratorio4_id','medicacion4','paciente','telefono','correo','fecha','bonificacion','estado','observaciones');
	
	public function recetas_por_medico($medico){		
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE medico_id={$medico} ORDER BY id DESC";
		return $resultado = prescription::buscar_por_sql($sql);		
	}
	
	public function recetas_por_fecha(){
		$sql = "SELECT * FROM ".static::$nombre_tabla." ORDER BY id DESC";
		return $resultado = prescription::buscar_por_sql($sql);
	}
	
	public function recetas_efectivas(){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='positivo' ORDER BY id DESC";
		return $resultado = prescription::buscar_por_sql($sql);
	}
	
	public function recetas_negativas(){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='negativo' ORDER BY id DESC";
		return $resultado = prescription::buscar_por_sql($sql);
	}
	
	public function recetas_pendientes(){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='pendiente' ORDER BY id DESC";
		return $resultado = prescription::buscar_por_sql($sql);
	}
	
	public function recetas_seguimiento(){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='seguimiento' ORDER BY id DESC";
		return $resultado = prescription::buscar_por_sql($sql);
	}
	
}

?>