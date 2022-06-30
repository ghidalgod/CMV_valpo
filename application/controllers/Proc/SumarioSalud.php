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
  
        $rol = $this->input->post('rol');
        $archivo = $this->name();;  //nombre del archivo   
        $nombrecompleto = $this->FiscalSumario_model->getName(96);    //prueba para enviar notificación
        $nombre = $nombrecompleto['nombre_fiscal'];
        $apellido = $nombrecompleto['apellido_fiscal'];
  
      
   
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
          
        
        //insertar datos 
        $this->SumarioSalud_model->insertarSumario($datos);
        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }

    public function name(){
        return basename($_FILES["documento"]["name"]);
    }

    //mostrar los datos por el id de la fila
    public function mostrarSumario($id){
        $this->data['title'] = 'FALSE';
        $this->data['subtitle'] = 'Página en blanco';
        $this->data['breadcrumb'] = array(
            array(
                'name' => 'Sumario administrativo',    
                'link' => site_url('sumario/index')  
            )
        );        
        $this->data['sumario'] = $this->SumarioSalud_model->getbyid($id);
        $this->data['asignado'] = $this->FiscalSumario_model->getUsuarios();
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
            'fecha_not' =>$this->input->post('fecha_not'),
            'plazo_fiscal' => $this ->input->post('plazo_fiscal'),
        );
      
        var_dump($datos);
        $this->SumarioSalud_model->editarSumario($datos);
        redirect(site_url(''));
    }


        public function instruccionSumario($id){ //denuncia aceptada

        $datos = array(
            'id' => $id,
            'fecha_not' => $this->input->post('fecha_not'),
            'rut_fiscal' =>$this->input->post('rut_fiscal'),
            'etapa' => 2, 
            'obs_sumario' => $this->input->post('obs_sumario'),
            'plazo_fiscal' => $this ->input->post('plazo_fiscal'),
            'fecha_sumario' => $this->input->post('fecha_sumario'),
        );
        
        $this->SumarioSalud_model->editarSumario($datos);
        
        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }

    public function visacion($id){  //se debe agregar un contabilizador de plazo
        
        $datos = array(

            'id' => $id,
            'etapa' => 3, // Visación
            'plazo_fiscal' => $this ->input->post('plazo_fiscal'),
            'fecha_sumario' => $this->input->post('fecha_sumario'),
           );

      
        $this->SumarioSalud_model->editarSumario($datos);

        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }

    public function sobreseimiento($id){  //cierre de sumario

        $datos = array(

            'id' => $id,
            'etapa' => 4, 
            'sentencia' => 3, 
            'fecha_sumario' => $this->input->post('fecha_sumario'),
            'fecha_plazos' => $this ->input->post('fecha_plazos'), 
            'fecha_sob' => $this ->input->post('fecha_sob'), 
        );

        $this->SumarioSalud_model->editarSumario($datos);
    
        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }

    
    public function cargos($id){  //Formulación de Cargos -->puede existir prórroga de parte del inculpado
  
        $datos = array(

            'id' => $id,
            'etapa' => 5, // Formulación de Cargos
            'sentencia' => 4, 
            'fecha_sumario' => $this ->input->post('fecha_sumario'), 
            'fecha_resolucion' => $this ->input->post('fecha_resolucion'), 
            'fecha_prorroga' => $this ->input->post('fecha_prorroga'), 
            'fecha_defensa' => $this ->input->post('fecha_defensa'), 
            'fecha_plazos' => $this ->input->post('fecha_plazos'), 
          );
        $this->SumarioSalud_model->editarSumario($datos);
       
        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }
    
    public function dictamen($id){  // Vista Fiscal --- Dictamen Sumario -- fechas

        $carpeta = $this->name();  //nombre del archivo   
        $rol = 'rol'; 

        //subida del archivo
        if(!empty($_FILES['userFiles']['name'][0])){
            $filesCount = count($_FILES['userFiles']['name']);
            $uploadPath = './files/juridica/SumarioSalud/'.$id.'_'.$rol.'/';
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
                $carpeta.=basename($_FILES['userFile']['name'] ).'/';

                $this->upload->initialize($config);
                $this->upload->do_upload('userFile');
            }
        }
        $datos = array(

            'id' => $id,
            'etapa' => 6, 
            'rol' => $rol, 
            'obs_sumario' => $this->input->post('obs_sumario'),
            'carpeta'=> $carpeta,
            'fecha_defensa' => $this ->input->post('fecha_defensa'), 
            'fecha_plazos' => $this ->input->post('fecha_plazos'), 
          );

        $this->SumarioSalud_model->editarSumario($datos);
        
        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }

    public function fechasSumario($id){  // resolucion realizada por fiscal aboslución o sanción
      
        $datos = array(

            'id' => $id, 
            'etapa' => 7, 
            'fecha_prorroga' => $this ->input->post('fecha_prorroga'), 
            
        );

        $this->SumarioSalud_model->editarSumario($datos);
       
        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }

       public function dictamenFiscal($id, $value){  
      
        $datos = array(

            'id' => $id, 
            'etapa' => 8, // Final
            'fecha_sumario' => $this ->input->post('fecha_sumario'), 
            'fecha_resolucion' => $this ->input->post('fecha_resolucion'), 
            'fecha_prorroga' => $this ->input->post('fecha_prorroga'), 
            'fecha_defensa' => $this ->input->post('fecha_defensa'), 
            'sentencia' => $value,
          );

        $this->SumarioSalud_model->editarSumario($datos);
        
        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }

    

    public function absolucion($id){  // resolucion realizada por fiscal aboslución o sanción
      
        $datos = array(

            'id' => $id, 
            'etapa' => 9, 
            'sentencia' => 5,
            'fecha_prorroga' => $this ->input->post('fecha_prorroga'), 
            
        );

        $this->SumarioSalud_model->editarSumario($datos);
       
        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }


    public function sancionFiscal($id){  
      
        $datos = array(

            'id' => $id, 
            'etapa' => 9,
            'sentencia' => 6,
            'fecha_resolucion' => $this ->input->post('fecha_resolucion'), 
          );

        $this->SumarioSalud_model->editarSumario($datos);
       
        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }

    
    public function antecedentes($id){  
      
        $datos = array(

            'id' => $id, 
            'etapa' => 10,
            'fecha_resolucion' => $this ->input->post('fecha_resolucion'), 
        );

        $this->SumarioSalud_model->editarSumario($datos);
        
        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }

    
    //funcion para finalizar un caso.
    public function resolucionSecretario($id){
        
        $datos = array(
            'id' => $id,
            'etapa' => 11,
            'fecha_reposicion' => $this ->input->post('fecha_reposicion'), 
        );

        $this->SumarioSalud_model->editarSumario($datos);

        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }
      
    public function finalizarSumario($id,$value){
        
        $datos = array(
            'id' => $id,
            'sentencia' => $value,
            'etapa' => 12,
            'fecha_reposicion' => $this ->input->post('fecha_reposicion'), 
        );

        $this->SumarioSalud_model->editarSumario($datos);
        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }

   /* public function valorMulta($id){      ETAPA FINAL, PARA GUARDAR VALOR MULTA
        
        $datos = array(
            'id' => $id,
            'sentencia' => 8,
            'etapa' => 13,
            'multa' => $this ->input->post('multa'), 
        
        );

        $this->SumarioSalud_model->editarSumario($datos);
        $mail = $this->SumarioSalud_model->getMail(96); 
        $this->SumarioSalud_model->sendMail($mail['nombre'],$mail['email']);
        redirect('');
        
    }
      */

    public function download($id){                   //funcion para descargar el documento. 

        $fichero = $this->SumarioSalud_model->getbyid($id);
        $file_path = './files/juridica/SumarioSalud/'.$fichero['rol'];

        if($fichero['documento'] == NULL){
            redirect(site_url(''));
        }

        force_download($file_path,NULL);
        redirect(site_url(''));
    }



    public function enviarNotificacion($rut_fiscal){

        $data = $this->SumarioSalud_model->getMail($rut_fiscal);
        $this->SumarioSalud_model->sendMail($data['nombre'],$data['email']);
        $nombre = $data['nombre'];
        $email = $data['email'];
        $asignado['nombre'] = $nombre;
        $asignado['email'] = $email;

        $this->view_handler->view('juridica','notificacion',$asignado);
    }


    }




