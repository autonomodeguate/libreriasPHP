<?php require_once('../includes/initialize.php'); ?>
<?php 
	//Buscamos las secciones
	$medicamentos = medicament::medicamentos_por_sal($_GET['id']);
	
	echo '<div id="ajax">';
	echo '<label for="seccion">Medicamento:</label>';
	echo '<select name="medicamento_cuatro">';
	foreach($medicamentos as $medicamento){
		echo '<option value="'.$medicamento->id.'">'.htmlentities($medicamento->nombre).'</option>';
	}
	echo "</select>";
	echo '</div>';
?>