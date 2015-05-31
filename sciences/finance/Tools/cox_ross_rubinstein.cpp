#include <iostream>
#include <cmath>
#include <vector>

using namespace std;

double binomial_call_u_d(const double& S, const double& K, const double& r, const double& up, const double& down, const int& n_steps)
{ 

	double u = 1 + (up/100);
	double d = 1 - (down/100);
	double p_up = (exp(r/100) - d)/(u - d);
	double p_down = 1.0 - p_up;
	
	vector<double> prices(n_steps + 1); 
	prices[0] = S*pow(d, n_steps); 
	
	for (int i = 1; i <= n_steps; ++i)
	{
		prices[i] = u*u*prices[i - 1];
	}
	
	vector<double> call_values(n_steps + 1); 
	for (int i = 0; i <= n_steps; ++i) 
	{ 
		call_values[i] = max(0.0, (prices[i] - K));
	}
	
	for (int j = n_steps - 1; j >= 0; --j)
	{
		for (int i = 0; i <= j; ++i) 
		{
			call_values[i] = (p_up*call_values[i + 1] + p_down*call_values[i])*exp(-r/100);
		}
	}
	return call_values[0];
}

double binomial_put_u_d(const double& S, const double& K, const double& r, const double& up, const double& down, const int& n_steps)
{ 
	
	double u = 1 + (up/100);
	double d = 1 - (down/100);
	double p_up = (exp(r/100) - d)/(u - d);
	double p_down = 1.0 - p_up;
	
	vector< double > prices(n_steps + 1); 
	prices[0] = S*pow(d, n_steps);
	 
	for (int i = 1; i <= n_steps; ++i) 
	{
		prices[i] = u*u*prices[i - 1];
	}
	
	vector<double> put_values(n_steps + 1); 
	for (int i = 0; i <= n_steps; ++i)
	{
		put_values[i] = max(0.0, (K - prices[i]));
	}  
	
	for (int j = n_steps - 1; j >= 0; --j) 
	{
		for (int i = 0; i <= j; ++i) {
			
			put_values[i] = (p_up*put_values[i + 1] + p_down*put_values[i])*exp(-r/100);
		}
	}
	
	return put_values[0];
}



int main()
{
	double S; 	//Prix de l'action (dollars)
	double K;	//Prix d'exercice (dollars)
	double r; 	//Taux d'interet (%)
	double up;	//Valuation a la hausse (%)
	double down;	//Valuation a la baisse (%)
	int n;		//Nombre de periodes
	
	
	cout << "******** PRICING OPTION EUROPEENNE AVEC COX-ROSS-RUBINSTEIN ********" << endl << endl;
	
	cout << "Veuillez saisir la valeur du prix de l'action :" << endl;
	cin >> S;
	cout << "Veuillez saisir la valeur du prix d'exercice :" << endl;
	cin >> K;
	cout << "Veuillez saisir la valeur du taux d'interet :" << endl;
	cin >> r;
	cout << "Veuillez saisir le pourcentage d'augmentation maximum du prix de l'action :" << endl;
	cin >> up;
	cout << "Veuillez saisir le pourcentage de diminution maximum du prix de l'action :" << endl;
	cin >> down;
	cout << "Veuillez saisir le nombre de periode d'evaluation :" << endl;
	cin >>n;
	cout << endl << endl;
	
	
	
	cout << "Les parametres sont :" << endl << endl;
	cout << "Prix de l'action S = " << S << " dollars" << endl 
	<< "Strike K = " << K << " dollars" << endl
	<< "Taux d'interet r = " << r << " %" << endl
	<< "Valuation a la hausse = " << up << " %" << endl
	<< "Valuation a la baisse = " << down << " %" << endl
	<< "Nombre de periodes n = " << n << endl
	<< endl << endl;
	
	cout << "CALL = " << binomial_call_u_d(S, K, r, up, down, n) <<  " dollars" << endl;
	cout << "PUT = " << binomial_put_u_d(S, K, r, up, down, n) << " dollars" << endl;
	
	cout << endl << endl;
	
	return 0;	
}