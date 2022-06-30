<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TipoPago extends CI_Controller {

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
		$this->data['menu_items'] = array('remuneraciones', 'tipoPago');
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Tipo de pago',
											'link' =>  site_url('TipoPago')
										);

		$this->data['title'] = 'Remuneraciones';
		$this->data['subtitle'] = 'Tipo de pago';

		$this->view_handler->view('funcionario', 'tipopago', $this->data);
	}
}