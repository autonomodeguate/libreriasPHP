<?php require_once('../../includes/initialize.php'); ?>
<?php 
	//Buscamos las secciones
	$subsecciones = subsections::subsecciones_por_seccion($_GET['id']);
	
	echo '<div>';
	echo '<label for="subseccion">Sub Sección:</label>';
	echo '<select name="subseccion">';
	foreach($subsecciones as $subseccion){
		echo '<option value="'.$subseccion->id.'">'.$subseccion->nombre.'</option>';
	}
	echo "</select>";
	echo '</div>';
?>