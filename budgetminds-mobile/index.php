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
  
	include '../config.php';
 

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
			Budgetminds
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
            </div>
            <div data-role="content" class="content-padding ">
                <h2>
                    GEREZ VOS DEPENSES <span class="accueil-span">SIMPLEMENT</span>
                </h2>
				<?php if(isset($erreurid)) echo '<div id="erreurid">'.$erreurid.'</div>';?>
               
						
                        <form action="index.php" method="post">
							 <div data-role="fieldcontain">
								<fieldset data-role="controlgroup">
									<input id="textinput4" placeholder="Login" value="" name="login" type="text" />
									<br />
									<input id="textinput5" placeholder="Mot de passe" value="" name="pass" type="password" />
								</fieldset>
							</div>
							<input type="submit" value="Login" />
                        </form>
						<a href="inscription.php" data-role="button" data-mini="true">S'inscrire</a>
						<br />
				
				
				 <div data-role="collapsible-set" data-theme="a" data-mini="true">
                    <div data-role="collapsible" data-collapsed="true">
                        <h3>
                            A Propos
                        </h3>
                        <p>Budgetminds vous permez de gérer vos dépenses plus efficacement et facilement que sur aucun autre site. Le principe est simple. À la fin de la journée vous entrez les dépenses que vous avez fait et vous avez le total et la moyenne de vos dépenses de la semaine.
						Vous pouvez ensuite consulter les dépenses que vous avez fait pendant le mois courant, puis sur toute l'année.
						La seule chose que vous avez à faire c'est de rentrer le montant de la journée, et Budgetminds fait les calculs pour vous. Rien de plus simple !
						</p>

                    </div>
                </div>
				
				
				 <div data-role="collapsible-set" data-theme="a" data-mini="true">
                    <div data-role="collapsible" data-collapsed="true">
                        <h3>
                            Découvrir
                        </h3>
                        <p>Entrez le montant de vos dépenses d'aujourd'hui:
						</p>
						<p><img src="img/montant.jpg" alt="Le montant" /></p>
						<p>Visualisez les dépenses que vous avez fait cette semaine sur la même page:</p>
						<p><img src="img/depsemaine.jpg" alt="Dépenses de la semaine" /></p>
						<p>Ceux du mois:</p>
						<p><img src="img/depmois.jpg" alt="Dépenses du mois" /></p>
						<p>Et celles de toute cette année:</p>
						<p><img src="img/depannee.jpg" alt="Dépenses de l'année" /></p>
                    </div>
                </div>
				
				<a data-icon="info" href="contact.php" data-role="button" data-mini="true" data-inline="true">Contactez-nous</a>
				
				
				
				
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