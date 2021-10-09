<?php
if(!empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['confirm_password']) && !empty($_POST['nom']) && !empty($_POST['lname']) && !empty($_POST['fname']))
{
  extract($_POST);
  $valid = true;
  
	include 'config.php';
  
    if($_POST['pass'] != $_POST['confirm_password'])
  {
    $valid = false;
    $erreurid = 'Veuillez reconfirmer le mot de passe';
  }
  
  
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
  
  if(preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $_POST['email']))
  {
    $valid = true;
  } else {
     $valid = false;
    $erreurid = 'Veuillez entrer une adresse email valide.';
	}

  
  if($valid)
  {
  
	$nom = stripslashes(htmlspecialchars($_POST['nom']));
	
	$pass = stripslashes(htmlspecialchars($_POST['pass']));
	
	$email = stripslashes(htmlspecialchars($_POST['email']));
	
	$lname = stripslashes(htmlspecialchars($_POST['lname']));
	
	$fname = stripslashes(htmlspecialchars($_POST['fname']));
	
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
    $ok = 'Inscription réussie ! <a href="index.php">Connectez-vous ici</a>';
	unset($nom);
    unset($email);
	unset($lname);
	unset($fname);
	unset($ip);
  }
}
 elseif(empty($_POST['email']) || empty($_POST['pass']) || empty($_POST['confirm_password']) || empty($_POST['nom']) || empty($_POST['lname']) || empty($_POST['fname'])) {
		
	$valid = false;
    $erreurid = 'Veuillez bien remplir le formulaire svp !';
 
 }

?>

<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title></title>
	<meta name="description" content="">
	<meta name="author" content="Niklas Edelstam">

	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="css/style.css">
	

	<script src="js/libs/modernizr-2.5.3-respond-1.1.0.min.js"></script>
</head>
<body>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

	<div id="header-container">
		<header class="wrapper clearfix">
			<h1 id="title"><a href="index.php">budgetminds</a></h1>
			
			
		</header>
	</div>
	<div id="main-container">
		<div id="main" class="wrapper clearfix">
			<div id="main-depenses">
				<h2>S'inscrire</h2>
				<div class="parametres"><a href="index.php" title="Accueil"><img src="img/home.svg" alt="Accueil" /></a></div>
					<div id="mesdepenses">
						
						<form id="signupForm" action="inscription-fn.php" method="post">
							<?php if(isset($erreurid)) echo '<div id="erreurid">'.$erreurid.'</div>';?>
							<?php if(isset($ok)) echo '<div id="ok">'.$ok.'</div>';?>
							 <p><label for="email">E-mail :</label><br /> <!-- Email -->
							<input type="text" name="email" value="<?php if(isset($email)) echo $email;?>" /></p>
							
							<p><label for="pass">Mot de passe :</label><br /> <!-- Password -->
							<input id="pass" name="pass" type="password" /></p>
						  
							<p><label for="confirm_password">Confirmez le :</label><br /> <!-- Confirm Password -->
							<input id="confirm_password" name="confirm_password" type="password" /></p>
							
						  <p><label for="nom">Login :</label><br /> <!-- Login de connection -->
						  <input type="text" name="nom" value="<?php if(isset($nom)) echo $nom;?>" />
						<div class="error"><?php if(isset($erreurnom)) echo $erreurnom;?></div></p>
						  
						  <p><label for="lname">Nom :</label><br /> <!-- Nom -->
						  <input type="text" name="lname" value="<?php if(isset($lname)) echo $lname;?>" /></p>
						 
						  
						 <p> <label for="fname">Prénom :</label><br /> <!-- Prenom  -->
						  <input type="text" name="fname" value="<?php if(isset($fname)) echo $fname;?>" /></p>
						  
							
						<p><input type="submit" class="submit_button" value="S'inscrire" /></p>
							
						</form>	
						
						
					</div> <!-- #mesdepenses -->
			</div> <!-- #main-depenses -->
			
			
		</div> <!-- #main -->	
	</div> <!-- #main-container -->

		<div id="footer-container" class="clearfix">
			<footer>
				<ul>
					<li>© 2012 Budgetminds</li>
					<li><a href="contact.php" title="Contact">Contact</a></li>
					<li><a href="apropos.php" title="A propos">A propos</a></li>
					<li><a href="faq.php" title="FAQ">FAQ</a></li>
				</ul>
			</footer>
		</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.2.min.js"><\/script>')</script>

<script src="js/script.js"></script>
<script>
	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>
