<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a('login.php');} ?>
<?php if(isset($sesion->usuario_id)){ $usuario = user::buscar_por_id($sesion->usuario_id); } ?>
<?php
	//$sql = "select count( * ) as conteo from permisos where id_accesos = {$id_acceso} and id_rol = {$tipo}";
	$id_acceso = 3;
	$sql = "select count( * ) as conteo from permisos where id_accesos = {$id_acceso} and id_rol = (select id_rol from usuarios where id = {$usuario->id})";
	$resultado = mysql_query($sql);
	$db = mysql_fetch_array($resultado);
	$acceso = $db['conteo'];	
	if($acceso == 0){
		redireccionar_a("logout.php");
	}	
?>
<!doctype html>
<html lang="es">
<head>
	<!-- Meta´s -->
	<meta charset="UTF-8" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	
	<title>Administración iMedics.ws</title>
	
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
	
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
					<li><a class="selected" href="index.php">Inicio</a></li>
					<li><a href="log-file.php">Ver Archivo Log</a></li>
					<li><a href="add-speciality.php">Agregar Especialidad</a></li>
					<li><a href="add-section-iteam.php">Agregar Principio Activo</a></li>
					<li><a href="add-product.php">Agregar Medicamento</a></li>
				</ul>
			</nav>
			<!-- #/Menu -->
			
		</header>
		<!-- #/Header -->
		
		<!-- Info -->
		<div id="info">
			Bienvenido al panel de administración: <b><?php echo $usuario->nombre; ?> | <a href="logout.php">Salir</a></b>
		</div>
		<!-- #/Info -->
		
		<!-- Banner -->
		<div id="banner">
			<img src="../images/banner_admin1.jpg" alt="banner" />
		</div>
		<!-- #/Banner -->
		
		<!-- Footer -->		
		<footer id="footer">
			Todos los derechos reservados 2012 iMedics.ws - Diseñado y Programado por: Luis Barrera - AutonomoDeGuate.com
		</footer>
		<!-- #/Footer -->
		
	</section>
	<!-- #/Wrapper -->

</body>
</html>