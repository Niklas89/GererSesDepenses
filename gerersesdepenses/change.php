<?php
session_start();
$session = $_SESSION['id'];

if(empty($_SESSION['id']))
{
	header('Location: index.php');
}

try{
  $bdd = new PDO('mysql:host=localhost;dbname=gerersesdepenses', 'root', 'root') or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES utf8');
  }
  
  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  }
  
 $req = $bdd->prepare('SELECT * FROM users WHERE id=:session');
 $req->execute(array('session'=>$_SESSION['id']));
 $data = $req->fetch();
 $req->closeCursor();
 
 if(!empty($_POST))
 {
	extract($_POST);
	$valid = true;
	
	if($valid)
	{
		$req = $bdd->prepare('UPDATE users SET email=:email, pass=:pass, login=:login, lname=:lname, fname=:fname WHERE id=:session');
		$req->execute(array(
			'email'=>$email,
			'pass'=>md5($pass),
			'login'=>$login,
			'lname'=>$lname,
			'fname'=>$fname,
			'session'=>$session
		));
		$req->closeCursor();
		$ok = 'Modification réussie. <a href="login.php" title="Accueil">Reconnectez-vous</a>';
		
		unset($_SESSION['users']);
		session_destroy();
	}
 }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title>Gérer ses dépenses - changement</title>
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
						},
						login: {
							required: true,
							minlength: 5
						},
						lname: {
							required: true,
							minlength: 5
						},
						fname: {
							required: true,
							minlength: 5
						},
					},
					messages: {
						pass: {
							required: "Entrez un mot de passe s'il vous plaît",
							minlength: "Votre mot de passe doit avoir au moins 5 caractères"
						},
						login: {
							required: "Entrez un login s'il vous plaît",
							minlength: "Votre login doit avoir au moins 5 caractères"
						},
						lname: {
							required: "Entrez votre nom de famille s'il vous plaît",
							minlength: "Votre nom de famille doit avoir au moins 5 caractères"
						},
						fname: {
							required: "Entrez votre prénom s'il vous plaît",
							minlength: "Votre prénom doit avoir au moins 5 caractères"
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
			<h3> Changer les informations de votre profil </h3> 
			
			<?php if(isset($ok)) echo '<div class="ok">'.$ok.'</div>';?>
			<form id="signupForm" action="change.php" method="post">
				
				 <label for="email">Votre E-mail :</label> <!-- Email -->
				<input type="text" name="email" value="<?php echo $data['email'];?>"/>
				
				<label for="pass">Nouveau mot de passe</label> <!-- Password -->
				<input id="pass" name="pass" type="password" />
			  
				<label for="confirm_password">Confirmez le mot de passe</label> <!-- Confirm Password -->
				<input id="confirm_password" name="confirm_password" type="password" />
				
			  <label for="login">Login :</label> <!-- Login de connection -->
			  <input type="text" name="login" value="<?php echo $data['login'];?>" />
			  
			  <label for="lname">Nom :</label> <!-- Nom -->
			  <input type="text" name="lname" value="<?php echo $data['lname'];?>" />
			 
			  
			  <label for="fname">Prénom :</label> <!-- Prenom  -->
			  <input type="text" name="fname" value="<?php echo $data['fname'];?>" />
			  
				
			<p><input type="submit" class="submit_button" value="Modifier" /></p>
				
			</form>
			
			 <p><a href="profil.php">Retourner</a></p>
			
		</div>
	  </div>
	</body>
</html>