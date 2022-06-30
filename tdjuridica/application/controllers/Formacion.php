<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formacion extends CI_Controller {

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
		$this->data['menu_items'] = array('infoPersonal', 'formacion');
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Información de formación o profesional',
											'link' =>  site_url('Formacion')
										);

		$this->data['title'] = 'Datos personales';
		$this->data['subtitle'] = 'Información de formación o profesional';
		
		$this->data['funcionario'] = $this->getInfoFormacionOProfesional();

		$this->view_handler->view('funcionario', 'formacion', $this->data);
	}
	
	private function getInfoFormacionOProfesional() {
		$data = $this->Funcionarios_model->getInfoFormacionOProfesional("189034377");
		return $data;
	}


}