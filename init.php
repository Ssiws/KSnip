<?php
require_once( "func/base.php");
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