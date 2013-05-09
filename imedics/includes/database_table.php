<?php

require_once(LIB_DIR.SD."database.php");

class database_table
{
	protected static $nombre_tabla;
	protected static $campos_tabla;
	
	public static function buscar_por_id($id)
	{
		global $bd;
		$matriz_objetos = self::buscar_por_sql("SELECT * FROM ".static::$nombre_tabla." WHERE id=".$bd->preparar_consulta($id));
		return (!empty($matriz_objetos)) ? array_shift($matriz_objetos) : false;
	}
	
	public static function buscar_todos()
	{
		return self::buscar_por_sql("SELECT * FROM ".static::$nombre_tabla);
	}
	
	public static function buscar_por_sql($sql)
	{
		global $bd;
		$matriz_objetos = array();
		$resultado = $bd->enviar_consulta($sql);
		while($registro = $bd->fetch_array($resultado))
		{
			array_push($matriz_objetos,self::instanciar($registro));
		}
		return $matriz_objetos;
	}
	
	public static function instanciar($registro)
	{
		$nombre_clase = get_called_class();
		$objeto = new $nombre_clase;
		foreach($registro as $propiedad => $valor)
		{
			if($objeto->propiedad_existe($propiedad))
			{
				$objeto->$propiedad = $valor;
			}
		}
		return $objeto;
	}
	
	public function propiedad_existe($propiedad)
	{
		$propiedades = get_object_vars($this);
		return array_key_exists($propiedad,$propiedades);
	}
	
	public function propiedades()
	{
		$valores_tabla = array();
		foreach(static::$campos_tabla as $campo)
		{
			$valores_tabla[$campo] = $this->$campo;
		}
		return $valores_tabla;
	}
	
	public function guardar()
	{
		if(!isset($this->id))
		{
			return $this->crear();
		}
		else
		{
			return $this->actualizar();
		}
	}
	
	public function crear()
	{
		global $bd;
		$propiedades = $this->propiedades();
		$sql = "INSERT INTO ".static::$nombre_tabla." (";
		$sql .= implode(",",array_keys($propiedades));
		$sql .= ") VALUES ('";
		$sql .= implode("','",array_values($propiedades)). "')";
		if($bd->enviar_consulta($sql))
		{
			$this->id = $bd->insert_id();
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function actualizar()
	{
		global $bd;
		$campos_prop = array();
		$propiedades = $this->propiedades();
		foreach($propiedades as $propiedad => $valor)
		{
			array_push($campos_prop,"{$propiedad} = '{$valor}'");
		}
		$sql = "UPDATE ".static::$nombre_tabla." SET ";
		$sql .= join(",",$campos_prop);
		$sql .= " WHERE id=".$bd->preparar_consulta($this->id);
		$bd->enviar_consulta($sql);
		if($bd->affected_rows()==1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function eliminar()
	{
		global $bd;
		$sql = "DELETE FROM ".static::$nombre_tabla;
		$sql .= " WHERE id=".$bd->preparar_consulta($this->id);
		$bd->enviar_consulta($sql);
		if($bd->affected_rows()==1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>