<?php 
include 'class/class.session.php'; 
Session::init();
if (!Session::isLogged()) {
	header('Location: login.php');
}
require_once( "func/base.php"); 
$pageTitle=_ADD_NEW_SNIPPET; 
head($pageTitle);

/* Get User Choice*/
if(isset($_GET['lang'])){
	if(is_numeric($_GET['lang'])){
		$langId=$_GET['lang'];
		$language=new language($langId);
		if($language->getDisplayName()==""){
			$erreur=_ERR_INVALID_LANGUAGE;
		}
		if(isset($_POST['snipTitle'])&&isset($_POST['snipContent'])){
			$title=$_POST['snipTitle'];
			$content=$_POST['snipContent'];
			$language->addSnippet($title,$content);
			$resultat=_ADDED;
		}
	}else{
		$erreur=_ERR_INVALID_LANGUAGE;
	}
}
else{
		die(_ERR_INVALID_LANGUAGE);
	}
?>

<body>
	<?php getLanguageSelector() ?>
	<div id="main">
		<?php if(!isset($erreur)){ ?>
		<h1><?php echo $pageTitle." ".$language->getDisplayName() ?></h1>
		
			<form method="post">
				<p><?php echo _TITLE.":" ?></p>
				<p><input required type="text" name="snipTitle" autocomplete="off" /></p>
				<p><?php echo _CODE.":" ?></p>
				<textarea cols="80" rows="25" name="snipContent"></textarea>
				<p><input type="submit" value="<?php echo _ADD ?>" /></p>			
			</form>
			<?php if(isset($resultat)){echo $resultat;} ?>
		<?php }
		else{
			echo "<p>$erreur</p>";
		}
echo "</div>";
foot();