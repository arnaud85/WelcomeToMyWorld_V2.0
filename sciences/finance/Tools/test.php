<!DOCTYPE html>

<html lang="fr">

<head>
</head>
	
<body>
	<?php include($_SERVER["DOCUMENT_ROOT"] . '/sciences/finance/Tools/financial_box.php'); ?>
			
			<?php
				$S = 100;
				$K = 100;
				$r = 2.5;
				$u = 5;
				$d = 5;
				$n = 2;
			
				echo 'S = ' . $S . '<br/>';
				echo 'K = ' . $K . '<br/>';
				echo 'r = ' . $r . '<br/>';
				echo 'Up = ' . $u . '<br/>';
				echo 'Down = ' . $d . '<br/>';
				echo 'Periods = ' . $n . '<br/>';
						
				echo 'Bin_call_1p = ' . binomial_single_period_call_u_d($S, $K, $r, $u, $d) . '<br/>';
				echo 'Bin_put_1p = ' . binomial_single_period_put_u_d($S, $K, $r, $u, $d) . '<br/>';
				echo 'Bin_call_mp = ' . binomial_call_u_d($S, $K, $r, $u, $d, $n) . '<br/>';
				echo 'Bin_put_mp = ' . binomial_put_u_d($S, $K, $r, $u, $d, $n) . '<br/>';
			?>

</body>
</html>