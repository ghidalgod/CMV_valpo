<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DbManager extends MY_Controller {

    public function __construct(){
		parent::__construct();
	    $this->ion_auth->redirectLoginIn();
	    if (!$this->ion_auth->is_admin()){
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
	    //$this->load->model('ProcessMaker_model');
	    $this->load->model('Db_manager_model');
	    $this->load->library(array('upload','form_validation','excel'));
	    //$this->load->helper('form');
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Inicio',
											'link' =>  site_url('inicio/index')
										),
									);
    }

	public function index()	{
		$this->data['menu_items'] = array(
										'auth',
										'dbmanager',
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Carga de datos',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'Herramientas de carga';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Por excel';
		
		$tablasDB = $this->Db_manager_model->getTables();											//Rescata nombre tablas DB
		
		$this->form_validation->set_rules('table_name', 'de la tabla DB', 'required');				//Validacion de input form
		if (empty($_FILES['data_excel']['name'])){
		    $this->form_validation->set_rules('data_excel', ' del archivo a subir', 'required');
		}
		
		
		if ($this->form_validation->run() === TRUE){												//Ejecuta validacion de form 
			$this->data['table_name'] = array(
						'name' => 'table_name',
						'id' => 'table_name',
						'options' => $tablasDB,
						"class"=> "chosen-select col-xs-8",
						'selected' => $this->form_validation->set_value('table_name'),
					);
			$this->data['data_excel'] = array(
						'name' => 'data_excel',
						'id' => 'data_excel',
						'accept' => '.xlsx',
						'value' => $this->form_validation->set_value('data_excel'),
					);
			$config = array(
						'upload_path' => './files/upload-db',
						'allowed_types' => 'xlsx',
						'overwrite' => true
					);
		
			$this->upload->initialize($config);														//Set cfg para guardar archivo de input form
			
			if($uploaded = $this->upload->do_upload('data_excel')) {								//SI se guardo archivo 
				$data_file = $this->upload->data();														//Refercia a los datos del excel subido
				
				$tableName = $this->input->post('table_name');											//Rescata nombre de columns DB
				$columnDB = $this->Db_manager_model->getColumn($tableName);
				
				$header = $columnDB;																	//Se guarda el nombre de column para comparar con las del excel
																										//para asegurar que todas las column de la DB tengan una en el excel
				$xlsx = $this->excel->readXLSX($data_file['full_path']);								//Se lee el excel
				if(empty($xlsx[2])) {																	//Si viene vacio el excel recarga la pog y muestra menssage de error
					$this->data['message'] = $this->bootstrap->alert('warning', "El excel no tiene datos.");
					$this->view_handler->view('dbmanager', 'excel', $this->data);
				}	else{
						
						if($this->Db_manager_model->saveExcelData($xlsx,$tableName)){
							$this->data['message'] = $this->bootstrap->alert('success', "Se cargó exitosament el Excel.");
							$this->view_handler->view('dbmanager', 'excel', $this->data);
						} else {
							$this->data['message'] = $this->bootstrap->alert('error', "El excel no se a cargado.");
							$this->view_handler->view('dbmanager', 'excel', $this->data);
						}

				}
			}
			
		}	else{
				$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message') );

				$this->data['table_name'] = array(
					'name' => 'table_name',
					'id' => 'table_name',
					'options' => $tablasDB,
					"class"=> "chosen-select col-xs-8",
					'selected' => $this->form_validation->set_value('table_name'),
				);
				$this->data['data_excel'] = array(
					'name' => 'data_excel',
					'id' => 'data_excel',
					'accept' => '.xlsx',
					'value' => $this->form_validation->set_value('data_excel'),
				);
				$this->view_handler->view('dbmanager', 'excel', $this->data);
			}
		
	}

}
