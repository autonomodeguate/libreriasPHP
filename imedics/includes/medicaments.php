<?php

require_once(LIB_DIR.SD.'database.php');

class medicament extends database_table{

	public $id;
	public $sal_id;
	public $imagen;
	public $tipo;
	public $peso;
	public $nombre;
	public $nombre_generico;
	public $indicaciones;
	public $efectos_adversos;
	public $dosificaciones;
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
	protected static $campos_tabla = array("sal_id","imagen","tipo","peso","nombre","nombre_generico","indicaciones","efectos_adversos","dosificaciones","especialidad_id","laboratorio_id","fagregado","estado","bonificacion","bonificacion_visita","pagina");
	
	protected $errores_upload = array(
	UPLOAD_ERR_OK => "no existe error",
	UPLOAD_ERR_INI_SIZE => "Ha excedido el tama�o especificado",
	UPLOAD_ERR_FORM_SIZE => "Excedio el tama�o maximo especificado en el formulario",
	UPLOAD_ERR_PARTIAL => "Archivo subido parcialmente",
	UPLOAD_ERR_NO_FILE => "No se ha seleccionado una imagen",
	UPLOAD_ERR_NO_TMP_DIR => "No existe un directorio temporal",
	UPLOAD_ERR_CANT_WRITE => "No se puede escribir en ese directorio",
	UPLOAD_ERR_EXTENSION => "Especificado por problema a extension instalada con php");
	
	public function ruta_archivo()
	{
		$cadena = str_replace(" ","-",$this->nombre);
		return $this->fotos_dir."/".$cadena.substr($this->imagen,-4);
	}
	
	
	/*--- Funciones para FRONT END ---*/
	
	public function medicamentos_por_especialidad_sal($sal,$especialidad){
		
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE sal_id = {$sal} AND especialidad_id={$especialidad} AND estado='activo'";
		$sql .= " ORDER BY nombre ASC";
		return $resultado = medicament::buscar_por_sql($sql);		
	}
	
	public function medicamentos_por_especialidad($especialidad){
		
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE especialidad_id={$especialidad} AND estado='activo'";
		$sql .= " ORDER BY nombre ASC";
		return $resultado = medicament::buscar_por_sql($sql);		
	}
	
	public function medicamentos_por_sal($sal_id){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE sal_id={$sal_id} AND estado='activo'";
		$sql .= " ORDER BY nombre ASC";
		return $resultado = medicament::buscar_por_sql($sql);
	}
	
	public function medicamentos_activos(){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE estado='activo' ORDER BY nombre ASC";
		return $resultado = medicament::buscar_por_sql($sql);
	}
	
	public function medicamentos_iteam($iteam){
		$sql = "SELECT * FROM ".static::$nombre_tabla;
		$sql .= " WHERE sal_id={$iteam} ORDER BY nombre ASC";
		return $resultado = medicament::buscar_por_sql($sql);
	}
	
	/* Back-end */
	
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
			
			//$nueva_ruta = RAIZ_DIR.SD."imedics".SD.$this->fotos_dir.SD.$this->imagen;
			$cadena = str_replace(" ","-",$this->nombre);
			$nueva_ruta = RAIZ_DIR.SD."imedics".SD.$this->fotos_dir.SD.$cadena.".".substr($this->imagen,-3);
			
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