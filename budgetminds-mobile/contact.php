<?php 

	include '../config.php';
  
 $req = $bdd->prepare('SELECT * FROM admin WHERE id =:id');
 $req->execute(array('id'=>'1'));
  $data = $req->fetch();
 $req->closeCursor();

$your_email = $data['email'];// <<=== update to your email address

session_start();
$errors = '';
$name = '';
$visitor_email = '';
$user_message = '';

if(isset($_POST['submit']))
{
	
	$name = $_POST['name'];
	$visitor_email = $_POST['email'];
	$user_message = $_POST['message'];
	///------------Do Validations-------------
	if(empty($name)||empty($visitor_email))
	{
		$errors .= "\n Name and Email are required fields. ";	
	}
	if(IsInjected($visitor_email))
	{
		$errors .= "\n Bad email value!";
	}
	if(empty($_SESSION['6_letters_code'] ) ||
	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
	{
	//Note: the captcha code is compared case insensitively.
	//if you want case sensitive match, update the check above to
	// strcmp()
		$errors .= "\n The captcha code does not match!";
	}
	
	if(empty($errors))
	{
		//send the email
		$to = $your_email;
		$subject="Budgetminds contact";
		$from = $your_email;
		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
		
		$body = "Un utilisateur, $name vous a contacté sur Budgetminds :\n".
		"Nom: $name\n".
		"Email: $visitor_email \n".
		"Message: \n ".
		"$user_message\n".
		"IP: $ip\n";	
		
		$headers = "From: $from \r\n";
		$headers .= "Reply-To: $visitor_email \r\n";
		
		mail($to, $subject, $body,$headers);
		
		header('Location: dialogmerci.php');
	}
}

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
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
			Inscription Budgetminds
        </title>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
        <link rel="stylesheet" href="css/my.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js">
        </script>
        <script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js">
        </script>
		
		<!-- a helper script for vaidating the form-->
	<script src="js/gen_validatorv31.js" type="text/javascript"></script>	
		
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
                <h2>Contactez-nous</h2>
						<div id='contact_form_errorloc' class='err'></div>
                        <form name="contact_form" 
						action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
							 <div data-role="fieldcontain">
								<fieldset data-role="controlgroup">
									<input type="text" placeholder="Nom" name="name" value='<?php echo htmlentities($name) ?>' />
									<input type="text" placeholder="Email" name="email" value='<?php echo htmlentities($visitor_email) ?>'>
									<textarea name="message" placeholder="Message" rows=8 cols=30><?php echo htmlentities($user_message) ?></textarea>
									<p>
									<img alt="captcha" src="../captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' ><br />
									<input id="6_letters_code" placeholder="Entrez le code" name="6_letters_code" type="text"><br />
									<a data-icon="refresh" href="javascript: refreshCaptcha();" data-role="button" data-mini="true" data-inline="true">Rafraichir Captcha</a>
									</p>
									
								</fieldset>
							</div>
							<input type="submit" class="submit_button" value="Envoyer" name='submit'>
                        </form>

	
            </div>
            <div data-theme="a" data-role="footer" data-position="fixed">
                <h5>
                    © 2012 Budgetminds
                </h5>
            </div>
        </div>
		<!-- captcha -->
		<script type='text/javascript'>
		// Code for validating the form
		// Visit http://www.javascript-coder.com/html-form/javascript-form-validation.phtml
		// for details
		var frmvalidator  = new Validator("contact_form");
		//remove the following two lines if you like error message box popups
		frmvalidator.EnableOnPageErrorDisplaySingleBox();
		frmvalidator.EnableMsgsTogether();

		frmvalidator.addValidation("name","req","Entrez votre nom svp !"); 
		frmvalidator.addValidation("email","req","Entrer votre email svp !"); 
		frmvalidator.addValidation("email","email","Entrez une adresse email valable svp !"); 
		</script>
		<script type='text/javascript'>
		function refreshCaptcha()
		{
			var img = document.images['captchaimg'];
			img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
		}
		</script>
    </body>
</html>