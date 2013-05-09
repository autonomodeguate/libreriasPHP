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

	//Recibimos los datos para crear el nuevo iTeam
	if(isset($_POST['submit'])){
		$nombre = $_POST['nombre'];
		$nombre_generico = $_POST['nombre_generico'];
		$indicaciones = $_POST['indicaciones'];
		$efectos_adversos = $_POST['efectos_adversos'];
		$dosificaciones = $_POST['dosificaciones'];
		$sal_id = $_POST['sales'];
		$especialidad_id = $_POST['especialidad'];
		$laboratorio_id = $_POST['laboratorios'];
		$pagina = $_POST['pagina'];
		$estado = $_POST['estado'];
		
			global $bd;
			$medicamento = new medicament();
			$medicamento->nombre = $bd->preparar_consulta(strip_tags($nombre));
			$medicamento->nombre_generico = $bd->preparar_consulta(strip_tags($nombre_generico));
			$medicamento->indicaciones = strip_tags($indicaciones,"<b><br><em><p><strong>");
			$medicamento->efectos_adversos = strip_tags($efectos_adversos,"<b><br><em><p><strong>");
			$medicamento->dosificaciones = $bd->preparar_consulta(strip_tags($dosificaciones));
			$medicamento->sal_id = $bd->preparar_consulta(strip_tags($sal_id));
			$medicamento->especialidad_id = $bd->preparar_consulta(strip_tags($especialidad_id));
			$medicamento->laboratorio_id = $bd->preparar_consulta(strip_tags($laboratorio_id));
			$medicamento->fagregado = date("Y-m-d");
			$medicamento->estado = $bd->preparar_consulta(strip_tags($estado));
			$medicamento->pagina = $bd->preparar_consulta(strip_tags($pagina));
			$medicamento->bonificacion = 1;
			$medicamento->bonificacion_visita = 1;
			$medicamento->adjuntar_foto($_FILES['medicamento']);
			if($medicamento->guardar())
			{
				$message = "Medicamento agregado con exito. ";
				redireccionar_a("add-product.php?message={$message}");
			}
			else
			{
				$mensaje = "Los siguientes errores an ocurrido: ";
				$mensaje .= join("<br /> - ",$medicamento->errores);
			}
	}
	
	/* Obtenemos sales activas */
	$sales = sales::sales_activas();
	
	/* Obtenemos Laboratorios */
	$laboratorios = lab::lab_activos();
	
	/* Obtenemos Especialidades Activas */
	$especialidades = speciality::obtener_especialidades_activas();
	
?>
<!doctype html>
<html lang="es">
<head>
	<!-- Meta´s -->
	<meta charset="UTF-8" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	
	<title>Agregar Medicamento - Administración iMedics.ws</title>
	
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
	
	<!--- TinyMCE ---> 
	<script type="text/javascript" src="../../editor/tiny_mce/tiny_mce.js"></script> 
	<script type="text/javascript">// <![CDATA[
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,justifyleft,justifycenter,justifyright, justifyfull,undo,redo,link,unlink",
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
					<li><a href="add-speciality.php">Agregar Especialidad</a></li>
					<li><a href="add-section-iteam.php">Agregar Principio Activo</a></li>
					<li><a class="selected" href="add-product.php">Agregar Medicamento</a></li>
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
				
				<?php if(isset($message) || isset($_GET["message"])) { ?>
					<div id="error">
						<?php
							if(isset($_GET["message"]))	{ echo $_GET["message"]; }
							if(isset($message))	{ echo $message; }
						?>
					</div>
				<?php } ?>
				
				
				<!-- Formu Agregar Producto -->
				<div id="add-menu">
				
					<hgroup>
						<h2>Agregar Medicamento</h2>
					</hgroup>
					
					<form action="add-product.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
						<div>
							<label for="producto">Foto Medicamento:</label>
							<input type="file" id="file" required name="medicamento" />
						</div>
						<div>
							<label for="nombre">Nombre:</label>
							<input type="text" name="nombre" required />
						</div>
						<div>
							<label for="nombre-generico">Nombre Genérico:</label>
							<input type="text" name="nombre_generico" />
						</div>
						<div>
							<label for="indicaciones">Indicaciones:</label>
							<textarea name="indicaciones" cols="75" rows="5"></textarea>
						</div>
						<div>
							<label for="efectos-adversos">Efectos adversos:</label>
							<textarea name="efectos_adversos" cols="75" rows="5"></textarea>
						</div>
						<div>
							<label for="dosificaciones">Dosificaciones:</label>
							<input type="text" name="dosificaciones" />
						</div>
						<div>
							<label for="especialidades">Especialidad:</label>
							<select name="especialidad">
									<?php foreach($especialidades as $especialidad){ ?>
									<option value="<?php echo $especialidad->id ?>"><?php echo htmlentities($especialidad->nombre); ?></option>
									<?php } ?>
							</select>
						</div>
						<div>
							<label for="sales">Principio Activo:</label>
							<select name="sales">
									<?php foreach($sales as $sal){ ?>
									<option value="<?php echo $sal->id ?>"><?php echo $sal->nombre; ?></option>
									<?php } ?>
							</select>
						</div>
						<div>
							<label for="laboratorio">Laboratorio:</label>
							<select name="laboratorios">
									<?php foreach($laboratorios as $laboratorio){ ?>
									<option value="<?php echo $laboratorio->id ?>"><?php echo htmlentities($laboratorio->nombre); ?></option>
									<?php } ?>
							</select>
						</div>
						<div>
							<label for="pagina">Pagina:</label>
							<input type="text" name="pagina" />
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
			Todos los derechos reservados 2012 iMedics.ws - Diseñado y Programado por: Luis Barrera - AutonomoDeGuate.com
		</footer>
		<!-- #/Footer -->
		
	</section>
	<!-- #/Wrapper -->

</body>
</html>