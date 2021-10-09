<?php
if(!empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['confirm_password']) && !empty($_POST['nom']) && !empty($_POST['lname']) && !empty($_POST['fname']))
{
  extract($_POST);
  $valid = true;
  
	include '../config.php';
  
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
			Inscription Budgetminds
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
				<a data-role="button" data-inline="true" data-transition="fade" data-theme="a" href="index.php" data-icon="home" data-iconpos="left">
                    Home
                </a>
            </div>
            <div data-role="content" class="content-padding ">
                <h2>
                    S'inscrire
                </h2>
					<?php if(isset($ok)){ echo '<div id="ok">'.$ok.'</div>';} 
						elseif(isset($erreurid)){ ?>
						<?php echo '<div id="erreurid">'.$erreurid.'</div>'; ?>	
                        <form action="inscription-fn.php" method="post">
							 <div data-role="fieldcontain">
								<fieldset data-role="controlgroup">
										<input type="text" placeholder="Email" name="email" value=""<?php if(isset($email)) echo $email;?>"/>
										
										<input id="pass" placeholder="Mot de passe" name="pass" type="password" />
									  
										<input id="confirm_password" placeholder="Confirmer" name="confirm_password" type="password" />
										
									  <input type="text" placeholder="Login" name="nom" value="<?php if(isset($nom)) echo $nom;?>" />
									  <div class="error"><?php if(isset($erreurnom)) echo $erreurnom;?></div>
									  
									  <input type="text" placeholder="Nom" name="lname" value="<?php if(isset($lname)) echo $lname;?>" />
									 
									 
									<input type="text" placeholder="Prénom" name="fname" value="<?php if(isset($fname)) echo $fname;?>" />
									
								</fieldset>
							</div>
							<input type="submit" value="S'inscrire" />
                        </form>	<?php } ?>

	
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