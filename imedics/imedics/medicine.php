<?php require_once('../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a("login.php");} ?>
<?php if(isset($sesion->usuario_id)){ $medico = medic::buscar_por_id($sesion->usuario_id); } ?>
<?php
	ini_set('SMTP','mail.guatemedica.net');
	//ini_set('sendmail_from', 'webmaster@imedics.ws');
	
	if(isset($_POST['submit'])){
		
		$medicamento_id = $_POST['medicamento_id'];
		$nombre_medicamento = $_POST['nombre_medicamento'];
		$comentario = $_POST['comentario'];
		$laboratorio_id = $_POST['laboratorio_id'];
		$especialidad = $_POST['especialidad'];
		
		global $bd;
		$comment = new comment();
		$comment->especialidad_id = $especialidad;
		$comment->medicamento_id = $medicamento_id;
		$comment->nombre_medicamento = $nombre_medicamento;
		$comment->doctor_id = $medico->id;
		$comment->nombre_doctor = $medico->nombre;
		$comment->comentario = $bd->preparar_consulta(strip_tags($comentario));
		$comment->fagregado = date("Y-m-d H%m%s");
		$comment->laboratorio_id = $laboratorio_id;
		
		if($comment->guardar()){
			
		$asunto = "Comentario via iMedics.ws";
$cuerpo = "
Fecha: ".date("d-m-Y")."
El Dr. " .strtoupper($medico->nombre). " ha realizado el siguiente comentario:
Producto: " . $nombre_medicamento . "
Comentario: " . $comentario . "
				
Para contactarse con dicho doctor puede hacierlo vía correo electrónico a: ". $medico->usuario ." ó al teléfono ".$medico->telefono." ó realizandole una visita a la siguiente dirección: ". $medico->direccion ."
			
Gracias.";
			
			mail("direcciongeneral@imedics.ws,comentarios@imedics.ws",$asunto,$cuerpo);
			
			$message = "Tu comentario se agrego correctamente, pronto recibiras una respuesta del laboratorio.";
		}
		else{
			$message = "Ocurrio un error al agregar tu comentario, intentalo de nuevo mas tarde.";
		}
		redireccionar_a("medicine.php?medicament=".$medicamento_id."&message={$message}");
		
	}
	
	$medicamento = medicament::buscar_por_id($_GET['medicament']);
	
	if(isset($_GET['save']) && $_GET['save'] == 1){		
		$visita = new visit();
		$visita->medico_id = $medico->id;
		$visita->producto_id = $medicamento->id;
		$visita->laboratorio_id = $medicamento->laboratorio_id;
		$visita->bonificacion = $medicamento->bonificacion_visita;
		$visita->fecha = date('Y-m-d');
		
		if($visita->guardar()){
			true;
		}else{
			false;
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
	
	<title><?php echo htmlentities($medicamento->nombre); ?> - iMedics.ws - Internet Medical Solutions</title>
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
					<li><a class="selected" href="medicines.php">iVisita</a></li>
					<li><a href="prescription-on-line.php">iReceta</a></li>
					<li><a href="bonus.php">iPuntos</a></li>
					<li><a href="profile.php">Mi Perfil</a></li>
					<li><a href="contact.php">Contacto</a></li>
				</ul>
				<span><?php if($medico->sexo == 'mas'){ echo "Bienvenido Dr. ";}else{ echo "Bienvenida Dra. "; } ?><?php echo $medico->nombre; ?> - <a href="logout.php">Cerrar Sesión</a></span>
			</div>
			<!-- #/Nav -->
			
		</div>
		<!-- #/Header -->
		
		<!-- Content -->
		<div id="content" class="clearfix">
			
			<!-- Flash Left -->
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
				
				<!-- Informacion del medicamento
				<div id="list">
					<p><span>Nombre Genérico:</span> Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
					<p><span>Pricipio Activo:</span> <?php //echo htmlentities($medicamento->nombre); ?></p>
					<p><span>Indicaciones:</span> Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
					<p><span>Efectos Adversos:</span> Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
					<p><span>Dosificaciones:</span> Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
				</div>-->
				<img src="<?php echo $medicamento->ruta_archivo(); ?>" alt="<?php echo $medicamento->nombre; ?>" />
				
				<!-- #/Informacion del medicamento -->
				
				<?php if(!isset($_GET['comment'])){ ?>
				<!-- Opciones -->
				<div id="opciones">
					<a class="pdf" href="http://<?php echo urlencode($medicamento->pagina); ?>" target="black">Ver más...</a> <!--<a class="prescribe" href="prescription-on-line.php?medicine=<?php //echo urlencode($medicamento->id); ?>">Recetar</a>--> - <a class="comment" href="medicine.php?medicament=<?php echo urlencode($medicamento->id); ?>&comment=1#text">Comentar</a> - <a class="back" href="JavaScript:void(0);" onclick="window.history.back(-1);">Regresar</a>
				</div>
				<!-- #/Opciones -->
				<?php } ?>
								
				<?php if(isset($_GET['comment']) && $_GET['comment'] == 1){ ?>
				<!-- Area Comentario -->
				<div id="comment">
					<a id="text"></a>
					<form action="medicine.php" method="post">
					<input type="hidden" name="medicamento_id" value="<?php echo $medicamento->id; ?>" />
					<input type="hidden" name="nombre_medicamento" value="<?php echo $medicamento->nombre; ?>" />
					<input type="hidden" name="laboratorio_id" value="<?php echo $medicamento->laboratorio_id; ?>" />
					<input type="hidden" name="especialidad" value="<?php echo $medicamento->especialidad_id; ?>" />				
						
						<div>
							<label for="comentario"><b>Agregar Comentario:</b></label>
							<textarea name="comentario" cols="30" rows="10" required></textarea><br />
							<input type="submit" name="submit" value="Agregar comentario" /> - <a href="medicine.php?medicament=<?php echo urlencode($medicamento->id); ?>">Cancelar</a>
						</div>
						
					</form>
				</div>
				<!-- #/Area Comentario -->
				<?php } ?>
				
			</div>
			<!-- #/Center -->
			
			<!-- Flash Right -->
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