<?php
session_start();
$id_users = $_SESSION['id'];

if(empty($_SESSION['id']))
{
	header('Location: index.php');
}

	include '../config.php';
  

?>

<div data-role="dialog" data-url="depenses.php">
	
		<div data-role="header" data-theme="a" role="banner">
			<h1 class="ui-title" role="heading" aria-level="1">Semaine du <?php echo date('d/m', strtotime($_GET['date'])); ?></h1>
		</div>

		<div data-role="content" data-theme="c" role="main">
				<ul data-role="listview" data-theme="c">
				<?php 
									$getdate = $_GET['date'];
									$formated_semaine_du = date('d/m/Y', strtotime($getdate));
					$req = $bdd->prepare('SELECT * FROM depenses WHERE id_users=:id_users AND WEEK(coldate) = WEEK(\''.$getdate.'\') ORDER BY coldate DESC');
							 $req->execute(array('id_users'=>$id_users));
							 
							  while ($datagetdate = $req->fetch())
							{ 
								
								$format_date = $datagetdate['coldate'];
								$formated_date = date('d/m \à H\hi', strtotime($format_date)); 
								echo '<li>'.$formated_date.': '.$datagetdate['montant'].'€<br />'.$datagetdate['description'].'</li>';
							}
							  $req->closeCursor(); 
							  ?>
                </ul>
		</div>
		
	</div>