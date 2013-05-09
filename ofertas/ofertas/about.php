<?php require_once('../includes/initialize.php'); ?>
<?php
	$menus = menu::obtener_menus();
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
	
	<title>Nosotros - OfertasChapinas.com - Ofertas 100% Chapinas</title>
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
					<li><a href="section.php?product=<?php echo urlencode($menu->id); ?>&iteam=<?php echo urlencode($menu->id); ?>&title=<?php echo urlencode($menu->nombre); ?>"><?php echo $menu->nombre; ?></a></li>
				<?php } ?>
				</ul>
				
				<form action="search.php" method="get">
					<input type="search" name="search" value="¿Qué necesitas?" onBlur="if(this.value == '') this.value = '¿Qué necesitas?';" onFocus="if(this.value == '¿Qué necesitas?') this.value = '';" />
				</form>
				
			</nav>
			<!-- #/Access -->
			
		</header>
		<!-- #/Header -->
		
		<!-- Content -->
		<section id="content" class="clearfix">
			
			<!-- Formu -->
			<section id="about">
				
				<hgroup>
					<h1>¿Qui&eacute;nes Somos?</h1>
				</hgroup>
				<p>
				Ofertas Chapinas.com es la herramienta más eficiente del internet para encontrar, comparar y escoger productos de gran demanda, lo complementa un  equipo humano experto en Telemercadeo  encargado de asesorar a cada uno de nuestros clientes. Nuestras líneas de productos abarcan las de mayor demanda local y regional: Agricultura, Veterinaria, Repuestos, Línea Blanca, etcétera.
				</p>
				
				<p>
				Nuestros Proveedores son solamente empresas de prestigio y confianza del mercado nacional: Amorsa, Promoagro, Distelsa, Bayer, etcétera.
				</p>
				
				<p>
				Nuestra Bases de datos actualmente alcanza un número superior a 15,000 usuarios,  la cual esta en constante aumento por medio de un sistema de recolección de datos muy eficiente.
				</p>
				
				<p>
				Solicite más información incluyendo sus datos a info@ofertaschapinas.com. con gusto le estaremos enviando la información requerida.<br />
				<a href="contact.php">Contactenos</a>
				</p>
				
			</section>
			<!-- #/Formu -->
			
			<!-- Aside -->
			<aside id="aside-contact">
				<div>
					<a href="register_cupon.php"><img src="images/img-about.jpg" alt="contacto ofertas chapinas" /></a>
				</div>
			</aside>
			<!-- #/Aside -->
		
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