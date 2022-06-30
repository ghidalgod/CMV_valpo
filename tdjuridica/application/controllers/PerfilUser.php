<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerfilUser extends My_Controller {

    public function __construct(){
		parent::__construct();
	    // Config

	    // Models

	    //Crear el archivos en carpeta model con nombre reemplazante_model
	    // Libraries
	    $this->load->library('upload');
	    $this->load->library('form_validation');
	    // Helpers
	    $this->load->helper('date');
	    $this->load->helper('directory');
	    $this->load->helper('file');
	    $this->load->helper('array');
    	// View data
		$this->data['breadcrumb'] = array(
			array(
				'name' => 'Cuenta de usuario',
				'link' =>  site_url('PerfilUser/index')
			)
		);
		$this->data['message'] = null;

    }

	public function index() {
		$this->data['title'] = 'Administración de cuenta';
		$this->data['subtitle'] = 'Información personal';
		
		$this->data['breadcrumb'][] = array(
			'name' => 'Información de cuenta',
		);
		
		//$this->data['menu_items'][] = 'list';
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['username'] = $this->session->userdata('identity');
		$this->data['nombres'] = $this->session->userdata('first_name');
		$this->data['apellidos'] = $this->session->userdata('last_name');
		$this->data['email'] = $this->session->userdata('email');
		$this->data['phone'] = $this->session->userdata('phone');

		$this->view_handler->view('perfilUser', 'perfil', $this->data);
	}

	public function ajustes(){
		$this->data['title'] = 'Administración de cuenta';
		$this->data['subtitle'] = 'Ajustes de cuenta';
		
		$this->data['breadcrumb'][] = array(
			'name' => 'Ajustes de cuenta'
		);
		
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['nombres'] = $this->session->userdata('first_name');
		$this->data['apellidos'] = $this->session->userdata('last_name');
		$this->data['email'] = $this->session->userdata('email');
		$this->data['phone'] = $this->session->userdata('phone');
		$user = $this->session->userdata('user_id');
		$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');

		if($this->input->post('finalizar') == 1){

			$config = array(
				array(
					'field' => 'nombres',
					'label' => '<b>Nombres</b>',
					'rules' => "trim"
				),
				array(
					'field' => 'apellidos',
					'label' => '<b>Apellidos</b>',
					'rules' => "trim"
				),
				array(
					'field' => 'email',
					'label' => '<b>Email</b>',
					'rules' => "trim"
				),
				array(
					'field' => 'phone',
					'label' => '<b>Telefono</b>',
					'rules' => "trim"
				),
			);

			$this->form_validation->set_rules($config);
			if($this->form_validation->run()){

				$data = array(
					'first_name' => $this->input->post('nombres'),
					'last_name' => $this->input->post('apellidos'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
				);

				if(!empty($_FILES['userFileD']['name'])){
					if($this->ion_auth->in_group(array(9))){
						$idEstudiante = $this->Estudiantes_model->get('*', array('rut' => $this->session->userdata('rut')))[0]->id;
						$uploadPath = './files/atavar/estudiantes/' .$idEstudiante. '/';
						if (!is_dir($uploadPath)) {
					        mkdir($uploadPath, 0755, TRUE);
					    }
					    $config = array(
							'upload_path' => $uploadPath,
							'allowed_types' => '*',
							'overwrite' => true
						);
						$map = directory_map($uploadPath,1);
						foreach ($map as $posicionArray => $nombreArchivo) {
							@unlink($uploadPath . $nombreArchivo);
			        	}
						$this->upload->initialize($config);
						if(!$this->upload->do_upload('userFileD')){
				            $data['uploadError'] = $this->upload->display_errors();
				            $this->session->set_flashdata('message', $this->upload->display_errors());
				        }	
					}	else{
							$idCuenta = $this->session->userdata('user_id');
							$uploadPath = './files/atavar/cuentas/' .$idCuenta. '/';
							if (!is_dir($uploadPath)) {
						        mkdir($uploadPath, 0755, TRUE);
						    }
						    $config = array(
								'upload_path' => $uploadPath,
								'allowed_types' => '*',
								'file_name' => 'avatar',
								'overwrite' => true
							);
							$map = directory_map($uploadPath,1);
							foreach ($map as $posicionArray => $nombreArchivo) {
								@unlink($uploadPath . $nombreArchivo);
				        	}
							$this->upload->initialize($config);
							if(!$this->upload->do_upload('userFileD')){
					            $data['uploadError'] = $this->upload->display_errors();
					            $this->session->set_flashdata('message', $this->upload->display_errors());
					        }	
						}
				}

				if ($this->ion_auth->update($user, $data))
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					$newData = $this->ion_auth->user($user)->row();
					$this->ion_auth->set_session($newData);
					redirect('perfilUser', 'refresh');

				}
				else
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('perfilUser', 'refresh');

				}
			}

		}

		if($this->input->post('finalizar') == 2){

			
		}

		if($this->input->post('finalizar') == 3){

			$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
			$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');
			$user = $this->ion_auth->user()->row();

			if ($this->form_validation->run() === FALSE){
				// display the form
				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				// render
				//$this->view_handler->view('perfilUser', 'ajustes', $this->data);
			}
			else
			{
				$identity = $this->session->userdata('identity');

				$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

				if ($change)
				{
					//if the password was successfully changed
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('perfilUser', 'refresh');
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('perfilUser', 'refresh');
				}
			}
			
		}
		$this->view_handler->view('perfilUser', 'ajustes', $this->data);
	}
}
