<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DiasLibres extends MY_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('Dias_libres_model');
		$this->load->library('form_validation');
		$this->load->library('upload');
		//$this->load->helper('directory');
		
    }
 
	public function index()	{

		redirect('inicio');

	}

	public function resumen(){
		if($this->session->flashdata('preloader') !== TRUE) {$this->preloader("DiasLibres/resumen"); return;}
		$group = array('dlibresView','dlibresAdd');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		$this->data['menu_items'] = array(
										'diaslibres',
				 						'resumen'
									);
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Días Libres: Control y registro',
											'link' =>  site_url('DiasLibres/resumen')
										),
									);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Pagina en blanco';
		// Llamada a constructor de vista
		
		$this->data['datatable'] = 	json_encode($this->Dias_libres_model->getPersonal());
		$this->data['mesesUsados'] = json_encode($this->Dias_libres_model->getMesesUsados());
		$this->view_handler->view('diaslibres', 'resumen', $this->data);
	}
	
	public function admin(){
		if($this->session->flashdata('preloader') !== TRUE) {$this->preloader("DiasLibres/admin"); return;}
		$group = array('admin');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		$this->data['menu_items'] = array(
										'diaslibres'
									);
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Días Libres: Panel admin',
											'link' =>  site_url('DiasLibres/admin')
										),
									);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Pagina en blanco';
		// Llamada a constructor de vista
		
		$this->data['datatable'] = 	json_encode($this->Dias_libres_model->getPersonal());
		//$this->data['mesesUsados'] = json_encode($this->Dias_libres_model->getMesesUsados());
		$this->view_handler->view('diaslibres', 'admin', $this->data);
	}
	
	//Añade a un funcionario a la base de datos una vez que se hayan validado los datos de este
	//En caso de ingresarse un rut que existe en la base de datos la vista arroja un mensaje de warning
	public function addPersonal(){
		$group = array('admin');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		$this->data['message'] = validation_errors() ? validation_errors() : $this->session->flashdata('message');

		
		$this->data['menu_items'] = array(
										'diaslibres'
									);
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Días Libres: Panel admin',
											'link' =>  site_url('DiasLibres/addPersonal')
										),
										array(
											'name' => 'Add Personal',
										),
									);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Pagina en blanco';
		// Llamada a constructor de vista
		$this->data['centros'] = $this->ProcessMaker_model->getEstablecimiento();
		$this->data['cargos'] = $this->ProcessMaker_model->getCargos();
		$this->data['contratos'] = array('REEMPLAZO','INDEFINIDO','PLAZO FIJO');
		$this->data['personal'] = array('rut'        => '',		//se definen las variables que van en el input
										'digito_rut' => '',		
										'nombres'	=> '',
										'apellido_paterno' => '',
										'apellido_materno' => '',
										'correo' => '',
										'reconosimiento'	=> '',
										'calidad'	=>	'',
										'inicio_contrato'     => '',
										'termino_contrato'    => '',
										'cargo'    => '',
										'categoria'    => '',
										'nivel'    => '',
										'centro' =>  '',
										'nombreCentro' =>  '');
		
		
		//Se extrae la informacion que hay en el formulario
		
		$data_Personal = array( 
		'rut'        => $this->input->post('rut'),	
		'digito_rut' => $this->input->post('digito_rut'),	
		'nombres'	=> $this->input->post('nombres'),
		'apellido_paterno' => $this->input->post('apellido_paterno'),
		'apellido_materno' => $this->input->post('apellido_materno'),
		'correo' => $this->input->post('correo'),
		'reconosimiento'	=> $this->input->post('reconosimiento'),
		'calidad' => $this->input->post('contrato'),
		'inicio_contrato'     => $this->input->post('inicio_contrato'),
		'termino_contrato'    => $this->input->post('termino_contrato'),
		'cargo'    => $this->input->post('cargo'),
		'categoria'    => $this->input->post('categoria'),
		'nivel'    => $this->input->post('nivel'),
		'centro' =>  $this->input->post('centro')
		);
		
		//Se comienzan las validaciones de los datos extraidos
		$vacio = FALSE;
		if (isset($_POST) && !empty($_POST)){
			foreach ($data_Personal as $key => $item){
				if(empty($item) && $key != 'correo'){
			    	$vacio = TRUE;
			    }elseif(!empty($item && $key != 'correo')){
			        $this->session->set_flashdata($key, $data_Personal[$key]);		//Se guardan los campos que no estan vacios como flashdata 
			       }
		    }
			if(strtotime($this->input->post('reconosimiento')) > strtotime($this->input->post('inicio_contrato'))){
	    	    $this->session->set_flashdata('message', $this->bootstrap->alert('danger', 'La fecha de reconocimiento es posterior a la de inicio de contrato.'));
				redirect('DiasLibres/addPersonal', 'refresh');
			}/*Esto esta comentado hasta que se tenga claridad sobre los terminos de contrato con la gente que no tiene calidad de 'INDEFINIDO'
			
			
			
			elseif(strtotime($this->input->post('inicio_contrato')) > strtotime($this->input->post('termino_contrato'))){
	    	    $this->session->set_flashdata('message', $this->bootstrap->alert('danger', 'La fecha de termino es anterior a la de inicio.'));
				redirect('DiasLibres/addPersonal', 'refresh');
				
				
				
			}*/
			else{
		        if($vacio == TRUE){
		        	$this->session->set_flashdata('message', $this->bootstrap->alert('danger', 'No pueden existir campos vacios.'));
					redirect('DiasLibres/addPersonal', 'refresh');
			        return;
		        }else{
		        	if($data_Personal['calidad'] == 'INDEFINIDO' || $data_Personal['termino_contrato'] =='1970-01-01'){
						$data_Personal['termino_contrato'] = ('0000-00-00');
					}
		        	if($this->validarRut($data_Personal['rut'].$data_Personal['digito_rut'])){	//Se valida la estructura del rut ingresado
		        		if($this->validarRutDB($data_Personal['rut']) == true){					//Se valida que no este en la base de datos
		        			if($this->Dias_libres_model->addPersonal($data_Personal) == true){		//Se añade a la persona si es que los datos pasan las validaciones 
								$this->session->set_flashdata('message', $this->bootstrap->alert('success', 'Se ha agregado al funcionario.'));
								redirect('DiasLibres/addPersonal', 'refresh');
							}else{																	
								$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'Error al registrar, intente más tarde.'));
								redirect('DiasLibres/addPersonal', 'refresh');
							}
		        		}else{																		//Mensaje de error en caso de que el rut se encuentre duplicado en la base de datos
		        			$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'Advertencia, este rut ya se encuentra en la Base de Datos.'));
							redirect('DiasLibres/addPersonal', 'refresh');
		        		}
		        	}else{
		        		$this->session->set_flashdata('message', $this->bootstrap->alert('danger', 'Error al registrar, rut no valido.'));
		        		redirect('DiasLibres/addPersonal', 'refresh');
		        	}
		        }
			}
		}
		
		//Se vuelve a setear la data para mostrar en la pagina con flashdata para que persista para la siguiente sesion
		
		$this->data['rut'] = array(
			'name'  => 'rut',
			'id'    => 'rut',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('rut', $this->session->flashdata('rut')),
		);
		$this->data['digito_rut'] = array(
			'name'  => 'digito_rut',
			'id'    => 'digito_rut',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('rut',$this->session->flashdata('digito_rut')),
		);
		
		$this->data['nombres'] = array(
			'name'  => 'nombres',
			'id'    => 'nombres',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('nombres', $this->session->flashdata('nombres')),
		);
		
		$this->data['apellido_paterno'] = array(
			'name'  => 'apellido_paterno',
			'id'    => 'apellido_paterno',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('apellido_paterno', $this->session->flashdata('apellido_paterno')),
		);
		
		$this->data['apellido_materno'] = array(
			'name'  => 'apellido_materno',
			'id'    => 'apellido_materno',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('apellido_materno', $this->session->flashdata('apellido_materno')),
		);
		
		$this->data['correo'] = array(
			'name'  => 'correo',
			'id'    => 'correo',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('correo', $this->session->flashdata('correo')),
		);
		
		$this->data['reconosimiento'] = array(
			'name'  => 'reconosimiento',
			'id'    => 'reconosimiento',
			'type'  => 'date',
			'value' => $this->form_validation->set_value('reconosimiento', date('Y-m-d', strtotime($this->session->flashdata('reconosimiento')))),
		);
				
		$this->data['contrato'] = array(
			'name'  => 'contrato',
			'id'    => 'contrato',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('correo', $this->session->flashdata('calidad')),
		);
		
		$this->data['inicio_contrato'] = array(
			'name'  => 'inicio_contrato',
			'id'    => 'inicio_contrato',
			'type'  => 'date',
			'value' => $this->form_validation->set_value('inicio_contrato', date('Y-m-d', strtotime($this->session->flashdata('inicio_contrato')))),
		);
		
		$this->data['termino_contrato'] = array(
			'name'  => 'termino_contrato',
			'id'    => 'termino_contrato',
			'type'  => 'date',
			'value' => $this->form_validation->set_value('termino_contrato', date('Y-m-d', strtotime($this->session->flashdata('termino_contrato')))),
		);
		
		
		$this->data['cargo'] = array(
			'name'  => 'cargo',
			'id'    => 'cargo',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('cargo', $this->session->flashdata('cargo')),
		);
		
		$this->data['categoria'] = array(
			'name'  => 'categoria',
			'id'    => 'categoria',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('categoria', $this->session->flashdata('categoria')),
		);
		
		$this->data['nivel'] = array(
			'name'  => 'nivel',
			'id'    => 'nivel',
			'type'  => 'number',
			'value' => $this->form_validation->set_value('nivel', $this->session->flashdata('nivel')),
		);
		
		$this->data['centro'] = array(
			'name'  => 'centro',
			'id'    => 'centro',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('centro',( $this->Dias_libres_model->getNombreCentro($this->session->flashdata('centro')))),
		);
		
		
		
		$this->view_handler->view('diaslibres', 'admin/addPersonal', $this->data);
		
	}
	
	//La vista permite al usuario la edicion de datos del funcionario seleccionado
	//Validando los datos y mandando un mensaje de error en caso de ser no validos
	
	public function editPersonal($rut_persona){
		$group = array('admin');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		$this->data['message'] = validation_errors() ? validation_errors() : $this->session->flashdata('message');

		
		$this->data['menu_items'] = array(
										'diaslibres'
									);
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Días Libres: Panel admin',
											'link' =>  site_url('DiasLibres/editpersonal')
										),
										array(
											'name' => 'Edit Personal',
										),
									);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Pagina en blanco';
		// Llamada a constructor de vista
		
		$this->data['personal'] = $this->Dias_libres_model->getPersona($rut_persona);	//Se extraen de la base de datos los datos del funcionario
		$this->data['cargos'] = $this->ProcessMaker_model->getCargos();					//Se extraen de la base de datos los cargos existentes 
		$this->data['centros'] = $this->ProcessMaker_model->getEstablecimiento();		//Se extraen de la base de datos los establecimientos
		$this->data['nombreCentro'] = $this->Dias_libres_model->getNombreCentro($this->data['personal']['centro']);		//Con el codigo del centro se recupera el nombre del centro
		$this->data['contratos'] = array('REEMPLAZO','INDEFINIDO','PLAZO FIJO');		//Posibles tipos de contratos

		
		$this->form_validation->set_rules('rut', 'Error en rut', 'trim|required|rut');
		$this->form_validation->set_rules('nombres', 'Los nombres son requeridos', 'trim|required');
		$this->form_validation->set_rules('apellido_paterno', 'Apellido paterno, requerido', 'trim|required');
		$this->form_validation->set_rules('apellido_materno', 'Apellido materno, requerido', 'trim|required');
		$this->form_validation->set_rules('reconocimiento', 'Reconocimiento, requerido', 'trim|required');
		$this->form_validation->set_rules('inicio_contrato', 'Fecha de inicio contrato, requerido', 'trim|required');
		$this->form_validation->set_rules('cargos', 'Cargo, requerido', 'trim|required');
		$this->form_validation->set_rules('centros', 'Centro, requerido', 'trim|required');
		
		//Comienza la validacion de los datos
		if (isset($_POST) && !empty($_POST)){
			if(strtotime($this->input->post('reconocimiento')) > strtotime($this->input->post('inicio_contrato'))){
	    	    $this->session->set_flashdata('message', $this->bootstrap->alert('danger', 'La fecha de reconocimiento es posterior a la de inicio de contrato.'));
				redirect('DiasLibres/editPersonal/'.$rut_persona, 'refresh');
			}/*Esto esta comentado hasta que se tenga claridad sobre los terminos de contrato con la gente que no tiene calidad de 'INDEFINIDO'
			
			elseif((strtotime($this->input->post('inicio_contrato')) > strtotime($this->input->post('termino_contrato')) && $this->input->post('contrato') != 'INDEFINIDO') || TRUE){
	    	    $this->session->set_flashdata('message', $this->bootstrap->alert('danger', 'La fecha de termino es anterior a la de inicio.'));
				redirect('DiasLibres/editPersonal/'.$rut_persona, 'refresh');
				
				
			}*/
			else{	
				//Se extraen los datos del formulario
				//Se toma en cuenta la edicion del rut por algun caso excepciopnal
				$data_Personal = array( 
					'rut_inicial' => $this->data['personal']['rut'],				//rut inicial
					'digito_rut_inicial' => $this->data['personal']['digito_rut'],	//digito rut inicial
					'rut'        => $this->input->post('rut'),						//nuevo rut ingresado
					'digito_rut' => $this->input->post('digito_rut'),				//nuevo digito verificador ingresado
					'nombres'	=> $this->input->post('nombres'),
					'apellido_paterno' => $this->input->post('apellido_paterno'),
					'apellido_materno' => $this->input->post('apellido_materno'),
					'correo' => $this->input->post('correo'),
					'contrato' => $this->input->post('contrato'),
					'reconosimiento'	=> $this->input->post('reconocimiento'),
					'inicio_contrato'     => $this->input->post('inicio_contrato'),
					'termino_contrato'    => $this->input->post('termino_contrato'),
					'cargo'    => $this->input->post('cargo'),
					'categoria'    => $this->input->post('categoria'),
					'nivel'    => $this->input->post('nivel'),
					'centro' =>  $this->Dias_libres_model->getNombreCentro($this->input->post('centro'))
				);
				if($data_Personal['contrato'] == 'INDEFINIDO' || $data_Personal['termino_contrato'] =='1970-01-01'){
					$data_Personal['termino_contrato'] = ('0000-00-00');
				}
				foreach ($data_Personal as $key => $item){	//Se revisa que no hayan campos vacios
			    	if(empty($item) && $key != 'correo'){
						//if($data_Personal['contrato'] != 'INDEFINIDO' && ($key == 'termino_contrato')){ //Se comenta esto debido a la incertidumbre que existe con respecto a los contrato
						$this->session->set_flashdata('message', $this->bootstrap->alert('danger', 'No pueden existir campos vacios. El campo vacio es: '.$key));
						redirect('DiasLibres/editPersonal/'.$rut_persona, 'refresh');
				        	return;
			        	//}
			        }

		        }
		        
		        
		        if($this->validarRut($data_Personal['rut'].$data_Personal['digito_rut'])){	//Se valida el rut
		        	if($this->Dias_libres_model->updatePersonal($data_Personal) == true){	//Se editan los datos del funcionario en la BD una vez que este todo correcto
						$this->session->set_flashdata('message', $this->bootstrap->alert('success', 'Se han editado los datos del funcionario.'));
						if($data_Personal['rut_inicial'] != $data_Personal['rut']){
							redirect('DiasLibres/editPersonal/'.$data_Personal['rut'], 'refresh');
						}else{
							redirect('DiasLibres/editPersonal/'.$rut_persona, 'refresh');
						}
					}elseif($estado == false){
						$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'Error al registrar, intente más tarde.'));
						redirect('DiasLibres/editPersonal/'.$rut_persona, 'refresh');
					}
				
		        }else{
		        	$this->session->set_flashdata('message', $this->bootstrap->alert('danger', 'Error al registrar, rut no valido.'));
		        	redirect('DiasLibres/editPersonal/'.$rut_persona, 'refresh');
		        }
			}
		}
		
		//Se setea la informacion para mostrar en el formulario
		
		$this->data['rut'] = array(
			'name'  => 'rut',
			'id'    => 'rut',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('rut', $this->data['personal']['rut']),
		);
		$this->data['digito_rut'] = array(
			'name'  => 'digito_rut',
			'id'    => 'digito_rut',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('rut',$this->data['personal']['digito_rut']),
		);
		
		$this->data['nombres'] = array(
			'name'  => 'nombres',
			'id'    => 'nombres',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('nombres', $this->data['personal']['nombres']),
		);
		
		$this->data['apellido_paterno'] = array(
			'name'  => 'apellido_paterno',
			'id'    => 'apellido_paterno',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('apellido_paterno', $this->data['personal']['apellido_paterno']),
		);
		
		$this->data['apellido_materno'] = array(
			'name'  => 'apellido_materno',
			'id'    => 'apellido_materno',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('apellido_materno', $this->data['personal']['apellido_materno']),
		);
		
		$this->data['correo'] = array(
			'name'  => 'correo',
			'id'    => 'correo',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('correo', $this->data['personal']['correo']),
		);
		
		$this->data['reconocimiento'] = array(
			'name'  => 'reconocimiento',
			'id'    => 'reconocimiento',
			'type'  => 'date',
			'value' => $this->form_validation->set_value('reconocimiento', date('Y-m-d', strtotime($this->data['personal']['reconosimiento']))),
		);
		
		$this->data['contrato'] = array(
			'name'  => 'contrato',
			'id'    => 'contrato',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('correo', $this->data['personal']['calidad']),
		);
		
		$this->data['inicio_contrato'] = array(
			'name'  => 'inicio_contrato',
			'id'    => 'inicio_contrato',
			'type'  => 'date',
			'value' => $this->form_validation->set_value('inicio_contrato', date('Y-m-d', strtotime($this->data['personal']['inicio_contrato']))),
		);
		$this->data['termino_contrato'] = array(
			'name'  => 'termino_contrato',
			'id'    => 'termino_contrato',
			'type'  => 'date',
			'value' => $this->form_validation->set_value('termino_contrato', date('Y-m-d', strtotime($this->data['personal']['termino_contrato']))),
		);
		
		$this->data['cargo'] = array(
			'name'  => 'cargo',
			'id'    => 'cargo',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('cargo', $this->data['personal']['cargo']),
		);
		
		$this->data['categoria'] = array(
			'name'  => 'categoria',
			'id'    => 'categoria',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('categoria', $this->data['personal']['categoria']),
		);
		
		$this->data['nivel'] = array(
			'name'  => 'nivel',
			'id'    => 'nivel',
			'type'  => 'number',
			'value' => $this->form_validation->set_value('nivel', $this->data['personal']['nivel']),
		);
		$this->data['centro'] = array(
			'name'  => 'centro',
			'id'    => 'centro',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('centro', $this->data['nombreCentro']),
		);
		
		$this->view_handler->view('diaslibres', 'admin/editpersonal', $this->data);
	}
	
	public function addFL($rut = null){
		$group = array('dlibresAdd');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		if(empty($rut)) { echo json_encode(['ERROR_RUN_NULL']); return; }
		
		if(strtotime($this->input->post('inicio')) > strtotime($this->input->post('termino'))){
			$response[] = 'ERROR_MSN_BACK';
	        $response[] = 'La fecha de termino es anterior a la de inicio.';
	        echo json_encode($response);
	        return;
		}
		$feriadoLegal = array(
			'rut' => $rut,
			'inicio' => date('Y-m-d',strtotime($this->input->post('inicio'))),
			'termino' => date('Y-m-d',strtotime($this->input->post('termino'))),
			'created_by' => $this->session->username,
		);
			
		foreach ($feriadoLegal as $item){
            if(empty($item)){
                $response[] = 'ERROR_FORM_VALIDATOR';
                $response[] = json_encode($feriadoLegal);	
                echo json_encode($response);
                return;
        	}
        }
        $feriadoLegal['fin_de_semana'] = $this->input->post('finDeSemana');
		$result = $this->Dias_libres_model->addFL($feriadoLegal);
		
		if( strcmp($result[0],'SUCCESSFUL') == 0 ){
			$feriadoLegal['id'] = $result[1];
			$uploadPath = './files/diasLibres/'.$rut.'/fl/' . $result[1] . '/';
			if (!is_dir($uploadPath)){
				mkdir($uploadPath, 0755, TRUE);
			}
	        $config = array(
				'upload_path' => $uploadPath,
				'allowed_types' => '*',
				'overwrite' => true
			);
			$this->upload->initialize($config);
			
	        if($this->upload->do_upload('documento')){
	        	$feriadoLegal['path'] = $uploadPath;
	        	echo json_encode(['SUCCESSFUL',json_encode($feriadoLegal),$result[2], $result[3]]);
	        	return;
        	}	else{
        			$this->Dias_libres_model->removeFL($result[1]);
        			$feriadoLegal['documento'] = '';
	        		$response[] = 'ERROR_FORM_VALIDATOR';
	                $response[] = json_encode($feriadoLegal);
	                echo json_encode($response);
	                return;
        		}
		}	else{
				if(strcmp($result[0],'NOT_DAYS') == 0) {
					echo json_encode(['NOT_DAYS']);
					return;
				} else {
					echo json_encode(['ERROR_BACK',$result[0]]);
					return;
				}
			}
	}
	
	/*La vista muestra los datos de la persona a quien pertenece el fl y los datos del fl
	en caso de no existir un fl negativo se pueden editar todos los fl existentes, de lo contrario
	se debe esperar a que el año proximo llegue*/
	public function editFL($id){
		$group = array('admin');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		$this->data['message'] = validation_errors() ? validation_errors() : $this->session->flashdata('message');

		
		$this->data['menu_items'] = array(
										'diaslibres'
									);
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Días Libres: Panel admin',
											'link' =>  site_url('DiasLibres/admin')
										),
										array(
											'name' => 'Edit Personal',
										),
									);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Pagina en blanco';
		
		$this->data['feriado'] = $this->Dias_libres_model->getFL($id);
		
		$rut = $this->data['feriado']['rut'];
		#dias disponibles antes de realizar el cambio para la actualización
		$diha = $this->Dias_libres_model->contarDHabiles($this->data['feriado']['inicio'], $this->data['feriado']['termino']);
		#datos para ser mostrados en al editar el feriado legal
		$datos = $this->Dias_libres_model->dataForUpdateFL($rut,$this->data['feriado']['negativo'] );
		$this->data['nombre']         = $datos['nombre'];
		$this->data['rut']            = $datos['rut']; //rut con formato xx.xxx.xxx-d
		$this->data['periodos']       = $datos['periodos'];
		$this->data['disponibles']    = $datos['disponibles']; //en caso de negativos
		$disponibles = $datos['periodos']['disponibles']; //disponibles totales en los periodos
		
		/*con esto se muestra la cantidad de dias disponibles como negativos en caso de ser negativos en la vista
		de admin*/
		if($this->data['feriado']['negativo'] == 1){
			$this->data['no_change'] = ($datos['periodos']['disponibles']+$diha)*-1;
		}else{
			$this->data['no_change'] = ($datos['periodos']['disponibles']+$diha);
		}
		
		/*con esto se verifica si es que existe un feriado negativo para decirle a la persona que no se pueden
		editar los feriados positivos, solo en caso de que exista un feriado negativo esto tendra efecto*/
		if($datos['negativos'] < 0 and $this->data['feriado']['negativo'] != 1){
			$this->data['warn'] = '<div class="alert alert-warning" role="alert">
					Este feriado no se puede editar mientras existan feriados legales negativos, deberá esperar.
				</div>';
		}else{
			$this->data['warn'] = "";
		}
		
		$this->form_validation->set_rules('inicio', 'La fecha de inicio es obligatoria', 'trim|required');
		$this->form_validation->set_rules('termino', 'La fecha de termino es obligatoria', 'trim|required');
		$this->form_validation->set_rules('documento_fl', 'El documento es obligatorio.', 'required');
		
		if (isset($_POST) && !empty($_POST)){
			$dias_habiles = $this->Dias_libres_model->contarDHabiles($this->input->post('inicio'), $this->input->post('termino'));
			if(strtotime($this->input->post('inicio')) > strtotime($this->input->post('termino'))){
	    	    $this->session->set_flashdata('message', $this->bootstrap->alert('danger', 'La fecha de termino es anterior a la de inicio.'));
				redirect('DiasLibres/editfL/'.$id, 'refresh');
			}elseif($disponibles+$diha-$dias_habiles < 0){ //se suman los dias del feriado a editar a los dias disponibles y se restan los nuevos dias habiles
	    	    $this->session->set_flashdata('message', $this->bootstrap->alert('danger', 'Al funcionario no le alcanzan los días.'));
	    	    redirect('DiasLibres/editfL/'.$id, 'refresh');
			}elseif($_FILES['documento_fl']['error'] == 4){
	    	    $this->session->set_flashdata('message', $this->bootstrap->alert('danger', 'Debe ingresar el documento de solicitud.'));
	    		redirect('DiasLibres/editfL/'.$id, 'refresh');
			}elseif($datos['negativos'] < 0 and $this->data['feriado']['negativo'] != 1){
			    $this->session->set_flashdata('message', $this->bootstrap->alert('danger', 'Mientras existan feriados legales negativos solo se pueden editar negativos.'));
				redirect('DiasLibres/editfL/'.$id, 'refresh');
			}else{
				$data_FL = array( 
				'id'         => $id,
				'rut'        => $rut,
				'inicio'     => $this->input->post('inicio'),
				'termino'    => $this->input->post('termino'),
				'diasHabIni' => $diha,
				'negativo_fl'=> $this->data['feriado']['negativo'],
				'dias_negativos' => $datos['negativos']
				);
			
				#codigo de la función persona para agregar el archivo.
				$archive = array();
	
				$uploadPath = './files/diasLibres/'.$rut.'/fl/' . $id . '/';
	    		if (!is_dir($uploadPath)){
    				mkdir($uploadPath, 0755, TRUE);
    			}
    	    
    	    	$archive = array(
    				'upload_path' => $uploadPath,
    				'allowed_types' => '*',
    				'overwrite' => true
    			);
   	       		
    			$this->upload->initialize($archive);
    			if($this->upload->do_upload('documento_fl')){
		    	   	if($this->Dias_libres_model->updateFL($data_FL,$this->data['periodos']['detalle']) == true) {
        		       	$this->session->set_flashdata('message', $this->bootstrap->alert('success', 'Feriado legal registrado'));
		    	   		redirect('DiasLibres/admin/', 'refresh');
		    	   	}else{
		    	   		$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'Error al registrar, intente mas tarde.'));
		    	   	}
		    	}else{
            		$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'Error al registrar, intente mas tarde.'));
            	}
			}
		}
		
		$this->data['inicio'] = array(
			'name'  => 'inicio',
			'id'    => 'inicio',
			'type'  => 'date',
			'class' => 'form-control date-picker',
			'value' => $this->form_validation->set_value('inicio', date('Y-m-d', strtotime($this->data['feriado']['inicio']))),
		);
		$this->data['termino'] = array(
			'name'  => 'termino',
			'id'    => 'termino',
			'type'  => 'date',
			'class' => 'form-control date-picker',
			'value' => $this->form_validation->set_value('termino', date('Y-m-d', strtotime($this->data['feriado']['termino']))),
		);
	
		$this->data['dias_habiles'] = $diha;
		
		$this->view_handler->view('diaslibres', 'admin/editFL', $this->data);
	}
	
	//********************************************************************************************************************
	//Elimina un FL y devuelve los dias que haya usado a su periodo correspondiente
	public function deleteFL($id){
		$arreglito = [];
		$arreglito = $this->data = $this->Dias_libres_model->removeFL($id);
		redirect("DiasLibres/admin"); 
	}
	
	//********************************************************************************************************************
	
	public function addDA($rut = null){
		$group = array('dlibresAdd');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		if(empty($rut)) { echo json_encode(['ERROR_RUN_NULL']); return; }
		
		$diaAdministrativo = array(
			'rut' => $rut,
			'inicio' => $this->input->post('inicio_da'),
			'dias' => $this->input->post('dias'),
			'created_by' => $this->session->username
		);
			
		foreach ($diaAdministrativo as $item){
            if(empty($item)){
                $response[] = 'ERROR_FORM_VALIDATOR';
                $response[] = json_encode($diaAdministrativo);	
                echo json_encode($response);
                return;
        	}
        }
		
		$diaAdministrativo['inicio'] = date('Y-m-d',strtotime($this->input->post('inicio_da')));
		$result = $this->Dias_libres_model->addDA($diaAdministrativo);
		
		if( strcmp($result[0],'SUCCESSFUL') == 0 ){
			
			$diaAdministrativo['id'] = $result[1];
			$uploadPath = './files/diasLibres/'.$rut.'/da/' . $result[1] . '/';
			if (!is_dir($uploadPath)){
				mkdir($uploadPath, 0755, TRUE);
			}
	        $config = array(
				'upload_path' => $uploadPath,
				'allowed_types' => '*',
				'overwrite' => true
			);
			$this->upload->initialize($config);
			
	        if($this->upload->do_upload('documento')){
	        	$diaAdministrativo['path'] = $uploadPath;
	        	echo json_encode(['SUCCESSFUL',json_encode($diaAdministrativo), $result[2]]);
	        	return;
        	}	else{
        			/*
        			$this->Dias_libres_model->removeDA($result[1]);
        			$diaAdministrativo['documento'] = '';
	        		$response[] = 'ERROR_FORM_VALIDATOR';
	                $response[] = json_encode($diaAdministrativo);
	                echo json_encode($response);
	                return;
	                */
	                echo json_encode(['SUCCESSFUL',json_encode($diaAdministrativo), $result[2]]);
	        		return;
        		}
		}	else{
				if( strcmp($result[0],'NOT_DAYS') == 0 ){
					echo json_encode($result);
					return;
				}	else {
						echo json_encode(['ERROR_BACK',$result[0]]);
						return;
					}
			}
	}

	/*Se intenta borrar el día admnistrativo en la bd en caso de no poder se captura el error pero no se muestra nada
	y lo mismo sucede con el archivo se intenta borrar, pero no muestra el error en caso de no poder hacerlo, en caso de que
	se quiera ver el error se debe capturar el error o sacar el removeDA del try catch*/
	public function deleteDA($id){
		$this->load->helper("file");
		
		$datos = $this->Dias_libres_model->getDA($id);
		
		$target = './files/diasLibres/'.$datos['diaADM']['rut'].'/da/' . $id . '/';
		
		try{
			$this->Dias_libres_model->removeDA($id);
			if(delete_files($target, true, false)){
				rmdir($target);
			}
		}catch(Exception $e){
			
		}
		
		redirect("DiasLibres/admin");
	}

	/*con el id se muestra la informacion de la persona a quien pertenece el dia administrativo y
	los datos del dia administrativo, como el documento es opcional solo se verifica si se subio pero no
	se valida*/
	public function editDA($id){
		$group = array('admin');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		$this->data['message'] = validation_errors() ? validation_errors() : $this->session->flashdata('message');
		
		$this->data['menu_items'] = array(
										'diaslibres'
									);
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Días Libres: Panel admin',
											'link' =>  site_url('DiasLibres/admin')
										),
										array(
											'name' => 'Editar Día Administrativo',
										),
									);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Pagina en blanco';
		
		$this->data['data_dadm'] = $this->Dias_libres_model->getDA($id);
		
		$this->data['inicio'] = array(
			'name'  => 'inicio',
			'id'    => 'inicio',
			'type'  => 'date',
			'class' => 'form-control date-picker',
			'value' => $this->form_validation->set_value('inicio', date('Y-m-d', strtotime($this->data['data_dadm']['diaADM']['inicio']))),
		);
		
		$this->data['no_change'] = $this->data['data_dadm']['disponible']+$this->data['data_dadm']['diaADM']['dias'];
		
		$options = array(
        	"0.5"  => '1/2',
        	"1"    => '1',
        );
        
        $this->data['options']  = $options;
        $this->data['extra_sl'] = array(
        		'class' => "col-md-6"
        	);
		
		if($this->data['data_dadm']['diaADM']['dias'] == 1){
			$this->data['seleccion'] = '1';
		}else{
			$this->data['seleccion'] = '1/2';
		}
		
		$this->form_validation->set_rules('inicio', 'de días a solicitar', 'trim|required');
		
		if (isset($_POST) && !empty($_POST)){
			$this->form_validation->run();
			$rules = array();
			/*Código de persona para vclidar que los dias disponibles sean mayores a 0*/
			if($this->data['no_change']-$this->input->post('dias') < 0){
				$rules[]= array(
        				'field' => 'noCupo',
        				'label' => '<b></b>',
        				'rules' => "required",
        				'errors' => array(
                            'required' => 'Al funcionario no le alcanzan los días.',
                                ),
        		);
        	}
			$this->form_validation->set_rules($rules);
        	$validacion = $this->form_validation->run();
		
			if($validacion){
				$ledata = array(
					'inicio' => $this->input->post('inicio'),
					'dias'  => $this->input->post('dias')
				);
			
				$resultado = $this->Dias_libres_model->updateDA($id,$ledata);
				
				if($resultado != "ACTUALIZADO"){
					$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'Error al registrar, intente mas tarde.'.$resultado));
					redirect('DiasLibres/editDA/'.$id, 'refresh'); 
				}else{
					/*como el archivo es opcional solo se debe verificar si se subio y en caso de ser así se guarda*/
					if($_FILES['documento_fl']['error'] == 0){
						$uploadPath = './files/diasLibres/'.$this->data['data_dadm']['diaADM']['rut'].'/da/' . $id . '/';
						if (!is_dir($uploadPath)){
							mkdir($uploadPath, 0755, TRUE);
						}
			        	$config = array(
							'upload_path' => $uploadPath,
							'allowed_types' => '*',
							'overwrite' => true
						);
						$this->upload->initialize($config);
						if($this->upload->do_upload('documento_fl')){
							$this->session->set_flashdata('message', $this->bootstrap->alert('success', 'Día Administrativo actualizado'));
							redirect('DiasLibres/editDA/'.$id, 'refresh');
						}else{
							$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'Error al registrar, intente mas tarde.'));
							redirect('DiasLibres/editDA/'.$id, 'refresh'); 
						}
					}else{
						$this->session->set_flashdata('message', $this->bootstrap->alert('success', 'Día Administrativo actualizado'));
						redirect('DiasLibres/editDA/'.$id, 'refresh');
					}
					
				}
				
			}
		}
		
		$this->view_handler->view('diaslibres', 'admin/editDA', $this->data);
	}

	public function getPermisos($rut = null){
		$group = array('dlibresView','dlibresAdd');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		$data = $this->Dias_libres_model->getPermisos($rut);
		
		echo json_encode($data);
	}
	
	public function persona($rut = null){
		$group = array('dlibresView','dlibresAdd');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		$this->data['errors'] = array();
		$this->data['submit'] = 0;
		$validacion = false;
		$this->data['dias'] = 0;
		$this->data['tipo'] = 0;
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->data['menu_items'] = array(
										'diaslibres',
				 						'resumen'
									);
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Días Libres: Control y registro',
											'link' =>  site_url('DiasLibres/resumen')
										),
										array(
											'name' => 'Funcionario: '. $rut,
										),
									);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Pagina en blanco';
		// Llamada a constructor de vista
		$this->data['rut'] = $rut;
		$this->data['persona'] = $this->Dias_libres_model->getPersona($rut);
		
		$config = array();
		if($this->input->post('submit') == 1){
		    $config = array(
    			array(
    				'field' => 'inicio',
    				'label' => '<b>Fecha inicio FL</b>',
    				'rules' => "trim|required"
    			),
    			array(
    				'field' => 'termino',
    				'label' => '<b>Fecha termino FL</b>',
    				'rules' => "trim|required"
    			),
    		);
    		if(strtotime($this->input->post('inicio')) > strtotime($this->input->post('termino'))){
    		    $config[]= array(
    				'field' => 'menor',
    				'label' => '<b></b>',
    				'rules' => "required",
    				'errors' => array(
                        'required' => 'La fecha de termino es anterior a la de inicio.',
                            ),
    			);
    		}
    		if($_FILES['documento_fl']['error'] ==4){
    		    $config[]= array(
    				'field' => 'document',
    				'label' => '<b></b>',
    				'rules' => "required",
    				'errors' => array(
                        'required' => 'El documento es obligatorio.',
                            ),
    			);
    		}
    		$this->form_validation->set_rules($config);
    		$validacion = $this->form_validation->run();
    		if($validacion){
    		    $disponibles = $this->Dias_libres_model->calcularEspacioFL($rut);
    		    $diasHabiles = $this->Dias_libres_model->contarDHabiles($this->input->post('inicio'), $this->input->post('termino'));
    		    if($disponibles['disponibles'] < $diasHabiles){
    		        $config[]= array(
        				'field' => 'noCupo',
        				'label' => '<b></b>',
        				'rules' => "required",
        				'errors' => array(
                            'required' => 'Al funcionario no le alcanzan los días.',
                                ),
        			);
        			$this->form_validation->set_rules($config);
        			$validacion = $this->form_validation->run();
    		    }
    		}
		}
		
		if($this->input->post('submit') == 0){
		    $config = array(
    			array(
    				'field' => 'dias',
    				'label' => '<b>Días a solicitar</b>',
    				'rules' => "trim|required"
    			),
    			array(
    				'field' => 'inicio_da',
    				'label' => '<b>Fecha inicio DA</b>',
    				'rules' => "trim|required"
    			),
    		);
  
    		$this->form_validation->set_rules($config);
    		$validacion = $this->form_validation->run();
    		if($validacion){
    		    $disponibles = $this->Dias_libres_model->calcularDA($rut);
    		    if($disponibles < (float)$this->input->post('dias')){
    		        $config[]= array(
        				'field' => 'noCupo',
        				'label' => '<b></b>',
        				'rules' => "required",
        				'errors' => array(
                            'required' => 'Al funcionario no le alcanzan los días.',
                                ),
        			);
        			$this->form_validation->set_rules($config);
        			$validacion = $this->form_validation->run();
    		    }
    		}
		}
		
		if($this->input->post('submit') == 2){
		    $config = array(
    			array(
    				'field' => 'tipo',
    				'label' => '<b>Tipo permiso</b>',
    				'rules' => "trim|required"
    			),
    			array(
    				'field' => 'inicio_otros',
    				'label' => '<b>Fecha inicio</b>',
    				'rules' => "trim|required"
    			),
    			array(
    				'field' => 'termino_otros',
    				'label' => '<b>Fecha termino</b>',
    				'rules' => "trim|required"
    			),
    			
    		);
    		if(strtotime($this->input->post('inicio_otros')) > strtotime($this->input->post('termino_otros'))){
    		    $config[]= array(
    				'field' => 'menor',
    				'label' => '<b></b>',
    				'rules' => "required",
    				'errors' => array(
                        'required' => 'La fecha de termino es anterior a la de inicio.',
                            ),
    			);
    		}
    		if($this->input->post('tipo') == 1){
	    		if($_FILES['documento_otros']['error'] == 4){
	    		    $config[]= array(
	    				'field' => 'document',
	    				'label' => '<b></b>',
	    				'rules' => "required",
	    				'errors' => array(
	                        'required' => 'El documento es obligatorio.',
	                            ),
	    			);
	    		}
    		}
    		$this->form_validation->set_rules($config);
    		$validacion = $this->form_validation->run();
    		if($validacion){
    		    $disponibles = $this->Dias_libres_model->calcularPSGS($rut);
    		    if($disponibles < $this->Dias_libres_model->contarDHabiles(date('Y-m-d',strtotime($this->input->post('inicio_otros'))), date('Y-m-d',strtotime($this->input->post('termino_otros'))),false)){
    		        $config[]= array(
        				'field' => 'noCupo',
        				'label' => '<b></b>',
        				'rules' => "required",
        				'errors' => array(
                            'required' => 'Al funcionario no le alcanzan los días.',
                                ),
        			);
        			$this->form_validation->set_rules($config);
        			$validacion = $this->form_validation->run();
    		    }
    		}
		}
		
		if($validacion === FALSE){
			!empty($this->input->post('inicio')) ? $this->data['inicio'] = $this->input->post('inicio') : $this->data['inicio'] = NULL;
			!empty($this->input->post('termino')) ? $this->data['termino'] = $this->input->post('termino') : $this->data['termino'] = NULL;
			!empty($this->input->post('inicio_da')) ? $this->data['inicio_da'] = $this->input->post('inicio_da') : $this->data['inicio_da'] = NULL;
			!empty($this->input->post('inicio')) ? $this->data['inicio_otros'] = $this->input->post('inicio_otros') : $this->data['inicio_otros'] = NULL;
			!empty($this->input->post('termino')) ? $this->data['termino_otros'] = $this->input->post('termino_otros') : $this->data['termino_otros'] = NULL;
			!empty($this->input->post('dias')) ? $this->data['dias'] = $this->input->post('dias') : $this->data['dias'] = 0;
			!empty($this->input->post('submit')) ? $this->data['submit'] = $this->input->post('submit') : $this->data['submit'] = 0;
			!empty($this->input->post('tipo')) ? $this->data['tipo'] = $this->input->post('tipo') : $this->data['tipo'] = 0;
			$this->view_handler->view('diaslibres', 'persona', $this->data);
		}else{
		    if($this->input->post('submit') == 1){
		        
		        $feriadoLegal = array(
        			'rut' => $rut,
        			'inicio' => date('Y-m-d',strtotime($this->input->post('inicio'))),
        			'termino' => date('Y-m-d',strtotime($this->input->post('termino'))),
        			'created_by' => $this->session->username
        		);
        		$result = $this->Dias_libres_model->addFL($feriadoLegal);
        		
        		if( strcmp($result[0],'SUCCESSFUL') == 0 ){
        			$uploadPath = './files/diasLibres/'.$rut.'/fl/' . $result[1] . '/';
        			if (!is_dir($uploadPath)){
        				mkdir($uploadPath, 0755, TRUE);
        			}
        	        $config = array(
        				'upload_path' => $uploadPath,
        				'allowed_types' => '*',
        				'overwrite' => true
        			);
        			$this->upload->initialize($config);
        			
        	        if($this->upload->do_upload('documento_fl')){
        	        	$this->session->set_flashdata('message', $this->bootstrap->alert('success', 'Feriado legal registrado'));
    		        	redirect('DiasLibres/persona/'.$rut, 'refresh');
                	}	else{
                			$this->Dias_libres_model->removeFL($result[1]);
                			$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'Error al registrar, intente mas tarde.'));
                			redirect('DiasLibres/persona/'.$rut, 'refresh');
                		}
        		}	else{
        				if(strcmp($result[0],'NOT_DAYS') == 0) {
        					$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'Persona sin días.'));
                			redirect('DiasLibres/persona/'.$rut, 'refresh');
        				} else {
        					$this->session->set_flashdata('message', $this->bootstrap->alert('warning', 'Error al registrar, intente mas tarde.'));
                		    redirect('DiasLibres/persona/'.$rut, 'refresh');
        				}
        			}
        		
		    } 
		    
		    if($this->input->post('submit') == 0) {
		        $diaAdministrativo = array(
        			'rut' => $rut,
        			'inicio' => date('Y-m-d',strtotime($this->input->post('inicio_da'))),
        			'dias' => $this->input->post('dias'),
        			'created_by' => $this->session->username
        		);
        		$result = $this->Dias_libres_model->addDA($diaAdministrativo);
        		
        		if($_FILES['documento_da']['error'] != 4){
        		    $uploadPath = './files/diasLibres/'.$rut.'/da/' . $result[1] . '/';
        			if (!is_dir($uploadPath)){
        				mkdir($uploadPath, 0755, TRUE);
        			}
        	        $config = array(
        				'upload_path' => $uploadPath,
        				'allowed_types' => '*',
        				'overwrite' => true
        			);
        			$this->upload->initialize($config);
        			$this->upload->do_upload('documento_da');
        		}
        		$this->session->set_flashdata('message', $this->bootstrap->alert('success', 'Día administrativo registrado'));
    		    redirect('DiasLibres/persona/'.$rut, 'refresh');
		    }
		    
		    if($this->input->post('submit') == 2){
		    	$otros_permisos = array(
        			'rut' => $rut,
        			'inicio' => date('Y-m-d',strtotime($this->input->post('inicio_otros'))),
        			'termino' => date('Y-m-d',strtotime($this->input->post('termino_otros'))),
        			'tipo' => $this->input->post('tipo'),
        		);
        		
        		$result = $this->Dias_libres_model->addOtros($otros_permisos);
        		
        		if($_FILES['documento_otros']['error'] != 4 && $result[0] != 'NOT_DAYS'){
        		    $uploadPath = './files/diasLibres/'.$rut.'/otros/' . $result[1] . '/';
        			if (!is_dir($uploadPath)){
        				mkdir($uploadPath, 0755, TRUE);
        			}
        	        $config = array(
        				'upload_path' => $uploadPath,
        				'allowed_types' => '*',
        				'overwrite' => true
        			);
        			$this->upload->initialize($config);
        			$this->upload->do_upload('documento_otros');
        		}
        		$this->session->set_flashdata('message', $this->bootstrap->alert('success', 'Permiso adicional registrado'));
    		    redirect('DiasLibres/persona/'.$rut, 'refresh');
		    }
		}
		
	}
	
	public function deletePersona(){
		echo 'DELETIADO PP';
	}
	
	public function calcularFL($inicio, $termino){
	    
	    echo $this->Dias_libres_model->contarDHabiles($inicio, $termino);
	}
	
	public function getPermisosValidar(){
		$group = array('dlibresValidador');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);

		$data = $this->Dias_libres_model->getPermisosValidar();
		
		echo json_encode($data);
	}
	
	public function rechazarPermiso($id = null){
		if(empty($id)) return 0;
		$group = array('dlibresValidador');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		if($this->Dias_libres_model->rechazarPermiso($id))	echo json_encode($id);
			else echo json_encode('ERROR');
	}
	
	public function aceptarPermiso($id = null){
		if(empty($id)) return 0;
		$group = array('dlibresValidador');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		if($this->Dias_libres_model->aceptarPermiso($id))	echo json_encode($id);
			else echo json_encode('ERROR');
		
	}
	
	//Valida la estructura de un rut, el rut ingresado debe tener el digito verificador
	//Puede arrojar un error en caso de que se ingresen letras en vez de numeros, tener cuidado con eso o controlar el error
	public function validarRut($rut = null){
	    $rut = preg_replace('/[^k0-9]/i', '', $rut);
	    $dv  = substr($rut, -1);
	    $numero = substr($rut, 0, strlen($rut)-1);
	    $i = 2;
	    $suma = 0;
	    foreach(array_reverse(str_split($numero)) as $v){
	        if($i==8)
	            $i = 2;
	        $suma += $v * $i;
	        ++$i;
	    }
	    $dvr = 11 - ($suma % 11);
	    
	    if($dvr == 11)
	        $dvr = 0;
	    if($dvr == 10)
	        $dvr = 'K';
	    if($dvr == strtoupper($dv))
	        return true;
	    else
	        return false;
	}
	
	//Valida que el rut que se le pasa no exista en la base de datos
	//Retorna true si es que no existe, false si es que se encuentra alguna coincidencia
	public function validarRutDB($rut){
		$this->db->where('rut', $rut);
		$query = $this->db->get('personal');
		if($query->num_rows() == 0){
			return true;	
		}else{
			return false;
		}
		
	}
	
	
	/*
	public function updateEXCEL(){
		
		$this->Dias_libres_model->updateFun();
	}
	*/
	
	/*
	public function cargaMasiva(){
		
		$this->Dias_libres_model->cargaMasiva();
	}
	
	*/
	

	/*
	public function aqua(){
		
		
		//$this->Dias_libres_model->actualizarPersonalIgestion();
		
		//$this->Dias_libres_model->ingresarPersonal('161996807');
		
		//$this->Dias_libres_model->primerPeriodo();

	}
	*/

	
	/*Se toman los directorios de files/diaslibres para generar dos arreglos da y fl ambos asociativos
	[RUT=>[id's]] para luego hacer un diff por rut con el arreglo que entrega getIDs*/
	public function listarArchivos(){
		$flBD = $this->Dias_libres_model->getIDs("fl");
		$daBD = $this->Dias_libres_model->getIDs("da");
		
		$daRut = array();
		$flRut = array();
		
		$path = './files/diasLibres/';
		$directorios = scandir($path);
		unset($directorios[0]);
		unset($directorios[1]);
		foreach($directorios as $dir){
			$rutArch = scandir($path.$dir);
			unset($rutArch[0]);
			unset($rutArch[1]);
			foreach($rutArch as $dirR){
				if($dirR == "da") {
					$rutScan = scandir($path.$dir."/".$dirR);
					unset($rutScan[0]);
					unset($rutScan[1]);
					foreach($rutScan as $val) $daRut[$dir][] = $val;
				}else {
					$rutScan = scandir($path.$dir."/".$dirR);
					unset($rutScan[0]);
					unset($rutScan[1]);
					foreach($rutScan as $val) $flRut[$dir][] = $val;
				}
			}
		}
		/*COMPARACIÖN DE LOS ID EXISTENTES EN LA BASE DE DATOS CON LOS IDs QUE SE ENCUENTRAN 
		EN FILES/DIASLIBRES*/
		echo "ARCHIVOS DA NO EXISTENTES EN LA BD<br>";
		foreach($daBD as $rut => $rData){
			if (array_key_exists($rut, $daRut)) {
    			$diffDA = \array_diff($daRut[$rut], $daBD[$rut]);
    			if(!empty($diffDA)){
    				echo "<ul>";
    				foreach($diffDA as $id){
						echo "<li>".$path.$rut."/".$id."</li>";
						//$this->action($path.$rut."/".$id); //LLAMAR A LA FUNCION ACTION
					}
					echo "</ul>";
				}
			}
		}
		echo "<br><hr><br>";
		echo "ARCHIVOS FL NO EXISTENTES EN LA BD<br><br>";
		foreach($flBD as $rut => $rData){
			if (array_key_exists($rut, $flRut)) {
    			$diffFL = \array_diff($flRut[$rut], $flBD[$rut]);
    			if(!empty($diffFL)){
    				echo "<ul>";
    				foreach($diffFL as $id){
						echo "<li>".$path.$rut."/".$id."</li>";
						//$this->action($path.$rut."/".$id); //LLAMAR A LA FUNCION ACTION
					}
					echo "</ul>";
				}
			}
		}
			
	}
	
	private function action($path){
		$this->load->helper("file");
		/*

		if(delete_files($path, true, false)){
			rmdir($path);
			echo "ARCHIVO BORRADO";
		}else echo "no se pudo borrar";
	
		*/
	}
	
}
