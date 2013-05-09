<?php

require_once LIB_DIR.SD.'database.php';

class comment extends database_table
{
	public $id;
	public $especialidad_id;
	public $medicamento_id;
	public $nombre_medicamento;
	public $doctor_id;
	public $nombre_doctor;
	public $comentario;
	public $fagregado;
	public $laboratorio_id;
	
	protected static $nombre_tabla = 'comentarios';
	protected static $campos_tabla = array('especialidad_id','medicamento_id','nombre_medicamento','doctor_id','nombre_doctor','comentario','fagregado','laboratorio_id');
	
}

?>