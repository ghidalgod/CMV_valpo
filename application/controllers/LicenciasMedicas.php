<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LicenciasMedicas extends CI_Controller {

    public function __construct(){
		parent::__construct();
	    //$this->ion_auth->redirectLoginIn();
	    $this->load->model('Licencias_medicas_model');
	    $this->load->model('ProcessMaker_model');
	    $this->load->model('Igestion_model');
	    $this->load->library('form_validation');

	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Inicio',
											'link' =>  site_url('inicio/index')
										),
									);
    }

	public function index()	{
		$this->data['menu_items'] = array(
										'educacion',
										'personal',
										'licenciasmedicas'
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Licencias medicas',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Buscador';
		// Llamada a constructor de vista
		$this->view_handler->view('', 'licenciasmedicas', $this->data);
	}
	
	public function licenciasMedicas()	{
		$group = array('developed','lmedicas');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301); 
		
		//formularios y codigos de cada categoria y datos para kpi
		$this->data['centros'] = $this->ProcessMaker_model->getEstablecimiento();
		$this->data['cargos'] = $this->ProcessMaker_model->getCargos();
		$this->data['reporte'] = $this->Licencias_medicas_model->getReport();     //datos como id o numero de casos para los Filtros de busqueda
		$this->data['tiposLM'] = $this->Licencias_medicas_model->getTiposLM();	//formulario
		$this->data['salud'] = $this->Licencias_medicas_model->getSalud();		//formulario
		
		$this->data['menu_items'] = array(
										'licenciasMedicas',
										'lmedicas',
										'general'
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Licencias médicas',
											'link' =>  ''
										);
		// Título del contenido
		//$this->data['title'] = 'Licencias Médicas';
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Carga y géstion';
		// Llamada a constructor de vista
		$this->view_handler->view('licenciasmedicas', 'general', $this->data);
	}
	
	public function reporte()	{
		$group = array('developed','lmedicascentro');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301); 
		
		$this->data['menu_items'] = array(
										'licenciasMedicas',
										'lmedicascentro',
										'reporte',
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Reporte Licencias médicas',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Reporte y control';
		// Llamada a constructor de vista
		$this->data['reporte'] = $this->Licencias_medicas_model->getReport();
	
		$this->view_handler->view('licenciasmedicas', 'reporte', $this->data);
	}
	
	public function administrador(){
		$group = array('admin');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301); 
		
		//formularios y codigos de cada categoria y datos para kpi
		$this->data['centros'] = $this->ProcessMaker_model->getEstablecimiento();
		$this->data['cargos'] = $this->ProcessMaker_model->getCargos();
		$this->data['reporte'] = $this->Licencias_medicas_model->getReport();     //datos como id o numero de casos para los Filtros de busqueda
		$this->data['tiposLM'] = $this->Licencias_medicas_model->getTiposLM();	//formulario
		$this->data['salud'] = $this->Licencias_medicas_model->getSalud();		//formulario
		
		$this->data['menu_items'] = array(
										'licenciasMedicas'
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Licencias médicas',
											'link' =>  ''
										);
		// Título del contenido
		//$this->data['title'] = 'Licencias Médicas';
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Carga y gestión';
		// Llamada a constructor de vista
		$this->view_handler->view('licenciasmedicas', 'administrador', $this->data);
	}
	
	public function licencias180() {
		$group = array('lmedicas180');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		

		
		$this->data['menu_items'] = array('licenciasMedicas', 'lmedicas180');
		
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Licencias 180 días',
											'link' =>  ''
										);
										
		$this->data['title'] = 'Licencias Médicas';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Tope 180 días';									
		
		$this->view_handler->view('licenciasmedicas', 'licencias180', $this->data);
	}
	
	public function getLicenciasMedicas(){
		$group = array('developed','lmedicascentro','lmedicas','lmpersonal', "admin");
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
        $data = $this->Licencias_medicas_model->getAll();
		echo json_encode($data);
		return;
	}
	
	public function getPersonasSaludIncompatible(){
		$group = array('lmedicas180');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
        $data = $this->Licencias_medicas_model->getPersonasSaludIncompatible();
		echo json_encode($data);
		return;
	}
	
	public function getDetalleSaludIncompatible($rut){
		$group = array('lmedicas180');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
        $data = $this->Licencias_medicas_model->getDetalleSaludIncompatible($rut);
		echo json_encode($data);
		return;
	}	
	
	public function addLicenciaMedica(){
		$group = array('lmedicas');
		if(!$this->ion_auth->in_group($group)) return;
		
		if(!empty($this->input->post('centro'))) $letra = $this->input->post('centro')[0];
		
		if(!empty($letra)){	
			if(strcmp($letra,'K') == 0) $conv = 'salud';
				elseif(strcmp($letra,'Z') == 0 || strcmp($letra,'Y') == 0) $conv = 'normal';
					else $conv = $this->input->post('conv');
		} else $conv = 'error';
						
		$licenciaMedica = array(
            'numero_licencia' => $this->input->post('nlic'),
            'periodo' => $this->input->post('periodo'),
            'dias' => $this->input->post('dias'),
            'tipo' => $this->input->post('tipo'),
            'reposo' => $this->input->post('reposo'),
            'salud' => $this->input->post('salud'),
            'nombre' => $this->input->post('nombre'),
            'apellido_paterno' => $this->input->post('paterno'),
            'apellido_materno' => $this->input->post('materno'),
            'rut' => preg_replace('/[^k0-9]/i', '',$this->input->post('rut')),
            'digito_rut' => $this->input->post('digito_rut'),
            'cargo' => $this->input->post('cargo'),
            'centro' => $this->input->post('centro'),
            'medico' => $this->input->post('medico'),
            'rut_medico' => preg_replace('/[^k0-9]/i', '',$this->input->post('rut_medico')),
            'digito_rut_medico' => $this->input->post('digito_rut_medico'),
            'conv' => $conv,
            'correo_centro' => 1
        );
        //Validar si todos los campos fueron completados
        foreach ($licenciaMedica as $key => $item){
        	if($key != 'digito_rut' && $key != 'digito_rut_medico'){
	            if(empty($item)){
	                $response[] = 'ERROR_FORM_VALIDATOR';
	                $response[] = json_encode($licenciaMedica);	
	                echo json_encode($response);
	                return;
	            }
        	}
        }
        //valida el rut 
        if(!$this->validarRut($licenciaMedica['rut'].$licenciaMedica['digito_rut'])){
        	$response[] = 'ERROR_RUT_VALIDATOR';
            $response[] = json_encode($licenciaMedica);
            echo json_encode($response);
            return;
        }
        //valida rut medico
        if(!$this->validarRut($licenciaMedica['rut_medico'].$licenciaMedica['digito_rut_medico'])){
        	$response[] = 'ERROR_RUT_MEDICO_VALIDATOR';
            $response[] = json_encode($licenciaMedica);
            echo json_encode($response);
            return;
        }
        //valida si el numero de licencia ya fue ingresado
        if($this->Licencias_medicas_model->is_exists(array('numero_licencia' => $licenciaMedica['numero_licencia']))){
        	$response[] = "ERROR_DUPLICATE_NLIC";
        	$response[] = "TO-DO";
        	echo json_encode($response);
        	return;
        }
        //agrega la licencia, si guardo es 1, de otro caso error
        $respuesta = $this->Licencias_medicas_model->ingresar($licenciaMedica, $this->input->post('centro'));
        if(strcmp($respuesta[0],"SUCCESSFUL") == 0){
        	$licenciaMedica["id"] = $respuesta[1];
        	$licenciaMedica["fecha_registro"] = date("Y-m-d");
        	$licenciaMedica["correo_centro"] = 1;
        	$response[] = "SUCCESSFUL";
        	$response[] = json_encode($licenciaMedica);
        	echo json_encode($response);
        	return;
        }	else{
        		if(strcmp($respuesta[0],"ERROR_MAIL_SEND") == 0){
        			$licenciaMedica["id"] = $respuesta[1];
		        	$licenciaMedica["fecha_registro"] = date("Y-m-d");
		        	$licenciaMedica["correo_centro"] = 0;
        			$response[] = "ERROR_MAIL_SEND";
        			$response[] = json_encode($licenciaMedica);
        			echo json_encode($response);
        			return;
        		}else{
        			$response[] = "ERROR_DB_SAVE";
        			$response[] = "TO-DO";
        			echo json_encode($response);
        			return;
        		}
        	}
	}
	
	public function getPersonaRutProcess($rut = null, $digito = null){
		$group = array('developed','lmedicas');
		if(!$this->ion_auth->in_group($group)) return;
		
		if($rut < 10000000) $codigoPersona = '0'. $rut . '' .$digito;
				else $codigoPersona =  ''. $rut . '' . $digito;
		
		
		$data = $this->Igestion_model->getFuncionario($codigoPersona);
		
		if(!empty($data)){
			
			$data = array(
						'rut' => (int)substr($data[0]['CodigoPersona'],0,-1),
						'digito_rut' => substr($data[0]['CodigoPersona'],-1),
						'nombre' => $data[0]["Nombres"],
						'apellido_paterno' => $data[0]["ApellidoPaterno"],
						'apellido_materno' => $data[0]["ApellidoMaterno"],
						'centro' => $data[0]["CodigoCentro"],
						'cargo' => substr($data[0]["Cargo"],7),
						'categoria' => substr($data[0]["Categoria"],-1),
						'nivel' => $data[0]["CodigoNivel"],
						'calidad' => $data[0]["CalidadJuridica"]
					);
			echo json_encode(["SUCCESSFUL",$data]);
			return;
		}
		
		$data = $this->Licencias_medicas_model->getPersonalRut($rut);
		
		if(empty($data)) $data = $this->ProcessMaker_model->getPersonaLM($rut,$digito);
		
        if(!empty($data)){
			echo json_encode(["SUCCESSFUL",$data]);
		}	else {
				echo json_encode(["ERROR_NULL_DB",$data]);
			}
	}
	
	public function getMedicoRut($rut = null){
		$group = array('developed','lmedicas');
		if(!$this->ion_auth->in_group($group)) return;
		
		$data = $this->Licencias_medicas_model->getMedicoRut($rut);
		
		if(!empty($data)){
			echo json_encode(["SUCCESSFUL",$data]);
		}	else {
				echo json_encode(["ERROR_NULL_DB",$rut]);
			}
        
	}
	
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

	/*MODULO LICENCIAS MÉDICAS PERSONAL*/
	
	public function personal(){
		
		$group = array('lmpersonal');
		
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		$this->data['menu_items'] = array(
								'licenciasMedicas',
								'lmpersonal'
							);
		
		
		$this->data['title'] = 'FALSE';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Reporte y control';
		$this->data['estadosPagos'] = $this->Licencias_medicas_model->getDataEstadoPago();
		$this->data['resolucion'] = $this->Licencias_medicas_model->getDataResolucion();
		//var_dump($this->data['estadosPagos']);
		$this->data['reporte'] = $this->Licencias_medicas_model->getReport();
		$this->view_handler->view('licenciasmedicas', 'personal', $this->data); //Carga una vista en la direccion licenciasmedicas + personal
	}
	
	public function setDatosPersonal($licenciaId){
		$group = array('lmpersonal');
		if(!$this->ion_auth->in_group($group)) return;
		
		$response = array();
		
		$estado_pago = $this->input->post('estado_pago'.$licenciaId);
		$monto = $this->input->post('monto'.$licenciaId);
		$resolucion = $this->input->post('resolucion'.$licenciaId);
		$cant_dias = $this->input->post('cant_dias'.$licenciaId);
		$dias_pagados = $this->input->post('dias_pagados'.$licenciaId);
		
		
		/*if($monto == ''){
			array_push($response,'MNT_NULL');
			echo json_encode($response);
			return;
		}else{*/
			if($resolucion == 2 || $resolucion == 3){
				if($cant_dias == null || $cant_dias <= 0){
					array_push($response,'DAY_NULL');
					echo json_encode($response);
					return;
				}else{
					$data = array(
							'id' => $licenciaId,
							'estado_pago' => $estado_pago,
							'monto' => $monto,
							'resolucion' => $resolucion,
							'cantidad_dias' => $cant_dias,
							'dias_pagados' => $dias_pagados
	    		
						);
	    			$this->Licencias_medicas_model->agregarLMPersonal($data);
					array_push($response,'SUCCESS');
	    			echo json_encode($response);
	    			return;
				}
			}else{
				$data = array(
						'id' => $licenciaId,
						'estado_pago' => $estado_pago,
						'monto' => $monto,
						'resolucion' => $resolucion,
						'cantidad_dias' => $cant_dias,
						'dias_pagados' => $dias_pagados
					);
	    		$this->Licencias_medicas_model->agregarLMPersonal($data);
				array_push($response,'SUCCESS');
	    		echo json_encode($response);
	    		return;
			}
	/*	}*/	
	}
		
		
	public function getDatosPersonal($licenciaId){
		$group = array('lmpersonal');
		if(!$this->ion_auth->in_group($group)) return;
			return json_encode($this->Licencias_medicas_model->getDatosPersonal($licenciaId));
	}
	
	public function editLicenciaMedica() {
		$group = array('admin');
		if(!$this->ion_auth->in_group($group)) return;
		
		$anulacion = empty($this->input->post('anulacion')) ? 0 : 1;
		$letra = empty($this->input->post('centro')) ? null : $letra = $this->input->post('centro')[0];
		
		if(strcmp($letra,'K') == 0) $conv = 'salud';
			elseif(strcmp($letra,'Z') == 0 || strcmp($letra,'Y') == 0) $conv = 'normal';
				else $conv = $this->input->post('conv');
		
		$licenciaMedica = array(
            'numero_licencia' => $this->input->post('nlic'),
            'medico' => $this->input->post('medico'),
            'rut_medico' => preg_replace('/[^k0-9]/i', '',$this->input->post('rut_medico')),
            'digito_rut_medico' => $this->input->post('digito_rut_medico'),            
            'periodo' => $this->input->post('periodo'),
            'dias' => $this->input->post('dias'),
            'tipo' => $this->input->post('tipo'),
            'reposo' => $this->input->post('reposo'),
            'salud' => $this->input->post('salud'),
            'nombre' => $this->input->post('nombre'),
            'apellido_paterno' => $this->input->post('paterno'),
            'apellido_materno' => $this->input->post('materno'),
            'rut' => preg_replace('/[^k0-9]/i', '',$this->input->post('rut')),
            'digito_rut' => $this->input->post('digito_rut'),
            'cargo' => $this->input->post('cargo'),
            'centro' => $this->input->post('centro'),
            'conv' => $conv,
            'correo_centro' => 1,
            'anulada' => $anulacion
        );
        
        if($licenciaMedica['dias'] < 1){
            $response[] = 'ERROR_DAYS';
            $response[] = json_encode($licenciaMedica);
            echo json_encode($response);
            return;
        }
        
        foreach ($licenciaMedica as $key => $item){
        	if($key === 'anulada' || $key === 'digito_rut' || $key === 'digito_rut_medico') {
        		continue;
        	}
        	
            if(empty($item)){
                $response[] = 'ERROR_FORM_VALIDATOR';
                $response[] = json_encode($licenciaMedica);	
                echo json_encode($response);
                return;
            }
        }
        
        if(!$this->validarRut($licenciaMedica['rut'].$licenciaMedica['digito_rut'])){
        	$response[] = 'ERROR_RUT_VALIDATOR';
            $response[] = json_encode($licenciaMedica);
            echo json_encode($response);
            return;
        }
        
        if(!$this->validarRut($licenciaMedica['rut_medico'].$licenciaMedica['digito_rut_medico'])){
        	$response[] = 'ERROR_RUT_MEDICO_VALIDATOR';
            $response[] = json_encode($licenciaMedica);
            echo json_encode($response);
            return;
        }        
        
        $where = array("id" => $this->input->post('idRegistro'));
        
		$errorOrId = $this->Licencias_medicas_model->modificar($licenciaMedica, $where);
		
        if($errorOrId > 0){ //
        	$licenciaMedica["id"] = $errorOrId;
        	$licenciaMedica["fecha_registro"] = date("Y-m-d");
        	$licenciaMedica["correo_centro"] = 1;                  
        	$response[] = "SUCCESSFUL";
        	$response[] = json_encode($licenciaMedica);
        	echo json_encode($response);
        	return;
        } else if(strcmp($errorOrId,"ERROR_DUPLICATE_NLIC") === 0){
        	$response[] = "ERROR_DUPLICATE_NLIC";
        	$response[] = "TO-DO";
        	echo json_encode($response);
        	return;
        } else if(strcmp($errorOrId,"ERROR_MAIL_SEND_BOTH") === 0){
        	$response[] = "ERROR_MAIL_SEND_BOTH";
        	$response[] = "TO-DO";
        	echo json_encode($response);
        	return;
        } else if(strcmp($errorOrId,"ERROR_MAIL_SEND_CC1") === 0){
        	$response[] = "ERROR_MAIL_SEND_CC1";
        	$response[] = "TO-DO";
        	echo json_encode($response);
        	return;
        } else if(strcmp($errorOrId,"ERROR_MAIL_SEND_CC2") === 0){
        	$response[] = "ERROR_MAIL_SEND_CC2";
        	$response[] = "TO-DO";
        	echo json_encode($response);
        	return;
        } else {
        	$response[] = "ERROR_DB_SAVE";
        	$response[] = "TO-DO";
        	echo json_encode($response);
        	return;
        }
	}

	
}