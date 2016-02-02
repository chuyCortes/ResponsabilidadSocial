<?php
$cargar_menu="menus/menu.principal.php";
$cargar_pagina_evarios="mod_principal/index.default.php";
$titulo="Portada";

$ltd_actividades_arr=$bd->query_arr("Select * from evento_fime_actividades order by dia_act, orden_act");
$totales_arr=$bd->query_arr("Select id_act, count(*) as total from evento_fime_seleccion group by id_act order by id_act");

foreach($totales_arr as $info_tmp){
	$txa[$info_tmp["id_act"]]=$info_tmp["total"];
}

include ("index.layout.sup.php");
include ("index.layout.inf.php");
?>