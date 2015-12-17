<?php 
$bypassLoginCheck=true;
require_once("init.php");

if(CheckSetup()=="AskCreateLogin"){
	
	if(isset($_POST['login'])&&isset($_POST['password'])&&isset($_POST['passwordConfirm'])){
		if($_POST['password'] === $_POST['passwordConfirm']){
			try{
				$db=(new db())->bdd;
				$sqlQuery=$db->prepare( 'INSERT INTO tblUser VALUES (NULL,?,?,?)');
				$sqlQuery->execute(array($_POST['login'],password_hash($_POST['password'],PASSWORD_DEFAULT),"fr"));
				$db=null;
				$resultat="Login créé avec succès ! <a href='login.php'>Cliquez ici pour vous connecter.</a>";
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
		$smarty->assign("mustCreateLogin",true);	
	}
}else{
		$db=(new db())->bdd;
		$sqlQuery=$db->prepare( 'SELECT UserName,UserPassword FROM tblUser LIMIT 1');
		$sqlQuery->execute();
		$userinfos=$sqlQuery->fetchObject();
		$db=null;
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

$smarty->display("login.tpl");
?>
