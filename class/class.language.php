<?php
require_once("class.db.php");
require_once("class.snippet.php");
class language
{
    private $languageId;
	private $languageShortName;
	private $languageDisplayName;
	
	//constructeur
    public function language($id){
		$this->languageId=$id;
		$this->languageDisplayName=$this->getDisplayName();
		$this->languageShortName=$this->getShortName();
    }
	public function disableLanguage(){
		$db=(new db())->bdd;
		//Effacer tous les snippets associés au langage qu'on désactive
		$sqlQuery=$db->prepare( 'DELETE FROM tblSnippets WHERE snipLangID='.$this->languageId);
        $sqlQuery->execute();
		//désactiver le langage choisi
		$sqlQuery=$db->prepare( 'UPDATE tblLanguage SET langEnabled=0, langPosition=0 WHERE PKlang='.$this->languageId);
		$sqlQuery->execute();
		$db=null;
	}
	public function addSnippet($title,$content,$tags=""){
		$db=(new db())->bdd;
		$title=htmlentities($title,ENT_QUOTES);
		$content=htmlentities($content,ENT_QUOTES);
		try{
			$req = $db->prepare("INSERT INTO
			tblSnippets (snipTitle, snipContent,snipLangID,snipTags) 
			VALUES(?, ?, ?, ?)");
			$req->execute(array($title, $content,$this->languageId,$tags));
		}catch(Exception $e){
			$db=null;
			return ("Erreur lors de l'ajout."+$e->getMessage());
		}
		return "OK";
	}
	public function changePositionInMenu($newPosition){
		if($newPosition>0){
			$db=(new db())->bdd;
			$sqlQuery=$db->prepare( 'UPDATE tblLanguage SET langPosition=? WHERE PKlang='.$this->languageId);
			$sqlQuery->execute(array($newPosition));
			$db=null;
		}
	}
	
	public function getSnippets(){
		if(isset($this->languageId)){
			$db=(new db())->bdd;
			$sqlQuery=$db->prepare( 'SELECT PKsnip FROM tblSnippets WHERE snipLangID='.$this->languageId);
        	$sqlQuery->execute();
			$snippets=$sqlQuery->fetchAll();
			
			$snips=array();
			foreach($snippets as $snippet){
				$oneSnippet=new snippet($snippet["PKsnip"]);
				array_push($snips,$oneSnippet);
			}
			$db=null;
			return $snips;
		}
	}
	public function getDisplayName($force=false){
		//Si force==true, on ignore le fait que le langage soit actif ou non
		if($force){
			$db=(new db())->bdd;
			$sqlQuery=$db->prepare( 'SELECT langDisplayName FROM tblLanguage WHERE PKlang='.$this->languageId);
        	$sqlQuery->execute();
			$displayName=$sqlQuery->fetchColumn();
			$db=null;
			$returnValue=$displayName;
		}else if(isset($this->languageDisplayName)){
			$returnValue=$this->languageDisplayName;
		}else{
			$db=(new db())->bdd;
			$sqlQuery=$db->prepare('SELECT langDisplayName FROM tblLanguage WHERE langEnabled=1 AND PKlang='.$this->languageId);
        	$sqlQuery->execute();
			$this->languageDisplayName=$sqlQuery->fetchColumn();
			$db=null;
			$returnValue=$this->languageDisplayName;
		}
		
		return $returnValue;
	}
	public function getShortName(){
		if(isset($this->languageShortName)){
			return $this->languageShortName;
		}else{
			$db=(new db())->bdd;
			$sqlQuery=$db->prepare( 'SELECT langShortName FROM tblLanguage WHERE langEnabled=1 AND PKlang='.$this->languageId);
			$sqlQuery->execute();
			$this->languageShortName=$sqlQuery->fetchColumn();
			$db=null;
			return $this->languageShortName;
		}
	}
	public function getCurrentPositionInMenu(){
		$db=(new db())->bdd;
		$sqlQuery=$db->prepare( 'SELECT langPosition FROM tblLanguage WHERE langEnabled=1 AND PKlang='.$this->languageId);
		$sqlQuery->execute();
		$positionInMenu=$sqlQuery->fetchColumn();
		$db=null;
		return $positionInMenu;
	}
	public function getLanguageId(){
		return $this->languageId;
	}
}
?>