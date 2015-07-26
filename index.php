<?php 
require("init.php");

/* Get User Choice*/
if(isset($_GET['language'])){
	if(is_numeric($_GET['language'])){
		$choosenLanguage=$_GET['language'];
	}
}

if(isset($_GET['mode'])){
	$mode=$_GET['mode'];
}else{
	$mode="";
}
switch($mode){
	case "addsnippet":
		if(isset($choosenLanguage)){
			$selectedLang=new Language($choosenLanguage);
			$smarty->assign("selectedLanguage",$selectedLang);
			if(isset($_POST['snipTitle']) && isset($_POST['snipContent'])){
				$title=$_POST['snipTitle'];
				$content=$_POST['snipContent'];
				
				$tags=$_POST['snipTags'];
				$tagsCleanup=explode(";",$tags);
				for($i=0;$i<count($tagsCleanup);$i++){
					$tagsCleanup[$i]=trim($tagsCleanup[$i]);	
				}
				$tags=implode(";",$tagsCleanup);
				$tags=trim($tags,";");
				
				$tags=$_POST['snipTags'];
				$result=$selectedLang->addSnippet($title,$content,$tags);
				$smarty->assign("result",$result);
			}
		}
		$smarty->display("addsnippet.tpl");
		break;
	case "viewsnippet":
		if(isset($_GET['snip'])&&is_numeric($_GET['snip'])){
			try{
			$snippet=new Snippet($_GET['snip']);
			$language=new Language($snippet->getLanguageId());
			$languageShortName=$language->getShortName();
			
			$smarty->assign("language",$languageShortName);
			$smarty->assign("snippet",$snippet);
			$smarty->display("viewsnippet.tpl");
			}catch(Exception $e){
				echo _ERR_INVALID_SNIPPET;
			}
		}
		break;
	case "deletesnippet":
		if(isset($_GET['snipId'])){
			if(is_numeric($_GET['snipId'])){
				$snippetToDelete=new snippet($_GET['snipId']);
				$smarty->assign("snippetToDelete",$snippetToDelete);
				$smarty->display("deletesnippet.tpl");
			}
		}
		if(isset($_POST['confirm'])){
			$langId=$snippetToDelete->getLanguageId();
			$snippetToDelete->deleteSnippet();
			header('Location: index.php?language='.$langId);
		}
		break;
	case "editsnippet":
		if(isset($_GET['snip'])){
			if(is_numeric($_GET['snip'])){
				if(isset($_POST['snipTitle'])&&isset($_POST['snipContent'])){
					$snippet=new snippet($_GET['snip']);
					$title=$_POST['snipTitle'];
					$content=$_POST['snipContent'];
					
					$tags=$_POST['snipTags'];
					$tagsCleanup=explode(";",$tags);
					for($i=0;$i<count($tagsCleanup);$i++){
						$tagsCleanup[$i]=trim($tagsCleanup[$i]);	
					}
					$tags=implode(";",$tagsCleanup);
					$tags=trim($tags,";");
					
					$resultat=$snippet->modifySnippet($title,$content,$tags);
					$smarty->assign("resultat",$resultat);
				}
				$snippetToEdit=new snippet($_GET['snip']);
				$smarty->assign("snippetToEdit",$snippetToEdit);
				$smarty->display("editsnippet.tpl");
			}
		}
		if(isset($_POST['confirm'])){
			$langId=$snippetToDelete->getLanguageId();
			$snippetToDelete->deleteSnippet();
			header('Location: index.php?language='.$langId);
		}
		break;
	default:
		if(isset($choosenLanguage)){
			$selectedLang=new Language($choosenLanguage);
			$smarty->assign("selectedLanguage",$selectedLang);
			$smarty->assign("wantedTag","");
			if(isset($_GET['tag'])){
				$smarty->assign("wantedTag",$_GET['tag']);
			}
		}
		$smarty->display("index.tpl");
		break;
}

?>
