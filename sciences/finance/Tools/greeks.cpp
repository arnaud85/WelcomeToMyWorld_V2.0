#include <iostream>
#include <cmath>

using namespace std;



double normal(const double& z) 
{ 

	return (1.0/sqrt(2.0*M_PI))*exp(-0.5*z*z);
}

double N(const double& z) {
	
	if (z > 6.0) 
	{ 
		return 1.0; 
	}
	
	if (z < -6.0) { 
		return 0.0; 
	}
	
	double b1 = 0.31938153;
	double b2 = -0.356563782;
	double b3 = 1.781477937;
	double b4 = -1.821255978;
	double b5 = 1.330274429;
	double p = 0.2316419;
	double c2 = 0.3989423;
	
	double a = fabs(z);
	
	double t = 1.0/(1.0+a*p);
	
	double b = c2*exp((-z)*(z/2.0));
	
	double n = ((((b5*t+b4)*t+b3)*t+b2)*t+b1)*t;
	
	n = 1.0 - b*n;
	
	if ( z < 0.0 ) 
	{
		n = 1.0 - n;
	}
	
	return n;
}

double Black_Scholes_DELTA_CALL(const double& S, const double& K, const double& r, const double& sigma, const double& t)
{
	double d1 = (log(S/K) + (r/100)*t)/((sigma/100)*sqrt(t)) + 0.5*(sigma/100)*sqrt(t);
	 
	return N(d1);
}

double Black_Scholes_DELTA_PUT(const double& S, const double& K, const double& r, const double& sigma, const double& t)
{
	double d1 = (log(S/K) + (r/100)*t)/((sigma/100)*sqrt(t)) + 0.5*(sigma/100)*sqrt(t);
	 
	return N(d1) - 1;
}

double Black_Scholes_GAMMA(const double& S, const double& K, const double& r, const double& sigma, const double& t)
{	
	double d1 = (log(S/K) + (r/100)*t)/((sigma/100)*sqrt(t)) + 0.5*(sigma/100)*sqrt(t);
	 
	return normal(d1)/(S*(sigma/100)*sqrt(t));
}

double Black_Scholes_THETA_CALL(const double& S, const double& K, const double& r, const double& sigma, const double& t)
{	
	double d1 = (log(S/K) + (r/100)*t)/((sigma/100)*sqrt(t)) + 0.5*(sigma/100)*sqrt(t);
	double d2 = d1 - ((sigma/100)*sqrt(t));
	 
	return -(S*(sigma/100)*normal(d1))/(2*sqrt(t)) - (r/100)*K*exp(-(r/100)*t)*N(d2);
}

double Black_Scholes_THETA_PUT(const double& S, const double& K, const double& r, const double& sigma, const double& t)
{	
	double d1 = (log(S/K) + (r/100)*t)/((sigma/100)*sqrt(t)) + 0.5*(sigma/100)*sqrt(t);
	double d2 = d1 - ((sigma/100)*sqrt(t));
	 
	return -(S*(sigma/100)*normal(d1))/(2*sqrt(t)) + (r/100)*K*exp(-(r/100)*t)*N(-d2);
}

double Black_Scholes_VEGA(const double& S, const double& K, const double& r, const double& sigma, const double& t)
{	
	double d1 = (log(S/K) + (r/100)*t)/((sigma/100)*sqrt(t)) + 0.5*(sigma/100)*sqrt(t);
	 
	return S*sqrt(t)*normal(d1);
}

double Black_Scholes_RHO_CALL(const double& S, const double& K, const double& r, const double& sigma, const double& t)
{
	double d1 = (log(S/K) + (r/100)*t)/((sigma/100)*sqrt(t)) + 0.5*(sigma/100)*sqrt(t);
	double d2 = d1 - ((sigma/100)*sqrt(t));
	
	return K*t*exp(-(r/100)*t)*N(d2);
}

double Black_Scholes_RHO_PUT(const double& S, const double& K, const double& r, const double& sigma, const double& t)
{
	double d1 = (log(S/K) + (r/100)*t)/((sigma/100)*sqrt(t)) + 0.5*(sigma/100)*sqrt(t);
	double d2 = d1 - ((sigma/100)*sqrt(t));
	
	return -K*t*exp(-(r/100)*t)*N(-d2);
}

int main()
{
	double S; 		//Prix de l'action (dollars)
	double K; 		//Prix d'exercice (dollars)
	double r; 		//Taux d'interet (%) 
	double sigma; 	//volatilite (%)
	double t;		//Duree (an)
	
	
	cout << "******** BLACK-SCHOLES : LES GRECQUES ********" << endl << endl;
	
	cout << "Veuillez saisir la valeur du prix de l'action :" << endl;
	cin >> S;
	cout << "Veuillez saisir la valeur du prix d'exercice :" << endl;
	cin >> K;
	cout << "Veuillez saisir la valeur du taux d'interet :" << endl;
	cin >> r;
	cout << "Veuillez saisir la valeur de la volatilite :" << endl;
	cin >> sigma;
	cout << "Veuillez saisir la duree d'evaluation :" << endl;
	cin >> t;
	cout << endl << endl;
	
	cout << "Les parametres sont :" << endl << endl;
	cout << "Prix de l'action S = " << S << " dollars" << endl 
	<< "Strike K = " << K << " dollars" << endl
	<< "Taux d'interet r = " << r << " %" << endl
	<< "Volatilite sigma = " << sigma << " %" << endl
	<< "Maturite t = " << t << " an" << endl
	<< endl << endl;
	
	cout << "DELTA call = " << Black_Scholes_DELTA_CALL(S, K, r, sigma, t) << endl;
	cout << "DELTA put = " << Black_Scholes_DELTA_PUT(S, K, r, sigma, t) << endl;
	
	cout << "GAMMA = " << Black_Scholes_GAMMA(S, K, r, sigma, t) << endl;
	
	cout << "THETA call = " << Black_Scholes_THETA_CALL(S, K, r, sigma, t) << endl;
	cout << "THETA put = " << Black_Scholes_THETA_PUT(S, K, r, sigma, t) << endl;
	
	cout << "VEGA = " << Black_Scholes_VEGA(S, K, r, sigma, t) << endl;
	
	cout << "RHO call = " << Black_Scholes_RHO_CALL(S, K, r, sigma, t) << endl;
	cout << "RHO put = " << Black_Scholes_RHO_PUT(S, K, r, sigma, t) << endl;
	cout << endl;
	
	return 0;	
}