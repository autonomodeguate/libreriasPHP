<?php require_once('../includes/initialize.php'); ?>
<?php
	$menus = menu::obtener_menus();
	
	if(isset($_POST['submit'])){
		
		$nombre = $_POST['nombre'];
		$telefono = $_POST['telefono'];
		$cupon = $_POST['cupon'];
		
		
		if(strlen($cupon) >= 5){
			$message = "La cantidad de digitos del cupón no es correcta.";
			redireccionar_a("register_cupon.php?message={$message}");
		}
		
		$dato = register::verificar_cupon($cupon);
		if($dato){
			$message = "Lo sentimos, el numero de cupón ya fue registrado anteriormente.";
			redireccionar_a("register_cupon.php?message={$message}");
		}
		else{
		
			global $bd;
			$registro = new register();
			$registro->nombre = $bd->preparar_consulta(strip_tags($nombre));
			$registro->telefono = $bd->preparar_consulta(strip_tags($telefono));
			$registro->cupon = $bd->preparar_consulta(strip_tags($cupon));
			$registro->fregistro = date('Y-m-d');
			
			if($registro->guardar()){
				
				if($registro->cupon == 1003){
					$message = "<hgroup><h1>FELICITACIONES!!!</h1></hgroup> tú cupon es el ganador...<br /> Te has hecho acreedor de un horno de microondas, para reclamar tu premio es necesario que te comuniques a los telefonos 2361-1141";
				}
				else{
					$message = "Tú cupon fue registrado con éxito.<br />Gracias por participar, no olvides que tienes un <hgroup><h1>10% de Descuento</h1></hgroup> en todos nuestros productos.";
				}
				redireccionar_a("register_cupon.php?message={$message}");
				
			}
		}
		
	}
	
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
	
	<title>Registrar Cupon - OfertasChapinas.com - Ofertas 100% Chapinas</title>
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
		  
	
	function MM_validateForm() { //v4.0
	  if (document.getElementById){
		var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
		for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
		  if (val) { nm=val.name; if ((val=val.value)!="") {
			if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
			  if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
			} else if (test!='R') { num = parseFloat(val);
			  if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
			  if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
				min=test.substring(8,p); max=test.substring(p+1);
				if (num<min || max<num) errors+='- '+nm+' Debe ingresar un numero entre '+min+' y '+max+'.\n';
		  } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
		} if (errors) alert('Los siguientes errores han ocurrido:\n'+errors);
		document.MM_returnValue = (errors == '');
	} }
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
		
			<hgroup>
				<h1>Registrar Cupón</h1>
			</hgroup>
			<p>
				Para verificar si tu cupon tiene premio es necesario que ingreses todos los datos que se te solicitan.
			</p>
			
			<?php if(isset($_GET['message'])){ ?>
			<!-- Message -->
			<div id="message">
					<?php echo $_GET['message']; ?>					
			</div>
			<!-- #/Message -->
			<?php } ?>
		
			<!-- Register -->
			<div id="register">
				
				<form action="register_cupon.php" method="post" name="registrar_cupon" onSubmit="MM_validateForm('nombre','','R','telefono','','R','cupon','','RinRange1:5000');return document.MM_returnValue">
					<fieldset>
					
						<div>
							<label for="nombre">Nombre:</label>
							<input name="nombre" type="text" id="nombre" required />
						</div>
						<div>
							<label for="nombre">Telefono:</label>
							<input name="telefono" type="text" id="telefono" required />
						</div>
						<div>
							<label for="nombre">Cupón:</label>
							<input name="cupon" type="text" id="cupon" required />
						</div>
						<div>
							<input type="submit" name="submit" id="s" value="Registrar" /><br />
						</div>
					
					</fieldset>
				</form>
				<a href="index.php">Regresar</a>
			
		  </div>
			<!-- #/Register -->
		
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