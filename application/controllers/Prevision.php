<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prevision extends CI_Controller {

    public function __construct(){
		parent::__construct();
		
		if (!$this->session->userdata("login_google")) redirect('Inicio', 'location', 301);
		
		// $this->load->model('Funcionarios_model');
		
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Inicio',
											'link' =>  site_url('inicio/index')
										),
									);
    }

	public function index()	{
		$this->data['menu_items'] = array('remuneraciones', 'prevision');
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Prevision',
											'link' =>  site_url('Prevision')
										);

		$this->data['title'] = 'Remuneraciones';
		$this->data['subtitle'] = 'Prevision';

		$this->view_handler->view('funcionario', 'prevision', $this->data);
	}


}