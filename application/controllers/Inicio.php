<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends MY_Controller {
 
    public function __construct() 
    {
		parent::__construct();
		$this->load->model('Noticias_model');
		$this->load->model('Inicio_model');
		$this->load->model('Casos_model');
		$this->load->model('Laboral_model');
		$this->load->model('SumarioSalud_model');


		/*
			Breadcrumb:
			Por cada nivel que se desee mostrar, se agrega un array con la siguiente estructura 
			array(
			
				'name' => 'Nombre',
				'link' => 'http://www.pagina.com/nombre'
			)
		*/
		$this->data['breadcrumb'] = array(
			array(
				'name' => 'Inicio',
				'link' =>  site_url('inicio/index')
			)
		);
		/*
			Contiene los menú seleccionados
			Ejemplo:
			$data['menu_items'] = array(
				'menu1',
				'submenu1',
				'subsubmenu1'
			);
		*/
		$this->data['menu_items'] = array(
			'inicio',
		);

		if($this->ion_auth->in_group('juridica1')){
			$this->data['avatar'] = 'profesor.jpg';
			$this->data['avatar_descrip'] = 'Imagen avatar Usuario 1';
			$this->data['avatar_nombre'] = 'Usuario 1';
		}
    }

	public function index(){
		
		$this->data['title'] = 'FALSE';
		$this->data['subtitle'] = 'Sistemas externos';
		$this->data['tabla']   = $this->Inicio_model->verifyDatesFile(); //VERIFICAR Y MOSTRAR LOS FERIADOS
		$this->data['noticias'] = $this->Noticias_model->cardsNoticias();//CARDS CON LAS NOTICIAS DEL AÑO
		$this->data['resumen'] = $this->Inicio_model->getResumen();
		$this->view_handler->view('inicio', 'main', $this->data);
		
	}
	
	public function getCausas(){
		if($this->ion_auth->in_group(array(22,23))){
			$data = $this->Laboral_model->datatable();
			echo json_encode($data);
			return;
		}
	}

	public function getSumario(){
		if($this->ion_auth->in_group(array(22,23))){
			$data = $this->SumarioSalud_model->datatable();
			echo json_encode($data);
			return;
		}
	}


}
