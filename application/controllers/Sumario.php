<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sumario extends CI_Controller {
    public function __construct() 
    {
		parent::__construct();
		// Session
	    $this->ion_auth->redirectLoginIn();

	    // Libraries
	    $this->load->library('upload');
	    // Helpers
	    $this->load->helper('date');
	    $this->load->helper('directory');
    	// View data
		$this->data['breadcrumb'] = array(
			array(
				'name' => 'Sumario Administrativo',
				'link' =>  site_url('sumario/index')
			)
		);
		$this->data['menu_items'] = array(
			'umario'
		);
		
		$this->data['title'] = 'FALSE';
		$this->data['subtitle'] = 'Página en blanco';

		$this->load->helper('array');
    }

	public function index()	{
		if($this->ion_auth->in_group(22)) $this->view_handler->view('juridica/Flujosprocedimientos', 'VerSumario', $this->data);
	}
}
