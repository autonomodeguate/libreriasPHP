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
	$i = 0;
	$bonificaciones = prescription::recetas_por_medico($medico->id);
	$visitas = visit::visitas_por_medico($medico->id);
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
	
	<title>iPuntos - iMedics.ws - Internet Medical Solutions</title>
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
					<li><a class="selected" href="bonus.php">iPuntos</a></li>
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
			<div id="center-bonus">
				
				<!-- Recetas -->
				<hgroup>
					<h2>Estado general de iPuntos por Receta</h2>
				</hgroup>
				<!--
				<table id="bonus" width="100%">
				<tr>
					<td colspan="3" style="font-weight:bold;color:#fb650a;padding:5px;text-align:left;">iPuntos por iVisita</td>
				</tr>
				<tr>
					<td><b>Fecha</b></td>
					<td><b>Medicamento</b></td>
					<td><b>Cantidad</b></td>
				</tr>
				<?php //foreach($visitas as $visita){ $j = $i%2; ?>
				<tr class="estilo<?php //echo $j; ?>">
					<td width="20%"><?php //$fecha = date("d / m / Y",strtotime($visita->fecha)); echo $fecha; ?></td>
					<?php //$medicamento = medicament::buscar_por_id($visita->producto_id); ?>
					<td width="70%"><?php //echo htmlentities($medicamento->nombre); ?></td>
					<td width="10%"><?php //echo $visita->bonificacion; ?></td>
				</tr>
				<?php //$i++; } ?>
				<tr>
				<td colspan="2" style="text-align:right;"><b>Total Puntos:</b></td>
				<?php 
					//$sql = "SELECT sum(bonificacion) AS total_bonificacion_visitas FROM visitas_productos WHERE medico_id = ".$medico->id." AND fecha between '2012-09-01' and '2012-12-31'"; 
					//$rst = mysql_query($sql);
					//$db = mysql_fetch_array($rst); 
					//$total_bonificacion = $db['total_bonificacion_visitas'];
				?>
				<td><?php //echo $total_bonificacion; ?></td>
				</tr>
				</table>
				<!-- #/Recetas -->
				
				
				<!-- Visitas -->
				<table id="bonus" width="100%">
				<tr>
					<td><b>Fecha</b></td>
					<td><b>Medicamento 1</b></td>
					<td><b>Medicamento 2</b></td>
					<td><b>Medicamento 3</b></td>
					<td><b>Paciente</b></td>
					<td><b>Puntos</b></td>
					<td><b>Estatus</b></td>
				</tr>
				<?php if(count($bonificaciones) && $bonificaciones != 0){ ?>
					<?php foreach($bonificaciones as $bonificacion){ $j = $i%2; ?>
					<tr class="estilo<?php echo $j; ?>">
						<td style="text-align:center;" width="10%"><?php $fecha = date("d/m/Y",strtotime($bonificacion->fecha)); echo $fecha; ?></td>
						<?php $medicamento1 = medicament::buscar_por_id($bonificacion->medicamento1_id); ?>
						<td width="17%"><?php echo htmlentities(substr($medicamento1->nombre,0,15)); ?></td>
						<?php $medicamento2 = medicament::buscar_por_id($bonificacion->medicamento2_id); ?>
						<td width="17%"><?php if(!empty($medicamento2->nombre)){echo htmlentities(substr($medicamento2->nombre,0,15));}else{ echo "---";} ?></td>
						<?php $medicamento3 = medicament::buscar_por_id($bonificacion->medicamento3_id); ?>
						<td width="17%"><?php if(!empty($medicamento3->nombre)){echo htmlentities(substr($medicamento3->nombre,0,15));}else{ echo "---";}; ?> </td>
						<td width="25%"><?php echo $bonificacion->paciente; ?></td>
						<td width="5%"><?php echo $bonificacion->bonificacion; ?></td>
						<td width="10%"><?php if($bonificacion->estado == 'positivo'){ echo " <span class='positivo'>Positivo</span>";} ?><?php if($bonificacion->estado == 'negativo'){ echo " <span class='negativo'>Negativo</span>";} ?> <?php if($bonificacion->estado == 'pendiente'){ echo " <span class='pendiente'>Pendiente</span>";} ?> <?php if($bonificacion->estado == 'seguimiento'){ echo " <span class='pendiente'>Pendiente</span>";} ?></td>
					</tr>
					<?php $i++; } ?>
					<tr>
					<td colspan="5" style="text-align:right;"><b>Total Puntos:</b></td>
					<?php
						$sql = "select sum(bonificacion) as total_bonificacion from recetas where medico_id = ".$medico->id." and estado='positivo' and fecha between '2013-01-01' and '2013-12-31'"; 
						$rst = mysql_query($sql);
						$db = mysql_fetch_array($rst); 
						$total_bonificacion = $db['total_bonificacion'];
					?>
					<td><?php if(count($total_bonificacion) && $total_bonificacion != 0){echo $total_bonificacion;} else{ echo " 0";} ?></td>
					</tr>
					<?php }else{ ?>
					<tr>
						<td colspan="7">Por el momento no hay registro de recetas realizadas.</td>
					</tr>
					<?php } ?>
					</table>
				
				<!-- #/Visitas -->
				
				<div id="xx">
					<a class="back" href="prescription-on-line.php">Regresar</a>
				</div>
				
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