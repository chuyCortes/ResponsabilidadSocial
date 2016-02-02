<?php

	////////////////////////////////////////// Información de los Errores //////////////////////////////////////////
	// Error 10.- Pertenece a la función de valida archivo e indica que el archivo no tiene una extensión valida
	//
	// Error 11.- Pertenece a la función de valida archivo e indica que el archivo pesa mas de lo permitido
	//
	// Error 12.- Pertenece a la función de valida archivo e indica que la validación de medidas no se puede
	//            llevar a cabo debido a que no es un formato de imagen permitido
	//
	// Error 13.- Pertenece a la función de valida archivo e indica que alguna de las medidas no es valida
	//
	// Error 21.- Pertenece a la función de subir archivo e indica que hubo un error al intentar subir el archivo
	//
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	Class Archivos{
	
		function valida_archivo($info_arch,$peso_max,$ext_validas,$medh_valida="",$medv_valida="",$crit_val=""){
			$id_error="";
			$ext_img=".jpg.jpeg.gif.png";
			
			$ext_archivo = strtolower(strrchr($info_arch["name"],'.'));
			$ext_aceptada=false;
			
			$ext_validas_array=split(";", $ext_validas);
			
			foreach($ext_validas_array as $ext_valida){
			  if(strtolower($ext_valida)==$ext_archivo){
				$ext_aceptada=true;
				break;
			  }
			}
			
			if($ext_aceptada){
				if($info_arch["size"]>$peso_max || empty($info_arch["size"])){
					$id_error=11;
				}
				
				if(!empty($medh_valida) || !empty($medv_valida)){
					
					if(strstr($ext_img, $ext_archivo)){
						
						$medh_validas_arr=split(";", $medh_validas);
						$crit_val=($crit_val==2 || $crit_val==1) ? $crit_val : 0;
						
						$med_img_arr=getimagesize($info_arch["tmp_name"]);
						
						switch($crit_val){
							case "1": // el 1 es >
								$medh_aceptada=(empty($medh_valida)) ? true : (($med_img_arr[0]>$medh_valida) ? true : false);
								$medv_aceptada=(empty($medv_valida)) ? true : (($med_img_arr[1]>$medv_valida) ? true : false);
							break;
							case "2": // el 2 es <
								$medh_aceptada=(empty($medh_valida)) ? true : (($med_img_arr[0]<$medh_valida) ? true : false);
								$medv_aceptada=(empty($medv_valida)) ? true : (($med_img_arr[1]<$medv_valida) ? true : false);
							break;
							default: // default es =
								$medh_aceptada=(empty($medh_valida)) ? true : (($med_img_arr[0]==$medh_valida) ? true : false);
								$medv_aceptada=(empty($medv_valida)) ? true : (($med_img_arr[1]==$medv_valida) ? true : false);
							break;
						}
						
						if(!$medh_aceptada || !$medv_aceptada){
							$id_error=13;
						}

					}else{
						$id_error=12;
					}
				}
				
			}else{
				$id_error=10;
			}
			
			return $id_error;
		}
		
		
		function subir_archivo($info_arch,$ruta_arch,$textra_arch="",$nper_arch=""){
			
			$ext_archivo = strtolower(strrchr($info_arch["name"],'.'));
		
			if(!empty($nper_arch)){
				$nombre_arch_tmp=$nper_arch;
			}else{
				$nombre_arch_tmp=date("dm-His").$textra_arch.$ext_archivo;
			}
			
			$nombre_arch=$ruta_arch.$nombre_arch_tmp;
			
			if(!copy($info_arch["tmp_name"], $nombre_arch)){
				$id_error=21;
			}else{
				$id_error=$nombre_arch_tmp;
			}
		
			return $id_error;
		
		}
		
		
		function elimina_archivo($ruta_arch,$nombre_arch){
			
			if(!empty($nombre_arch)){
				if(file_exists($ruta_arch.$nombre_arch)){
					unlink($ruta_arch.$nombre_arch);
				}
			}
		}
		
	}

?>