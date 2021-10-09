<?php
session_start();
$id_users = $_SESSION['id'];

if(empty($_SESSION['id']))
{
	header('Location: index.php');
}

	include '../config.php';
  


 
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

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Gérez vos dépenses simplement.">
		<meta name="keywords" content="gérer ses dépenses, dépenses, budget">
		<meta name="author" content="Niklas Edelstam">
		<meta name="robots" content="index,follow" />
        <title>
			Dépenses Budgetminds
        </title>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
        <link rel="stylesheet" href="css/my.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js">
        </script>
        <script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js">
        </script>
    </head>
    <body>
        <div data-role="page" data-theme="a" data-content-theme="a" id="page1">
            <div data-theme="a" data-role="header">
                <div class="text-align-center">
                    <img class="img-logo" alt="Budgetminds" src="img/logo.png" />
                </div>
				<a data-role="button" data-inline="true" data-transition="fade" data-theme="a" href="logout.php" data-icon="home" data-iconpos="left">
                    Home
                </a>
                <a data-role="button" data-inline="true" data-transition="fade" data-theme="a" href="change.php" data-icon="gear" data-iconpos="left">
                    Profil
                </a>
            </div>
            <div data-role="content" class="content-padding ">
                <h2>
                    DEPENSES
                </h2>
				<?php if(isset($erreurid)) echo '<div id="erreurid">'.$erreurid.'</div>';?>
					
                        
						
                        <form action="depenses.php" method="post">
							 <div data-role="fieldcontain">
								<fieldset data-role="controlgroup">
									<input id="textinput4" placeholder="Montant d'aujourd'hui" value="" name="montant" type="text" data-mini="true" />
									<br />
									<textarea name="description" placeholder="Description" rows="5" cols="23"  data-mini="true"></textarea>
								</fieldset>
							</div>
							<input type="submit" value="Ajouter" data-mini="true" />
                        </form>
					

						
						
						
				<div data-role="collapsible-set" data-theme="a" data-mini="true">
                    <div data-role="collapsible" data-collapsed="true">
                        <h3>
                            Cette semaine
                        </h3>		
							<ul data-role="listview" data-divider-theme="a" data-inset="true">
							<?php // le nombre de dépenses cette semaine
										$req = $bdd->prepare('SELECT COUNT(id) FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(NOW()) ORDER BY coldate'); // Select and count depenses from this week
										 $req->execute(array('id_users'=>$id_users));
										 
										 $datacount = $req->fetch(); ?>
										
										 
								<li data-role="list-divider" role="heading">
									<?php echo $datacount[0]; ?> dépense(s) cette semaine
								</li>
								<?php $req->closeCursor(); ?>
								
								<?php // les dépenses de la semaine
										$req = $bdd->prepare('SELECT id,id_users,description,coldate,DATE_FORMAT(coldate, \'%d/%m à %Hh%i\') AS coldate_fr,montant FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(NOW()) ORDER BY coldate DESC'); // Select dates from this week
										 $req->execute(array('id_users'=>$id_users));
										 
										 while ($dataweek = $req->fetch())
										{ ?>
								<li data-theme="c">
								   
										Jour <?php echo date('N', strtotime($dataweek['coldate'])); ?>: <?php echo $dataweek['coldate_fr'].': '.$dataweek['montant']; ?>€<br />
										<?php echo $dataweek['description']; ?>
									
								</li>
								<?php  } $req->closeCursor(); ?>
							</ul>
					
				
				
							<?php  // Total des dépenses de la semaine et moyenne par jour
										$req = $bdd->prepare('SELECT sum(montant) FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(NOW()) ORDER BY coldate'); // Select and sums up depenses from this week
										 $req->execute(array('id_users'=>$id_users));
										 
										 $datasum = $req->fetch();
										
										error_reporting(0); ?>
							<div>
								<b>
									Total: <?php echo $datasum[0]; ?>€
								</b>
							</div>
							 <?php $moyenne = $datasum[0]/$datacount[0];
										  $moyenne2 = number_format($moyenne,2); ?>
							<div>
								<b>
									Moyenne / jour: <?php echo $moyenne2; ?>€
									<?php $req->closeCursor(); ?>
								</b>
							</div>
					</div>
				</div>
				
				
				
                <div data-role="collapsible-set" data-theme="a" data-mini="true">
                    <div data-role="collapsible" data-collapsed="true">
                        <h3>
                            Ce mois
                        </h3>
						<ul data-role="listview" data-inset="true">
						<?php // Toutes les dépenses du mois
							$req = $bdd->prepare('SELECT id,id_users,description,coldate,DATE_FORMAT(coldate, \'%d/%m\') AS coldate_fr,montant, COUNT(*) FROM depenses WHERE id_users=:id_users AND MONTH(coldate) = MONTH(NOW()) GROUP BY WEEK(coldate) DESC');
							 $req->execute(array('id_users'=>$id_users));
							 
							 while ($datamonth = $req->fetch())
							{ 
							$envoi_date_semaine = date('Y-m-d', strtotime($datamonth['coldate']));
							echo '<li data-theme="c"><a data-theme="c" href="dialogsemaine.php?date='.$envoi_date_semaine.'" data-rel="dialog" data-transition="pop">Semaine du '.$datamonth['coldate_fr'].' - dépenses: '.$datamonth[6].'</a></li>';

						 }   ?>
						</ul>
                    </div>
                </div>
				
				     <div data-role="collapsible-set" data-theme="a" data-content-theme="" data-mini="true">
                    <div data-role="collapsible" data-collapsed="true">
                        <h3>
                            Cette année
                        </h3>
						<ul data-role="listview" data-inset="true">
						<?php // Toutes les dépenses de l'année
							$req = $bdd->prepare('SELECT id,id_users,description,coldate,DATE_FORMAT(coldate, \'%d/%m/%Y\') AS coldate_fr,montant, COUNT(*) FROM depenses WHERE id_users=:id_users AND YEAR(coldate) = YEAR(NOW()) GROUP BY MONTH(coldate) DESC');
							 $req->execute(array('id_users'=>$id_users));
							 
							 while ($datayearmonth = $req->fetch())
							{ 
							$envoi_date_mois = date('Y-m-d', strtotime($datayearmonth['coldate']));
							echo '<li data-theme="c"><a data-theme="c" href="dialogmois.php?date='.$envoi_date_mois.'" data-rel="dialog" data-transition="pop">Mois '.date('m', strtotime($datayearmonth['coldate'])).' - dépenses: '.$datayearmonth[6].'</a></li>';
							
							 } ?>
						</ul>
                    </div>
                </div>
				
						
				
            </div>
            <div data-theme="a" data-role="footer" data-position="fixed">
                <h5>
                    © 2012 Budgetminds
                </h5>
            </div>
        </div>
        <script>
            //App custom javascript
        </script>
    </body>
</html>