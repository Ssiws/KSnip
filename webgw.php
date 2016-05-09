<?php
require_once( "class/class.languages.php");
require_once('locale/fr.php');

if (isset($_POST['action']) && isset($_POST['token'])) {
	$action=$_POST['action'];
}else{
	if(!isset($_POST['token'])){
		echo _ERR_INVALID_PARAMS;
		die();
	}
}

switch ($action) {
	case 'check':
		echo "OK";
		break;
	case 'AddSnippet':
		AddSnippet();
		break;
	case 'GetSnippets':
		if (!isset($_POST['language'])) {
			echo _ERR_INVALID_PARAMS;
		}else{
			$languageOfFile=$_POST['language'];
			$tokenReceived=$_POST['token'];
			if (CheckTokenValidity($tokenReceived)) {
				$languages=new languages();
				$lang=$languages->getLanguageByName($languageOfFile);
				if($lang!=null){
					$wantedSnippets=$lang->getSnippets();
					foreach ($wantedSnippets as $oneSnippet) {
						echo html_entity_decode("&para;BEGIN-SNIPSNIP&para;\r\n");
						echo '<?xml version="1.0" encoding="utf-8"?>';			
						echo '<CodeSnippets xmlns="http://schemas.microsoft.com/VisualStudio/2005/CodeSnippet">';
							echo '<CodeSnippet Format="1.0.0">';
								echo '<Header>';
									echo '<Title>'.html_entity_decode($oneSnippet->getTitle(), ENT_QUOTES).'</Title>';
								echo '</Header>';
								echo '<Snippet>';
									echo '<Code Language="'.$languageOfFile.'">';
										echo '<![CDATA['.html_entity_decode($oneSnippet->getContent(), ENT_QUOTES).']]>';
									echo '</Code>';
								echo '</Snippet>';
							echo '</CodeSnippet>';
						echo "</CodeSnippets>\r\n";
					}
				}else{
					echo _ERR_INVALID_LANGUAGE;
				}
			}else{
				echo _ERR_INVALID_TOKEN;
			}
		}
		break;

	default: //Par défaut, on suppose que l'utilisateur veut rajouter un snippet (ancienne version de l'extension VisualStudio peut-être)
			AddSnippet();
		break;
}


function CheckTokenValidity($tokenProvided){
	$db=(new db())->bdd;
	$sqlQuery=$db->prepare( 'SELECT UserPassword FROM tblUser LIMIT 1');
	$sqlQuery->execute();
	$userPass=$sqlQuery->fetchColumn();
	$db=null;
	$token=sha1($userPass);
	if($tokenProvided==$token){
		return true;
	}else{
		sleep(1);
		return false;
	}
}

function AddSnippet(){
	if(!isset($_POST['code'])||!isset($_POST['language'])||!isset($_POST['filename'])||!isset($_POST['token'])){
			echo _ERR_INVALID_PARAMS;
		}else{
			$codeReceived=$_POST['code'];
			$languageOfFile=$_POST['language'];
			$fileName=$_POST['filename'];
			$tokenReceived=$_POST['token'];

			if(CheckTokenValidity($tokenReceived)){
				$languages=new languages();
				$lang=$languages->getLanguageByName($languageOfFile);
				if($lang!=null){
					$languages->enableLanguage($lang->getLanguageId()); //Activer le langage si ce n'est pas déjà le cas
					$lang->addSnippet($fileName, $codeReceived);
					printf("%s: %s",_ADDED_TO,$lang->getDisplayName(true));
				}else{
					echo _ERR_INVALID_LANGUAGE;
				}
			}else{
				echo _ERR_INVALID_TOKEN;
			}
		}
}
?>