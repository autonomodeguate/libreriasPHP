<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a('login.php');} ?>
<?php if(isset($sesion->usuario_id)){ $usuario = user::buscar_por_id($sesion->usuario_id); } ?>
<?php
	
	//Buscamos los productos por su sección
	if(isset($_GET['product'])){
		$productos = product::productos_por_iteam($_GET['product']);
	}
	
	//Buscamos el producto para eliminarlo
	if(!empty($_GET['delete']))
	{
		$delete = product::buscar_por_id($_GET['delete']);
		$delete->suprimir();
		if($bd->affected_rows()==1)
		{
			$message = "Producto eliminado correctamente. ";
		}
		else
		{
			$message = "Ocurrio un error al eliminar el producto. ";
		}
		redireccionar_a("show-products-iteam.php?message={$message}&product=".urlencode($delete->menu_id));		
	}
	
	//Buscamos el id del producto a bloquear
	if(!empty($_GET['bloq']))
	{
		global $bd;
		$bloq = product::buscar_por_id($_GET['bloq']);
		$bloq->estado = 'bloq';
		$bloq->guardar();
		if($bd->affected_rows()==1)
		{
			$message = "Producto bloqueado correctamente. ";
		}
		else
		{
			$message = "Ocurrio un error al bloquear el producto. ";
		}
		redireccionar_a("show-products-iteam.php?message={$message}&product=".urlencode($bloq->menu_id));
	}
	
	//Recibimos el id del producto a activar
	if(!empty($_GET['activ']))
	{
		$activar = product::buscar_por_id($_GET['activ']);
		$activar->estado = 'activo';
		$activar->guardar();
		if($bd->affected_rows()==1)
		{
			$message = "Producto activado correctamente. ";
		}
		else
		{
			$message = "Ocurrio un error al activar el producto. ";
		}
		redireccionar_a("show-products-iteam.php?message={$message}&product=".urlencode($activar->menu_id));
	}
	
?>
<!doctype html>
<html lang="es">
<head>
	<!-- Meta´s -->
	<meta charset="UTF-8" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	
	<title>Productos por Sección - Administración Ofertas Chapinas</title>
	
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
					<li><a href="add-iteam-menu.php">Agregar iTeam al Menú</a></li>
					<li><a href="add-section-iteam.php">Agregar Sección por iTeam</a></li>
					<li><a href="add-product.php">Agregar Producto</a></li>
					<li><a href="logout.php">Salir</a></li>
				</ul>
			</nav>
			<!-- #/Menu -->
			
		</header>
		<!-- #/Header -->
		
		<!-- Info -->
		<div id="info">
			Bienvenido al panel de administración: <b><?php echo $usuario->nombre; ?></b>
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
				<?php $menu = menu::buscar_por_id($_GET['product']); ?>
				<span>Productos pertenecientes al iTeam <?php echo $menu->nombre; ?></span>
					<table border="1" width="100%">
								<tr>
									<td><b>Nombre</b></td>
									<td><b>Precio</b></td>
									<td><b>Sección</b></td>
									<td><b>Estado</b></td>
									<td><b>Opciones</b></td>
								</tr>
					<?php if(count($productos) !=0){ ?>
						<?php foreach($productos as $producto){ ?>
								<tr>
									<td width="200"><?php echo $producto->nombre; ?></td>
									<td width="75"><?php echo $producto->precio; ?></td>
									<!-- Secciones -->
									<?php $seccion = sections::buscar_por_id($producto->seccion_id); ?>
									<td width="120"><?php echo $seccion->nombre; ?></td>
									<!-- #/Secciones -->
									<td><?php if($producto->estado =='activo'){ echo '<p style="color:green;">Activ</p>';}else{ echo ' <p style="color:red;">Bloq</p>';} ?></td>
									<td><a href="edit-product.php?product=<?php echo urlencode($producto->id); ?>&iteam=<?php echo $producto->menu_id ?>">Editar</a> - <a href="show-products-iteam.php?bloq=<?php echo urlencode($producto->id); ?>">Bloq</a> - <a href="show-products-iteam.php?activ=<?php echo urlencode($producto->id); ?>">Activ</a> - <a href="show-products-iteam.php?delete=<?php echo urlencode($producto->id); ?>">Delete</a></td>
								</tr>
						<?php } ?>
					</table>
					<?php }else{ echo "<br />Por el momento no existen iTeams Activos"; } ?>
				</div>
				<a href="add-iteam-menu.php">Regresar</a>
				
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