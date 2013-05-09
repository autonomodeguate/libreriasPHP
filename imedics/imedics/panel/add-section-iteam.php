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

	//Recibimos los datos para crear la nueva sal activa
	if(isset($_POST['submit'])){
		$nombre = $_POST['nombre'];
		$estado = $_POST['estado'];
		
		global $bd;
		$sal = new sales();
		$sal->nombre = $bd->preparar_consulta($nombre);
		$sal->estado = $estado;
		if($sal->guardar()){
			$message = "Sal Activa agregada con exito...";
		}
		else{
			$message = "Ocurrio un error al agregar la sal activa...";
		}
		redireccionar_a("add-section-iteam.php?message={$message}");
	}
	
	//Recibimos los datos para editar el iTeam
	if(isset($_POST['sub_edit'])){
		$nombre = $_POST['nombre'];
		$estado = $_POST['estado'];
		
		global $bd;
		
		$sal = sales::buscar_por_id($_GET['id']);
		$sal->nombre = $bd->preparar_consulta($nombre);
		$sal->estado = $estado;
		if($sal->guardar()){
			$message = "Sal Activa editada con exito...";
		}
		else{
			$message = "Ocurrio un error al editar la sal activa...";
		}
		redireccionar_a("add-section-iteam.php?message={$message}");
	}
	
	//Buscamos las sales activas
	$sales_activ = sales::sales_activas();
	
	//Buscamos las sales bloqueadas
	$sales_bloq = sales::sales_inactivas();
	
	//Buscar sales por id
	if(!empty($_GET['edit'])){
		$edit = sales::buscar_por_id($_GET['edit']);
	}
	
	//Bloq sales
	if(isset($_GET['bloq'])){
		$bloq = sales::buscar_por_id($_GET['bloq']);
		$bloq->estado = 'bloq';
		if($bloq->guardar()){
			$message = "Sal Activa bloqueada con éxito...";
		}
		else{
			$message = "Ocurio un error al bloquear la sal activa...";
		}
		redireccionar_a("add-section-iteam.php?message={$message}");
	}
	
	//Activar sales
	if(isset($_GET['activ'])){
		$activ = sales::buscar_por_id($_GET['activ']);
		$activ->estado = "activo";
		if($activ->guardar()){
			$message = "Sal Activa activada con éxito...";
		}
		else{
			$message = "Ocurrio un error al activar la sal activa...";
		}
		redireccionar_a("add-section-iteam.php?message={$message}");
	}
	
	//Eliminar sales
	if(isset($_GET['delete'])){
		$delete = sales::buscar_por_id($_GET['delete']);
		if($delete->eliminar()){
			$message = "Sal Activa eliminada con éxito...";
		}
		else{
			$message = "Ocurrio un error al eliminar la sal activa...";
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
	
	<title>Agregar Principio Activo - Administración iMedics.ws</title>
	
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
					<li><a class="selected" href="add-section-iteam.php">Agregar Principio Activo</a></li>
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
							if(isset($mensaje)){ echo $mensaje;	}
						?>
					</div>
				<?php } ?>
				
				<div id="menu_activos">
				<span>Principio Activo - Activo</span>
					<?php if(count($sales_activ) !=0){ ?>
					<table border="1" width="100%">
								<tr>
									<td><b>Nombre</b></td>
									<td colspan="3"><b>Opciones</b></td>
								</tr>
						<?php foreach($sales_activ as $sales){ ?>
								<tr>
									<td width="200"><?php echo $sales->nombre; ?></td>
									<td><a href="add-section-iteam.php?edit=<?php echo urlencode($sales->id); ?>">Editar</a></td>
									<td><a href="add-section-iteam.php?bloq=<?php echo urlencode($sales->id); ?>">Bloq</a></td>
									<td><a href="add-section-iteam.php?delete=<?php echo urlencode($sales->id); ?>">Delete</a></td>
									<td><a href="show-products-iteam.php?iteam=<?php echo urlencode($sales->id); ?>">Ver Medicamentos</a></td>
								</tr>
						<?php } ?>
					</table>
					<?php }else{ echo "<br />Por el momento no existen Secciones activas..."; } ?>
				</div>
				
				<div id="menu_inactivos">
				<span>Principio Activo - Bloqueados</span>
					<?php if(count($sales_bloq) !=0){ ?>
						<table border="1" width="100%">
								<tr>
									<td><b>Nombre</b></td>
									<td colspan="2"><b>Opciones</b></td>
								</tr>
						<?php foreach($sales_bloq as $sbloq){ ?>
								<tr>
									<td width="200"><?php echo $sbloq->nombre; ?></td>
									<td><a href="add-section-iteam.php?activ=<?php echo urlencode($sbloq->id); ?>">Activ</a></td>
									<td><a href="add-section-iteam.php?delete=<?php echo urlencode($sbloq->id); ?>">Delete</a></td>
								</tr>
						<?php } ?>
						</table>
					<?php }else{ echo "<br />Por el momento no existen Sales inactivas...";} ?>
				</div>
				
				<?php if(!isset($_GET['edit'])){ ?>
				<!-- Formu Agregar iTeam -->
				<div id="add-menu">
				
					<hgroup>
						<h2>Agregar Principio Activo</h2>
					</hgroup>
					
					<form action="add-section-iteam.php" method="post">
						<div>
							<label for="iteam">Nombre:</label>
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
						<h2>Editar Principio Activo</h2>
					</hgroup>
					
					<form action="add-section-iteam.php?id=<?php echo urlencode($edit->id); ?>" method="post">
						<div>
							<label for="iteam">Nombre:</label>
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
			Todos los derechos reservados 2012 iMedics.ws - Diseñado y Programado por: Luis Barrera - AutonomoDeGuate.com
		</footer>
		<!-- #/Footer -->
		
	</section>
	<!-- #/Wrapper -->

</body>
</html>