<?php
/*
***************************************************************************************************************
Finalidad de la Clase

Por medio de esta clase podemos realizar desde consultas simples hasta consultas personalizadas, a demas de que
tambien podemos agregar, actualizar o hasta eliminar registros usando esta clase

Nota: Requiere que el archivo constantes.php este previamente cargado, debido a que hace referencia a algunas
constantes supuestamente definidas en este archivo
***************************************************************************************************************
*/

/*
***************************************************************************************************************
Funciones y Parametros que componen esta Clase

Bdmysql()			-  Función Constructora por medio de la cual se crea la conexión a la Base de Datos
					   Indicada en las Constantes.
				
query_obj($query)	-  Funcion con la que se puede ejecutar una consulta SQL definida por el usuario, a
					   diferencia de los demas esta funcion regresa un objeto Recordset con el cual se
					   pueden usar las sentencias SQL sin ningun problema.
					   Parametros Utilizados
					     $query		- Variable que contiene la sentencia SQL definida por el Usuario
					     $rs		- Variable que sera regresada la cual representa el objeto Recordset

query_arr($query)	-  Funcion con la que se ejecuta una sentencia SQL y el resultado es almacenado en un
					   arreglo el cual contiene toda la información que se consiguio de la consulta.
					   Para accesar esta información se puede utilizar un Foreach
					   Parametros Utilizados
					     $query 	- Variable que contiene la sentencia SQL definida por el Usuario
					     $qry		-  Variable que almacena el resultado del Recordset
					     $rs		- Variable que contiene un arreglo el cual almacenara toda la información
									  obtenida del Recordset

query_col($query)	-  Funcion con la que se ejecuta una sentencia SQL y el resultado es almacenado en un
					   arreglo el cual contiene solo la primera columna de la información del Recordset.
					   Para accesar esta información se puede utilizar un Foreach
				 	   Parametros Utilizados
				 	     $query		-  Variable que contiene la sentencia SQL definida por el Usuario
				 	     $qry		-  Variable que almacena el resultado del Recordset
				 	     $rs		-  Variable que contiene un arreglo con la información del Recordset que se
				 	     			   va a devolver

query_row($query)	-  Funcion con la que se ejecuta una sentencia SQL y el resultado es almacenado en un
					   arreglo el cual contiene solo el primer renglon de la información del Recordset
					   Para accesar esta información se puede utilizar un Foreach
					   Parametros Utilizados
				 	     $query		-  Variable que contiene la sentencia SQL definida por el Usuario
				 	     $qry		-  Variable que almacena el resultado del Recordset
				 	     $rs		-  Variable que contiene un arreglo con la información del Recordset que se
				 	     			   va a devolver

query_uno($query)	-  Funcion con la que se ejecuta una sentencia SQL la cual le hace referencia a un solo
					   campo en una sola fila (ejemplo Select nombre from alumnos where id=2) esto es debido
					   a que la funcion solamente regresara un solo valor y es el que este almacenado en ese
					   momento en el recordset
					   Parametros Utilizados
				 	     $query		-  Variable que contiene la sentencia SQL definida por el Usuario
				 	     $qry		-  Variable que almacena el resultado del Recordset

contar($tabla,$criterio=false)
					-  Funcion con la que se ejecuta un query definido por la funcion con la cual se regresa
					   el numero total de registros contenidos en el Recordset
					   Parametros Utilizados
				 	     $tabla		-  Variable que contiene el nombre de la tabla en donde se realizara el query	
				 	     $criterio	-  Variable que contiene los criterios que se utilizaran en la Clausula
				 	     			   Where de la sentencia SQL, si no contiene nada no es tomada en cuenta
				 	     $qry		-  Variable que almacena el resultado del Recordset
				 	     $rs		-  Variable que se regresara con el numero de Registros encontrados en el
				 	     			   Recordset

agrega($query)		-  Funcion con la que se ejecuta una sentencia SQL de Inserción, con el cual se inserta
					   la información de un nuevo registro en la Base de Datos
					   Parametros Utilizados
				 	     $query		-  Variable que contiene la sentencia SQL definida por el Usuario
					     $insid		-  Variable que contiene el Id del registro que se acaba de agregar,
					     			   el cual es regresado al usuario

actualiza($query)	-  Funcion con la que se ejecuta una sentencia SQL de Actualización, con la cual se 
					   actualiza la información de un registro existente en la Base de Datos
					   Parametros Utilizados
				 	     $query		-  Variable que contiene la sentencia SQL definida por el Usuario
					     $cuantos	-  Variable que contiene el numero de registros afectados por la
					     			   actualizacion, este numero sera regresado al usuario
					     
elimina($tabla,$criterios)
					-  Funcion con la que se ejecuta un query definido por la funcion con la cual se elimina
					   un determinado registro de la tabla indicada, es de suma importancia indicar los
					   criterios debido a que si no se tiene cuidado con esta funcion se pueden eliminar
					   todos los registros
					   Parametros Utilizados
				 	     $tabla		-  Variable que contiene el nombre de la tabla en donde se realizara el query	
				 	     $criterio	-  Variable que contiene los criterios que se utilizaran en la Clausula
									   Where de la sentencia SQL
					     $cuantos	-  Variable que contiene el numero de registros afectados por la
					     			   eliminacion, este numero sera regresado al usuario
					     			   
correr($query)		-  Esta funcion es igual a la de query_obj pero esta funcion es para correr cualquier tipo
					   de query
					   Parametros Utilizados
					     $query		- Variable que contiene la sentencia SQL definida por el Usuario
					   	 $resid;	- Variable que sera regresada la cual representa el objeto Recordset

escapar($cadena)	-  Esta funcion es para convertir la cadena en una cadena segura para su uso en las
					   sentencias SQL, ejemplo, las comillas las convierte a sus respectivas representaciones
					   para su uso en el SQL
					   Parametros Utilizados
					     $cadena	- Variable que contiene la cadena que se va a convertir en una cadena segura
					     			  para su uso en el SQL
					     			  
Class _rs			-  Esta es una clase creada especificamente para el manejo de los recordset a traves del
					   Fetch Array

_rs(&$qry)			-  Funcion que se asignar el objeto recordset a una variable llamada del mismo nombre para
					   la cual es creada localmente en la misma clase
					   Parametros Utilizados
					     $qry		- Variable que contiene la sentencia SQL

fetch($tipo="array")-  Funcion que se encarga de regresar la informacion contenida en el recordset, ya sea a
					   traves de un mysql_fetch_array o un mysql_fetch_assoc
					   Parametros Utilizados
					     $tipo		- Variable que se utiliza para indicar como se desea devolver la
					     			  informacion, ya sea a traves de un Arreglo normal o atraves de un arreglo
					     			  asociado con la informacion de las columnas
					   
***************************************************************************************************************
*/

class Bdmysql {
	var $_cn;
	var $_res;
	
	// Constructor
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	// Actualización 15/06/2010
	// Le agrege el manejo de variables a travez del llamado del constructor para poder realizar varias
	// conexiones a diferentes Bases de Datos con la misma clase
	//////////////////////////////////////////////////////////////////////////////////////////////////////

	function Bdmysql($bd_per="") {
		$bd_per=(empty($bd_per)) ? _BD_ : $bd_per;
		$this->_cn = array("usr"=>_USR_,"pwd"=>_PWD_,"hst"=>_HST_,"bd"=>$bd_per);
		$this->_res= @mysql_connect($this->_cn["hst"],$this->_cn["usr"],$this->_cn["pwd"]);
		@mysql_select_db($this->_cn["bd"],$this->_res) or die ("Error DB :".mysql_error());
	}
	
	// =========================================================
	// PUBLICA
	// Corre un query y regresa un objeto (_rs) para hacer fetch
	// Ejemplo de uso:
	// $tal = $bd->query_obj("select * from tabla");
	// while ($fila = $tal->fetch()) {
	// 		//recorre la fila
	// }
	// =========================================================
	function query_obj($query) {
		if (stristr($query,"select") && $qry = @mysql_query($query)) {
			$rs = &new _rs($qry);
			return $rs;
		} else {
			// Disparar error
			$rs = &new _rs($qry);
			return $rs;
		}
	}
	
	// =========================================================
	// PUBLICA
	// Corre un query y regresa un array con todo el recordset
	// Ejemplo de uso:
	// $tal = $bd->query_arr("select * from tabla");
	// foreach ($tal as $fila) {
	// 		//recorre la fila
	// }
	// =========================================================
	function query_arr($query) {
		$rs = array();
		if (stristr($query,"select") && $qry = @mysql_query($query)) {
			while ($fila = mysql_fetch_assoc($qry)) {
				$rs[] = $fila;
			}
			@mysql_free_result($qry);
			return $rs;
		} else {
			// Disparar error
			return $rs;
		}
	}
	
	// =========================================================
	// PUBLICA
	// Corre un query y regresa un array con una columna
	// Sirve para traer un solo campo de multiples filas
	// Ejemplo de uso:
	// $tal = $bd->query_arr("select * from tabla");
	// foreach ($tal as $fila) {
	// 		//recorre la fila
	// }
	// =========================================================
	function query_col($query) {
		$rs = array();
		if (stristr($query,"select") && $qry = @mysql_query($query)) {
			while ($fila = mysql_fetch_row($qry)) {
				$rs[] = $fila[0];
			}
			@mysql_free_result($qry);
			return $rs;
		} else {
			// Disparar error
			return $rs;
		}
	}
	
	// =========================================================
	// PUBLICA
	// Corre un query y regresa un array con la primera fila del recordset
	// Ejemplo de uso:
	// $tal = $bd->query_row("select * from tabla");
	// $tal tiene ahora el array con la primera fila del resultado
	// =========================================================
	function query_row($query) {
		$rs = array();
		if (stristr($query,"select") && $qry = @mysql_query($query)) {
			if ($fila = @mysql_fetch_assoc($qry)) {
				$rs = $fila;
			}
			@mysql_free_result($qry);
			return $rs;
		} else {
			// Disparar error
			return $rs;
		}
	}
	
	// =========================================================
	// PUBLICA
	// Corre un query simple (un solo campo/fila) y regresa el valor
	// Ejemplo de uso:
	// $tal = $bd->query_uno("select status from tabla where id=1");
	// echo "el status es $tal";
	// =========================================================
	function query_uno($query) {
		if ($test = stristr($query,"select") && $qry = @mysql_query($query)) {
			if(@mysql_num_rows($qry)) {
				return mysql_result($qry,0);
			}
		}
		return false;
	}
	
	// =========================================================
	// PUBLICA
	// Cuenta las filas coincidentes con el criterio en la tabla
	// Ejemplo de uso:
	// $cuantos = $bd->contar("tabla","status=0");
	// =========================================================
	function contar($tabla,$criterio=false) {
		$rs = 0;
		$query = "SELECT count(*) FROM ".$tabla;
		$query.= ($criterio) ? " where ".$criterio : "";
		if ($qry = @mysql_query($query)) {
			$rs = mysql_result($qry,0);
			@mysql_free_result($qry);
		}
		return $rs;
	}
	
	function renglones($query){
		if ($test = stristr($query,"select") && $qry = @mysql_query($query)) {
			if(@mysql_num_rows($qry)) {
				return mysql_num_rows($qry);
			}
		}
		return false;
	}
	
	
	// =========================================================
	// PUBLICA
	// Corre un query tipo INSERT y regresa el ID asignado si hay uno
	// Ejemplo de uso:
	// $tal = $bd->agrega("insert into tabla (id,campo) values (NULL,'tal')");
	// echo "El nuevo registro es el Numero $tal";
	// =========================================================
	function agrega($query) {
		if (stristr($query,"insert") && $qry = @mysql_query($query)) {
			if ($insid = @mysql_insert_id($this->_res)) {
				return $insid;
			} else {
				return true;
			}
		} else {
			// Disparar error
			return false;
		}
	}
	
	// =========================================================
	// PUBLICA
	// Corre un query tipo UPDATE y regresa la cantidad de filas afectadas
	// Ejemplo de uso:
	// $tal = $bd->actualiza("update tabla set campo='valor' where id<100");
	// echo "Se modificaron $tal registros en la Base de datos";
	// =========================================================
	function actualiza($query) {
		if (stristr($query,"update") && $qry = @mysql_query($query)) {
			if ($cuantos = @mysql_affected_rows($this->_res)) {
				return $cuantos;
			} else {
				return true;
			}
		} else {
			// Disparar error
			return false;
		}
	}
	
	// =========================================================
	// PUBLICA
	// Corre un query tipo DELETE y regresa la cantidad de filas afectadas
	// Ejemplo de uso:
	// $tal = $bd->elimina("tabla","id=2");
	// echo "Se eliminaron $tal registros de la Base de datos";
	// =========================================================
	function elimina($tabla,$criterios) {
		$query = "delete from ".$tabla." where ".$criterios;
		if ($qry = @mysql_query($query)) {
			if ($cuantos = @mysql_affected_rows($this->_res)) {
				return $cuantos;
			} else {
				return true;
			}		
		} else {
			return false;
		}
	}
	
	// =========================================================
	// PUBLICA
	// Corre un query cualquiera y regresa el recurso creado por el query
	// Ejemplo de uso:
	// $tal = $bd->correr("select * from tabla");
	// $fila = mysql_fetch_array($tal);
	// =========================================================
	function correr($query) {
		$resid = @mysql_query($query);
		return $resid;
	}
	
	// =========================================================
	// PUBLICA
	// Escapa una cadena para que pueda incluirse en un query
	// de forma segura, evitando XSS
	// Ejemplo de uso:
	// $cadena_segura = $bd->escapar($cadena_insegura);
	// =========================================================
	function escapar($cadena) {
		if (!get_magic_quotes_gpc()) { 
		   return addslashes($cadena); 
		} else { 
		   return $cadena; 
		} 
	}
	
	function usuarios_online($ip,$url,$filtro=""){
		$timestamp = time(); 
		$timeout = $timestamp-180;		// cada 60 es 1 min.
		
		//Se inserta la Información del Nuevo Visitante
		$result=mysql_query("Insert into enlinea VALUES ('$timestamp','$ip','$url')");
		
		// Elimina los Registros que ya tienen mas de cierto tiempo de Inactividad		
		$result=mysql_query("Delete from enlinea where timestamp<$timeout");
		
		// Realiza un query para saber cual es el total de Gente en Linea
		(!empty($filtro))? $filtro="where url='". $filtro ."'" : "";
		$result = mysql_query("SELECT DISTINCT ip FROM enlinea ". $filtro);
		
		// El numero de Usuarios en Linea lo almacena en la variable $usuarios
		$usuarios = mysql_num_rows($result);
		
		// Regresa el valor
		return $usuarios;
	}
	
}

// =========================================================
// PRIVADA
// Clase abstracta para manejar recordsets via fetch
// =========================================================
class _rs {
	var $recordset;
	function _rs(&$qry) {
		$this->recordset = &$qry;
	}
	
	function fetch($tipo="array") {
		if ($tipo=="array") {
			if ($fila = @mysql_fetch_array($this->recordset)) {
				return $fila;
			} else {
				@mysql_free_result($this->recordset);
				return false;
			}
		} else {
			if ($fila = @mysql_fetch_assoc($this->recordset)) {
				return $fila;
			} else {
				@mysql_free_result($this->recordset);
				return false;
			}
		}
	}
}

?>
