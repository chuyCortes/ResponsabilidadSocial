<?php 

	$activo=true;

	require("admin/clases/clase.controlclases.php");
	require("admin/clases/constantes.base.php");
	
	$cc=new control_clases (); 
	$cc->prepara("bd");
	
	include("arreglos.php");
	
	$totales_xact_arr=$bd->query_arr("Select id_act, count(*) as total from evento_fime_seleccion group by id_act");
	$totales_xrally_arr=$bd->query_arr("Select extra_sel, count(*) as total from evento_fime_seleccion where id_act=31 group by extra_sel");
	
	foreach($totales_xact_arr as $info_tmp){
		$total_xact[$info_tmp["id_act"]]=$info_tmp["total"];
	}
	
	foreach($totales_xrally_arr as $info_tmp){
		$total_xrally[$info_tmp["extra_sel"]]=$info_tmp["total"];
	}
	
	if(!empty($_POST["envia_info"])){
		
		$campos_obg="matricula,nombre,carrera,email";
		$alias_campos="Matrícula,Nombre Completo,Carrera,Correo Electrónico";
		
		$error_texto="";
		$campos_obg_arr=explode(",",$campos_obg);
		$alias_obg_arr=explode(",",$alias_campos);
		$ctd=0;
		foreach($campos_obg_arr as $campo){
			if(empty($_POST[$campo ."_form"])){
				$error[$campo ."_form"]="error";
				$error_texto.="El campo ". $alias_obg_arr[$ctd] ." no puede estar vacio \\n";
				$error_aviso=True;
			}
		$ctd++;
		}
		
		if(count($_POST["actividad_form"])<=0){		
			$error_texto.="Debes de seleccionar una actividad\\n";
			$error_aviso=True;
		}
		
		if(isset($_POST["actividad_form"][31])){
			if(empty($_POST["equipo_rally"])){
				$error_texto.="Debes de seleccionar un equipo del rally\\n";
				$error_aviso=True;
			}
		}
		
		if(empty($error_texto)){
			
			// Información de la Tabla y los Campos
			$tabla="evento_fime_registro";
			$campos="matricula,nombre,carrera,semestre,email";
			$campos_arr=explode(",",$campos);
			
			// Aqui se genera la información para el Insert
			foreach($campos_arr as $cmp){
				$sql_campos.=$cmp ."_reg,";
				$sql_valores.="'". $_POST[$cmp. "_form"] ."',";
			}
			
			$sql_campos=substr($sql_campos,0,-1);
			$sql_valores=substr($sql_valores,0,-1);
			
			$chr_esp=array("á","é","í","ó","ú","ñ","ü","Á","É","Í","Ó","Ú","Ñ","Ü","'");
			$chr_nor=array("a","e","i","o","u","n","u","a","e","i","o","u","n","u","");
			
			// Se genera el Sql
			$sql="Insert into ". $tabla ." (id_reg, ". $sql_campos .", bqd_reg, fyh_reg) values ('',". $sql_valores .",'". str_replace($chr_esp, $chr_nor, $_POST["nombre_form"]) ."','". time() ."')";
			$nvo_reg=$bd->agrega($sql);
			
			foreach($_POST["actividad_form"] as $nact=>$omitir){
				if($nact!=31){
					$sql_act="Insert into evento_fime_seleccion (id_sel, id_reg, id_act) values ('', ". $nvo_reg .", ". $nact .")";
				}else{
					$sql_act="Insert into evento_fime_seleccion (id_sel, id_reg, id_act, extra_sel) values ('', ". $nvo_reg .", ". $nact .", ". $_POST["equipo_rally"] .")";
				}
				$nva_act=$bd->agrega($sql_act);
			}
			
			setcookie ("cfm_reg_fime",base64_encode("02,". $nvo_reg .",56,F"),time()+7200);  //La cookie se crea y caduca en dos hora
			
			header("Location: gracias.php");
			exit;
		}
	}else{
		$_POST["matricula_form"]="";
		$_POST["nombre_form"]="";
		$_POST["carrera_form"]="";
		$_POST["semestre_form"]="";
		$_POST["email_form"]="";
		
	}
	
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
                 <a href="registro.php">Pre-registro</a> &nbsp; | &nbsp;
                 <a href="programa.html">Programa</a> &nbsp; | &nbsp;
               
                
			</div>
		</div>
		<div id="contenido">
			<div id="col_izq">
				<br />
				<h1 class="centrado">FORMATO DE PRE-REGISTRO</h1>
				<div class="importante">
					<span>Importante: </span>
					Recuerda que esto es un pre-registro a la actividad, para que tu asistencia sea tomada en cuenta deberás acudir a la actividad y al final registrar tu asistencia.
					<br /><br />
					No recibirás constancia de asistencia sin haber entregado tu contraseña al finalizar la actividad.
				</div>
				<br />
				<?php if($activo){ ?>
					<form action="registro.php" method="post" name="formulario">
						<table border="0" cellspacing="2" cellpadding="6" width="100%">
							<tr>
								<th width="25%">* Matrícula</th>
								<td><input type="text" name="matricula_form" value="<?php echo $_POST["matricula_form"]; ?>" class="mtxt <?php echo $error["matricula_form"]; ?>" /></td>
							</tr>
							<tr>
								<th>* Nombre Completo</th>
								<td><input type="text" name="nombre_form" value="<?php echo $_POST["nombre_form"]; ?>" class="ltxt <?php echo $error["nombre_form"]; ?>" /></td>
							</tr>
						</table>
						<br />
						<table border="0" cellspacing="2" cellpadding="6" width="100%">
							<tr>
								<th width="25%">* Carrera</th>
								<td>
									<select name="carrera_form" class="ltxt">
										<option value="" />-------- -------- -------- --------</option>
										<?php foreach($carreras_arr as $nombre_carrera){
											echo "<option value=\"". $nombre_carrera ."\" ". (($_POST["carrera_form"]==$nombre_carrera) ? "selected=\"selected\"" : "") .">". $nombre_carrera ."</option>";
										} ?>
									</select>
								</td>
							</tr>
							<tr>
								<th> &nbsp; Semestre</th>
								<td><input type="text" name="semestre_form" value="<?php echo $_POST["semestre_form"]; ?>" class="mtxt <?php echo $error["semestre_form"]; ?>" /></td>
							</tr>
						</table>
						<br />
						<table border="0" cellspacing="2" cellpadding="6" width="100%">
							<tr>
								<th width="25%">* Correo Electrónico</th>
								<td><input type="text" name="email_form" value="<?php echo $_POST["email_form"]; ?>" class="ltxt <?php echo $error["email_form"]; ?>" /></td>
							</tr>
						</table>
						<br />
						<hr size="1" />
						<h3>Actividades del 1er. Congreso de Responsabilidad Social</h3>
						<p class="centrado">Favor de marcar las actividades a las cuales esta interesado en asistir</p>
						<?php 
							$ltd_conf_arr=$bd->query_arr("Select * from evento_fime_actividades where estado_act=1 order by dia_act, orden_act");
							
							$dia=$ltd_conf_arr[0]["dia_act"];
							echo "<table border=\"0\" cellspacing=\"2\" cellpadding=\"6\" width=\"100%\">";
							echo "<tr><th colspan=\"4\">". $ltd_conf_arr[0]["dia_act"] ." de Enero</th></tr>";
							foreach($ltd_conf_arr as $info_conf){
								if($dia!=$info_conf["dia_act"]){
									echo "</table><br />\n";
									echo "<table border=\"0\" cellspacing=\"2\" cellpadding=\"6\" width=\"100%\">\n";
										echo "<tr><th colspan=\"4\">". $info_conf["dia_act"] ." de Enero</th></tr>\n";
										$dia=$info_conf["dia_act"];
								}
								echo "<tr>";
									echo "<th width=\"5%\">";
										switch($info_conf["tipo_act"]){
											case 1:
												echo "<input type=\"checkbox\" name=\"actividad_form[". $info_conf["id_act"] ."]\" ". ((isset($_POST["actividad_form"][$info_conf["id_act"]])) ? "checked=\"checked\"" : "") ." />";
											break;
											case 2:
												echo "<input type=\"checkbox\" name=\"actividad_form[". $info_conf["id_act"] ."]\" ". ((isset($_POST["actividad_form"][$info_conf["id_act"]])) ? "checked=\"checked\"" : "") ." />";
											break;
											case 3:
												echo "<input type=\"checkbox\" name=\"actividad_form[". $info_conf["id_act"] ."]\" ". ((isset($_POST["actividad_form"][$info_conf["id_act"]])) ? "checked=\"checked\"" : "") ." />";
											break;
										}										
									echo "</th>\n";
									echo "<td width=\"15%\">". $info_conf["hora_act"] ."</td>\n";
									echo "<td width=\"15%\">". $tipo_arr[$info_conf["tipo_act"]] ."</td>\n";
									if($info_conf["id_act"]!=31){
										echo "<td><strong>". $info_conf["expositor_act"] ."</strong><br />". $info_conf["tema_act"] ."<br /><small>Lugar: ". $info_conf["lugar_act"] ."</small></td>\n";
									}else{
										echo "<td><table width=\"100%\">";
										echo "<tr><td width=\"150\">";
										echo "<strong>". $info_conf["expositor_act"] ."</strong><br />". $info_conf["tema_act"] ."<br /><small>Lugar: ". $info_conf["lugar_act"] ."</small>\n";
										echo "</td><td><strong>Equipo </strong>";
										echo "<select name=\"equipo_rally\">";
											echo "<option value=\"\" ". ((empty($_POST["equipo_rally"])) ? "selected=\"selected\"" : "" ) .">--------</option>";
											for($c=1;$c<=5;$c++){
												echo "<option value=\"". $c ."\" ". (($_POST["equipo_rally"]==$c) ? "selected=\"selected\"" : "" ) .">". $equipos_arr[$c] ."</option>";
											}
										echo "</select>";
										echo "</td></tr>";
										echo "</table>";
									}
								echo "</tr>";
							}
						?>
						</table>
						
						<p class="centrado">
							<input type="submit" name="envia_info" value="Enviar Información" />
						</p>
						
					</form>
					<?php }else{ ?>
						<p>El pre-registro a finalizado</p>
					<?php } ?>
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