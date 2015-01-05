<?php 
    include 'class/class.session.php'; Session::init();
	include 'class/class.db.php';
	require_once('func/base.php');
	head("Connexion");
	
	$needToSetup=false;
	if(!file_exists("data/data")){
		setup();
		$needToSetup=true;
	}
	$db=(new db())->bdd;
	$sqlQuery=$db->prepare( 'SELECT UserName,UserPassword FROM tblUser LIMIT 1');
	$sqlQuery->execute();
	$userinfos=$sqlQuery->fetchObject();
	$db=null;
	
	if($needToSetup==true||$userinfos==false){
		//No user
		if(!isset($_POST['wantedLogin'])&&!isset($_POST['wantedPassword'])&&!isset($_POST['wantedPasswordConfirm'])){
			$needToSetup=true;
		}else if($_POST['wantedPassword'] === $_POST['wantedPasswordConfirm']){
			try{
				$db=(new db())->bdd;
				$sqlQuery=$db->prepare( 'INSERT INTO tblUser VALUES (NULL,?,?)');
				$sqlQuery->execute(array($_POST['wantedLogin'],password_hash($_POST['wantedPassword'],PASSWORD_DEFAULT)));
				$db=null;
				$resultat="Login créé avec succès ! <a href='login.php'>Login !</a>";
			}catch(Exception $e){
				$resultat="Erreur dans la création du login: ".$e->getMessage();
			}
		}else{
			$resultat="Les mots de passe ne correspondent pas!";
		}
	}else{
		if (isset($_POST['login']) && isset($_POST['password']) && Session::login($userinfos->UserName, $userinfos->UserPassword,$_POST['login'], $_POST['password'] )) {
			header('Location: index.php');
		}
	}


	function AskCreateLogin(){
	echo <<<EOT
	<h1>Bienvenue !</h1>
	<p>Pour commencer, choisissez un nom d'utilisateur / mot de passe</p>
	<form id="loginForm" method="POST">
		<label>Login :</label><input type="text" name="wantedLogin" /><br>
      	<label>Password :</label><input type="password" name="wantedPassword" />
      	<label>Password :</label><input type="password" name="wantedPasswordConfirm" />
		<input type="submit" value="Go !" />
	</form>
EOT;
	}
	function ShowLoginForm(){
	echo <<<EOT
	<h1>Connexion </h1>
	<form id="loginForm" method="POST">
		<label>Login :</label><input type="text" name="login" /> <br>
      	<label>Password :</label><input type="password" name="password" />
		<input type="submit" value="Login" />
	</form>
EOT;
}
?>
   <div id="main">
    <?php
		if($needToSetup){
			AskCreateLogin();
		}else if(isset($resultat)){
			echo "<h1>Login</h1>";
			echo $resultat;
		}
		else{
			ShowLoginForm();
		}
	  ?>
    </div>
<?php foot();
