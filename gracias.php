<?php 
	if(isset($_COOKIE["cfm_reg_fime"])){
		$id=explode(",",base64_decode($_COOKIE["cfm_reg_fime"])); 
		require("admin/clases/clase.controlclases.php");
		require("admin/clases/constantes.base.php");
		
		$cc=new control_clases (); 
		$cc->prepara("bd,correo");
		
		include("arreglos.php");
		
		$info_reg=$bd->query_row("Select * from evento_fime_registro where id_reg=". $id[1]);
		
	}else{
		header("location: index.html");
		exit;
	}
	
	$mensaje.="
		<div style=\"width: 600px;\">
		
			<table width=\"600\" cellspacing=\"1\" cellpadding=\"7\" style=\"font-family: Arial; font-size: 12px;\">
				<tr><th width=\"25%\" style=\"background-color: #F6F6F6; text-align: left;\">Matrícula: </th><td style=\"background-color: #FFFFFF; text-align: left;\">". $info_reg["matricula_reg"] ."</td></tr>
				<tr><th style=\"background-color: #F6F6F6; text-align: left;\">Nombre Completo: </th><td style=\"background-color: #FFFFFF; text-align: left;\">". $info_reg["nombre_reg"] ."</td></tr>
				<tr><th style=\"background-color: #F6F6F6; text-align: left;\">Carrera: </th><td style=\"background-color: #FFFFFF; text-align: left;\">". $info_reg["carrera_reg"] ."</td></tr>
				<tr><th style=\"background-color: #F6F6F6; text-align: left;\">Semestre: </th><td style=\"background-color: #FFFFFF; text-align: left;\">". $info_reg["semestre_reg"] ."</td></tr>
				<tr><th style=\"background-color: #F6F6F6; text-align: left;\">Correo Electrónico: </th><td style=\"background-color: #FFFFFF; text-align: left;\">". $info_reg["email_reg"] ."</td></tr>
			</table><br />
		";
		
	$info_act_arr=$bd->query_arr("Select evento_fime_seleccion.*, evento_fime_actividades.* from evento_fime_seleccion, evento_fime_actividades where evento_fime_actividades.id_act=evento_fime_seleccion.id_act and evento_fime_seleccion.id_reg=". $id[1] ." order by evento_fime_actividades.dia_act, evento_fime_actividades.orden_act");
	
	$mensaje.="
		<h4 style=\"font-family: Arial; font-size: 12px;\">Actividades Seleccionadas</h4>
		<table width=\"600\" cellspacing=\"1\" cellpadding=\"7\" style=\"font-family: Arial; font-size: 12px;\">
		<tr><th style=\"background-color: #F6F6F6; text-align: left;\">Día</th><th style=\"background-color: #F6F6F6; text-align: left;\" width=\"13%\">Hora</th><th style=\"background-color: #F6F6F6; text-align: left;\">Actividad</th><th style=\"background-color: #F6F6F6; text-align: left;\">Información</th></tr>
	";
		
	foreach($info_act_arr as $info_act){
		$mensaje.="<tr>
			<td style=\"background-color: #FFFFFF; text-align: left;\">". $info_act["dia_act"] ."</td>
			<td style=\"background-color: #FFFFFF; text-align: left;\">". $info_act["hora_act"] ."</td>
			<td style=\"background-color: #FFFFFF; text-align: left;\">". $tipo_arr[$info_act["tipo_act"]] ."</td>
			<td style=\"background-color: #FFFFFF; text-align: left;\">". $info_act["tema_act"] ." ". $info_act["expositor_act"] ." ". $info_act["lugar_act"] ." ". ((!empty($info_act["extra_sel"])) ? " &nbsp; &nbsp; Equipo: ". $equipos_arr[$info_act["extra_sel"]] : "") ."</td>
		</tr>";
	}
	
	$mensaje.="</table>";

	$mensaje.="</div>";
	
	//$mensaje2="<center><div style=\"text-align: center; width: 600px; padding-bottom: 5px;\"><img src=\"http://eventos.uanl.mx/registro_alconpat/imagenes/correo_enc.jpg\" /><br /><h4 style=\"font-family: Arial; font-size: 12px;\">Le agradecemos que haya completado el pre-registro para asistir al Congreso ALCONPAT  2014. <br />Esta inscripción tendrá plena validez al efectuar el pago respectivo. <br />Favor de revisar los datos que aquí  se mencionan.</h4></div>". $mensaje ."</center>";
	
	$correo->actualiza_config("From","webmaster@uanl.mx");
	
	$correo->enviar_correo($info_reg["email_reg"],"Pre-registro - 1er. Congreso de Responsabilidad Social",$mensaje,false);
	
	setcookie("cfm_reg_fime","",time()-7200);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es-ES">
	<head>
		<title>1er. CONGRESO  DE RESPONSABILIDAD SOCIAL</title>
		<link rel="stylesheet" type="text/css" media="all" href="estilos.css" />
		<script type="text/javascript">
		<!--
			function errores(){
				alert("<?php echo $error_texto; ?>");
			}
			
			function inicio(){
				<?php if(!empty($error_texto)){ ?>
					errores();
				<?php } ?>
				
			}
			
		//-->
		</script>
	</head>
	<body <?php echo ((!empty($error_texto)) ? "onLoad=\"inicio()\"" : ""); ?> >
		<div id="encabezado">
		  <div id="banner">
			  <img src="imagenes/encabezado.jpg" />
			</div>
			<div id="menu">&nbsp;
                <a href="index.html" style="color: #8c0408;">Inicio</a> &nbsp; | &nbsp;
                 <a href="registro.html">Registro e inscripción</a> &nbsp; | &nbsp;
                 <a href="programa.html">Programa</a> &nbsp; | &nbsp;
               
                
			</div>
		</div>
		<div id="contenido">
			<div id="col_izq">
				<br />
				<h1 class="centrado">PRE-REGISTRO REALIZADO</h1>
				<div class="importante">
					<span>Importante: </span>
					Recuerda que esto es un pre-registro a la actividad, para que tu asistencia sea tomada en cuenta deberás acudir a la actividad y al final registrar tu asistencia.
					<br /><br />
					No recibirás constancia de asistencia sin haber entregado tu contraseña al finalizar la actividad.
				</div>
				<br />
				<?php echo $mensaje; ?>
				
			</div>
			<div id="col_der">
				<h2><strong>Fechas Importantes:</strong></h2>
                <ul class="espaciado">
                  <li><strong>Lunes 26, martes 27 y mi&eacute;rcoles 28 de enero del 2015</strong></li>
                  <li><strong>9:00 &ndash; 18:00 horas</strong></li>
                </ul>
                <p><br />
                <img src="imagenes/logos1.jpg" width="300" height="75" /></p>
<br />
                <p><img src="imagenes/logos2.jpg" width="300" height="88" /></p>
                <p><img src="imagenes/logos3.jpg" width="300" height="76" /></p>
              <p><img src="imagenes/logos4.jpg" width="150" height="64" /></p>
              <p>&nbsp;</p>
			</div>
			<div class="vacio"></div>
		</div>
		<div id="pie">
		  <table width="100%" border="0" cellspacing="0">
		    <tr>
			    <td width="25%">&nbsp;</td>
			    <td width="25%"><img src="imagenes/logo_uanl.png" /></td>
			    <td width="25%"><img src="imagenes/logo_vision.png" /></td>
			    <td width="25%">&nbsp;</td>
	        </tr>
		  </table>
    </div>
		
        </div>
	</body>
</html>