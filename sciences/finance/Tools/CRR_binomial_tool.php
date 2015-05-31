<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CRR : simulation</title>
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
			
				<h1>TP : Pricing avec le modèle CRR</h1>			

				<p>Après la théorie vient la pratique !</p> 
				
				<p>Est-ce que ça vous direz de vous glisser dans la peau d'un <em>trader</em> l'espace de quelques instants ? Oui ?
				Et bien n'attendez plus un seul instant et testez l'outil de <em>pricing</em> ci-dessous que je vous mets gracieusement à disposition,
				dans mon immense bontée!<br/></p>

				<p>Rentrez donc les valeurs que vous souhaitez donner pour le prix de l'actif financier, le prix d'exercice (ou <em>Strike</em>),
				et le taux d'intérêt. Renseignez également une estimation du pourcentage maximum d'augmentation du prix de l'action et pareillement pour
				la dévaluation.</p>

				<p>Par exemple, nous allons <em>pricer</em> une option d'achat sur un actif sous-jacent, avec les paramètres suivants :
				<ul>
					<li>Prix de l'action : <strong>100 dollars</strong></li>
					<li>Prix d'exercice : <strong>100 dollars</strong></li>
					<li>Taux d'intérêt : <strong>2,5 %</strong></li>
					<li>Valuation à la hausse (<em>up</em>) : <strong>5 %</strong></li>
					<li>Valuation à la baisse (<em>down</em>) : <strong>5 %</strong></li>
					<li>Nombre de périodes pour le modèle : <strong>2</strong></li></p>
				</ul>
				</p>

				<p>Nous obtenons, pour un call : <strong>5.23 dollars</strong></p>

				<p>Testez par vous mêmes : <br/></p>

				<?php
				$CallOrPut = $price = $strike = $rate = $up = $down = $steps = "";
				$CallOrPutErr = $priceErr = $strikeErr = $rateErr = $upErr = $downErr = $stepsErr = "";
				$priceOK = $strikeOK = $rateOK = $upOK = $downOK = $stepsOK = false;

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

					if (empty($_POST["up"])) {
						$upErr = "Renseignez une estimation de gain !";
					} else {
						$up = check_input($_POST["up"]);
						if (!is_numeric($up) || $up<=0) {
							$upErr = "Le gain doit être un nombre strictement positif!"; 
				     		}
						else
						{
							$upOK = true;	
						}
					}

					if (empty($_POST["down"])) {
						$downErr = "Renseignez une estimation de perte !";
					} else {
						$down = check_input($_POST["down"]);
						if (!is_numeric($down) || $down<=0) {
							$downErr = "La perte doit être un nombre strictement positif!"; 
				     		}
						else
						{
							$downOK = true;	
						}
					}

					if (empty($_POST["steps"])) {
						$stepsErr = "Renseignez le nombre de pas !";
					} else {
						$steps = check_input($_POST["steps"]);
						if (!is_numeric($steps) || $steps<=0) {
							$stepsErr = "Nombre entier strictement positif !"; 
				     		}
						else
						{
							$stepsOK = true;	
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
						<legend>Pricing par le modèle de Cox-Ross-Rubinstein</legend>
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
							<label>Up : </label>
							<input type="number" name="up" step="any" min="0" value="<?php echo $up;?>" size="3" />
							<span class="error"><?php echo $upErr;?></span>
						<p>
							<label>Down : </label>
							<input type="number" name="down" step="any" min="0" value="<?php echo $down;?>" size="3" />
							<span class="error"><?php echo $downErr;?></span>
						</p>

						<p>
							<label>Nombre de pas : </label>
							<input type="number" name="steps" min="1" value="<?php echo $steps;?>" size="3" />
							<span class="error"><?php echo $stepsErr;?></span>
						</p>
						
						<?php					
						if($priceOK && $strikeOK && $rateOK && $upOK && $downOK && $stepsOK)
						{
							if($CallOrPut == "call")
							{
								echo 
								'
								<p>
									<label for="call"><bold>CALL : </bold></label>
									<output type="number" size="6" >' . round(binomial_call_u_d($price, $strike, $rate, $up, $down, $steps), 2) . 
									' $</output>
								</p>
								';
							}
							else if($CallOrPut == "put")
							{
								echo 
								'
								<p>
									<label for="call"><bold>PUT : </bold></label>
									<output type="number" size="6" >' . round(binomial_put_u_d($price, $strike, $rate, $up, $down, $steps), 2) . 
									' $</output>
								</p>
								';
							}						
						}
						?>

					</fieldset></p>

					<div style="text-align:center;"><input type="submit" name="compute" value="Calculer" /></div>
				</form>
			
				<p><br/><br/><br/></p>
				
				<p>Si vous souhaitez vous-même vous entrainer à coder quelques algorithmes, je vous fournis un code en C++ reprenant l'exemple 
				ci-dessus, que vous pourrez exploiter à votre guise : 
				<a href="cox_ross_rubinstein.cpp" download="cox_ross_rubinstein.cpp"><input type="submit" value="Code C++" /></a>
				</p>
				
				<p>D'autre part, n'hésitez pas à faire un tour du côté du <a href="/sciences/finance/Annex/Code.php">formulaire</a> si vous souhaitez 
				avoir les algorithmes, déja codés en C++, des formules utilisées tout au long de cet exposé. 
				Vous y trouverez certainement votre bonheur !</p>

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