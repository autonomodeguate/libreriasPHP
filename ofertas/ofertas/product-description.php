<?php require_once('../includes/initialize.php'); ?>
<?php
	$menus = menu::obtener_menus();
	
	//ini_set('SMTP','mail.ofertaschapinas.com');
	ini_set('sendmail_from', 'webmaster@ofertaschapinas.com'); 
	
	if(isset($_POST['submit'])){
		$nombre = $_POST['nombre'];
		$telefono = $_POST['telefono'];
		$producto = $_POST['producto'];
		(int)$cantidad = $_POST['cantidad'];
		$cupon = $_POST['cupon'];
		(int)$costo = $_POST['costo'];
		(int)$minima = $_POST['minima'];
				
		$resultado = $cantidad * $costo;
		if($resultado >= $minima){
		
$asunto = "Solicitud de compra";
$cuerpo = "El usuario ".$nombre. " ha realizado la siguiente compra:
Producto : " . $producto . "
Telefono: " . $telefono . "
Cantidad: " . $cantidad . "
Cupon: " . $cupon . "
			
El precio unitario del producto es: Q" . $costo . " \n
El cliente realizo un pedido de: " . $cantidad . " articulos \n
Total de la compra: Q" . $resultado . "
					
Contactarse con el lo antes posible.";
			
			if(mail("luis.barrera@ofertaschapinas.com",$asunto,$cuerpo)){
				$message = "En hora buena, su pedido se realizo con éxito, el monto total es de {$resultado}, ahora puede proceder a realizar su deposito en Banrural en la cuenta No. 34 100 29 102 a nombre de Serproin. A la brebedad posible uno de nuestros asesores se pondra en contacto con usted.";
				redireccionar_a("product-description.php?product=".$_GET['product']."&iteam=".$_GET['iteam']."&message={$message}");
			}
			
		}else{
			
			$message = "Debes realizar un consumo igual o mayor a la compra minima.";
			redireccionar_a("product-description.php?product=".$_GET['product']."&iteam=".$_GET['iteam']."&message={$message}");
			
		}
		
	}
	
	if(empty($_GET['product']) || !isset($_GET['product']) || empty($_GET['iteam']) || !isset($_GET['iteam'])){
		redireccionar_a("index.php");
	}
	
	$iteam = menu::buscar_por_id($_GET['iteam']);
	
	$producto = product::buscar_por_id($_GET['product']);
	
	$secciones = sections::secciones_activas_por_iteam($_GET['iteam']);
	
	$subsection = subsections::buscar_por_id($_GET['subsection']);
	
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
	
	<title><?php echo $producto->nombre; ?> - <?php $iteam->nombre; ?> - OfertasChapinas.com - Ofertas 100% Chapinas</title>
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
					<li><a <?php if($_GET['iteam'] == $menu->id){ echo " class='selected'";} ?> href="section.php?product=<?php echo urlencode($menu->id); ?>&iteam=<?php echo urlencode($menu->id); ?>"><?php echo $menu->nombre; ?></a></li>
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
			<section id="description">
			
				<div class="photo">
					<img id="imagen" src="<?php echo $producto->ruta_archivo(); ?>" alt="<?php echo $producto->nombre; ?>" title="<?php echo $producto->nombre; ?>" />
				</div>
				<article class="info">
				
					<hgroup>
						<h1><?php echo $producto->nombre; ?></h1>
					</hgroup>
					<p>
					<?php echo $producto->descripcion; ?>
					</p>
					<p>
					<b>Costo Unitario:</b> Q <?php echo $producto->precio; ?>
					</p>
					<p>
					<b>Compra Mínima:</b> Q <?php echo $producto->minima; ?>
					</p>
					
				</article>
				
				<?php if(isset($_GET['shop'])) {?>
				<a href="product-description.php?product=<?php echo urlencode($producto->id); ?>&iteam=<?php echo urlencode($producto->menu_id); ?>&subsection=<?php echo urlencode($producto->subseccion_id); ?>&title=<?php echo urlencode($producto->nombre); ?>&shop=<?php echo true; ?>">Hacer pedido <img id="carro" width="38" height="28" src="images/carro.png" /></a>
				<?php } ?>
				
				<?php if(isset($mensaje) || isset($_GET["message"])) { ?>
					<div id="error">
						<?php
							if(isset($_GET["message"]))	{ echo $_GET["message"]; }
							if(isset($mensaje))	{ echo $mensaje; }
						?>
					</div>
				<?php } ?>
				
				<?php if(isset($_GET['shop']) && $_GET['shop'] == true){ ?>
				<!-- Shop -->
				<div id="shop">				
						
					<form id="shop_form" name="shop_form" method="post" action="product-description.php?product=<?php echo urlencode($producto->id); ?>&iteam=<?php echo urlencode($producto->menu_id); ?>&title=<?php echo urlencode($producto->nombre); ?>">
						<input type="hidden" name="costo" value="<?php echo $producto->precio; ?>" />
						<input type="hidden" name="minima" value="<?php echo $producto->minima ?>" />
						<div>
							<label for="nombre">Nombre:</label>
							<input type="text" name="nombre" required value="<?php echo isset($nombre) ? $nombre : ""; ?>" />
						</div>
						<div>
							<label for="nombre">Teléfono:</label>
							<input type="text" name="nombre" required value="<?php echo isset($telefono) ? $telefono : ""; ?>" />
						</div>
						<div>
							<label for="producto">Producto:</label>
							<input type="text" name="producto" required readonly="readonly" value="<?php echo $producto->nombre; ?>" />
						</div>
						<div>
							<label for="producto">Cantidad:</label>
							<input type="text" name="cantidad" required  />
						</div>
						<div>
							<label for="cupon">Cupon:</label>
							<input type="text" name="cupon" value="<?php echo isset($cupon) ? $cupon : ""; ?>" />
						</div>
						<div>
							<input type="submit" id="sub" name="submit" value="Comprar" />
						</div>
					</form>
					
					<a id="enlace_shop" href="product-description.php?product=<?php echo urlencode($producto->id); ?>&iteam=<?php echo urlencode($producto->menu_id); ?>&subsection=<?php echo urlencode($producto->subseccion_id); ?>&title=<?php echo urlencode($producto->nombre); ?>">Cancelar</a>
					
				</div>
				<!-- #/Shop -->
				<?php } ?>
				
				<a id="enlace" href="JavaScript:void(0);" onclick="window.history.back(-1);">Regresar</a>
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