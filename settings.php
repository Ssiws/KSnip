<?php 
require("init.php");

$db=(new db())->bdd;
$sqlQuery=$db->prepare( 'SELECT UserPassword FROM tblUser LIMIT 1');
$sqlQuery->execute();
$userPass=$sqlQuery->fetchColumn();
$db=null;
$token=sha1($userPass);

/* Get User Choice*/
if(isset($_POST['action'])){
	switch($_POST['action']){
		case "enableLanguages":
			if(isset($_POST['shortName']) && is_numeric($_POST['shortName'])){
				$shortName=$_POST['shortName'];
				$resultat=languages::enableLanguage($shortName);
				$smarty->assign("resultat",$resultat);
			}
			break;
		case "disableLanguages":
			if(isset($_POST['grl'])){
				if(is_numeric($_POST['grl'])){
					$languageToDelete=new language($_POST['grl']);
					$languageToDelete->disableLanguage();
					languages::cleanupPositionCount(); //Remet de l'ordre dans le compteur des positions
				}
			}
			break;
		case "reorgLanguages":
			end($_POST); //Move the pointer to the end of array
			$operation=explode('-',key($_POST)); //clicked item. Format: languageID-up|dn e.g: 16-dn
			$idToMove=$operation[0];
			$direction=$operation[1];

			$languageToMove=new language($idToMove);
			$currentPosition=$languageToMove->getCurrentPositionInMenu();	
		if($direction=="up"){
			$newPosition=$currentPosition-1;
		}else{
			$newPosition=$currentPosition+1;
		}
			changePos($languageToMove,$currentPosition,$newPosition);
		break;
	}
}

$smarty->assign("token",$token);
$smarty->display("settings.tpl");

function changePos($language,$oldPosition,$targetPosition){
	if($targetPosition==0){
		$targetPosition=1;
	}
	if($targetPosition!=$oldPosition){
		$languageAlreadyInTargetPos=languages::getLanguageByPositionInMenu($targetPosition);
		if($languageAlreadyInTargetPos!=null){
			$languageAlreadyInTargetPos->changePositionInMenu($oldPosition);
			$language->changePositionInMenu($targetPosition);
		}
	}
}