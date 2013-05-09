<?php

require_once LIB_DIR.SD.'database.php';

class medic extends database_table
{
	public $id;
	public $id_rol;
	public $nombre;
	public $correo;
	public $especialidad_id;
	public $telefono;
	public $direccion;
	public $colegiado;
	public $usuario;
	public $clave;
	public $estado;
	public $fagregado;
	public $sexo;
	
	protected static $nombre_tabla = 'medicos';
	protected static $campos_tabla = array('id_rol','nombre','correo','especialidad_id','telefono','direccion','colegiado','usuario','clave','estado','fagregado','sexo');
	
	public static function autenticar($usuario='',$clave=''){
		global $bd;
		$usuario = $bd->preparar_consulta($usuario);
		$clave = $bd->preparar_consulta(sha1($clave));
		$sql = "SELECT * FROM medicos 
				WHERE usuario='{$usuario}' 
				AND clave='{$clave}' 
				LIMIT 1";
		$matriz = medic::buscar_por_sql($sql);
		return (!empty($matriz)) ? array_shift($matriz) : false;
	}
}

?>