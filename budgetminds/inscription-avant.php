<?php
session_start();


if(!empty($_POST))
{
  extract($_POST);
  $valid = true;
  
	include 'config.php';
  
  
  $req = $bdd->prepare('SELECT id FROM users WHERE login=:nom');
  $req->execute(array('nom'=>$nom));
  if($req->rowCount()>0)
  {
    $valid = false;
    $erreurid = 'Ce pseudo est déjà pris';
  }
  
  $req = $bdd->prepare('SELECT id FROM users WHERE email=:email');
  $req->execute(array('email'=>$email));
  if($req->rowCount()>0)
  {
    $valid = false;
    $erreurid = 'Cette adresse e-mail est déjà utilisée par un membre';
  }
  $req->closeCursor(); //Ne pas oublier de fermer la requete une fois que c'est fini
  
  if($valid)
  {
	$ip = $_SERVER['REMOTE_ADDR'];
    $req = $bdd->prepare('INSERT INTO users (login,pass,email,lname,fname,ip) VALUES (:nom,:pass,:email,:lname,:fname,:ip)');
    $req->execute(array(
	  'nom'=>$nom,	
      'pass'=>md5($pass),
      'email'=>$email,
	  'lname'=>$lname,
	  'fname'=>$fname,
	  'ip'=>$ip
    ));
    
    $req->closeCursor();
    $ok = 'Inscription réussie. Vous pouvez maintenant <a href="login.php">vous connecter</a>.';
	unset($nom);
    unset($email);
	unset($lname);
	unset($fname);
	unset($ip);
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title>Gérer ses dépenses - inscription</title>
		<meta name="author" content="Niklas Edelstam">
		
		
		<script src="lib/jquery.js" type="text/javascript"></script>
		<script src="lib/jquery.validate.js" type="text/javascript"></script>
		
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		
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
						lname: {
							required: true
						},
						fname: {
							required: true
						},
						pass: {
							required: true,
							minlength: 5
						},
						confirm_password: {
							required: true,
							minlength: 5,
							equalTo: "#pass"
						},
						email: {
							required: true,
							email: true
						}
						
					},
					messages: {
						
						lname: {
							required: "Entrez votre nom s'il vous plaît"
						},
						fname: {
							required: "Entrez votre prénom s'il vous plaît",
						},
						pass: {
							required: "Entrez un mot de passe s'il vous plaît",
							minlength: "Votre mot de passe doit avoir au moins 5 caractères"
						},
						confirm_password: {
							required: "Entrez un mot de passe s'il vous plaît",
							minlength: "Votre mot de passe doit comporter au moins 5 caractères",
							equalTo: "Entrez le même mot de passe s'il vous plaît"
						},
						email: "Entrez une adresse mail valide s'il vous plaît"
					}
				});
			});
			</script>
		
	</head>
	
	<body>
	  <div id="conteneur">
		<div id="formulaire">
			<?php if(isset($erreurid)) echo '<div class="erreurid">'.$erreurid.'</div>';?>
			<?php if(isset($ok)) echo '<div class="ok">'.$ok.'</div>';?>

			<h3>Inscrivez-vous</h3>
			<p>Entrez votre nom et votre e-mail svp</p>
			<form id="signupForm" action="inscription.php" method="post">
			  
			  <label for="nom">Login :</label> <!-- Login de connection -->
			  <input type="text" name="nom" value="<?php if(isset($nom)) echo $nom;?>" />
			  <div class="error"><?php if(isset($erreurnom)) echo $erreurnom;?></div>
			 
			  <label for="pass">Password</label> <!-- Password -->
			  <input id="pass" name="pass" type="password" />
			  
			  <label for="confirm_password">Confirm password</label> <!-- Confirm Password -->
			  <input id="confirm_password" name="confirm_password" type="password" />
			  
			  <label for="lname">Nom :</label> <!-- Nom -->
			  <input type="text" name="lname" value="<?php if(isset($lname)) echo $lname;?>" />
			 
			  
			  <label for="fname">Prénom :</label> <!-- Prenom  -->
			  <input type="text" name="fname" value="<?php if(isset($fname)) echo $fname;?>" />
			  
			  
			  <label for="email">Votre E-mail :</label> <!-- Email -->
			  <input type="text" name="email" value="<?php if(isset($email)) echo $email;?>" />
			 
			  
			  <p><input type="submit" class="submit_button" value="Envoyer" /></p>
			  
			</form>
			<p><a href="index.php">Revenir à l'accueil</a></p>
		</div>
	  </div>
	</body>
</html>