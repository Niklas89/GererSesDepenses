<?php
session_start();
if(!empty($_SESSION['id']))
{
  header('Location: depenses.php');
}

if(!empty($_POST))
{
  $valid = true;
  extract($_POST);
  
  if($valid)
  {
  
	include 'config.php';
 

  $req = $bdd->prepare('SELECT * FROM users WHERE login=:login AND pass=:pass');
  $req->execute(array(
    'login'=>$login,
    'pass'=>md5($pass)
  ));
  $data = $req->fetch();
  if($req->rowCount()==0)
  {
    $valid = false;
    $erreurid = 'Mauvais identifiants !';
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
      header('Location: depenses.php');
    }
  
  }
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
			<!--<nav>
				<ul>
					<li><a href="#">nav ul li a</a></li>
					<li><a href="#">nav ul li a</a></li>
					<li><a href="#">nav ul li a</a></li>
				</ul>
			</nav>-->
		</header>
	</div>
	<div id="main-container">
		<div id="main" class="wrapper clearfix">
			
			<article>
				<header>
					<?php if(isset($erreurid)) echo '<div id="erreurid">'.$erreurid.'</div>';?>
					<form id="signupForm" action="index.php" method="post">
						<label>Connectez-vous :</label>
						  <p><input type="text" name="login" value="<?php if(isset($login)){ echo $login;} else{ echo 'Login';} ?>" onFocus="this.value='';" onBlur="if(this.value==''){this.value='Login';}" /></p>
						  <p><input type="password" name="pass" value="<?php if(isset($pass)){ echo $pass;} else{ echo 'Mot de passe';} ?>" onFocus="this.value='';" onBlur="if(this.value==''){this.value='Mot de passe :';}" /></p>
						  
						  <p><input type="submit" class="submit_button" value="Login" /></p>
					  
					</form>
				</header>
				<footer>
					<form id="signupForm" action="inscription.php" method="post">
					<label>Inscrivez-vous :</label>
					<p><input type="text" name="email" value="Email" onFocus="this.value='';" onBlur="if(this.value==''){this.value='Email';}" /></p>
						  
					<p><input type="submit" class="submit_button" value="S'inscrire" /></p>
					</form>
				</footer>
			</article>
			
			<aside>
				<h1>gerez vos dépenses<br /><span class="redspan">simplement</span></h1>
				<h1>pour découvrir<br /><a href="decouvrir.php">cliquez ici</a></h1>
			</aside>
			
		</div> <!-- #main -->
		
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
		
	</div> <!-- #main-container -->



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
