<?php
require_once('func/base.php');
require_once( "class/class.languages.php"); 

$codeReceived=$_POST['code'];
$languageOfFile=$_POST['language'];
$fileName=$_POST['filename'];


$languages=new languages();
$lang=$languages->getLanguageByName($languageOfFile);
if($lang!=null){
	$languages->enableLanguage($lang->getLanguageId()); //Activer le langage si ce n'est pas déjà le cas
		
	$lang->addSnippet("From Visual Studio: ".$fileName,urldecode($codeReceived));
	printf("%s: %s",_ADDED_TO,$lang->getDisplayName(true));
}else{
	echo _ERR_INVALID_LANGUAGE;
}
?>