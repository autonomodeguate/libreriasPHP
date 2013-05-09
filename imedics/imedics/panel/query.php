<?php require_once('../../includes/initialize.php'); ?>
<?php 
	//Buscamos las secciones
	$secciones = sections::secciones_por_iteam($_GET['id']);
	
	echo '<div>';
	echo '<label for="seccion">Sección:</label>';
	echo '<select name="seccion" onchange="combo_dependiente()>';
	foreach($secciones as $seccion){
		echo '<option value="'.$seccion->id.'">'.$seccion->nombre.'</option>';
	}
	echo "</select>";
	echo '</div>';
?>