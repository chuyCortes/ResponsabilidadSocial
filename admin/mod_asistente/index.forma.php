<form method="post" action="index.php?<?php echo $_SERVER["QUERY_STRING"]; ?>" name="formulario" class="formulario">
	<table border="0" cellspacing="2" cellpadding="6" width="100%">
		<tr>
			<th width="25%">* Matrícula</th>
			<td><input type="text" name="matricula_form" value="<?php echo $_POST["matricula_form"]; ?>" class="sstxt <?php echo $error["matricula_form"]; ?>" /></td>
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
			<td><input type="text" name="semestre_form" value="<?php echo $_POST["semestre_form"]; ?>" class="sstxt <?php echo $error["semestre_form"]; ?>" /></td>
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
							if($total_xact[$info_conf["id_act"]]<300){
								echo "<input type=\"checkbox\" name=\"actividad_form[". $info_conf["id_act"] ."]\" ". ((isset($_POST["actividad_form"][$info_conf["id_act"]])) ? "checked=\"checked\"" : "") ." />";
							}else{
								echo "-----";
							}
						break;
						case 2:
							if($total_xact[$info_conf["id_act"]]<30){
								echo "<input type=\"checkbox\" name=\"actividad_form[". $info_conf["id_act"] ."]\" ". ((isset($_POST["actividad_form"][$info_conf["id_act"]])) ? "checked=\"checked\"" : "") ." />";
							}else{
								echo "-----";
							}
						break;
						case 3:
							if($total_xact[$info_conf["id_act"]]<50){
								echo "<input type=\"checkbox\" name=\"actividad_form[". $info_conf["id_act"] ."]\" ". ((isset($_POST["actividad_form"][$info_conf["id_act"]])) ? "checked=\"checked\"" : "") ." />";
							}else{
								echo "-----";
							}
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
							if($total_xrally[$c]<5){
								echo "<option value=\"". $c ."\" ". (($_POST["equipo_rally"]==$c) ? "selected=\"selected\"" : "" ) .">". $equipos_arr[$c] ."</option>";
							}
						}
					echo "</select>";
					echo "</td></tr>";
					echo "</table>";
				}
			echo "</tr>";
		}
	?>
	</table>
	<p align="right">
		<input type="submit" name="envia_info_evarios" value="Guardar Información" />
	</p>
</form>