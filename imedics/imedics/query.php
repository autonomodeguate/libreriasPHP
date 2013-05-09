<?php require_once('../includes/initialize.php'); ?>
<?php 
	//Buscamos las secciones
	$medicamentos = medicament::medicamentos_por_sal($_GET['id']);
	
	echo '<div id="ajax">';
	echo '<label for="seccion">Medicamento:</label>';
	echo '<select name="medicamento1">';
	foreach($medicamentos as $medicamento){
		echo '<option value="'.$medicamento->id.'">'.htmlentities($medicamento->nombre).'</option>';
	}
	echo "</select>";
	echo '<input type="hidden" name="bonificacion" value="'.$medicamento->bonificacion.'" />';
	echo '<input type="hidden" name="laboratorio1" value="'.$medicamento->laboratorio_id.'" />';
	echo '</div>';
?>