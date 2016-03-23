<?php
require_once("class.db.php");
class snippet
{
	private $snipId;
	private $snippetTitle;
	private $snippetContent;
	private $snippetTags;
	private $snippetLanguageId;

	public function __construct($snipId){
		$this->snipId=$snipId;
	}
    // déclaration des méthodes
	public function deleteSnippet(){
		$db=(new db())->bdd;
		$sqlQuery=$db->prepare( 'DELETE FROM tblSnippets WHERE PKsnip='.$this->snipId);
		$sqlQuery->execute();
		$db=null;
	}
	
	public function modifySnippet($title,$content,$tags=""){
		$title=htmlentities($title,ENT_QUOTES);
		$content=htmlentities($content,ENT_QUOTES);
		try{
			$db=(new db())->bdd;
			$sqlQuery=$db->prepare( 'UPDATE tblSnippets SET snipTitle=?,snipContent=?,snipTags=? WHERE PKsnip='.$this->snipId);
			$sqlQuery->execute(array($title,$content,$tags));
			$db=null;
		}catch(Exception $e){
			return "Erreur lors de la modification".$e->getMessage();
		}
		return "OK";
	}
	
	public function getTitle(){
		if(isset($this->snippetTitle)){
			return $this->snippetTitle;
		}else{
			$db=(new db())->bdd;
			$sqlQuery=$db->prepare( 'SELECT snipTitle FROM tblSnippets WHERE PKsnip='.$this->snipId);
        	$sqlQuery->execute();
			$this->snippetTitle=$sqlQuery->fetchColumn();
			$db=null;
			return $this->snippetTitle;
		}
	}
	public function getContent(){
		if(isset($this->snippetContent)){
			return $this->snippetContent;
		}else{
			$db=(new db())->bdd;
			$sqlQuery=$db->prepare( 'SELECT snipContent FROM tblSnippets WHERE PKsnip='.$this->snipId);
        	$sqlQuery->execute();
			$this->snippetContent=$sqlQuery->fetchColumn();
			$db=null;
			return $this->snippetContent;
		}
	}
	public function getTags(){
		if(isset($this->snippetTags)){
			return $this->snippetTags;
		}else{
			$db=(new db())->bdd;
			$sqlQuery=$db->prepare( 'SELECT snipTags FROM tblSnippets WHERE PKsnip='.$this->snipId);
        	$sqlQuery->execute();
			$this->snippetTags=$sqlQuery->fetchColumn();
			$db=null;
			return $this->snippetTags;
		}
	}
	public function getLanguageId(){
		if(isset($this->snippetLanguageId)){
			return $this->snippetLanguageId;
		}else{
			$db=(new db())->bdd;
			$sqlQuery=$db->prepare( 'SELECT snipLangID FROM tblSnippets WHERE PKsnip='.$this->snipId);
        	$sqlQuery->execute();
			$this->snippetLanguageId=$sqlQuery->fetchColumn();
			$db=null;
			return $this->snippetLanguageId;
		}
	}
	public function getLanguage(){
		return new Language($this->getLanguageId());
		
	}
	public function getId(){
		return $this->snipId;
	}
}
?>