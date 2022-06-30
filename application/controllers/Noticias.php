<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Noticias extends MY_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('Noticias_model');
		$this->load->library('form_validation');
		$this->load->library('upload');
	    $this->ion_auth->redirectLoginIn();

	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Noticias',
											'link' =>  site_url('Noticias/index')
										),
									);
    }

	public function index()	{
		//print_r($this->session->userdata());
		//print_r($this->Noticias_model->getAllNews());
		$this->data['menu_items'] = array(
										'noticias',
										'noticias'
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Noticias',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'Noticias';
		//datatable
		$this->data['dataTable'] = json_encode($this->Noticias_model->getAllNews());
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Comunicados y avisos internos CMV';
		$this->data['message'] = validation_errors() ? validation_errors() : $this->session->flashdata('message');

		
		//VALIDACIONES PARA AGREGAR UNA NOTICIA
		//COMO MENCIONO EN editarNoticia QUIZAS CUERPO NO SEA NECESARIO
		$this->form_validation->set_rules('titulo', 'de Título', 'required');
		$this->form_validation->set_rules('cuerpo', 'de cuerpo', 'required');
		$this->form_validation->set_rules('tipo', 'de tipo', 'required');
		
		if($this->form_validation->run()){
			$datos = array(
				'titulo'     => $this->input->post('titulo'),
				'cuerpo'     => $this->dataReady($this->input->post('cuerpo')),
				'fecha'      => date("Y-m-d"),
				'tipo'       => $this->input->post('tipo'),
				'created_by' => $this->session->userdata('username')
				);
			if($this->Noticias_model->agregarNoticia($datos) != "AGREGADA"){
				$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'Error al registrar, intente mas tarde.'.$resultado));
				redirect('Noticias', 'refresh'); 
			}else{
				$this->session->set_flashdata('message', $this->bootstrap->alert('success', 'Noticia agregada.'));
				redirect('Noticias', 'refresh'); 
			}
		}
		// Llamada a constructor de vista
		$this->view_handler->view('noticias','', $this->data);
	}
	
	//funcion para tomar lo que se escribe en ckeditor y pasarlo a hmtl para almacenarlo en la BD
	private function dataReady($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	public function borrarNoticia($id){
		try{
			$this->Noticias_model->removeNoticia($id);
		}catch(Exception $e){
			echo $e;
		}
		redirect("Noticias","refresh");
	}
	
	public function editarNoticia($id){
	//	print_r($this->Noticias_model->getNoticia($id));
		$this->data['menu_items'] = array(
										'noticias',
										'noticias'
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Noticias',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		$this->data['message'] = validation_errors() ? validation_errors() : $this->session->flashdata('message');

		$noticia = $this->Noticias_model->getNoticia($id);
		
		$this->form_validation->set_rules('titulo', 'de Título', 'required');
		$this->form_validation->set_rules('cuerpo', 'de cuerpo', 'required');
		//ESTA VALIDACION "cuerpo" QUIZAS NO SE MUY NECESARIA YA QUE PODRIA EXISTIR LA POSIBILIDAD
		//DE QUE SOLO SE QUIERA PONER UN TITULO QUE EXPLIQUE ALGO Y NADA MÁS
		$this->form_validation->set_rules('tipo', 'de tipo', 'required');

		if($this->form_validation->run()){
			$datos = array(
				'titulo'    => $this->input->post('titulo'),
				'cuerpo'    => $this->dataReady($this->input->post('cuerpo')),
				'fecha'     => date("Y-m-d"),
				'tipo'      => $this->input->post('tipo'),
				'edited_by' => $this->session->userdata('username')
				);

			if($this->Noticias_model->updateNoticia($id,$datos) != "ACTUALIZADO"){
				$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'Error al registrar, intente mas tarde.'.$resultado));
				redirect('Noticias/editarNoticia/'.$id, 'refresh'); 
			}else{
				$this->session->set_flashdata('message', $this->bootstrap->alert('success', 'Noticia editada correctamente.'));
				redirect('Noticias/editarNoticia/'.$id, 'refresh'); 
			}
		}

		$this->data['titulo'] = array(
			'name'  => 'titulo',
			'id'    => 'titulo',
			'type'  => 'text',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('titulo',$noticia['titulo']),
		);
		$text = html_entity_decode($noticia['cuerpo']);
		$this->data['editor'] = array(
			'name'  => 'cuerpo',
			'id'    => 'editor',
			'value' => $this->form_validation->set_value('cuerpo',$text),
			'rows'  => '8',
    		'cols'  => '45',
    		'style' => "display:none;"
		);
		
		//tipos de noticia
		$this->data['social'] = array(
			'name'   => 'tipo',
			'id'     => 'tipo',
			'value'  => "Social",
			'checked'=> 0
		);
		$this->data['general'] = array(
			'name'   => 'tipo',
			'id'     => 'tipo',
			'value'  => "General",
			'checked'=> 0
		);
		$this->data['administrativo'] = array(
			'name'   => 'tipo',
			'id'     => 'tipo',
			'value'  => "Administrativo",
			'checked'=> 0
		
		);
		//Para poner el tipo de noticia como checked en la vista de editar
		switch($noticia['tipo']){
			case "Administrativo":
				$this->data['administrativo']['checked'] = 1;
				break;
			case "General":
				$this->data['general']['checked'] = 1;
				break;
			case "Social":
				$this->data['social']['checked'] = 1;
				break;
		}
		// Llamada a constructor de vista
		$this->view_handler->view('noticias','editarNoticia', $this->data);
	}
}
