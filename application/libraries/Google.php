<?php
/**
 * Nombre:    Google Auth
 * Autor:  Jorge Ortiz
 *          jortizd@cmvalparaiso.cl
 *
 *
 * Creado:  18.11.2019
 *
 * Descripción:  Libreria que facilita el uso y control de autentificación con cuenta google cmvalparaiso.cl usando OAUTH2..
 *				
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//Libreria base de autenticación de google implementada con protocolo Aouth2 
//ref: https://github.com/googleapis/google-api-php-client
require_once '/home/cmvalpar/public_html/td/vendor/autoload.php';

class Google {
	//Constantes de conección
	const CLIENT_ID = "911332213087-vnd1ahs4oks63unb0suhvigralijc99q.apps.googleusercontent.com";
    const CLIENT_SECRET = "HrpOI9zBUZjsaqN-fl6K0fZ4";
    const REDIRECT_URI = "https://www.buscadorprocess.cmvalparaiso.cl/index.php/googleAuth/logincmv";
    const HOSTED_DOMAIN = "cmvalparaiso.cl";
    const APP_NAME = "Intraned TD CMV";
    
	const COOKIE_NAME = 'COOKIE_GOOGLE';
	const REMEMBER_COOKIE_NAME = 'REMEMBER_COOKIE_GOOGLE'; 
	
	public function __construct()
	{
		//$this->load->library(array('email'));
		
		//$this->load->helper(array('cookie', 'language', 'url'));

		//$this->load->library('session');

		//$this->load->model('');

	}
	
	/**
	 * login
	 *
	 * Crea una conección para que el usuario se pueda logiar con su cuenta google cmvalparaiso.cl
	 * 
	 *
	 * @return mixed
	 */
	public function login(){
		//Se crea un objeto google_client para iniciar y tratar la conección con google
		$client = new Google_Client();
		//Datos de conección
        $client->setApplicationName(self::APP_NAME);
        $client->setClientId(self::CLIENT_ID);
        $client->setClientSecret(self::CLIENT_SECRET);
        $client->setHostedDomain(self::HOSTED_DOMAIN);
        $client->setRedirectUri(self::REDIRECT_URI);
        //Servicio del usuario al cual se quiere acceder, en este caso como sera loggin
        //Solo se pide permisos para ver el profile,
        $client->addScope("profile");
        //Link de autenticación pora que un usuario ingrese a la ventana de google y seleccione la cuenta
        //que usara para loggiarce
        $authUrl = $client->createAuthUrl();


        $code = isset($_GET['code']) ? $_GET['code'] : NULL;
        
        if(isset($code)) {
		    try {
		        $token = $client->fetchAccessTokenWithAuthCode($code);
		        //$this->newSession($token);
		        $client->setAccessToken($token);
		    }catch (Exception $e){
		        echo $e->getMessage();
		    }
		    try {
		        $pay_load = $client->verifyIdToken();
		        return $pay_load;
		    }catch (Exception $e) {
		        echo $e->getMessage();
		    }
		} else{
		    header('Location: '.$authUrl);
		}

	}
	
	public function logout(){
		// delete the remember me cookies if they exist
		if (get_cookie(self::COOKIE_NAME)){
			delete_cookie(self::COOKIE_NAME);
		}
		if (get_cookie(self::REMEMBER_COOKIE_GOOGLE)){
			delete_cookie(self::REMEMBER_COOKIE_GOOGLE);
		}
		
		// Destroy the session
		$this->session->sess_destroy();
		//Recreate the session
		if (substr(CI_VERSION, 0, 1) == '2'){
			$this->session->sess_create();
		}	else{
				if (version_compare(PHP_VERSION, '7.0.0') >= 0)	{
					session_start();
				}
				$this->session->sess_regenerate(TRUE);
			}

		$this->set_message('logout_successful');
		return TRUE;
	}
	
	private function newSession(){
		//TO-DO: Guarda en la session del user, el token de autenticacion
	}
	
	private function deleteSession(){
		//TO-DO: Elimina la session del usuario y su token de autenticación
	}
	
	public function checkTokenExpiration(){
		//TO-DO: usando el token guardado en la session de usuario, comprueba si el token aun es valido
	}
	
}