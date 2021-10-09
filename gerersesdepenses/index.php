<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title>Gérer ses dépenses</title>
		<meta name="author" content="Niklas Edelstam">
		
		<link href="css/style.css" rel="stylesheet" type="text/css" />
	</head>
	
	<body>
	  <div id="conteneur">
		<div id="formulaire">
			<?php
			if(empty($_SESSION['id'])){
			?>
				<h2>Bonjour, bienvenue !</h2>
				<p>Pour vous inscrire cliquez <a href="inscription.php">ici</a></p>
				<p>Sinon <a href="login.php">identifiez-vous</a>.</p>
			<?php
			}
			else{
			?>
				<h2>Bonjour <?php echo $_SESSION['users'];?>, bienvenue !</h2>
				<p>Consultez <a href="profil.php">votre profil</a>.</p>
			<?php
			}
			?>
		</div>
	  </div>
	</body>
</html>