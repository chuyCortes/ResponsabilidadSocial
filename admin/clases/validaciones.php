<?php

/*
*******************************************************************************************************
Finalidad del Archivo

Este archivo contiene diversas funciones con las que se pueden realizar diversas validaciones 
enfocadas principalmente a la validaci�n de la informaci�n enviada desde los formularios, tambien
cuenta confunciones de validaciones del Url y los diferentes procedimientos que se realizaran en los
formularios dependiendo de lo que se requiera

*******************************************************************************************************
*/

/*
*******************************************************************************************************
Funciones y Variables Usadas en el Archivo

$msgerror					- Variable que almacena todos los mensajes de error que se van presentando
							  a lo largo de las validaciones, todos estos errores se van almacenando
							  en un arreglo
							  Variable Global

$errores					- Variable que almacena todos los campos que marcan error en el transcurso
							  de las validaciones, esta variable almacena toda la informaci�n en un
							  arreglo
							  Variable Global


verifurl($url,$real=0)		- Funci�n encargada de validar el URL proporcionada a la funci�n, si
							  el URL es valido regresa True de lo contrario regresa False
							  Parametros de la funci�n
							    $url	-  El Url que se desea validar
							    $real	-  Mediante este parametro se le puede indicar a la funci�n
							    		   que verdaderamente compruebe si existe el dominio
							    		   Este parametro puede tomar 2 valores
							    		   True (1)		- Realiza una comprovaci�n para ver si
							    		   				  verdaderamente existe el dominio
							    		   Falso (0)	- Solo Verifica que el URL proporcionado tenga
							    		   				  un formato valido
							    		   				  Valor por Default

urlfull($url)				- Funci�n que se encarga de completar el URL agregandole lo del http:// en
							  caso de no contenerlo, en caso de que ya lo incluya no hace nada
							  Parametros de la funci�n
							    $url	-  El url al que se le desea agregar lo del http://

pushlogo($num,&$file)		- Funci�n que tiene como finalidad la de mover un archivo cargado mediante
							  el elemento file de un formulario a su respectiva carpeta, siempre y 
							  cuando cumpla con los requerimientos de tama�o y tipo de archivo, si
							  cumple regresa True de lo contrario regresa False.
							  Parametros de la funci�n
							    $num	-  Id del registro al que pertenece la imagen, este se
							    		   convertira en el nuevo nombre del archivo
							    $file	-  Informaci�n del archivo cargada a la pagina mediante el
							    		   elemento file de un formulario

cleanstring(&$arr)			- Funci�n encargada de cambiar los caracteres especiales a sus respectivos
							  valores HTML por ejemplo el & lo convierte a &amp;
							    $arr	- Texto al que se le aplicara la funci�n de htmlspecialchars
							    		  la cual convierte caracteres especiales a sus respectivos
							    		  valores HTML

quitaslash(&$arr)			- Funci�n encargada de eliminar las \ que se ponen de mas despues de 
							  utilizar la funci�n cleanstring, cuando se encuetra \\ solo deja una
							    $arr	- Texto al que se le aplicara la funci�n stripslashes la cual
							    		  se encarga de eliminar las \ que se encuentran en el texto.

es_email($email)			- Funci�n encargada de validar direcciones de correo electronico, en caso
							  de ser valida la direcci�n de correo regresara True, en caso contrario
							  regresara False
							  Parametros de la funci�n
							    $email	- Variable que contiene la direcci�n de correo electronico que
							    		  se desea validar

err($campo,$mensaje)		- Funci�n que realiza una referencia entre las variables de msgerror y
							  errores con algunas variables de uso local en la funci�n, esto lo realiza
							  con el fin de ir agregando los nuevos valores a sus respectivas
							  variables
							  Parametros de la funci�n
							    $campo	- Nombre del campo en donde se presento el error
							    $mensaje- Mensaje que se presentara cuando se realize el listado de
							    		  errores encontrados

ver($campo,$alias,$tipo,$patron="",$extra=0)
							- Funci�n encargada de realizar las diversas validaci�nes a los elementos
							  de un formulario, cada validaci�n tiene un numero especifico, por ejemplo
							  el numero 1 indica que no debe de estar vacio el campo y el numero 2
							  indica que debe de ser de tipo texto, para validar que sea de tipo texto
							  y que no este vacio basta con indicar que se realize la validaci�n # 3,
							  la cual es la suma del 1 y 2, la funci�n identifica que validaciones se
							  van a realizar mediante el sistema binario, con el cual solo basta con
							  que tenga una semejansa y se esa manera se realizara la validaci�n
							  Parametros de la funci�n
							    $campo	- Nombre del campo en el formulario HTML
							    $alias	- Nombre que sera mostrado en caso de haber un error
							    $tipo	- Numero que indica la validaci�n que se realizara, para
							    		  realizar validaciones de varios tipos se deden de sumar los
							    		  numeros de las validaciones que se desean realizar
							    $patron	- Patron que se utilizara para realizar una validaci�n perso-
							    		  nalizada, para poder usar la validaci�n personalizada el tipo
							    		  debe de contener el # 32
							    $extra	- Esta variable es usada para realizar comparaciones entre
							    		  el valor que contenga la variable campo y el valor que
							    		  contenga esta viariable, es usada en las validaciones # 64
							    		  y 128
							  Validaciones y sus respctivos Numeros
							    	1	- Valida que no este vacio
							    	2	- Valida que sea de tipo texto
							    	4	- Valida que sea Numerico
							    	8	- Valida que sea una Fecha Valida
							    	16	- Valida si es un email, hace uso de la funcion es_email
							    	32	- Validaci�n personalizada, requiere un patron
							    	64	- Comparaci�n con otro valor, el valor a comparar esta
							    		  contenido en la variable $extra
							    	128 - Solo presenta un error en caso de que la variable $extra sea
							    		  True
							    	256 - Validaci�n de la URL, hace uso de la funcion verifurl

*******************************************************************************************************
*/

$msgerror = array();
$errores = array();

function verifurl($url,$real=0) {
	$patron = "/^((([a-z0-9])[a-z0-9\-]+\.)+((com|net|org|gov|gob|info|museum|biz|mil|aero)$|[a-z]{2})$)|([0-9]{1,3}\.){3}([0-9]{1,3})$/i";
	$partes = parse_url($url);
	if (preg_match($patron,$partes["host"])) {
		if ($real) {
			if ($fp=@fopen($url,"r")) {
				fclose($fp);
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	} else {
		return false;
	}
	
}

function urlfull($url) {
	$url = (preg_match("/^(http|ftp)(s)?:\/\//i",$url)) ? $url : "http://".$url;
	return $url;
}

function pushlogo($num,&$file) {
	if (is_numeric($num) && preg_match("/^image\/(jpg|jpeg|pjpeg)$/i",$file["type"])) {
		$size = getimagesize($file["tmp_name"]);
		if ($size[0]==200 && $size[1]==120) {
			return (@move_uploaded_file($file["tmp_name"],PATH_LOGO.$num.".jpg"));
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function cleanstring(&$arr) {
	$arr = htmlspecialchars($arr);
}

function quitaslash(&$arr) {
	$arr = stripslashes($arr);
}


	function es_email($email) {
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
	}

function err($campo,$mensaje) {
	global $msgerror,$errores;
	$msg=&$msgerror;
	$cam=&$errores;
	$msg[]=$mensaje;
	$cam[$campo]="ERR";
}

function ver($campo,$alias,$tipo,$patron="",$extra=0) {
	
	global $_POST, $_GET;
	
	// No vac�o
	if ($tipo & 1) {
		if (!isset($_POST[$campo]) || $_POST[$campo]=="") {
			err($campo,"El campo $alias no puede estar vacio");
		}
	}
	
	// Alfanumerico general
	if ($tipo & 2) {
		if (isset($_POST[$campo]) && $_POST[$campo]!="" && !(preg_match("/^[a-zA-Z0-9������ \\\'\\\"\/\.\,\_\-\(\)]+$/i",$_POST[$campo]))) {
			err($campo,"$alias debe de ser texto");
		}
	}
	
	// Numerico general
	if ($tipo & 4) {
		if (isset($_POST[$campo]) && $_POST[$campo]!="" && !(preg_match("/^[0-9]+$/",$_POST[$campo]))) {
			err($campo,"$alias debe de ser num�rico");
		}
	}
	
	// Fecha
	if ($tipo & 8) {
		if (isset($_POST[$campo]) && $_POST[$campo]!="") {
			$partes = explode("-",$_POST[$campo]);
			if (($partes[0]>2015 || $partes[0]<1700) || !checkdate($partes[1],$partes[2],$partes[0])) {
				err($campo,"$alias tiene que ser una fecha valida. Favor de verificarla");
			}
		}
	}
	
	// Email (depende de funcion externa)
	if ($tipo & 16) {
		if (isset($_POST[$campo]) && $_POST[$campo]!="" && !(es_email($_POST[$campo]))) {
			err($campo,"El campo $alias debe de ser una direcci�n de correo valida en la forma de nombre@dominio.extensi�n");
		}
	}
	
	// Regex Avanzado
	if ($tipo & 32) {
		if (isset($_POST[$campo]) && $_POST[$campo]!="" && !(@preg_match($patron,$_POST[$campo]))) {
			err($campo,"$alias no parece tener un formato valido");
		}
	}
	
	// Opciones diferente a valor "extra"
	if ($tipo & 64) {
		if (isset($_POST[$campo]) && $_POST[$campo]===$extra) {
			err($campo,"El campo $alias debe de tener seleccionada una opci�n valida");
		}
	}
	
	
	// Repetido
	if ($tipo & 128) {
		if ($extra == true) {
			err($campo,"El valor del campo $alias no puede ser usado debido a que actualmente se encuentra en uso");
		}
	}
	
	// URL
	if ($tipo & 256) {
		if (isset($_POST[$campo]) && $_POST[$campo]!="") {
			$_POST[$campo] = (preg_match("/^(http|ftp)(s)?/i",$_POST[$campo])) ? $_POST[$campo] : "http://".$_POST[$campo];
			if (!verifurl($_POST[$campo],$extra)) {
				err($campo,"El campo $alias debe de ser una direcci�n web valida");
			}
		}
	}
	
	return true;
}

$procesaOK = false;

?>