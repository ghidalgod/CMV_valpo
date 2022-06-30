<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Licencias_medicas_model extends General_model {
	public function __construct() {
		$this->load->model('ProcessMaker_model');
		$table = 'licencias_medicas';
        parent::__construct($table);
    }
    
    public function ingresar($licenciaMedica = null,$codigoE = null){
    	$licenciaMedica['create_by'] = $this->session->userdata('identity');
    	$idRecord = $this->add_id($licenciaMedica);
    	if($idRecord > 0){
    		//$codigoE = 'KKK';
    		$cuerpoCorreo = $this->formatBodyMail($licenciaMedica);
    		$correos = $this->db->query("SELECT correo FROM correos_inst WHERE establecimiento='$codigoE'")->result();
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
    		if(!$this->sendMail($nombreRemitente, $correoRemitente, $cuerpoCorreo, $cc, 'Recepción licencia médica')){
    			$this->update(array("correo_centro" => 0), array("id" => $idRecord));
    			return ['ERROR_MAIL_SEND',$idRecord];
    		}else return ['SUCCESSFUL',$idRecord];
    	}else return ['ERROR_DB_SAVE'];
    }
    
	public function getAll(){
		$whereResult = null;
		$group = array('lmedicascentro');
		if($this->ion_auth->in_group($group)) {
    		$codigos = $this->ion_auth->getCodigosIgestion();
    		if(empty($codigos)){
				$whereResult = null;
    		}	else {
    				$whereResult = "(";
	    			foreach($codigos as $key => $value){
	    				$whereResult .= "centro = '".$value['codigo']."' OR ";
		    		}
		    		$whereResult = substr($whereResult, 0, -3). ")";
    			}
    	}
    	
   		$table = 'licencias_medicas';
    	$primaryKey = 'id';
    	$whereAll = "anulada = 0";
    	
		$columns = array(
	   		array( 'db' => 'id', 'dt' => 'ID' ),
	    	array( 'db' => 'numero_licencia', 'dt' => 'NLIC' ),
		    array( 'db' => 'periodo', 'dt' => 'PERIODO' ),
		    array( 'db' => 'dias', 'dt' => 'DIAS' ),
		    array( 'db' => 'nombre', 'dt' => 'NOMBRES' ),
		    array( 'db' => 'apellido_paterno', 'dt' => 'APELLIDO_PATERNO' ),
		    array( 'db' => 'apellido_materno', 'dt' => 'APELLIDO_MATERNO' ),
		    array( 'db' => 'rut', 'dt' => 'RUT' ),
		    array( 'db' => 'digito_rut', 'dt' => 'DIGITO' ),
		    array( 'db' => 'cargo', 'dt' => 'CARGO' ),
		    array( 'db' => 'centro', 'dt' => 'ESTAB' ),
		    array( 'db' => 'conv', 'dt' => 'CONV' ),
		    array( 'db' => 'correo_centro', 'dt' => 'CORREO' ),
		    array( 'db' => 'fecha_registro', 'dt' =>'FECHA_REGISTRO'),
		    array( 'db' => 'tipo', 'dt' =>'TIPO'),
		    array( 'db' => 'reposo', 'dt' =>'REPOSO'),
		    array( 'db' => 'salud', 'dt' =>'SALUD'),
		    array( 'db' => 'medico', 'dt' =>'MEDICO'),
		    array( 'db' => 'rut_medico', 'dt' =>'RUT_MEDICO'),
		    array( 'db' => 'digito_rut_medico', 'dt' =>'DIGITO_RUT_MEDICO'),
	    );
    	
    	$group = array('lmpersonal');
	    if($this->ion_auth->in_group($group)){
	    	$columns[] = array( 'db' => 'estado_pago', 'dt' =>'ESTADO_PAGO');
		    $columns[] = array( 'db' => 'monto', 'dt' =>'MONTO');
		    $columns[] = array( 'db' => 'resolucion', 'dt' =>'RESOLUCION');
   		    $columns[] = array( 'db' => 'cantidad_dias', 'dt' =>'CANTIDAD_DIAS');
	    }
	    
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll);
    	$centros = $this->ProcessMaker_model->getEstablecimiento();
    	
    	$estadosPagos = array('','Pagada', 'Pago parcial', 'Pago directo', 'Pendiente de pago', 'Sin derecho a pago');
    	$resolucion = array('', '1. Aprobada', '3. Ampliada', '4. Reducida', '2. Rechazada');

    	foreach($data['data'] as $key => $value){
    		$KeyCentro = array_search($value['ESTAB'], array_column($centros, 'codigo'));
    		if($KeyCentro !== FALSE) {
    			$data['data'][$key]['ESTAB'] = $centros[$KeyCentro]['nombre'];
    			$data['data'][$key]['CENTRO'] = $centros[$KeyCentro]['codigo'];
    		}
    		if($this->ion_auth->in_group($group)){
    			if(empty($value['RESOLUCION'])) $value['RESOLUCION'] = 0;
	    		$data['data'][$key]['ESTADO_PAGO'] = $estadosPagos[$value['ESTADO_PAGO']];
	    		$data['data'][$key]['RESOLUCION'] = $resolucion[$value['RESOLUCION']];
    		}
    		
    	}
		return $data;
    }
    
    public function getReport(){
    	
    	$whereResult = null;
    	$group = array('lmedicascentro');
   		if($this->ion_auth->in_group($group)) {
    		$codigos = $this->ion_auth->getCodigosIgestion();
    		if(empty($codigos)){
				$whereResult = null;
    		}	else {
    				$whereResult = "(";
	    			foreach($codigos as $key => $value){
	    				$whereResult .= "centro = '".$value['codigo']."' OR ";
		    		}
		    		$whereResult = substr($whereResult, 0, -3). ")";
    			}
    	}
   		
    	$this->db->select('id');
    	$this->db->from('licencias_medicas');
    	$this->db->where('DATE_ADD(periodo, INTERVAL dias DAY) >','CURDATE()',FALSE);
    	if($this->ion_auth->in_group($group)) if(!empty($codigos)) {$this->db->where($whereResult);}
		
		$query = $this->db->get();
		$activas = $query->result_array();
		
		$this->db->select('id');
		$this->db->from('licencias_medicas');
    	$this->db->where('DATE_ADD(periodo, INTERVAL dias DAY) BETWEEN','CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)',FALSE);
    	if($this->ion_auth->in_group($group)) if(!empty($codigos)) {$this->db->where($whereResult);}
		
		$query = $this->db->get();
		$vencen7dias = $query->result_array();
		
		$this->db->select('id, dias');
		$this->db->from('licencias_medicas');
    	$this->db->where('DATE_ADD(periodo, INTERVAL dias DAY) >','DATE_SUB(CURDATE(), INTERVAL 29 DAY)',FALSE);
    	if($this->ion_auth->in_group($group)) if(!empty($codigos)) {$this->db->where($whereResult);}
		
		$query = $this->db->get();
		$ultimo30dias = $query->result_array();
		$diasTotal = 0;
		
		foreach($ultimo30dias as $key => $value){
			$diasTotal += (int)$value['dias'];
		}
		
		$this->db->select('id, dias');
		$this->db->from('licencias_medicas');
    	$this->db->where('DATE_ADD(periodo, INTERVAL dias DAY) >','DATE_SUB(CURDATE(), INTERVAL 180 DAY)',FALSE);
    	if($this->ion_auth->in_group($group)) if(!empty($codigos)) {$this->db->where($whereResult);}
		
		$query = $this->db->get();
		$ultimo365dias = $query->result_array();
		
		$diasTotalAño = 0;
		foreach($ultimo365dias as $key => $value){
			$diasTotalAño += (int)$value['dias'];
		}
		
		$data = array(
				'activas' => $activas,
				'vencen7dias' => $vencen7dias,
				'ultimo30dias'=> $ultimo30dias,
				'ultimo30diastotal'=> $diasTotal,
				'ultimo365dias' => $ultimo365dias,
				'ultimo365diastotal' => $diasTotalAño,
			);
			
        return $data;
    }
    
    public function getTiposLM(){
    	
    	$data = array( 'Enfermedad o accidente común',
    					'Prórroga medicina preventiva',
    					'Licencia maternal pre y post natal',
    					'Enfermedad grave hijo menor de 1 año',
    					'Accidente del trabajo o del trayecto',
    					'Enfermedad profesional',
    					'Patología del embarazo');
    	
    	return $data;
    }
    
    public function getSalud(){
    	
    	$data = array( 'Fonasa',
    					'Banmédica S.A.',
    					'Chuquicamata Ltda.',
    					'Colmena Golden Cross S.A.',
    					'Consalud S.A.',
    					'Cruz Blanca S.A.',
    					'Cruz del Norte Ltda.',
    					'Nueva Masvida Ltda.',
    					'Fundación Ltda.',
    					'Fusat Ltda.',
    					'Río Blanco Ltda.',
    					'San Lorenzo Ltda.',
    					'Vida Tres S.A.',
    					'Instituto de Seguiridad del Trabajo');
    	
    	return $data;
    }
    
    public function getPersonalRut($rut = null){
    	if(empty($rut)) return null;
    	
    	$data = $this->get("*", array('rut' => $rut));
    	
    	if(!empty($data)){
    		$data = $data[0];
    	}
    	
    	return $data;
    	
    }
    
    public function getMedicoRut($rut = null){
    	if(empty($rut)) return null;
 
    	$data = $this->get("medico, digito_rut_medico", array('rut_medico' => $rut));
    	
    	if(!empty($data)){
    		$data = $data[0];
    	}
    	
    	return $data;
    	
    }
   
    public function sendMail($nombre = null, $email = null, $cuerpoCorreo, $cc = null, $subject){
        $this->load->library('PHPMailer_Lib');
        $mail = $this->phpmailer_lib->load();		
		$mail->isSMTP();
		$mail->Host = 'ssl://smtp.gmail.com';
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
		$mail->Password = "td456CMV";
		$mail->setFrom('notificaciones.td@cmvalparaiso.cl', 'Notificación TD');
		$mail->addAddress($email, $nombre);
		if(!empty($cc)){
			foreach($cc as $value){
				$mail->addCC($value->correo);
			}
		}
		$mail->Subject = $subject;
		$mail->MsgHTML($cuerpoCorreo);
		$mail->CharSet = 'UTF-8';
		return $mail->send();
	}
	
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
	
	/*PERSONAL*/
	
	public function agregarLMPersonal($data=null){
    	
    	return $this->update($data,array('id' => $data['id']));
    	
    }
    
    public function getDatosPersonal($licenciaId=null){	
    	$query = $this->db->get_where('licencias_medicas', array('id' => $licenciaId));
    	$datosPersonal = $query->result_array();
    	echo json_encode($datosPersonal);//$licenciaId;
    }
    
    public function getDataEstadoPago(){
    	
    	$this->db->select('*');
    	$this->db->from('estado_pago');
    	
    	$query = $this->db->get();
		$estadosPagos = $query->result_array();
    	return json_encode($estadosPagos);
    }
    
    public function getDataResolucion(){
    	
    	$this->db->select('*');
    	$this->db->from('resolucion');
    	
    	$query = $this->db->get();
		$resolucion = $query->result_array();
    	
    	return json_encode($resolucion);
    }
    
	public function modificar($licencia, $where) {
		$centroCostoAntiguo = $this->getCentroDeCostoLicenciaMedica($where);
		$centroCostoNuevo = $licencia["centro"];
		
		$respuestaCC1 = false;
		$respuestaCC2 = false;
		$licenciaAntigua = $this->db->get_where($this->table, $where)->result()[0];
		
		if ($this->update($licencia, $where, null, null)) {
			if ($centroCostoAntiguo !== $centroCostoNuevo) {
				$respuestaCC1 = $this->enviarCorreo($licenciaAntigua, $licencia, $centroCostoAntiguo, $where);
				$respuestaCC2 = $this->enviarCorreo($licenciaAntigua, $licencia, $centroCostoNuevo, $where);
				if(!$respuestaCC1 && !$respuestaCC2) {
					return "ERROR_MAIL_SEND_BOTH";
				} else if (!$respuestaCC1){
					return "ERROR_MAIL_SEND_CC1";
				} else if (!$respuestaCC2) {
					return "ERROR_MAIL_SEND_CC2";
				} else {
					return $where["id"];
				}				
			} else {
				$respuestaCC2 = $this->enviarCorreo($licenciaAntigua, $licencia, $centroCostoNuevo, $where);
				if(!$respuestaCC2) {
					return "ERROR_MAIL_SEND_BOTH";
				} else {
					return $where["id"];
				}				
			}
			
		} else if ($this->db->error()["code"] === 1062) { 
			return "ERROR_DUPLICATE_NLIC";
		} else {
			return false;
		}		
	}
	
    private function getCentroDeCostoLicenciaMedica($where) {
		$this->db->select('centro');
    	$res = $this->db->get_where($this->table, $where)->result();
    	if ($res) {
    		return $res[0]->centro;
    	} else {
    		return false;
    	}
    }
    
    private function enviarCorreo($licenciaAntigua, $licenciaNueva, $centroCosto, $where) {
    	$correos = $this->db->query("SELECT correo FROM correos_inst WHERE establecimiento='$centroCosto'")->result();
		$cuerpoCorreo = $this->formatBodyMailLicenciaModificada($licenciaAntigua, $licenciaNueva);
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
    
    private function formatBodyMailLicenciaModificada($licenciaAntigua, $licenciaNueva){
		$cuerpo = " <h3>Buen día,</h3>
					<p>Se ha modificado una licencia médica asociada a su centro:</p>
					<h4>Licencia Original</h4>
					<ul>
						<li>RUN: $licenciaAntigua->rut-$licenciaAntigua->digito_rut</li>
						<li>Nombre funcionario: $licenciaAntigua->nombre $licenciaAntigua->apellido_paterno $licenciaAntigua->apellido_materno</li>
						<li>N° de licencia: $licenciaAntigua->numero_licencia</li>
						<li>Médico: $licenciaAntigua->medico</li>
						<li>Rut médico: $licenciaAntigua->rut_medico-$licenciaAntigua->digito_rut_medico$</li>
						<li>Fecha inicio reposo: $licenciaAntigua->periodo</li>
						<li>Cantidad de dias: $licenciaAntigua->dias</li>
						<li>Cargo: $licenciaAntigua->cargo</li>
						<li>Centro de costo: $licenciaAntigua->centro</li>
						<li>Convenio: $licenciaAntigua->conv</li>
						<li>Tipo: $licenciaAntigua->tipo</li>
						<li>Reposo: $licenciaAntigua->reposo</li>
						<li>Salud: $licenciaAntigua->salud</li>
						<li>Licencia anulada: " . ($licenciaAntigua->anulada ? "Sí" : "No") . "</li>
					</ul>
					<h4>Licencia Nueva</h4>
					<ul>
						<li>RUN: {$licenciaNueva['rut']}-{$licenciaNueva['digito_rut']}</li>
						<li>Nombre funcionario: {$licenciaNueva['nombre']} {$licenciaNueva['apellido_paterno']} {$licenciaNueva['apellido_materno']}</li>
						<li>N° de licencia: {$licenciaNueva['numero_licencia']}</li>
						<li>Médico: {$licenciaNueva['medico']}</li>
						<li>Rut médico: {$licenciaNueva['rut_medico']}-{$licenciaNueva['digito_rut_medico']}</li>
						<li>Fecha inicio reposo: {$licenciaNueva['periodo']}</li>
						<li>Cantidad de dias: {$licenciaNueva['dias']}</li>
						<li>Cargo: {$licenciaNueva['cargo']}</li>
						<li>Centro de costo: {$licenciaNueva['centro']}</li>
						<li>Convenio: {$licenciaNueva['conv']}</li>
						<li>Tipo: {$licenciaNueva['tipo']}</li>
						<li>Reposo: {$licenciaNueva['reposo']}</li>
						<li>Salud: {$licenciaNueva['salud']}</li>
						<li>Licencia anulada: " . ($licenciaNueva['anulada'] ? "Sí" : "No") . "</li>
					</ul>
					<p>Recuerde que puede consultar esta información en detalle en <A href='https://www.td.cmvalparaiso.cl'>https://www.td.cmvalparaiso.cl</A></p>
					<p>Saludos.</p>
					<p>(Este mensaje es una notificación automatica. favor no responder el correo)</p>";
		return $cuerpo;
	}    
    
    public function getPersonasSaludIncompatible(){
		$whereResult = null;
		$group = array('lmedicascentro');
		if($this->ion_auth->in_group($group)) {
    		$codigos = $this->ion_auth->getCodigosIgestion();
    		if(empty($codigos)){
				$whereResult = null;
    		}	else {
    				$whereResult = "(";
	    			foreach($codigos as $key => $value){
	    				$whereResult .= "centro = '".$value['codigo']."' OR ";
		    		}
		    		$whereResult = substr($whereResult, 0, -3). ")";
    			}
    	}
    	
   		$table = 'salud_incompatible';
    	$primaryKey = 'rut';
    	
		$columns = array(
		    array( 'db' => 'total_dias', 'dt' => 'DIAS' ),
		    array( 'db' => 'nombre', 'dt' => 'NOMBRES' ),
		    array( 'db' => 'apellido_paterno', 'dt' => 'APELLIDO_PATERNO' ),
		    array( 'db' => 'apellido_materno', 'dt' => 'APELLIDO_MATERNO' ),
		    array( 'db' => 'rut', 'dt' => 'RUT' ),
		    array( 'db' => 'digito_rut', 'dt' => 'DIGITO' ),
		    array( 'db' => 'centro', 'dt' => 'ESTAB' ),
		    array( 'db' => 'cargo', 'dt' => 'CARGO' )
		);

    	$data = $this->data_tables->complex($_POST, $table, $primaryKey, $columns, $whereResult);
    	
    	$centros = $this->ProcessMaker_model->getEstablecimiento();
		
    	foreach($data['data'] as $key => $value){
    		$KeyCentro = array_search($value['ESTAB'], array_column($centros, 'codigo'));
    		if($KeyCentro !== FALSE) {
    			$data['data'][$key]['ESTAB'] = $centros[$KeyCentro]['nombre'];
    			$data['data'][$key]['CENTRO'] = $centros[$KeyCentro]['codigo'];
    		}
    	}    	
    	
    	return $data;
    }
    
    public function getDetalleSaludIncompatible($rut){
		$whereResult = "rut = $rut";

   		$table = 'salud_incompatible_detalle';
    	$primaryKey = 'id';
    	
		$columns = array(
			array( 'db' => 'id', 'dt' => 'ID' ),
		    array( 'db' => 'numero_licencia', 'dt' => 'NLIC' ),
		    array( 'db' => 'tipo', 'dt' => 'TIPO' ),
		    array( 'db' => 'termino', 'dt' => 'TERMINO' ),
		    array( 'db' => 'periodo', 'dt' => 'PERIODO' ),
		    array( 'db' => 'dias', 'dt' => 'DIAS' )
		);

    	$data = $this->data_tables->complex($_POST, $table, $primaryKey, $columns, $whereResult);
    	
    	return $data;
    }
}