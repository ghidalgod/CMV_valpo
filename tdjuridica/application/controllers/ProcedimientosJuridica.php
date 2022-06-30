<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class ProcedimientosJuridica extends CI_Controller{
    private $data = array();
    private $filebase;

    public function __construct(){
       	parent::__construct();
		// Session
	    $this->ion_auth->redirectLoginIn();
	    // Config
	    // Models
	    //Crear el archivos en carpeta model con nombre reemplazante_model
	    //$this->load->model('casos_model', 'this_model');

	    // Libraries
	    $this->load->library('upload');
	    // Helpers
	    $this->load->helper('date');
	    $this->load->helper('directory');
    	// View data
		$this->data['title'] = 'FALSE';
		$this->data['subtitle'] = 'Página en blanco';
		$this->data['observaciones'] = 'Observaciones'; //REVISAR
		$this->data['breadcrumb'] = array(
			array(
				'name' => 'Flujo Procedimientos',
				'link' =>  site_url('procedimientos/index')
			)
		);
		$this->data['menu_items'] = array(
			'procedimientos'
		);
		
		$this->load->helper('array');
		if($this->ion_auth->in_group(1)){
			$this->data['avatar'] = 'boss.png';
			$this->data['avatar_descrip'] = 'Imagen avatar admin';
			$this->data['avatar_nombre'] = 'Administrador';
		}

		if($this->ion_auth->in_group(3)){
			$this->data['avatar'] = 'usuario.jpg';
			$this->data['avatar_descrip'] = 'Imagen avatar Usuario';
			$this->data['avatar_nombre'] = 'Usuario';
		}
		if($this->ion_auth->in_group(array(1,2,3,4,5,6,7,8))){
			$idCuenta = $this->session->userdata('user_id');
			$uploadPath = './files/avatar/cuentas/' .$idCuenta. '/';
			$map = directory_map($uploadPath,1);
			if(!empty($map)) $this->data['avatarP'] = 'files/avatar/cuentas/' .$idCuenta. '/'. $map[0];
		}
    

    }

    public function index($id_caso = null){
        
    }

    public function procedimientos(){
       if($this->ion_auth->in_group(array('juridica1','abogado'))) $this->view_handler->view('juridica','menu', $this->data);
    }


	public function addObservaciones(){
		$this->data['title'][] = 'observaciones';
		$this->data['breadcrumb'][] = array(
			'name' => 'Agregar observaciones',
		);
		$this->data['title'] = 'Observaciones';
		$this->data['subtitle'] = 'Agregar';
			
		$config = array(
			array(
				'field' => 'Observaciones',
				'rules' => "trim|required"
			)
		);
	}

	



}