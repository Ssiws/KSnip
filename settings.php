<?php 
include 'class/class.session.php'; 
Session::init();
if (!Session::isLogged()) {
	header('Location: login.php');
}
require_once( "func/base.php"); 
$pageTitle=_SETTINGS; 
head($pageTitle);

/* Setup */
$languages=new languages();

/* Get User Choice*/
if(isset($_POST['action'])){
	switch($_POST['action']){
		case "enableLanguages":
			if(isset($_POST['shortName']) && is_numeric($_POST['shortName'])){
				$shortName=$_POST['shortName'];
				$resultat=$languages->enableLanguage($shortName);
			}
			break;
		case "disableLanguages":
			if(isset($_POST['grl'])){
				if(is_numeric($_POST['grl'])){
					$languageToDelete=new language($_POST['grl']);
					$languageToDelete->disableLanguage();
					$languages->cleanupPositionCount(); //Remet de l'ordre dans le compteur des positions
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
?>

<body>
	<?php getLanguageSelector() ?>
	<div id="main">
		<h1><?php echo $pageTitle ?></h1>
		<div class='bloc'>
			<h2><?php echo _ENABLE_A_LANGUAGE?></h2>
			<?php writeEnableLanguageModule(); ?>
		</div>
		<div class='bloc'>
			<h2><?php echo _DISABLE_A_LANGUAGE?></h2>
			<?php writeDisableLanguageModule(); ?>
		</div>	
		<div class='bloc'>
			<h2><?php echo _REORG_MENU ?></h2>
			<?php writeReorgLanguageModule(); ?>
		</div>
		<div class='bloc'>
			<h2><?php echo _DL_EXT_TITLE ?></h2>
			<p><?php echo _DL_EXT ?></p>
			<p><?php echo _DL_EXT_DESCR ?></p>
		</div>
	</div>

<?php
function writeEnableLanguageModule(){
	global $languages;
	if(count($languages->getDisabledLanguages())==0){
		printf("<p>%s</p>",_NO_MORE_LANGUAGES_TO_ENABLE);
	}else{
		echo	'<form method="post">
				<input type="hidden" name="action" value="enableLanguages" />
				<select name="shortName" size="1">';
			foreach($languages->getDisabledLanguages() as $lang){
				echo "<option value='".$lang->getLanguageId()."'>".htmlentities($lang->getDisplayName(true))."</option>";
			}

	echo	'</select>
			<p><input type="submit" value="'._ENABLE.'" /></p>
			</form>';
	if(isset($resultat)){echo $resultat;}
	}
}
function writeDisableLanguageModule(){
	global $languages;
	echo	'<form method="post">
			<input type="hidden" name="action" value="disableLanguages" />';
	foreach($languages->getAvailableLanguages() as $lang){
		$langID=$lang->getLanguageId();				
		$langName=$lang->getDisplayName();
		echo"<p><input type='radio' name='grl' value='$langID' id='$langID'><label for='$langID'>$langName</label></p>";
	}
	echo "<p><input type='submit' value='"._DISABLE_AND_DELETE_SNIPPETS."'/></p>
	</form>";
}
function writeReorgLanguageModule(){
	global $languages;
	echo	'<form method="POST">
			<input type="hidden" name="action" value="reorgLanguages" />';
	foreach($languages->getAvailableLanguages() as $lang){
		$langID=$lang->getLanguageId();				
		$langName=$lang->getDisplayName();
		echo"<p><input type='submit' name='$langID-up' value='&#8593;'><input type='submit' name='$langID-dn' value='&#8595;'> $langName</p>";
	}
}
function changePos($language,$oldPosition,$targetPosition){
	global $languages;
	$languageAlreadyInTargetPos=$languages->getLanguageByPositionInMenu($targetPosition);
	if($languageAlreadyInTargetPos!=null){
		$languageAlreadyInTargetPos->changePositionInMenu($oldPosition);
		$language->changePositionInMenu($targetPosition);
	}
}
foot();