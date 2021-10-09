<?php
session_start();
$session = $_SESSION['id'];

if(empty($_SESSION['id']))
{
	header('Location: index.php');
}

	include 'config.php';
  
 $req = $bdd->prepare('SELECT * FROM users WHERE id=:session');
 $req->execute(array('session'=>$_SESSION['id']));
 $data = $req->fetch();
 $req->closeCursor();
 

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
			
			<nav>
				<a href="logout.php" title="Déconnexion"><img src="img/power.svg" alt="Déconnexion" style="width:35px;height:35px;"/></a>	
			</nav>
			
		</header>
	</div>
	<div id="main-container">
		<div id="main" class="wrapper clearfix">
			<div id="main-depenses">
				<h2>Changer mes paramètres</h2>
				<div class="clipboard"><a href="depenses.php" title="Mes dépenses"><img src="img/piggy-bank-white.svg" alt="Mes dépenses" /></a></div>
					<div id="mesdepenses">
						
						<form id="signupForm" action="change-fn.php" method="post">
							
							 <p><label for="email">E-mail :</label><br /> <!-- Email -->
							<input type="text" name="email" value="<?php echo $data['email'];?>"/></p>
							
							<p><label for="pass">Mot de passe :</label><br /> <!-- Password -->
							<input id="pass" name="pass" type="password" /></p>
						  
							<p><label for="confirm_password">Confirmez le :</label><br /> <!-- Confirm Password -->
							<input id="confirm_password" name="confirm_password" type="password" /></p>
							
						  <p><label for="login">Login :</label><br /> <!-- Login de connection -->
						  <input type="text" name="login" value="<?php echo $data['login'];?>" /></p>
						  
						  <p><label for="lname">Nom :</label><br /> <!-- Nom -->
						  <input type="text" name="lname" value="<?php echo $data['lname'];?>" /></p>
						 
						  
						 <p> <label for="fname">Prénom :</label><br /> <!-- Prenom  -->
						  <input type="text" name="fname" value="<?php echo $data['fname'];?>" /></p>
						  
							
						<p><input type="submit" class="submit_button" value="Modifier" /></p>
							
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
