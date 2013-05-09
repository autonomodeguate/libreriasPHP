<?php

require_once LIB_DIR.SD.'config.php';

class database{
	
	public $conexion;
	public $ultima_consulta;
	public $mq_activado;
	public $real_escape_string;
	
	function __construct()
	{
		$this->abrir_conexion();
		$this->mq_activado = get_magic_quotes_gpc();
		$this->real_escape_string = function_exists("mysql_real_escape_string");
	}
	
	public function abrir_conexion(){
		$this->conexion = @mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		if(!$this->conexion){
			die('No se pudo conectar al servidor de la base de datos: '. mysql_error());
		}
		else{
			$db_select = mysql_select_db(DB_NAME, $this->conexion);
			if(!$db_select){
				die('No se pudo seleccionar la base de datos: '. mysql_error());
			}
		}
	}
	
	public function enviar_consulta($sql){
		$this->ultima_consulta = $sql;
		$resultado = mysql_query($sql,$this->conexion);
		$this->verificar_consulta($resultado);
		return $resultado;
	}
	
	public function fetch_array($resultado){
		return mysql_fetch_array($resultado);
	}
	
	public function num_rows($resultado){
		return mysql_num_rows($resultado);
	}
	
	public function affected_rows(){
		return mysql_affected_rows($this->conexion);
	}
	
	public function insert_id(){
		return mysql_insert_id($this->conexion);
	}
	
	public function preparar_consulta($consulta)
	{
		if($this->real_escape_string)
		{
			if($this->mq_activado)
			{
				$consulta = stripslashes($consulta);
			}
			$consulta = mysql_real_escape_string($consulta);
		}
		else
		{
			if(!$this->mq_activado)
			{
				$consulta = addslashes($consulta);
			}
		}
		return $consulta;
	}
	
	private function verificar_consulta($resultado){
		if(!$resultado){
			$salida = "Error al realizar la consulta: ". mysql_error();
			$salida .= " <br />Ultima consulta SQL: ".$this->ultima_consulta;
			die($salida);
		}
	}
	
	public function cerrar_conexion(){
		if(isset($this->conexion)){
			mysql_close($this->conexion);
			unset($this->conexion);
		}
	}
	
}

$bd = new database();

?>