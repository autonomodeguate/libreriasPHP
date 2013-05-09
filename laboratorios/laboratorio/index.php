<?php require_once('../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a("login.php");} ?>
<?php if(isset($sesion->usuario_id)){ $laboratorio = lab::buscar_por_id($sesion->usuario_id); } ?>
<?php
	//$sql = "select count( * ) as conteo from permisos where id_accesos = {$id_acceso} and id_rol = {$tipo}";
	$id_acceso = 2;
	$sql = "select count( * ) as conteo from permisos where id_accesos = {$id_acceso} and id_rol = (select id_rol from laboratorios where id = {$laboratorio->id})";
	$resultado = mysql_query($sql);
	$db = mysql_fetch_array($resultado);
	$acceso = $db['conteo'];	
	if($acceso == 0){
		redireccionar_a("logout.php");
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!-- Meta´s -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	
	<title>Inicio - Sección Laboratorios - iMedics.ws - Internet Medical Solutions</title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	
	<!-- Javascript -->
	<!-- html5.js for IE less than 9 -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
</head>
<body>
	
	<!-- Wrapper -->
	<div id="wrapper">
		
		<!-- Header -->
		<div id="header" class="clearfix">
			
			<!-- Banner -->
			<div id="banner">
				<img src="images/banner-principal.jpg" alt="Guatemedica.net" />
			</div>
			<!-- #/Banner -->
			
			<!-- Nav -->
			<div id="nav" class="clearfix">				
				<ul>
					<li><a class="selected" href="index.php">Inicio</a></li>
					<li><a href="visits.php">iVisita</a></li>
					<li><a href="profile.php">Perfil</a></li>
					<li><a href="contact.php">Contacto</a></li>
				</ul>
				<span>Bienvenido Laboratorio <?php echo $laboratorio->nombre; ?> - <a href="logout.php">Cerrar Sesión</a></span>
			</div>
			<!-- #/Nav -->
			
		</div>
		<!-- #/Header -->
		
		<!-- Content -->
		<div id="content" class="clearfix">
			
			<!-- Center -->
			<div id="center-login" class="clearfix">				
				
				<!-- Nosotros -->
				<div id="nosotros">
					
					<div id="docs">
						<img src="images/img-inicio.jpg" />
					</div>
					<p>
					<hgroup>
						<h3>¿Quienes Somos?</h3>
					</hgroup>
					i Medics, es un grupo formado por personas con amplia experiencia en el desarrollo de aplicaciones web y visita médica. Hemos desarrollado cientos de aplicaciones web a médicos y proveedores de productos y servicios relacionados con el cuidado de la salud.
					</p>
					<p>
					<a href="http://www.medicossixtino.com" target="_blank">www.medicossixtino.com</a>, <a href="http://www.guatemedica.net" target="_blank">www.guatemedica.net</a>, <a href="http://www.alumbraguatemala.com" target="_blank">www.alumbraguatemala.com</a>, etcétera.
					</p>
					<p>
					Nuestro proyecto estrella es la visita médica en línea (i Visita), esta facilita el acceso del médico a la información de diferentes medicamentos disponibles en Guatemala. Esta herramienta es de uso exclusivo del médico.
					</p>
					<p>
					Invitamos desde ya a todos los Laboratorios Farmaceúticos de Guatemala a percibir los importantes beneficios de incluir la información de sus medicamentos en esta poderosa herramienta web afiliandose desde ya a i Medics.
					</p>
					<p>
					Para más información, sirvase escribirnos a <a href="mailto:info@imedics.ws">info@imedics.ws</a>
					</p>
					
				</div>
				<!-- #/Nosotros -->
				
				<!-- Options Nav -->
				<div id="options">
					
					<div>
						<a href="visits.php"><img src="images/ivisita.jpg" alt="iVisitas" /></a>
					</div><!--
					<br />
					<div>
						<a href="prescriptions.php"><img src="images/ireceta.jpg" alt="iRecetas" /></a>
					</div>-->
					
				</div>
				<!-- #/Options Nav -->
				
			</div>
			<!-- #/Center -->
			
		</div>
		<!-- #/Content -->
		
		<!-- Footer -->
		<div id="footer">
			Todos los derechos reservados 2012
		</div>
		<!-- #/Footer -->
		
	</div>
	<!-- #/Wrapper -->

</body>
</html>