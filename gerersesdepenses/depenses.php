<?php
session_start();
$id_users = $_SESSION['id'];

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

 
 
 
 
 
 if(!empty($_POST))
 {
	extract($_POST);
	$valid = true;
	
	if($valid)
	{
		$coldate = date('Y-m-d H:i:s');
		
		
		$req = $bdd->prepare('INSERT INTO depenses (id_users,description,coldate,montant) VALUES (:id_users,:description,:coldate,:montant)');
		$req->execute(array(
		  'id_users'=>$id_users,
		  'description'=>$description,
		  'coldate'=>$coldate,
		  'montant'=>$montant
		));
		$req->closeCursor();
		$ok = 'Ajouté avec success';
		
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
						montant: {
							required: true,
							minlength: 1
						}
					},
					messages: {
						montant: {
							required: "Entrez un montant s'il vous plaît",
							minlength: "Votre montant doit avoir au moins 1 caractère"
						}
					}
				});
			});
			</script>
			
	</head>
	
	<body>
	  <div id="conteneur">
		<div id="formulaire">
			<h3> Gérez vos dépenses </h3> 
			
			<?php if(isset($ok)) echo '<div class="ok">'.$ok.'</div>';?>
			<form id="signupForm" action="depenses.php" method="post">
				
				 <label for="montant">Les dépenses d'aujourd'hui :</label> <!-- Email -->
				<input type="text" name="montant" />
				
				
				<label for="description">Description</label>
				<textarea id="description" name="description" cols="30"></textarea>
		
				
				<p><input type="submit" class="submit_button" value="Ajouter" /></p>
				
			</form>
			
			<p>
			
			Dépenses de la semaine:<br />
			<?php $req = $bdd->prepare('SELECT id,id_users,description,coldate,DATE_FORMAT(coldate, \'%d/%m à %Hh%i\') AS coldate_fr,montant FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(NOW()) ORDER BY coldate DESC'); // Select dates from this week
			 $req->execute(array('id_users'=>$id_users));
			 
			 while ($dataweek = $req->fetch())
			{
			 echo 'Jour '.date('N', strtotime($dataweek['coldate'])).': '.$dataweek['coldate_fr'].': '.$dataweek['montant'].'€<br />';
			 }
			 
			 $req->closeCursor(); ?>
			</p>
			<p>
			<?php $req = $bdd->prepare('SELECT COUNT(id) FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(NOW()) ORDER BY coldate'); // Select and count depenses from this week
			 $req->execute(array('id_users'=>$id_users));
			 
			 $datacount = $req->fetch();
			
			 echo 'Nombre de dépenses cette semaine: '.$datacount[0];
			 $req->closeCursor(); ?>
			</p>
			
			
			<p>
			<?php $req = $bdd->prepare('SELECT sum(montant) FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(NOW()) ORDER BY coldate'); // Select and sums up depenses from this week
			 $req->execute(array('id_users'=>$id_users));
			 
			 $datasum = $req->fetch();
			
			 echo 'Total des dépenses de la semaine: '.$datasum[0].'€<br />';
			  $moyenne = $datasum[0]/$datacount[0];
			  $moyenne2 = number_format($moyenne,2); 
			 echo 'Moyenne dépense par jour: '.$moyenne2.'€<br />'; 
			 $req->closeCursor(); ?>
			</p>
			
			<p>Toutes les dépenses du mois: <br />
			<?php $req = $bdd->prepare('SELECT id,id_users,description,coldate,DATE_FORMAT(coldate, \'%d/%m\') AS coldate_fr,montant, COUNT(*) FROM depenses WHERE id_users=:id_users AND MONTH(coldate) = MONTH(NOW()) GROUP BY WEEK(coldate) DESC');
			 $req->execute(array('id_users'=>$id_users));
			 
			 while ($datamonth = $req->fetch())
			{
			 echo '<a href="depenses.php?date='.date('Y-m-d', strtotime($datamonth['coldate'])).'">semaine du '.$datamonth['coldate_fr'].' - nb de dépenses: '.$datamonth[6].'</a><br />';
			 }
			  $req->closeCursor(); ?>
			</p>
			
			<?php
			if(!empty($_GET['date'])){
			$getdate = $_GET['date'];
			echo '<h3>'.$getdate.'</h3>';
			$req = $bdd->prepare('SELECT * FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(\''.$getdate.'\') ORDER BY coldate DESC');
			 $req->execute(array('id_users'=>$id_users));
			 
			 while ($datagetdate = $req->fetch())
			{
			 echo $datagetdate['coldate'].' '.$datagetdate['montant'].'€<br />';
			 }
			 
			 $req->closeCursor();
			
			}
			
			?>
			
			
			
			<p><a href="depenses.php?year=1">Toutes les dépenses de l'année</a><br />
			<?php if(!empty($_GET['year'])){
			$req = $bdd->prepare('SELECT id,id_users,description,coldate,DATE_FORMAT(coldate, \'%d/%m/%Y\') AS coldate_fr,montant FROM depenses WHERE id_users=:id_users AND YEAR(coldate) = YEAR(NOW()) ORDER BY coldate DESC');
			 $req->execute(array('id_users'=>$id_users));
			 
			 while ($datayear = $req->fetch())
			{
			 echo 'Semaine '.date('W', strtotime($datayear['coldate'])).': '.$datayear['coldate_fr'].' - dépensé: '.$datayear['montant'].'€<br />';
			 }
			  $req->closeCursor(); 
			  } ?>
			</p>
			
			
			 <p><a href="profil.php">Retourner</a></p>
			
		</div>
	  </div>
	</body>
</html>