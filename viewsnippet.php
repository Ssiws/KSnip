<?php 
include 'class/class.session.php'; 
Session::init();
if (!Session::isLogged()) {
	header('Location: login.php');
}
require_once( "func/base.php"); 
$pageTitle=_SNIPPET ; 
head($pageTitle);

/* Setup */
$languages=new languages();

/* Get User Choice*/
if(isset($_GET['snip'])&&is_numeric($_GET['snip'])){
	try{
	$snippet=new Snippet($_GET['snip']);
	$language=new Language($snippet->getLanguageId());
	$languageShortName=$language->getShortName();
	}catch(Exception $e){
		$erreur=ERR_INVALID_SNIPPET;
	}
}else{
	$erreur=ERR_INVALID_SNIPPET;
}
?>

<body>
	<?php getLanguageSelector() ?>
	<div id="main">
		<h1><?php echo $pageTitle ?></h1>
		
		<?php
		if(!isset($erreur)){	
			printf("<p><h2>%s <a href='deletesnippet.php?snipId=%d'>%s</a> <a href='modifysnippet.php?snip=%d'>%s</a></h2></p>",$snippet->getTitle(),$_GET['snip'],_DELETE,$_GET['snip'],_EDIT);
				echo "<pre class='brush: $languageShortName; gutter: false; toolbar: false;'>";
				echo $snippet->getContent();
			}else{
				echo $erreur;
			}
			echo "</pre>";
			?>
		
	</div>
<?php foot();