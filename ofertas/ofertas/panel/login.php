﻿<?php require_once '../../includes/initialize.php'; ?>
<?php
	if($sesion->esta_logueado())
	{
		redireccionar_a("index.php");
	}
	elseif(isset($_POST['submit']))
	{
		$usuario = $_POST['usuario'];
		$clave = $_POST['clave'];
		$usuario = user::autenticar($usuario,$clave);
		if($usuario)
		{
			$sesion->loguearse($usuario);
			grabar_acciones("Logueado","El usuario ".$usuario->usuario." se ha logueado.");
			redireccionar_a("index.php");
		}
		else
		{
			$mensaje = "Usuario/Clave incorrectos. ";
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
	
	<title>Login - Administración Ofertas Chapinas</title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
	
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
			
		</header>
		<!-- #/Header -->
		
		
		<!-- Content -->
		<section id="content" class="clearfix">
		<div id="form">
			<?php if(isset($mensaje)){ ?>
				<p><?php echo $mensaje; ?></p>
			<?php } ?>
			<form action="login.php" method="post" id="login">
				<div>
					<label for="user">Usuario:</label>
					<input type="text" name="usuario" required />
				</div>
				<div>
					<label for="password">Clave:</label>
					<input type="password" name="clave" required /><br />
					<input type="submit" name="submit" id="submit" value="Ingresar" />
				</div>
			</form>
		</div>
			
		</section>
		<!-- #/Content -->
		
		<footer id="footer">
			Todos los derechos reservados 2012 Ofertas Chapinas - Diseñado y Programado por: Luis Barrera
		</footer>
		
	</section>
	<!-- #/Wrapper -->

</body>
</html>