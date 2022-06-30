<?php defined('BASEPATH') OR exit('No direct script access allowed');


class GoogleAuth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	
	    if ($this->ion_auth->logged_in()) redirect('/');
	    
		$this->load->model('Google_auth_model');
	}

	public function index()
	{
	}

	// /**
	//  * Log the user in
	//  */
	// public function logincmv(){
	// 	$usuario = $this->google->login();
	// 	if (!empty($usuairo)){
	// 			//if the login is successful
	// 			//redirect them back to the home page
	// 			$this->session->set_flashdata('message', 'Usuario ingresado');
	// 			echo ' Controller usuario ingreado';
	// 		}	else{
	// 				// if the login was un-successful
	// 				// redirect them back to the login page
	// 				$this->session->set_flashdata('message', 'Usuario denegado');
	// 				echo ' Controller Usuario denegado';
	// 				//redirect('auth/login'); // use redirects instead of loading views for compatibility with MY_Controller libraries
	// 			}
			
	// 		//$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'login', $this->data);
	// }

	/**
	 * Log the user out
	 */
	public function logout(){
		// redirect them to the login page
		$this->session->set_flashdata('message', 'Usuario cerrado');
		redirect('Inicio');
	}

	/**
	* Redirect a user checking if is admin
	*/
	public function redirectUser(){

	}
	
	public function ingresarConGoogle() {
	    
		require_once APPPATH . 'libraries/vendor/autoload.php';
		
		$google_client = new Google_Client();
		$google_client->setClientId('695268222744-nh9n7jj62clf1hdhssub7ltbgppolb2n.apps.googleusercontent.com');
		$google_client->setClientSecret('PmcCHqRZ5D2DYPb4D4CnUz02');
		$google_client->setPrompt('select_account');
		$google_client->addScope('email');
		$google_client->addScope('profile');
		$url = "http://tdcmvalparaiso.cl/codiad/workspace/desarrollo/index.php/googleAuth/ingresarConGoogle";
		$google_client->setRedirectUri($url);

		
		if (isset($_GET['code'])) {
			
			$token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

			if (!isset($token['error'])) {
				$google_client->setAccessToken($token['access_token']);

				$this->session->set_userdata('access_token', $token['access_token']);

				$google_service = new Google_Service_Oauth2($google_client);

				$data = $google_service->userinfo->get();
				
				$current_datetime = date('Y-m-d H:i:s');

				if ($this->Google_auth_model->Is_already_register($data['id'])) {
					$user_data = array (
						'first_name' => $data['given_name'],
						'last_name' => $data['family_name'],
						'email_address' => $data['email'],
						'profile_picture' => $data['picture'],
						'updated_at' => $current_datetime
					);

					$this->Google_auth_model->Update_user_data($user_data, $data['id']);
				} else {
					$user_data = array (
						'login_oauth_uid' => $data['id'],
						'first_name' => $data['given_name'],
						'last_name' => $data['family_name'],
						'email_address' => $data['email'],
						'profile_picture' => $data['picture'],
						'created_at' => $current_datetime
					);

					$this->Google_auth_model->Insert_user_data($user_data);
				}
				
				$this->session->set_userdata('login_google', true);
				$this->session->set_userdata('user_data', $user_data);
				
			}
		}

		if (!$this->session->userdata('access_token')) {
			redirect($google_client->createAuthUrl());
		}
		
		redirect('InicioFuncionario');
		
	}
	

}
