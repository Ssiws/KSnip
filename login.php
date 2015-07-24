<?php 
$bypassLoginCheck=true;
require_once("init.php");
$needToSetup=false;

if(!file_exists("data/data")){
	setup();
	$needToSetup=true;
}else{ //Le fichier de DB existe => vérification pour déterminer si un user existe
	$db=(new db())->bdd;
	$sqlQuery=$db->prepare( 'SELECT UserName,UserPassword FROM tblUser LIMIT 1');
	$sqlQuery->execute();
	$userinfos=$sqlQuery->fetchObject();
	$db=null;
	if($userinfos==false){
		$needToSetup=true;
	}
}

	if($needToSetup==true){
		if(!isset($_POST['login'])&&!isset($_POST['password'])&&!isset($_POST['passwordConfirm'])){
			$smarty->assign("needToSetup",true);
		}else if($_POST['password'] === $_POST['passwordConfirm']){
			try{
				$db=(new db())->bdd;
				$sqlQuery=$db->prepare( 'INSERT INTO tblUser VALUES (NULL,?,?)');
				$sqlQuery->execute(array($_POST['login'],password_hash($_POST['password'],PASSWORD_DEFAULT)));
				$db=null;
				$resultat="Login créé avec succès ! <a href='login.php'>Login !</a>";
				$smarty->assign("resultat",$resultat);
			}catch(Exception $e){
				$resultat="Erreur dans la création du login: ".$e->getMessage();
				$smarty->assign("resultat",$resultat);
			}
		}else{
			$resultat="Les mots de passe ne correspondent pas! <a href='./login.php'>Recommencer</a>";
			$smarty->assign("resultat",$resultat);
		}
		
	}else{
		if (isset($_POST['login']) &&
			isset($_POST['password']) &&
			Session::login($userinfos->UserName,
						   $userinfos->UserPassword,
						   $_POST['login'],
						   $_POST['password'] ))
		{
			header('Location: index.php');
		}
	}
	$smarty->display("login.tpl"); //Installation
?>
