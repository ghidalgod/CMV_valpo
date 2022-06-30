<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permisos extends CI_Controller {

    public function __construct(){
		parent::__construct();
		
		if (!$this->session->userdata("login_google")) redirect('Inicio', 'location', 301);
		
		$this->load->model('Funcionarios_model');
		
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Inicio',
											'link' =>  site_url('inicio/index')
										),
									);
    }

	public function index()	{
		$this->data['menu_items'] = array('permisos');
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Permisos/Vacaciones',
											'link' =>  site_url('Permisos')
										);

		$this->data['title'] = 'Permisos/Vacaciones';
		$this->data['subtitle'] = '';

		$this->view_handler->view('funcionario', 'permisos', $this->data);
	}

	public function getPermisos() {
		$rut = "189034377";
		$permisos = $this->Funcionarios_model->getPermisos($rut);

		echo json_encode($permisos);
		return;
			
	}


}