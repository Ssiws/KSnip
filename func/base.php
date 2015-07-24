<?php
require_once("locale/fr.php");
require_once("class/class.db.php");

function setup(){
	if(mkdir("data")){
		$db=new db();
		$db->setup();
	}else{
		echo "Impossible d'écrire dans ".realpath(".");
		die();
	}

}
?>