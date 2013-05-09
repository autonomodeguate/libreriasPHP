<?php require_once('../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a("login.php");} ?>
<?php if(isset($sesion->usuario_id)){ $medico = medic::buscar_por_id($sesion->usuario_id); } ?>
<?php

	$sales = sales::buscar_todos();	
	
		ini_set('SMTP','mail.guatemedica.net');
		//ini_set('sendmail_from', 'webmaster@imedics.ws'); 
		
		$medicamentos = medicament::medicamentos_activos();
		
		if(isset($_GET['medicine'])){			
			$medicine = medicament::buscar_por_id($_GET['medicine']);			
		}
		
		if(isset($_POST['submit'])){
			
			$paciente = $_POST['paciente'];
			$correo = $_POST['correo'];
			$medicamento = $_POST['medicamento'];
			$medicamento_dos = $_POST['medicamento_dos'];
			$medicamento_tres = $_POST['medicamento_tres'];
			//$medicamento_cuatro = $_POST['medicamento_cuatro'];
			$laboratorio_id = $_POST['laboratorio_id'];
			$explicacion = $_POST['explicacion'];
			$bonificacion = $_POST['bonificacion'];
			
			if(!empty($correo)){
				$medicament = medicament::buscar_por_id($medicamento);
				$asunto = "Medicamento recetado a travez de iMedics.ws";
$cuerpo = "
Esta receta fue generada a travez del portal iMedics.ws con fecha: ".date("d-m-Y")."

Medicamento Recetado: " . $medicament->nombre . "
Dosis: " . $explicacion . "
				
Si tienes dudas del medicamento estos son los datos del medico

Nombre: ".$medico->nombre."
Colegiado: ".$medico->colegiado."
Correo: ".$medico->correo."
Direccion: ".$medico->direccion."
			
";
				if(mail("{$correo},info@imedics.ws",$asunto,$cuerpo)){
					true;
				}else{
					false;
				}
			}
			
			
			global $bd;
			$receta = new prescription();
			
			$receta->medico_id = $medico->id;
			$receta->medicamento_id = $medicamento;
			$receta->laboratorio_id = $laboratorio_id;
			$receta->paciente = $bd->preparar_consulta(strip_tags($paciente));
			$receta->dosis = $bd->preparar_consulta(strip_tags($explicacion));
			$receta->bonificacion = $bd->preparar_consulta($bonificacion);
			$receta->fecha = date("Y-m-d");
			
			if($receta->guardar()){
				$message = "La receta se registro correctamente.";
			}else{
				$message = "Ocurrio un error al registrar la receta. Intentalo nuevamente";
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
	
	<title>iReceta - iMedics.ws - Internet Medical Solutions</title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
	<!-- Styles -->
	<script language="JavaScript" type="text/javascript" src="js.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/style_print.css" media="print" />
	
	<!-- Javascript -->
	<script type="text/javascript">
	var tags_span = new Array();
	 
	function cambiarTexto(laclase,eltexto) {
	 var tags_span = document.getElementsByTagName('span');
	 for (i=0; i < tags_span.length; i++) {
	  if (tags_span[i].className == laclase) {
	   var texto = eltexto;
	   tags_span[i].innerHTML= texto;
	  }
	 }
	}
	function mostrar_ocultar(dcodigo) {
	 if ((document.getElementById(dcodigo).style.display) == 'block') {
	  document.getElementById(dcodigo).style.display = 'none';
	  cambiarTexto(dcodigo,'Click aqui - Agregar más medicamentos') ;// Texto para cuando la capa esté oculta
	 }else{
	  document.getElementById(dcodigo).style.display = 'block';
	  cambiarTexto(dcodigo,"Click aqui - Menos medicamentos"); // Texto para cuando la capa esté visible
	 }
	}
	</script>
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
					<li><a href="medicines.php">iVisita</a></li>
					<li><a class="selected" href="prescription-on-line.php">iReceta</a></li>
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
				
				<!-- Form Receta -->
				<div id="receta">
					
					<form method="post">
						
						<fieldset>
							<div id="direction">
								<?php echo $medico->direccion; ?>
							</div>
							<div>
								<table width="100%" style="text-align:right;">
									<tr>
										<td>Fecha: <?php echo date("d-m-Y"); ?></td>
									</tr>
								</table>
							</div>
							<div>
								<label for="">Medico:</label>
								<?php $especialidad = speciality::buscar_por_id($medico->especialidad_id); ?>
								<input type="text" name="medico" value="<?php echo htmlentities($medico->nombre); ?> - <?php echo htmlentities($especialidad->nombre); ?>" />
							</div>
							<div>
								<label for="paciente">Nombre Paciente:</label>
								<input type="text" name="paciente" required />
							</div>
							<div>
								<label for="paciente">Correo del Paciente:</label>
								<input type="text" name="correo" />
							</div>
							
							<!-- Combo 1 -->
							<div>
								<label for="medicamento">Principio Activo:</label>
								<select name="medicamento" id="combo_uno" onchange="combo_dependiente_uno()">
									<option value="0">Selecciona...</option>
									<?php foreach($sales as $sal){ ?>
									<option value="<?php echo $sal->id ?>"><?php echo htmlentities($sal->nombre); ?></option>
									<?php } ?>
								</select>
							</div>
							<div id="combo_uno_uno">
								<label for="seccion">Medicamento:</label>
								<select name="seccion">
										<option value=""></option>
								</select>
							</div>
							<div>
								<label for="explicacion">Medicación:</label>
								<textarea rows="3" name="explicacion" required></textarea>
							</div>
							
							<div id="contenedor">
							
								<span class="oculto" onclick="mostrar_ocultar('oculto');">Click aqui - Agregar más medicamentos</span>
									
								<div id="oculto" style="display:none;">
									
									<hr />
									<!-- Combo 2 -->
									<div>
										<label for="medicamento">Principio Activo:</label>
										<select name="medicamento" id="combo_dos" onchange="combo_dependiente_dos()">
											<option value="0">Selecciona...</option>
											<?php foreach($sales as $sal){ ?>
											<option value="<?php echo $sal->id ?>"><?php echo htmlentities($sal->nombre); ?></option>
											<?php } ?>
										</select>
									</div>
									<div id="combo_dos_dos">
										<label for="seccion">Medicamento:</label>
										<select name="seccion">
												<option value=""></option>
										</select>
									</div>
									<div>
										<label for="explicacion">Medicación:</label>
										<textarea rows="3" name="explicacion2" value=""></textarea>
									</div>
									<!-- #/Combo 2 -->
									
									<hr />
									<!-- Combo 3 -->
									<div>
										<label for="medicamento">Principio Activo:</label>
										<select name="medicamento" id="combo_tres" onchange="combo_dependiente_tres()">
											<option value="0">Selecciona...</option>
											<?php foreach($sales as $sal){ ?>
											<option value="<?php echo $sal->id ?>"><?php echo htmlentities($sal->nombre); ?></option>
											<?php } ?>
										</select>
									</div>
									<div id="combo_tres_tres">
										<label for="seccion">Medicamento:</label>
										<select name="seccion">
												<option value=""></option>
										</select>
									</div>
									<div>
										<label for="explicacion">Medicación:</label>
										<textarea rows="3" name="explicacion3" value=""></textarea>
									</div>
									<!-- #/Combo 3 -->
								</div>
							
							</div>
							
							<div id="bottoms">
								<input type="submit" name="submit" value="Imprimir Receta" class="css3button" onclick="window.print();" /><br /><a href="medicines.php">Cancelar</a>
							</div>
							<div id="firmas">
								<table width="100%">
									<tr>
										<td width="10%">Firma: </td>
										<td width="40%">________________________</td>
										<td width="10%">Sello: </td>
										<td width="40%">________________________</td>
									</tr>
								</table>
							</div>
							
						</fieldset>
						
					</form>
					
				</div>
				<!-- #/Form Receta -->
				
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