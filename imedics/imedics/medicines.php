<?php require_once('../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a("login.php");} ?>
<?php if(isset($sesion->usuario_id)){ $medico = medic::buscar_por_id($sesion->usuario_id); } ?>
<?php	$sales = sales::buscar_todos(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!-- Meta´s -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	
	<title>Medicamentos - iMedics.ws - Internet Medical Solutions</title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/lksMenuSkin1.css" />
	
	<!-- Javascript -->
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.lksMenu.js"></script>
	<script>
        $('document').ready(function(){
            $('.menu').lksMenu();
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
			<div id="center" class="clearfix">
				<div style="text-align:center;width:100%;">
					<?php $speciality = speciality::buscar_por_id($medico->especialidad_id); ?>
					<h3>Medicamentos para <?php echo htmlentities($speciality->nombre); ?></h3>
				</div>
				<hr />				
				
				<div class="menu clearfix">
					<ul>
						<?php foreach($sales as $sal){ ?>
						<li><a href="#"><?php echo $sal->nombre; ?></a>
							<?php $medicamentos = medicament::medicamentos_por_especialidad_sal($sal->id,$medico->especialidad_id); ?>
							<?php if(count($medicamentos) != 0){ ?>
							<?php foreach($medicamentos as $medicamento){ ?>
							<ul>
								<li><a href="medicine.php?medicament=<?php echo urlencode($medicamento->id); ?>&save=1"><?php echo htmlentities($medicamento->nombre); ?></a></li>
							</ul>
							<?php }?>
							
							<?php } else{ ?>
								<ul>
									<li>En este momento no hay medicamentos disponibles para esta sal activa.</li>
								</ul>
							<?php } ?>
						<?php } ?>
						</li>
					</ul>
				</div>
				<!--
				<div id="list">
					<a href="specialists.php">Otros</a>
				</div>
				-->
				
				<div id="xx">
					<a class="back" href="JavaScript:void(0);" onclick="window.history.back(-1);">Regresar</a>
				</div>
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