<?php
	ini_set("display_startup_errors",1);
	ini_set("display_errors",1);
	
	require("clases/clase.controlclases.php");
	require("clases/constantes.base.php");
	
	include("../arreglos.php");
	
	$cc=new control_clases (); 
	$cc->prepara("bd,encripta");
	
	$cc->imprime_errores();
	
	$info_qs_evarios=base64_decode($_SERVER["QUERY_STRING"]);
	$info_qs_evarios=explode("&", $info_qs_evarios);

	foreach($info_qs_evarios as $campo=>$contenido){
		$contenido_temp=explode("=", $contenido);
		$$contenido_temp[0]=$contenido_temp[1];
	}
	
	if(!empty($_COOKIE["evarios_admin_us"])){
		
		/* Si la cookie existe realiza la verificación del password	*/

		$info_evarios_admin_us=explode("|", base64_decode($_COOKIE["evarios_admin_us"]));
		
		$verifica=$bd->query_uno("Select password_us from usuarios_stm where id_us=". $info_evarios_admin_us[0]);

		$verifica=$encripta->paraweb($verifica);
		
		if($verifica==$info_evarios_admin_us[1]){

			switch($seccion_evarios){
				case "excel_stm":
					$cargar_modulo="excel.php";
				break;
				
				case "asistente_stm":
					$cargar_modulo="mod_asistente/index.php";
				break;
				
				case "precarga_stm":
					$cargar_modulo="mod_precarga/index.php";
				break;
				
				case "taller_stm":
					$cargar_modulo="mod_taller/index.php";
				break;
				
				case "salir_stm":
					setcookie ("evarios_admin_us","",time()-7200);
					header("location: index.php");
				break;

				default:
					$cargar_modulo="mod_principal/index.php";
				break;
			}
		}else{
			setcookie ("evarios_admin_us","",time()-7200);
			$cargar_modulo="index.error.php";
			//$carga_pagina="error.php";
		}
		
		/* Aqui se termina ese procedimiento */
		
	}else{
	
		$cargar_modulo="mod_login/index.php";
		
		/* Aqui termina */
	}
if(!empty($cargar_modulo)){
	include($cargar_modulo);
}else{
	echo "No se indico ningun modulo para cargar";
}
?>