<?php
session_start();
if(empty($_SESSION['id']))
{
  header('Location: index.php');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title>Gérer ses dépenses - profil</title>
		<meta name="author" content="Niklas Edelstam">
		
		<link href="css/style.css" rel="stylesheet" type="text/css" />
	</head>
	
	<body>
	  <div id="conteneur">
		<div id="formulaire">
		<h3><?php echo 'Bonjour '.$_SESSION['users'].', voici votre espace membre ';?></h3>
			<div>
				<a href="change.php"> Changer vos informations de profil </a>
			</div>
			
			<div>
				<a href="depenses.php">Gérez vos dépenses</a>
			</div>
			
			<div>
				<a href="logout.php"> Déconnexion </a>
			</div>
		</div>
	  </div>
	</body>
</html>