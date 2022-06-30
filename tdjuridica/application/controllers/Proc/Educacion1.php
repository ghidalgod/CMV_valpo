<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Educacion1 extends CI_Controller {
    private $data = array();
	private $filebase;

    public function __construct(){
		parent::__construct();
		// Session
	    $this->ion_auth->redirectLoginIn();
	    // Config
	    // Models
	    $this->load->model('Casos_model');
	    $this->load->model('Procedimientos_model');
	    $this->load->model('Users_model');//NUEVO
  	    $this->load->model('Actividad1d_model');  

	    // Libraries
	    $this->load->library('upload');
	    
	    // Helpers
	    $this->load->helper(array('date','download', 'file', 'html'));
    	// View data
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
		
		// Errors
		$this->data['errors'] = array();
   }

public function index(){
	$this->data['usuarios'] = $this->Casos_model->getCaso();
	//var_dump($this->$data['usuarios']);
   	$this->view_handler->view('juridica/Flujosprocedimientos/Educacion1', 'Ingresar', $this->data);
   
   
}

public function IngresarProc1(){
	if(!$this->ion_auth->in_group(22)){
		redirect(site_url('Inicio'),'location');
	}

    $components = new stdClass();
    $this->data['breadcrumb'][] = array(
        'name' => 'Primer Paso: Ingreso de información de la denuncia'
    );


	//$this->data['usuarios'] = $this->Casos_model->getCaso();

		
		$this->form_validation->set_rules('titulo','<b>Titulo</b>','trim|required');
		$this->form_validation->set_rules('denunciante','<b>Denunciante</b>','trim|required');
		$this->form_validation->set_rules('RUC','<b>RUC</b>','trim|required');
		$this->form_validation->set_rules('asignado','<b>Asignado</b>','trim|required');
		$this->form_validation->set_rules('denuncia','<b>Denuncia</b>','trim|required');
		$this->form_validation->set_rules('tipo','<b>Tipo</b>','trim|required');


		if($this->form_validation->run() == FALSE){
        	!empty($this->input->post('titulo')) ? $this->data['titulo'] = $this->input->post('titulo') : $this->data['titulo'] = $datosCaso->titulo;        	
        	!empty($this->input->post('denunciante')) ? $this->data['denunciante'] = $this->input->post('denunciante') : $this->data['denunciante'] = $datosCaso->denunciante;        	
			!empty($this->input->post('RUC')) ? $this->data['RUC'] = $this->input->post('RUC') : $this->data['RUC'] = $datosCaso->RUC;
			!empty($this->input->post('asignado')) ? $this->data['asignado'] = $this->input->post('asignado') : $this->data['asignado'] = $datosCaso->asignado;
        	!empty($this->input->post('denuncia')) ? $this->data['denuncia'] = $this->input->post('denuncia') : $this->data['denuncia'] = $datosCaso->denuncia;
        	!empty($this->input->post('tipo')) ? $this->data['tipo'] = $this->input->post('tipo') : $this->data['tipo'] = $datosCaso->tipo;
        	
      
        	//MENU SELECCION DE ACTIVIDAD 
			$this->data['menu_procesos'] = array(2,3,3,3,3);
			$components->menu = $this->load->view('components/juridica/procedimientos/menuProc', $this->data, true);	
        	$this->view_handler->view('juridica/procedimientos/Educacion1', 'Ingresar', $this->data);
      	}else{
	      	$caso1next = array(
				'titulo' => $this->input->post('titulo'),
				'denunciante' => $this->input->post('denunciante'),
				'RUC' => $this->input->post('RUC'),
				'asignado' => $this->input->post('asignado'),
				'denuncia' => $this->input->post('denuncia'),
				'nombre' => $this->session->userdata('first_name'),
				'tipo' => $this->input->post('tipo')
	      	); 

	      	$caso = array(
				'id_user' => $this->session->userdata('user_id'),
	        	'etapa' => 2,
	       		'estado' => "ACTIVO",
	       		'fecha' => date('Y-m-d'),
	        ); 

			$id_asignado = $this->Casos_model->getidbyname($caso1next['asignado']);
	      	$id_procedimientos = $this->Procedimientos_model->add_id($caso);
			$this->Actividad1d_model->add($caso1next);
	      	$this->Casos_model->update($casos, array('id' => $id_user));
	      	$this->data['menu_procesos'] = array(1,2,3,3,3);
		   	$this->data['id_proc'] = $id_procedimientos;
		   	/*
			//CREAR DOCUMENTOS PDF
		    $this->createpdf($casos, $id_procedimientos, $actividad1d, $listanueva, $listanueva_2, $listanueva_3, $id_caso); 
		    //FIN CREAR DOCUMENTOS PDF*/
		    //variables para notificar
			$nombre = $caso1next['asignado'];
			$numero = $id_caracterizacion;
			$RUC = $caso1next['RUC'];
			$this->enviar($email, $nombre, $numero, $RUC);
		    
		    //FIN variables para notificar
			$components->menu = $this->load->view('components/juridica/procedimientos/menuProc', $this->data, true);
			$this->data['components'] = $components;
			$this->view_handler->view('components/juridica/procedimientos/Educacion1', 'Ingresar', $this->data);
		}
        
    }

        public function getcasos() {
		$columns = array(
			array( 'db' => 'id', 'dt' => 'id' ),
			array( 'db' => 'rut', 'dt' => 'rut' ),
			array( 'db' => 'nombres', 'dt' => 'nombres' ),
			array( 'db' => 'apellido_p', 'dt' => 'apellido_p' ),
			array( 'db' => 'apellido_m', 'dt' => 'apellido_m' ),
			array( 'db' => 'nacimiento', 'dt' => 'nacimiento' )
		);

		$data = $this->casos_model->simple_data_table($columns);
		echo json_encode($data);
   	    }

    	public function mostrar($id_caso = null){
    	$this->data['caso'] = $this->Casos_model->get('*', array('id' => $id_caso));

		$this->data['breadcrumb'][] = array(
			'name' => 'Información Denuncia'
		);
		$this->data['menu_procesos'] = array(1,3,3,3,3);
		$this->data['usuarios'] = $this->Casos_model->getCaso();

		if($procedimientos[0]->etapa == 2) $this->data['menu_procesos'] = array(1,2,3,3,3);
		if($procedimientos[0]->etapa == 3) $this->data['menu_procesos'] = array(1,1,2,3,3);
		if($procedimientos[0]->etapa == 4) $this->data['menu_procesos'] = array(1,1,1,2,3);
		if($procedimientos[0]->etapa == 5) $this->data['menu_procesos'] = array(1,1,1,1,2);
		if($procedimientos[0]->etapa == 6) $this->data['menu_procesos'] = array(1,1,1,1,1);
		
		$this->data['actividad1d'] = $this->Actividad1d_model->get('*', array('id' => $id_caso));
		
		$components = new stdClass();
		$components->infoBasica = $this->load->view('infoBasica', $this->data, true);
		$components->menu = $this->load->view('components/juridica/procedimientos/menuProc', $this->data, true);
		$this->data['components'] = $components;
		$this->view_handler->view('components/juridica/procedimientos/Educacion1', 'Ingresar', $this->data);
    }

    public function enviar($email, $nombre, $caso, $RUC){
    	$this->load->library('PHPMailer_Lib');													//CARGA LIBRERÍA DE PHPMAILER
      	$mail = $this->phpmailer_lib->load();		       
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPOptions = array(
            'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
            )
        );
		$mail->SMTPAuth = true;
		$mail->Username = "phpmailer.test.of.code@gmail.com";											//CORREO DE NOTIFICACIONES
		$mail->Password = "1q2w3ecmv";															//CONTRASEÑA DE DICHO CORREO
		$mail->setFrom('phpmailer.test.of.code@gmail.com', 'Notificación');					//NOMBRE Y CORREO DE ENVÍO
		$mail->addAddress($email, $nombre);												//AGREGA DIRECCIONES PRINCIPALES
		$mail->Subject = 'Inicio de Procedimiento N°'.$caso;								//ASUNTO
		$mail->MsgHTML('Se ha ingresado una Denuncia RUC:'.$RUC.', ingrese al sistema para revisarla');//MENSAJE, PUEDE USAR html
		$mail->CharSet = 'UTF-8';
		$mail->send();
	}



}