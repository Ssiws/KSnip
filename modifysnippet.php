<?php 
include 'class/class.session.php'; 
Session::init();
if (!Session::isLogged()) {
	header('Location: login.php');
}
require_once( "func/base.php"); 
$pageTitle=_EDIT_SNIPPET ; 
head($pageTitle);


/* Get User Choice*/
if(isset($_GET['snip'])){
	if(is_numeric($_GET['snip'])){
		$snipId=$_GET['snip'];
		$snippet=new snippet($snipId);
		if($snippet->getTitle()==""){
			$erreur=_ERR_INVALID_SNIPPET;
		}
		if(isset($_POST['snipTitle'])&&isset($_POST['snipContent'])){
			$title=$_POST['snipTitle'];
			$content=$_POST['snipContent'];
			$resultat=$snippet->modifySnippet($title,$content);
			//Il faut réinstancier le snippet qu'on viens de modifier pour que les modification soient visible quand user valide
			// sinon, ancien texte
			$snippet=new snippet($snipId);
		}
		
		$actualTitle=str_replace("'","\'",(html_entity_decode($snippet->getTitle())));
		$actualContent=$snippet->getContent();
	}else{
		$erreur=_ERR_INVALID_SNIPPET;
	}
}
else{
		$erreur=_ERR_INVALID_SNIPPET;
	}
?>

<body>
	<?php getLanguageSelector() ?>
	<div id="main">
		<?php if(!isset($erreur)){ ?>
		<h1><?php echo $pageTitle.": ".$snippet->getTitle() ?></h1>
		
			<form method="post">
				<p><?php echo _TITLE.":" ?></p>
				<?php echo "<p><input required type='text' name='snipTitle' value='".$actualTitle."'/></p>"; ?>
				<p><?php echo _CODE.":" ?></p>
				<textarea cols="80" rows="25" name="snipContent"><?php echo $actualContent ?></textarea>
				<p><input type="submit" value="<?php echo _EDIT ?>" /></p>			
			</form>
			<?php if(isset($resultat)){echo $resultat;} ?>
		<?php }
		else{
			echo "<p>$erreur</p>";
		}
echo "</div>";
foot();