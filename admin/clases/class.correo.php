<?php

/*
***************************************************************************************************************
Finalidad de la Clase

Mediante esta clase se pueden enviar correos, los correos se pueden enviar con diferentes parametros los cuales
pueden modificarse con las funciones presentes en esta clase, se recomienda complementar esta clase con el archivo
validaciones.php puesto que con este archivo se pueden validar los diversos campos que conforman esta clase
***************************************************************************************************************
*/

Class Correo{

var $headers;
var $headers_param;
var $headers_preparados;

	function Correo(){
		$this->headers_param=array("MIME-Version"=>"Version del MIME","Content-type"=>"El tipo de Contenido del correo, puede ser text/html o text/plain, el charset se puede quedar igual","From"=>"De donde viene el correo","Reply-To"=>"Si queremos que el replay se dirija a otra dirección","Return-path"=>"Direccón a donde va la contestación","Cc"=>"Con copia para","Bcc"=>"Con copia en blanco para");
		$this->headers["MIME-Version"]="1.0";
		$this->headers["Content-type"]="text/html; charset=iso-8859-1";
		//$this->headers["Content-type"]="text/plain; charset=iso-8859-1";
		$this->headers["From"]="webmaster@uanl.mx";
		//$this->headers["Reply-To"]="webmaster@uanl.mx";
		//$this->headers["Return-path"]="webmaster@uanl.mx";
		//$this->headers["Bcc"]="cosme.cavazos@uanl.mx";
		//$this->headers["Cc"]="cosme.cavazos@dgi.uanl.mx";
	}

	// =========================================================
	// PUBLICA
	// Muestra los parametros que se pueden modificar en el Header
	// Ejemplo de uso:
	// $correo->info_config();
	// =========================================================
	
	function info_config(){
		echo "<p><strong>Parametros que puede utilizar para el Header</strong></p>";
		foreach($this->headers_param as $campo=>$valor){
			echo "<strong>$campo</strong> $valor <br />";
		}
	}
	
	// =========================================================
	// PUBLICA
	// Muestra la información de los headers
	// Ejemplo de uso:
	// $correo->mostrar_config();
	// =========================================================
	
	function mostrar_config(){
		echo "<p><strong>Parametros actuales del Header</strong></p>";
		foreach($this->headers as $campo=>$valor){
			echo "<strong>$campo</strong> = $valor<br />";
		}
	}
	
	// =========================================================
	// PUBLICA
	// Permite la modificación de los parametros de los headers
	// El nombre del Parametro debe de ser tal y como lo muestra el
	// info_config
	// Ejemplo de uso:
	// $correo->actualiza_config("From","cosme_x@yahoo.com");
	// =========================================================
	
	function actualiza_config($param="",$valor=""){
		if(!empty($param)){
			if(!empty($this->headers_param[$param])){
				if(!empty($valor)){
					$this->headers[$param]=$valor;
				}
			}else{
				echo "El parametro $param no es Valido";
			}
		}else{
			echo "El nombre del parametro no puede estar en blanco";
		}
	}
	
	
	// =========================================================
	// PUBLICA
	// Esta función es usada por la funcion de enviar_correo, la
	// cual le permite generar el listado de headers que va a utilizar
	// =========================================================
	
	function prepara_headers(){
			$this->headers_preparados="";
			foreach($this->headers as $campo=>$valor){
				$this->headers_preparados.=$campo .": ". $valor ."\r\n";
			}
		}
		
	// =========================================================
	// PUBLICA
	// Con esta función enviamos correos
	// Ejemplo de uso:
	// $correo->enviar_correo("cosme_d@hotmail.com","Subject del Correo","El mensaje que va a recibir");
	// Si todo sale bien imprime el texto de El correo fue Enviado
	// =========================================================
		
	function enviar_correo($email_para="",$asunto="",$mensaje="",$mostrar_aviso=true){
		$aviso="";
		$enviado=false;
		if(!empty($email_para)){
			$this->prepara_headers();
			if (@mail($email_para,$asunto,$mensaje,$this->headers_preparados)){
				$aviso="<p>El correo fue Enviado</p>";
				$enviado=true;
			}else{
				$aviso="<p>Se presento un Error al Enviar la Información al Correo Indicado</p>";
			}
		}else{
			$aviso="<p>Debes de Indicar el Correo de la Persona al que va dirigido</p>";
		}
		
		if($mostrar_aviso){
				echo $aviso;
			}else{
				return $enviado;
			}
	}
}

?>