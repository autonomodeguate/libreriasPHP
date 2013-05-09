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
	
	$recetas = prescription::recetas_efectivas();
	
?>
<!doctype html>
<html lang="es">
<head>
	<!-- Meta´s -->
	<meta charset="UTF-8" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	
	<title>Recetas Efectivas - iMedics.ws</title>
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
					<li><a class="selected" href="recetas-efectivas.php">Recetas Efectivas</a></li>
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
			
			<?php if(isset($message) || isset($_GET["message"])) { ?>
					<div id="error">
						<?php
							if(isset($_GET["message"]))	{ echo $_GET["message"]; }
							if(isset($message))	{ echo $message; }
						?>
					</div>
			<?php } ?>
			
			<table width="100%">
				<tr>
					<td><b>#Receta</b></td>
					<td><b>Nombre del Medico</b></td>
					<td><b>Nombre del Paciente</b></td>
					<td><b>Fecha</b></td>
					<td><b>Estado</b></td>
					<td><b>R. Detallada</b></td>
				</tr>
				<?php if(count($recetas) != 0){ ?>
					<?php foreach($recetas as $receta){ ?>
					<tr>
						<td><?php echo $receta->id; ?></td>
						<?php $medico = medic::buscar_por_id($receta->medico_id); ?>
						<td><?php echo $medico->nombre; ?></td>
						<td><?php echo $receta->paciente; ?></td>
						<td><?php $fecha = date("d/m/Y",strtotime($receta->fecha)); echo $fecha; ?></td>
						<td><?php if($receta->estado == 'positivo'){ echo " <span class='positivo'>Positivo</span>";} ?><?php if($receta->estado == 'negativo'){ echo " <span class='negativo'>Negativo</span>";} ?> <?php if($receta->estado == 'pendiente'){ echo " <span class='pendiente'>Pendiente</span>";} ?></td>
						<td><a href="view-prescription.php?prescription=<?php echo urlencode($receta->id); ?>">Ver</a></td>
					</tr>
					<?php } ?>
				<?php }else{?>
				<tr>
					<td colspan="6">Por el momento no hay recetas pendientes de revisión.</td>
				</tr>
				<?php } ?>
			</table>
			
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