<?php
Class control_clases{
	var $clases;
	var $errores;
	var $presento_errores;
	
	function control_clases() {
		// Aqui debemos registrar cualquier clase
		// que queramos que este disponible en
		// algun lugar de el sitio.
		// orden de los Parametros: Alias, Clase, Archivo
		$this->clases = array(
			"bd"		=>	array("bd","Bdmysql","class.bdmysql.php"),
			"pagina"	=>	array("pagina","Xhtml","class.xhtml.php"),
			"correo"	=>	array("correo","Correo","class.correo.php"),
			"xml"		=>	array("xml","Crear_archivo","class.xml.php"),
			"encripta"	=>	array("encripta","encripta","class.encrypta.php"),
			"archivo"	=>	array("archivo","Archivos","class.archivos.php"),
			"vcard"		=>	array("vcard","vCard","class.vcard.php"),
			"qs"		=>	array("qs","QST","class.querystring.php"));
	}
	
	// Funcion para preparar las clases solicitadas para su uso
	// $ids es una cadena separada con comas de los ID de las clases
	// a instanciar.
	function prepara($ids){
		$arreglo_clases=explode(",",$ids);
		foreach($arreglo_clases as $clase){
			if(is_array($this->clases[$clase])){
				$argumentos_array=$this->clases[$clase];
				if(file_exists($_SERVER["DOCUMENT_ROOT"].PATH_FW.$argumentos_array[2])){
					if(!class_exists($argumentos_array[1])){
						include ($argumentos_array[2]);
						$GLOBALS[$argumentos_array[0]]=new $argumentos_array[1];
					}else{  // Cuando la Clase ya se encuentra cargada
						$this->acumula_errores("La Clase ". $clase . " Actualmente ya esta Cargada");
						$this->presento_errores=true;
					}
				}else{	// Cuando no existe el archivo a cargar
			  		$this->acumula_errores("No se Encontro el Archivo de la Clase ". $clase);
			  		$this->presento_errores=true;
				}
			}else{		// Cuando no esta registrada la Inf. Clase
				$this->acumula_errores("La Clase ". $clase ." que Intentas Cargar no esta Definida");
				$this->presento_errores=true;
			}
		}
	}
	
	function acumula_errores($info_error){
		$this->errores[]=$info_error;
	}
	
	function imprime_errores(){
		if($this->presento_errores){
			echo "<ol>\n";
			foreach($this->errores as $contenido){
				echo "<li>$contenido</li>\n";
			}
			echo "<li>Ruta: ". $_SERVER["DOCUMENT_ROOT"].PATH_FW ."</li>";
			echo "</ol>\n";
		}
	}
}
?>