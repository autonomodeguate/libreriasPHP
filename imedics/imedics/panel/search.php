<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a('login.php');} ?>
<?php if(isset($sesion->usuario_id)){ $usuario = user::buscar_por_id($sesion->usuario_id); } ?>
<?php
	
	if(isset($_POST['submit'])){
		$titulo = $_POST['titulo'];
		$descripcion = $_POST['descripcion'];
		$keywords = $_POST['keywords'];
		$url = $_POST['url'];
		
		global $bd;
		
		$search = new search();
		$search->title = $bd->preparar_consulta($titulo);
		$search->description = $bd->preparar_consulta($descripcion);
		$search->url = $url;
		$search->keywords = $bd->preparar_consulta($keywords);
		
		if($search->guardar()){
			$message = "Agregado con éxito.";
		}
		else{
			$message = "Error al agregar.";
		}
		redireccionar_a("search.php?message={$message}");
	}
	
?>
<!doctype html>
<html lang="es">
<head>
	<!-- Meta´s -->
	<meta charset="UTF-8" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	
	<title>Agregar Palabras Claves - Administración Ofertas Chapinas</title>
	
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
					<li><a href="add-product2.php">Agregar Producto</a></li>
					<li><a class="selected" href="search.php">Search</a></li>
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
						<h2>Agregar Palabra Clave</h2>
					</hgroup>
					
					<form action="search.php" method="post">
						<div>
							<label for="titulo">Titulo:</label>
							<input type="text" name="titulo" required />
						</div>
						<div>
							<label for="descripcion">Descripcion:</label>
							<textarea name="descripcion" cols="35" rows="8" required></textarea>
						</div>
						<div>
							<label for="descripcion">Keywords:</label>
							<textarea name="keywords" cols="35" rows="8" required></textarea>
						</div>
						<div>
							<label for="url">Url:</label>
							<textarea name="url" cols="35" rows="2" required></textarea>
						</div>
						<div>
							<input type="submit" id="sub" name="submit" value="Agregar" />
						</div>
					</form>
					
				</div>
				<!-- #/Formu Agregar iTeam -->
				
				<?php if(!empty($_GET['edit'])){ ?>
				<!-- Formu Agregar iTeam -->
				<div id="edit-menu">
				
					<hgroup>
						<h2>Editar iTeam al Menú</h2>
					</hgroup>
					
					<form action="add-iteam-menu.php?id=<?php echo urlencode($edit->id); ?>" method="post">
						<div>
							<label for="iteam">iTeam:</label>
							<input type="text" name="nombre" required value="<?php echo $edit->nombre; ?>" />
						</div>
						<div>
							<label for="estado">Estado:</label>
							<select name="estado">
								<option value="activo" <?php if($edit->estado == 'activo'){ echo ' selected';} ?>>Activo</option>
								<option value="bloq" <?php if($edit->estado == 'bloq'){ echo ' selected';} ?>>Bloq</option>
							</select><br />
							<input type="submit" id="sub" name="sub_edit" value="Agregar" />
						</div>
						<a href="add-iteam-menu.php">Cancelar</a>
					</form>
					
				</div>
				<!-- #/Formu Agregar iTeam -->
				<?php } ?>
				
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