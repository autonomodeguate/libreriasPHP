<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a('login.php');} ?>
<?php if(isset($sesion->usuario_id)){ $usuario = user::buscar_por_id($sesion->usuario_id); } ?>
<?php
	//$sql = "select count( * ) as conteo from permisos where id_accesos = {$id_acceso} and id_rol = {$tipo}";
	$id_acceso = 3;
	$sql = "select count( * ) as conteo from permisos where id_accesos = {$id_acceso} and id_rol = (select id_rol from usuarios where id = {$usuario->id})";
	$resultado = mysql_query($sql);
	$db = mysql_fetch_array($resultado);
	$acceso = $db['conteo'];	
	if($acceso == 0){
		redireccionar_a("logout.php");
	}	
?>
<?php
	
	//Buscamos los productos por su sección
	if(isset($_GET['iteam'])){
		$productos = medicament::medicamentos_iteam($_GET['iteam']);
	}
	
	//Buscamos el producto para eliminarlo
	if(!empty($_GET['delete']))
	{
		$delete = medicament::buscar_por_id($_GET['delete']);
		$delete->suprimir();
		if($bd->affected_rows()==1)
		{
			$message = "Medicamento eliminado correctamente. ";
		}
		else
		{
			$message = "Ocurrio un error al eliminar el Medicamento. ";
		}
		redireccionar_a("show-products-iteam.php?message={$message}&iteam=".urlencode($delete->sal_id));		
	}
	
	//Buscamos el id del producto a bloquear
	if(!empty($_GET['bloq']))
	{
		global $bd;
		$bloq = medicament::buscar_por_id($_GET['bloq']);
		$bloq->estado = 'bloq';
		$bloq->guardar();
		if($bd->affected_rows()==1)
		{
			$message = "Medicamento bloqueado correctamente. ";
		}
		else
		{
			$message = "Ocurrio un error al bloquear el medicamento. ";
		}
		redireccionar_a("show-products-iteam.php?message={$message}&iteam=".urlencode($bloq->sal_id));
	}
	
	//Recibimos el id del producto a activar
	if(!empty($_GET['activ']))
	{
		$activar = medicament::buscar_por_id($_GET['activ']);
		$activar->estado = 'activo';
		$activar->guardar();
		if($bd->affected_rows()==1)
		{
			$message = "Medicamento activado correctamente. ";
		}
		else
		{
			$message = "Ocurrio un error al activar el medicamento. ";
		}
		redireccionar_a("show-products-iteam.php?message={$message}&iteam=".urlencode($activar->sal_id));
	}
	
?>
<!doctype html>
<html lang="es">
<head>
	<!-- Meta´s -->
	<meta charset="UTF-8" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	
	<title>Medicamentos por Principio Activo - Administración iMedics.ws</title>
	
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
	
	<!-- html5.js for IE less than 9 -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
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
			
			<!-- Menu -->
			<nav id="access">
				<ul>
					<li><a href="index.php">Inicio</a></li>
					<li><a href="log-file.php">Ver Archivo Log</a></li>
					<li><a href="add-speciality.php">Agregar Especialidad</a></li>
					<li><a href="add-section-iteam.php">Agregar Principio Activo</a></li>
					<li><a href="add-product.php">Agregar Medicamento</a></li>
				</ul>
			</nav>
			<!-- #/Menu -->
			
		</header>
		<!-- #/Header -->
		
		<!-- Info -->
		<div id="info">
			Bienvenido al panel de administración: <b><?php echo $usuario->nombre; ?> | <a href="logout.php">Salir</a></b>
		</div>
		<!-- #/Info -->
		
		<!-- Content -->
		<section id="content" class="clearfix">
			
			<!-- Texts -->
			<article id="texts">			
				
				<?php if(isset($mensaje) || isset($_GET["message"])) { ?>
					<div id="error">
						<?php
							if(isset($_GET["message"]))	{ echo $_GET["message"]; }
							if(isset($mensaje))	{ echo $mensaje; }
						?>
					</div>
				<?php } ?>
				
				<div id="menu_activos">
				<?php $principio = sales::buscar_por_id($_GET['iteam']); ?>
				<span>Medicamentos pertenecientes al Principio Activo <b><?php echo $principio->nombre; ?></b></span>
					<table border="1" width="100%">
								<tr style="text-align:center;">
									<td><b>Nombre</b></td>
									<td><b>Especialidad</b></td>
									<td><b>Farmaceutica</b></td>
									<td><b>Estado</b></td>
									<td><b>Opciones</b></td>
								</tr>
					<?php if(count($productos) !=0){ ?>
						<?php foreach($productos as $producto){ ?>
								<tr style="text-align:center;">
									<td width="200"><?php echo htmlentities($producto->nombre); ?></td>
									<?php $especialidad = speciality::buscar_por_id($producto->especialidad_id); ?>
									<td width="75"><?php echo htmlentities($especialidad->nombre); ?></td>
									<!-- Secciones -->
									<?php $laboratorio = lab::buscar_por_id($producto->laboratorio_id); ?>
									<td width="120"><?php echo $laboratorio->nombre; ?></td>
									<!-- #/Secciones -->
									<td><?php if($producto->estado =='activo'){ echo '<p style="color:green;">Activo</p>';}else{ echo ' <p style="color:red;">Bloq</p>';} ?></td>
									<td><a href="edit-product.php?product=<?php echo urlencode($producto->id); ?>">Editar</a> - <a href="show-products-iteam.php?bloq=<?php echo urlencode($producto->id); ?>">Bloq</a> - <a href="show-products-iteam.php?activ=<?php echo urlencode($producto->id); ?>">Activ</a> - <a href="show-products-iteam.php?delete=<?php echo urlencode($producto->id); ?>">Delete</a></td>
								</tr>
						<?php } ?>
					</table>
					<?php }else{ echo "<br />Por el momento no existen iTeams Activos"; } ?>
				</div>
				<a href="JavaScript:void(0);" onclick="window.history.back(-1);">Regresar</a>
				
			</article>
			<!-- #/Texts -->
			
			<!-- Aside -->
			<aside id="aside">
				<img src="../images/banner-aside-admin2.jpg" alt="" />
			</aside>
			<!-- #/Aside -->
			
		</section>
		<!-- #/Content -->
		
		<!-- Footer -->		
		<footer id="footer">
			Todos los derechos reservados 2012 Ofertas Chapinas - Diseñado y Programado por: Luis Barrera
		</footer>
		<!-- #/Footer -->
		
	</section>
	<!-- #/Wrapper -->

</body>
</html>