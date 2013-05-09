<?php require_once('../includes/initialize.php'); ?>
<?php
	if($sesion->esta_logueado())
	{
		redireccionar_a("index.php");
	}
	elseif(isset($_POST['submit']))
	{
		$usuario = $_POST['usuario'];
		
		if($_SESSION['captcha'] == md5($_POST['captcha'])){
			$clave = $_POST['clave'];
			$usuario = medic::autenticar($usuario,$clave);
			if($usuario){
				$sesion->loguearse($usuario);
				grabar_acciones("Logueado","El Dr(a). ".$usuario->nombre." se ha logueado.");
				redireccionar_a("prescription-on-line.php");
			}
			else
			{
				$message = "Usuario o Clave incorrectos. ";
			}
		}else{
			$message = "Los caracteres del captcha no coinciden.";
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
	
	<title>Login - iMedics.ws - Internet Medical Solutions</title>
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
					<li><a href="prescription-on-line.php">iReceta</a></li>
					<li><a href="bonus.php">iPuntos</a></li>
					<li><a href="profile.php">Mi Perfil</a></li>
				</ul>
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
				
				<!-- Login -->
				<div id="login">
				
					<hgroup>
						<h1><a href="register-medic.php"><img src="images/warning.png" /> Si aun no se a registrado haga click aquí</a></h1>
					</hgroup>
					
					<?php if(isset($message) || isset($_GET["message"])) { ?>
					<div id="error">
						<?php
							if(isset($_GET["message"]))	{ echo $_GET["message"]; }
							if(isset($message))	{ echo $message; }
						?>
					</div>
					<?php } ?>
					
					<form action="login.php" method="post">
						<fieldset>
							<div>
								<label for="usuario"><b>Nombre de Usuario:</b></label>
								<input type="text" name="usuario" placeholder="mail@example.com" required="Este campo es necesario." value="<?php echo isset($usuario) ? $usuario : "";  ?>" />
							</div>
							<div>
								<label for="clave"><b>Clave:</b></label>
								<input type="password" name="clave" required />
							</div>
							<div>
								<label for="captcha"><b>Captcha:</b></label>
								<input type="text" name="captcha" required placeholder="Ingresa los caracteres que ves en el cuadro de abajo" />
								<img src="captcha.php" />
							</div>
							<div>
								<input type="submit" name="submit" id="submitlog" value="Ingresar" /><br />
								<a href="#">Olvide mi contraseña</a>
							</div>
						</fieldset>					
					</form>
					
				</div>
				<!-- #/Login -->
				
				<div id="navegador">
					<span>Guatemedica.net</span> recomienda la navegación en este sitio con Google Chrome. <a href="https://www.google.com/intl/es/chrome/browser/?hl=es" target="blank">Descargalo Aquí</a>
				</div>
				
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