<?php require_once('../includes/initialize.php'); ?>
<?php
	//ini_set("SMTP","mail.imedics.ws");
	ini_set('sendmail_from', 'webmaster@imedics.ws'); 
	
	$especialidades = speciality::obtener_especialidades_activas();
	
	if(isset($_POST['submit'])){
		
		$nombre = $_POST['nombre'];
		$correo = $_POST['correo'];
		$especialida = $_POST['especialidad'];
		$telefono = $_POST['telefono'];
		$direccion = $_POST['direccion'];
		$colegiado = $_POST['colegiado'];
		$sexo = $_POST['sexo'];
		
		$errores = array();
		
		if($_SESSION['captcha'] == md5($_POST['captcha'])){
		
			if(empty($correo)){
				$errores[] = "Es necesario que ingrese una dirección de correo válida, ya que a esta seran enviadas sus claves de acceso.";
			}
			
			if(empty($nombre))
			{
				$errores[] = "El nombre es obligatorio. ";
			}
			
			if(empty($direccion))
			{
				$errores[] = "Ingrese una dirección válida. ";
			}
			
			if(empty($telefono))
			{
				$errores[] = "El teléfono es necesario. ";
			}
			
			//verifica sino hay un usuario ya existente.
			$sql = "SELECT correo FROM medicos WHERE correo='{$correo}'";
			$resultado = mysql_query($sql);
			if(mysql_num_rows($resultado) !=0){
				$errores[] = "El correo electrónico ya fue registrado anteriormente.";
			}
			
			if(empty($errores)){
				global $bd;
				$medico = new medic();
				$medico->id_rol = 1;
				$medico->nombre = $bd->preparar_consulta(htmlentities($nombre));
				$medico->correo = $bd->preparar_consulta($correo);
				$medico->especialidad_id = $bd->preparar_consulta($especialida);
				$medico->telefono = $bd->preparar_consulta($telefono);
				$medico->direccion = $bd->preparar_consulta(strip_tags($direccion));
				$medico->colegiado = $bd->preparar_consulta(strip_tags($colegiado));
				$medico->sexo = $bd->preparar_consulta($sexo);
				$medico->usuario = $bd->preparar_consulta($correo);
				$medico->clave = sha1('000000');
				$medico->estado = 'activo';
				$medico->fagregado = date('Y-m-d');
				
				if($medico->guardar()){
					$asunto = "Su registro en iMedics.ws ha sido exitoso.";
					$cuerpo = "Felicidades su registro fue exitoso en nuestro sistema iMedics.ws, estos son tus datos:
Usuario: " . $medico->correo . "
Contraseña inicial: 000000 (6 Ceros) 
No olvide ingresar al sistema y cambiarla lo antes posible.
					
Esperamos que disfrute de nuestro programa, si tiene algún problema con el manejo del sistema escríbanos a info@imedics.ws
Para poder iniciar su sesión haga clic en este enlace o cópielo y pégalo en su navegador: http://www.imedics.ws/
						
					ATT: Equipo iMedics.ws";
					mail("info@imedics.ws,{$medico->correo}",$asunto,$cuerpo);
					$message = 'Su registro fue exitoso, a su correo electrónico fueron enviádos sus datos de acceso, <a href="login.php">pulse aqui para iniciar sesión</a>';
				}
				else{
					$message = 'Ocurrio un problema con el registro, intentelo mas tarde.';
				}
			}else{
				$message = "Los siguientes errores han ocurrido:";
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
	
	<title>Rigistro de Médicos - iMedics.ws - Internet Medical Solutions</title>
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
					<li><a href="specialists.php">iVisita</a></li>
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
				
				<hgroup>
					<h1>Registro de Médicos</h1>
					<p>Llene cuidadosamente cada uno de los campos que se te piden a continuación.<br />*Todos los campos son obligatorios.</p>
				</hgroup>
				
				<?php if(isset($message) || isset($_GET["message"])) { ?>
				<div id="error">
					<?php
						if(isset($_GET["message"]))	{ echo $_GET["message"]; }						
						if(isset($message))
						{
							echo $message;
							if(isset($errores))
							{
								foreach($errores as $error)
								{
									echo "<br /> - " . $error;
								}
							}
						}
					?>
				</div>
				<?php } ?>
				
				<!-- Register -->
				<div id="register">
					
					<form action="register-medic.php" method="post">
						<fieldset>
							<div>
								<label for="nombre">*Nombre:</label>
								<input type="text" name="nombre" required value="<?php echo isset($nombre) ? $nombre : ""; ?>" />
							</div>
							<div>
								<label for="correo">*Correo:</label>
								<input type="text" name="correo" required value="<?php echo isset($correo) ? $correo : ""; ?>" />
							</div>
							<div>
								<label for="especialidad">*Especialidad:</label>
								<select name="especialidad">
									<option value="">Selecciona tu especialidad...</option>
								<?php foreach($especialidades as $especialidad){ ?>
									<option value="<?php echo $especialidad->id; ?>" <?php if(isset($especialida) && $especialida == $especialidad->id){ echo " selected=' selected'";} ?>><?php echo htmlentities($especialidad->nombre); ?></option>
								<?php } ?>
								</select>
							</div>
							<div>
								<label for="colegiado">*Colegiado:</label>
								<input type="text" name="colegiado" required value="<?php echo isset($colegiado) ? $colegiado : ""; ?>" />
							</div>
							<div>
								<label for="telefono">*Telefono:</label>
								<input type="text" name="telefono" required value="<?php echo isset($telefono) ? $telefono : ""; ?>" />
							</div>
							<div>
								<label for="direccion">*Dirección:</label>
								<input type="text" name="direccion" required value="<?php echo isset($direccion) ? $direccion : ""; ?>" />
							</div>
							<div>
								<label for="sexo">Genero:</label>
								<select name="sexo">
									<option value="mas" <?php if(isset($sexo) && $sexo = 'mas'){ echo "selected=' selected'";} ?>>Hombre</option>
									<option value="fem" <?php if(isset($sexo) && $sexo = 'fem'){ echo "selected=' selected'";} ?>>Mujer</option>
								</select>
							</div>
							<div>
								<label for="captcha">Captcha:</label>
								<input type="text" name="captcha" required placeholder="Ingresa los caracteres que ves en el cuadro de abajo" />
								<img src="captcha.php" />
							</div>
							<div>
								<input type="submit" name="submit" id="submitlog" value="Registrarme" /><br />
								<a href="index.php">Cancelar</a>
							</div>
						</fieldset>					
					</form>
					
				</div>
				<!-- #/Register -->
				
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