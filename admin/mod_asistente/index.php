<?php

//Listado de elementos que estan en el filtro, debe de ser solo el nombre y el nombre del elemento de formulario debe de terminar con _fltr
$filtros_arr=array("dia","tipo","actividad","nombre","ast");

//Prepara la redirección que se utiliza cuando se realiza algun proceso
$filtro_cmp_tmp="";
foreach($filtros_arr as $elemento_tmp){
	$var_tmp=$elemento_tmp ."_fltr";
	$filtro_cmp_tmp.="&". $var_tmp ."=". $$var_tmp;
}

$redireccion="index.php?". base64_encode("seccion_evarios=asistente_stm&filtro_form=true". $filtro_cmp_tmp ."&pgn=". $pgn);

// Caracteres especiales que seran remplazados para facilitar las busquedas
$chr_esp=array("á","é","í","ó","ú","ñ","ü","Á","É","Í","Ó","Ú","Ñ","Ü","'");
$chr_nor=array("a","e","i","o","u","n","u","a","e","i","o","u","n","u","");

switch($subseccion_evarios){
	case "cmb_reg":
		$campo_reg=$bd->query_uno("Select ". $elemento ." from evento_fime_registro where id_reg=". $id_reg);
		$campo_reg=($campo_reg) ? "0" : "1";
		
		$campo_reg=$bd->actualiza("Update evento_fime_registro set ". $elemento ."=". $campo_reg ." where id_reg=". $id_reg);

		header("Location: ". $redireccion);
		exit;
	break;
	case "nvo_reg":
		$cargar_menu="menus/menu.principal.php";
		$cargar_pagina_evarios="mod_asistente/index.forma.php";
		$titulo="Nuevo Registro";
		$script_val=true;
		$script_val2=true;
		
		if(!empty($_POST["envia_info_evarios"])){
			
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
			
				header("Location: index.php?". base64_encode("seccion_evarios=asistente_stm"));
				exit;
			}
		}else{
			$_POST["matricula_form"]="";
			$_POST["nombre_form"]="";
			$_POST["carrera_form"]="";
			$_POST["semestre_form"]="";
			$_POST["email_form"]="";
		}
	
	break;
	case "mdf_reg":
	$cargar_menu="menus/menu.principal.php";
	$cargar_pagina_evarios="mod_asistente/index.forma.php";
	$titulo="Modificar Información";
	$script_val=true;
	$script_val2=true;
	
	if(!empty($_POST["envia_info_evarios"])){
		
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
			
			$_POST["bqd_form"]=strtolower(str_replace($chr_esp, $chr_nor, $_POST["nombre_form"]));
			
			// Información de la Tabla y los Campos
			$tabla="evento_fime_registro";
			$campos="matricula,nombre,carrera,semestre,email";
			$campos_arr=explode(",",$campos);
			
			// Aqui se genera la información para el Insert
			foreach($campos_arr as $cmp){
				$sql_valores.=$cmp. "_reg='". $_POST[$cmp. "_form"] ."', ";
			}
			
			$sql_valores=substr($sql_valores,0,-2);
			
			
			// Se genera el Sql
			$sql="Update ". $tabla ." set ". $sql_valores ." where id_reg='". $id_reg ."'";
			$mdf_reg=$bd->actualiza($sql);
			
			$elm_reg=$bd->elimina("evento_fime_seleccion","id_reg=". $id_reg);
			
			foreach($_POST["actividad_form"] as $nact=>$omitir){
				if($nact!=31){
					$sql_act="Insert into evento_fime_seleccion (id_sel, id_reg, id_act) values ('', ". $id_reg .", ". $nact .")";
				}else{
					$sql_act="Insert into evento_fime_seleccion (id_sel, id_reg, id_act, extra_sel) values ('', ". $id_reg .", ". $nact .", ". $_POST["equipo_rally"] .")";
				}
				$nva_act=$bd->agrega($sql_act);
			}
			
			header("Location: ". $redireccion);
			exit;
		}
		}else{
			$info_reg=$bd->query_row("Select * from evento_fime_registro where id_reg=". $id_reg);
			
			foreach($info_reg as $campo=>$valor){
				$_POST[str_replace("_reg","_form",$campo)]=$valor;
			}
			
			$info_act=$bd->query_arr("Select * from evento_fime_seleccion where id_reg=". $id_reg);
			
			foreach($info_act as $info_tmp){
				$_POST["actividad_form"][$info_tmp["id_act"]]="Marcado";
				if($info_tmp["id_act"]==31){
					$_POST["equipo_rally"]=$info_tmp["extra_sel"];
				}
			}
		}
	break;
	case "elm_reg":
		$cargar_menu="menus/menu.principal.php";
		$cargar_pagina_evarios="index.error.php";
		$titulo="";
		
		if(!empty($id_reg)){
			
			$existe=$bd->query_row("Select * from evento_fime_registro where id_reg=". $id_reg);
			
			if(!empty($existe["id_reg"])){
				
				$elm_reg=$bd->elimina("evento_fime_registro","id_reg=". $id_reg);
				
				$elm_reg=$bd->elimina("evento_fime_seleccion","id_reg=". $id_reg);
				
				header("Location: ". $redireccion);
				exit;
				
			}else{
				$msg_error="El registro no existe";
			}
			
		}else{
			$msg_error="Error al verificar la información del Registro";
		}
		
	break;
	default:
		$cargar_menu="menus/menu.principal.php";
		$cargar_pagina_evarios="mod_asistente/index.listado.php";
		$titulo="Listado de Pre-Registros";
		
		if(!empty($filtro_form)){
			$_POST["filtro_form"]=true;
			foreach($filtros_arr as $info_tmp){
				$nombre_filtro=$info_tmp ."_fltr";
				$_POST[$nombre_filtro]=$$nombre_filtro;
			}
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
		
		$ltd_registros_tmp=$bd->query_arr("Select evento_fime_registro.*, evento_fime_seleccion.*, evento_fime_actividades.* from evento_fime_registro, evento_fime_seleccion, evento_fime_actividades where evento_fime_registro.id_reg=evento_fime_seleccion.id_reg and evento_fime_seleccion.id_act=evento_fime_actividades.id_act ". $where ." order by fyh_reg Desc");
		$tdr=count($ltd_registros_tmp);
		
		// Cantidad de Registros por Página
		$rxp=50;
		
		if($tdr>0){
			if($tdr>=$rxp){
				$pgn=(empty($pgn) ? 1 : $pgn);
				$mtr_pgnc=true;
				$tdp=round($tdr/$rxp);
				if(($tdp*$rxp)<$tdr){
					$tdp++;
				}
				$limite="limit ". ($rxp * ($pgn-1)) .", ". $rxp;
				
				$ltd_registros=$bd->query_arr("Select evento_fime_registro.*, evento_fime_seleccion.*, evento_fime_actividades.* from evento_fime_registro, evento_fime_seleccion, evento_fime_actividades where evento_fime_registro.id_reg=evento_fime_seleccion.id_reg and evento_fime_seleccion.id_act=evento_fime_actividades.id_act ". $where ." order by fyh_reg Desc ". $limite);

			}else{
				$ltd_registros=$ltd_registros_tmp;
			}
			
		}
		
		if(!empty($ltd_registros)){
		
			foreach($ltd_registros as $info_tmp){
				if(!isset($ltd_rxa[$info_tmp["id_reg"]]["matricula_reg"])){
					$ltd_rxa[$info_tmp["id_reg"]]["id_reg"]=$info_tmp["id_reg"];
					$ltd_rxa[$info_tmp["id_reg"]]["matricula_reg"]=$info_tmp["matricula_reg"];
					$ltd_rxa[$info_tmp["id_reg"]]["nombre_reg"]=$info_tmp["nombre_reg"];
					$ltd_rxa[$info_tmp["id_reg"]]["carrera_reg"]=$info_tmp["carrera_reg"];
					$ltd_rxa[$info_tmp["id_reg"]]["semestre_reg"]=$info_tmp["semestre_reg"];
					$ltd_rxa[$info_tmp["id_reg"]]["email_reg"]=$info_tmp["email_reg"];
					$ltd_rxa[$info_tmp["id_reg"]]["fyh_reg"]=$info_tmp["fyh_reg"];
					$ltd_rxa[$info_tmp["id_reg"]]["ast_reg"]=$info_tmp["ast_reg"];
				}
				
				$ltd_rxa[$info_tmp["id_reg"]]["actividades_reg"].="- Día ". $info_tmp["dia_act"] ." / ". $tipo_arr[$info_tmp["tipo_act"]] ."<br />". $info_tmp["expositor_act"] ." - ". $info_tmp["tema_act"] ."<br />";
			}
			
		}

	break;	
}


$qs_bqd="";
foreach($filtros_arr as $elemento_tmp){
	$var_tmp=$elemento_tmp ."_fltr";
	$qs_bqd.="&". $var_tmp ."=". $_POST[$var_tmp];
}

include ("index.layout.sup.php");
include ("index.layout.inf.php");

?>