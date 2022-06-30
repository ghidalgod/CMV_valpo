<?php defined ('BASEPATH') OR exit ('No direct script access allowed');

class SumarioSalud extends CI_Controller{
    private $data = array();


    public function __construct(){
		parent::__construct();
		// Session
	    $this->ion_auth->redirectLoginIn();

	    // Models
        $this->load->model('SumarioSalud_model');
        $this->load->model('FiscalSumario_model');
        

 	    // Libraries
	    $this->load->library('upload');
	    
	    // Helpers
        $this->load->helper(array('date','download','file','html'));
        $this->data['menu_items'] = array(
            'sumario'
        );
    	// View data

    
        $this->load->helper('array');
        $this->load->helper('form');
        $this->load->helper('download');
		
		// Errors
		$this->data['errors'] = array();
        $this->data['title'] = 'FALSE';
        $this->data['subtitle'] = 'Sin titulo';

   }

public function index(){ //para ver formulario en la pag de sumario administrativo

  $this->view_handler->view('juridica/Flujosprocedimientos/Sumario_salud', 'Ingresar', $this->data);
   
}

    public function sumario(){
        $this->data['breadcrumb'] = array(
            array(
                'name' => 'Sumario Administrativo',
                'link' => site_url('sumario/index')
            )
        );
        $this->view_handler->view('juridica/Flujosprocedimientos/Sumario_salud','Ingresar',$this->data);
        $this->data['asignado'] = $this->SumarioSalud_model->getUsuarios();

    }


    public function insertarSumario(){
        //form validation
        $this->form_validation->set_rules('titulo','<b>Título de la Denuncia</b>','trim|required');
        $this->form_validation->set_rules('nom_cesfam','<b>Nombre Cesfam Denunciante</b>','trim|required');
        $this->form_validation->set_rules('rol','<b>Número Denuncia</b>','trim|required');
        $this->form_validation->set_rules('fecha_solicitud','<b>Fecha Solicitud de Denuncia</b>','trim|required');
        

        //creacion de array de datos.
        $titulo = $this->input->post('titulo');
        $nom_cesfam = $this->input->post('nom_cesfam');
        $rol = $this->input->post('rol');
        $archivo = $this->name();;  //nombre del archivo
        $documento=null;        
      
   
        //subida del archivo
        if(!empty($_FILES['userFiles']['name'][0])){
            $filesCount = count($_FILES['userFiles']['name']);
            $uploadPath = './files/juridica/SumarioSalud/'.$rol.'/';
            if (!is_dir($uploadPath)){
                mkdir($uploadPath, 0755, TRUE);
            }
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$i];
                $_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];
                $config = array(
                    'upload_path' => $uploadPath,
                    'allowed_types' => '*',
                    'overwrite' => true
                );
                $archivo.=basename($_FILES['userFile']['name'] ).'/';
                $this->upload->initialize($config);
                $this->upload->do_upload('userFile');
            }

            //creación de datos
            $datos = array(
                'titulo' => $this->input->post('titulo'),
                'nom_cesfam' => $this->input->post('nom_cesfam'),
                'rol' => $this->input->post('rol'),
                'fecha_solicitud' => $this->input->post('fecha_solicitud'),
                'archivo' => $archivo,
                'observacion' =>$this->input->post('observacion'),
                'etapa' => 0,
               
             
               
            );  
          
        }
        //insertar datos 
        $this->SumarioSalud_model->insertarSumario($datos);
        
    //obtener mail --> Enviar mail a jocelin+rodrigo para evaluación de antecedentes-----------------------------------------
        $mail = $this->FiscalSumario_model->getMail(1);   //fiscal asignado
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }

    public function name(){
        return basename($_FILES["documento"]["name"]);
    }

    //mostrar los datos por el id de la fila
    public function mostrarSumario($id=null){
        $this->data['title'] = 'FALSE';
        $this->data['subtitle'] = 'Página en blanco';
        $this->data['breadcrumb'] = array(
            array(
                'name' => 'Sumario administrativo',    
                'link' => site_url('sumario/index')  
            )
        );        
        $this->data['sumario'] = $this->SumarioSalud_model->getbyid($id);
         
        $this->view_handler->view('juridica/Flujosprocedimientos/Sumario_Salud','VerSumario',$this->data);
        
    }

    //perimite aceptar o rechazar sumario administrativo
    public function editarSumario($id, $value){
        
        $this->form_validation->set_rules('plazo_fiscal','<b>Fecha plazo hasta el cierre de la investigación</b>','trim|required');
        $this->form_validation->set_rules('rut_fiscal','<b>RUN Fiscal</b>','trim|required');
        $this->form_validation->set_rules('fecha_not','<b>Fecha de Notificación</b>','trim|required');

        $datos = array(
            'id' => $id,
            'etapa' => 1, // apertura
            'sentencia' => $value,
            'rut_fiscal' =>$this->input->post('rut_fiscal'),
            'fecha_not' =>$this->input->post('fecha_not'),
            'plazo_fiscal' => $this ->input->post('plazo_fiscal'),
        );
      
        var_dump($datos);
        $this->SumarioSalud_model->editarSumario($datos);
        redirect(site_url('inicio/index'));
    }


        public function instruccionSumario($id=null){ //denuncia aceptada

        $this->form_validation->set_rules('plazo_fiscal','<b>Fecha plazo hasta el cierre de la investigación</b>','trim|required');
        $this->form_validation->set_rules('rut_fiscal','<b>RUN Fiscal</b>','trim|required');
        $this->form_validation->set_rules('fecha_not','<b>Fecha de Notificación</b>','trim|required');

        $datos = array(

            'id' => $id,
            'fecha_not' => $this->input->post('fecha_not'),
            'rut_fiscal' =>$this->input->post('rut_fiscal'),
            'etapa' => 2, 
            'obs_sumario' => $this->input->post('obs_sumario'),
            'plazo_fiscal' => $this ->input->post('plazo_fiscal'),
        );
        
        $this->SumarioSalud_model->editarSumario($datos);
        
        $mail = $this->FiscalSumario_model->getMail(1);    

        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);

        redirect(site_url(''));
    }

    public function visacion($id){  //se debe agregar un contabilizador de plazo

        $this->form_validation->set_rules('rut_fiscal','<b>RUN Fiscal</b>','trim|required');
        $this->form_validation->set_rules('fecha_solicitud','<b>Fecha Solicitud de Denuncia</b>','trim|required');
        $this->form_validation->set_rules('plazo_fiscal','<b>Fecha plazo hasta el cierre de la investigación</b>','trim|required');
        $this->form_validation->set_rules('fecha_not','<b>Fecha de Notificación</b>','trim|required');
        $this->form_validation->set_rules('archivo','<b>Adjuntar Documentos:</b>','trim|required');
        $this->form_validation->set_rules('obs_sumario','<b?>Instrucción Sumario</b?','trim|required');

        $asignado = $this->FiscalSumario_model->getAsignado($id);

        $datos = array(

            'id' => $id,
            'titulo' => $this->input->post('titulo'),
            'nom_cesfam' => $this->input->post('nom_cesfam'),
            'rol' => $this->input->post('rol'),
            'fecha_solicitud' =>$this ->input->post('fecha_solictud'),
            'fecha_not' => $this->input->post('fecha_not'),
            'rut_fiscal' =>$asignado,
            'etapa' => 3, // Visación
            'obs_sumario' => $this->input->post('obs_sumario'),
            'archivo' => $this ->input->post('archivo'),
            'plazo_fiscal' => $this ->input->post('plazo_fiscal'),
   

        );

        $mail = $this->FiscalSumario_model->getMail($asignado);    
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);

        var_dump($datos);
        $this->SumarioSalud_model->editarSumario($datos);
        redirect(site_url('inicio/index'));
    }

    public function sobreseimiento($id, $value){  //dictamen

        $datos = array(

            'id' => $id,
            'etapa' => 4, 
            'sentencia' => $value, 
        );

        $this->SumarioSalud_model->editarSumario($datos);
        redirect(site_url(''));
    }

    
    public function cargos($id, $value){  //Formulación de Cargos -->puede existir prórroga de parte del inculpado

        $datos = array(

            'id' => $id,
            'etapa' => 5, // Formulación de Cargos
            'sentencia' => $value, 
          );


        $this->SumarioSalud_model->editarSumario($datos);
        redirect(site_url(''));
    }
    
    public function dictamen($id, $value){  // Vista Fiscal --- Dictamen Sumario


        $datos = array(

            'id' => $id,
            'titulo' => $this->input->post('titulo'),
            'nom_cesfam' => $this->input->post('nom_cesfam'),
            'rol' => $this->input->post('rol'),
            'fecha_solicitud' =>$this ->input->post('fecha_solictud'),
            'fecha_not' => $this->input->post('fecha_not'),
            'etapa' => 6, // Dictamen
            'obs_sumario' => $this->input->post('obs_sumario'),
            'archivo' => $this ->input->post('archivo'),
            'plazo_fiscal' => $this ->input->post('plazo_fiscal'), 
            'sentencia' => $this ->input->post('sentencia'), 
            'tipo' => $value,
          );

        $this->SumarioSalud_model->editarSumario($datos);
        redirect(site_url('inicio/index'));
    }

    public function resolucion($id, $value){  // Procedimiento Final
      
        $datos = array(

            'id' => $id,
            'titulo' => $this->input->post('titulo'),
            'nom_cesfam' => $this->input->post('nom_cesfam'),
            'rol' => $this->input->post('rol'),
            'fecha_solicitud' =>$this ->input->post('fecha_solictud'),
            'fecha_not' => $this->input->post('fecha_not'),
            'etapa' => 7, // Final
            'obs_sumario' => $this->input->post('obs_sumario'),
            'archivo' => $this ->input->post('archivo'),
            'plazo_fiscal' => $this ->input->post('plazo_fiscal'), 
            'sentencia' => $this ->input->post('sentencia'), 
            'tipo' => $value,
          );

        $this->SumarioSalud_model->editarSumario($datos);
        redirect(site_url(''));
    }
    
    //funcion para finalizar un caso.
    public function finalizarSumario($id,$value){
        
        $datos = array(
            'id' => $id,
            'sentencia' => $value,
            'etapa' => 7,
            'tipo' => $value,
        );

        $this->SumarioSalud_model->editarSumario($datos);

        redirect(site_url(''));
    }
      
    
    public function download($id){                   //funcion para descargar el documento. 
        $fichero = $this->SumarioSalud_model->getbyid($id);
        $file_path = './files/juridica/SumarioSalud/'.$fichero['rol'].'_'.$fichero['documento'];

        if($fichero['documento'] == NULL){
            redirect(site_url('inicio/index'));
        }

        force_download($file_path,NULL);
        redirect(site_url('inicio/index'));
    }




    public function asignarUsuario($id = null){   
                 //funcion para reasignar el valor del asignado en la tabla 
        $asignado = $this->input->post('asignado');
        $obs_sumario = $this->input->post('obs_sumario');

        $this->data['sumario'] = $this->SumarioSalud_model->getbyid($id);
        $this->data['asignado'] = $this->FiscalSumario_model->getUsuarios();
        
        $this->SumarioSalud_model->asignarUsuario($id,$asignado,$obs_sumario);

        if ($this->data['sumario']){
            $this->view_handler->view ('juridica/Flujosprocedimientos/Sumario_salud','VerSumario',$this->data);
        }

        
}

    public function enviarNotificacion($id_asignado){
        $data = $this->FiscalSumario_model->getMail($id_asignado);
        $this->SumarioSalud_model->sendMail($data['nombre'],$data['email']);
        $nombre = $data['nombre'];
        $email = $data['email'];
        $asignado['nombre'] = $nombre;
        $asignado['email'] = $email;

        $this->view_handler->view('juridica','notificacion',$asignado);
    }


    }




