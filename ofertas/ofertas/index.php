<?php require_once('../includes/initialize.php'); ?>
<?php
	$menus = menu::obtener_menus();
	
	$animales = product::animales(1);
	$agriculturas = product::agricultura(2);
	$tecnologias = product::tecnologia(3);
	$lineas = product::lineas(4);
	$repuestos = product::repuestos(5);
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
	
	<title>OfertasChapinas.com - Ofertas 100% Chapinas</title>
	<link rel="shortcut icon" href="favicon.ico" />
	
	<!-- Styles -->
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/coin-slider-styles.css"/>
	
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
					<li><a href="section.php?product=<?php echo urlencode($menu->id); ?>&iteam=<?php echo urlencode($menu->id); ?>&title=<?php echo urlencode($menu->nombre); ?>"><?php echo $menu->nombre; ?></a></li>
				<?php } ?>
				</ul>
				
				<form action="search.php" method="get">
					<input type="search" name="search" value="¿Qué necesitas?" onblur="if(this.value == '') this.value = '¿Qué necesitas?';" onfocus="if(this.value == '¿Qué necesitas?') this.value = '';" />
				</form>
				
			</nav>
			<!-- #/Access -->
			
		</header>
		<!-- #/Header -->
		
		<!-- Banner -->
		<div id="banner_ofertas">
			<a href="register_cupon.php" title="Registra tu cupón haciendo click aquí"><img src="images/banner_descuento.jpg" alt="Ofertas Chapinas" /></a>
		</div>
		<!-- #/Banner -->		
		
		<!-- Content -->
		<section id="content" class="clearfix">
			
			<p>
			<hgroup>
				<h2>Ultimos productos ingresados</h2>
			</hgroup>
			Haz click sobre una de las imagenes para ver la descripción del producto.
			</p>
			
			<?php if(count($animales) != 0){ ?>
			<div id="productos-recientes" class="clearfix">
				<hgroup>
					<h2>Productos Veterinarios</h2>
				</hgroup>
			<?php foreach($animales as $animal){ ?>
				<div class="pic" class="clearfix">
					<a href="product-description.php?product=<?php echo urlencode($animal->id); ?>&iteam=<?php echo urlencode($animal->menu_id); ?>&subsection=<?php echo urlencode($animal->subseccion_id); ?>&title=<?php echo urlencode($animal->nombre); ?>"><img width="200" height="150" src="<?php echo $animal->ruta_archivo(); ?>" alt="<?php echo $animal->nombre; ?>" title="<?php echo $animal->nombre; ?>" /></a>
					<div class="p">
						<p><b><?php echo $animal->nombre; ?></b></p>
					</div>
				</div>
			<?php } ?>
			</div>
			<?php } ?>
			
			<?php if(count($agriculturas) != 0){ ?>
			<div id="productos-recientes" class="clearfix">
				<hgroup>
					<h2>Agricultura</h2>
				</hgroup>
			<?php foreach($agriculturas as $agricultura){ ?>
				<div class="pic" class="clearfix">
					<a href="product-description.php?product=<?php echo urlencode($agricultura->id); ?>&iteam=<?php echo urlencode($agricultura->menu_id); ?>&subsection=<?php echo urlencode($agricultura->subseccion_id); ?>&title=<?php echo urlencode($agricultura->nombre); ?>"><img width="200" height="150" src="<?php echo $agricultura->ruta_archivo(); ?>" alt="<?php echo $agricultura->nombre; ?>" title="<?php echo $agricultura->nombre; ?>" /></a>
					<div class="p">
						<p><b><?php echo $agricultura->nombre; ?></b></p>
					</div>
				</div>
			<?php } ?>
			</div>
			<?php } ?>
			
			<?php if(count($tecnologias) != 0){ ?>
			<div id="productos-recientes" class="clearfix">
				<hgroup>
					<h2>Tecnología</h2>
				</hgroup>
			<?php foreach($tecnologias as $tecnologia){ ?>
				<div class="pic" class="clearfix">
					<a href="product-description.php?product=<?php echo urlencode($tecnologia->id); ?>&iteam=<?php echo urlencode($tecnologia->menu_id); ?>&subsection=<?php echo urlencode($tecnologia->subseccion_id); ?>&title=<?php echo urlencode($tecnologia->nombre); ?>"><img width="200" height="150" src="<?php echo $tecnologia->ruta_archivo(); ?>" alt="<?php echo $tecnologia->nombre; ?>" title="<?php echo $tecnologia->nombre; ?>" /></a>
					<div class="p">
						<p><b><?php echo $tecnologia->nombre; ?></b></p>
					</div>
				</div>
			<?php } ?>
			</div>
			<?php } ?>
			
			<?php if(count($lineas) != 0){ ?>
			<div id="productos-recientes" class="clearfix">
				<hgroup>
					<h2>Línea Blanca</h2>
				</hgroup>
			<?php foreach($lineas as $linea){ ?>
				<div class="pic" class="clearfix">
					<a href="product-description.php?product=<?php echo urlencode($linea->id); ?>&iteam=<?php echo urlencode($linea->menu_id); ?>&subsection=<?php echo urlencode($linea->subseccion_id); ?>&title=<?php echo urlencode($linea->nombre); ?>"><img width="200" height="150" src="<?php echo $linea->ruta_archivo(); ?>" alt="<?php echo $linea->nombre; ?>" title="<?php echo $linea->nombre; ?>" /></a>
					<div class="p">
						<p><b><?php echo $linea->nombre; ?></b></p>
					</div>
				</div>
			<?php } ?>
			</div>
			<?php } ?>
			
			<?php if(count($repuestos) != 0){ ?>
			<div id="productos-recientes" class="clearfix">
				<hgroup>
					<h2>Repuestos</h2>
				</hgroup>
			<?php foreach($repuestos as $repuesto){ ?>
				<div class="pic" class="clearfix">
					<a href="product-description.php?product=<?php echo urlencode($repuesto->id); ?>&iteam=<?php echo urlencode($repuesto->menu_id); ?>&subsection=<?php echo urlencode($repuesto->subseccion_id); ?>&title=<?php echo urlencode($repuesto->nombre); ?>"><img width="200" height="150" src="<?php echo $repuesto->ruta_archivo(); ?>" alt="<?php echo $repuesto->nombre; ?>" title="<?php echo $repuesto->nombre; ?>" /></a>
					<div class="p">
						<p><b><?php echo $repuesto->nombre; ?></b></p>
					</div>
				</div>
			<?php } ?>
			</div>
			<?php } ?>			
		
		</section>
		<!-- #/Content -->
		
		<!-- Estaciones -->
		<div id="estaciones">
			
			<table width="100%">
				<td colspan="4">
					<b>En estas estaciones de servicio puedes solicitar tus cupones de descuento</b>
				</td>
				<tr>
					<td><b>Puerta a las verapaces</b>, Baja Verapaz</td>
					<td><b>Chapines, S.A.</b>, Baja Verapaz</td>
					<td><b>Obdulios</b>, Baja Verapaz</td>
					<td><b>El Gran Chaparral</b>, Rabinal</td>
				</tr>
				<tr>
					<td><b>Estacion Don Alex</b>, Cubulco</td>
					<td><b>Estacion El Amate</b>, Cubulco</td>
					<td><b>Estación San Jeronimo</b>, San Jeronimo</td>
					<td><b>Gasolinera Verapaz</b>, Alta Verapaz</td>
				</tr>
				<tr>
					<td><b>MiniMarket Santo</b>, Alta Verapaz</td>
					<td><b>Domingo</b>, Alta Verapaz</td>
					<td><b>Las Magnolias</b>, Tac Tic</td>
					<td></td>
				</tr>
			</table>
			
		</div>
		<!-- #/Estaciones -->
		
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