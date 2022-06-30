<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class SumarioSalud_model extends General_model{
    public function __construct(){    
        $table = 'denuncia_salud';
        parent::__construct($table); 
    }

     public function datatable() {                  //inicializa la base de datos
        $table = 'denuncia_salud';
        $primaryKey = 'denuncia_salud.id';
		$columns = array(
			array( 'db' => 'denuncia_salud.id', 'dt' => 'id' ),
            array( 'db' => 'denuncia_salud.titulo', 'dt' => 'titulo' ),
			array( 'db' => 'denuncia_salud.nom_cesfam', 'dt' => 'nom_cesfam' ),
			array( 'db' => 'denuncia_salud.rol', 'dt' => 'rol' ),   // código fiscal o número de denuncia sumario
            array( 'db' => 'denuncia_salud.fecha_solicitud', 'dt' => 'fecha_solicitud' ),
            array( 'db' =>'denuncia_salud.plazo_fiscal', 'dt' => 'plazo_fiscal'),
            array( 'db' =>'denuncia_salud.contador', 'dt' => 'contador'),
			array( 'db' => 'denuncia_salud.fecha_not', 'dt' => 'fecha_not' ),
            array( 'db' => 'denuncia_salud.archivo', 'dt' => 'archivo' ),
            array( 'db' => 'denuncia_salud.rut_fiscal', 'dt' => 'rut_fiscal' ),
            array( 'db' =>'denuncia_salud.observacion', 'dt' => 'observacion'),
            array( 'db' =>'denuncia_salud.tipo', 'dt' => 'tipo'), 
            array( 'db' =>'denuncia_salud.etapa', 'dt' => 'etapa'), // Rechazada, denuncia aceptada, sumario, sobreseimiento, formulación cargo, resolución sumario
            array( 'db' =>'denuncia_salud.sentencia', 'dt' => 'sentencia'), //0 en espera, 1 rechazada, 2 aceptada
            array( 'db' =>'denuncia_salud.carpeta', 'dt' => 'carpeta'), //fiscal guarda archivos
            array( 'db' =>'denuncia_salud.obs_sumario', 'dt' => 'obs_sumario'),  
            array( 'db' =>'denuncia_salud.multa', 'dt' => 'multa'),
            array( 'db' =>'denuncia_salud.fecha_prorroga', 'dt' => 'fecha_prorroga'),    
            array( 'db' =>'denuncia_salud.fecha_plazos', 'dt' => 'fecha_plazos'),  
            array( 'db' =>'denuncia_salud.fecha_sumario', 'dt' => 'fecha_sumario'),  
            array( 'db' =>'denuncia_salud.fecha_prorroga', 'dt' => 'fecha_prorroga'), //Fecha sobreseimiento
            array( 'db' =>'denuncia_salud.fecha_defensa', 'dt' => 'fecha_defensa'),
            array( 'db' =>'denuncia_salud.fecha_resolucion', 'dt' => 'fecha_resolucion'),
            array( 'db' =>'denuncia_salud.fecha_reposicion', 'dt' => 'fecha_reposicion'),
		);
        $data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns);
        return $data;
    }

    public function insertarSumario($data){     
        $this->db->insert('denuncia_salud',$data);

    }

    public function editarSumario($data){    //funcion que edita el dato que recibe a partir del id, buscandolo en la tabla.
        $this->db->get('denuncia_salud');
        $this->db->where('id',$data ['id']);
        $this->db->update('denuncia_salud',$data);
    }


    public function getbyid($id=null){                    //devuelve la columna de la tabla de datos
        $query = $this->db->query('SELECT * FROM denuncia_salud WHERE denuncia_salud.id = '. $id);
        foreach($query->result() as $value){
            $data['id'] = $value->id;
            $data['titulo'] = $value->titulo;
            $data['nom_cesfam'] = $value->nom_cesfam;
            $data['rol'] = $value->rol;
            $data['fecha_solicitud'] = $value->fecha_solicitud;
            $data['plazo_fiscal'] = $value -> plazo_fiscal;
            $data['contador'] = $value -> contador;
            $data['fecha_not'] = $value->fecha_not;
            $data['archivo'] = $value->archivo;
            $data['rut_fiscal'] = $value->rut_fiscal;
            $data['observacion'] = $value->observacion;
            $data['tipo'] = $value->tipo;
            $data['etapa'] = $value->etapa;
            $data['sentencia'] = $value->sentencia;
            $data['carpeta'] = $value -> carpeta;
            $data['obs_sumario'] = $value -> obs_sumario;
            $data['multa'] = $value -> multa;
            $data['fecha_plazos'] = $value -> fecha_plazos;
            $data['fecha_sumario'] = $value -> fecha_sumario; //fecha de las etapas
            $data['fecha_sob'] = $value -> fecha_sob; 
            $data['fecha_prorroga'] = $value -> fecha_prorroga; 
            $data['fecha_defensa'] = $value -> fecha_defensa;
            $data['fecha_resolucion'] = $value -> fecha_resolucion;
            $data['fecha_reposicion'] = $value -> fecha_reposicion;
        }
        return $data;
    }
 



    public function asignar_usuario($id,$asignado,$observacion){
        $query = $this->db->query('UPDATE fiscal_sumario SET fiscal_sumario.rut_fiscal = '.$asignado.' WHERE fiscal_sumario.id = '.$id);
        $data = $this->FiscalSumario_model->getName($asignado);
        $query2 = $this->db->query('UPDATE fiscal_sumario SET fiscal_sumario.nombre_fiscal = '.'"'.$data['nombre_fiscal'].'"'.' WHERE fiscal_sumario.id = '.$id);
        $query3 = $this->db->query('UPDATE fiscal_sumario SET fiscal_sumario.apellido_fiscal = '.'"'.$data['apellido_fiscal'].'"'.' WHERE fiscal_sumario.id = '.$id);
        $query3 = $this->db->query('UPDATE fiscal_sumario SET fiscal_sumario.observacion = '.'"'.$observacion.'"'.' WHERE fiscal_sumario.id = '.$id);
    }

    public function getMail($id = null){
        $query = $this->db->query('SELECT * FROM users WHERE users.id = '. $id);
        foreach($query->result() as $value){
            $data['email'] = $value->email;
            $data['nombre'] = $value->first_name .' '. $value->last_name; 
        }
        return $data;
    }
    
    public function sendMail($nombre, $email){
        $this->load->library('PHPMailer_Lib');
        $mail = $this->phpmailer_lib->load();		
		$mail->isSMTP();
        //$mail->SMTPDebug = 2;
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
		$mail->Username = "notificaciones.td@cmvalparaiso.cl";
		$mail->Password = "1q2w3etdcmv";
		$mail->setFrom('notificaciones.td@cmvalparaiso.cl', 'Notificación TD');
		$mail->addAddress($email, $nombre);
		$mail->Subject = 'Sumario Administrativo';
		$mail->MsgHTML("Sumario Administrativo");
		$mail->CharSet = 'UTF-8';
		
		if(!empty($subject)){
			$mail->Subject = $subject;
		}
		return $mail->send();
	}
/*
    public function formatBodyMail($licencia){
		
		$cuerpo =	'<h4>Buenos dias,</h4>
					<br>
					Se ha recibido una licencia médica asociada a su centro:
					<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Nombre funcionario: '.$licencia['nombre'].' '.$licencia['apellido_paterno'].' '.$licencia['apellido_materno'].'
					<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - RUN: '.$licencia['rut'].'-'.$licencia['digito_rut'].'
					<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Fecha inicio reposo: '.$licencia['periodo'].'
					<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Cantidad de dias: '.$licencia['dias'].'
					<br>
					<br>
					Recuerde que puede consultar esta información en detalle en <A href="https://www.td.cmvalparaiso.cl">https://www.td.cmvalparaiso.cl</A> 
					<br>
					<br>
					Saludos.(Este mensaje es una notificación automatica. favor no responder el correo)';
		return $cuerpo;
	}

    private function enviarCorreo($licenciaAntigua, $licenciaNueva, $centroCosto, $where) {
    	$correos = $this->db->query("SELECT correo FROM correos_inst WHERE establecimiento='$centroCosto'")->result();
		$cuerpoCorreo = $this->formatBodyMail($licenciaAntigua, $licenciaNueva);
		$correoRemitente = '';
    	$cc = null;
    	if(!empty($correos)){
    		$correoRemitente = $correos[0]->correo;
    		if(count($correos) > 1){
    			unset($correos[0]);
    			$cc = $correos;
    		}
    	}
    	
    	$nombreRemitente = 'Establecimiento CMV';
    	
    	if(!$this->sendMail($nombreRemitente, $correoRemitente, $cuerpoCorreo, $cc, "Modificación de licencia médica")){
    		$this->update(array("correo_centro" => 0), $where);
    		return false;
    	} else {
    		return true;
    	}
    }

    */
    public function getArchivo($id){
        $query = $this->db->query('SELECT * FROM denuncia_salud WHERE id = '.$id);
        foreach($query->result() as $value){
            $documento = $value->archivo;
        }
        return $documento;
    }
 
    }

