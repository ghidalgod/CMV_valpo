<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ayuda extends MY_Controller {

    public function __construct(){
		parent::__construct();
	    $this->ion_auth->redirectLoginIn();

	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Ayuda',
											'link' =>  site_url('Ayuda/index')
										),
									);
    }

	public function index()	{
		$this->data['menu_items'] = array(
										'ayuda',
										'changelog'
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Cambios de sistema',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'Ayuda';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Historial de mejoras y cambios de plataforma';
		// Llamada a constructor de vista
		$this->view_handler->view('ayuda', 'changelog', $this->data);
	}	
	
}