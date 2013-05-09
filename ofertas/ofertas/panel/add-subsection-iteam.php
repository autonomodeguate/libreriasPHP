<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a('login.php');} ?>
<?php if(isset($sesion->usuario_id)){ $usuario = user::buscar_por_id($sesion->usuario_id); } ?>
<?php

	//Recibimos los datos para crear el nuevo iTeam
	if(isset($_POST['submit'])){
		$nombre = $_POST['nombre'];
		$seccion_id = $_POST['seccion'];
		$menu_id = $_POST['menu'];
		$estado = $_POST['estado'];
		
		$subseccion = new subsections();
		$subseccion->seccion_id = $seccion_id;
		$subseccion->menu_id = $menu_id;
		$subseccion->nombre = $nombre;
		$subseccion->estado = $estado;
		if($subseccion->guardar()){
			$message = "Sub Sección agregada con exito...";
		}
		else{
			$message = "Ocurrio un error al agregar la Sub Sección...";
		}
		redireccionar_a("add-subsection-iteam.php?message={$message}&id=".$subseccion->seccion_id);
	}
	
	//Recibimos los datos para editar el iTeam
	if(isset($_POST['sub_edit'])){
		$nombre = $_POST['nombre'];
		$seccion_id = $_POST['seccion'];
		$estado = $_POST['estado'];
		
		$sub = subsections::buscar_por_id($_GET['id']);
		$sub->nombre = $nombre;
		$sub->seccion_id = $seccion_id;
		$sub->estado = $estado;
		if($sub->guardar()){
			$message = "Sub Sección editada con exito...";
		}
		else{
			$message = "Ocurrio un error al editar la Sub Sección...";
		}
		redireccionar_a("add-subsection-iteam.php?message={$message}&id=".$sub->seccion_id);
	}
	
	//Obtenemos los iTems disponibles
	$menus = menu::buscar_todos();
	
	//Buscamos las secciones activas
	$subsecciones_activ = subsections::subsecciones_activas();
	
	//Buscamos las secciones bloqueadas
	$subsecciones_bloq = subsections::subsecciones_bloq();
	
	$section = sections::buscar_por_id($_GET['id']);
	
	//Buscar sección por id
	if(!empty($_GET['edit'])){
		$edit = subsections::buscar_por_id($_GET['edit']);
	}
	
	//Bloq sección
	if(isset($_GET['bloq'])){
		$bloq = subsections::buscar_por_id($_GET['bloq']);
		$bloq->estado = 'bloq';
		if($bloq->guardar()){
			$message = "Sub Sección bloqueada con éxito...";
		}
		else{
			$message = "Ocurio un error al bloquear la Sub Sección...";
		}
		redireccionar_a("add-subsection-iteam.php?message={$message}&id=".$bloq->seccion_id);
	}
	
	//Activar sección
	if(isset($_GET['activ'])){
		$activ = subsections::buscar_por_id($_GET['activ']);
		$activ->estado = "activo";
		if($activ->guardar()){
			$message = "Sub Sección activada con éxito...";
		}
		else{
			$message = "Ocurrio un error al activar la Sub Sección...";
		}
		redireccionar_a("add-subsection-iteam.php?message={$message}&id=".$activ->seccion_id);
	}
	
	//Eliminar sección
	if(isset($_GET['delete'])){
		$delete = subsections::buscar_por_id($_GET['delete']);
		if($delete->eliminar()){
			$message = "Sub Sección eliminada con éxito...";
		}
		else{
			$message = "Ocurrio un error al eliminar la Sub Sección...";
		}
		redireccionar_a("add-subsection-iteam.php?message={$message}&id=".$delete->seccion_id);
	}
?>
<!doctype html>
<html lang="es">
<head>
	<!-- Meta´s -->
	<meta charset="UTF-8" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	
	<title>Agregar Sub Sección por iTeam - Administración Ofertas Chapinas</title>
	
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
							if(isset($mensaje)){ echo $mensaje;	}
						?>
					</div>
				<?php } ?>
				
				<div id="menu_activos">
				<span>Sub-Secciones Activas</span>
					<?php if(count($subsecciones_activ) !=0){ ?>
					<table border="1" width="100%">
								<tr>
									<td><b>Nombre</b></td>
									<td><b>Sección</b></td>
									<td colspan="3"><b>Opciones</b></td>
								</tr>
						<?php foreach($subsecciones_activ as $subsecciones){ ?>
								<tr>
									<td width="200"><?php echo $subsecciones->nombre; ?></td>
									<?php $seccion = sections::buscar_por_id($subsecciones->seccion_id); ?>
									<td><?php echo $seccion->nombre; ?></td>
									<td><a href="add-subsection-iteam.php?edit=<?php echo urlencode($subsecciones->id); ?>&id=<?php echo urlencode($subsecciones->seccion_id); ?>">Editar</a></td>
									<td><a href="add-subsection-iteam.php?bloq=<?php echo urlencode($subsecciones->id); ?>&id=<?php echo urlencode($subsecciones->seccion_id); ?>">Bloq</a></td>
									<td><a href="add-subsection-iteam.php?delete=<?php echo urlencode($subsecciones->id); ?>&id=<?php echo urlencode($subsecciones->seccion_id); ?>">Delete</a></td>
								</tr>
						<?php } ?>
					</table>
					<?php }else{ echo "<br />Por el momento no existen Secciones activas..."; } ?>
				</div>
				
				<div id="menu_inactivos">
				<span>Sub-Secciones Inactivas</span>
					<?php if(count($subsecciones_bloq) !=0){ ?>
						<table border="1" width="100%">
								<tr>
									<td><b>Nombre</b></td>
									<td><b>Sección</b></td>
									<td colspan="2"><b>Opciones</b></td>
								</tr>
						<?php foreach($subsecciones_bloq as $sbloq){ ?>
								<tr>
									<td width="200"><?php echo $sbloq->nombre; ?></td>
									<?php $seccion = sections::buscar_por_id($subsecciones->seccion_id); ?>
									<td><?php echo $seccion->nombre; ?></td>
									<td><a href="add-subsection-iteam.php?activ=<?php echo urlencode($sbloq->id); ?>&id=<?php echo urlencode($subsecciones->seccion_id); ?>">Activ</a></td>
									<td><a href="add-subsection-iteam.php?delete=<?php echo urlencode($sbloq->id); ?>&id=<?php echo urlencode($subsecciones->seccion_id); ?>">Delete</a></td>
								</tr>
						<?php } ?>
						</table>
					<?php }else{ echo "<br />Por el momento no existen Secciones inactivas...";} ?>
				</div>
				
				<?php if(!isset($_GET['edit'])){ ?>
				<!-- Formu Agregar iTeam -->
				<div id="add-menu">
				
					<hgroup>
						<h2>Agregar Sub Sección a Sección</h2>
					</hgroup>
					
					<form action="add-subsection-iteam.php" method="post">
						<div>
							<label for="iteam">Nombre:</label>
							<input type="text" name="nombre" required />
						</div>
						<div>
							<label for="menu">Menu:</label>
							<select name="menu">
							<?php foreach($menus as $menu){ ?>
								<option value="<?php echo $menu->id; ?>"><?php echo $menu->nombre; ?></option>
							<?php } ?>
							</select>
						</div>
						<div>
							<label for="iteam">Subsección:</label>
							<select name="seccion">
								<option value="<?php echo $section->id ?>"><?php echo $section->nombre; ?></option>
							</select>
						</div>
						<div>
							<label for="estado">Estado:</label>
							<select name="estado">
								<option value="activo">Activo</option>
								<option value="bloq">Bloq</option>
							</select><br />
							<input type="submit" id="sub" name="submit" value="Agregar" /><br />
							<a href="add-section-iteam.php">Cancelar</a>
						</div>
					</form>
					
				</div>
				<!-- #/Formu Agregar iTeam -->
				<?php } ?>
				
				<?php if(!empty($_GET['edit'])){ ?>
				<!-- Formu Agregar iTeam -->
				<div id="edit-menu">
				
					<hgroup>
						<h2>Editar Sub Sección a Sección</h2>
					</hgroup>
					
					<form action="add-subsection-iteam.php?id=<?php echo urlencode($edit->id); ?>" method="post">
						<div>
							<label for="iteam">Nombre:</label>
							<input type="text" name="nombre" required value="<?php echo $edit->nombre; ?>" />
						</div>
						<div>
							<label for="iteam">Sección:</label>
							<select name="seccion">
								<?php $sections = sections::buscar_todos(); ?>
								<?php foreach($sections as $section){ ?>
									<option value="<?php echo $section->id ?>" <?php if($edit->seccion_id == $section->id){ echo ' selected="selected"';} ?>><?php echo $section->nombre; ?>
								<?php } ?>
							</select>
						</div>
						<div>
							<label for="estado">Estado:</label>
							<select name="estado">
								<option value="activo" <?php if($edit->estado == 'activo'){ echo ' selected';} ?>>Activo</option>
								<option value="bloq" <?php if($edit->estado == 'bloq'){ echo ' selected';} ?>>Bloq</option>
							</select><br />
							<input type="submit" id="sub" name="sub_edit" value="Editar" />
						</div>
						<a href="add-section-iteam.php">Cancelar</a>
					</form>
					
				</div>
				<!-- #/Formu Agregar iTeam -->
				<?php } ?>
				
			</article>
			<!-- #/Texts -->
			
			<!-- Aside -->
			<aside id="aside">
				<img src="../images/banner-aside-admin3.jpg" alt="" />
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