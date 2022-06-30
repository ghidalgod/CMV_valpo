<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InicioFuncionario extends CI_Controller {
 
    public function __construct() 
    {
		parent::__construct();
		
		if (!$this->session->userdata("login_google")) redirect('Inicio', 'location', 301);
		
		$this->load->model('Inicio_model');
		/*
			Breadcrumb:
			Por cada nivel que se desee mostrar, se agrega un array con la siguiente estructura 
			array(
				'name' => 'Nombre',
				'link' => 'http://www.pagina.com/nombre'
			)
		*/
		$this->data['breadcrumb'] = array(
			array(
				'name' => 'Inicio',
				'link' =>  site_url('inicio/index')
			)
		);

		$this->data['menu_items'] = array(
			'inicio',
		);
    }

	public function index(){
		
		$this->data['title'] = 'FALSE';
		$this->data['subtitle'] = '';
		
		$this->view_handler->view('funcionario', 'inicio', $this->data);
	}
}
