<?php 
include 'class/class.session.php'; 
Session::init();
if (!Session::isLogged()) {
	header('Location: login.php');
}
require_once( "func/base.php"); 
$pageTitle=_DELETE_SNIPPET ; 
head($pageTitle);

/* Setup */
$languages=new languages();

/* Get User Choice*/
if(isset($_GET['snipId'])){
	if(is_numeric($_GET['snipId'])){
		$snippetToDelete=new snippet($_GET['snipId']);
	}
	if(isset($_POST['confirm'])){
		$langId=$snippetToDelete->getLanguageId();
		$snippetToDelete->deleteSnippet();
		header('Location: index.php?language='.$langId);
	}
}
?>

<body>
	<?php getLanguageSelector() ?>
	<div id="main">
		<h1><?php echo $pageTitle ?></h1>
		<form method="post">
			<input type="hidden" name="confirm"/>
			<?php
			if(isset($snippetToDelete)&&(!isset($resultat))){
				printf("%s: %s ?",_DELETE,$snippetToDelete->getTitle());
				echo "<p><input type='hidden' id='confirm'/></p>";
				printf("<input type='submit' value='%s'/>",_DELETE_THIS_SNIPPET);
			}
			?>
		</form>
	</div>
<?php foot();