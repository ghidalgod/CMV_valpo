<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Igestion extends MY_Controller {

    public function __construct(){
		parent::__construct();
	    $this->ion_auth->redirectLoginIn();
	    $this->load->model('Igestion_model');
		
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Inicio',
											'link' =>  site_url('inicio/index')
										),
									);
    }

	public function index()	{
		if($this->session->flashdata('preloader') !== TRUE) {$this->preloader("Igestion"); return;}

		$this->data['menu_items'] = array(
										'salud',
										'personal',
										'igestion'
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Salud: Igestion',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'FALSE';
		// Llamada a constructor de vista
		$this->data['datatable'] = 	json_encode($this->Igestion_model->getTest());
		$this->view_handler->view('igestion', 'paginaBlanco', $this->data);

	}
	
}
