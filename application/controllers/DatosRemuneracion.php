<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DatosRemuneracion extends CI_Controller {

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
		$this->data['menu_items'] = array('remuneraciones', 'datosRemuneracion');
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Datos remuneración',
											'link' =>  site_url('DatosRemuneracion')
										);

		$this->data['title'] = 'Remuneraciones';
		$this->data['subtitle'] = 'Datos remuneración';

		$this->view_handler->view('funcionario', 'datosremuneracion', $this->data);
	}
	
	public function getDistribucionProgramas() {
		
		$inicio = new DateTime();
		$termino = new DateTime();
		
		$inicio->setDate(2020, 1, 1);
		$termino->setDate(2020, 3, 31);
		
		$arr = array(
			'data' => array(
				0 => array(
					'CODIGO' => "20",
					'NOMBRE' => "ODONTOLOGICO",
					'HORAS' => 22,
					'FECHA_INICIO' => $inicio,
					'FECHA_TERMINO' => $termino,
					'CENTRO_COSTO' => "CONS. CORDILLERA (K645)"
				)				
			)
		);

		echo json_encode($arr);
		return;
	}
	
	public function getDistribucionDesempeno() {
		
		$inicio = new DateTime();
		$termino = new DateTime();
		
		$inicio->setDate(2020, 1, 1);
		$termino->setDate(2020, 3, 31);
		
		$arr = array(
			'data' => array(
				0 => array(
					'CENTRO_COSTO' => "CONS. CORDILLERA (K645)",
					'HORAS' => 22,
					'CONCEPTO' => "C27 A. DES. C.D.1",
					'FECHA_INICIO' => $inicio,
					'FECHA_TERMINO' => $termino
				)				
			)
		);

		echo json_encode($arr);
		return;
	}


}