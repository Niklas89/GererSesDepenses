<?php
session_start();
$id_users = $_SESSION['id'];

if(empty($_SESSION['id']))
{
	header('Location: index.php');
}

	include 'config.php';
  
 
/* Select all from "depenses"
  $req = $bdd->prepare('SELECT * FROM depenses WHERE id_users=:id_users'); 
 $req->execute(array('id_users'=>$id_users));
 $data = $req->fetch();
 $req->closeCursor();
 */
 
  /* Select last depense by user
 $req = $bdd->prepare('SELECT * FROM depenses WHERE id_users=:id_users AND id = (SELECT MAX(id) FROM depenses WHERE id_users=:id_users)');
 $req->execute(array('id_users'=>$id_users));
 $datamax = $req->fetch();
 $req->closeCursor(); */

 
 if(!empty($_POST)) {
 if($_POST['description'] == 'Description') {
	$_POST['description'] = '';
 }

	$montant = stripslashes(htmlspecialchars($_POST['montant']));
	   if(is_numeric($_POST['montant']))
	  {
		extract($_POST);
		$valid = true;
	  } else {
		 $valid = false;
		$erreurid = 'Le montant doit contenir uniquement des chiffres !';
		}
 
	
	if($valid)
	{
		date_default_timezone_set('Europe/Madrid');
		$coldate = date('Y-m-d H:i:s');
		
			$description = stripslashes(htmlspecialchars($_POST['description']));
		
		$req = $bdd->prepare('INSERT INTO depenses (id_users,description,coldate,montant) VALUES (:id_users,:description,:coldate,:montant)');
		$req->execute(array(
		  'id_users'=>$id_users,
		  'description'=>$description,
		  'coldate'=>$coldate,
		  'montant'=>$montant
		));
		$req->closeCursor();
		$ok = 'Ajouté avec succès !';
		
	}
  } // if not empty post

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
				<h2>Mes dépenses</h2>
				<div class="parametres"><a href="change.php" title="Paramètres de compte"><img src="img/gear.svg" alt="Paramètres de compte" /></a></div>
					<div id="mesdepenses">
					
						<?php if(isset($ok)){ echo '<div id="ok">'.$ok.'</div>';} 
						elseif(isset($erreurid)){ echo '<div id="erreurid" style="margin:10px;">'.$erreurid.'</div>';  } ?>
						<form id="signupForm" action="depenses.php" method="post">
						
						<label>Aujourd'hui :</label>
						<p><input type="text" name="montant" value="Montant" onFocus="this.value='';" onBlur="if(this.value==''){this.value='Montant';}" /></p>
						<p><textarea name="description" rows="5" cols="23" value="Description" onFocus="this.value='';" onBlur="if(this.value==''){this.value='Description';}">Description</textarea></p>
							  
						<p><input type="submit" class="submit_button" value="Ajouter" /></p>
						  
						</form>
						
					<div id="content">
						
			
							<p>
							<?php // le nombre de dépenses cette semaine
							$req = $bdd->prepare('SELECT COUNT(id) FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(NOW()) ORDER BY coldate'); // Select and count depenses from this week
							 $req->execute(array('id_users'=>$id_users));
							 
							 $datacount = $req->fetch();
							
							 echo '<strong>'.$datacount[0].' dépense(s) cette semaine: </strong>';
							 $req->closeCursor(); ?>
							</p>
							
							<ul class="semaine_du_liste"> 
							<?php // les dépenses de la semaine
							$req = $bdd->prepare('SELECT id,id_users,description,coldate,DATE_FORMAT(coldate, \'%d/%m à %Hh%i\') AS coldate_fr,montant FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(NOW()) ORDER BY coldate DESC'); // Select dates from this week
							 $req->execute(array('id_users'=>$id_users));
							 
							 while ($dataweek = $req->fetch())
							{
							 echo '<li><span class="underline">Jour '.date('N', strtotime($dataweek['coldate'])).':</span> '.$dataweek['coldate_fr'].': '.$dataweek['montant'].'€<br />
							 <span class="description_italique">'.$dataweek['description'].'</span></li>';
							 }
							 
							 $req->closeCursor(); ?>
							</ul>
							
							
							
							
							<p>
							<?php  // Total des dépenses de la semaine et moyenne par jour
							$req = $bdd->prepare('SELECT sum(montant) FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(NOW()) ORDER BY coldate'); // Select and sums up depenses from this week
							 $req->execute(array('id_users'=>$id_users));
							 
							 $datasum = $req->fetch();
							
							error_reporting(0);
							 echo '<strong>Total:</strong> '.$datasum[0].'€<br />';
							  $moyenne = $datasum[0]/$datacount[0];
							  $moyenne2 = number_format($moyenne,2); 
							 echo '<strong>Moyenne par jour:</strong> '.$moyenne2.'€<br />'; 
							 $req->closeCursor(); ?>
							</p>
							
							
							
							<div class="separation"></div>
							
							
							<p><strong>Dépenses du mois:</strong> <br />
							<?php // Toutes les dépenses du mois
							$req = $bdd->prepare('SELECT id,id_users,description,coldate,DATE_FORMAT(coldate, \'%d/%m\') AS coldate_fr,montant, COUNT(*) FROM depenses WHERE id_users=:id_users AND MONTH(coldate) = MONTH(NOW()) GROUP BY WEEK(coldate) DESC');
							 $req->execute(array('id_users'=>$id_users));
							 
							 while ($datamonth = $req->fetch())
							{
							 echo '<a class="depenses_du_mois" href="depenses.php?date='.date('Y-m-d', strtotime($datamonth['coldate'])).'&#ddm">Semaine du '.$datamonth['coldate_fr'].' - dépenses: '.$datamonth[6].'</a><br />';
							 }
							  $req->closeCursor(); ?>
							</p>
							
							
							
							<?php
							// afficher la semaine en cliquant sur un lien pour les dépenses du mois 
							if(!empty($_GET['date'])){
							$getdate = $_GET['date'];
							$formated_semaine_du = date('d/m/Y', strtotime($getdate));
							echo '<p class="semaine_du_rouge" id="ddm"><strong>Semaine du:</strong> '.$formated_semaine_du.'<br />
							<a class="depenses_du_mois" href="depenses.php?description='.$_GET['date'].'&#ddmd" title="description">Voir les description</a></p>';
							echo '<ul class="semaine_du_liste">';
							$req = $bdd->prepare('SELECT * FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(\''.$getdate.'\') ORDER BY coldate DESC');
							 $req->execute(array('id_users'=>$id_users));
							 
							 while ($datagetdate = $req->fetch())
							{
								$format_date = $datagetdate['coldate'];
								$formated_date = date('d/m \à H\hi', strtotime($format_date));
							 echo '<li>'.$formated_date.': '.$datagetdate['montant'].'€</li>';
							 }
							 
							 $req->closeCursor();
							echo '</ul>';
							}
							
							?>
							
							
							
							<?php
							// si jai cliqué sur le lien description afficher la semaine et la description 
							if(!empty($_GET['description'])){
							$getdate = $_GET['description'];
							$formated_semaine_du = date('d/m/Y', strtotime($getdate));
							echo '<p class="semaine_du_rouge" id="ddmd"><strong>Semaine du:</strong> '.$formated_semaine_du.'</p>';
							echo '<ul class="semaine_du_liste">';
							$req = $bdd->prepare('SELECT * FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(\''.$getdate.'\') ORDER BY coldate DESC');
							 $req->execute(array('id_users'=>$id_users));
							 
							 while ($datagetdate = $req->fetch())
							{
								$format_date = $datagetdate['coldate'];
								$formated_date = date('d/m \à H\hi', strtotime($format_date));
							 echo '<li>'.$formated_date.': '.$datagetdate['montant'].'€<br />
							 <span class="description_italique">'.$datagetdate['description'].'</span></li>';
							 }
							 
							 $req->closeCursor();
							echo '</ul>';
							}
							
							?>
							
							
							
							<div class="separation"></div>
							
							<?php // Toutes les dépenses de l'année 
						
							if(!empty($_GET['year'])){ ?>
							<p class="get_dep_annee" id="dda"><a href="depenses.php?year=1&#dda" title="Dépenses de l'année">Dépenses de l'année :</a></p>
							<p><a class="depenses_du_mois" href="depenses.php?description_anne=1&#ddad" title="Afficher les descriptions">Voir les descriptions</a></p>
							<?php 
							echo '<ul class="semaine_du_liste">';
							$req = $bdd->prepare('SELECT id,id_users,description,coldate,DATE_FORMAT(coldate, \'%d/%m/%Y\') AS coldate_fr,montant FROM depenses WHERE id_users=:id_users AND YEAR(coldate) = YEAR(NOW()) ORDER BY coldate DESC');
							 $req->execute(array('id_users'=>$id_users));
							 
							 while ($datayear = $req->fetch())
							{
							 echo '<li>Semaine '.date('W', strtotime($datayear['coldate'])).': '.$datayear['coldate_fr'].' - dépensé: '.$datayear['montant'].'€</li>';
							 }
							  $req->closeCursor(); 
							  echo '</ul>';
							  }  
							  // Toutes les dépenses de l'année en voyant les description
							elseif(!empty($_GET['description_anne'])){ ?>
							<p class="get_dep_annee" id="ddad"><a href="depenses.php?year=1&#dda" title="Dépenses de l'année">Dépenses de l'année :</a></p> 
							
							<ul class="semaine_du_liste">
							<?php 
							
							$req = $bdd->prepare('SELECT id,id_users,description,coldate,DATE_FORMAT(coldate, \'%d/%m/%Y\') AS coldate_fr,montant FROM depenses WHERE id_users=:id_users AND YEAR(coldate) = YEAR(NOW()) ORDER BY coldate DESC');
							 $req->execute(array('id_users'=>$id_users));
							 
							 while ($datayear = $req->fetch())
							{
							 echo '<li>Semaine '.date('W', strtotime($datayear['coldate'])).': '.$datayear['coldate_fr'].' - dépensé: '.$datayear['montant'].'€<br />
							 <span class="description_italique">'.$datayear['description'].'</span></li>';
							 }
							  $req->closeCursor(); 
							  ?>
							  </ul> <?php } else { ?>
							<p><strong><a href="depenses.php?year=1&#dda">Dépenses de l'année</a></strong></p>
							<?php }  ?>
							
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
