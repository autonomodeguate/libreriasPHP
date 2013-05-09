<?php

require_once(LIB_DIR.SD.'database.php');

class medicament extends database_table{

	public $id;
	public $imagen;
	public $tipo;
	public $peso;
	public $nombre;
	public $especialidad_id;
	public $laboratorio_id;
	public $fagregado;
	public $estado;
	public $pagina;
	public $bonificacion;
	public $bonificacion_visita;
	public $fotos_dir = "medicamentos";
	public $nombre_tmp;
	public $errores = array();
	
	protected static $nombre_tabla = "medicamento";
	protected static $campos_tabla = array("imagen","tipo","peso","nombre","especialidad_id","laboratorio_id","fagregado","estado","bonificacion","bonificacion_visita","pagina");
	
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
		return $this->fotos_dir."/".$this->imagen;
	}
	
	
	/*--- Funciones para FRONT END ---*/
	
	public function medicamentos_por_especialidad($especialidad){
		
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE especialidad_id={$especialidad} AND estado='activo'";
		$sql .= " ORDER BY nombre ASC";
		return $resultado = medicament::buscar_por_sql($sql);
		
	}
	
	public function medicamentos_activos(){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='activo' ORDER BY nombre ASC";
		return $resultado = medicament::buscar_por_sql($sql);
	}
	
	/*--- Funciones Laboratorios ---*/
	
	public function medicamentos_por_laboratorio($lab_id){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE laboratorio_id = {$lab_id}";
		$sql .= " ORDER BY nombre ASC";
		return $resultado = medicament::buscar_por_sql($sql);
	}
	
	/*--- Funciones Back End ---*/
	
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
			$this->imagen = basename($info['name']);
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
			
			$nueva_ruta = RAIZ_DIR.SD."medics".SD.$this->fotos_dir.SD.$this->imagen;
			
			if(empty($this->nombre_tmp))
			{
				$this->errores[] = "No se encontraron los datos suficientes. ";
				return false;
			}
			
			if(file_exists($nueva_ruta))
			{
				$this->errores[] = "La imagen del medicamento ya fue subida anteriormente. ";
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
		$nueva_ruta = RAIZ_DIR.SD."medics".SD.$this->fotos_dir.SD.$this->imagen;
		if($this->eliminar())
		{
			return unlink($nueva_ruta);
		}
	}
}

?>