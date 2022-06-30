<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DatosContractuales extends CI_Controller {

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
		$this->data['menu_items'] = array('contratos');
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Datos contractuales',
											'link' =>  site_url('DatosContractuales')
										);

		$this->data['title'] = 'Datos contractuales';

		$this->view_handler->view('funcionario', 'datoscontractuales', $this->data);
	}
	
	public function getMovimientosVidaFuncionaria() {
		$rut = "189034377";
		$movimientos = $this->Funcionarios_model->getVidaFuncionaria($rut);

		echo json_encode($movimientos);
		return;
			
	}


}