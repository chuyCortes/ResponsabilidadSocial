<?php
	header('Content-Type: application/vnd.ms-excel;');
	header("Content-Disposition: filename=inscritos.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$campos_arr=array(
		"tipo"=>"Tipo",
		"dia"=>"Día",
		"hora"=>"Hora",
		"expositor"=>"Expositor",
		"tema"=>"Tema",
		"lugar"=>"Lugar",
		"matricula"=>"Matrícula",
		"nombre"=>"Nombre Completo",
		"carrera"=>"Carrera",
		"semestre"=>"Semestre",
		"email"=>"Correo Electrónico",
		"fyh"=>"Fecha y Hora de Registro",
		"ast"=>"AST"
		);
		
	// Filtro
	if(!empty($filtro_form)){
		$_POST["filtro_form"]=true;
		$_POST["dia_fltr"]=$dia_fltr;
		$_POST["tipo_fltr"]=$tipo_fltr;
		$_POST["actividad_fltr"]=$actividad_fltr;
		$_POST["nombre_fltr"]=$nombre_fltr;
		$_POST["ast_fltr"]=$ast_fltr;
	}
	
	if(!empty($_POST["filtro_form"])){
		
		if(!empty($_POST["dia_fltr"])){
			$where.="evento_fime_actividades.dia_act='". $_POST["dia_fltr"] ."' and ";
		}
		
		if(!empty($_POST["tipo_fltr"])){
			$where.="evento_fime_actividades.tipo_act='". $_POST["tipo_fltr"] ."' and ";
		}
		
		if(!empty($_POST["nombre_fltr"])){
			$where.="instr(evento_fime_registro.bqd_reg,\"". strtolower($_POST["nombre_fltr"]) ."\") and ";
		}
		
		if(!empty($_POST["actividad_fltr"])){
			$where.="evento_fime_actividades.id_act='". $_POST["actividad_fltr"] ."' and ";
		}
		
		if(!empty($_POST["ast_fltr"])){
			$where.="evento_fime_registro.ast_reg='". (($_POST["ast_fltr"]==2) ? "0" : "1") ."' and ";
		}
		
	}
	
	if(!empty($where)){
		$where=" and ". substr($where,0,-4);
	}
	
	$ltd_registros=$bd->query_arr("Select evento_fime_actividades.*, evento_fime_registro.* from evento_fime_actividades, evento_fime_seleccion, evento_fime_registro where evento_fime_actividades.id_act=evento_fime_seleccion.id_act and evento_fime_seleccion.id_reg=evento_fime_registro.id_reg ". $where ." order by dia_act, orden_act");

?>

<html>
<head>
<title>Información de los Inscritos</title>
</head>
<body>
<table border="1" cellpadding="3">
<tr>
	<?php foreach($campos_arr as $campo=>$alias){ ?>
			<th bgcolor="#CCCCCC"><?php echo $alias; ?></th>
	<?php } ?>
</tr>
	<?php foreach($ltd_registros as $renglon){ ?>
		<tr>
			<?php 
				foreach($campos_arr as $campo=>$alias){
					switch($campo){
						case "tipo":
							echo "<td>". $tipo_arr[$renglon[$campo ."_act"]] ."</td>";
						break;
						case "fyh":
							echo "<td>". date("d-m-Y H:m:s", $renglon[$campo ."_reg"]) ."</td>";
						break;
						case "ast":
							echo "<td>". (($renglon[$campo ."_reg"]==1) ? "Sí" : "No" ) ."</td>";
						break;
						default:
							if($campo=="dia" || $campo=="hora" || $campo=="expositor" || $campo=="tema" || $campo=="lugar"){
								echo "<td>". ((!empty($renglon[$campo ."_act"])) ? $renglon[$campo ."_act"] : "&nbsp;") ."</td>";
							}else{
								echo "<td>". ((!empty($renglon[$campo ."_reg"])) ? $renglon[$campo ."_reg"] : "&nbsp;") ."</td>";
							}
						break;
					}
				} ?>
		</tr>
	<?php } ?>
</table>
</body>
</html>