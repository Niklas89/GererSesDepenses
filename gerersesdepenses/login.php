<?php
session_start();
if(!empty($_SESSION['id']))
{
  header('Location: index.php');
}

if(!empty($_POST))
{
  $valid = true;
  extract($_POST);
  
  if($valid)
  {
  try{
  $bdd = new PDO('mysql:host=localhost;dbname=gerersesdepenses', 'root', 'root') or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES utf8');
  }
  
  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  }
 

  $req = $bdd->prepare('SELECT * FROM users WHERE login=:login AND pass=:pass');
  $req->execute(array(
    'login'=>$login,
    'pass'=>md5($pass)
  ));
  $data = $req->fetch();
  if($req->rowCount()==0)
  {
    $valid = false;
    $erreurid = 'Mauvais identifiants';
  }
  

  else
  {
    if($req->rowCount()>0)
    {
      $_SESSION['users'] = $login;
      $_SESSION['id'] = $data['id'];
    }
  }
    
    $req->closeCursor();
    if($valid)
    {
      header('Location: profil.php');
    }
  
  }
}



/* 
  $req = $bdd->prepare('SELECT * FROM users WHERE login=:login AND pass=:pass');
  $req->execute(array(
    'login'=>$login,
    'pass'=>sha1($pass)
  ));
  $data = $req->fetch();
  if(empty($login) || empty($pass))
  {
    $valid = false;
    $erreurid = 'Mauvais identifiants';
  }
	if(!empty($login) || !empty($pass))
    {
	  $_SESSION['users'] = $login;
      header('Location: profil.php');
    }
  $req->closeCursor();
  }
}*/
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
	    <title>Gérer ses dépenses - login</title>
	    <meta name="author" content="Niklas Edelstam">
		
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		
		<script src="lib/jquery.js" type="text/javascript"></script>
		<script src="lib/jquery.validate.js" type="text/javascript"></script>
		
		<script type="text/javascript">
			$.validator.setDefaults({
				submitHandler: function() {  $(form).submit(); }
			});

			$().ready(function() {
			
				$("#commentForm").validate();

				// Validation quand on tab ou quand on envoie
				$("#signupForm").validate({
					rules: {
						login: {
							required: true
						},
						pass: {
							required: true
						},
					},
					messages: {
						pass: {
							required: "Entrez un mot de passe s'il vous plaît"
						},
						login: "Entrez votre pseudo valide s'il vous plaît"
					}
				});
			});
			</script>
		
	</head>
	<body>
  
	<div id="conteneur">
		<div id="formulaire">
			<?php if(isset($erreurid)) echo '<div class="erreurid">'.$erreurid.'</div>';?>
			<h3>Connectez-vous</h3>
			<form id="signupForm" action="login.php" method="post">
			  
			  <label for="login">Login :</label>
			  <input type="text" name="login" value="<?php if(isset($login)) echo $login;?>" />
		  
			  <label for="pass">Mot de passe :</label>
			  <input type="password" name="pass" value="<?php if(isset($pass)) echo $pass;?>" />
			  
			  <p><input type="submit" class="submit_button" value="Connexion" /></p>
			  
			</form>
			<p><a href="index.php">Revenir à l'accueil</a></p>
		</div>	
	 </div>
	</body>
</html>