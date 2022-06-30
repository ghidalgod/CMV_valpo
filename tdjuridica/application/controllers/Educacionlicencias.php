<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Educacionlicencias extends MY_Controller {
    
    public function __construct() 
    {
		parent::__construct();
		// Libraries
	    $this->load->model('Educacion_model');

	    // Helpers
	    $this->load->helper('date');
	    $this->load->helper('array');
		$this->data['breadcrumb'] = array(
			array(
				'name' => 'Licencias médicas',
				'link' =>  site_url('Educacionlicencias/index')
			)
		);
		$this->data['menu_items'] = array(
			'Educación',
		);
		$this->data['errors'] = array();
    }

	public function index(){
		if($this->ion_auth->in_group(1)){
			$this->data['title'] = 'Licencias médicas de Educación';
			$this->data['subtitle'] = 'Licencias médicas';
			$this->view_handler->view('Educacion', 'licencias',$this->data);
		}
	}
	
	public function getLicenciasMedicas(){
		$data = $this->Educacion_model->getAll();
        echo json_encode($data);
        return;
	}
}