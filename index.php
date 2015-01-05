<?php 
include 'class/class.session.php'; 
Session::init();
if (!Session::isLogged()) {
	header('Location: login.php');
}

require_once( "func/base.php");
$pageTitle=_HOME;
head($pageTitle);

/* Setup */
$languages=new languages();

/* Get User Choice*/
if(isset($_GET['language'])){
	if(is_numeric($_GET['language'])){
		$choosenLanguage=$_GET['language'];
	}
}
?>

<body>
	<?php 
		if(!file_exists("data/data")){
			setup();
		}
		getLanguageSelector()
	?>
	<div id="main">
			<?php 
				
				if(isset($choosenLanguage)){
						$selectedLang=new Language($choosenLanguage);
						$langDisplayName=$selectedLang->getDisplayName();
						$langId=$selectedLang->getLanguageId();
						if($langDisplayName!=""){
							printf("<h1>%s: %s</h1>",_LANGUAGE, $langDisplayName);
							printf("<p class='addSnippet'><a href='addsnippet.php?lang=%d'>%s</a></p>",$langId,_ADD_SNIPPET);
							$snippetsForCurrentLanguage=$selectedLang->getSnippets();
							echo "<ul class='snipList'>";
							foreach($snippetsForCurrentLanguage as $snippet){
								echo "<li><a href='viewsnippet.php?snip=".$snippet->getId()."'>".$snippet->getTitle()."</a></li>\n";
							}
							echo "</ul>";
						}else{
							echo _INVALID_LANGUAGE;
						}
					}else if($languages->getAvailableLanguages()==array()){
						//Tous les langages sont désactivés dans les paramères...
						printf("<h1>%s</h1>",_ALL_LANGUAGES_DISABLED);
					}
				?>
		</div>
<?php foot();