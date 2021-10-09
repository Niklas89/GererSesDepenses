<?php
session_start();
$session = $_SESSION['id'];

if(empty($_SESSION['id']))
{
	header('Location: index.php');
}

	include '../config.php';
  
 $req = $bdd->prepare('SELECT * FROM users WHERE id=:session');
 $req->execute(array('session'=>$_SESSION['id']));
 $data = $req->fetch();
 $req->closeCursor();
 

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
			Paramètres Budgetminds
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
                <a data-role="button" data-inline="true" data-transition="fade" data-theme="a" href="depenses.php" data-icon="gear" data-iconpos="left">
                    Dépenses
                </a>
            </div>
            <div data-role="content" class="content-padding ">
                <h2>
                    Changer mes paramètres
                </h2>
						
                        <form action="change-fn.php" method="post">
							 <div data-role="fieldcontain">
								<fieldset data-role="controlgroup">
										<input type="text" placeholder="Email" name="email" value="<?php echo $data['email'];?>"/>
										
										<input id="pass" placeholder="Mot de passe" name="pass" type="password" />
									  
										<input id="confirm_password" placeholder="Confirmer" name="confirm_password" type="password" />
										
									  <input type="text" placeholder="Login" name="login" value="<?php echo $data['login'];?>" />
									  
									  <input type="text" placeholder="Nom" name="lname" value="<?php echo $data['lname'];?>" />
									 
									 
									<input type="text" placeholder="Prénom" name="fname" value="<?php echo $data['fname'];?>" />
									
								</fieldset>
							</div>
							<input type="submit" value="Modifier" />
                        </form>

	
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