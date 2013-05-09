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
<?php
	//ini_set('SMTP','mail.guatemedica.net');
	ini_set('sendmail_from', 'webmaster@imedics.ws'); 
	if(isset($_POST['submit'])){
		
		$nombre = $_POST['nombre'];
		$direccion = $_POST['direccion'];
		$telefono = $_POST['telefono'];
		$correo = $_POST['correo'];
		$mensaje = $_POST['comentario'];
		$errores = array();
		
		if(empty($nombre)){
			$errores[] = "Debe ingresar su nombre.";
		}
		
		if(empty($telefono)){
			$errores[] = "Ingrese su n&uacute;mero tel&eacute;fonico.";
		}
		
		if(empty($correo)){
			$errores[] = "Ingrese su correo electr&oacute;nico.";
		}
		
		if(empty($mensaje)){
			$errores[] = "Ingrese un texto para el mensaje. ";
		}
		
		if(empty($errores)){
$asunto = "Solicitud de informacion iMedics.ws";
$cuerpo = "
El Dr(a). ".strtoupper($nombre). " Solicita informacion, estos son sus datos:
Direccion: " . $direccion . "
Telefono: " . $telefono . "
Correo: " . $correo . "
Comentario: " . $mensaje . "
				
Contactarse con el lo antes posible.
			
Gracias.";
			
			$peticion = mail("info@imedics.ws",$asunto,$cuerpo);
			
			if($peticion){
				$message = "Su mensaje se envio con &eacute;xito, en breve nos pondremos en contacto con usted.";
			}
			else{
				$message = "En este momento no fue posible enviar su mensaje, por favor intentelo mas tarde. ";
			}
			
		}
		else{
			$message = "Los siguientes errores han ocurrido: ";
		}
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
	
	<title>Contacto - Sección Laboratorios - iMedics.ws - Internet Medical Solutions</title>
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
					<li><a href="index.php">Inicio</a></li>
					<li><a href="visits.php">iVisita</a></li>
					<li><a href="profile.php">Perfil</a></li>
					<li><a class="selected" href="contact.php">Contacto</a></li>
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
					
					<!-- Errores -->
					<?php if(isset($message) || isset($_GET["message"])) { ?>
					<div id="error">
						<?php
							if(isset($_GET["message"]))	{ echo $_GET["message"]; }
							if(isset($message))	{ echo $message; }
						?>
					</div>
					<?php } ?>
					<!-- #/Errores -->
					
					<!-- Form Receta -->
					<div id="receta">
						
						<form action="contact.php" method="post">
					
							<p>
							Si tiene alguna duda del funcionamiento de la aplicacion, o inquietudes puedes llenar el formulario de contacto y a la brevedad posible nos pondremos en contacto contigo.
							</p>					
							<fieldset>
							<div>
								<label for="nombre">Nombre: </label>
								<input type="text" name="nombre" required value="<?php echo isset($nombre) ? $nombre : ""; ?>" />
							</div>
							<div>
								<label for="direccion">Direccion: </label>
								<input type="text" name="direccion" value="<?php echo isset($direccion) ? $direccion : ""; ?>" />
							</div>
							<div>
								<label for="telefono">Tel&eacute;fono: </label>
								<input type="text" name="telefono" required value="<?php echo isset($telefono) ? $telefono : ""; ?>" />
							</div>
							<div>
								<label for="correo">Correo: </label>
								<input type="email" name="correo" required value="<?php echo isset($correo) ? $correo : ""; ?>" />
							</div>
							<div>
								<label for="comentario">Mensaje: </label>
								<textarea name="comentario" cols="43" rows="12" required><?php echo isset($mensaje) ? $mensaje : ""; ?></textarea>
								<br />
								<input type="submit" name="submit" id="submit" value="Enviar Consulta" />
							</div>
							</fieldset>
							
						</form>
						
					</div>
					<!-- #/Form Receta -->
					
				</div>
				<!-- #/Nosotros -->
				
				<!-- Options Nav -->
				<div id="options">
					
					<div>
						<a href="visits.php"><img src="images/ivisita.jpg" alt="iVisitas" /></a>
					</div>
					<!--
					<br />
					<div>
						<a href="prescriptions.php"><img src="images/ireceta.jpg" alt="iRecetas" /></a>
					</div> -->
					
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