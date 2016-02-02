<?php

Class Encripta{

	function parabd($info=""){
		if(!empty($info)){
			$info=base64_encode(_PC1_ .base64_encode($info)._PC2_);
		}
		return $info;
	}
	
	function paraweb($info=""){
		if(!empty($info)){
			$info=md5(date("d-m-Y") .$info);
		}
		return $info;
	}
	
	function desencriptabd($info=""){
		if(!empty($info)){
			$info=base64_decode($info);
			$info=str_replace(_PC1_,"",$info);
			$info=str_replace(_PC2_,"",$info);
			$info=base64_decode($info);
		}
		return $info;
	}

}

?>