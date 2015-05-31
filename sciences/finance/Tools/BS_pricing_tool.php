<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Black-Scholes : simulation</title>
	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/css/style.css">
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
			
			<h1>TP : Pricing avec Black-Scholes</h1>			

			<p>Après la théorie vient la pratique !</p> 
			
			<p>L'outil ci-dessous permet de calculer un <em>Call</em> ainsi qu'un <em>Put</em>
			dans le cas du modèle de <em>Black-Scholes</em>. Pas mal, non ?<br/></p>

			<p>Rentrez donc les valeurs que vous souhaitez donner pour le prix de l'actif financier, le prix d'exercice (ou <em>Strike</em>),
			le taux d'intérêt, la volatilité et enfin la durée d'estimation et le résultat obtenu va apparaitre sous vos yeux ébahis!</p>

			<p>Par exemple, avec le jeu de paramètres suivants :
			<ul>
				<li>Prix de l'action : <strong>50 dollars</strong></li>
				<li>Prix d'exercice : <strong>50 dollars</strong></li>
				<li>Taux d'intérêt : <strong>10 %</strong></li>
				<li>Volatilité : <strong>30 %</strong></li>
				<li>Durée : <strong>1 an</strong></li></p>
			</ul></p>

			<p>Nous obtenons, pour un call : <strong>8.37 dollars</strong></p>

			<p>Testez par vous mêmes : <br/></p>

			<?php
			$CallOrPut = $price = $strike = $rate = $sigma = $time = "";
			$CallOrPutErr = $priceErr = $strikeErr = $rateErr = $sigmaErr = $timeErr = $CallOrPutErr = "";
			$priceOK = $strikeOK = $rateOK = $sigmaOK = $timeOK = false;
			$BS_pricing;

			if ($_SERVER["REQUEST_METHOD"] == "POST") {

				 if (empty($_POST["CallOrPut"])) {
				     $CallOrPutErr = "Call ou Put ?";
				  } else {
				     $CallOrPut = check_input($_POST["CallOrPut"]);
				   }
				

				if (empty($_POST["price"])) {
					$priceErr = "Renseignez le prix de l'action!";
			   	} else {
					$price = check_input($_POST["price"]);
					if (!is_numeric($price) || $price<=0) {
						$priceErr = " Le prix doit être un nombre strictement positif!"; 
			     		}
					else
					{
						$priceOK = true;	
					}
			   	}
			   
				if (empty($_POST["strike"])) {
					$strikeErr = "Renseignez le prix d'exercice !";
				} else {
					$strike = check_input($_POST["strike"]);
					if (!is_numeric($strike) || $strike<=0) {
						$strikeErr = "Le strike doit être un nombre strictement positif!"; 
			     		}
					else
					{
						$strikeOK = true;	
					}
				}

				if (empty($_POST["rate"])) {
					$rateErr = "Renseignez le taux d'intérêt !";
				} else {
					$rate = check_input($_POST["rate"]);
					if (!is_numeric($rate) || $rate<=0) {
						$rateErr = "Le taux d'intérêt doit être un nombre strictement positif!"; 
			     		}
					else
					{
						$rateOK = true;	
					}
				}

				if (empty($_POST["sigma"])) {
					$sigmaErr = "Renseignez la volatilité !";
				} else {
					$sigma = check_input($_POST["sigma"]);
					if (!is_numeric($sigma) || $sigma<=0) {
						$sigmaErr = "La volatilité doit être un nombre strictement positif!"; 
			     		}
					else
					{
						$sigmaOK = true;	
					}
				}

				if (empty($_POST["time"])) {
					$timeErr = "Renseignez la durée d'exercice !";
				} else {
					$time = check_input($_POST["time"]);
					if (!is_numeric($time) || $time<=0) {
						$timeErr = "La durée d'exercice doit être un nombre strictement positif!"; 
			     		}
					else
					{
						$timeOK = true;	
					}
				}
			   
			}

			function check_input($data) {
			   
				$data = trim($data);
			   	$data = stripslashes($data);
			   	$data = htmlspecialchars($data);
			   
				return $data;
			}

			?>

			<form id="black_scholes_form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
				<p><fieldset>
					<legend>Pricing par le modèle de Black-Scholes</legend>
					<p>
						<label>Type : </label>						
						<input type="radio" name="CallOrPut" <?php if (isset($CallOrPut) && $CallOrPut=="call") echo "checked";?>  value="call">Call
						<input type="radio" name="CallOrPut" <?php if (isset($CallOrPut) && $CallOrPut=="put") echo "checked";?>  value="put">Put
						<span class="error"><?php echo $CallOrPutErr;?></span>
					</p>
					<p>
						<label>Prix de l'action : </label>
						<input type="number" name="price" step="any" min="0" value="<?php echo $price;?>" size="3" />
						<span class="error"><?php echo $priceErr;?></span>
					</p>
					<p>
						<label>Prix d'exercice : </label>
						<input type="number" name="strike" step="any" min="0" value="<?php echo $strike;?>" size="3" />
						<span class="error"><?php echo $strikeErr;?></span>
					</p>
					<p>
						<label>Taux d'intérêt : </label>
						<input type="number" name="rate" step="any" min="0" value="<?php echo $rate;?>" size="3" />
						<span class="error"><?php echo $rateErr;?></span>
					</p>
					<p>
						<label>Volatilité : </label>
						<input type="number" name="sigma" step="any" min="0" value="<?php echo $sigma;?>" size="3" />
						<span class="error"><?php echo $sigmaErr;?></span>
					<p>
						<label>Temps : </label>
						<input type="number" name="time" step="any" min="0" value="<?php echo $time;?>" size="3" />
						<span class="error"><?php echo $timeErr;?></span>
					</p>
					
					<?php					
					if($priceOK && $strikeOK && $rateOK && $sigmaOK && $timeOK)
					{
						if($CallOrPut == "call")
						{
							echo 
							'
							<p>
								<label for="call"><bold>CALL : </bold></label>
								<output type="number" size="6" >' . round(Black_Scholes_CALL($price, $strike, $rate, $sigma, $time), 2) . ' $</output>
							</p>
							';
						}
						else if($CallOrPut == "put")
						{
							echo 
							'
							<p>
								<label for="call"><bold>PUT : </bold></label>
								<output type="number" size="6" >' . round(Black_Scholes_PUT($price, $strike, $rate, $sigma, $time), 2) . ' $</output>
							</p>
							';
						}						
					}
					?>

				</fieldset></p>

				<div style="text-align:center;"><input type="submit" name="compute" value="Calculer" /></div>
			</form>
			
			<p><br/><br/><br/></p>
			
			<p>Si vous souhaitez vous-même vous entrainer à coder quelques algorithmes, je vous fournis encore une fois le code C++ reprenant 
			l'exemple ci-dessus, que vous pourrez exploiter à votre guise : 
			<a href="black_scholes.cpp" download="black_scholes.cpp"><input type="submit" value="Code C++" /></a>
			</p>

			<div class="hidden-site" id="hidden-site"></div>
					
			</div>

			<footer>Copyright © 2014 - Arnaud BIEGUN. Tous droits réservés.</footer>

		</div>

	</div>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        
    <script type="text/javascript" src="/js/app.js"></script>

    <script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"> </script>
	
</body>

</html>