<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejemplo extends MY_Controller {

    public function __construct(){
		parent::__construct();
	    //$this->ion_auth->redirectLoginIn();
	    // $this->load->model('Funcionarios_model');

	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Inicio',
											'link' =>  site_url('inicio/index')
										),
									);

    }

	public function index()	{

		
		$this->data['menu_items'] = array(
										'ejemplo',
										'paginaBlanco'
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Ejemplo: Pagina en blanco',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'Inicio';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Pagina en blanco';
		// Llamada a constructor de vista
		
		$this->view_handler->view('ejemplo', 'paginaBlanco', $this->data);

	}
	
	// public function prueba() {
	// 	$fechas = $this->Funcionarios_model->getFechasVidaFuncionaria('189034377');
	// 	$fechaContrato = $fechas[0]->FechaInicio;
		
	// 	for ($i = 0; $i < count($fechas); $i++) {
		    
	// 	    if ($i === count($fechas) - 1) {
	// 	    	break;
	// 	    }
		    
	// 	    $fechaTermino = date("d-m-Y", strtotime($fechas[$i]->FechaTermino."+ 1 days"));
	// 	    $fechaInicio = date("d-m-Y", strtotime($fechas[$i+1]->FechaInicio));
		    
	// 	    if ($fechaTermino !== $fechaInicio) {
	// 	    	$fechaContrato = $fechas[$i+1]->FechaInicio;
	// 	    }
		    
		    
	// 	}
		
	// 	return date("d/m/Y", strtotime($fechaContrato));

	// }

}

