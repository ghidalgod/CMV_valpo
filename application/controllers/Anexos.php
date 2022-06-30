<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anexos extends MY_Controller {
    
    public function __construct() 
    {
		parent::__construct();
		$this->load->model('Anexos_model');
		// Libraries
	    $this->load->library('upload');
	    $this->load->library('form_validation');
	    // Helpers
	    $this->load->helper('date');
	    $this->load->helper('array');
		$this->data['breadcrumb'] = array(
			array(
				'name' => 'Anexos',
				'link' =>  site_url('Anexos/index')
			)
		);
		$this->data['errors'] = array();
    }

	public function index(){
		if($this->ion_auth->in_group(1)){
			$this->data['title'] = 'Anexos';
			$this->data['subtitle'] = 'Editor';
			$this->view_handler->view('anexos', 'admin',$this->data);
		}else{
			$this->data['title'] = 'Anexos';
			$this->data['subtitle'] = 'Anexos de administración central';
			
			$this->data['menu_items'] = array('utilidades','anexos');
		
			$this->view_handler->view('anexos', 'principal',$this->data);
		}
	}

	public function getit(){
		$data = $this->Anexos_model->getanexos();
        echo json_encode($data);
        return;
	}
	
	public function addnew(){
		$this->data['menu_items'][] = 'anexo';
		$this->data['breadcrumb'][] = array(
			'name' => 'Agregar nuevo anexo',
		);
		$this->data['title'] = 'Anexos';
		$this->data['subtitle'] = 'Agregar';
			
		$config = array(
			array(
				'field' => 'anexo',
				'label' => '<b>Anexo</b>',
				'rules' => "trim|required"
			),
			array(
				'field' => 'nombre',
				'label' => '<b>Nombre</b>',
				'rules' => "trim|required"
			),
			array(
				'field' => 'departamento',
				'label' => '<b>Departamento o dirección</b>',
				'rules' => "trim|required"
			)
		);
		$this->form_validation->set_rules($config);

		if($this->form_validation->run() === FALSE){
			!empty($this->input->post('anexo')) ? $this->data['anexo'] = $this->input->post('anexo') : $this->data['anexo'] = NULL;
			!empty($this->input->post('nombre')) ? $this->data['nombre'] = $this->input->post('nombre') : $this->data['nombre'] = NULL;
			!empty($this->input->post('cargo')) ? $this->data['cargo'] = $this->input->post('cargo') : $this->data['cargo'] = NULL;
			!empty($this->input->post('departamento')) ? $this->data['departamento'] = $this->input->post('departamento') : $this->data['departamento'] = NULL;
			!empty($this->input->post('email')) ? $this->data['email'] = $this->input->post('email') : $this->data['email'] = NULL;
			$this->view_handler->view('anexos', 'adminadd', $this->data);
		}else{
			$anexos = array(
				'anexo' => $this->input->post('anexo'),
				'nombre' => $this->input->post('nombre'),
				'cargo' => empty($this->input->post('cargo')) ?  NULL : $this->input->post('cargo'),
				'departamento' => $this->input->post('departamento'),
				'email' => empty($this->input->post('email')) ?  NULL : strtolower($this->input->post('email'))
			);
			$this->Anexos_model->addnexo($anexos);
			redirect('anexos');
		}
	}
	
	public function deleteold($id){
		if($this->Anexos_model->delold($id)){
			$response = $this->message_handler->get("Successful", "Remove", $id);
		}else{
			$response = $this->message_handler->get('Warning', 'DoesNotExist');
		}
		echo json_encode($response);
		return;
	}
	
	public function editold($id){
	   	$anexo = $this->Anexos_model->get('*', array('id' => $id));
    	if(empty($anexo)) {
    		$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'No existe el anexo.'));
    		redirect('anexos', 'admin', 301);
    	}
    	
		$this->data['title'] = 'Anexo';
		$this->data['subtitle'] = 'Editor';
		$this->data['breadcrumb'][] = array(
			'name' => 'Editar'
		);
		
		$config = array(
			array(
				'field' => 'anexo',
				'label' => '<b>Anexo</b>',
				'rules' => "trim|required"
			),
			array(
				'field' => 'nombre',
				'label' => '<b>Nombre</b>',
				'rules' => "trim|required"
			),
			array(
				'field' => 'departamento',
				'label' => '<b>Departamento o dirección</b>',
				'rules' => "trim|required"
			)
		);
		$this->form_validation->set_rules($config);

		if($this->form_validation->run() === FALSE){
			!empty($this->input->post('anexo')) ? $this->data['anexo'] = $this->input->post('anexo') : $this->data['anexo'] = $anexo[0]->anexo;
			!empty($this->input->post('nombre')) ? $this->data['nombre'] = $this->input->post('nombre') : $this->data['nombre'] = $anexo[0]->nombre;
			!empty($this->input->post('cargo')) ? $this->data['cargo'] = $this->input->post('cargo') : $this->data['cargo'] = $anexo[0]->cargo;
			!empty($this->input->post('departamento')) ? $this->data['departamento'] = $this->input->post('departamento') : $this->data['departamento'] = $anexo[0]->departamento;
			!empty($this->input->post('email')) ? $this->data['email'] = $this->input->post('email') : $this->data['email'] = $anexo[0]->email;
			$this->view_handler->view('anexos', 'adminedit', $this->data);
		}else{
			$anexos = array(
				'anexo' => $this->input->post('anexo'),
				'nombre' => $this->input->post('nombre'),
				'cargo' => empty($this->input->post('cargo')) ?  NULL : $this->input->post('cargo'),
				'departamento' => $this->input->post('departamento'),
				'email' => empty($this->input->post('email')) ?  NULL : strtolower($this->input->post('email'))
			);
			
			$this->Anexos_model->edi_tor($id, $anexos);
			redirect('anexos');
		}
	}
}