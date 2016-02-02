<form action="index.php?<?php echo base64_encode("seccion_evarios=asistente_stm"); ?>" method="post" class="listado">
<table width="100%" cellspacing="1" cellpadding="4">
<tr>
	<th>Día</th>
	<th>Tipo</th>
	<th>Actividad</th>
	<th>Nombre Alumno</th>
	<th>Asistió</th>
</tr>
<tr>
	<td>
		<select name="dia_fltr" class="ssstxt">
			<option value="" <?php echo ((empty($_POST["dia_fltr"])) ? "selected=\"selected\"" : ""); ?>>---- ---- ---- ---- ----</option>
			<option value="26" <?php echo (($_POST["dia_fltr"]==26) ? "selected=\"selected\"" : ""); ?>>26</option>
			<option value="27" <?php echo (($_POST["dia_fltr"]==27) ? "selected=\"selected\"" : ""); ?>>27</option>
			<option value="28" <?php echo (($_POST["dia_fltr"]==28) ? "selected=\"selected\"" : ""); ?>>28</option>
		</select>
	</td>
	<td>
		<select name="tipo_fltr" class="sstxt">
			<option value="" <?php echo ((empty($_POST["tipo_fltr"])) ? "selected=\"selected\"" : ""); ?>>---- ---- ---- ---- ----</option>
			<option value="1" <?php echo (($_POST["tipo_fltr"]==1) ? "selected=\"selected\"" : ""); ?>>Conferencia</option>
			<option value="2" <?php echo (($_POST["tipo_fltr"]==2) ? "selected=\"selected\"" : ""); ?>>Taller</option>
			<option value="3" <?php echo (($_POST["tipo_fltr"]==3) ? "selected=\"selected\"" : ""); ?>>Deporte</option>
		</select>
	</td>
	<td>
		<select name="actividad_fltr" class="stxt">
			<option value="" <?php echo ((empty($_POST["tipo_fltr"])) ? "selected=\"selected\"" : ""); ?>>---- ---- ---- ---- ----</option>
			<?php
				$ltd_actividades_arr=$bd->query_arr("Select * from evento_fime_actividades order by dia_act, orden_act");
				foreach($ltd_actividades_arr as $info_tmp){
					echo "<option value=\"". $info_tmp["id_act"] ."\" ". (($_POST["actividad_fltr"]==$info_tmp["id_act"]) ? "selected=\"selected\"" : "") .">". $info_tmp["tema_act"] ." / ". $info_tmp["expositor_act"] ."</option>";
				}
			?>
		</select>
	</td>
	<td><input type="text" name="nombre_fltr" value="<?php echo $_POST["nombre_fltr"]; ?>" class="stxt" /></td>
	<td>
		<select name="ast_fltr" class="ssstxt">
			<option value="" <?php echo ((empty($_POST["ast_fltr"])) ? "selected=\"selected\"" : ""); ?>>----</option>
			<option value="1" <?php echo (($_POST["ast_fltr"]==1) ? "selected=\"selected\"" : ""); ?>>Sí</option>
			<option value="2" <?php echo (($_POST["ast_fltr"]==2) ? "selected=\"selected\"" : ""); ?>>No</option>
		</select>
	</td>
</tr>
</table>
<p align="center"><input type="submit" name="filtro_form" value="Filtrar" /></p>
</form>
<div class="opc_izq">
	Registros encontrados: <?php echo count($ltd_rxa); ?>
</div>
<div class="opc_der">
	<a href="index.php?<?php echo base64_encode("seccion_evarios=excel_stm&filtro_form=True&id_reg=". $info["id_reg"]  . $qs_bqd ."&pgn=". $p); ?>" title="Exportar listado a Excel"><img src="imagenes/excel.png" align="absmiddle" border="0" /></a> &nbsp; 
	<a href="index.php?<?php echo base64_encode("seccion_evarios=asistente_stm&subseccion_evarios=nvo_reg"); ?>" title="Nuevo Registro"><img src="imagenes/nuevo.png" align="absmiddle" border="0" /></a>
</div>
<?php
	echo "<table width=\"100%\" cellspacing=\"2\" cellpadding=\"4\"  class=\"listado\">\n";
		echo "<tr>\n";
			echo "<th width=\"8%\">\n";
				echo "Matrícula";
			echo "</th>\n";
			echo "<th width=\"26%\">\n";
				echo "Información del Alumno";
			echo "</th>\n";
			echo "<th width=\"42%\">\n";
				echo "Actividades";
			echo "</th>\n";
			echo "<th width=\"10%\">\n";
				echo "FyH Registro";
			echo "</th>\n";
			echo "<th width=\"5%\">\n";
				echo "AST";
			echo "</th>\n";
			echo "<th colspan=\"9%\">\n";
				echo "Opciones";
			echo "</th>\n";
		echo "</tr>";
		$contador=0;
		if(!empty($ltd_rxa)){
			foreach($ltd_rxa as $id_tmp=>$info){
				$clase=(($contador%2)==0) ? "" : "class=\"claro\"";
				echo "<tr>\n";
					echo "<td ". $clase ." align=\"center\">". $info["matricula_reg"] ."</td>";
					echo "<td ". $clase ." ><a href=\"mailto:". $info["email_reg"] ."\">". $info["nombre_reg"] ."</a><br /><small>Carrera: ". $info["carrera_reg"]  ."<br />Semestre: ". $info["semestre_reg"] ."</small></td>";
					echo "<td ". $clase ." ><small>". $info["actividades_reg"] ."</small></td>";
					echo "<td ". $clase ." align=\"center\">". date("d-m-Y H:i:s", $info["fyh_reg"]) ."</small></td>";
					echo "<td ". $clase ." align=\"center\"><a href=\"index.php?". base64_encode("seccion_evarios=asistente_stm&subseccion_evarios=cmb_reg&id_reg=". $info["id_reg"] ."&elemento=ast_reg". $qs_bqd ."&pgn=". $p) ."\" title=\"Asistencia\"><img src=\"imagenes/". (($info["ast_reg"]) ? "" : "no_") ."marcado.png\" border=\"0\" /></a></td>";
					echo "<td  ". $clase ." align=\"center\"><a href=\"index.php?". base64_encode("seccion_evarios=asistente_stm&subseccion_evarios=mdf_reg&id_reg=". $info["id_reg"] . $qs_bqd ."&pgn=". $p) ."\" title=\"Modificar Información del Registro\"><img src=\"imagenes/modificar.png\" border=\"0\" /></a></td>";
					echo "<td  ". $clase ." align=\"center\">";
					echo "<a href=\"index.php?". base64_encode("seccion_evarios=asistente_stm&subseccion_evarios=elm_reg&id_reg=". $info["id_reg"] . $qs_bqd ."&pgn=". $p) ."\" title=\"Eliminar Información\" onClick=\"return confirm('¿Estás seguro de eliminar está información?'); \"><img src=\"imagenes/eliminar.png\" border=\"0\" /></a>";
					echo "</td>";
				echo "</tr>\n";
				$contador++;
			}
		}
echo "</table>";
?>
<p align="right">Registros encontrados: <?php echo count($ltd_rxa); ?></p>
<?php if($mtr_pgnc){ ?>
<p id="paginacion">
	<?php for($p=1;$p<=$tdp;$p++){ ?>
		<a href="index.php?<?php echo base64_encode("seccion_evarios=asistente_stm" . $qs_bqd ."&pgn=". $p . (($_POST["filtro_form"]) ? "&filtro_form=true" : "")); ?>" <?php echo (($p==$pgn || empty($pgn)) ? "class=\"sel\"" : ""); ?> ><?php echo $p; ?></a>
	<?php } ?>
</p>
<?php } ?>