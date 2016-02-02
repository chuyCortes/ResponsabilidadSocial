<?php

$cargar_pagina_evarios="mod_login/index.login.php";
$titulo="";
$script_val=true;

if(!empty($_POST["einfo_us_evarios"])){
	if(!empty($_POST["login_us_form"]) && !empty($_POST["password_us_form"])){
		$recordset_us=$bd->query_row("Select * from usuarios_stm where login_us='". $_POST["login_us_form"] ."' and password_us='". $encripta->parabd($_POST["password_us_form"]) ."' and estado_us=1");
		if(!empty($recordset_us["id_us"])){
			
			$valor_cookie_us=$recordset_us["id_us"] ."|". $encripta->paraweb($recordset_us["password_us"]) ."|". $recordset_us["nombre_us"] ."|". $recordset_us["tipo_us"];
			
			$valor_cookie_us=base64_encode($valor_cookie_us);

			setcookie ("evarios_admin_us","$valor_cookie_us",time()+7200);  //La cookie se crea y caduca en dos hora
			
			header("location: index.php");
			exit;
			
		}else{
			$recordset_us=$bd->query_row("Select * from usuarios_stm where login_us='". $_POST["login_us_form"] ."' and pwdtmp_us='". $_POST["password_us_form"] ."' and estado_us=1");
			if(!empty($recordset_us["id_us"])){
				
				$bd->actualiza("Update usuarios_stm set password_us='". $encripta->parabd($_POST["password_us_form"]) ."', pwdtmp_us='' where login_us='". $_POST["login_us_form"] ."' and pwdtmp_us='". $_POST["password_us_form"] ."'");
				
				$recordset_us=$bd->query_row("Select * from usuarios_stm where login_us='". $_POST["login_us_form"] ."' and password_us='". $encripta->parabd($_POST["password_us_form"]) ."'");
				
				$valor_cookie_us=$recordset_us["id_us"] ."|". $encripta->paraweb($recordset_us["password_us"]) ."|". $recordset_us["nombre_us"] ."|". $recordset_us["tipo_us"];
				
				$valor_cookie_us=base64_encode($valor_cookie_us);
	
				setcookie ("evarios_admin_us","$valor_cookie_us",time()+7200);  //La cookie se crea y caduca en dos hora
				
				header("location: index.php");
				exit;
			}else{
				$error_texto="Favor de Verificar el Usuario y Contraseña";
				$error_aviso=True;
			}
		}
	}else{
		$error_texto="Favor de Escribir un Usuario y Contraseña Validos";
		$error_aviso=True;
	}
}

include ("index.layout.sup.php");
include ("index.layout.inf.php");
?>