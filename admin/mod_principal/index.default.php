<p>Bienvenido(a) <?php echo $info_evarios_admin_us[2]; ?></p>
<br /><br />
<table width="90%" cellspacing="1" cellpadding="6" border="0" align="center">
	<tr>
		<th class="enc" colspan="5">Listado de Registros por Actividad</th>
	</tr>
	<tr>
		<th>Día</th>
		<th width="9%">Hora</th>
		<th width="11%">Actividad</th>
		<th>Nombre</th>
		<th>Inscritos</th>
	</tr>
	<?php foreach($ltd_actividades_arr as $info_act_tmp){
		echo "<tr>";
			echo "<td>". $info_act_tmp["dia_act"] ."</td>";
			echo "<td>". $info_act_tmp["hora_act"] ."</td>";
			echo "<td>". $tipo_arr[$info_act_tmp["tipo_act"]] ."</td>";
			echo "<td>". $info_act_tmp["tema_act"] ."<br />". $info_act_tmp["expositor_act"] ."</td>";
			echo "<td align=\"center\">". $txa[$info_act_tmp["id_act"]] ."</td>";
		echo "</tr>";
	} ?>
</table>