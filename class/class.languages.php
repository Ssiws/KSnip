<?php
require_once("class.db.php");
require_once("class.snippet.php");
require_once("class.language.php");
//Gestion des languages de programmation
class languages
{
	//constructeur
    public function languages(){
    }
	
    public function getAvailableLanguages() {
		$db=(new db())->bdd;
		$sqlQuery=$db->prepare('SELECT * FROM tblLanguage WHERE langEnabled=1 ORDER BY langPosition ASC');
        $sqlQuery->execute();
		$languagesFromDb=$sqlQuery->fetchAll();
		$languages=array(); //contiendra les objets de type "language"
		foreach($languagesFromDb as $oneLanguageFromDb){
			$language=new language($oneLanguageFromDb["PKlang"]);
			array_push($languages,$language);
		}
		$db=null;
		return $languages;
	}
	
	public function getDisabledLanguages() {
		$db=(new db())->bdd;
		$sqlQuery=$db->prepare('SELECT * FROM tblLanguage WHERE langEnabled=0 ORDER BY langShortName');
        $sqlQuery->execute();
		$languagesFromDb=$sqlQuery->fetchAll();
		$languages=array(); //contiendra les objets de type "language"
		foreach($languagesFromDb as $oneLanguageFromDb){
			$language=new language($oneLanguageFromDb["PKlang"]);
			array_push($languages,$language);
		}
		$db=null;
		return $languages;
	}
	
	public function getLanguageByName($name){
		$db=(new db())->bdd;
		$sqlQuery=$db->prepare('SELECT PKlang FROM tblLanguage WHERE langShortName="'.$name.'"');
        $sqlQuery->execute();
		$requestedLanguageId=$sqlQuery->fetchColumn();
		$db=null;
		if($requestedLanguageId!=null){
			return new language($requestedLanguageId);
		}else{
			return null;
		}
	}
	
	public function getLanguageByPositionInMenu($pos){
		$db=(new db())->bdd;
		$sqlQuery=$db->prepare('SELECT PKlang FROM tblLanguage WHERE langPosition="'.$pos.'"');
        $sqlQuery->execute();
		$requestedLanguageId=$sqlQuery->fetchColumn();
		$db=null;
		if($requestedLanguageId==""){
			return null;
		}
		return new language($requestedLanguageId);
	}
	
	public function enableLanguage($langId){
		if(is_numeric($langId)){
			$nextPositionInMenu=$this->getNextPositionCount();
			$db=(new db())->bdd;
			$req = $db->prepare('UPDATE tblLanguage SET langEnabled=1,langPosition=? WHERE PKlang=? AND langEnabled=0');
			$req->execute(array($nextPositionInMenu,$langId));
			$db=null;
			return "Terminé !";
		}
	}
	
	private function getNextPositionCount(){
		$db=(new db())->bdd;
		$sqlQuery=$db->prepare('SELECT langPosition FROM tblLanguage WHERE langEnabled=1 ORDER BY langPosition DESC LIMIT 1');
		$sqlQuery->execute();
		$lastPos=$sqlQuery->fetchColumn();
		$db=null;
		return $lastPos+1;
	}
	public function cleanupPositionCount(){
		$count=1;
		foreach ($this->getAvailableLanguages() as $lang){
			$lang->changePositionInMenu($count);
			$count++;
		}
		
	}
}
?>