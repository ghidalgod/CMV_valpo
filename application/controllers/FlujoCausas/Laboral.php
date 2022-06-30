<?php defined ('BASEPATH') OR exit ('No direct script access allowed');

class Laboral extends CI_Controller{
    private $data = array();

    public function __construct(){
        parent::__construct();
        //sesión
        $this->ion_auth->redirectLoginIn();

        //models
        $this->load->model('Laboral_model');

        //librerias
        $this->load->library('upload');
        //helpers
        $this->load->helper(array('date','download','file','html'));

        $this->data['menu_items'] = array(
            'causas'
        );
        $this->load->helper('array');
        $this->load->helper('form');
        $this->load->helper('download');

        //errores
        $this->data['errors'] = array();
        $this->data['title'] = 'FALSE';
        $this->data['subtitle'] = 'Sin titulo';

    }

    public function index(){
    }

    public function ordinario(){
        $this->data['breadcrumb'] = array(
            array(
                'name' => 'Laboral Ordinario',
                'link' => site_url('ordinario/index')
            )
        );
        $this->view_handler->view('juridica/Flujoscausa/Laboral','Ordinario',$this->data);
    }

    public function monitorio(){
        $this->data['title'] = 'FALSE';
		$this->data['subtitle'] = 'Página en blanco';
        
        $this->data['breadcrumb'] = array(
            array(
                'name' => 'Laboral Monitorio',
                'link' => site_url('monitorio/index')
            )
        );
        $this->view_handler->view('juridica/Flujoscausa/Laboral','Monitorio',$this->data);
        $this->data['asignado'] = $this->Laboral_model->getUsuarios();

    }

    //====================================================================MONITORIO==========================================================================================

    public function insertar_monitorio(){
        //form validation

        $this->form_validation->set_rules('n_demandante','<b>Nombre del Demandante</b>','trim|required');
        $this->form_validation->set_rules('rut','<b>RUT del Demandante</b>','trim|required');
        $this->form_validation->set_rules('rol','<b>RIT/ROL</b>','trim|required');
        $this->form_validation->set_rules('fecha_not','<b>Fecha de Notificación</b>','trim|required');
        $this->form_validation->set_rules('fecha_res','<b>Fecha de Respuesta</b>','trim|required');

        //creacion de array de datos.
        
        $rol = $this->input->post('rol');
        $tipo = explode("-",$rol);
        $n_archivo = $this->name();  //nombre del archivo
        $rut = $this->input->post('rut');
        $rol = $this->input->post('rol');
        $nombrecompleto = $this->Laboral_model->getName(96);
        $nombre = $nombrecompleto['nombre_asignado'];
        $apellido = $nombrecompleto['apellido_asignado'];

        $datos = array(
            'n_demandante' => $this->input->post('n_demandante'),
            'rut' => $this->input->post('rut'),
            'rol' => $this->input->post('rol'),
            'fecha_not' => $this->input->post('fecha_not'),
            'tribunal' => $this->input->post('tribunal'),
            'fecha_res' => $this->input->post('fecha_res'),
            'tipo' => $tipo[0],
            'id_asignado' => 96,
            'archivo' => $n_archivo,
            'etapa' => 1,
            'nombre_asignado' => $nombre,
            'apellido_asignado' =>$apellido
        );
        
        $config['upload_path'] = './files/juridica/LaboralM/';
        $config['allowed_types'] = '*';
        $config['overwrite'] = true;
        $config['file_name'] = $rut.'_'.$rol.'_'.$n_archivo;
        //subida del archivo
       
        if(!empty($_FILES['userFiles']['name'][0])){
            $filesCount = count($_FILES['userFiles']['name']);
            $uploadPath = './files/juridica/LaboralM/'.$rut.'_'.$rol.'/';
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
                $this->upload->initialize($config);
                $this->upload->do_upload('userFile');
                $this->Laboral_model->insertar_monitorio($datos);
                
            }
        }
        
    //obtener mail
        $mail = $this->Laboral_model->getMail(96);
        $this->Laboral_model->sendMail($mail['nombre'],$mail['email']);
        redirect(site_url('inicio/index'));
        
    }

    public function name(){
        return basename($_FILES["documento_fl"]["name"]);
    }

    //mostrar los datos por el id de la fila
    public function mostrar_monitorio_id($id = null){
        $this->data['title'] = 'FALSE';
        $this->data['subtitle'] = 'Página en blanco';
        $this->data['breadcrumb'] = array(
            array(
                'name' => 'Laboral Monitorio',
                'link' => site_url('monitorio/index')
            )
        );
        
        $this->data['denuncia'] = $this->Laboral_model->getbyid($id);
        $this->data['asignado'] = $this->Laboral_model->getUsuarios();
        $this->view_handler->view('juridica/Flujoscausa/Laboral','MonitorioMostrar',$this->data);
        
    }

    //edita la información que recibe
    public function editar_monitorio($id = null){  //recibe el id a partir del URI, desde la tabla del inicio.
        $this->form_validation->set_rules('fecha_not','<b>Fecha de Notificación</b>','trim|required');
        $this->form_validation->set_rules('n_demandante','<b>Nombre de Demandante</b>','trim|required');
        $this->form_validation->set_rules('rut','<b>RUT del Demandante</b>','trim|required');
        $this->form_validation->set_rules('rol','<b>RIT/ROL</b>','trim|required');
        $this->form_validation->set_rules('fecha_prep','<b?>Fecha de Audiencia Preparatoria</b?','trim|required');
        //var_dump($asignado);
        $asignado = $this->Laboral_model->getAsignado($id);

        $datos = array(
            'id' => $id, 
            'n_demandante' => $this->input->post('n_demandante'),       
            'rut' => $this->input->post('rut'),
            'rol' => $this->input->post('rol'),   
            'fecha_res' => $this->input->post('fecha_res'),
            'etapa' => 2,
            'id_asignado' => $asignado,
        );

        $mail = $this->Laboral_model->getMail($asignado);
        $this->Laboral_model->sendMail($mail['nombre'],$mail['email']);

        var_dump($datos);
        $this->Laboral_model->editar_monitorio($datos);
        redirect(site_url('inicio/index'));

    }

    //funcion para finalizar un caso.
    public function finalizar_monitorio($id = null,$value = null){
        $asignado = $this->Laboral_model->getAsignado($id);
        $datos = array(
            'id' => $id,
            'resolucion' => $value,
            'etapa' => 0,
            'id_asignado' => $asignado
        );

        $this->Laboral_model->editar_monitorio($datos);
        $mail = $this->Laboral_model->getMail($asignado);
        $this->Laboral_model->sendMail($mail['nombre'],$mail['email']);

        redirect(site_url('inicio/index'));
    }

// =================================================================ORDINARIO===================================================================================================
    public function insertar_ordinario(){
    //form validation

    $this->form_validation->set_rules('n_demandante','<b>Nombre del Demandante</b>','trim|required');
    $this->form_validation->set_rules('rut','<b>RUT del Demandante</b>','trim|required');
    $this->form_validation->set_rules('rol','<b>RIT/ROL</b>','trim|required');
    $this->form_validation->set_rules('fecha_not','<b>Fecha de Notificación</b>','trim|required');
    $this->form_validation->set_rules('fecha_prep','<b>Fecha de Audiencia Preparatoria</b>','trim');
    $this->form_validation->set_rules('fecha_juicio','<b>Fecha de Audiencia del Juicio</b>','trim');
    
 
    
    $rol = $this->input->post('rol');
    $tipo = explode("-",$rol);
    $n_archivo = $this->name();  //nombre del archivo
    $rut = $this->input->post('rut');
    $rol = $this->input->post('rol');
    $nombrecompleto = $this->Laboral_model->getName(96);
    $nombre = $nombrecompleto['nombre_asignado'];
    $apellido = $nombrecompleto['apellido_asignado'];
    $docFinal = null;
    

        //subida del archivo
   
    if(!empty($_FILES['userFiles']['name'][0])){
        $filesCount = count($_FILES['userFiles']['name']);
        $uploadPath = './files/juridica/LaboralM/'.$rut.'_'.$rol.'/';
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

            $docFinal.=basename($_FILES['userFile']['name'] ).'/';
         

            $this->upload->initialize($config);
            $this->upload->do_upload('userFile');
    
            
        }
    }

    $documento = explode(" ", $docFinal);

       //creacion de array de datos.
    $datos = array(
        'n_demandante' => $this->input->post('n_demandante'),
        'rut' => $this->input->post('rut'),
        'rol' => $this->input->post('rol'),
        'fecha_not' => $this->input->post('fecha_not'),
        'tribunal' => $this->input->post('tribunal'),
        'fecha_prep' => $this->input->post('fecha_prep'),
        'fecha_juicio' => $this->input->post('fecha_juicio'),
        'tipo' => $tipo[0],
        'id_asignado' => 96,
        'archivo' => $docFinal,
        'etapa' => 3,
        'nombre_asignado' => $nombre,
        'apellido_asignado' => $apellido
    );
    $this->Laboral_model->insertar_monitorio($datos);



   // $config['upload_path'] = './files/juridica/LaboralO/';
    //$config['allowed_types'] = '*';
    //$config['overwrite'] = true;
    //$config['file_name'] = $rut.'_'.$rol.'_'.$n_archivo;

    
    /*
    if($this->upload->initialize($config)){
    
    $this->upload->do_upload('documento_fl');
    }
    else{
        echo "no cargo el config";
    }


    $this->Laboral_model->insertar_ordinario($datos);
    */

    $mail = $this->Laboral_model->getMail(96);                  //por defecto se debe enviar al abogado por defecto que es Leonardo
    $this->Laboral_model->sendMail($mail['nombre'],$mail['email']);
    redirect(site_url('inicio/index'));
    
    
}

public function mostrar_ordinario_id($id = null){
        $this->data['title'] = 'FALSE';
        $this->data['subtitle'] = 'Página en blanco';
        $this->data['breadcrumb'] = array(
            array(
                'name' => 'Laboral Ordinario',
                'link' => site_url('ordinario/index')
            )
        );
        
        $this->data['denuncia'] = $this->Laboral_model->getbyid($id);
        $this->data['asignado'] = $this->Laboral_model->getUsuarios();
       
        $documento = $this->Laboral_model->getArchivo($id);
        $documento= explode("/", $documento);   
    

        foreach($documento as $k => $valor){

             $this ->data[$k]['docFinal'] = $documento[$k];
        }
   
    
        $this->view_handler->view('juridica/Flujoscausa/Laboral','OrdinarioMostrar',$this->data);

        
    }

    public function editar_ordinario($id=null){
        $this->form_validation->set_rules('fecha_not','<b>Fecha de Notificación</b>','trim');
        $this->form_validation->set_rules('fecha_prep','<b?>Fecha de Audiencia Preparatoria</b?','trim|required');
        $this->form_validation->set_rules('n_demandante','<b>Nombre de Demandante</b>','trim|required');
        $this->form_validation->set_rules('rut','<b>RUT del Demandante</b>','trim|required');
        $this->form_validation->set_rules('rol','<b>RIT/ROL</b>','trim|required');
        $asignado = $this->Laboral_model->getAsignado($id);
        var_dump($asignado);

        $datos = array(
            'id' => $id, 
            'n_demandante' => $this->input->post('n_demandante'),       
            'rut' => $this->input->post('rut'),
            'rol' => $this->input->post('rol'),   
            'fecha_prep' => $this->input->post('fecha_prep'),
            'etapa' => 4,
            'id_asignado' => $asignado,
            'observacion' => $this->input->post('observacion')
        );

        var_dump($datos);

        $mail = $this->Laboral_model->getMail($asignado);
        $this->Laboral_model->sendMail($mail['nombre'],$mail['email']);
        $this->Laboral_model->editar_ordinario($datos);
        redirect(site_url('inicio/index'));

    }

    public function editar_ordinario2($id=null){                        //pasa a la fase de la audiencia del juicio
        $this->form_validation->set_rules('fecha_not','<b>Fecha de Notificación</b>','trim|required');
        $this->form_validation->set_rules('fecha_juicio','<b?>Fecha de Audiencia de Juicio</b?','trim|required');
        $this->form_validation->set_rules('n_demandante','<b>Nombre de Demandante</b>','trim|required');
        $this->form_validation->set_rules('rut','<b>RUT del Demandante</b>','trim|required');
        $this->form_validation->set_rules('rol','<b>RIT/ROL</b>','trim|required');
        
        $asignado = $this->Laboral_model->getAsignado($id);
        $datos = array(
            'id' => $id, 
            'n_demandante' => $this->input->post('n_demandante'),       
            'rut' => $this->input->post('rut'),
            'rol' => $this->input->post('rol'),   
            'fecha_juicio' => $this->input->post('fecha_juicio'),
            'etapa' => 5,
            'id_asignado' => $asignado,
            'observacion' => $this->input->post('observacion')
        );

        $mail = $this->Laboral_model->getMail($asignado);
        $this->Laboral_model->sendMail($mail['nombre'],$mail['email']);
        $this->Laboral_model->editar_ordinario($datos);
        redirect(site_url('inicio/index'));

    }

    //funcion para finalizar un caso.
    public function finalizar_ordinario($id = null,$value = null){
        $asignado = $this->Laboral_model->getAsignado($id);
        $datos = array(
            'id' => $id,
            'resolucion' => $value,
            'etapa' => 0,
            'id_asignado' => $asignado,
            'observacion' => $this->input->post('observacion')
        );

        $this->Laboral_model->editar_monitorio($datos);
        
        $mail = $this->Laboral_model->getMail($asignado);
        $this->Laboral_model->sendMail($mail['nombre'],$mail['email']);

        redirect(site_url('inicio/index'));
    }


    public function impugnacion($id = null){             // esta es la funcion que llama cuando pasa a un estado de impugnacion
        $asignado = $this->Laboral_model->getAsignado($id);
        $datos = array(
            'id' => $id,
            'resolucion' => 0,
            'etapa' => 6,
            'id_asignado' => $asignado,
            'observacion' => $this->input->post('observacion')
        );

        $this->Laboral_model->editar_monitorio($datos);

        $mail = $this->Laboral_model->getMail($asignado);
        $this->Laboral_model->sendMail($mail['nombre'],$mail['email']);

        redirect(site_url('inicio/index'));

    }

//==============================================================================================================================================================================

    
    
    public function download($id = null){                   //funcion para descargar el documento. 
        $fichero = $this->Laboral_model->getbyid($id);
        $file_path = './files/juridica/LaboralM/'.$fichero['rut'].'_'.$fichero['rol'].'_'.$fichero['docFinal'];

        if($fichero['docFinal'] == NULL){
            redirect(site_url('inicio/index'));
        }

        force_download($file_path,NULL);
        redirect(site_url('inicio/index'));
    }



    public function asignar_usuario($id = null){            //funcion para reasignar el valor del asignado en la tabla 
            $asignado = $this->input->post('asignado');
            $obs = $this->input->post('obs_asignado');
            $this->Laboral_model->asignar_usuario($id,$asignado,$obs);
            $this->data['denuncia'] = $this->Laboral_model->getbyid($id);
            $this->data['asignado'] = $this->Laboral_model->getUsuarios();

            if ($this->data['denuncia']['tipo'] == 'O'){         //si es de tipo ordinario que llame nuevamente a la vista de mostrar.
            $this->view_handler->view('juridica/Flujoscausa/Laboral','OrdinarioMostrar',$this->data);
            }
            if ($this->data['denuncia']['tipo'] == 'M'){
                $this->view_handler->view('juridica/Flujoscausa/Laboral','MonitorioMostrar',$this->data);
            }
    }

    public function enviar_notificacion($id_asignado = null){
        $data = $this->Laboral_model->getMail($id_asignado);
        $this->Laboral_model->sendMail($data['nombre'],$data['email']);
        $nombre = $data['nombre'];
        $email = $data['email'];
        $asignado['nombre'] = $nombre;
        $asignado['email'] = $email;

        $this->view_handler->view('juridica','notificacion',$asignado);
    }



}