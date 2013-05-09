<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$sesion->esta_logueado()){redireccionar_a('login.php');} ?>
<?php if(isset($sesion->usuario_id)){ $usuario = user::buscar_por_id($sesion->usuario_id); } ?>
<?php

	//Recibimos los datos para crear el nuevo iTeam
	if(isset($_POST['submit'])){
		$nombre = $_POST['nombre'];
		$estado = $_POST['estado'];
		
		$menu = new menu();
		$menu->nombre = $nombre;
		$menu->estado = $estado;
		if($menu->guardar()){
			$message = "iTeam agregado con exito...";
		}
		else{
			$message = "Ocurrio un error al agregar el iTeam...";
		}
		redireccionar_a("add-iteam-menu.php?message={$message}");
	}
	
	//Recibimos los datos para editar el iTeam
	if(isset($_POST['sub_edit'])){
		$nombre = $_POST['nombre'];
		$estado = $_POST['estado'];
		
		$menu = menu::buscar_por_id($_GET['id']);
		$menu->nombre = $nombre;
		$menu->estado = $estado;
		if($menu->guardar()){
			$message = "iTeam editado con exito...";
		}
		else{
			$message = "Ocurrio un error al editar el iTeam...";
		}
		redireccionar_a("add-iteam-menu.php?message={$message}");
	}
	
	//Buscamos los iTeams Activos
	$iteams = menu::menus_activos();
	
	//Buscamos los iTeam Bloqs
	$ibloqs = menu::menus_inactivos();
	
	//Buscar iTeam por id
	if(!empty($_GET['edit'])){
		$edit = menu::buscar_por_id($_GET['edit']);
	}
	
	//Bloq iTeam
	if(isset($_GET['bloq'])){
		$bloq = menu::buscar_por_id($_GET['bloq']);
		$bloq->estado = 'bloq';
		if($bloq->guardar()){
			$message = "iTeam bloqueado con éxito...";
		}
		else{
			$message = "Ocurio un error al bloquear el iTeam...";
		}
		redireccionar_a("add-iteam-menu.php?message={$message}");
	}
	
	//Activar iTeam
	if(isset($_GET['activ'])){
		$activ = menu::buscar_por_id($_GET['activ']);
		$activ->estado = "activo";
		if($activ->guardar()){
			$message = "iTeam activado con éxito...";
		}
		else{
			$message = "Ocurrio un error al activar el iTeam...";
		}
		redireccionar_a("add-iteam-menu.php?message={$message}");
	}
	
	//Eliminar iTeam
	if(isset($_GET['delete'])){
		$delete = menu::buscar_por_id($_GET['delete']);
		if($delete->eliminar()){
			$message = "iTeam eliminado con éxito...";
		}
		else{
			$message = "Ocurrio un error al eliminar el iTeam...";
		}
		redireccionar_a("add-iteam-menu.php?message={$message}");
	}
?>
<!doctype html>
<html lang="es">
<head>
	<!-- Meta´s -->
	<meta charset="UTF-8" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	
	<title>Agregar iTeam al Menú - Administración Ofertas Chapinas</title>
	
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
					<li><a class="selected" href="add-iteam-menu.php">Agregar iTeam al Menú</a></li>
					<li><a href="add-section-iteam.php">Agregar Sección por iTeam</a></li>
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
							if(isset($mensaje))	{ echo $mensaje; }
						?>
					</div>
				<?php } ?>
				
				<div id="menu_activos">
				<span>iTeams Activos</span>
					<?php if(count($iteams) !=0){ ?>
						<?php foreach($iteams as $iteam){ ?>
							<table border="1" width="100%">
								<tr>
									<td width="250"><?php echo $iteam->nombre; ?></td>
									<td><a href="add-product.php?id=<?php echo urlencode($iteam->id); ?>">Agregar Producto</a></td>
									<td><a href="add-iteam-menu.php?edit=<?php echo urlencode($iteam->id); ?>">Editar</a></td>
									<td><a href="add-iteam-menu.php?bloq=<?php echo urlencode($iteam->id); ?>">Bloq</a></td>
									<td><a href="add-iteam-menu.php?delete=<?php echo urlencode($iteam->id); ?>">Delete</a></td>
									<td><a href="show-products-iteam.php?product=<?php echo urlencode($iteam->id); ?>">Productos</a></td>
								</tr>
							</table>
						<?php } ?>
					<?php }else{ echo "<br />Por el momento no existen iTeams Activos"; } ?>
				</div>
				
				<div id="menu_inactivos">
				<span>iTeams Inactivos</span>
					<?php if(count($ibloqs) !=0){ ?>
						<?php foreach($ibloqs as $ibloq){ ?>
						<table border="1" width="80%">
								<tr>
									<td width="250"><?php echo $ibloq->nombre; ?></td>
									<td><a href="add-iteam-menu.php?activ=<?php echo urlencode($ibloq->id); ?>">Activ</a></td>
									<td><a href="add-iteam-menu.php?delete=<?php echo urlencode($ibloq->id); ?>">Delete</a></td>
								</tr>
						</table>
						<?php } ?>
					<?php }else{ echo "<br />Por el momento no existen iTeams Inactivos...";} ?>
				</div>
				
				<?php if(!isset($_GET['edit'])){ ?>
				<!-- Formu Agregar iTeam -->
				<div id="add-menu">
				
					<hgroup>
						<h2>Agregar iTeam al Menú</h2>
					</hgroup>
					
					<form action="add-iteam-menu.php" method="post">
						<div>
							<label for="iteam">iTeam:</label>
							<input type="text" name="nombre" required />
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
							<input type="submit" id="sub" name="sub_edit" value="Editar" />
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