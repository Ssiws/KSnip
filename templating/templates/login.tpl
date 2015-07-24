<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'> 
		<meta http-equiv='X-UA-Compatible' content='IE=edge' />
		<title>Connexion</title>
		<style type='text/css'>
			@import url('style/style.css');
		</style>
	</head>
   <div id="main">
	<h1>Connexion </h1>
	{if isset($resultat)}
		<p>{$resultat}</p>
	{else}
	<form id="loginForm" method="POST">
		{if isset($needToSetup)}
			<p>Pour commencer, choisissez un nom d'utilisateur et un mot de passe</p>
		{/if}
		<label>Login :</label><input required type="text" name="login" /> <br />
	  	<label>Password :</label><input required type="password" name="password" /><br />
  		{if isset($needToSetup)}
			<label>Password :</label><input required type="password" name="passwordConfirm" /><br />
		{/if}
  		{if isset($needToSetup)}
			<input type="submit" value="C'est parti !" id="registerButton" />
		{else}
			<input type="submit" value="Connexion" id="registerButton" />
		{/if}
		
	</form>
	{/if}
	
</div>