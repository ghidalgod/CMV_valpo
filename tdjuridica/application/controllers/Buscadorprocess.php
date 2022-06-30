<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buscadorprocess extends My_Controller {

    public function __construct(){
		parent::__construct();
	    
	    $this->load->model('ProcessMaker_model');

	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Buscador Process',
											'link' =>  site_url('Buscadorprocess/index')
										),
									);
    }
    //SEBALINDO
	//pagina de buscador process para educación y escuelas Educación>Personal>Buscador Process
	public function index()	{
		if($this->session->flashdata('preloader') !== TRUE) {$this->preloader("Buscadorprocess"); return;}
	    $group = array('admin','bpeducacion','escuelas');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		$this->data['menu_items'] = array(
										'educacion',
										'personal',
										'buscadorP'
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Educación',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Educación';
		// Llamada a constructor de vista
		$this->data['indicadores'] = $this->ProcessMaker_model->getIndicadoresE();
		$this->view_handler->view('buscadorprocess', 'educacion', $this->data);
	}

	public function saludPersonal(){
		if($this->session->flashdata('preloader') !== TRUE) {$this->preloader("Buscadorprocess/saludPersonal"); return;}
	    $group = array('admin','bpsalud');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		$this->data['indicadores'] = $this->ProcessMaker_model->getIndicadoresS();
		
		$this->data['menu_items'] = array(
										'salud',
										'personal',
										'buscadorP'
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Salud',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'Lista de casos process';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Salud';
		// Llamada a constructor de vista
		
		$this->view_handler->view('buscadorprocess/salud', 'personal', $this->data);
	}
	
	public function saludCompras(){
		if($this->session->flashdata('preloader') !== TRUE) {$this->preloader("Buscadorprocess/saludCompras"); return;}
	    $group = array('bpcsalud');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301); 
		
		$this->data['indicadores'] = $this->ProcessMaker_model->getIndicadoresCS();
		$this->data['menu_items'] = array('salud','adquisiciones', 'buscadorP');
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Compras Salud',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'Lista de casos process';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Compras Salud';
		// Llamada a constructor de vista
		$this->view_handler->view('buscadorprocess/salud', 'compras', $this->data);
	}
	
    public function consultorProcess(){
		$this->data['menu_items'] = array(
										'consultor',
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Consultor',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = '';
		// Llamada a constructor de vista
		$this->view_handler->view('buscadorprocess', 'consultor', $this->data);
    }
    
    public function resumenCaso($caso) {

        $data = $this->ProcessMaker_model->resumenCaso($caso);
		echo json_encode($data);
    }
	
	public function getCasosEducacion($filter = null) {
	    $group = array('admin','bpeducacion','escuelas');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		if($filter == 1) $data = $this->ProcessMaker_model->getAmpliacionesEducacion();
        else $data = $this->ProcessMaker_model->getAllEducacion();
		echo json_encode($data);
		return;
    }
    
    public function getCasosSaludPersonal() {
	    $group = array('admin','bpsalud');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
        $data = $this->ProcessMaker_model->getAllPersonalSalud();
		echo json_encode($data);
		return;
    }
    
    public function getDetalleSaludCompras($caseNumber) {
	    $group = array('bpcsalud');
		if(!$this->ion_auth->in_group($group)) return;
		
        $data = $this->ProcessMaker_model->getDetalleComprasSalud($caseNumber);
		echo json_encode($data);
		return;
    }
    
	// Pedidos Droguería
	// -> Autor: Marcelo Leiton
	public function pedidoDrogueria($filter = null){
		$group = array('admin','bpdrogueria');

		if(!$this->ion_auth->in_group($group)) redirect('/', 'location', 301); 
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Pedidos Droguería',
											'link' =>  ''
										);
		$this->data['mesesUsados'] = json_encode($this->ProcessMaker_model->getMesesUsados()); //Para Grafica de pedidos del año
		
		$this->data['indicadores']= $this->ProcessMaker_model->getIndicadoresP(); //Para Filtros completado / en curso / cancelados

		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'drogueria';
		// Llamada a constructor de vista
		$this->view_handler->view('buscadorprocess/drogueria', 'admin', $this->data);
	}
		
	//Obtener la información para el dataTable y distinción de usuarios	
	public function getDrogueriaTables($filter = null){
		$group = array('admin','bpdrogueria'); //-> bpdrogueria: Perfil para pedidos droguería
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		if($filter == 2) $data = $this->ProcessMaker_model->getPedidosSrogueria();
        else $data = $this->ProcessMaker_model->getPedidosSrogueria();
		echo json_encode($data);
		return;
		
	}
	//Fin Pedidos Droguería
	
	public function volumetria(){
		$this->ProcessMaker_model->volumetria();
	}
	    
}
