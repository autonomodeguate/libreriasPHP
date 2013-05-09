<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a('login.php');} ?>
<?php if(isset($sesion->usuario_id)){ $usuario = user::buscar_por_id($sesion->usuario_id); } ?>
<?php

	//Recibimos los datos para crear el nuevo iTeam
	if(isset($_POST['submit'])){
		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];
		$precio = $_POST['precio'];
		$minima = $_POST['minima'];
		$menu_id = $_POST['menu'];
		$seccion_id = $_POST['seccion'];
		$subseccion = $_POST['subseccion'];
		$estado = $_POST['estado'];
		
			global $bd;
			$producto = new product();
			$producto->nombre = $bd->preparar_consulta(strip_tags($nombre));
			$producto->menu_id = $bd->preparar_consulta(strip_tags($menu_id));
			$producto->seccion_id = $bd->preparar_consulta(strip_tags($seccion_id));
			$producto->subseccion_id = $bd->preparar_consulta(strip_tags($subseccion));
			$producto->descripcion = strip_tags($descripcion,"<b><br><em><p><strong>");
			$producto->precio = $bd->preparar_consulta(strip_tags($precio));
			$producto->minima = $bd->preparar_consulta(strip_tags($minima));
			$producto->estado = $bd->preparar_consulta(strip_tags($estado));
			$producto->fagregado = date("Y-m-d");
			$producto->adjuntar_foto($_FILES['producto']);
			if($producto->guardar())
			{
				$message = "Producto agregado con exito. ";
				redireccionar_a("add-product.php?message={$message}&id=".$producto->menu_id);
			}
			else
			{
				$mensaje = "Los siguientes errores an ocurrido: ";
				$mensaje .= join("<br /> - ",$producto->errores);
			}
	}
	
	if(!isset($_GET['id']) && empty($_GET['id'])){
		redireccionar_a("index.php");
	}
	
	//Obtenemos los iTems disponibles
	$menus = menu::buscar_todos();
	
	$menu = menu::buscar_por_id($_GET['id']);
	$secciones = sections::secciones_por_iteam($menu->id);
	
?>
<!doctype html>
<html lang="es">
<head>
	<!-- Meta´s -->
	<meta charset="UTF-8" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	
	<title>Agregar Sección por iTeam - Administración Ofertas Chapinas</title>
	
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
	
	<!--- TinyMCE ---> 
	<script type="text/javascript" src="../../editor/tiny_mce/tiny_mce.js"></script> 
	<script type="text/javascript">// <![CDATA[
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,image,media",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		forced_root_block : '',
		plugins : 'inlinepopups,media',	
	});
	// ]]>
	</script>
	<!--- Fin TinyMCE --->
	
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
					<li><a class="selected" href="add-product.php">Agregar Producto</a></li>
					<li><a href="search.php">Search</a></li>
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
				
				
				<!-- Formu Agregar Producto -->
				<div id="add-menu">
				
					<hgroup>
						<h2>Agregar Producto</h2>
					</hgroup>
					
					<form action="add-product.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
						<div>
							<label for="producto">Producto:</label>
							<input type="file" id="file" required name="producto" />
						</div>
						<div>
							<label for="nombre">Nombre:</label>
							<input type="text" name="nombre" required />
						</div>
						<div>
							<label for="descripcion">Descripción:</label>
							<textarea name="descripcion" cols="75" rows="20"></textarea>
						</div>
						<div>
							<label for="precio">Precio:</label>
							<input type="text" name="precio" required />
						</div>
						<div>
							<label for="precio">Compra Mínima:</label>
							<input type="text" name="minima" required />
						</div>
						<div>
							<label for="menu">Menu:</label>
							<select id="combo" name="menu">
									<option value="<?php echo $menu->id ?>"><?php echo $menu->nombre; ?></option>
							</select>
						</div>
						<div id="combo2">
							<label for="seccion">Sección:</label>
							<select name="seccion">
									<?php foreach($secciones as $seccion){ ?>
									<option value="<?php echo $seccion->id ?>"><?php echo $seccion->nombre; ?></option>
									<?php } ?>
							</select>
						</div>
						<!--
						<div id="combo3">
							<label for="seccion">Sub Sección:</label>
							<select name="subseccion">
									<?php // $subsecciones = subsections::subsecciones_por_menu($_GET['id']); ?>
									<?php // foreach($subsecciones as $subseccion){ ?>
									<option value="<?php // echo $subseccion->id; ?>"><?php // echo $subseccion->nombre; ?></option>
									<?php // } ?>
							</select>
						</div>-->
						<div id="combo3">
							<label for="seccion">Sub Sección:</label>
							<select name="subseccion">
									<?php $subsecciones = subsections::subsecciones_por_seccion($seccion->id); ?>
									<?php foreach($subsecciones as $subseccion){ ?>
									<option value="<?php echo $subseccion->id; ?>"><?php echo $subseccion->nombre; ?></option>
									<?php } ?>
							</select>
						</div>
						<div>
							<label for="estado">Estado:</label>
							<select name="estado">
								<option value="activo">Activo</option>
								<option value="bloq">Bloq</option>
							</select><br />
							<input type="submit" id="sub" name="submit" value="Agregar" />
						</div>
					</form>
					
				</div>
				<!-- #/Formu Agregar Producto -->
				
							
			</article>
			<!-- #/Texts -->
			
			<!-- Aside -->
			<aside id="aside">
				<img src="../images/banner-aside-admin4.jpg" alt="" />
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