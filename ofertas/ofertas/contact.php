<?php require_once('../includes/initialize.php'); ?>
<?php
	$menus = menu::obtener_menus();
	
	
	if(isset($_POST['submit'])){
		
		$nombre = $_POST['nombre'];
		$telefono = $_POST['telefono'];
		$correo = $_POST['correo'];
		$asunto = $_POST['asunto'];
		$mensaje = $_POST['mensaje'];
		
		$asunto = "Solicitud de informacion";
		$cuerpo = "El usuario ".$nombre. " Solicita información, estos son sus datos:
		Teléfono: " . $telefono . "
		Correo: " . $correo . "
		Comentario: " . $comentario . "
				
		Contactarse con el lo antes posible.";
			
		$sql = "INSERT INTO formulario_contacto SET nombre='{$nombre}', telefono='{$telefono}', correo='{$correo}', asunto='{$asunto}, mensaje='{$mensaje}', ip='".$_SERVER['REMOTE_ADDR']."'";
		if(mysql_query($sql)){
			mail("luis.barrera@ofertaschapinas.com",$asunto,$cuerpo);
			$message = "Tu mensaje se envio con exito. ";
		}
		else{
			$message = "En este momento no fue posible enviar tu mensaje. ";
		}
		redireccionar_a("contact.php?message={$message}");
		
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
	
	<title>Contacto - OfertasChapinas.com - Ofertas 100% Chapinas</title>
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
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' debe ingresar un número.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
    } if (errors) alert('Los siguientes errores han ocurrido:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
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
			<section id="formulario">
				<?php if(isset($mensaje) || isset($_GET["message"])) { ?>
					<div id="error">
						<?php
							if(isset($_GET["message"]))	{ echo $_GET["message"]; }
							if(isset($mensaje))	{ echo $mensaje; }
						?>
					</div>
				<?php } ?>			
			
				<p>
					Si tienes alguna inquietud sobre el servicio llena el siguiente formulario de contacto.
				</p>
				<form action="contact.php" method="post" name="contacto" onSubmit="MM_validateForm('nombre','','R','telefono','','R','asunto','','R','mensaje','','R');return document.MM_returnValue">
					<div>
					<label for="nombre">Nombre:</label>
					<input name="nombre" type="text" id="nombre" required />
					</div>
					<div>
					<label for="telefono">Telefono:</label>
					<input name="telefono" type="text" id="telefono" required />
					</div>
					<div>
					<label for="email">Correo:</label>
					<input type="email" name="correo" required />
					</div>
					<div>
					<label for="asunto">Asunto:</label>
					<input name="asunto" type="text" id="asunto" required />
					</div>
					<div>
					<label for="mensaje">Mensaje:</label>
					<textarea name="mensaje" cols="40" rows="5" id="mensaje"></textarea>
					<br />
					<input type="submit" id="sub" name="submit" value="Enviar" />
					</div>
				</form>
				
			</section>
			<!-- #/Formu -->
			
			<!-- Aside -->
			<aside id="aside-contact">
				<div>
					<img src="images/img-contact.jpg" alt="contacto ofertas chapinas" />
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