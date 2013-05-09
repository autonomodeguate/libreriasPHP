<?php require_once('../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a("login.php");} ?>
<?php if(isset($sesion->usuario_id)){ $medico = medic::buscar_por_id($sesion->usuario_id); } ?>
<?php
	//$sql = "select count( * ) as conteo from permisos where id_accesos = {$id_acceso} and id_rol = (select id_rol from medicos where id = {$medico->id})";
	$id_acceso = 1;
	$sql = "select count( * ) as conteo from permisos where id_accesos = {$id_acceso} and id_rol = (select id_rol from medicos where id = {$medico->id})";
	$resultado = mysql_query($sql);
	$db = mysql_fetch_array($resultado);
	$acceso = $db['conteo'];	
	if($acceso == 0){
		redireccionar_a("logout.php");
	}
?>
<?php
	
	if(isset($_POST['submit'])){
		
		$nombre = $_POST['nombre'];
		$telefono = $_POST['telefono'];
		$direccion = $_POST['direccion'];
		
		$edicion = medic::buscar_por_id($medico->id);
		
		if(empty($nombre) || empty($telefono) || empty($direccion)){
			$message = "Todos los campos son obligatorios.";
		}else{
			
			global $bd;
			
			$edit = medic::buscar_por_id($medico->id);
			
			$edit->nombre = $bd->preparar_consulta(strip_tags($nombre));
			$edit->telefono = $bd->preparar_consulta(strip_tags($telefono));
			$edit->direccion = $bd->preparar_consulta(strip_tags($direccion));			
			if($edit->guardar()){
				$message = "Tus datos se actualizaron con éxito.";
			}else{
				$message = "Ocurrio un error al actualizar sus datos, intentelo mas tarde.";
			}
			redireccionar_a("profile.php?message={$message}");			
		}		
	}
	
	if(isset($_POST['submit_pass'])){
		
		$clave = $_POST['clave'];
		$confirm = $_POST['confirm'];
		
		if($clave != $confirm){
			$message = "Las contraseñas no coinciden.";
		}elseif($clave >= 41){
			$message = "La contraseña no debe contener mas de 40 caracteres.";
		}else{
			
			$pass = medic::buscar_por_id($medico->id);
			$pass->clave = $bd->preparar_consulta(strip_tags(sha1($clave)));
			if($pass->guardar()){
				$message = "Su clave se edito con éxito.";
			}else{
				$message = "Ocurrio un error al editar su clave intentelo mas tarde.";
			}
			redireccionar_a("profile.php?message={$message}");
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
	
	<title>Perfil <?php echo $medico->nombre; ?> - iMedics.ws - Internet Medical Solutions</title>
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
					<li><a class="selected" href="profile.php">Mi Perfil</a></li>
					<li><a href="contact.php">Contacto</a></li>
				</ul>
				<span><?php if($medico->sexo == 'mas'){ echo "Bienvenido Dr. ";}else{ echo "Bienvenida Dra. "; } ?><?php echo $medico->nombre; ?> - <a href="logout.php">Cerrar Sesión</a></span>
			</div>
			<!-- #/Nav -->
			
		</div>
		<!-- #/Header -->
		
		<!-- Content -->
		<div id="content" class="clearfix">
			
			<!-- Flash Left --
			<div id="flash-left">
				<table>
					<tr>
						<td><embed width="200" height="150" src="flashes/derecho3.swf" type="application/x-shockwave-flash" /></td>
					</tr>
					<tr>
						<td><embed width="200" height="150" src="flashes/derecho1.swf" type="application/x-shockwave-flash" /></td>
					</tr>
					<tr>
						<td><embed width="200" height="150" src="flashes/derecho2.swf" type="application/x-shockwave-flash" /></td>
					</tr>
				</table>
			</div>
			<!-- #/Flash Left -->
			
			<!-- Center -->
			<div id="center">
			
				<hgroup>
					<h1>Perfil - <?php if($medico->sexo == 'mas'){ echo "Dr. ";}else{ echo "Dra. "; } ?><?php echo $medico->nombre; ?></h1>
				</hgroup>
				<hr />
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
					
					<form action="profile.php" method="post">
						
						<fieldset>
							
							<div>
								<label for="nombre">Nombre:</label>
								<input type="text" name="nombre" required value="<?php echo htmlentities($medico->nombre); ?>" />
							</div>
							<div>
								<label for="especialidad">Especialidad:</label>
								<?php $especialidad = speciality::buscar_por_id($medico->especialidad_id); ?>
								<input type="text" name="especialidad" readonly="readonly" value="<?php echo htmlentities($especialidad->nombre);  ?>" />
							</div>
							<div>
								<label for="telefono">Teléfono:</label>
								<input type="text" name="telefono" required value="<?php echo $medico->telefono; ?>" />
							</div>
							<div>
								<label for="direccion">Dirección:</label>
								<input type="text" name="direccion" required value="<?php echo $medico->direccion; ?>" />
							</div>
							<div>
								<label for="colegiado">Colegiado Activo:</label>
								<input type="text" name="colegiado" readonly="readonly" value="<?php echo $medico->colegiado; ?>" />
							</div>
							<div>
								<label for="registro">Fecha de Registro:</label>
								<input type="text" name="registro" readonly="readonly" value="<?php echo $medico->fagregado; ?>" />
							</div>
							<div>
								<label for="usuario">Usuario:</label>
								<input type="text" name="usuario" readonly="readonly" value="<?php echo $medico->usuario; ?>" />
							</div>
							<p><a href="profile.php?pass=1#CLAVE">Deseo editar mi contraseña</a></p>
							<div>
								<input type="submit" name="submit" value="Guardar Datos" /> - <a href="index.php">Regresar</a>
							</div>
							
						</fieldset>
						
					</form>
					
					<?php if(isset($_GET['pass']) && $_GET['pass'] == 1){?>
					<a name="CLAVE"></a>
					<form action="profile.php" method="post">
						<fieldset>
							<div>
								<label for="clave">Nueva Contraseña:</label>
								<input type="password" required name="clave" />
							</div>
							<div>
								<label for="confirm">Confirmar Contraseña:</label>
								<input type="password" required name="confirm" />
							</div>
							<div>
								<input type="submit" name="submit_pass" value="Guardar Contraseña" /> - <a href="profile.php">Cancelar</a>
							</div>
						</fieldset>					
					</form>
					<?php } ?>
					
				</div>
				<!-- #/Form Receta -->
				
			</div>
			<!-- #/Center -->
			
			<!-- Flash Right --
			<div id="flash-right">
				<table>
					<tr>
						<td><a href="medicine.php?medicament=3&save=1"><img src="images/colica.jpg" /></a></td>
					</tr>
					<tr>
						<td><a href="medicine.php?medicament=4&save=1"><img src="images/pronol.jpg" /></a></td>
					</tr>
					<tr>
						<td><a href="medicine.php?medicament=5&save=1"><img src="images/psyllium2.jpg" /></a></td>
					</tr>
				</table>
			</div>
			<!-- #/Flash Right -->
			
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