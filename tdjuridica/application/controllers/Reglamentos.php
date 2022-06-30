<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reglamentos extends MY_Controller {
    
    public function __construct() 
    {
		parent::__construct();
	    // Libraries
	    $this->load->model('Reglamentos_model');
	    $this->load->library('upload');
	    $this->load->library('form_validation');
	    // Helpers
	    $this->load->helper('date');
	    $this->load->helper('array');
	    $this->load->helper('download');
		$this->data['breadcrumb'] = array(
			array(
				'name' => 'Políticas y Reglamentos',
				'link' =>  site_url('Reglamentos/index')
			)
		);
		$this->data['menu_items'] = array(
			'Reglamentos',
		);
		$this->data['errors'] = array();
    }

	public function index(){
		if($this->ion_auth->in_group(1)){
			$this->data['title'] = 'Políticas y Reglamentos';
			$this->data['subtitle'] = 'Agregar/Eliminar';
			$this->view_handler->view('reglamentos', 'admin',$this->data);
		}else{
			$this->data['title'] = 'Políticas y Reglamentos';
			$this->data['subtitle'] = 'Reglamentos de administración central';
			
			$this->data['menu_items'] = array('utilidades','reglamentos');
		
			$this->view_handler->view('reglamentos', 'principal',$this->data);
		}
	}
	
	public function getit(){
		$data = $this->Reglamentos_model->getreglamentos();
        echo json_encode($data);
        return;
	}
	
	public function downloadfile($id){
		$code = $this->Reglamentos_model->getcode($id);
        $filepath = 'https://drive.google.com/a/cmvalparaiso.cl/file/d/'.$code.'/view?usp=sharing';
        redirect($filepath);
	}
	
	public function addnew(){
		$this->data['menu_items'][] = 'políticas y reglamentos';
		$this->data['breadcrumb'][] = array(
			'name' => 'Agregar nuevo archivo',
		);
		$this->data['title'] = 'Políticas y Reglamentos';
		$this->data['subtitle'] = 'Agregar';
			
		$config = array(
			array(
				'field' => 'nombre',
				'label' => '<b>Nombre</b>',
				'rules' => "trim|required"
			),
			array(
				'field' => 'tipo',
				'label' => '<b>Tipo</b>',
				'rules' => "trim|required"
			),
			array(
				'field' => 'descripcion',
				'label' => '<b>Descripci¨®n</b>',
				'rules' => "trim"
			),
			array(
				'field' => 'codigo',
				'label' => '<b>C¨®digo</b>',
				'rules' => "trim|required"
			)
		);
		$this->form_validation->set_rules($config);

		if($this->form_validation->run() === FALSE){
			!empty($this->input->post('nombre')) ? $this->data['nombre'] = $this->input->post('nombre') : $this->data['nombre'] = NULL;
			!empty($this->input->post('tipo')) ? $this->data['tipo'] = $this->input->post('tipo') : $this->data['tipo'] = NULL;
			!empty($this->input->post('codigo')) ? $this->data['codigo'] = $this->input->post('codigo') : $this->data['codigo'] = NULL;
			$this->view_handler->view('reglamentos', 'adminadd', $this->data);
		}else{
		    $text = "\xd3";
			$reglamentos = array(
				'nombre' => $this->input->post('nombre'),
				'tipo' => $this->input->post('tipo'),
				'descripcion' => empty($this->input->post('descripcion')) ? "-SIN DESCRIPCI".utf8_encode($text)."N-" : $this->input->post('descripcion'),
				'codigo' => $this->input->post('codigo'),
			);
			$this->Reglamentos_model->addinstr($reglamentos);
			redirect('reglamentos');
		}
	}
	
	public function deleteold($id){
		if($this->Reglamentos_model->delold($id)){
			$response = $this->message_handler->get("Successful", "Remove", $id);
		}else{
			$response = $this->message_handler->get('Warning', 'DoesNotExist');
		}
		echo json_encode($response);
	return;
	}
}