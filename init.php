<?php
require_once('locale/fr.php');
require_once('vendor/smarty/libs/Smarty.class.php');
require_once 'class/class.db.php'; 
require_once 'class/class.session.php'; 
require_once 'class/class.languages.php';

Session::init();
if(!isset($bypassLoginCheck)){
	if (!Session::isLogged()) {
		header('Location: login.php');
	}
}

class SmartySnip extends Smarty{
	function SmartySnip(){
		parent::__construct(); 
	    $this->template_dir = 'templating/templates/';
	    $this->compile_dir  = 'templating/templates_c/';
	    $this->config_dir   = 'templating/configs/';
	    $this->cache_dir    = 'templating/cache/';
	    $this->caching = false;
	}
}
$smarty=new SmartySnip();
//** un-comment the following line to show the debug console
//$smarty->debugging = true;

function CheckSetup(){
	$mustSetup=false;
	//Création du répertoire data s'il n'existe pas
	if(!is_dir("data")){
		if(!mkdir("data")){
			echo "Impossible d'écrire dans ".realpath(".");
			die();
		}
		$mustSetup=true;
	}
	//vérification de l'existence d'un fichier dbid, s'il n'existe pas on le créé
	if(glob("data/*.dbid")!=null){
		$file=glob("data/*.dbid")[0];
	    $dbId=trim(explode('/',$file)[1],".dbid");
	    
	    if(!file_exists("data/$dbId")){ 
			$mustSetup=true;
			$mustCreateLogin=true;
	    }else{
	    	//la DB existe,vérification pour déterminer si un user existe 
	    	$db=(new db())->bdd;
			$sqlQuery=$db->prepare( 'SELECT UserName,UserPassword FROM tblUser LIMIT 1');
			$sqlQuery->execute();
			$userinfos=$sqlQuery->fetchObject();
			$db=null;
			if($userinfos==false){
				$mustCreateLogin=true;
			}
	    }
	}else{
		$guid=getGUID();
		$file = fopen("data/$guid.dbid", 'w') or die("Impossible d'écrire dans ".realpath("."));
		fclose($file);
		$mustSetup=true;
		$mustCreateLogin=true;
		$dbid=$guid;
	}
	if($mustSetup==true){
		$db=new db();
		$db->setup();
	}
	if(isset($mustCreateLogin)){
		return "AskCreateLogin";
	}
}

function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}