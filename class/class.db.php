<?php
//Gère la connexion à la base de données principale
class db
{
    public $bdd;
    public function __construct(){
        try{
    		$file=glob("data/*.dbid")[0];
    		$dbId=trim(explode('/',$file)[1],".dbid");
			$this->bdd = new PDO("sqlite:data/$dbId",null,null, array(PDO::ATTR_PERSISTENT => true));
			$this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			checkIfUpgrade1Needed();
		}catch (Exception $e){
			die('Erreur de base de données : '.$e->getMessage());
		}
    }
	
	private function checkIfUpgrade1Needed(){
		$sqlQuery=$this->bdd->prepare('SELECT count(*) FROM tblLanguage WHERE langShortName=xaml');
		$sqlQuery->execute();
		$isXAMLExisting=$sqlQuery->fetchColumn();
		if($isXAMLExisting >= 1){
			return false;
		}else{
			$this->bdd->exec("INSERT INTO `tblLanguage` VALUES ('35','XAML','xaml','0','0');");
		}
	}
	
	public function setup(){
		$bdd=$this->bdd;
		$sqlQuery=$bdd->prepare("
		CREATE TABLE IF NOT EXISTS \"tblSnippets\" (
			`PKsnip`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
			`snipLangID`	INTEGER NOT NULL,
			`snipContent`	TEXT,
			`snipTitle`	TEXT,
			`snipTags`	TEXT
		);");
		$sqlQuery->execute();
		
		$sqlQuery=$bdd->prepare("CREATE TABLE IF NOT EXISTS \"tblLanguage\" (
			`PKlang`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
			`langDisplayName`	TEXT NOT NULL UNIQUE,
			`langShortName`	TEXT NOT NULL UNIQUE,
			`langEnabled`	INTEGER NOT NULL,
			`langPosition`	INTEGER NOT NULL
		)");
		$sqlQuery->execute();
		
		$sqlQuery=$bdd->prepare("CREATE TABLE IF NOT EXISTS \"tblUser\" (
			`PKUser`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
			`UserName`	TEXT NOT NULL,
			`UserPassword`	TEXT NOT NULL,
			`UserLanguage`	TEXT NOT NULL
		)");
		$sqlQuery->execute();
		
		$bdd->exec("INSERT INTO `tblLanguage` VALUES ('1','HTML','html','1','1');
		INSERT INTO `tblLanguage` VALUES ('2','C#','csharp','1','2');
		INSERT INTO `tblLanguage` VALUES ('3','PHP','php','1','3');
		INSERT INTO `tblLanguage` VALUES ('4','C++','c_cpp','0','0');
		INSERT INTO `tblLanguage` VALUES ('5','AppleScript','applescript','0','0');
		INSERT INTO `tblLanguage` VALUES ('6','ActionScript','actionscript','0','0');
		INSERT INTO `tblLanguage` VALUES ('7','Bash','sh','0','0');
		INSERT INTO `tblLanguage` VALUES ('8','Makefile','makefile','0','0');
		INSERT INTO `tblLanguage` VALUES ('9','ColdFusion','coldFusion','0','0');
		INSERT INTO `tblLanguage` VALUES ('10','CSS','css','1','4');
		INSERT INTO `tblLanguage` VALUES ('11','D','d','0','0');
		INSERT INTO `tblLanguage` VALUES ('12','Pascal','pascal','0','0');
		INSERT INTO `tblLanguage` VALUES ('13','Erlang','erlang','0','0');
		INSERT INTO `tblLanguage` VALUES ('14','Groovy','groovy','0','0');
		INSERT INTO `tblLanguage` VALUES ('15','Java','java','0','0');
		INSERT INTO `tblLanguage` VALUES ('16','Less','less','0','0');
		INSERT INTO `tblLanguage` VALUES ('17','JavaScript','javascript','0','0');
		INSERT INTO `tblLanguage` VALUES ('18','Perl','perl','0','0');
		INSERT INTO `tblLanguage` VALUES ('19','Python','python','0','0');
		INSERT INTO `tblLanguage` VALUES ('20','Ruby','ruby','0','0');
		INSERT INTO `tblLanguage` VALUES ('21','Sass','sass','0','0');
		INSERT INTO `tblLanguage` VALUES ('22','Scala','scala','0','0');
		INSERT INTO `tblLanguage` VALUES ('23','SQL','sql','0','0');
		INSERT INTO `tblLanguage` VALUES ('24','VB','vbscript','0','0');
		INSERT INTO `tblLanguage` VALUES ('25','Lisp','lisp','0','0');
		INSERT INTO `tblLanguage` VALUES ('26','Ada','ada','0','0');
		INSERT INTO `tblLanguage` VALUES ('27','Batch','batchfile','0','0');
		INSERT INTO `tblLanguage` VALUES ('28','Matlab','matlab','0','0');
		INSERT INTO `tblLanguage` VALUES ('29','LaTeX','latex','0','0');
		INSERT INTO `tblLanguage` VALUES ('30','PowerShell','powershell','1','5');
		INSERT INTO `tblLanguage` VALUES ('31','Smarty','smarty','0','0');
		INSERT INTO `tblLanguage` VALUES ('32','Objective-C','objectivec','0','0');
		INSERT INTO `tblLanguage` VALUES ('33','Assembly-x86','assembly_x86','0','0');
		INSERT INTO `tblLanguage` VALUES ('34','VHDL','vhdl','0','0');
		INSERT INTO `tblLanguage` VALUES ('35','XAML','xaml','0','0');
		");
	}
}
?>