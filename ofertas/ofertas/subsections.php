<?php require_once('../includes/initialize.php'); ?>
<?php
	$menus = menu::obtener_menus();
	
	if(empty($_GET['subsection']) || !isset($_GET['subsection'])){
		redireccionar_a("index.php");
	}
		
	/*Paginacion*/
	$pagina = (!empty($_GET["pagina"])) ? (int)$_GET["pagina"] : 1;
	$productos_grupo = 15;
	$total_productos = product::total_subsecciones($_GET['subsection']);
	
	$paginacion = new pagination($pagina,$productos_grupo,$total_productos);
	$sql = "SELECT * FROM productos ";
	$sql .= " WHERE subseccion_id=".$_GET['subsection'];
	$sql .= " AND estado='activo'";
	$sql .= " LIMIT {$productos_grupo} ";
	$sql .= "OFFSET ".$paginacion->offset();
	
	//Buscamos el listado de productos disponibles
	$productos = product::buscar_por_sql($sql);
	
	/* ------------------ */	
	$iteam = menu::buscar_por_id($_GET['iteam']);
	
	$secciones = sections::secciones_activas_por_iteam($_GET['iteam']);
	
	$subsection = subsections::buscar_por_id($_GET['subsection']);
	
	//$section = sections::buscar_por_id($_GET['subsection']);
?>
<!DOCTYPE html>
<html lang="es" >
<head>
	<!-- Meta´s -->
	<meta charset="UTF-8" />
	<meta name="author" content="Luis Barrera | autonomodeguate@gmail.com" />
	<meta name="robots" content="INDEX,FOLLOW" />
	<meta name="description" content="Ofertas chapinas es un portal para promocionar todo tipo de productos ofertados en Guatemala" />
	<meta name="keywords" content="ofertas, chapinas, chapin, productos en oferta, guatemala, ofertas chapinas, productos a buen precio" />
	
	<title><?php echo $subsection->nombre; ?> - Ofertas Chapinas.com - Una Manera Sencilla de Comprar</title>
	<link rel="shortcut icon" href="favicon.ico" />
	
	<!-- Styles -->
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/coin-slider-styles.css" />
	
	<!-- Javascript -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/coin-slider.min.js"></script>
	<script type="text/javascript">
    $(document).ready(function() {
        $('#coin-slider').coinslider({ width: 519, delay: 5000 });
    });
	</script>
	
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-33497436-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	
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
			
			<!-- Menu Top -->
			<nav id="menu-top">
				<ul>
					<li><a href="index.php">Inicio</a></li>
					<li><a href="about.php">Nosotros</a></li>
					<li><a href="contact.php">Contacto</a></li>
				</ul>
			</nav>
			<!-- #/Menu Top -->
			
			<!-- Lotogipo -->
			<div class="logotipo">
				<a href="index.php"><img src="images/logotipo.png" alt="Ofertas Chapinas" /></a>
			</div>
			<!-- #/Logotipo -->
			
			<!-- Slide -->
			<div id="coin-slider">
				<img src="images/ofertas.jpg" alt="Ofertas Chapinas" />
				<img src="images/animales.jpg" alt="Animales" />
				<img src="images/agricultura.jpg" alt="Agricultura" />
				<img src="images/tecnologia.jpg" alt="Tecnología" />
				<img src="images/linea-blanca.jpg" alt="Línea Blanca" />
				<img src="images/repuestos-y-accesorios.jpg" alt="Repuestos y Accesorios" />
			</div>
			<!-- #/Slide -->
			
			<!-- Articles -->
			<div id="articles">
				<img src="images/articulos.jpg" alt="Ofertas Chapinas" />
			</div>
			<!-- #/Articles -->
			
			<!-- Access -->
			<nav id="access">
				<ul>
				<?php foreach($menus as $menu){ ?>
					<li><a <?php if($_GET['iteam'] == $menu->id){ echo " class='selected'";} ?> href="section.php?product=<?php echo urlencode($menu->id); ?>&iteam=<?php echo urlencode($menu->id); ?>&title=<?php echo urlencode($menu->nombre); ?>"><?php echo $menu->nombre; ?></a></li>
				<?php } ?>
				</ul>
				
				<form action="search.php" method="get">
					<input type="search" name="search" value="¿Qué necesitas?" onblur="if(this.value == '') this.value = '¿Qué necesitas?';" onfocus="if(this.value == '¿Qué necesitas?') this.value = '';" />
				</form>
				
			</nav>
			<!-- #/Access -->
			
		</header>
		<!-- #/Header -->
		
		<!-- Content -->
		<section id="content" class="clearfix">
		
			<!-- Aside -->
			<aside id="aside">
				<h2><?php echo $iteam->nombre; ?></h2>
				<ul class="subsections">
				<?php foreach($secciones as $seccion){ ?>
					<li><a href="sections-iteam.php?iteam=<?php echo urlencode($seccion->menu_id); ?>&section=<?php echo urlencode($seccion->id); ?>&name=<?php echo urlencode($seccion->nombre); ?>"><b><?php echo $seccion->nombre; ?></b></a>
						<ul>
							<?php $subsecciones = subsections::obtener_subsecciones_por_seccion($seccion->id); ?>
							<?php foreach($subsecciones as $subseccion){ ?>
								<li><a <?php if($subseccion->id == $subsection->id){ echo ' class="section"';} ?> href="subsections.php?subsection=<?php echo urlencode($subseccion->id); ?>&iteam=<?php echo urlencode($seccion->menu_id); ?>&name=<?php echo $subseccion->nombre; ?>"><?php echo $subseccion->nombre; ?></a></li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
				</ul>
				
			</aside>
			<!-- #/Aside -->
			
			<!-- Description -->
			<section id="section">
				
				<p>
					<hgroup>
					<h1><?php echo $subsection->nombre; ?></h1>
					</hgroup>
					Haz click sobre una de las imagenes para ver la descripción del producto.
				</p>
				
				<div id="section-products" class="clearfix">
				<?php if(count($productos) != 0){ ?>
					<?php foreach($productos as $producto){ ?>
					<div class="pic" class="clearfix">
						<a href="product-description.php?product=<?php echo urlencode($producto->id); ?>&iteam=<?php echo urlencode($producto->menu_id); ?>&subsection=<?php echo urlencode($producto->subseccion_id); ?>&title=<?php echo urlencode($producto->nombre) ?>"><img src="<?php echo $producto->ruta_archivo(); ?>" alt="<?php echo $producto->nombre; ?>" title="<?php echo $producto->nombre; ?>" /></a>
						<div class="p">
							<p><b><?php echo $producto->nombre; ?></b></p>
						</div>
					</div>
					<?php } ?>
				<?php }else{ echo '<div id="none">En este momento no hay productos disponibles.</div>'; } ?>
				</div>
				
				<div id="pagination">
					<?php
						if($paginacion->existe_anterior())
						{
							echo "&nbsp;<a href=\"subsections.php?iteam=".urlencode($producto->menu_id)."&subsection=".urlencode($producto->subseccion_id)."&section=".urlencode($producto->seccion_id)."&pagina=";
							echo $paginacion->pagina_anterior();
							echo "\"><img style=\"vertical-align:text-bottom\" width=\"20\" height=\"20\" src=\"images/left.png\" alt=\"left\" title=\"Anterior\" /></a>&nbsp;";
						}
						
						for($i=1;$i<=$paginacion->total_paginas();$i++)
						{
							if($paginacion->pagina_actual == $i)
							{
								echo "&nbsp;<b>{$i}</b>&nbsp;";
							}
							else
							{
								echo "&nbsp;<a href=\"subsections.php?iteam=".urlencode($producto->menu_id)."&subsection=".urlencode($producto->subseccion_id)."&section=".urlencode($producto->seccion_id)."&pagina={$i}\">$i</a>&nbsp;";
							}
						}
						
						if($paginacion->existe_siguiente())
						{
							echo "&nbsp;<a href=\"subsections.php?iteam=".urlencode($producto->menu_id)."&subsection=".urlencode($producto->subseccion_id)."&section=".urlencode($producto->seccion_id)."&pagina=";
							echo $paginacion->pagina_siguiente();
							echo "\"><img style=\"vertical-align:text-bottom\" width=\"20\" height=\"20\" src=\"images/right.png\" alt=\"left\" title=\"Siguiente\" /></a>&nbsp;";
						}
					?>
				</div>
				
				<hr />
				<a href="JavaScript:void(0);" onclick="window.history.back(-1);">Regresar</a>
			</section>
			<!-- #/Description -->
		
		</section>
		<!-- #/Content -->
		
		<!-- Footer -->
		<footer id="footer">
			Todos los derechos reservados 2012 OfertasChapinas.com<br />
			OfertasChapinas.com es parte del Grupo Maya de Guatemala<br />
			5ta. Calle 2-05 Zona 9 Local "C" Tels: 2361-1137 (47)<br />
			Worked by: Luis Barrera
		</footer>
		<!-- #/Footer -->
		
	</section>
	<!-- #/Wrapper -->

</body>
</html>
<?php if(isset($bd)){ $bd->cerrar_conexion();} ?>