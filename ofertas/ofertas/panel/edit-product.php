<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a('login.php');} ?>
<?php if(isset($sesion->usuario_id)){ $usuario = user::buscar_por_id($sesion->usuario_id); } ?>
<?php 
	if(empty($_GET['product']) || !isset($_GET['product'])){
		redireccionar_a("index.php");
	}
	
	$product = product::buscar_por_id($_GET['product']);
	
	$secciones = sections::secciones_por_iteam($_GET['iteam']);
?>
<?php

	//Recibimos los datos para editar el iTeam
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
			$producto = product::buscar_por_id($_GET['product']);
			$producto->nombre = $bd->preparar_consulta(strip_tags($nombre));
			$producto->menu_id = $bd->preparar_consulta(strip_tags($menu_id));
			$producto->seccion_id = $bd->preparar_consulta(strip_tags($seccion_id));
			$producto->subseccion_id = $bd->preparar_consulta(strip_tags($subseccion));
			$producto->descripcion = strip_tags($descripcion,"<b><br><em><p><strong>");
			$producto->precio = $bd->preparar_consulta(strip_tags($precio));
			$producto->minima = $bd->preparar_consulta(strip_tags($minima));
			$producto->estado = $bd->preparar_consulta(strip_tags($estado));
			if($producto->guardar()){
				$message = "Producto editado con exito. ";				
			}
			else{
				$message = "Ocurrio un error al editar el producto.";
			}
			redireccionar_a("edit-product.php?message={$message}&product=".$producto->id."&iteam=".$producto->menu_id);
	}
	
	//Obtenemos los iTems disponibles
	$menus = menu::buscar_todos();
	
?>
<!doctype html>
<html lang="es">
<head>
	<!-- Meta´s -->
	<meta charset="UTF-8" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	
	<title>Editar Producto - Administración Ofertas Chapinas</title>
	
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
	
	<!-- html5.js for IE less than 9 -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script language="JavaScript" type="text/javascript" src="js.js"></script>
	
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
				
				
				<!-- Formu Agregar iTeam -->
				<div id="add-menu">
				
					<hgroup>
						<h2>Editar Producto <?php echo $product->nombre; ?></h2>
					</hgroup>
					
					<form action="edit-product.php?product=<?php echo urlencode($product->id); ?>&iteam=<?php echo $product->menu_id ?>" method="post">
						<div>
							<img width="375" height="250" src="../<?php echo $product->ruta_archivo(); ?>" />
						</div>
						<div>
							<label for="nombre">Nombre:</label>
							<input type="text" name="nombre" required value="<?php echo $product->nombre; ?>" />
						</div>
						<div>
							<label for="descripcion">Descripción:</label>
							<textarea name="descripcion" cols="75" rows="20"><?php echo $product->descripcion; ?></textarea>
						</div>
						<div>
							<label for="precio">Precio:</label>
							<input type="text" name="precio" required value="<?php echo $product->precio; ?>" />
						</div>
						<div>
							<label for="precio">Compra Mínima:</label>
							<input type="text" name="minima" required value="<?php echo $product->minima ?>" />
						</div>
						<div>
							<label for="menu">Menu:</label>
							<select id="combo" name="menu" onchange="combo_dependiente()">
									<option value="0">Selecciona una opción</option>
								<?php foreach($menus as $menu){ ?>
									<option value="<?php echo $menu->id ?>" <?php if($menu->id == $product->menu_id){ echo ' selected="selected"';} ?>><?php echo htmlentities($menu->nombre); ?></option>
								<?php } ?>
							</select>
						</div>
						<div>
							<label for="seccion">Sección:</label>
							<select name="seccion">
							<?php foreach($secciones as $seccion){ ?>
									<option value="<?php echo $seccion->id ?>" <?php if($product->seccion_id == $seccion->id){ echo ' selected="selected"';} ?>><?php echo $seccion->nombre ?></option>
							<?php } ?>
							</select>
						</div>
						<div>
							<label for="sub seccion">Sub Sección:</label>
							<select name="subseccion">
							<?php $subsecciones = subsections::subsecciones_por_seccion($seccion->id); ?>
							<?php foreach($subsecciones as $subseccion){ ?>
									<option value="<?php echo $subseccion->id ?>" <?php if($product->subseccion_id == $subseccion->id){ echo ' selected="selected"';} ?>><?php echo $subseccion->nombre ?></option>
							<?php } ?>
							</select>
						</div>
						<div>
							<label for="estado">Estado:</label>
							<select name="estado">
								<option value="activo" <?php if($product->estado == 'activo'){ echo ' selected="selected"';} ?>>Activo</option>
								<option value="bloq" <?php if($product->estado == 'bloq'){ echo ' selected="selected"';} ?>>Bloq</option>
							</select><br />
							<input type="submit" id="sub" name="submit" value="Editar" />
						</div>
						<a href="JavaScript:void(0);" onclick="window.history.back(-1);">Regresar</a>
					</form>
					
				</div>
				<!-- #/Formu Agregar iTeam -->
				
							
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