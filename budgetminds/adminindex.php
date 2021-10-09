<?php
session_start();
$id_users = $_SESSION['id'];

if(empty($_SESSION['id']))
{
	header('Location: index.php');
}

	include 'config.php';
  
  if(!empty($_GET['supprimer'])) {
	$req = $bdd->query("DELETE FROM users WHERE id =".$_GET['supprimer']);
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
			
			<nav>
				<a href="logout.php" title="Déconnexion"><img src="img/power.svg" alt="Déconnexion" style="width:35px;height:35px;"/></a>	
			</nav>
			
		</header>
	</div>
	<div id="main-container">
		<div id="main" class="wrapper clearfix">
			<div id="main-depenses">
				<h2>Les membres</h2>
				<div class="parametres"><a href="adminchange.php" title="Paramètres de compte"><img src="img/gear.svg" alt="Paramètres de compte" /></a></div>
					<div id="mesdepenses">
					
						<?php if(isset($ok)) echo '<div id="ok">'.$ok.'</div>';?>
						
					<div id="content">
						<?php // compte le nombre de membres
							$req = $bdd->query('SELECT * FROM users'); 
							 
							 while($users = $req->fetch()) {
							 echo "<p>".$users['fname']." ".$users['lname']." - <a href='userprofil.php?id=".$users['id']."' title='Voir profil'>Voir profil</a> - <a href='adminindex.php?supprimer=".$users['id']."' title='Supprimer'><img src='img/supprimer.png' alt='Supprimer' /></a></p>";
							 }
							 $req->closeCursor(); ?>
			
							
							
					</div>
						
						
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
