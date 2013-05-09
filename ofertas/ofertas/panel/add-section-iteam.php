<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a('login.php');} ?>
<?php if(isset($sesion->usuario_id)){ $usuario = user::buscar_por_id($sesion->usuario_id); } ?>
<?php

	//Recibimos los datos para crear el nuevo iTeam
	if(isset($_POST['submit'])){
		$nombre = $_POST['nombre'];
		$menu_id = $_POST['iteam'];
		$estado = $_POST['estado'];
		
		global $bd;
		$seccion = new sections();
		$seccion->menu_id = $menu_id;
		$seccion->nombre = $bd->preparar_consulta($nombre);
		$seccion->estado = $estado;
		if($seccion->guardar()){
			$message = "Sección agregada con exito...";
		}
		else{
			$message = "Ocurrio un error al agregar la sección...";
		}
		redireccionar_a("add-section-iteam.php?message={$message}");
	}
	
	//Recibimos los datos para editar el iTeam
	if(isset($_POST['sub_edit'])){
		$nombre = $_POST['nombre'];
		$estado = $_POST['estado'];
		
		global $bd;
		
		$menu = sections::buscar_por_id($_GET['id']);
		$menu->nombre = $bd->preparar_consulta($nombre);
		$menu->estado = $estado;
		if($menu->guardar()){
			$message = "iTeam editado con exito...";
		}
		else{
			$message = "Ocurrio un error al editar el iTeam...";
		}
		redireccionar_a("add-section-iteam.php?message={$message}");
	}
	
	//Obtenemos los iTems disponibles
	$menus = menu::buscar_todos();
	
	//Buscamos las secciones activas
	$sections_activ = sections::secciones_activas();
	
	//Buscamos las secciones bloqueadas
	$sections_bloq = sections::secciones_inactivas();
	
	//Buscar sección por id
	if(!empty($_GET['edit'])){
		$edit = sections::buscar_por_id($_GET['edit']);
	}
	
	//Bloq sección
	if(isset($_GET['bloq'])){
		$bloq = sections::buscar_por_id($_GET['bloq']);
		$bloq->estado = 'bloq';
		if($bloq->guardar()){
			$message = "Sección bloqueada con éxito...";
		}
		else{
			$message = "Ocurio un error al bloquear la sección...";
		}
		redireccionar_a("add-section-iteam.php?message={$message}");
	}
	
	//Activar sección
	if(isset($_GET['activ'])){
		$activ = sections::buscar_por_id($_GET['activ']);
		$activ->estado = "activo";
		if($activ->guardar()){
			$message = "Sección activada con éxito...";
		}
		else{
			$message = "Ocurrio un error al activar la sección...";
		}
		redireccionar_a("add-section-iteam.php?message={$message}");
	}
	
	//Eliminar sección
	if(isset($_GET['delete'])){
		$delete = sections::buscar_por_id($_GET['delete']);
		if($delete->eliminar()){
			$message = "Sección eliminada con éxito...";
		}
		else{
			$message = "Ocurrio un error al eliminar la sección...";
		}
		redireccionar_a("add-section-iteam.php?message={$message}");
	}
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
					<li><a class="selected" href="add-section-iteam.php">Agregar Sección por iTeam</a></li>
					<li><a href="add-product2.php">Agregar Producto</a></li>
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
				<span>Secciones Activas</span>
					<?php if(count($sections_activ) !=0){ ?>
					<table border="1" width="100%">
								<tr>
									<td><b>Nombre</b></td>
									<td><b>iTeam</b></td>
									<td colspan="3"><b>Opciones</b></td>
									<td><b>Add...</b></td>
								</tr>
						<?php foreach($sections_activ as $sections){ ?>
								<tr>
									<td width="200"><?php echo $sections->nombre; ?></td>
									<?php $iteam = menu::buscar_por_id($sections->menu_id); ?>
									<td><?php echo $iteam->nombre; ?></td>
									<td><a href="add-section-iteam.php?edit=<?php echo urlencode($sections->id); ?>">Editar</a></td>
									<td><a href="add-section-iteam.php?bloq=<?php echo urlencode($sections->id); ?>">Bloq</a></td>
									<td><a href="add-section-iteam.php?delete=<?php echo urlencode($sections->id); ?>">Delete</a></td>
									<td><a href="add-subsection-iteam.php?id=<?php echo urlencode($sections->id); ?>">Add...</a></td>
								</tr>
						<?php } ?>
					</table>
					<?php }else{ echo "<br />Por el momento no existen Secciones activas..."; } ?>
				</div>
				
				<div id="menu_inactivos">
				<span>Secciones Inactivas</span>
					<?php if(count($sections_bloq) !=0){ ?>
						<table border="1" width="100%">
								<tr>
									<td><b>Nombre</b></td>
									<td><b>iTeam</b></td>
									<td colspan="2"><b>Opciones</b></td>
								</tr>
						<?php foreach($sections_bloq as $sbloq){ ?>
								<tr>
									<td width="200"><?php echo $sbloq->nombre; ?></td>
									<?php $iteam = menu::buscar_por_id($sbloq->menu_id); ?>
									<td><?php echo $iteam->nombre; ?></td>
									<td><a href="add-section-iteam.php?activ=<?php echo urlencode($sbloq->id); ?>">Activ</a></td>
									<td><a href="add-section-iteam.php?delete=<?php echo urlencode($sbloq->id); ?>">Delete</a></td>
								</tr>
						<?php } ?>
						</table>
					<?php }else{ echo "<br />Por el momento no existen Secciones inactivas...";} ?>
				</div>
				
				<?php if(!isset($_GET['edit'])){ ?>
				<!-- Formu Agregar iTeam -->
				<div id="add-menu">
				
					<hgroup>
						<h2>Agregar Seccion al Menú</h2>
					</hgroup>
					
					<form action="add-section-iteam.php" method="post">
						<div>
							<label for="iteam">Nombre:</label>
							<input type="text" name="nombre" required />
						</div>
						<div>
							<label for="iteam">iTeam:</label>
							<select name="iteam">
								<?php foreach($menus as $menu){ ?>
									<option value="<?php echo $menu->id ?>"><?php echo $menu->nombre; ?></option>
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
				<!-- #/Formu Agregar iTeam -->
				<?php } ?>
				
				<?php if(!empty($_GET['edit'])){ ?>
				<!-- Formu Agregar iTeam -->
				<div id="edit-menu">
				
					<hgroup>
						<h2>Editar sección al Menú</h2>
					</hgroup>
					
					<form action="add-section-iteam.php?id=<?php echo urlencode($edit->id); ?>" method="post">
						<div>
							<label for="iteam">Nombre:</label>
							<input type="text" name="nombre" required value="<?php echo $edit->nombre; ?>" />
						</div>
						<div>
							<label for="iteam">iTeam:</label>
							<select name="iteam">
								<?php foreach($menus as $menu){ ?>
									<option value="<?php echo $menu->id ?>" <?php if($edit->menu_id == $menu->id){ echo ' selected="selected"';} ?>><?php echo $menu->nombre; ?></option>
								<?php } ?>
							</select>
						</div>
						<div>
							<label for="estado">Estado:</label>
							<select name="estado">
								<option value="activo" <?php if($edit->estado == 'activo'){ echo ' selected';} ?>>Activo</option>
								<option value="bloq" <?php if($edit->estado == 'bloq'){ echo ' selected';} ?>>Bloq</option>
							</select><br />
							<input type="submit" id="sub" name="sub_edit" value="Agregar" />
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