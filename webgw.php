<?php
require_once( "class/class.languages.php");
require_once('locale/fr.php');

if(!isset($_POST['code'])||!isset($_POST['language'])||!isset($_POST['filename'])||!isset($_POST['token'])){
	echo _ERR_INVALID_PARAMS;
}else{
	$codeReceived=$_POST['code'];
	$languageOfFile=$_POST['language'];
	$fileName=$_POST['filename'];
	$tokenReceived=$_POST['token'];

	$db=(new db())->bdd;
	$sqlQuery=$db->prepare( 'SELECT UserPassword FROM tblUser LIMIT 1');
	$sqlQuery->execute();
	$userPass=$sqlQuery->fetchColumn();
	$db=null;
	$token=sha1($userPass);

	if($tokenReceived==$token){
		$languages=new languages();
		$lang=$languages->getLanguageByName($languageOfFile);
		if($lang!=null){
			$languages->enableLanguage($lang->getLanguageId()); //Activer le langage si ce n'est pas déjà le cas
			$lang->addSnippet("From Visual Studio: ".$fileName,urldecode($codeReceived));
			printf("%s: %s",_ADDED_TO,$lang->getDisplayName(true));
		}else{
			echo _ERR_INVALID_LANGUAGE;
		}
	}else{
		echo _ERR_INVALID_TOKEN;
	}
}
?>