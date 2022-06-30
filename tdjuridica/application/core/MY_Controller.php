<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public $data = array();
    public function __construct(){
		parent::__construct();
		
		//Si el usuario se loguea con Google es enviado al inicio del funcionario y no al login
		if ($this->session->userdata("login_google")) redirect('InicioFuncionario', 'location', 301);
		
		//Confirmaci��n de usuario logiado y que no exeda el tiempo de inactividad
		$this->ion_auth->redirectLoginIn();
		
		//Define la imagen del avatar que tendra el usuario dependiendo del grupo al que pertenesca.
		$this->data['avatar'] = 'logocmv.png';
		
		if($this->ion_auth->in_group(1)){
			$this->data['avatar_descrip'] = 'Administrador';
			$this->data['avatar_nombre'] = 'Administrador';
		}
		if($this->ion_auth->in_group(3)){
			$this->data['avatar_descrip'] = 'Educación';
			$this->data['avatar_nombre'] = 'Educación';
		}
		
		if($this->ion_auth->in_group(5)){
			$this->data['avatar_descrip'] = 'Educación';
			$this->data['avatar_nombre'] = 'Educación';
			$this->data['nombreEstablecimiento'] = $this->session->userdata('nombreEstablecimiento');
		}
    }
    
    public function preloader($redirect_url = null){
    	$this->data['title'] = 'FALSE';
    	$this->session->set_flashdata('preloader', TRUE);
    	$this->data['urlPreloader'] = site_url($redirect_url);
    	$this->view_handler->view('preloader', 'circulo', $this->data);
    }
    /*
    public function preloader($url){
    	
    	//$this->session->set_flashdata('preloader', TRUE);
    	//$this->data['urlPreloader'] = site_url($URL;
  )  	//$this->view_handler->view('preloader', 'circulo', $this->data);
    }
    */
    
}
