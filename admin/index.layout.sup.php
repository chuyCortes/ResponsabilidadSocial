<?php header('Content-Type: text/html;charset=ISO-8859-1'); ?>
<html>
<head>
	<title>Administrador : <?php echo $titulo;?></title>
	<link rel="stylesheet" type="text/css" href="estilos.css" />
	<?php if($script_val){ ?>
		<script language="javascript" src="../validacion.js"></script>
		<script type="text/javascript">
		<!--
		
			<?php if($script_val2){ ?>
				function factura(){
					if(formulario.rfactura_form[0].checked==true){
						document.getElementById('factura').style.display="block";
					}
					
					if(formulario.rfactura_form[1].checked==true){
						document.getElementById('factura').style.display="none";
					}
					
				}
			<?php } ?>
		
			function errores(){
				alert("<?php echo $error_texto; ?>");
			}
			
			function inicio(){
				<?php if(!empty($error_texto)){ ?>
					errores();
				<?php } ?>
				<?php if($script_val2){ ?>
					factura();
				<?php } ?>
			}
			
		//-->
		</script>
	<?php } ?>
</head>
<body onLoad="inicio()">
<div id="fondo_encabezado">
	<div id="encabezado">
		<h1>Administrador 1er. Congreso de Responsabilidad Social</h1>
		<div id="logo"><img src="imagenes/logo_uanl.png" border="0" alt="Universidad Autónoma de Nuevo León" /></div>
	</div>
</div>

<div id="menu">
	<?php if(!empty($cargar_menu)){ include($cargar_menu); }  ?>
</div>

<div id="contenido">
	<?php if($titulo!=""){ ?>
		<h2><?php echo $titulo; ?></h2>
	<?php } ?>

	<?php include($cargar_pagina_evarios); ?>
	
</div>

<div id="pie">
	<p>UNIVERSIDAD AUTONOMA DE NUEVO LEON | Derechos Reservados <?php echo date("Y"); ?>.<br />
	   Avenida Universidad s/n, Cd. Universitaria, San Nicolás de los Garza, N.L. Tel. 52 81 8329 4000<br />
	   Sitio desarrollado por la Dirección General de Informática</p>