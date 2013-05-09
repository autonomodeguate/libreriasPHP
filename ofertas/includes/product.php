<?php

require_once(LIB_DIR.SD.'database.php');

class product extends database_table
{
	public $id;
	public $menu_id;
	public $seccion_id;
	public $subseccion_id;
	public $producto;
	public $tipo;
	public $peso;
	public $nombre;
	public $descripcion;
	public $precio;
	public $minima;
	public $fagregado;
	public $estado;
	public $fotos_dir = "productos";
	public $nombre_tmp;
	public $errores = array();
	
	protected static $nombre_tabla = "productos";
	protected static $campos_tabla = array("menu_id","seccion_id","subseccion_id","producto","tipo","peso","nombre","descripcion","precio","minima","fagregado","estado");
	
	protected $errores_upload = array(
	UPLOAD_ERR_OK => "no existe error",
	UPLOAD_ERR_INI_SIZE => "Ha excedido el tamaño especificado",
	UPLOAD_ERR_FORM_SIZE => "Excedio el tamaño maximo especificado en el formulario",
	UPLOAD_ERR_PARTIAL => "Archivo subido parcialmente",
	UPLOAD_ERR_NO_FILE => "No se ha seleccionado una imagen",
	UPLOAD_ERR_NO_TMP_DIR => "No existe un directorio temporal",
	UPLOAD_ERR_CANT_WRITE => "No se puede escribir en ese directorio",
	UPLOAD_ERR_EXTENSION => "Especificado por problema a extension instalada con php");
	
	public function ruta_archivo()
	{
		return $this->fotos_dir."/".$this->producto;
	}
	
	public function productos_por_iteam($iteam){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE menu_id={$iteam}";
		return $resultado = product::buscar_por_sql($sql);
	}
	
	/*
		/* FRONT-END
	*/
	
	public function productos_iteam($iteam){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE menu_id={$iteam} ";
		$sql .= "AND estado='activo'";
		return $resultado = product::buscar_por_sql($sql);
	}
	
	public function productos_por_seccion($iteam){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE seccion_id={$iteam} ";
		$sql .= "AND estado='activo'";
		return $resultado = product::buscar_por_sql($sql);
	}
	
	public function animales($menu_id){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE menu_id={$menu_id} ";
		$sql .= " AND estado='activo' ORDER BY id DESC LIMIT 8";
		return $resultado = product::buscar_por_sql($sql);
	}
	
	public function agricultura($menu_id){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE menu_id={$menu_id} ";
		$sql .= " AND estado='activo' ORDER BY id DESC LIMIT 8";
		return $resultado = product::buscar_por_sql($sql);
	}
	
	public function tecnologia($menu_id){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE menu_id={$menu_id} ";
		$sql .= " AND estado='activo' ORDER BY id DESC LIMIT 8";
		return $resultado = product::buscar_por_sql($sql);
	}
	
	public function lineas($menu_id){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE menu_id={$menu_id} ";
		$sql .= " AND estado='activo' ORDER BY id DESC LIMIT 8";
		return $resultado = product::buscar_por_sql($sql);
	}
	
	public function repuestos($menu_id){
		global $bd;
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE menu_id={$menu_id} ";
		$sql .= " AND estado='activo' ORDER BY id DESC LIMIT 8";
		return $resultado = product::buscar_por_sql($sql);
	}
	
	/*
		/* END FRONT-END
	*/
		
	public function adjuntar_foto($info)
	{
		if(!$info && empty($info) && !is_array($info))
		{
			array_push($this->errores,"El archivo no es valido. ");
			return false;
		}
		elseif($info['error'] != 0)
		{
			array_push($this->errores,$this->errores_upload[$info['error']]);
			return false;
		}
		else
		{
			$this->producto = basename($info['name']);
			$this->tipo = $info['type'];
			$this->peso = $info['size'];
			$this->nombre_tmp = $info['tmp_name'];
			return true;
		}
	}
	
	public function guardar()
	{
		if(!isset($this->id))
		{
			if(!empty($this->errores))
			{
				return false;
			}
			
			$nueva_ruta = RAIZ_DIR.SD."ofertas".SD.$this->fotos_dir.SD.$this->producto;
			
			if(empty($this->nombre_tmp))
			{
				$this->errores[] = "No se encontraron los datos suficientes. ";
				return false;
			}
			
			if(file_exists($nueva_ruta))
			{
				$this->errores[] = "La imagen del producto ya fue subida anteriormente. ";
				return false;
			}
			
			if(move_uploaded_file($this->nombre_tmp,$nueva_ruta))
			{
				if($this->crear())
				{
					return true;
				}
				else
				{
					$this->errores[] = "No se creo el registro en la base de datos. ";
					return false;
				}
			}
			else
			{
				$this->errores[] = "No se pudo mover el archivo a un directorio seguro. ";
				return false;
			}
		}
		else
		{
			$this->actualizar();
		}
	}
	
	public function suprimir()
	{
		$nueva_ruta = RAIZ_DIR.SD."ofertas".SD.$this->fotos_dir.SD.$this->producto;
		if($this->eliminar())
		{
			return unlink($nueva_ruta);
		}
	}
}

?>