<?php require_once('../includes/initialize.php'); ?>
<?php
	if($sesion->esta_logueado())
	{
		redireccionar_a("index.php");
	}
	
	//ini_set('SMTP','mail.guatemedica.net');
	ini_set('sendmail_from', 'webmaster@imedics.ws');
	if(isset($_POST['submit']))
	{
	
		if($_SESSION['captcha'] == md5($_POST['captcha'])){
			
			global $bd;
			
			$correo = $bd->preparar_consulta($_POST['correo']);
			
			if(empty($correo))
			{
				$message = "Es necesario que ingreses tu dirección de correo. ";
			}
			else
			{				
				$sql = "SELECT * FROM laboratorios WHERE correo='{$correo}'";
				
				$resultado = mysql_query($sql);
				if(mysql_affected_rows()==1)
				{
					$usuario = mysql_fetch_array($resultado);
										
					$password = sha1('000000');
					
					$sql = "UPDATE laboratorios SET clave='{$password}' WHERE id=". $usuario['id'];
					mysql_query($sql);
					
					if(mysql_affected_rows()== 1)
					{
						$email = $usuario['correo'];
						
						$asunto = "Restauración de contraseña";
						$cuerpo = "Su clave fue restaurada con éxito, sus datos son los siguientes:
						Usuario: " . $usuario['correo'] . "
						Nueva contraseña: 000000 (6 Ceros) 
						No olvide ingresar al sistema y cambiarla lo antes posible.
						
						Si tienes algun problema con el manejo del sistema escribanos a info@imedics.ws
						Para poder iniciar tu sesión haz click en este enlace ó copialo y pegalo en tu navegador: http://www.imedics.ws/laboratorios/
						
						ATT: Equipo iMedics.ws
						Tel: 2361-1152";
						
						if(mail($email,$asunto,$cuerpo))
						{
							$message = "A su correo fueron enviados sus nuevos datos de acceso.";
						}
					}
					else
					{
						$message = "No fue posible restaurar sus datos. ";
					}
					
				}
				else
				{
					$message = "La dirección de correo no es válida. ";
				}
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
	
	<title>Recuperar Clave - Sección Laboratorios - iMedics.ws - Internet Medical Solutions</title>
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
					iMedics, analiza sistemas, descubre necesidades y desarrolla soluciones en el internet que facilitan considerablemente la labor Fármaco-informativa diaria de un médico, es decir, le facilitamos el acceso  a la información de diferentes medicamentos en el momento preciso que él lo necesita.
					</p>
					<p>
					Por este medio el médico podrá encontrar y comparar diferentes opciones disponibles en el mercado y escoger la que el considere más adecuada para su paciente, sin necesidad de depender exclusivamente de labor promocional que se realiza a través de la visita médica respectiva.
					</p>
					<p>
					Si usted es un médico en Guatemala, desde ya le sugerimos afiliarse lo antes posible a nuestro portal y disfrutar de los importantes beneficios de tener una asistente virtual de medicamentos en su computador o dispositivo personal.  Lo asistimos  desde la consulta de productos hasta la impresión final respectiva de sus recetas. 
					</p>
					<p>
					A los laboratorios farmacéuticos desde ya les hacemos la cordial invitación de contactarnos para conocer los importantes beneficios que solamente pueden obtener al publicar sus productos en el canal directo con su médico, i Medics.
					</p>
					<p>
					Para consultas puede escribirnos a <a href="mailto:info@imedics.ws">info@imedics.ws</a>
					</p>
					
				</div>
				<!-- #/Nosotros -->
				
				<!-- Login -->
				<div id="login">
					<!--
					<hgroup>
						<h1><a href="register-medic.php"><img src="images/warning.png" /> Si aun no se a registrado haga click aquí</a></h1>
					</hgroup>
					-->
					
					<?php if(isset($message) || isset($_GET["message"])) { ?>
					<div id="error">
						<?php
							if(isset($_GET["message"]))	{ echo $_GET["message"]; }
							if(isset($message))	{ echo $message; }
						?>
					</div>
					<?php } ?>
					
					<form action="return-password.php" method="post">
						<h4>
						Sus datos de acceso seran reestablecidos y enviados a su correo electrónico.
						</h4>
						<fieldset>
							<div>
								<label for="correo"><b>Correo Electrónico:</b></label>
								<input type="text" name="correo" placeholder="mail@example.com" required="Este campo es necesario." value="<?php echo isset($correo) ? $correo : "";  ?>" />
							</div>
							<div>
								<label for="captcha"><b>Captcha:</b></label>
								<input type="text" name="captcha" required placeholder="Ingresa los caracteres que ves en el cuadro de abajo" />
								<img src="captcha.php" />
							</div>
							<div>
								<input type="submit" name="submit" id="submitlog" value="Recuperar Clave" /> - <a href="login.php">Cancelar</a><br />
							</div>
						</fieldset>					
					</form>
					
				</div>
				<!-- #/Login -->
				
				<div id="navegador">
					<span>Guatemedica.net</span> recomienda la navegación en este sitio con Google Chrome. <a href="https://www.google.com/intl/es/chrome/browser/?hl=es" target="blank">Descargalo Aquí</a>
				</div>
				
			</div>
			<!-- #/Center Login -->
			
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