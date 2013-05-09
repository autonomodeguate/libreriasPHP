<?php

require_once LIB_DIR.SD.'database.php';

class search extends database_table{

	public $id;
	public $title;
	public $description;
	public $url;
	public $keywords;
	
	protected static $nombre_tabla = "search";
	protected static $campos_tabla = array('title','description','url','keywords');
		
}

?>