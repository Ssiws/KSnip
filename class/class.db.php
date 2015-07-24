<?php
//Gère la connexion à la base de données principale
class db
{
    public $bdd;
    public function db(){
        try{
			$this->bdd = new PDO('sqlite:data/data',null,null, array(PDO::ATTR_PERSISTENT => true));
			$this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch (Exception $e){
			die('Erreur de base de données : '.$e->getMessage());
		}
    }
	public function setup(){
		$bdd=$this->bdd;
		$sqlQuery=$bdd->prepare("
		CREATE TABLE IF NOT EXISTS \"tblSnippets\" (
			`PKsnip`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
			`snipLangID`	INTEGER NOT NULL,
			`snipContent`	TEXT,
			`snipTitle`	TEXT
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
			`UserPassword`	TEXT NOT NULL
		)");
		$sqlQuery->execute();
		
		$bdd->exec("INSERT INTO `tblLanguage` VALUES ('1','HTML','html','1','1');
		INSERT INTO `tblLanguage` VALUES ('2','C#','csharp','1','2');
		INSERT INTO `tblLanguage` VALUES ('3','PHP','php','1','3');
		INSERT INTO `tblLanguage` VALUES ('4','C++','cpp','0','0');
		INSERT INTO `tblLanguage` VALUES ('5','AppleScript','applescript','0','0');
		INSERT INTO `tblLanguage` VALUES ('6','ActionScript 3','as3','0','0');
		INSERT INTO `tblLanguage` VALUES ('7','Bash','bash','0','0');
		INSERT INTO `tblLanguage` VALUES ('8','Shell','shell','0','0');
		INSERT INTO `tblLanguage` VALUES ('9','ColdFusion','cf','0','0');
		INSERT INTO `tblLanguage` VALUES ('10','CSS','css','1','4');
		INSERT INTO `tblLanguage` VALUES ('11','Delphi','delphi','0','0');
		INSERT INTO `tblLanguage` VALUES ('12','Pascal','pascal','0','0');
		INSERT INTO `tblLanguage` VALUES ('13','Erlang','erlang','0','0');
		INSERT INTO `tblLanguage` VALUES ('14','Groovy','groovy','0','0');
		INSERT INTO `tblLanguage` VALUES ('15','Java','java','0','0');
		INSERT INTO `tblLanguage` VALUES ('16','JavaFX','jfx','0','0');
		INSERT INTO `tblLanguage` VALUES ('17','JavaScript','js','0','0');
		INSERT INTO `tblLanguage` VALUES ('18','Perl','pl','0','0');
		INSERT INTO `tblLanguage` VALUES ('19','Python','py','0','0');
		INSERT INTO `tblLanguage` VALUES ('20','Ruby','ruby','0','0');
		INSERT INTO `tblLanguage` VALUES ('21','Sass','sass','0','0');
		INSERT INTO `tblLanguage` VALUES ('22','Scala','scala','0','0');
		INSERT INTO `tblLanguage` VALUES ('23','SQL','sql','0','0');
		INSERT INTO `tblLanguage` VALUES ('24','VB','vb','0','0');
		INSERT INTO `tblLanguage` VALUES ('25','VB.net','vbnet','0','0');
		INSERT INTO `tblLanguage` VALUES ('26','Ada','ada','0','0');
		INSERT INTO `tblLanguage` VALUES ('27','Batch','bat','0','0');
		INSERT INTO `tblLanguage` VALUES ('28','F#','fsharp','0','0');
		INSERT INTO `tblLanguage` VALUES ('29','LaTeX','latex','0','0');
		INSERT INTO `tblLanguage` VALUES ('30','PowerShell','powershell','1','5');
		");
	}
}
?>