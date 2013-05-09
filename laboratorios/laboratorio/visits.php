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
	$medicamentos = medicament::medicamentos_por_laboratorio($laboratorio->id);	
	$i = 0;
	
	if(isset($_POST['submit'])){
		
		$fecha_ini = $_POST['fecha_inicio'];
		$fecha_fin = $_POST['fecha_fin'];
		$producto = $_POST['producto'];
		
		$visitas = visit::visitas_por_producto($fecha_ini,$fecha_fin,$producto,$laboratorio->id);
		$medicament = medicament::buscar_por_id($producto);
		
	}
	
	if(isset($_POST['submit_general'])){
		
		$fecha_ini = $_POST['fecha_inicio'];
		$fecha_fin = $_POST['fecha_fin'];
		
		$visitas_generales = visit::visitas_por_laboratorio($fecha_ini,$fecha_fin,$laboratorio->id);		
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
	
	<title>iVisitas - Sección Laboratorios - iMedics.ws - Internet Medical Solutions</title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
	
	<!-- Javascript -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
 	<script type="text/javascript">
	jQuery(function($){
		$.datepicker.regional['es'] = {
			closeText: 'Cerrar',
			prevText: '&#x3c;Ant',
			nextText: 'Sig&#x3e;',
			currentText: 'Hoy',
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
			'Jul','Ago','Sep','Oct','Nov','Dic'],
			dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
			dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
			weekHeader: 'Sm',
			dateFormat: 'yy/mm/dd',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''};
		$.datepicker.setDefaults($.datepicker.regional['es']);
	});
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
					<li><a class="selected" href="visits.php">iVisita</a></li>
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
				
				<!-- Option Labs -->
				<div id="optionlabs">
					
					<hgroup>
					<h1>Listado de <span>i</span>Medicamentos</h1>
					</hgroup>
					<?php if(count($medicamentos) != 0){ ?>				
						<table border="1" width="100%">
							<tr>
								<td colspan="2" style="color:#000;font-size:12px;">*Seleccione las fechas para visualizar las visitas</td>
							</tr>
							<?php $o = 0; ?>
							<?php foreach($medicamentos as $medicamento){ $j = $i%2;?>
							<tr>
								<td width="50%" class="estilo<?php echo $j; ?> <?php if(isset($producto) && $producto == $medicamento->id){ echo " resaltado";} ?>"><?php echo htmlentities($medicamento->nombre); ?></td>
								<td width="50%" class="estilo<?php echo $j; ?>">
								
									<form id="visits" action="visits.php" method="post">
										<label for="Del">Del:
										<?php $o = $o+1; ?>
										<script>
										$(document).ready(function() {
										 $("#datepicker<?php echo $o; ?>").datepicker();
										});
										</script>
										<input type="text" name="fecha_inicio" readonly="readonly" id="datepicker<?php echo $o; ?>" required />
										</label>
										
										<label for="Al">Al:
										<?php $o = $o+1; ?>
										<script>
										$(document).ready(function() {
										 $("#datepicker<?php echo $o; ?>").datepicker();
										});
										</script>
										<input type="text" name="fecha_fin" readonly="readonly" id="datepicker<?php echo $o; ?>" required />
										</label>
										<input type="hidden" name="producto" value="<?php echo $medicamento->id; ?>"/>
										
										<input type="submit" name="submit" value="Ver" />
									</form>
									
								</td>
							</tr>
							<?php $i++; }?>
							<tr>
								<td style="color:#069;"><b>Ver un listado general</b></td>
								<td>
									<form id="visits" action="visits.php" method="post">
											<label for="Del">Del:
											<?php $o = $o+1; ?>
											<script>
											$(document).ready(function() {
											 $("#datepicker<?php echo $o; ?>").datepicker();
											});
											</script>
											<input type="text" name="fecha_inicio" readonly="readonly" id="datepicker<?php echo $o; ?>" required />
											</label>
											
											<label for="Al">Al:
											<?php $o = $o+1; ?>
											<script>
											$(document).ready(function() {
											 $("#datepicker<?php echo $o; ?>").datepicker();
											});
											</script>
											<input type="text" name="fecha_fin" readonly="readonly" id="datepicker<?php echo $o; ?>" required />
											</label>											
											<input type="submit" name="submit_general" value="Ver" />
									</form>
								</td>
							</tr>
						</table>
					<?php } ?>
					
				</div>
				<!-- #/Option Labs -->
				
				<!-- Options Nav -->
				<div id="options">
					
					<hgroup>
					<h1>Listado de <span>i</span>Visitas <?php echo isset($medicament) ? htmlentities($medicament->nombre) : ""; ?></h1>
					</hgroup>
					
					<table width="100%" border="1">
					<?php if(isset($visitas)){ ?>
							<tr>
								<td style="color:#000;">Nombre del m&eacute;dico que visito</td>
								<td style="color:#000;">Especialidad</td>
								<td style="color:#000;">Visita</td>
							</tr>
							<?php foreach($visitas as $visita){ ?>
								<?php $medico = medic::buscar_por_id($visita->medico_id); ?>
								<td><?php echo $medico->nombre; ?></td>
								<?php $especialidad = speciality::buscar_por_id($medico->especialidad_id); ?>
								<td style="color:#069;"><?php echo htmlentities($especialidad->nombre); ?></td>
								<td><?php $visita->fecha; $fecha = date("d-m-Y",strtotime($visita->fecha)); echo $fecha; ?></td>
							</tr>
							<?php } ?>
							<tr>
								<td style="color:#000;font-size:12px;" colspan="3">Este medicamento tiene un total de <?php echo count($visitas); ?> visitas<br />Del: <?php $fecha_ini; $fecha_ini2 = date("d-m-Y",strtotime($fecha_ini)); echo $fecha_ini2; ?> Al: <?php $fecha_fin; $fecha_fin2 = date("d-m-Y",strtotime($fecha_fin)); echo $fecha_fin2; ?></td>
							</tr>
						<?php } ?>
						
					<?php if(isset($visitas_generales)){ ?>
							<tr>
								<td style="color:#000;">Nombre del m&eacute;dico que visito</td>
								<td style="color:#000;">Especialidad</td>
								<td style="color:#000;">Visita</td>
							</tr>
							<?php foreach($visitas_generales as $visitag){ ?>
								<?php $medico = medic::buscar_por_id($visitag->medico_id); ?>
								<td><?php echo $medico->nombre; ?></td>
								<?php $especialidad = speciality::buscar_por_id($medico->especialidad_id); ?>
								<td style="color:#069;"><?php echo htmlentities($especialidad->nombre); ?></td>
								<td><?php $visitag->fecha; $fecha = date("d-m-Y",strtotime($visitag->fecha)); echo $fecha; ?></td>
							</tr>
							<?php } ?>
							<tr>
								<td style="color:#000;font-size:12px;" colspan="3">Existen un total de <?php echo count($visitas_generales); ?> visitas a los medicamentos<br />Del: <?php $fecha_ini; $fecha_ini2 = date("d-m-Y",strtotime($fecha_ini)); echo $fecha_ini2; ?> Al: <?php $fecha_fin; $fecha_fin2 = date("d-m-Y",strtotime($fecha_fin)); echo $fecha_fin2; ?></td>
							</tr>
						<?php } ?>
					</table>
					
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