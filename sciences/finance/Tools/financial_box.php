<?php

function rand_0_1()
{
	srand(time(NULL));	

	return mt_rand()/mt_getrandmax();
}

function normal_distribution($x) 
{ 
		return (1.0/sqrt(2.0*pi()))*exp(-0.5*$x*$x);
}

function random_normal_distribution()
{
	$S = 2;

	while ($S >= 1) 
	{
		$a = 2.0*rand_0_1() - 1.0;
		$b = 2.0*rand_0_1() - 1.0;
		$S = pow($a, 2) + pow($b, 2);
	}

	return $a*sqrt(-2.0*log($S)/$S);
}

function cumulative_normal_distribution($x)
{
	
	if ($x > 6.0) 
	{ 
		return 1.0; 
	}
	
	if ($x < -6.0) { 
		return 0.0; 
	}
	
	$b1 = 0.31938153;
	$b2 = -0.356563782;
	$b3 = 1.781477937;
	$b4 = -1.821255978;
	$b5 = 1.330274429;
	$p = 0.2316419;
	$c2 = 0.3989423;
	
	$t = 1.0/(1.0 + abs($x)*$p);
	
	$b = $c2*exp(-$x*$x/2.0);
	
	$n = (((($b5*$t + $b4)*$t + $b3)*$t + $b2)*$t + $b1)*$t;
	
	$n = 1.0 - $b*$n;
	
	if ( $x < 0.0 ) 
	{
		$n = 1.0 - $n;
	}
	
	return $n;
}

function Black_Scholes_CALL($S, $K, $r, $sigma, $t)
{
	$d1 = (log($S/$K) + ($r/100)*$t)/(($sigma/100)*sqrt($t)) + 0.5*($sigma/100)*sqrt($t);
	$d2 = $d1 - (($sigma/100)*sqrt($t));
	
	return $S*cumulative_normal_distribution($d1) - $K*exp(-($r/100)*$t)*cumulative_normal_distribution($d2);	
}

function Black_Scholes_PUT($S, $K, $r, $sigma, $t)
{
	$d1 = (log($S/$K) + ($r/100)*$t)/(($sigma/100)*sqrt($t)) + 0.5*($sigma/100)*sqrt($t);
	$d2 = $d1 - (($sigma/100)*sqrt($t));
	
	return $K*exp(-($r/100)*$t)*cumulative_normal_distribution(-$d2) - $S*cumulative_normal_distribution(-$d1);	
}

function Black_Scholes_DELTA_CALL($S, $K, $r, $sigma, $t)
{
	$d1 = (log($S/$K) + ($r/100)*$t)/(($sigma/100)*sqrt($t)) + 0.5*($sigma/100)*sqrt($t);
	
	return cumulative_normal_distribution($d1);
}

function Black_Scholes_DELTA_PUT($S, $K, $r, $sigma, $t)
{
	$d1 = (log($S/$K) + ($r/100)*$t)/(($sigma/100)*sqrt($t)) + 0.5*($sigma/100)*sqrt($t);
	
	return cumulative_normal_distribution($d1) - 1;
}

function Black_Scholes_GAMMA($S, $K, $r, $sigma, $t)
{	
	$d1 = (log($S/$K) + ($r/100)*$t)/(($sigma/100)*sqrt($t)) + 0.5*($sigma/100)*sqrt($t);
	 
	return normal_distribution($d1)/($S*($sigma/100)*sqrt($t));
}

function Black_Scholes_THETA_CALL($S, $K, $r, $sigma, $t)
{	
	$d1 = (log($S/$K) + ($r/100)*$t)/(($sigma/100)*sqrt($t)) + 0.5*($sigma/100)*sqrt($t);
	$d2 = $d1 - (($sigma/100)*sqrt($t));
	 
	return -($S*($sigma/100)*normal_distribution($d1))/(2*sqrt($t)) - ($r/100)*$K*exp(-($r/100)*$t)*cumulative_normal_distribution($d2);
}

function Black_Scholes_THETA_PUT($S, $K, $r, $sigma, $t)
{	
	$d1 = (log($S/$K) + ($r/100)*$t)/(($sigma/100)*sqrt($t)) + 0.5*($sigma/100)*sqrt($t);
	$d2 = $d1 - (($sigma/100)*sqrt($t));
	 
	return -($S*($sigma/100)*normal_distribution($d1))/(2*sqrt($t)) + ($r/100)*$K*exp(-($r/100)*$t)*cumulative_normal_distribution(-$d2);
}

function Black_Scholes_VEGA($S, $K, $r, $sigma, $t)
{	
	$d1 = (log($S/$K) + ($r/100)*$t)/(($sigma/100)*sqrt($t)) + 0.5*($sigma/100)*sqrt($t);
	
	return $S*sqrt($t)*normal_distribution($d1);
}

function Black_Scholes_RHO_CALL($S, $K, $r, $sigma, $t)
{
	$d1 = (log($S/$K) + ($r/100)*$t)/(($sigma/100)*sqrt($t)) + 0.5*($sigma/100)*sqrt($t);
	$d2 = $d1 - (($sigma/100)*sqrt($t));

	return $K*$t*exp(-($r/100)*$t)*cumulative_normal_distribution($d2);
}

function Black_Scholes_RHO_PUT($S, $K, $r, $sigma, $t)
{
	$d1 = (log($S/$K) + ($r/100)*$t)/(($sigma/100)*sqrt($t)) + 0.5*($sigma/100)*sqrt($t);
	$d2 = $d1 - (($sigma/100)*sqrt($t));

	return -$K*$t*exp(-($r/100)*$t)*cumulative_normal_distribution(-$d2);
}

function binomial_single_period_call_u_d($S, $K, $r, $up, $down)
{
	$up = 1 + ($up/100);
	$down = 1 - ($down/100);
	$p_up = (exp($r/100) - $down)/($up - $down);
	$p_down = 1.0 - $p_up;
	$call_up = max(0.0,($up*$S - $K));
	$call_down = max(0.0,($down*$S - $K));
	
	return exp(-$r/100)*($p_up*$call_up + $p_down*$call_down);
	
}

function binomial_single_period_put_u_d($S, $K, $r, $up, $down)
{
	$up = 1 + ($up/100);
	$down = 1 - ($down/100);
	$p_up = (exp($r/100) - $down)/($up - $down);
	$p_down = 1.0 - $p_up;
	$put_up = max(0.0, ($K - $up*$S));
	$put_down = max(0.0, ($K - $down*$S));
	
	return exp(-($r/100))*($p_up*$put_up + $p_down*$put_down);
}

function binomial_call_u_d($S, $K, $r, $up, $down, $steps)
{ 	
	$up = 1 + ($up/100);
	$down = 1 - ($down/100);
	$p_up = (exp($r/100) - $down)/($up - $down);
	$p_down = 1.0 - $p_up;
	
	$prices = array(); 
	$prices[0] = $S*pow($down, $steps); 
	for ($i = 1; $i <= $steps; ++$i) 
	{
		$prices[$i] = $up*$up*$prices[$i - 1];
	}
	
	$call_values = array(); 
	for ($i = 0; $i <= $steps; ++$i)
	{
		$call_values[$i] = max(0.0, ($prices[$i] - $K));
	}  
	
	for ($j = $steps - 1; $j >= 0; --$j) 
	{
		for ($i = 0; $i <= $j; ++$i) {
			
			$call_values[$i] = ($p_up*$call_values[$i + 1] + $p_down*$call_values[$i])*exp(-($r/100));
		}
	}
	
	return $call_values[0];
}

function binomial_put_u_d($S, $K, $r, $up, $down, $steps)
{ 	
	$up = 1 + ($up/100);
	$down = 1 - ($down/100);
	$p_up = (exp($r/100) - $down)/($up - $down);
	$p_down = 1.0 - $p_up;
	
	$prices = array(); 
	$prices[0] = $S*pow($down, $steps); 
	for ($i = 1; $i <= $steps; ++$i) 
	{
		$prices[$i] = $up*$up*$prices[$i - 1];
	}
	
	$put_values = array(); 
	for ($i = 0; $i <= $steps; ++$i)
	{
		$put_values[$i] = max(0.0, ($K - $prices[$i]));
	}  
	
	for ($j = $steps - 1; $j >= 0; --$j) 
	{
		for ($i = 0; $i <= $j; ++$i) {
			
			$put_values[$i] = ($p_up*$put_values[$i + 1] + $p_down*$put_values[$i])*exp(-($r/100));
		}
	}
	
	return $put_values[0];
}

?>