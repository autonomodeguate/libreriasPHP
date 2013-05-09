<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a('login.php');} ?>
<?php if(isset($sesion->usuario_id)){ $usuario = seller::buscar_por_id($sesion->usuario_id); } ?>
<?php
	//$sql = "select count( * ) as conteo from permisos where id_accesos = {$id_acceso} and id_rol = (select id_rol from medicos where id = {$medico->id})";
	$id_acceso = 4;
	$sql = "select count(*) as conteo from permisos where id_accesos = {$id_acceso} and id_rol = (select id_rol from vendedor where id = {$usuario->id})";
	$resultado = mysql_query($sql);
	$db = mysql_fetch_array($resultado);
	$acceso = $db['conteo'];	
	if($acceso == 0){
		redireccionar_a("logout.php");
	}
?>
<?php
	
	if(isset($_GET['prescription']) && !empty($_GET['prescription'])){
		$receta = prescription::buscar_por_id($_GET['prescription']);
	}else{
		redireccionar_a('index.php');
	}
	
	if(isset($_POST['submit'])){
		
		$receta_id = $_POST['receta_id'];
		$observaciones = $_POST['observaciones'];
		$estado = $_POST['estado'];
		
		$recetaedit = prescription::buscar_por_id($receta_id);
		$recetaedit->observaciones = $observaciones;
		$recetaedit->estado = $estado;
		if($recetaedit->guardar()){
			redireccionar_a('index.php?message=La receta se actualizo correctamente.');
		}else{
			$mensaje = "Ocurrio un error al actualizar la receta, intentolo mas tarde.";
		}
		
	}
	
?>
<!doctype html>
<html lang="es">
<head>
	<!-- Meta´s -->
	<meta charset="UTF-8" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	
	<title>Receta Detallada - iMedics.ws</title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="../css/adminv.css" />
	
	
	<!-- html5.js for IE less than 9 -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
</head>
<body>

	<!-- Wrapper -->
	<section id="wrapper">
		
		<!-- Header -->
		<header id="header" class="clearfix">
			
			<!-- Logo -->
			<div class="logo">
				<img src="../images/logotipo.png" alt="Logo" />
			</div>
			<!-- #/Logo -->
			
			<!-- Menu -->
			<nav id="access">
				<ul>
					<li><a href="index.php">Inicio</a></li>
					<li><a href="recetas-efectivas.php">Recetas Efectivas</a></li>
					<li><a href="recetas-negativas.php">Recetas Negativas</a></li>
					<li><a href="seguimientos.php">Seguimientos</a></li>
					<li><a href="logout.php">Salir</a></li>
				</ul>
			</nav>
			<!-- #/Menu -->
			
		</header>
		<!-- #/Header -->
		
		<!-- Info -->
		<div id="info">
			Bienvenido, <b><?php echo $usuario->nombre; ?></b>
		</div>
		<!-- #/Info -->
		
		<!-- Prescriptions -->
		<div id="prescriptions">
			<hgroup>
				<h1>Receta #2</h1>
			</hgroup>
			
			<?php if(isset($message) || isset($_GET["message"])) { ?>
					<div id="error">
						<?php
							if(isset($_GET["message"]))	{ echo $_GET["message"]; }
							if(isset($message))	{ echo $message; }
						?>
					</div>
			<?php } ?>
			
			<form method="post">
						
						<fieldset>
							<input type="hidden" name="receta_id" value="<?php echo $receta->id; ?>" />
							<div>
								<label for=""><b>Medico:</b></label>
								<?php $medico = medic::buscar_por_id($receta->medico_id); ?>
								<?php $especialidad = speciality::buscar_por_id($medico->especialidad_id); ?>
								<input type="text" name="medico" value="<?php echo $medico->nombre; ?> - <?php echo htmlentities($especialidad->nombre); ?>" />
							</div>
							<div>
								<label for="paciente"><b>Nombre del Paciente:</b></label>
								<input type="text" name="paciente" readonly="readonly" value="<?php echo $receta->paciente; ?>" />
							</div>
							<div>
								<label for="telefono"><b>Teléfono del Paciente:</b></label>
								<input type="text" name="telefono" readonly="readonly" value="<?php echo $receta->telefono; ?>" />
							</div>
							<div>
								<label for="paciente"><b>Correo del Paciente:</b></label>
								<input type="text" name="correo" readonly="readonly" value="<?php echo $receta->correo; ?>" />
							</div>
							
							<!-- Combo 1 -->
							<div>
								<label for="medicamento"><b>Medicamento 1:</b></label>
								<?php $medicamento1 = medicament::buscar_por_id($receta->medicamento1_id); ?>
								<input style="color:red;" type="text" name="correo" readonly="readonly" value="<?php echo $medicamento1->nombre; ?>" />
							</div>
							<div>
								<label for="explicacion"><b>Medicación:</b></label>
								<textarea rows="3" name="medicacion1" readonly="readonly"><?php echo $receta->medicacion1; ?></textarea>
							</div>
							
							<div>
								<label for="medicamento"><b>Medicamento 2:</b></label>
								<?php $medicamento2 = medicament::buscar_por_id($receta->medicamento2_id); ?>
								<input style="color:red;" type="text" name="correo" readonly="readonly" value="<?php if(!empty($medicamento2)){ echo $medicamento2->nombre; }else{ echo "---"; } ?>" />
							</div>
							<div>
								<label for="explicacion"><b>Medicación:</b></label>
								<textarea rows="3" name="medicacion1" readonly="readonly"><?php echo $receta->medicacion2; ?></textarea>
							</div>
							
							<div>
								<label for="medicamento"><b>Medicamento 3:</b></label>
								<?php $medicamento3 = medicament::buscar_por_id($receta->medicamento3_id); ?>
								<input style="color:red;" type="text" name="correo" readonly="readonly" value="<?php if(!empty($medicamento3)){ echo $medicamento3->nombre; }else{ echo "---"; } ?>" />
							</div>
							<div>
								<label for="explicacion"><b>Medicación:</b></label>
								<textarea rows="3" name="medicacion1" readonly="readonly"><?php echo $receta->medicacion3; ?></textarea>
							</div>
							<div>
								<label for="observaciones"><b>Observaciones</b></label>
								<textarea name="observaciones" cols="15" rows="8"><?php echo $receta->observaciones; ?></textarea>
							</div>
							<div>
								<label for="estado"><b>Estado:</b></label>
								<select name="estado">
									<option>Seleccione...</option>
									<option value="positivo" <?php if($receta->estado == 'positivo'){ echo " selected";} ?>>Compro Medicamento</option>
									<option value="negativo" <?php if($receta->estado == 'negativo'){ echo " selected";} ?>>No desea comprar</option>
									<option value="seguimiento" <?php if($receta->estado == 'seguimiento'){ echo " selected";} ?>>Volver a llamar</option>
								</select>
							</div>							
							<div id="bottoms">
								<input type="submit" name="submit" value="Actualizar Datos" class="css3button" /> - <a href="JavaScript:void(0);" onclick="window.history.back(-1);">Regresar</a>
							</div>
							
						</fieldset>
						
					</form>
			
		</div>
		<!-- #/Prescriptions -->
		
		<!-- Footer -->		
		<footer id="footer">
			Todos los derechos reservados 2012 iMedics.ws <!--Diseñado y Programado por: Luis Barrera - AutonomoDeGuate.com -->
		</footer>
		<!-- #/Footer -->
		
	</section>
	<!-- #/Wrapper -->

</body>
</html>