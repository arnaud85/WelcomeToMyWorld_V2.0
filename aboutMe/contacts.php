<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Contacts</title>
	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/grid.css">
</head>
	
<body>

	<div class="pusher">

		<div class="main-container">
			
			<header>
				<a href="#" id="header_icon" class="header_icon"></a>
				<nav>
					<a href="/index.html">Accueil</a></li>
					<a href="/aboutMe/aboutMe.html">Auteur</a></li>
					<a href="/sciences/sciences.html">Sciences</a>
					<a href="/sport/sport.html">Sport</a>
					</ul>
				</nav>
			</header>

			<div class="container">
				
				<p>Si vous désirez me contacter pour me faire part de diverses remarques concernant le site ou bien pour d'éventuelles offres
				   professionnelles, n'hésitez pas à remplir le formulaire suivant : <br/><br/></p>
				
				<?php

				$destinataire = 'arnaud.biegun@gmail.com';

				$message_envoye = "Votre message a ete envoye avec succes";
				$message_non_envoye = "Echec de transmission du message, veuillez reessayer SVP.";
				$message_formulaire_invalide = "Veuillez verifier que tous les champs sont bien remplis et ne comportent aucune erreur.";


				/*
				 * To clean and save texts
				 */
				function Rec($text)
				{
					$text = htmlspecialchars(trim($text), ENT_QUOTES);
					if (1 === get_magic_quotes_gpc())
					{
						$text = stripslashes($text);
					}

					$text = nl2br($text);
					return $text;
				};

				/*
				 * To check mail syntax
				 */
				function IsEmail($email)
				{
					$value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
					return (($value === 0) || ($value === false)) ? false : true;
				}


				$name     = (isset($_POST['name']))     ? Rec($_POST['name'])     : '';
				$email   = (isset($_POST['email']))   ? Rec($_POST['email'])   : '';
				$object   = (isset($_POST['object']))   ? Rec($_POST['object'])   : '';
				$message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';


				$email = (IsEmail($email)) ? $email : ''; 
				$err_formulaire = false;

				if (isset($_POST['send']))
				{
					if (($name != '') && ($email != '') && ($object != '') && ($message != ''))
					{
						$headers  = 'From:'.$name.' <'.$email.'>' . "\r\n";
						$headers .= 'Reply-To: '.$email. "\r\n" ;
						$headers .= 'X-Mailer:PHP/'.phpversion();

						$message = str_replace("&#039;","'",$message);
						$message = str_replace("&#8217;","'",$message);
						$message = str_replace("&quot;",'"',$message);
						$message = str_replace('<br>','',$message);
						$message = str_replace('<br />','',$message);
						$message = str_replace("&lt;","<",$message);
						$message = str_replace("&gt;",">",$message);
						$message = str_replace("&amp;","&",$message);

						if (mail($destinataire, $object, $message, $headers))
						{
							echo '<p>'.$message_envoye.'</p>';
						}
						else
						{
							echo '<p>'.$message_non_envoye.'</p>';
						};
					}
					else
					{
						echo '<p>'.$message_formulaire_invalide.'</p>';
						$err_formulaire = true;
					};
				};

				if (($err_formulaire) || (!isset($_POST['send'])))
				{
					echo '
					<form id="contact" method="post" action="">
						<p><fieldset><legend>Vos coordonnees</legend>
							<p><label for="name">Nom : </label><input type="text" id="name" name="name" value="'.stripslashes($name).'" tabindex="1" /></p>
							<p><label for="email">Email : </label><input type="text" id="email" name="email" value="'.stripslashes($email).'" tabindex="2" /></p>
						</fieldset></p>

						<p><fieldset><legend>Votre message :</legend>
							<p><label for="object">Objet : </label><input type="text" id="object" name="object" value="'.stripslashes($object).'" tabindex="3" /></p>
							<p><label for="message">Message :</label></p>
							<textarea id="message" name="message" tabindex="4" cols="100" rows="10">'.stripslashes($message).'</textarea></p>
						</fieldset></p>

						<div style="text-align:center;"><input type="submit" name="send" value="Envoyer le message" /></div>
					</form>
					';
				};
				?>
				
				<p><br/><br/></p>
				
				<p>Vous avez également la possibilité de télécharger mon CV si vous le désirez : 
				<a href="/aboutMe/cv.docx"><input type="submit" value="Télécharger CV" /></a>
				</p>

				<div class="hidden-site" id="hidden-site"></div>

			</div>

			<footer>Copyright © 2014 - Arnaud BIEGUN. Tous droits réservés.</footer>

		</div>

	</div>
			
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        
    <script type="text/javascript" src="/js/app.js"></script>
	
</body>
	
</html>
