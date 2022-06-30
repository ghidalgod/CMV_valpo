<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class ProcessMaker_model extends General_model {
	public function __construct() {
		$table = 'PMT_REEMPLAZO_EDUCACION';
        //parent::__construct($table);
        $dbProcess = $this->load->database('processMaker', TRUE);
        parent::__construct($table, $dbProcess);
    }


	//++++++++++++++++EDUCACIÓN PERSONAL++++++++++++++++++++
    private function getReemplazosEducacion() {
    	$table = 'PMT_REEMPLAZO_EDUCACION';
    	$primaryKey = 'PMT_REEMPLAZO_EDUCACION.APP_UID';
    	$columnCentro = 'PMT_REEMPLAZO_EDUCACION.ESTABLECIMIENTO_SOLICITANTE';
    	$tipoFiltroCentro = 1;
    	$whereResult = $this->getFiltroCentros($columnCentro, $tipoFiltroCentro);

    	$join = 'JOIN PMT_TABLA_REEMPLAZANTE ON PMT_REEMPLAZO_EDUCACION.APP_UID = PMT_TABLA_REEMPLAZANTE.APP_UID JOIN APP_CACHE_VIEW ON PMT_REEMPLAZO_EDUCACION.APP_UID = APP_CACHE_VIEW.APP_UID'; // JOIN TASK ON PROCESS.PRO_UID = 
		$whereAll = "PMT_TABLA_REEMPLAZANTE.APP_STATUS <> 'CANCELLED' AND PMT_TABLA_REEMPLAZANTE.APP_STATUS <> 'DRAFT' AND APP_CACHE_VIEW.DEL_LAST_INDEX = 1";
		
		//$whereAll = "APP_CACHE_VIEW.DEL_THREAD_STATUS='OPEN' AND DEL_FINISH_DATE IS NULL";
		
		$columns = array(
			//Datos de caso
	   		array( 'db' => 'PMT_REEMPLAZO_EDUCACION.APP_UID', 'dt' => 'APP_UID' ),
	   		array( 'db' => 'PMT_REEMPLAZO_EDUCACION	.APP_STATUS', 'dt' => 'APP_STATUS' ),
	    	array( 'db' => 'PMT_REEMPLAZO_EDUCACION.APP_NUMBER', 'dt' => 'APP_NUMBER' ),
	    	//Datos del funcionario que se aucentara por motivos de licencia medica, vacaciónes, o otros.
		    array( 'db' => 'PMT_REEMPLAZO_EDUCACION.ESTABLECIMIENTO_SOLICITANTE_LABEL', 'dt' => 'ESTABLECIMIENTO_SOLICITANTE_LABEL' ),
		    array( 'db' => 'PMT_REEMPLAZO_EDUCACION.RUT_REEMPLAZADO_LABEL', 'dt' => 'RUT_REEMPLAZADO_LABEL' ),
		    array( 'db' => 'PMT_REEMPLAZO_EDUCACION.NOMBRES_REEMPLAZADO_LABEL', 'dt' => 'NOMBRES_REEMPLAZADO_LABEL' ),
		    array( 'db' => 'PMT_REEMPLAZO_EDUCACION.APELLIDOS_REEMPLAZADO_LABEL', 'dt' => 'APELLIDOS_REEMPLAZADO_LABEL' ),
		    array( 'db' => 'PMT_REEMPLAZO_EDUCACION.CARGO_LABEL', 'dt' => 'CARGO_LABEL' ),
		    array( 'db' => 'PMT_REEMPLAZO_EDUCACION.MOTIVO_REEMPLAZO_LABEL', 'dt' => 'MOTIVO_REEMPLAZO_LABEL' ),
			//Datos del reemplazo que cubrira las horas o parte de estas.
		    array( 'db' => 'PMT_TABLA_REEMPLAZANTE.FUNCIONARIOS_RUT', 'dt' => 'FUNCIONARIOS_RUT' ),
		    array( 'db' => 'PMT_TABLA_REEMPLAZANTE.FUNCIONARIOS_NOMBRE', 'dt' => 'FUNCIONARIOS_NOMBRE' ),
		    array( 'db' => 'PMT_TABLA_REEMPLAZANTE.TEXT0000000001', 'dt' => 'FUNCIONARIOS_APELLIDO' ),
		    array( 'db' => 'PMT_TABLA_REEMPLAZANTE.FUNCIONARIOS_DESDE', 'dt' => 'FUNCIONARIOS_DESDE' ),
		    array( 'db' => 'PMT_TABLA_REEMPLAZANTE.FUNCIONARIOS_HASTA', 'dt' => 'FECHA_TERMINO_LABEL' ),
		    array( 'db' => 'PMT_TABLA_REEMPLAZANTE.FUNCIONARIOS_HORAS', 'dt' => 'FUNCIONARIOS_HORAS' ),
		    array( 'db' => 'PMT_TABLA_REEMPLAZANTE.DROPDOWN0000000006_LABEL', 'dt' => 'FUNCIONARIOS_FINANCIAMIENTO' ),
		    
		    array( 'db' => 'PMT_TABLA_REEMPLAZANTE.DROPDOWN0000000001_LABEL', 'dt' => 'TIPO' ),
		    array( 'db' => 'PMT_TABLA_REEMPLAZANTE.DROPDOWN0000000004_LABEL', 'dt' => 'PREVISION' ),
		    array( 'db' => 'PMT_TABLA_REEMPLAZANTE.DROPDOWN0000000005_LABEL', 'dt' => 'SALUD' ),
		    //datos adicionales del caso, como fecha creación, usuario responsable, nombre de tarea y proceso.
		    array( 'db' => 'APP_CACHE_VIEW.APP_CREATE_DATE', 'dt' => 'APP_CREATE_DATE' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CURRENT_USER', 'dt' => 'USR_FIRSTNAME' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_TAS_TITLE', 'dt' => 'TAS_TITLE' ),
		    array( 'db' => 'APP_CACHE_VIEW.TAS_UID', 'dt' => 'TAS_UID' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_PRO_TITLE', 'dt' => 'PRO_TITLE' ),
		    array( 'db' => 'APP_CACHE_VIEW.PRO_UID', 'dt' => 'PRO_UID' ),
	    );
	    
    	$dbProcess = $this->load->database('processMaker', TRUE);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll, $join, $dbProcess);
        return $data;
    }
    
    private function getProrrogasEducacion() {
    	$table = 'PMT_PRORROGAS_EDUCACION';
    	$primaryKey = 'PMT_PRORROGAS_EDUCACION.APP_UID';
    	
    	$columnCentro = 'PMT_PRORROGAS_EDUCACION.ESTABLECIMIENTO_SOLICITANTE';
    	$tipoFiltroCentro = 1;
    	$whereResult = $this->getFiltroCentros($columnCentro, $tipoFiltroCentro);
    	
    	$join = 'JOIN PMT_GRILLA_PRORROGA_EDUCACION ON PMT_PRORROGAS_EDUCACION.APP_UID = PMT_GRILLA_PRORROGA_EDUCACION.APP_UID JOIN APP_CACHE_VIEW ON PMT_GRILLA_PRORROGA_EDUCACION.APP_UID = APP_CACHE_VIEW.APP_UID'; // JOIN TASK ON PROCESS.PRO_UID = 
		$whereAll = "PMT_PRORROGAS_EDUCACION.APP_STATUS <> 'CANCELLED' AND PMT_PRORROGAS_EDUCACION.APP_STATUS <> 'DRAFT' AND APP_CACHE_VIEW.DEL_LAST_INDEX = 1";
		
		$columns = array(
			//datos del caso
	   		array( 'db' => 'PMT_PRORROGAS_EDUCACION.APP_UID', 'dt' => 'APP_UID' ),
	    	array( 'db' => 'PMT_PRORROGAS_EDUCACION.APP_NUMBER', 'dt' => 'APP_NUMBER' ),
	    	array( 'db' => 'PMT_PRORROGAS_EDUCACION.APP_STATUS', 'dt' => 'APP_STATUS' ),
	    	//Datos del funcionario que se aucentara por motivos de licencia medica, vacaciónes, o otros.
		    array( 'db' => 'PMT_PRORROGAS_EDUCACION.ESTABLECIMIENTO_SOLICITANTE_LABEL', 'dt' => 'ESTABLECIMIENTO_SOLICITANTE_LABEL' ),
		    array( 'db' => 'PMT_PRORROGAS_EDUCACION.RUT_REEMPLAZADO_LABEL', 'dt' => 'RUT_REEMPLAZADO_LABEL' ),
		    array( 'db' => 'PMT_PRORROGAS_EDUCACION.NOMBRES_REEMPLAZADO_LABEL', 'dt' => 'NOMBRES_REEMPLAZADO_LABEL' ),
		    array( 'db' => 'PMT_PRORROGAS_EDUCACION.APELLIDOS_REEMPLAZADO_LABEL', 'dt' => 'APELLIDOS_REEMPLAZADO_LABEL' ),
		    array( 'db' => 'PMT_PRORROGAS_EDUCACION.CARGO_LABEL', 'dt' => 'CARGO_LABEL' ),
		    array( 'db' => 'PMT_PRORROGAS_EDUCACION.MOTIVO_REEMPLAZO_LABEL', 'dt' => 'MOTIVO_REEMPLAZO_LABEL' ),
		    //Datos del reemplazo que cubrira las horas o parte de estas.
		    array( 'db' => 'PMT_GRILLA_PRORROGA_EDUCACION.FUNCIONARIOS_NOMBRE', 'dt' => 'FUNCIONARIOS_NOMBRE' ),
		    array( 'db' => 'PMT_GRILLA_PRORROGA_EDUCACION.TEXT0000000001', 'dt' => 'FUNCIONARIOS_APELLIDO' ),
		    array( 'db' => 'PMT_GRILLA_PRORROGA_EDUCACION.FUNCIONARIOS_RUT', 'dt' => 'FUNCIONARIOS_RUT' ),
		    array( 'db' => 'PMT_GRILLA_PRORROGA_EDUCACION.FUNCIONARIOS_DESDE', 'dt' => 'FUNCIONARIOS_DESDE' ),
		    array( 'db' => 'PMT_GRILLA_PRORROGA_EDUCACION.FUNCIONARIOS_HASTA', 'dt' => 'FECHA_TERMINO_LABEL' ),
		    array( 'db' => 'PMT_GRILLA_PRORROGA_EDUCACION.FUNCIONARIOS_HORAS', 'dt' => 'FUNCIONARIOS_HORAS' ),
		    array( 'db' => 'PMT_GRILLA_PRORROGA_EDUCACION.DROPDOWN0000000004_LABEL', 'dt' => 'FUNCIONARIOS_FINANCIAMIENTO' ),
		    array( 'db' => 'PMT_GRILLA_PRORROGA_EDUCACION.DROPDOWN0000000001_LABEL', 'dt' => 'TIPO' ),
		    array( 'db' => 'PMT_GRILLA_PRORROGA_EDUCACION.FUNCIONARIOS_PREVISION_LABEL', 'dt' => 'PREVISION' ),
		    array( 'db' => 'PMT_GRILLA_PRORROGA_EDUCACION.FUNCIONARIOS_SALUD_LABEL', 'dt' => 'SALUD' ),
		    //datos adicionales del caso, como fecha creación, usuario responsable, nombre de tarea y proceso.
		    array( 'db' => 'APP_CACHE_VIEW.APP_CREATE_DATE', 'dt' => 'APP_CREATE_DATE' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CURRENT_USER', 'dt' => 'USR_FIRSTNAME' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_TAS_TITLE', 'dt' => 'TAS_TITLE' ),
		    array( 'db' => 'APP_CACHE_VIEW.TAS_UID', 'dt' => 'TAS_UID' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_PRO_TITLE', 'dt' => 'PRO_TITLE' ),
		    array( 'db' => 'APP_CACHE_VIEW.PRO_UID', 'dt' => 'PRO_UID' ),
	    );
	    
    	$dbProcess = $this->load->database('processMaker', TRUE);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll, $join, $dbProcess);
        return $data;
    }
    
    private function getAmpliacionesEducacion() {
    	$table = 'PMT_AMPLIACIONES_EDUCACION';
    	$primaryKey = 'PMT_AMPLIACIONES_EDUCACION.APP_UID';
    	
    	$columnCentro = 'PMT_AMPLIACIONES_EDUCACION.ESTABLECIMIENTO_SOLICITANTE';
    	$tipoFiltroCentro = 1;
    	$whereResult = $this->getFiltroCentros($columnCentro, $tipoFiltroCentro);

    	
    	$join = 'JOIN APP_CACHE_VIEW ON PMT_AMPLIACIONES_EDUCACION.APP_UID = APP_CACHE_VIEW.APP_UID'; // JOIN TASK ON PROCESS.PRO_UID = 
		$whereAll = "PMT_AMPLIACIONES_EDUCACION.APP_STATUS <> 'CANCELLED' AND PMT_AMPLIACIONES_EDUCACION.APP_STATUS <> 'DRAFT' AND APP_CACHE_VIEW.DEL_LAST_INDEX = 1";
		$columns = array(
			//datos del caso
	   		array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.APP_UID', 'dt' => 'APP_UID' ),
	    	array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.APP_NUMBER', 'dt' => 'APP_NUMBER' ),
	    	array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.APP_STATUS', 'dt' => 'APP_STATUS' ),
	    	//datos del funcionario
		    array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.ESTABLECIMIENTO_SOLICITANTE_LABEL', 'dt' => 'ESTABLECIMIENTO_SOLICITANTE_LABEL' ),
		    array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.RUT_REEMPLAZANTE', 'dt' => 'RUT_REEMPLAZADO_LABEL' ),
		    array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.NOMBRE_REEMPLAZANTE', 'dt' => 'NOMBRES_REEMPLAZADO_LABEL' ),
		    array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.APELLIDOS_REEMPLAZANTE', 'dt' => 'APELLIDOS_REEMPLAZADO_LABEL' ),
		    array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.CARGO_LABEL', 'dt' => 'CARGO_LABEL' ),
		    array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.JUSTIFICACION_AMPLIACION', 'dt' => 'MOTIVO_REEMPLAZO_LABEL' ),
		    array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.FECHA_TERMINO', 'dt' => 'FECHA_TERMINO_LABEL' ),
		    array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.FECHA_INICIO', 'dt' => 'FUNCIONARIOS_DESDE' ),
		    array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.HRS_AMPLIAR_1', 'dt' => 'FUNCIONARIOS_HORAS' ),
		    array( 'db' => 'PMT_AMPLIACIONES_EDUCACION.CENTROS_DE_COSTO_LABEL', 'dt' => 'FUNCIONARIOS_FINANCIAMIENTO' ),
			//datos adicionales del caso, como fecha creación, usuario responsable, nombre de tarea y proceso.
		    array( 'db' => 'APP_CACHE_VIEW.APP_CREATE_DATE', 'dt' => 'APP_CREATE_DATE' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CURRENT_USER', 'dt' => 'USR_FIRSTNAME' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_TAS_TITLE', 'dt' => 'TAS_TITLE' ),
		    array( 'db' => 'APP_CACHE_VIEW.TAS_UID', 'dt' => 'TAS_UID' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_PRO_TITLE', 'dt' => 'PRO_TITLE' ),
		    array( 'db' => 'APP_CACHE_VIEW.PRO_UID', 'dt' => 'PRO_UID' ),
	    );

    	$dbProcess = $this->load->database('processMaker', TRUE);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll, $join, $dbProcess);
        return $data;
    }
    
    public function getNuevoContratosEducacion() {
    	$table = 'PMT_NUEVOSCONTRATOS_EDUCACION';
    	$primaryKey = 'PMT_NUEVOSCONTRATOS_EDUCACION.APP_UID';
    	$columnCentro = 'PMT_NUEVOSCONTRATOS_EDUCACION.ESTABLECIMIENTO_SOLICITANTE';
    	$tipoFiltroCentro = 1;
    	$whereResult = $this->getFiltroCentros($columnCentro, $tipoFiltroCentro);

    	$join = 'JOIN APP_CACHE_VIEW ON PMT_NUEVOSCONTRATOS_EDUCACION.APP_UID = APP_CACHE_VIEW.APP_UID'; // JOIN TASK ON PROCESS.PRO_UID = 
		$whereAll = "PMT_NUEVOSCONTRATOS_EDUCACION.APP_STATUS <> 'CANCELLED' AND PMT_NUEVOSCONTRATOS_EDUCACION.APP_STATUS <> 'DRAFT' AND APP_CACHE_VIEW.DEL_LAST_INDEX = 1";
		
		//$whereAll = "APP_CACHE_VIEW.DEL_THREAD_STATUS='OPEN' AND DEL_FINISH_DATE IS NULL";
		
		$columns = array(
			//Datos de caso
	   		array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.APP_UID', 'dt' => 'APP_UID' ),
	   		array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.APP_STATUS', 'dt' => 'APP_STATUS' ),
	    	array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.APP_NUMBER', 'dt' => 'APP_NUMBER' ),
	    	//Datos del funcionario que se aucentara por motivos de licencia medica, vacaciónes, o otros.
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.ESTABLECIMIENTO_SOLICITANTE_LABEL', 'dt' => 'ESTABLECIMIENTO_SOLICITANTE_LABEL' ),
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.RUT_TITULAR', 'dt' => 'RUT_REEMPLAZADO_LABEL' ),
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.NOMBRES_TITULAR', 'dt' => 'NOMBRES_REEMPLAZADO_LABEL' ),
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.APELLIDO_PATERNO_TITULAR', 'dt' => 'APELLIDOS_REEMPLAZADO_LABEL' ),
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.CARGO_TITULAR_LABEL', 'dt' => 'CARGO_LABEL' ),
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.MOTIVO_TITULAR_LABEL', 'dt' => 'MOTIVO_REEMPLAZO_LABEL' ),
			//Datos del reemplazo que cubrira las horas o parte de estas.
			
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.APELLIDO_MATERNO_TITULAR', 'dt' => 'FUNCIONARIOS_RUT' ),
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.INDEFINIDO_TITULAR', 'dt' => 'INDEFINIDO' ),
		    //array( 'db' => ' .TEXT0000000001', 'dt' => 'FUNCIONARIOS_APELLIDO' ),
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.INICIO_TITULAR', 'dt' => 'FUNCIONARIOS_DESDE' ),
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.FIN_TITULAR', 'dt' => 'FECHA_TERMINO_LABEL' ),
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.HORAS_TITULAR', 'dt' => 'FUNCIONARIOS_HORAS' ),
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.FINANCIAMIENTO_TITULAR_LABEL', 'dt' => 'FUNCIONARIOS_FINANCIAMIENTO' ),
		    
		    array( 'db' => 'PMT_NUEVOSCONTRATOS_EDUCACION.TIPO_FINANCIAMIENTO_TITULAR_LABEL', 'dt' => 'TIPO' ),
		    //array( 'db' => ' .DROPDOWN0000000004_LABEL', 'dt' => 'PREVISION' ),
		    //array( 'db' => ' .DROPDOWN0000000005_LABEL', 'dt' => 'SALUD' ),
		    
		    //datos adicionales del caso, como fecha creación, usuario responsable, nombre de tarea y proceso.
		    array( 'db' => 'APP_CACHE_VIEW.APP_CREATE_DATE', 'dt' => 'APP_CREATE_DATE' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CURRENT_USER', 'dt' => 'USR_FIRSTNAME' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_TAS_TITLE', 'dt' => 'TAS_TITLE' ),
		    array( 'db' => 'APP_CACHE_VIEW.TAS_UID', 'dt' => 'TAS_UID' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_PRO_TITLE', 'dt' => 'PRO_TITLE' ),
		    array( 'db' => 'APP_CACHE_VIEW.PRO_UID', 'dt' => 'PRO_UID' ),
	    );
	    
    	$dbProcess = $this->load->database('processMaker', TRUE);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll, $join, $dbProcess);
        return $data;
    }
    
    private function getAllEducacion(){
        $reemplazos = $this->getReemplazosEducacion();
        $prorrogas = $this->getProrrogasEducacion();
        $ampliaciones = $this->getAmpliacionesEducacion();
        $nuevosContratos = $this->getNuevoContratosEducacion();
        
        $data = array(
			"draw"            => $reemplazos['draw'],
			"recordsTotal"    => $reemplazos['recordsTotal'] + $prorrogas['recordsTotal'] + $ampliaciones['recordsTotal'],
			"recordsFiltered" => $reemplazos['recordsFiltered'],
			"data"            => array_merge(array_merge($reemplazos['data'], $prorrogas['data']), $ampliaciones['data'])
		);
		
		$data['data'] = array_merge($data['data'],$nuevosContratos['data']);
		
		return $data;
        
    }
    
    public function getIndicadoresE(){
    	$casosProcessGrilla = $this->getAllEducacion();

    	$casosProcess = $this->unique_multidim_array($casosProcessGrilla['data'], 'APP_NUMBER');
    	
    	$casosCompletados = 0;
    	$casosEnCurso = 0;
    	$casosBorrador = 0;
    	$reemplazosActivos = array();
    	$vencen7Dias = array();
    	
    	$resumenCN = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    	$resumenR = array(0, 0, 0, 0, 0, 0, 0, 0);
    	$resumenP = array(0, 0, 0, 0, 0, 0, 0, 0);
    	$resumenA = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
    	
    	$dataTable = array();
    	
    	//uid tareas de nuevos contratos
    	$taskCNID_VSEP = '3493856915e541b84bbd034010187816';
    	$taskCNID_VF = '2913531435e28a9979b64d5072019288';
    	$taskCNID_VAE = '7152775745e28a91f828264093324118';
    	$taskCNID_ASDE = '5412965235e29bb2d9b5d60096802545';
    	$taskCNID_CC = '2421141715e38233be96854006880758';
    	$taskCNID_CR = '1559981245e383543c79f14099948969';
    	$taskCNID_RE = '4602735145e39616802e9d4062439693';
    	$taskCNID_CC2 = '4289354935e57d7ec9758e9051032746';
    	$taskCNID_NR = '9099665605e29baddd62df6056850589';
    	$taskCNID_SC = '4415687185e287ebc7ccf77026818745';
    	
    	//uid tareas de reemplazo
    	$taskRUID_VJ = '4361483165dd5745c265616070974787';
    	$taskRUID_VPIE = '7050045335d65587320f2b2080178525';
    	$taskRUID_VAE = '1970904545c45deb206f261098191784';
    	$taskRUID_VSDE = '6868457525c45deb2198036056415719';
    	$taskRUID_ECC = '7426494965c45deb2102915023858423';
    	$taskRUID_CR = '4574224135c45deb20b9f93063375385';
    	$taskRUID_RE = '6015278045c45deb1e99996035107736';
    	$taskRUID_NR = '3094454645c45deb1d11cb5038948715';
    	//uid tareas de prorrogas
    	$taskPUID_VJ = '7862012735dd6b8ab6479e9059492106';
    	$taskPUID_VPIE = '5520675835d6d755532f5c3037801177';
    	$taskPUID_VAE = '9100553525cc1b6b7436634094139750';
    	$taskPUID_VSDE = '4767213395cc1b6b7807f46055406310';
    	$taskPUID_VP = '8862455525cc1b6b79dd813013068163';
    	$taskPUID_CR = '6928705435cc1b6b761f208061470290';
    	$taskPUID_RE = '4765612275cc1b6b6c440b3006493802';
    	$taskPUID_NR = '1067326945cc1b6b6a78b51010523474';
    	//uid tareas de ampliaciones
    	$taskAUID_VJ = '7466360915dd6ca601d7276012910966';
    	$taskAUID_VCH = '8994067395d44a156067236050354847';
    	$taskAUID_VFF = '7518575255cf14e3b0f8b30090691663';
    	$taskAUID_VAE = '8696857175cf14e3b1c7cc2016902924';
    	$taskAUID_VSDE = '2339769845cf14e3b288619082606695';
    	$taskAUID_VCD = '8626038035cf14e3ad91f20031325265';
    	$taskAUID_CAC = '1727311535cfe763ab28a53014067762';
    	$taskAUID_RE = '9455296735cf14e3b0295b5014593812';
    	$taskAUID_NR = '6635905875cf14e3ae725e4076648408';
    	
    	$debugg = array(); ////////////////////////////////////////////////////
    	
    	foreach($casosProcess as $key => $value){
    		switch($value['APP_STATUS']){
    			case 'COMPLETED': 
    				$casosCompletados += 1; 
    				break;
    				
    			case 'TO_DO': 
    				$casosEnCurso += 1;
    				switch($value['PRO_TITLE'][0]){
    					case '0':
		    				switch($value['TAS_UID']){
		    					case $taskCNID_VSEP : $resumenCN[0] += 1; break;
				        		case $taskCNID_VF : $resumenCN[1] += 1; break;
				        		case $taskCNID_VAE : $resumenCN[2] += 1; break;
				        		case $taskCNID_ASDE : $resumenCN[3] += 1; break;
				        		case $taskCNID_CC : $resumenCN[4] += 1; break;
				        		case $taskCNID_CR : $resumenCN[5] += 1; break;
				        		case $taskCNID_RE : $resumenCN[6] += 1; break;
				        		case $taskCNID_CC2 : $resumenCN[7] += 1; break;
				        		case $taskCNID_NR : $resumenCN[8] += 1; break;
				        		case $taskCNID_SC : $resumenCN[9] += 1; break;
		    				}
		    				break;
		    			case '1':
		    				switch($value['TAS_UID']){
		    					case $taskRUID_VJ : $resumenR[0] += 1; break;
				        		case $taskRUID_VPIE : $resumenR[1] += 1; break;
				        		case $taskRUID_VAE : $resumenR[2] += 1; break;
				        		case $taskRUID_VSDE : $resumenR[3] += 1; break;
				        		case $taskRUID_ECC : $resumenR[4] += 1; break;
				        		case $taskRUID_CR : $resumenR[5] += 1; break;
				        		case $taskRUID_RE : $resumenR[6] += 1; break;
				        		case $taskRUID_NR : $resumenR[7] += 1; break;
		    				}
		    				break;
		    			case '2':
		    				switch($value['TAS_UID']){
				        		case $taskPUID_VJ : $resumenP[0] += 1; break;
				        		case $taskPUID_VPIE : $resumenP[1] += 1; break;
				        		case $taskPUID_VAE : $resumenP[2] += 1; break;
				        		case $taskPUID_VSDE : $resumenP[3] += 1; break;
				        		case $taskPUID_VP : $resumenP[4] += 1; break;
				        		case $taskPUID_CR : $resumenP[5] += 1; break;
				        		case $taskPUID_RE : $resumenP[6] += 1; break;
				        		case $taskPUID_NR : $resumenP[7] += 1; break;
		    				}
		    				break;
		    			case '3':
		    				switch($value['TAS_UID']){
		    					case $taskAUID_VJ : $resumenA[0] += 1; break;
				        		case $taskAUID_VCH : $resumenA[1] += 1; break;
				        		case $taskAUID_VFF : $resumenA[2] += 1; break;
				        		case $taskAUID_VAE : $resumenA[3] += 1; break;
				        		case $taskAUID_VSDE : $resumenA[4] += 1; break;
				        		case $taskAUID_VCD : $resumenA[5] += 1; break;
				        		case $taskAUID_CAC : $resumenA[6] += 1; break;
				        		case $taskAUID_RE : $resumenA[7] += 1; break;
				        		case $taskAUID_NR : $resumenA[8] += 1; break;
		    				}
		    				break;
		    		}
    				break;
    		}
    		
			if($value['PRO_UID'] == '4789488115e2878f19b2c05048474524'){
				$casosProcessGrilla['data'][$key]['APELLIDOS_REEMPLAZADO_LABEL']  = $casosProcessGrilla['data'][$key]['APELLIDOS_REEMPLAZADO_LABEL'] . ' ' . $value['FUNCIONARIOS_RUT'];
				$casosProcessGrilla['data'][$key]['FUNCIONARIOS_RUT']  = 'Nuevo Contrato';
				$casosProcessGrilla['data'][$key]['FUNCIONARIOS_NOMBRE']  = 'Nuevo Contrato';
				$casosProcessGrilla['data'][$key]['FUNCIONARIOS_APELLIDO']  = '';
				$casosProcessGrilla['data'][$key]['PREVISION']  = 'Como documento en la solicitud de process';
				$casosProcessGrilla['data'][$key]['SALUD']  = 'Como documento en la solicitud de process';
				if($value['INDEFINIDO']) $casosProcessGrilla['data'][$key]['FECHA_TERMINO_LABEL'] = '2100-01-01';
			}
    	}
    	
    	$dataTable = json_encode($casosProcessGrilla['data']);
    	
    	foreach($casosProcessGrilla['data'] as $key => $value){
    		
    		if($value['TAS_UID'] != '3094454645c45deb1d11cb5038948715' && $value['TAS_UID'] != '1067326945cc1b6b6a78b51010523474' && $value['TAS_UID'] != '6635905875cf14e3ae725e4076648408' && $value['TAS_UID'] != '9099665605e29baddd62df6056850589'){
	    		if($value['FECHA_TERMINO_LABEL'] >= date('Y-m-d')){
	    			$reemplazosActivos[] = $value;
	    			if($value['FECHA_TERMINO_LABEL'] <= date('Y-m-d', strtotime(date('Y-m-d'). ' + 7 days'))){
		    			$vencen7Dias[] = $value;
		    		}
	    		}
    		}
    	}
    	
    	$whereResult = $this->getFiltroCentros('PMT_REEMPLAZO_EDUCACION.ESTABLECIMIENTO_SOLICITANTE', 1);
    	$this->db->select('PMT_REEMPLAZO_EDUCACION.APP_NUMBER');
    	$this->db->from('PMT_REEMPLAZO_EDUCACION');
    	$this->db->where('PMT_REEMPLAZO_EDUCACION.APP_STATUS','DRAFT');
    	if(!empty($whereResult)) $this->db->where($whereResult);
    	
    	$casosBorrador = $this->db->count_all_results();
    	
    	$whereResult = $this->getFiltroCentros('PMT_PRORROGAS_EDUCACION.ESTABLECIMIENTO_SOLICITANTE', 1);
    	$this->db->select('PMT_PRORROGAS_EDUCACION.APP_NUMBER');
    	$this->db->from('PMT_PRORROGAS_EDUCACION');
    	$this->db->where('PMT_PRORROGAS_EDUCACION.APP_STATUS','DRAFT');
    	if(!empty($whereResult)) $this->db->where($whereResult);
    	
    	$casosBorrador += $this->db->count_all_results();
    	
    	$whereResult = $this->getFiltroCentros('PMT_AMPLIACIONES_EDUCACION.ESTABLECIMIENTO_SOLICITANTE', 1);
    	$this->db->select('PMT_AMPLIACIONES_EDUCACION.APP_NUMBER');
    	$this->db->from('PMT_AMPLIACIONES_EDUCACION');
    	$this->db->where('PMT_AMPLIACIONES_EDUCACION.APP_STATUS','DRAFT');
    	if(!empty($whereResult)) $this->db->where($whereResult);
    	
    	$casosBorrador += $this->db->count_all_results();
    	
    	$whereResult = $this->getFiltroCentros('PMT_NUEVOSCONTRATOS_EDUCACION.ESTABLECIMIENTO_SOLICITANTE', 1);
    	$this->db->select('PMT_NUEVOSCONTRATOS_EDUCACION.APP_NUMBER');
    	$this->db->from('PMT_NUEVOSCONTRATOS_EDUCACION');
    	$this->db->where('PMT_NUEVOSCONTRATOS_EDUCACION.APP_STATUS','DRAFT');
    	if(!empty($whereResult)) $this->db->where($whereResult);
    	
    	$casosBorrador += $this->db->count_all_results();
    	
    	return array($casosCompletados, $casosEnCurso, $casosBorrador, $reemplazosActivos, $vencen7Dias, $resumenR, $resumenP, $resumenA, $dataTable, $resumenCN);
    	
    }
    
    //---------------EDUCACIÓN PERSONAL-----------------------
    
    //++++++++++++++++SALUD PERSONAL++++++++++++++++++++
    
    private function getReemplazosSalud() {
    	$table = 'PMT_REEMPLAZO';
    	$primaryKey = 'PMT_REEMPLAZO.APP_UID';
    	$whereResult = null;
    	if($this->ion_auth->in_group(11)){
    		$filtroActivo = false;
    		$codigos = $this->ion_auth->getCodigosIgestion();
    		if(empty($codigos)){
				$whereResult = null;
    		}	else {
    				$whereResult = "(";
	    			foreach($codigos as $key => $value){
	    				$this->table = 'PMT_ESTABLECIMIENTOS_SALUD';
	    				$id_dynaform = $this->get('id_dynaform',array('codigo_centro' => $value['codigo'] ));
	    				if(!empty($id_dynaform)){
	    					$filtroActivo = true;
	    					$whereResult .= "PMT_REEMPLAZO.CENTROS_DE_COSTO = '".$id_dynaform[0]->id_dynaform."' OR ";
	    				}
		    		}
		    		$filtroActivo ? $whereResult = substr($whereResult, 0, -3). ")" : $whereResult = null;
    			}
    	}
    	
    	$whereAll = "(PMT_REEMPLAZO.APP_STATUS = 'TO_DO' OR PMT_REEMPLAZO.APP_STATUS = 'COMPLETED') AND APP_CACHE_VIEW.DEL_LAST_INDEX = 1";
    	$join = 'JOIN APP_CACHE_VIEW ON PMT_REEMPLAZO.APP_UID = APP_CACHE_VIEW.APP_UID';
		$columns = array(
	   		array( 'db' => 'PMT_REEMPLAZO.APP_UID', 'dt' => 'APP_UID' ),
	    	array( 'db' => 'PMT_REEMPLAZO.APP_NUMBER', 'dt' => 'APP_NUMBER' ),
	    	array( 'db' => 'PMT_REEMPLAZO.NOMBRE_SOLICINTANTE', 'dt' => 'NOMBRE_SOLICITANTE' ),
		    array( 'db' => 'PMT_REEMPLAZO.CENTROS_DE_COSTO_LABEL', 'dt' => 'CENTRO_COSTO' ),
		    
		    array( 'db' => 'PMT_REEMPLAZO.NOMBRE_REEMPLAZANTE', 'dt' => 'NOMBRE_REEMPLAZANTE' ),
		    array( 'db' => 'PMT_REEMPLAZO.APELLIDOS_REEMPLAZANTE_LABEL', 'dt' => 'APELLIDO_REEMPLAZANTE' ),
		    array( 'db' => 'PMT_REEMPLAZO.RUT_REEMPLAZANTE_LABEL', 'dt' => 'RUT_REEMPLAZANTE' ),
		    array( 'db' => 'PMT_REEMPLAZO.TELEFONO_REEMPLAZANTE_LABEL', 'dt' => 'TELEFONO_REEMPLAZANTE' ),
		    array( 'db' => 'PMT_REEMPLAZO.direccion_reemplazante', 'dt' => 'DIRECCION_REEMPLAZANTE' ),
		    array( 'db' => 'PMT_REEMPLAZO.fecha_nac_reemplazante_label', 'dt' => 'FECHA_NAC_REEMPLAZANTE' ),
		    
		    array( 'db' => 'PMT_REEMPLAZO.MOTIVO_REEMPLAZO_LABEL', 'dt' => 'MOTIVO_REEMPLAZO' ),
		    array( 'db' => 'PMT_REEMPLAZO.HORAS_REEMPLAZO_LABEL', 'dt' => 'HORAS' ),
		    array( 'db' => 'PMT_REEMPLAZO.FECHA_INICIO_REEMPLAZO_LABEL', 'dt' => 'FECHA_INICIO' ),
		    array( 'db' => 'PMT_REEMPLAZO.FECHA_TERMINO_REEMPLAZO_LABEL', 'dt' => 'FECHA_TERMINO' ),
		    array( 'db' => 'PMT_REEMPLAZO.FECHA_PAGO_LABEL', 'dt' => 'FECHA_PAGO' ),
		    array( 'db' => 'PMT_REEMPLAZO.DISTRIBUCION_HORARIA_LABEL', 'dt' => 'DISTRIBUCION_HORARIO' ),
		    array( 'db' => 'PMT_REEMPLAZO.CARGOS_LABEL', 'dt' => 'CARGO' ),
		    
		    array( 'db' => 'PMT_REEMPLAZO.NOMBRES_REEMPLAZADO_LABEL', 'dt' => 'NOMBRE_FUNCIONARIO' ),
		    array( 'db' => 'PMT_REEMPLAZO.APELLIDOS_REEMPLAZADO_LABEL', 'dt' => 'APELLIDO_FUNCIONARIO' ),
		    array( 'db' => 'PMT_REEMPLAZO.RUT_REEMPLAZADO_LABEL', 'dt' => 'RUT_FUNCIONARIO' ),
		    
		    array( 'db' => 'PMT_REEMPLAZO.APP_STATUS', 'dt' => 'APP_STATUS' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CREATE_DATE', 'dt' => 'APP_CREATE_DATE' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CURRENT_USER', 'dt' => 'USR_FIRSTNAME' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_TAS_TITLE', 'dt' => 'TAS_TITLE' ),
		    array( 'db' => 'APP_CACHE_VIEW.TAS_UID', 'dt' => 'TAS_UID' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_PRO_TITLE', 'dt' => 'PRO_TITLE' ),
	    );
    	$dbProcess = $this->load->database('processMaker', TRUE);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll, $join, $dbProcess);
        return $data;
    }
    
    private function getProrrogasSalud() {
    	$table = 'PMT_PRORROGA';
    	$primaryKey = 'PMT_PRORROGA.APP_UID';
    	$whereResult = null;
    	if($this->ion_auth->in_group(11)){
    		$filtroActivo = false;
    		$codigos = $this->ion_auth->getCodigosIgestion();
    		if(empty($codigos)){
				$whereResult = null;
    		}	else {
    				$whereResult = "(";
	    			foreach($codigos as $key => $value){
	    				$this->table = 'PMT_ESTABLECIMIENTOS_SALUD';
	    				$id_dynaform = $this->get('id_dynaform',array('codigo_centro' => $value['codigo'] ));
	    				if(!empty($id_dynaform)){
	    					$filtroActivo = true;
	    					$whereResult .= "PMT_PRORROGA.CENTROS_DE_COSTO = '".$id_dynaform[0]->id_dynaform."' OR ";
	    				}
		    		}
		    		$filtroActivo ? $whereResult = substr($whereResult, 0, -3). ")" : $whereResult = null;
    			}
    	}

    	$whereAll = "(PMT_PRORROGA.APP_STATUS = 'TO_DO' OR PMT_PRORROGA.APP_STATUS = 'COMPLETED') AND APP_CACHE_VIEW.DEL_LAST_INDEX = 1";
    	$join = 'JOIN APP_CACHE_VIEW ON PMT_PRORROGA.APP_UID = APP_CACHE_VIEW.APP_UID';
		$columns = array(
	   		array( 'db' => 'PMT_PRORROGA.APP_UID', 'dt' => 'APP_UID' ),
	    	array( 'db' => 'PMT_PRORROGA.APP_NUMBER', 'dt' => 'APP_NUMBER' ),
	    	array( 'db' => 'PMT_PRORROGA.NOMBRE_SOLICINTANTE_LABEL', 'dt' => 'NOMBRE_SOLICITANTE' ),
		    array( 'db' => 'PMT_PRORROGA.CENTROS_DE_COSTO_LABEL', 'dt' => 'CENTRO_COSTO' ),
		    
		    array( 'db' => 'PMT_PRORROGA.NOMBRE_REEMPLAZANTE', 'dt' => 'NOMBRE_REEMPLAZANTE' ),
		    array( 'db' => 'PMT_PRORROGA.APELLIDOS_REEMPLAZANTE_LABEL', 'dt' => 'APELLIDO_REEMPLAZANTE' ),
		    array( 'db' => 'PMT_PRORROGA.RUT_REEMPLAZANTE_LABEL', 'dt' => 'RUT_REEMPLAZANTE' ),
		    array( 'db' => 'PMT_PRORROGA.TELEFONO_REEMPLAZANTE_LABEL', 'dt' => 'TELEFONO_REEMPLAZANTE' ),
		    
		    array( 'db' => 'PMT_PRORROGA.MOTIVO_REEMPLAZO_LABEL', 'dt' => 'MOTIVO_REEMPLAZO' ),
		    array( 'db' => 'PMT_PRORROGA.HORAS_REEMPLAZO_LABEL', 'dt' => 'HORAS' ),
		    array( 'db' => 'PMT_PRORROGA.FECHA_INICIO_REEMPLAZO_LABEL', 'dt' => 'FECHA_INICIO' ),
		    array( 'db' => 'PMT_PRORROGA.FECHA_TERMINO_REEMPLAZO_LABEL', 'dt' => 'FECHA_TERMINO' ),
		    array( 'db' => 'PMT_PRORROGA.FECHA_PAGO_LABEL', 'dt' => 'FECHA_PAGO' ),
		    array( 'db' => 'PMT_PRORROGA.DISTRIBUCION_HORARIA_LABEL', 'dt' => 'DISTRIBUCION_HORARIO' ),
		    array( 'db' => 'PMT_PRORROGA.CARGOS_LABEL', 'dt' => 'CARGO' ),
		    
		    array( 'db' => 'PMT_PRORROGA.NOMBRES_REEMPLAZADO_LABEL', 'dt' => 'NOMBRE_FUNCIONARIO' ),
		    array( 'db' => 'PMT_PRORROGA.APELLIDOS_REEMPLAZADO_LABEL', 'dt' => 'APELLIDO_FUNCIONARIO' ),
		    array( 'db' => 'PMT_PRORROGA.RUT_REEMPLAZADO_LABEL', 'dt' => 'RUT_FUNCIONARIO' ),
		    
		    array( 'db' => 'PMT_PRORROGA.APP_STATUS', 'dt' => 'APP_STATUS' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CREATE_DATE', 'dt' => 'APP_CREATE_DATE' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CURRENT_USER', 'dt' => 'USR_FIRSTNAME' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_TAS_TITLE', 'dt' => 'TAS_TITLE' ),
		    array( 'db' => 'APP_CACHE_VIEW.TAS_UID', 'dt' => 'TAS_UID' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_PRO_TITLE', 'dt' => 'PRO_TITLE' ),
	    );
    	$dbProcess = $this->load->database('processMaker', TRUE);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll, $join, $dbProcess);
        return $data;
    }
    
    private function getAmpliacionesSalud() {
    	$table = 'PMT_ASIGNACION_HORARIA';
    	$primaryKey = 'PMT_ASIGNACION_HORARIA.APP_UID';
    	$whereResult = null;
    	if($this->ion_auth->in_group(11)){
    		$filtroActivo = false;
    		$codigos = $this->ion_auth->getCodigosIgestion();
    		if(empty($codigos)){
				$whereResult = null;
    		}	else {
    				$whereResult = "(";
	    			foreach($codigos as $key => $value){
	    				$this->table = 'PMT_ESTABLECIMIENTOS_SALUD';
	    				$id_dynaform = $this->get('id_dynaform',array('codigo_centro' => $value['codigo'] ));
	    				if(!empty($id_dynaform)){
	    					$filtroActivo = true;
	    					$whereResult .= "PMT_ASIGNACION_HORARIA.CENTROS_DE_COSTO = '".$id_dynaform[0]->id_dynaform."' OR ";
	    				}
		    		}
		    		$filtroActivo ? $whereResult = substr($whereResult, 0, -3). ")" : $whereResult = null;
    			}
    	}
    	
    	$whereAll = "(PMT_ASIGNACION_HORARIA.APP_STATUS = 'TO_DO' OR PMT_ASIGNACION_HORARIA.APP_STATUS = 'COMPLETED') AND APP_CACHE_VIEW.DEL_LAST_INDEX = 1";
    	$join = 'JOIN APP_CACHE_VIEW ON PMT_ASIGNACION_HORARIA.APP_UID = APP_CACHE_VIEW.APP_UID';
		$columns = array(
	   		array( 'db' => 'PMT_ASIGNACION_HORARIA.APP_UID', 'dt' => 'APP_UID' ),
	    	array( 'db' => 'PMT_ASIGNACION_HORARIA.APP_NUMBER', 'dt' => 'APP_NUMBER' ),
	    	array( 'db' => 'PMT_ASIGNACION_HORARIA.NOMBRE_SOLICINTANTE', 'dt' => 'NOMBRE_SOLICITANTE' ),
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.CENTROS_DE_COSTO_LABEL', 'dt' => 'CENTRO_COSTO' ),
		    
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.NOMBRE_REEMPLAZANTE_LABEL', 'dt' => 'NOMBRE_REEMPLAZANTE' ),
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.APELLIDOS_REEMPLAZANTE_LABEL', 'dt' => 'APELLIDO_REEMPLAZANTE' ),
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.RUT_REEMPLAZANTE_LABEL', 'dt' => 'RUT_REEMPLAZANTE' ),
		    //array( 'db' => 'PMT_ASIGNACION_HORARIA.TELEFONO_REEMPLAZANTE_LABEL', 'dt' => 'TELEFONO_REEMPLAZANTE' ),
		    
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.MOTIVO_REEMPLAZO_LABEL', 'dt' => 'MOTIVO_REEMPLAZO' ),
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.HORAS_DOTACION_REEMPLAZANTE', 'dt' => 'HORAS' ),
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.FECHA_INICIO_REEMPLAZO_LABEL', 'dt' => 'FECHA_INICIO' ),
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.FECHA_TERMINO_REEMPLAZO_LABEL', 'dt' => 'FECHA_TERMINO' ),
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.FECHA_PAGO_LABEL', 'dt' => 'FECHA_PAGO' ),
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.DISTRIBUCION_HORARIA_LABEL', 'dt' => 'DISTRIBUCION_HORARIO' ),
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.CARGOS_LABEL', 'dt' => 'CARGO' ),
		    
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.NOMBRES_REEMPLAZADO_LABEL', 'dt' => 'NOMBRE_FUNCIONARIO' ),
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.APELLIDOS_REEMPLAZADO_LABEL', 'dt' => 'APELLIDO_FUNCIONARIO' ),
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.RUT_REEMPLAZADO_LABEL', 'dt' => 'RUT_FUNCIONARIO' ),
		    
		    array( 'db' => 'PMT_ASIGNACION_HORARIA.APP_STATUS', 'dt' => 'APP_STATUS' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CREATE_DATE', 'dt' => 'APP_CREATE_DATE' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CURRENT_USER', 'dt' => 'USR_FIRSTNAME' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_TAS_TITLE', 'dt' => 'TAS_TITLE' ),
		    array( 'db' => 'APP_CACHE_VIEW.TAS_UID', 'dt' => 'TAS_UID' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_PRO_TITLE', 'dt' => 'PRO_TITLE' )
	    );
	    $dbProcess = $this->load->database('processMaker', TRUE);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll, $join, $dbProcess);
        return $data;
    }
    
    public function getAllPersonalSalud(){
        $reemplazos = $this->getReemplazosSalud();
        
        $prorrogas = $this->getProrrogasSalud();
        
        $ampliaciones = $this->getAmpliacionesSalud();
        
        $data = array(
			"draw"            => $reemplazos['draw'],
			"recordsTotal"    => $reemplazos['recordsTotal'] + $prorrogas['recordsTotal'] + $ampliaciones['recordsTotal'],
			//"recordsTotal"    => $reemplazos['recordsTotal'] + $prorrogas['recordsTotal'],
			"recordsFiltered" => $reemplazos['recordsFiltered'],
			"data"            => array_merge(array_merge($reemplazos['data'], $prorrogas['data']), $ampliaciones['data'])
			//"data"            => array_merge($reemplazos['data'], $prorrogas['data'])
		);
		
		return $data;
        
        //return $reemplazos;
    }
    
    public function getIndicadoresS(){
    	$casosProcessGrilla = $this->getAllPersonalSalud();

    	$casosProcess = $this->unique_multidim_array($casosProcessGrilla['data'], 'APP_NUMBER');
    	
    	$casosCompletados = 0;
    	$casosEnCurso = 0;
    	$casosBorrador = 0;
    	$reemplazosActivos = array();
    	$vencen7Dias = array();
    	
    	$resumenR = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    	$resumenP = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
    	$resumenA = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    	
    	$dataTable = array();
    	
    	//uid tareas de reemplazo
    	$taskRUID_ADC = '7631937645b59cb0d0c1601027903125';
    	$taskRUID_VAS = '3605425725b2a7fd9614fd4030192812';
    	$taskRUID_ASR = '6113415465b2a7fd9693c44093420726';
    	$taskRUID_RSR = '5760929955b2a8001b430b3099353314';
    	$taskRUID_ADS = '1701901865b2a8001bb91e6024044276';
    	$taskRUID_CC = '4088604675b2ba9f5e4c260010528614';
    	$taskRUID_FC = '2336713465b2baa1e043da8075427523';
    	$taskRUID_CR = '9784456605b85782e066712051269385';
    	$taskRUID_RC = '4887124225b85737cb41e80006522320';
    	$taskRUID_NR = '3162460735b2a819477f794012390209';
    	//uid tareas de prorrogas
    	$taskPUID_ADC = '6131091665b8ea0bd53eda7091414236';
    	$taskPUID_VAS = '4751228695b8ea0bd66dde6083366559';
    	$taskPUID_ASR = '9118742845b8ea0bd59ffe3076555409';
    	$taskPUID_RSP = '9702009305b8ea0bd31b340082264462';
    	$taskPUID_ADS = '8341225455b8ea0bd40e550020539980';
    	$taskPUID_CC = '9017416655b8ea0bd24a941029830524';
    	$taskPUID_CR = '6751618685b8ea0bd4707e4061368867';
    	$taskPUID_RC = '7959994795b8ea0bd60cfc0038035408';
    	$taskPUID_NR = '6543912355b8ea0bd4d0c27051518096';
    	//uid tareas de ampliaciones
    	$taskAUID_ADC = '5280484605be563bd3eab17020036903';
    	$taskAUID_VAS = '1081048945be563bd4915c7017193809';
    	$taskAUID_ASAH = '2779896145be563bd08b7b9047458470';
    	$taskAUID_RSAH = '6800729065be563bd6d2370068327878';
    	$taskAUID_ADS = '2138684945be563bd52c717010637187';
    	$taskAUID_CC = '8221358045be563bd130695061417473';
    	$taskAUID_FC = '3752337135be563bd24ef06035968770';
    	$taskAUID_CR = '9925224495be563bd364519018829956';
    	$taskAUID_RC = '7827888415be563bd1c5a57010997441';
    	$taskAUID_NR = '1553598165be563bd2d83e9030885402';
    	
    	foreach($casosProcess as $key => $value){
    		switch($value['APP_STATUS']){
    			case 'COMPLETED': 
    				$casosCompletados += 1; 
    				break;
    				
    			case 'TO_DO': 
    				$casosEnCurso += 1;
    				switch($value['PRO_TITLE'][0]){
		    			case '1':
		    				switch($value['TAS_UID']){
		    					case $taskRUID_ADC : $resumenR[0] += 1; break;
				        		case $taskRUID_VAS : $resumenR[1] += 1; break;
				        		case $taskRUID_ASR : $resumenR[2] += 1; break;
				        		case $taskRUID_RSR : $resumenR[3] += 1; break;
				        		case $taskRUID_ADS : $resumenR[4] += 1; break;
				        		case $taskRUID_CC : $resumenR[5] += 1; break;
				        		case $taskRUID_FC : $resumenR[6] += 1; break;
				        		case $taskRUID_CR : $resumenR[7] += 1; break;
				        		case $taskRUID_RC : $resumenR[8] += 1; break;
				        		case $taskRUID_NR : $resumenR[9] += 1; break;
		    				}
		    				break;
		    			case '2':
		    				switch($value['TAS_UID']){
		    					case $taskPUID_ADC : $resumenP[0] += 1; break;
				        		case $taskPUID_VAS : $resumenP[1] += 1; break;
				        		case $taskPUID_ASR : $resumenP[2] += 1; break;
				        		case $taskPUID_RSP : $resumenP[3] += 1; break;
				        		case $taskPUID_ADS : $resumenP[4] += 1; break;
				        		case $taskPUID_CC : $resumenP[5] += 1; break;
				        		case $taskPUID_CR : $resumenP[6] += 1; break;
				        		case $taskPUID_RC : $resumenP[7] += 1; break;
				        		case $taskPUID_NR : $resumenP[8] += 1; break;
		    				}
		    				break;
		    			case '3':
		    				switch($value['TAS_UID']){
		    					case $taskAUID_ADC : $resumenA[0] += 1; break;
				        		case $taskAUID_VAS : $resumenA[1] += 1; break;
				        		case $taskAUID_ASAH : $resumenA[2] += 1; break;
				        		case $taskAUID_RSAH : $resumenA[3] += 1; break;
				        		case $taskAUID_ADS : $resumenA[4] += 1; break;
				        		case $taskAUID_CC : $resumenA[5] += 1; break;
				        		case $taskAUID_FC : $resumenA[6] += 1; break;
				        		case $taskAUID_CR : $resumenA[7] += 1; break;
				        		case $taskAUID_RC : $resumenA[8] += 1; break;
				        		case $taskAUID_NR : $resumenA[9] += 1; break;
		    				}
		    				break;
		    		}
    				break;
    		}
    	}
    	
    	$dataTable = json_encode($casosProcessGrilla['data']);
    	
    	foreach($casosProcessGrilla['data'] as $value){
    		
    		if($value['TAS_UID'] != '3162460735b2a819477f794012390209' && $value['TAS_UID'] != '6543912355b8ea0bd4d0c27051518096' && $value['TAS_UID'] != '1553598165be563bd2d83e9030885402'){
	    		if($value['FECHA_TERMINO'] >= date('Y-m-d')){
	    			$reemplazosActivos[] = $value;
	    			if($value['FECHA_TERMINO'] <= date('Y-m-d', strtotime(date('Y-m-d'). ' + 7 days'))){
		    			$vencen7Dias[] = $value;
		    		}
	    		}
    		}
    	}
    	
    	$whereResult = $this->getFiltroCentros('PMT_REEMPLAZO.CENTROS_DE_COSTO', 1);
    	$this->db->select('PMT_REEMPLAZO.APP_NUMBER');
    	$this->db->from('PMT_REEMPLAZO');
    	$this->db->where('PMT_REEMPLAZO.APP_STATUS','DRAFT');
    	if(!empty($whereResult)) $this->db->where($whereResult);
    	
    	$casosBorrador = $this->db->count_all_results();
    	
    	$whereResult = $this->getFiltroCentros('PMT_PRORROGA.CENTROS_DE_COSTO', 1);
    	$this->db->select('PMT_PRORROGA.APP_NUMBER');
    	$this->db->from('PMT_PRORROGA');
    	$this->db->where('PMT_PRORROGA.APP_STATUS','DRAFT');
    	if(!empty($whereResult)) $this->db->where($whereResult);
    	
    	$casosBorrador += $this->db->count_all_results();
    	
    	$whereResult = $this->getFiltroCentros('PMT_ASIGNACION_HORARIA.CENTROS_DE_COSTO', 1);
    	$this->db->select('PMT_ASIGNACION_HORARIA.APP_NUMBER');
    	$this->db->from('PMT_ASIGNACION_HORARIA');
    	$this->db->where('PMT_ASIGNACION_HORARIA.APP_STATUS','DRAFT');
    	if(!empty($whereResult)) $this->db->where($whereResult);
    	
    	$casosBorrador += $this->db->count_all_results();
    	
    	return array($casosCompletados, $casosEnCurso, $casosBorrador, $reemplazosActivos, $vencen7Dias, $resumenR, $resumenP, $resumenA, $dataTable);
    	
    }
    
    //---------------SALUD PEROSNAL---------------------
    
    //++++++++++++++++SALUD COMPRAS++++++++++++++++++++
    
    public function getComprasSalud() {
    	$table = 'PMT_REPORTE_COMPRAS_SALUD';
    	$primaryKey = 'PMT_REPORTE_COMPRAS_SALUD.APP_UID';
    	$whereResult = null;
    	$whereAll = "(PMT_REPORTE_COMPRAS_SALUD.APP_STATUS = 'TO_DO' OR PMT_REPORTE_COMPRAS_SALUD.APP_STATUS = 'COMPLETED') AND APP_CACHE_VIEW.DEL_LAST_INDEX = 1";
    	$join = 'JOIN APP_CACHE_VIEW ON PMT_REPORTE_COMPRAS_SALUD.APP_UID = APP_CACHE_VIEW.APP_UID'; // JOIN TASK ON PROCESS.PRO_UID = 
		$columns = array(
	   		array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.APP_UID', 'dt' => 'APP_UID' ),
	    	array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.APP_NUMBER', 'dt' => 'APP_NUMBER' ),
		    array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.CENTRO', 'dt' => 'CENTRO' ),
		    array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.FONDOF_LABEL', 'dt' => 'FONDOF_LABEL' ),
		    array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.FONDORENDIRMONTO', 'dt' => 'MONTO' ),
		    array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.BENEFICIARIO', 'dt' => 'BENEFICIARIO' ),
		    array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.DESPACHO_LABEL', 'dt' => 'DESPACHO' ),
		    array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.CONVENIO_LABEL', 'dt' => 'CONVENIO_LABEL' ),
		    array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.FONDORENDIR_LABEL', 'dt' => 'FONDORENDIR_LABEL' ),
		    array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.FONDORENDIRMONTO', 'dt' => 'FONDORENDIRMONTO' ),
		    array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.BENEFICIARIO', 'dt' => 'BENEFICIARIO' ),
		    array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.DESPACHO_LABEL', 'dt' => 'DESPACHO_LABEL' ),
		    array( 'db' => 'PMT_REPORTE_COMPRAS_SALUD.APP_STATUS', 'dt' => 'APP_STATUS' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CREATE_DATE', 'dt' => 'APP_CREATE_DATE' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CURRENT_USER', 'dt' => 'USR_FIRSTNAME' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_CURRENT_USER', 'dt' => 'USR_LASTNAME' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_TAS_TITLE', 'dt' => 'TAS_TITLE' ),
		    array( 'db' => 'APP_CACHE_VIEW.TAS_UID', 'dt' => 'TAS_UID' ),
		    array( 'db' => 'APP_CACHE_VIEW.APP_PRO_TITLE', 'dt' => 'PRO_TITLE' ),
	    );
	    $dbProcess = $this->load->database('processMaker', TRUE);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll, $join, $dbProcess);
        return $data;
    }
    
    public function getDetalleComprasSalud($caseNumber){
    	$this->db->select('*');
    	$this->db->from('PMT_REPORTE_COMPRAS_SALUD_GRID');
    	$this->db->where('PMT_REPORTE_COMPRAS_SALUD_GRID.APP_NUMBER',$caseNumber);

		$query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->result_array();
        }
        
        return $data;
    }
    
    public function getIndicadoresCS(){
    	$data = $this->getComprasSalud();
    	
    	$taskUID_ADC = '8949772555d5ebf65abe886093311143';	//	1.1)Autorización director CESFAM
    	$taskUID_ER = '1288992715d27913b5e4f85015976248';	//	2) Evaluar Requerimiento
    	$taskUID_EDAS = '3224204355d27934374cae7057124778';	//	3) Evaluación director Area Salud
    	$taskUID_CDP = '5694115885d2793bb77e993062052624';	//	4) Compra del Requerimiento (Solicitud CDP)
    	$taskUID_OC = '1039848775d27940b7b9f58029659116';	//	5) Compra del Requerimiento (Generación OC)
    	$taskUID_REE = '9871324115d27943379d0a1095393565';	//	6) Recepción y envío de evidencia
    	$taskUID_VE = '2585970835d2794ab883af6025745377';	//	7) Validación de Evidencia
    	$taskUID_NR = '2782793495d2792cb725148022663800';	//	Notificacíon de Rechazo
    	
    	$resumen = array(0, 0, 0, 0, 0, 0, 0, 0);
    	$completados = 0;
    	$enCurso = 0;
    	
    	foreach($data['data'] as $key => $value){
    		if($value['APP_STATUS'] == 'TO_DO'){
    			$enCurso += 1;
    			switch($value['TAS_UID']){
					case $taskUID_ADC : $resumen[0] += 1; break;
				    case $taskUID_ER : $resumen[1] += 1; break;
					case $taskUID_EDAS : $resumen[2] += 1; break;
					case $taskUID_CDP : $resumen[3] += 1; break;
					case $taskUID_OC : $resumen[4] += 1; break;
					case $taskUID_REE : $resumen[5] += 1; break;
					case $taskUID_VE : $resumen[6] += 1; break;
					case $taskUID_NR : $resumen[7] += 1; break;
		    	}
    		}	else $completados += 1;
    	}
    	
    	return array($completados,$enCurso,$resumen,json_encode($data['data']));
    	
    }
    
    //---------------SALUD COMPRAS---------------------
    
    //---------------Consultoria COMPRAS---------------------
    
	public function resumenCaso($ncaso){
		
		$this->db->select('APP_TAS_TITLE, APP_CURRENT_USER, APP_CREATE_DATE, APP_PRO_TITLE, DEL_DELEGATE_DATE, APP_NUMBER');
    	$this->db->from('APP_CACHE_VIEW');
    	$this->db->where('APP_CACHE_VIEW.APP_NUMBER',$ncaso);
    	$this->db->where('APP_CACHE_VIEW.DEL_LAST_INDEX',1);
    	//$this->db->join('USERS','APP_CACHE_VIEW.USR_UID = USERS.USR_UID');
    	//$this->db->join('TASK','APP_CACHE_VIEW.TAS_UID = TASK.TAS_UID');
    	$query = $this->db->get();
    	
    	if ($query->num_rows()>0) {
            $data = $query->result_array();
        } 
        
        return $data;
    	
	}
    //---------------Consultoria COMPRAS---------------------
    
	//+++++++++++++ Auth ION / FILTROS DE GRUPO +++++++++++++++++++++++++++
	
	private function getFiltroCentros($columnCentro,$tipoFiltroCentro){
    	
    	$whereResult = null;
    	if($this->ion_auth->in_group(5)) $whereResult = $columnCentro." = '" . $this->session->userdata['position'] . "'";
    	if($this->ion_auth->in_group(array('bpfiltroscentros'))){
    		$filtroActivo = false;
    		$codigos = $this->ion_auth->getCodigosIgestion();
    		if(empty($codigos)){
				$whereResult = null;
    		}	else {
    				$whereResult = "(";
	    			foreach($codigos as $key => $value){
	    				switch($tipoFiltroCentro){
	    					case 1: 
	    						$this->table = 'PMT_ESTABLECIMIENTOS_EDUCACION';
	    						$id_dynaform = $this->get('id',array('codigo' => substr($value['codigo'],0,1).'.'.substr($value['codigo'],1) ));
	    						break;
	    					case 2:
	    						$this->table = 'PMT_ESTABLECIMIENTOS_SALUD';
	    						$id_dynaform = $this->get('id_dynaform',array('codigo_centro' => $value['codigo'] ));
	    						break;
	    				}
	    				if(!empty($id_dynaform)){
	    					$filtroActivo = true;
	    					$whereResult .= $columnCentro ." = '".$id_dynaform[0]->id."' OR ";
	    				}
		    		}
		    		return $filtroActivo ? $whereResult = substr($whereResult, 0, -3). ")" : $whereResult = null;
    			}
    	}
    }
    
    public function setEstablecimiento(){
        $this->load->database('processMaker', FALSE, TRUE);
        
        $this->table = 'USERS';
        $username = $this->session->userdata('username');
        $idEstablecimiento = $this->get('USR_POSITION', array('USR_USERNAME' => $username),array(),array(),'')[0]->USR_POSITION;
        $this->session->set_userdata('position', $idEstablecimiento);
        
        $this->table = 'PMT_ESTABLECIMIENTOS_EDUCACION';
        $position = $this->session->userdata('position');
        $nombreEstablecimiento = $this->get('NOMBRE_ESTABLECIMIENTO', array('ID' => $position),array(),array(),'')[0]->NOMBRE_ESTABLECIMIENTO;
        $this->session->set_userdata('nombreEstablecimiento', $nombreEstablecimiento);
        
        $this->db->close();
        return 0;
    }
    
    //------------- Auth ION / FILTROS DE GRUPO ---------------------------
    
    
    //+++++++++++++ lICENCIAS MEDICAS ++++++++++++++++++++++++++
    
    private function normalizeDataLM($data, $tipo){
	    	switch($tipo){
	    		case 0:	
	    				$this->table = 'PMT_ESTABLECIMIENTOS_EDUCACION';
	    				$establecimiento = $this->get('codigo', array('id' =>  $data['ESTABLECIMIENTO_SOLICITANTE']));
	    				if(!empty($establecimiento)){
		    				$codigo = $establecimiento[0]->codigo;
		    				
		    				return array('nombre' => $data['NOMBRES_REEMPLAZADO_LABEL'],
		    							'apellido_paterno' => $data['APELLIDOS_REEMPLAZADO_LABEL'],
		    							'apellido_materno' => $data['APELLIDOS2_REEMPLAZADO_LABEL'],
		    							'cargo' => $data['CARGO_LABEL'],
		    							'centro' => str_replace ( '.', '' , $codigo),
		    							'app_number' =>$data['APP_NUMBER']
		    							);
	    				}
	    				return null;
	    				break;
	    		case 1: 
	    				$this->table = 'PMT_ESTABLECIMIENTOS_SALUD';
	    				$establecimiento = $this->get('codigo_centro', array('id_dynaform' =>  $data['CENTROS_DE_COSTO']));
	    				if(!empty($establecimiento)){
		    				$codigo = $establecimiento[0]->codigo_centro;
		    				return array('nombre' => $data['NOMBRES_REEMPLAZADO_LABEL'],
		    							'apellido_paterno' => $data['APELLIDOS_REEMPLAZADO_LABEL'],
		    							'apellido_materno' => '',
		    							'cargo' => $data['CARGOS_LABEL'],
		    							'centro' => $codigo,
		    							'app_number' =>$data['APP_NUMBER']
		    							);
	    				}
	    				return null;
	    				break;
	    		case 2: 
	    				$this->table = 'PMT_ESTABLECIMIENTOS_EDUCACION';
	    				$establecimiento = $this->get('codigo', array('id' =>  $data['ESTABLECIMIENTO_SOLICITANTE']));
	    				if(!empty($establecimiento)){
	    				$codigo = $establecimiento->codigo;
	    				return array('nombre' => $data['NOMBRES_REEMPLAZADO_LABEL'],
	    							'apellido_paterno' => $data['APELLIDOS_REEMPLAZADO_LABEL'],
	    							'apellido_materno' => $data['APELLIDOS2_REEMPLAZADO_LABEL'],
	    							'cargo' => $data['CARGO_LABEL'],
	    							'centro' => str_replace ( '.', '' , $codigo),
	    							'app_number' =>$data['APP_NUMBER']
	    							);
	    				}
	    				return null;
	    				break;
	    		case 3: 
	    				$this->table = 'PMT_ESTABLECIMIENTOS_SALUD';
	    				$establecimiento = $this->get('codigo_centro', array('id_dynaform' =>  $data['CENTROS_DE_COSTO']));
	    				if(!empty($establecimiento)){
		    				$codigo = $establecimiento[0]->codigo_centro;
		    				return array('nombre' => $data['NOMBRES_REEMPLAZADO_LABEL'],
		    							'apellido_paterno' => $data['APELLIDOS_REEMPLAZADO_LABEL'],
		    							'apellido_materno' => '',
		    							'cargo' => $data['CARGOS_LABEL'],
		    							'centro' => $codigo,
		    							'app_number' =>$data['APP_NUMBER']
		    							);
	    				}
	    				return null;
	    				break;
	    	}
    }
    
    public function getPersonaLM($rut = null, $digito = null){
    	$newstr = substr_replace($rut, '.', -3, 0);
		$rutConPuntos = substr_replace($newstr, '.', -7, 0);
		
    	$dbProcess = $this->load->database('processMaker', TRUE);
    	
    	$dbProcess->from('PMT_REEMPLAZO_EDUCACION');								// Reemplazos Educacion
        $dbProcess->where('RUT_REEMPLAZADO_LABEL',$rutConPuntos.'-'.$digito);
        $dbProcess->order_by("APP_NUMBER", "desc");
        $data[] = $dbProcess->get()->row_array();
        
        $dbProcess->from('PMT_REEMPLAZO');											// Reemplazo Salud
        $dbProcess->where('RUT_REEMPLAZADO_LABEL',$rutConPuntos.'-'.$digito);
        $dbProcess->order_by("APP_NUMBER", "desc");
        $data[] = $dbProcess->get()->row_array();
        
        $dbProcess->from('PMT_PRORROGAS_EDUCACION');								//Prorrogas Educacion
        $dbProcess->where('RUT_REEMPLAZADO_LABEL',$rutConPuntos.'-'.$digito);
        $dbProcess->order_by("APP_NUMBER", "desc");
        $data[] = $dbProcess->get()->row_array();
        
        $dbProcess->from('PMT_PRORROGA');											//Prorrogas Salud
        $dbProcess->where('RUT_REEMPLAZADO_LABEL',$rutConPuntos.'-'.$digito);
        $dbProcess->order_by("APP_NUMBER", "desc");
        $data[] = $dbProcess->get()->row_array();
        
        $valorApp = 0;
        $valorKey = 0;
        
        foreach($data as $key => $value){
        	if(!empty($value)){
        		if($valorApp < $value['APP_NUMBER']){
        			$valorApp = $value['APP_NUMBER'];
        			$valorKey = $key;
        		}
        	}
        }
        if($valorApp == 0) return null;
        	else return $this->normalizeDataLM($data[$valorKey], $valorKey );
    }
    
    public function getEstablecimiento(){
    	
    	$this->table = 'PMT_ESTABLECIMIENTOS_EDUCACION';
    	$educacion = $this->get('codigo, nombre_establecimiento');
    	
    	$this->table = 'PMT_ESTABLECIMIENTOS_SALUD';
    	$salud = $this->get('CODIGO_CENTRO, NOMBRE');
    	
    	foreach($educacion as $key => $value){
			$codigoFiltrado = str_replace ( '.', '' , $value->codigo);
    		$data[] = array('codigo' => $codigoFiltrado, 'nombre' => $codigoFiltrado.' - '.$value->nombre_establecimiento);
    	}
    	
    	foreach($salud as $key => $value){
    		$data[] = array('codigo' => $value->CODIGO_CENTRO, 'nombre' => $value->CODIGO_CENTRO.' - '.$value->NOMBRE);
    	}
		
		$data[] = array('codigo' => 'Z500', 'nombre' => 'Z500 - Dirección de aseo');
		$data[] = array('codigo' => 'Z510', 'nombre' => 'Z510 - Dirección de aseo (Cheques)');
		$data[] = array('codigo' => 'Y810', 'nombre' => 'Y810 - Cementerio');
		$data[] = array('codigo' => 'Z001', 'nombre' => 'Z001 - Administración Central');
		$data[] = array('codigo' => 'Q022', 'nombre' => 'Q022 - Liceo ED. Barra (PRORRETENCION)');
		$data[] = array('codigo' => 'P008', 'nombre' => 'P008 - S.E.P. 10% Sostenedor');
		$data[] = array('codigo' => 'P015', 'nombre' => 'P015 - INST.Maritimo VALPSO (A15)');
		$data[] = array('codigo' => 'P018', 'nombre' => 'P018 - INST.COMERC.FCO.ARAYA B');
		$data[] = array('codigo' => 'P019', 'nombre' => 'P019 - Herman Olguin (A019)');
		$data[] = array('codigo' => 'P022', 'nombre' => 'P022 - Liceo ED. de la Barra (A22)');
		$data[] = array('codigo' => 'P023', 'nombre' => 'P023 - POLIT.COMP.A. NAZAR (A23)');
		$data[] = array('codigo' => 'P024', 'nombre' => 'P024 - Liceo TEC. Femenino VALP.');
		$data[] = array('codigo' => 'P025', 'nombre' => 'P025 - Liceo M. Brandau de Ross (A25)');
		$data[] = array('codigo' => 'P026', 'nombre' => 'P026 - Liceo M. Luisa Bombal (B26)');
		$data[] = array('codigo' => 'P029', 'nombre' => 'P028 - Liceo Barón SEP');
		$data[] = array('codigo' => 'P029', 'nombre' => 'P029 - Liceo Valparaiso (A24)');
		$data[] = array('codigo' => 'P030', 'nombre' => 'P030 - Liceo María Franck de M.(B30)');
		$data[] = array('codigo' => 'P100', 'nombre' => 'P100 - Liceo Pedro Montt (C100)');
		$data[] = array('codigo' => 'P245', 'nombre' => 'P245 - Naciones Unidas (D245)');
		$data[] = array('codigo' => 'P246', 'nombre' => 'P246 - Arabe Siria (D246)');
		$data[] = array('codigo' => 'P249', 'nombre' => 'P249 - Republica del Paraguay (D249)');
		$data[] = array('codigo' => 'P250', 'nombre' => 'P250 - Corneta G. Cabrales (D250)');
		$data[] = array('codigo' => 'P251', 'nombre' => 'P251 - Grecia (D251)');
		$data[] = array('codigo' => 'P252', 'nombre' => 'P252 - Jorge Alessandri (E252)');
		$data[] = array('codigo' => 'P254', 'nombre' => 'P254 - Juan de Saavedra (D254)');
		$data[] = array('codigo' => 'P255', 'nombre' => 'P255 - Alemania (D255)');
		$data[] = array('codigo' => 'P256', 'nombre' => 'P256 - Republica del Uruguay (D256)');
		$data[] = array('codigo' => 'P262', 'nombre' => 'P262 - America (D262)');
		$data[] = array('codigo' => 'P264', 'nombre' => 'P264 - Eleuterio Ramirez (F264)');
		$data[] = array('codigo' => 'P266', 'nombre' => 'P266 - CARAB. Pedro Cariaga (E266)');
		$data[] = array('codigo' => 'P267', 'nombre' => 'P267 - Diego Portales P. (E267)');
		$data[] = array('codigo' => 'P268', 'nombre' => 'P268 - Republica Mexico. (E268)');
		$data[] = array('codigo' => 'P269', 'nombre' => 'P269 - Centro EDUC. Florida (E269)');
		$data[] = array('codigo' => 'P270', 'nombre' => 'P270 - Ramon Barros Luco (D270)');
		$data[] = array('codigo' => 'P271', 'nombre' => 'P271 - Pacifico (E271)');
		$data[] = array('codigo' => 'P272', 'nombre' => 'P272 - Juan Jose Latorre B. (D272)');
		$data[] = array('codigo' => 'P275', 'nombre' => 'P275 - Ciudad de Berlin (E275)');
		$data[] = array('codigo' => 'P286', 'nombre' => 'P286 - Montedonico (E286)');
		$data[] = array('codigo' => 'P289', 'nombre' => 'P289 - N.150 Laguna Verde (G289)');
		$data[] = array('codigo' => 'P294', 'nombre' => 'P294 - David Ben Gurion (F294)');
		$data[] = array('codigo' => 'P297', 'nombre' => 'P297 - Republica de Argentina (F297)');
		$data[] = array('codigo' => 'P298', 'nombre' => 'P298 - Escuela España (E298)');
		$data[] = array('codigo' => 'P299', 'nombre' => 'P299 - Piloto 1er Luis Parado (F299)');
		$data[] = array('codigo' => 'P301', 'nombre' => 'P301 - Cirujano Pedro Videla (F301)');
		$data[] = array('codigo' => 'P304', 'nombre' => 'P304 - TTE. Julio Allende O. (G304)');
		$data[] = array('codigo' => 'P305', 'nombre' => 'P305 - San Judas Tadeo (F305)');
		$data[] = array('codigo' => 'P307', 'nombre' => 'P307 - Blas Cuevas (D307)');
		$data[] = array('codigo' => 'P309', 'nombre' => 'P309 - Republica del Salvador (D309)');
		$data[] = array('codigo' => 'P310', 'nombre' => 'P310 - Colegio Pablo Neruda (E310)');
		$data[] = array('codigo' => 'P311', 'nombre' => 'P311 - Dr. Ernesto Quiros W. (F311)');
		$data[] = array('codigo' => 'P312', 'nombre' => 'P312 - Estado de Israel (E312)');
		$data[] = array('codigo' => 'P314', 'nombre' => 'P314 - Joaquin Edward Bello (D314)');
		
		$data[] = array('codigo' => 'J008', 'nombre' => 'J008 - Equipo Tecnico PIE');
		$data[] = array('codigo' => 'J015', 'nombre' => 'J015 - INST.Maritimo VALPSO (A15)');
		$data[] = array('codigo' => 'J018', 'nombre' => 'J018 - INST.COMERC.FCO.ARAYA B');
		$data[] = array('codigo' => 'J019', 'nombre' => 'J019 - Herman Olguin (A019)');
		$data[] = array('codigo' => 'J022', 'nombre' => 'J022 - Liceo ED. de la Barra (A22)');
		$data[] = array('codigo' => 'J023', 'nombre' => 'J023 - POLIT.COMP.A. NAZAR (A23)');
		$data[] = array('codigo' => 'J024', 'nombre' => 'J024 - Liceo TEC. Femenino VALP.');
		$data[] = array('codigo' => 'J025', 'nombre' => 'J025 - Liceo M. Brandau de Ross (A25)');
		$data[] = array('codigo' => 'J026', 'nombre' => 'J026 - Liceo M. Luisa Bombal (B26)');
		$data[] = array('codigo' => 'J028', 'nombre' => 'J028 - Liceo Baron (B28)');
		$data[] = array('codigo' => 'J029', 'nombre' => 'J029 - Liceo Valparaiso (A24)');
		$data[] = array('codigo' => 'J030', 'nombre' => 'J030 - Liceo María Franck de M.(B30)');
		$data[] = array('codigo' => 'J100', 'nombre' => 'J100 - Liceo Pedro Montt (C100)');
		$data[] = array('codigo' => 'J245', 'nombre' => 'J245 - Naciones Unidas (D245)');
		$data[] = array('codigo' => 'J246', 'nombre' => 'J246 - Arabe Siria (D246)');
		$data[] = array('codigo' => 'J249', 'nombre' => 'J249 - Republica del Paraguay (D249)');
		$data[] = array('codigo' => 'J250', 'nombre' => 'J250 - Corneta G. Cabrales (D250)');
		$data[] = array('codigo' => 'J251', 'nombre' => 'J251 - Grecia (D251)');
		$data[] = array('codigo' => 'J252', 'nombre' => 'J252 - Jorge Alessandri (E252)');
		$data[] = array('codigo' => 'J254', 'nombre' => 'J254 - Juan de Saavedra (D254)');
		$data[] = array('codigo' => 'J255', 'nombre' => 'J255 - Alemania (D255)');
		$data[] = array('codigo' => 'J256', 'nombre' => 'J256 - Republica del Uruguay (D256)');
		$data[] = array('codigo' => 'J262', 'nombre' => 'J262 - America (D262)');
		$data[] = array('codigo' => 'J264', 'nombre' => 'J264 - Eleuterio Ramirez (F264)');
		$data[] = array('codigo' => 'J266', 'nombre' => 'J266 - CARAB. Pedro Cariaga (E266)');
		$data[] = array('codigo' => 'J267', 'nombre' => 'J267 - Diego Portales P. (E267)');
		$data[] = array('codigo' => 'J268', 'nombre' => 'J268 - Republica Mexico. (E268)');
		$data[] = array('codigo' => 'J269', 'nombre' => 'J269 - Centro EDUC. Florida (E269)');
		$data[] = array('codigo' => 'J271', 'nombre' => 'J271 - Pacifico (E271)');
		$data[] = array('codigo' => 'J272', 'nombre' => 'J272 - Juan Jose Latorre B. (D272)');
		$data[] = array('codigo' => 'J275', 'nombre' => 'J275 - Ciudad de Berlin (E275)');
		$data[] = array('codigo' => 'J280', 'nombre' => 'J280 - Juan Wacquez (F280)');
		$data[] = array('codigo' => 'J286', 'nombre' => 'J286 - Montedonico (E286)');
		$data[] = array('codigo' => 'J289', 'nombre' => 'J286 - N.150 Laguna Verde (G289)');
		$data[] = array('codigo' => 'J294', 'nombre' => 'J294 - David Ben Gurion (F294)');
		$data[] = array('codigo' => 'J297', 'nombre' => 'J297 - Republica de Argentina (F297)');
		$data[] = array('codigo' => 'J298', 'nombre' => 'J298 - Escuela España (E298)');
		$data[] = array('codigo' => 'J299', 'nombre' => 'J299 - Piloto 1er Luis Parado (F299)');
		$data[] = array('codigo' => 'J301', 'nombre' => 'J301 - Cirujano Pedro Videla (F301)');
		$data[] = array('codigo' => 'J304', 'nombre' => 'J304 - TTE. Julio Allende O. (G304)');
		$data[] = array('codigo' => 'J305', 'nombre' => 'J305 - San Judas Tadeo (F305)');
		$data[] = array('codigo' => 'J307', 'nombre' => 'J307 - Blas Cuevas (D307)');
		$data[] = array('codigo' => 'J309', 'nombre' => 'J309 - Republica del Salvador (D309)');
		$data[] = array('codigo' => 'J310', 'nombre' => 'J310 - Colegio Pablo Neruda (E310)');
		$data[] = array('codigo' => 'J311', 'nombre' => 'J311 - Dr. Ernesto Quiros W. (F311)');
		$data[] = array('codigo' => 'J312', 'nombre' => 'J312 - Estado de Israel (E312)');
		$data[] = array('codigo' => 'J314', 'nombre' => 'J314 - Joaquin Edward Bello (D314)');
		$data[] = array('codigo' => 'J330', 'nombre' => 'J330 - CEIA');
		$data[] = array('codigo' => 'J507', 'nombre' => 'J507 - Reino de Suecia (F507)');
		$data[] = array('codigo' => 'J508', 'nombre' => 'J508 - Escuela Carcel');
		$data[] = array('codigo' => 'S900', 'nombre' => 'S900 - Taller Aguayo');
		$data[] = array('codigo' => 'Z003', 'nombre' => 'Z003 - Optica Popular');
		$data[] = array('codigo' => 'L381', 'nombre' => 'L381 - HABILIDADES PARA LA VIDA');
		$data[] = array('codigo' => 'W400', 'nombre' => 'W400 - Dirección De educación');
		$data[] = array('codigo' => 'W410', 'nombre' => 'W410 - FAEP (fondo de apoyo)');
		$data[] = array('codigo' => 'W420', 'nombre' => 'W420 - Programas (W420)');
		
		$data[] = array('codigo' => 'W421', 'nombre' => 'W421 - ORGANISM.TECNICO EJECUT.');
		$data[] = array('codigo' => 'W422', 'nombre' => 'W422 - PLANIFICACION (PROY.DAE)');
		$data[] = array('codigo' => 'W423', 'nombre' => 'W423 - ADMINISTRATIVO (PROY.DAE)');
		$data[] = array('codigo' => 'W424', 'nombre' => 'W424 - EXTRAESCOLAR (PROY.DAE W424)');
		$data[] = array('codigo' => 'W425', 'nombre' => 'W425 - CONCURSO PINTURA 2005  (W-425)');
		$data[] = array('codigo' => 'W426', 'nombre' => 'W426 - TEC.PEDAGOGICO (PROY.DAE W426)');
		$data[] = array('codigo' => 'W427', 'nombre' => 'W427 - INTEGRACION LENGUAJE (W427)');
		$data[] = array('codigo' => 'W428', 'nombre' => 'W428 - INTEGRACION COMUNAL DIF.(W428)');
		$data[] = array('codigo' => 'W429', 'nombre' => 'W429 - INTEGRACION AUTISMO (W429)');
		$data[] = array('codigo' => 'W430', 'nombre' => 'W430 - ORQUESTA INFANTIL (W430)');
		$data[] = array('codigo' => 'W431', 'nombre' => 'W431 - ESCUELA DE DEPORTES (W-431)');
		$data[] = array('codigo' => 'W432', 'nombre' => 'W432 - SECCION ACCION SOCIAL (W-432)');
		$data[] = array('codigo' => 'W433', 'nombre' => 'W433 - ARTISTICO CULT. CORO   (W-433)');
		$data[] = array('codigo' => 'W434', 'nombre' => 'W434 - PROY.MANT. Y REPARAC. (W-434)');
		$data[] = array('codigo' => 'W435', 'nombre' => 'W435 - PROY.CHILE MAS SEGURO (W-435)');
		$data[] = array('codigo' => 'W436', 'nombre' => 'W436 - ESC.FUTBOL TPS (W-436)');
		$data[] = array('codigo' => 'W437', 'nombre' => 'W437 - GESTION (W-437)');
		$data[] = array('codigo' => 'W450', 'nombre' => 'W450 - EDUCACION SUBV.REGULAR T.');
		$data[] = array('codigo' => 'K607', 'nombre' => 'K607 - SAPU PLACILLA/PER CAPITA');
		$data[] = array('codigo' => 'K668', 'nombre' => 'K668 - CENTRO SALUD MUNICIP UAPO');
		$data[] = array('codigo' => 'M023', 'nombre' => 'M023 - MÓDULOS DENTALES JUNAEB');
		$data[] = array('codigo' => 'K667', 'nombre' => 'K667 - LABORATORIO CLINICO POPULAR');
		$data[] = array('codigo' => 'Z005', 'nombre' => 'Z005 - EDUCACION CENTRAL');
		$data[] = array('codigo' => 'L363', 'nombre' => 'L363 - BIBLIOTECAS');
		
		$data[] = array('codigo' => 'KKK', 'nombre' => 'KKK - Admin Suport tank');
		
    	return $data;
    }
    
    public function getCargos(){

    	$cargoOtros = array(
			0 => array('CARGO' => 'PARADOCENTE'),
			1 => array('CARGO' => 'INSTRUCTOR TEC.CULINARIA Y SER'),
			2 => array('CARGO' => 'NUTRICIONISTA'),
			3 => array('CARGO' => 'DOCENTE'),
			4 => array('CARGO' => 'INSPECTOR PARADOCENTE'),
			5 => array('CARGO' => 'TECNICO INFORMATICO'),
			6 => array('CARGO' => 'ENCARGADO MANTENCION'),
			7 => array('CARGO' => 'DIRECTIVO DOCENTE'),
			8 => array('CARGO' => 'DIRECTOR'),
			9 => array('CARGO' => 'ASISTENTE SOCIAL'),
			10 => array('CARGO' => 'ASISTENTES DE SERVICIOS'),
			11 => array('CARGO' => 'PSICOLOGO HAB.DOC.'),
			12 => array('CARGO' => 'JEFE MANTENCION'),
			13 => array('CARGO' => 'INSTRUCTOR'),
			14 => array('CARGO' => 'SECRETARIA ADM.'),
			15 => array('CARGO' => 'ASIST.DE ENLACES'),
			16 => array('CARGO' => 'VIGILANTE NOCTURNO'),
			17 => array('CARGO' => 'ENCARGADO DE BIBLIOTECA'),
			18 => array('CARGO' => 'ORIENTADOR'),
			19 => array('CARGO' => 'SUBDIRECTOR'),
			20 => array('CARGO' => 'EDUCADORA DE PARVULOS'),
			21 => array('CARGO' => 'DIRECTOR ALTA DIRECCION'),
			22 => array('CARGO' => 'ENCARGADO ENFERMERIA'),
			23 => array('CARGO' => 'INSPECTOR GENERAL'),
			24 => array('CARGO' => 'PAÑOLERO'),
			25 => array('CARGO' => 'ELECTRICISTA'),
			26 => array('CARGO' => 'JEFE UNIDAD TECNICA'),
			27 => array('CARGO' => 'CHOFER'),
			28 => array('CARGO' => 'VIGILANTE SABADOS,DOMINGOS,FES'),
			29 => array('CARGO' => 'CONTADOR'),
			30 => array('CARGO' => 'JEFE DE FORMACION DIFERENCIAL'),
			31 => array('CARGO' => 'AYUDANTE DE GABINETE'),
			32 => array('CARGO' => 'FONOAUDIOLOGO'),
			33 => array('CARGO' => 'PSICOLOGO'),
			34 => array('CARGO' => 'JEFE FORM.PROFESIONAL'),
			35 => array('CARGO' => 'DIRECTIVO DOC.CALIDAD DIRECTOR'),
			36 => array('CARGO' => 'ASISTENTE DE AULA'),
			37 => array('CARGO' => 'ENCARGADA COMPUTAC.Y ENLACES'),
			38 => array('CARGO' => 'ASISTENTE TECNICO DIFERENCIAL'),
			39 => array('CARGO' => 'ASISTENTE PRIMER AÑO BASICO'),
			40 => array('CARGO' => 'DOC.EN FUNC.DE DIRECTOR SUBROG'),
			41 => array('CARGO' => 'ENCARGADO CRA'),
			42 => array('CARGO' => 'TERAPEUTA OCUPACIONAL'),
			43 => array('CARGO' => 'DIRECTOR SUBROGANTE'),
			44 => array('CARGO' => 'KINESIOLOGO'),
			45 => array('CARGO' => 'MONITOR TALLER SEP'),
			46 => array('CARGO' => 'ASISTENTE MEDIO AMBIENTE'),
			47 => array('CARGO' => 'COORDINADOR DOCENTE Y ADMINIST'),
			48 => array('CARGO' => 'DIRECTOR JARDINES VTF'),
			49 => array('CARGO' => 'ASIST.ADMINISTRATIVO VTF'),
			50 => array('CARGO' => 'COORDINADOR(A) PIE'),
			51 => array('CARGO' => 'PSICOPEDAGOGO'),
			52 => array('CARGO' => 'ASISTENTE EDUC.DIFERENCIAL'),
			53 => array('CARGO' => 'ASISTENTE TECN.DIFERENCIAL'),
			54 => array('CARGO' => 'TECNICO SUPERIOR ENFERMERIA'),
			55 => array('CARGO' => 'TECNICO  SUPERIOR'),
			56 => array('CARGO' => 'CIRUJANO DENTISTA'),
			57 => array('CARGO' => 'MEDICO CIRUJANO'),
			58 => array('CARGO' => 'ENFERMERA(O)UNIVERSITARIA(O)'),
			59 => array('CARGO' => 'AUXILIAR DE ENFERMERIA'),
			60 => array('CARGO' => 'MATRON(A)'),
			
			61 => array('CARGO' => 'AUXILIAR DENTAL'),
			62 => array('CARGO' => 'TECNICO SUPERIOR ODONTOLOGIA'),
			63 => array('CARGO' => 'TEC.N.SUP. INFORMATICA BIOMEDI'),
			64 => array('CARGO' => 'GUARDIA DE SEGURIDAD'),
			65 => array('CARGO' => 'OTROS PROFESIONALES'),
			66 => array('CARGO' => 'TECNICO N.SUP.TRABAJO SOCIAL'),
			67 => array('CARGO' => 'TECNICO.ADM.ORG.SALUD'),
			68 => array('CARGO' => 'QUIMICO FARMACEUTICO'),
			69 => array('CARGO' => 'TECNICO SUPERIOR FARMACIA'),
			70 => array('CARGO' => 'TEC.ADM.DE EMPRESAS'),
			71 => array('CARGO' => 'SECRETARIA EJECUTIVA'),
			72 => array('CARGO' => 'TECNICO MEDICO'),
			73 => array('CARGO' => 'DIRECTOR DEL ESTABLECIMENTO'),
			74 => array('CARGO' => 'OPTOMETRISTA'),
			75 => array('CARGO' => 'TECNOLOGO MEDICO'),
			76 => array('CARGO' => 'TEC.ADM.FINANCIERA'),
			77 => array('CARGO' => 'AUXILIAR DE ALIMENTACION'),
			78 => array('CARGO' => 'TEC. INFORMATICA'),
			79 => array('CARGO' => 'AS.SOCIAL DIRECTORA'),
			80 => array('CARGO' => 'DIRECTOR DE AREA DE SALUD'),
			81 => array('CARGO' => 'ADMINISTRADOR PUBLICO'),
			82 => array('CARGO' => 'CONTADOR AUDITOR'),
			83 => array('CARGO' => 'TEC.ADM.RECURSOS HUMANOS'),
			84 => array('CARGO' => 'TECNOLOGO SIST. INFORMACION'),
			85 => array('CARGO' => 'PINTOR'),
			86 => array('CARGO' => 'CAPATAZ'),
			87 => array('CARGO' => 'ODONTOLOGO'),
			88 => array('CARGO' => 'ABOGADO'),
			89 => array('CARGO' => 'JEFE DE PERSONAL'),
			90 => array('CARGO' => 'DOCENTE FUNC.CORDINACION'),
			91 => array('CARGO' => 'ASESOR DEL AREA DE EDUCACION'),
			92 => array('CARGO' => 'SOCIOLOGO COORD. UNID.PROGRAMA'),
			93 => array('CARGO' => 'COORDINADOR PEDAGOGI. PME.'),
			94 => array('CARGO' => 'COORD.VINCULACION MEDIO'),
			95 => array('CARGO' => 'ANALISTA PROGRAMADOR'),
			96 => array('CARGO' => 'COORDI.FORM.CIUDADANA'),
			97 => array('CARGO' => 'COORD.DOCENTE EDUC. BASICA'),
			98 => array('CARGO' => 'COORD.EDUC.EXITO ESCOLAR'),
			99 => array('CARGO' => 'SUB.DIREC.PROY.Y PROGRAMAS'),
			100 => array('CARGO' => 'INGENIERO INFORMATICO'),
			101 => array('CARGO' => 'CINEASTA'),
			102 => array('CARGO' => 'ENCARGADO DE INFORMATICA'),
			103 => array('CARGO' => 'ENCARGADO COMPRAS SEP'),
			104 => array('CARGO' => 'ASISTENTE TECNICO COMPUTACION'),
			105 => array('CARGO' => 'TALLERISTA'),
			106 => array('CARGO' => 'INGENIERO COMERCIAL'),
			107 => array('CARGO' => 'TECNICO TRABAJO SOCIAL'),
			108 => array('CARGO' => 'ENCARGADO DE ADQUISICIONES'),
			109 => array('CARGO' => 'ENCARGADO DE REDES'),
			110 => array('CARGO' => 'COORDINADOR DE COMPUTACION'),
			111 => array('CARGO' => 'ENCARGADO ENLACE'),
			112 => array('CARGO' => 'INGENIERO'),
			113 => array('CARGO' => 'ALBAÑIL'),
			114 => array('CARGO' => 'CARPINTERO'),
			115 => array('CARGO' => 'ARQUITECTO'),
			116 => array('CARGO' => 'MAESTRO DE TALLERES'),
			117 => array('CARGO' => 'GASFITER OFICINA TECNICA'),
			118 => array('CARGO' => 'INGENIERO DE PROYECTOS'),
			119 => array('CARGO' => 'SOLDADOR'),
			120 => array('CARGO' => 'DIBUJANTE TECNICO'),
			121 => array('CARGO' => 'DIRECTOR ORQUESTA JUVENIL'),
		);
		
    	$cargoProfesores = array(
			0 => array('CARGO' => 'PROFESOR DE ARTES PLASTICAS'),
			1 => array('CARGO' => 'PROF.DE CS.SOCIALES E HISTORIA'),
			2 => array('CARGO' => 'PROFESOR DE FISICA'),
			3 => array('CARGO' => 'PROFESOR FUNC.APOYO UTP'),
			4 => array('CARGO' => 'PROFESOR DE MATEMATICAS'),
			5 => array('CARGO' => 'PROFESOR DE CASTELLANO'),
			6 => array('CARGO' => 'PROF. TECNOLOGIA CONSERVACION'),
			7 => array('CARGO' => 'PROF.EN FUNCION U.T.P.'),
			8 => array('CARGO' => 'PROFESOR PROCESOS PORTUARIOS'),
			9 => array('CARGO' => 'PROFESOR MECANICA AUTOMOTRIZ'),
			10 => array('CARGO' => 'PROFESOR TALLER SEP'),
			11 => array('CARGO' => 'PROF.DE EDUCACION FISICA'),
			12 => array('CARGO' => 'PROF.EN FUNCION DE ORIENTACION'),
			13 => array('CARGO' => 'PROFESOR DE COMBUSTION INTERNA'),
			14 => array('CARGO' => 'PROFESOR DE INGLES'),
			15 => array('CARGO' => 'PROFESOR DE BIOLOGIA'),
			16 => array('CARGO' => 'PROFESOR BASICO COMUN'),
			17 => array('CARGO' => 'PROF. EN FUNCION INSP. GENERAL'),
			18 => array('CARGO' => 'PROFESOR FUNCION SUBDIRECTOR'),
			19 => array('CARGO' => 'PROF.DE ALIMENTAC. Y DIETETICA'),
			20 => array('CARGO' => 'PROF.DE EDUCACION MUSICAL'),
			21 => array('CARGO' => 'PROF. QUIMICA APLICADA'),
			22 => array('CARGO' => 'PROF.MANEJO Y CONTROL ALIMENTO'),
			23 => array('CARGO' => 'PROFESOR DE QUIMICA Y CIENCIAS'),
			24 => array('CARGO' => 'PROFESOR TECNICAS ESPECIALES'),
			25 => array('CARGO' => 'PROF.DE CONTABILIDAD Y ADMINIS'),
			26 => array('CARGO' => 'PROF.EDUCACION TECNOLOGICA'),
			27 => array('CARGO' => 'PROF. A.PLASTICAS Y SERIGRAFIA'),
			28 => array('CARGO' => 'PROFES. DE GESTION DE EMPRESA'),
			29 => array('CARGO' => 'PROFESOR DE SECRETARIADO'),
			30 => array('CARGO' => 'PROF.TECNICAS DE VENTAS'),
			31 => array('CARGO' => 'PROF.ESP.SERV.DE TURISMO'),
			32 => array('CARGO' => 'PROFESOR DE FILOSOFIA'),
			33 => array('CARGO' => 'PROFESOR ARTES VISUALES'),
			34 => array('CARGO' => 'PROFESOR DE CIENCIAS NATURALES'),
			35 => array('CARGO' => 'PROFESOR TRADUCCION'),
			36 => array('CARGO' => 'PROFESOR DE DERECHO COMERCIAL'),
			37 => array('CARGO' => 'PROFESOR DE CHINO MANDARIN'),
			38 => array('CARGO' => 'PROFESOR EDUC.DIFERENCIAL'),
			39 => array('CARGO' => 'PROF.INTEGRANTE DEPTO.ORIENTAC'),
			40 => array('CARGO' => 'PROF.ELECTRONICA Y TELECOMUNIC'),
			41 => array('CARGO' => 'PROFESOR TECNOLOGIA MATERIALES'),
			42 => array('CARGO' => 'PROF. GRUPO DIFERENCIAL'),
			43 => array('CARGO' => 'PROFESOR INTEGRANTE DE U.T.P.'),
			44 => array('CARGO' => 'PROF.JEFE DE TALLER EN TEJIDOS'),
			45 => array('CARGO' => 'PROF.EN FUNCION DE JEFE PRODUC'),
			46 => array('CARGO' => 'PROF.CONFECCION Y VESTUARIO'),
			47 => array('CARGO' => 'PROFESOR DE FRANCES'),
			48 => array('CARGO' => 'PROFESOR DE MODAS'),
			49 => array('CARGO' => 'PROF.ESPECIALIDAD GRAFICA'),
			50 => array('CARGO' => 'PROFESOR DE RELIGION'),
			51 => array('CARGO' => 'PROF.ESP. ADULTO MAYOR'),
			52 => array('CARGO' => 'PROF. TECNOLOGIA GASTRONOMICA'),
			53 => array('CARGO' => 'PROFESOR DE ENFERMERIA'),
			54 => array('CARGO' => 'PROFESOR DE DISEÑO'),
			55 => array('CARGO' => 'PROF.DE ARTES GRAFICAS'),
			56 => array('CARGO' => 'PROF.SERV.ALIMENTAC.COLECTIVA'),
			57 => array('CARGO' => 'PROFESOR APOYO UT FORM.PROF.'),
			58 => array('CARGO' => 'PROF.INTRO.PROCESOS PORTUARIOS'),
			59 => array('CARGO' => 'PROF.PREVENCION DE RIESGOS'),
			60 => array('CARGO' => 'PROF.ADMINISTRACION Y TURISMO'),
			61 => array('CARGO' => 'PROF.ELAB.INDUST.DE ALIMENTOS'),
			62 => array('CARGO' => 'PROF.SERVICIOS HOTELEROS'),
			63 => array('CARGO' => 'PROF.CONSTRUCCIONES METALICAS'),
			64 => array('CARGO' => 'PROFESOR INST.SANITARIAS'),
			65 => array('CARGO' => 'PROFESOR DE ELECTRICIDAD'),
			66 => array('CARGO' => 'PROF.RELACIONES PUBLICAS'),
			67 => array('CARGO' => 'PROF.DE REFRIGERAC.Y CLIMATIZA'),
			68 => array('CARGO' => 'PROF.DE INSTALACION SANITARIA'),
			69 => array('CARGO' => 'PROFESOR DE ALEMAN'),
			70 => array('CARGO' => 'PROF.BASICO PLAN COMPUTACIONAL'),
			71 => array('CARGO' => 'PROFESOR ENCARGADO U.T.PEDAGOG'),
			72 => array('CARGO' => 'PROF.TALLER DE PELUQUERIA'),
			73 => array('CARGO' => 'PROFESOR JEFE EDUC. MEDIA'),
			74 => array('CARGO' => 'PROF.EN FUNC.DE DIRECTIVO DOC.'),
			75 => array('CARGO' => 'PROFESOR DE GASTRONOMIA'),
			76 => array('CARGO' => 'PROFESOR DE COMPUTACION'),
			77 => array('CARGO' => 'PROFESOR DE QUIMICA '),
			78 => array('CARGO' => 'PROF. DE CONTABILIDAD'),
			79 => array('CARGO' => 'PROFESOR GASFITERIA Y CARPINT.'),
			80 => array('CARGO' => 'PROFESOR ASISTENCIA SOCIAL'),
			81 => array('CARGO' => 'PROF.TALLER PERIODISMO'),
			82 => array('CARGO' => 'PROFESOR DE ACUICULTURA'),
			83 => array('CARGO' => 'PROFESOR DE COMERCIALIZACION'),
			84 => array('CARGO' => 'PROFESOR ENCARGADO'),
			85 => array('CARGO' => 'PROFESOR DE TEATRO'),
			);
    	
    	$cargosAseo = array(
			0 => array('CARGO' => 'OPERARIO'),
			1 => array('CARGO' => 'AUXILIAR'),
			2 => array('CARGO' => 'SUPERVISOR'),
		);
		
		$cargosCementario = array(
			0 => array('CARGO' => 'MAESTRO EQUIPO MANTENIMIENTO'),
			//1 => array('CARGO' => 'VIGILANTE'),
			2 => array('CARGO' => 'RESPONSABLE SEGURIDAD'),
			3 => array('CARGO' => 'JARDINERO'),
			4 => array('CARGO' => 'VENDEDOR-ADMINISTRATIVO'),
			5 => array('CARGO' => 'RECIBIDOR'),
			6 => array('CARGO' => 'MANIPULADOR DE ALIMENTOS'),
			7 => array('CARGO' => 'CHOFER CAMION'),
			8 => array('CARGO' => 'MAYORDOMO'),
			//9 => array('CARGO' => 'AUXILIAR DE SERVICIO'),
			10 => array('CARGO' => 'AUXILIAR DE ASEO'),
			11 => array('CARGO' => 'JEFE DE ARCHIVO'),
			12 => array('CARGO' => 'ENCARGADO CEMENTERIO 2'),
			13 => array('CARGO' => 'OPERADOR MAQUINARIA PESADA'),
			14 => array('CARGO' => 'SUBDIRECTORA'),
			15 => array('CARGO' => 'PORTERO'),
			16 => array('CARGO' => 'DIRECTOR CEMENTERIO'),
			17 => array('CARGO' => 'ENCARGADO CEMENTERIO 1'),
			18 => array('CARGO' => 'CAJERO-CONTADOR'),
			19 => array('CARGO' => 'SECRETARIA'),
			20 => array('CARGO' => 'SUPERVISOR UNIDAD DE VENTAS Y ADMINISTRACIÓN'),
			21 => array('CARGO' => 'RESPONSABLE AREAS VERDES'),
			22 => array('CARGO' => 'ADMINISTRATIVO'),
			23 => array('CARGO' => 'BODEGUERO'),
		);
		$cargoJardin = array(
			0 => array('CARGO' => 'AUXILIAR DE PARVULOS'),
			//1 => array('CARGO' => 'EDUCADORA DE PARVULOS'),
			//2 => array('CARGO' => 'DIRECTOR JARDINES VTF'),
			3 => array('CARGO' => 'ASISTENTE ADMINISTRATIVO'),
			4 => array('CARGO' => 'COORDINADORA DE JARDINES VTF'),
			);
		$cargosCentral = array(
			0 => array('CARGO' => 'SUB-GERENTE ADMIN.Y FINANZAS'),
			1 => array('CARGO' => 'OPTICA POPULAR'),
			2 => array('CARGO' => 'ADMINISTRATIVO NIVEL 2'),
			3 => array('CARGO' => 'DIRECTOR DE RELACIONES LABORALES'),
			4 => array('CARGO' => 'EXPERTO PREVENCION DE RIESGOS'),
			5 => array('CARGO' => 'VIGILANTE'),
			6 => array('CARGO' => 'ADMINISTRATIVO NIVEL 1'),
			7 => array('CARGO' => 'ASESOR COMUNICACIONAL'),
			//8 => array('CARGO' => 'AUXILIAR'),
			9 => array('CARGO' => 'NO INFORMA'),
			10 => array('CARGO' => 'JEFE DEPARTAMENTO COMPUTACION'),
			//11 => array('CARGO' => 'SECRETARIA'),
			12 => array('CARGO' => 'AUXILIAR DE SERVICIO'),
			//13 => array('CARGO' => 'INGENIERO EN INFORMATICA'),
			14 => array('CARGO' => 'SECRETARIA DE GERENCIA GRAL.'),
			15 => array('CARGO' => 'ARQUITECTO'),
			16 => array('CARGO' => 'GERENTE GENERAL'),
			17 => array('CARGO' => 'DIRECTOR DE PERSONAS'),
			18 => array('CARGO' => 'JEFE DEPARTAMENTO'),
			19 => array('CARGO' => 'PROGRAMADOR OPERADOR'),
			20 => array('CARGO' => 'SUBGERENTE DE OPERACIONES'),
			21 => array('CARGO' => 'TENS'),
			//22 => array('CARGO' => 'ADMINISTRATIVO'),
			23 => array('CARGO' => 'ASESOR LEGAL'),
			24 => array('CARGO' => 'TECNICO PROFESIONAL'),
			25 => array('CARGO' => 'QUIMICO FARMACEUTICO'),
			26 => array('CARGO' => 'ENCARGADO DE PROYECTOS'),
			27 => array('CARGO' => 'PERIODISTA'),
			28 => array('CARGO' => 'FARMACIA POPULAR'),
			29 => array('CARGO' => 'PSICOLOGO'),
			30 => array('CARGO' => 'ABOGADO'),
			31 => array('CARGO' => 'PERSONAL DE SERVICIO'),
			32 => array('CARGO' => 'SUPERVISOR DE SEGURIDAD'),
			34 => array('CARGO' => 'TECNICO PROCESOS SALUD'),
			//35 => array('CARGO' => 'INGENIERO'),
			36 => array('CARGO' => 'JEFE SA. OPTICA'),
			37 => array('CARGO' => 'DIRECTOR INFORMATICA Y TRANSFORMACION DIGITAL'),
			38 => array('CARGO' => 'AUXILIAR DE FARMACIA'),
			39 => array('CARGO' => 'ENCARGADO DE ADMINISTRACION Y FINANZAS'),
		);

		
    	return array_merge($cargoOtros, $cargosAseo, $cargosCementario, $cargosCentral,$cargoJardin,$cargoProfesores);
    }
    
    //------------ LICENCIAS MEDICAS ----------------------------
    

	//++++++++++++ KPI PROCESS EDUCACION ++++++++++++++++++++++
    public function getCompletados($control) {
    	$this->db->select('DEL_FINISH_DATE');
    	$this->db->from('PMT_REEMPLAZO_EDUCACION');
    	$this->db->join('APPLICATION','APPLICATION.APP_UID = PMT_REEMPLAZO_EDUCACION.APP_UID');
    	$this->db->join('APP_DELEGATION','APP_DELEGATION.APP_NUMBER = PMT_REEMPLAZO_EDUCACION.APP_NUMBER'); 
    	$this->db->join('TASK','APP_DELEGATION.TAS_UID = TASK.TAS_UID');
    	$status = 'COMPLETED';
    	$this->db->where('APPLICATION.APP_STATUS',$status);
    	$index = 1;
    	$this->db->where('APP_DELEGATION.DEL_LAST_INDEX',$index);
    	if($control == 1){
    		$UID = '6015278045c45deb1e99996035107736';
    		$this->db->where('APP_DELEGATION.TAS_UID',$UID);
    	}else{
    		$UID = '3094454645c45deb1d11cb5038948715';
    		$this->db->where('APP_DELEGATION.TAS_UID',$UID);
    	}
		$query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->result_array();
        }
        return $data;
    }
    
    public function getRechazados() {
    	$this->db->select('DEL_FINISH_DATE');
    	$this->db->from('PMT_REEMPLAZO_EDUCACION');
    	$this->db->join('APPLICATION','APPLICATION.APP_UID = PMT_REEMPLAZO_EDUCACION.APP_UID');
    	$this->db->join('APP_DELEGATION','APP_DELEGATION.APP_NUMBER = PMT_REEMPLAZO_EDUCACION.APP_NUMBER'); 
    	$status = 'CANCELLED';
    	$this->db->where('APPLICATION.APP_STATUS',$status);
    	$index = 1;
    	$this->db->where('APP_DELEGATION.DEL_LAST_INDEX',$index);
		$query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function getCreados() {
    	$this->db->select('APP_CREATE_DATE');
    	$this->db->from('PMT_REEMPLAZO_EDUCACION');
    	$this->db->join('APPLICATION','APPLICATION.APP_UID = PMT_REEMPLAZO_EDUCACION.APP_UID');
    	$this->db->join('APP_DELEGATION','APP_DELEGATION.APP_NUMBER = PMT_REEMPLAZO_EDUCACION.APP_NUMBER'); 
    	$index = 1;
    	$this->db->where('APP_DELEGATION.DEL_LAST_INDEX',$index);
    	$query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->result_array();
        }
        return $data;
    }
    
    public function getAllDelegate($pro_uid = null){
    	$this->db->select('APP_NUMBER, APP_STATUS, TAS_UID, APP_TAS_TITLE, DEL_DELEGATE_DATE, DEL_INIT_DATE, DEL_FINISH_DATE');
    	$this->db->from('APP_CACHE_VIEW');
    	$this->db->where('PRO_UID', $pro_uid);
    	$this->db->where('APP_STATUS <>','DRAFT');

		$query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->result_array();
        }
        $data = $query->result_array();
        return $data;
    }
    
    //------------ KPI PROCESS EDUCACION -----------------------
    
    //------------ PEDIDOS DROGUERIA ---------------------------
	
    public function getPedidosSrogueria(){ // Consulta realizada mediante función Complex
	    $table ='PMT_PEDIDOS_DROGUERIA';
	    $primaryKey = 'PMT_PEDIDOS_DROGUERIA.APP_UID';
	    $columnCentro = 'PMT_PEDIDOS_DROGUERIA.CENTROSOLICITANTE';
	    //Filtro de distinción de muestra de data por centros
	    $whereResult = null;
    	if($this->ion_auth->in_group(11)){
    		$filtroActivo = false;
    		$codigos = $this->ion_auth->getCodigosIgestion();
    		if(empty($codigos)){
				$whereResult = null;
    		}	else {
    				$whereResult = "(";
	    			foreach($codigos as $key => $value){
	    				$this->table = 'PMT_ESTABLECIMIENTOS_SALUD';
	    				$id_dynaform = $this->get('id_dynaform',array('codigo_centro' => $value['codigo'] ));
	    				if(!empty($id_dynaform)){
	    					$filtroActivo = true;
	    					$whereResult .= "PMT_PEDIDOS_DROGUERIA.CENTROSOLICITANTE = '".$id_dynaform[0]->id_dynaform."' OR ";
	    				}
		    		}
		    		$filtroActivo ? $whereResult = substr($whereResult, 0, -3). ")" : $whereResult = null;
    			}
    	}
    	
	  	$join = 'join APP_DELEGATION ON PMT_PEDIDOS_DROGUERIA.APP_UID = APP_DELEGATION.APP_UID JOIN TASK ON APP_DELEGATION.TAS_UID = TASK.TAS_UID JOIN USERS ON APP_DELEGATION.USR_UID = USERS.USR_UID JOIN APPLICATION ON APP_DELEGATION.APP_UID = APPLICATION.APP_UID';
	    $whereAll = "(APP_DELEGATION.DEL_LAST_INDEX =  1 OR APP_DELEGATION.DEL_THREAD_STATUS = 'OPEN')";
	    $columns = array(
			array( 'db' => 'PMT_PEDIDOS_DROGUERIA.APP_UID', 'dt' => 'VIEW_APP_UID' ),
		    array( 'db' => 'PMT_PEDIDOS_DROGUERIA.APP_NUMBER', 'dt' => 'APP_NUMBER' ),
		    array( 'db' => 'PMT_PEDIDOS_DROGUERIA.APP_STATUS', 'dt' => 'APP_STATUS' ),
		          
			array( 'db' => 'PMT_PEDIDOS_DROGUERIA.CATEGORIAPEDIDO_LABEL', 'dt' => 'CATEGORIAPEDIDO_LABEL' ),
			array( 'db' => 'PMT_PEDIDOS_DROGUERIA.CENTROSOLICITANTE_LABEL', 'dt' => 'CENTROSOLICITANTE_LABEL' ),
			array( 'db' => 'PMT_PEDIDOS_DROGUERIA.NOMBRESOLICITANTE', 'dt' => 'NOMBRESOLICITANTE' ),
			array( 'db' => 'PMT_PEDIDOS_DROGUERIA.TIPOPEDIDO_LABEL', 'dt' => 'TIPOPEDIDO_LABEL' ),
			
			array( 'db' => 'APPLICATION.APP_CREATE_DATE', 'dt' => 'APP_CREATE_DATE' ),
			    
			array( 'db' => 'APP_DELEGATION.DEL_DELEGATE_DATE', 'dt' => 'DEL_DELEGATE_DATE' ),
			array( 'db' => 'APP_DELEGATION.DEL_FINISH_DATE', 'dt' => 'DEL_FINISH_DATE' ),
			    
			array( 'db' => 'TASK.TAS_TITLE', 'dt' => 'TAS_TITLE' ),
			    
			array( 'db' => 'USERS.USR_FIRSTNAME', 'dt' => 'USR_FIRSTNAME' ),
			array( 'db' => 'USERS.USR_LASTNAME', 'dt' => 'USR_LASTNAME' ),
	                	
		    );
		     
	    	$dbProcess = $this->load->database('processMaker', TRUE);
	    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll, $join, $dbProcess);
	        return $data;
	}
	
    public function getIndicadoresP(){ // Obtención de la data, cuando el estado (APP_STATUS) cumple las condiciones (COMPLETED / TO_DO / CANCELLED) para enviarla a js y html para la acción de botón de filtro.
	    $data = $this->getPedidosSrogueria();
	    $completados = array();
	    $enCurso = array();
	    $cancelado = array();
	    foreach($data['data'] as $value){
		    if($value['APP_STATUS'] == 'COMPLETED'){
		        $completados[] = $value; 
		    }
		     if($value['APP_STATUS'] == 'TO_DO'){
		        $enCurso[] = $value; 
		    }
		     if($value['APP_STATUS'] == 'CANCELLED'){
		        $cancelado[] = $value; 
		    }
	    }
	    $dataTable = json_encode($data['data']);
	    return array($completados,$enCurso,$cancelado, $dataTable); // Se obtiene el arreglo que luego es usado por posiciones ej: $indicadores[0]
	    echo json_encode($dataTable);
	}

	public function getAllGraficaDrogueria(){ //Query que obtiene el conteo de las categorias de pedidos en cada mes para el gráfico
	    //Filtro de distinción de muestra de data por centros
	    $whereResult = null;
    	if($this->ion_auth->in_group(11)){
    		$filtroActivo = false;
    		$codigos = $this->ion_auth->getCodigosIgestion();
    		if(empty($codigos)){
				$whereResult = null;
    		}	else {
    				$whereResult = "(";
	    			foreach($codigos as $key => $value){
	    				$this->table = 'PMT_ESTABLECIMIENTOS_SALUD';
	    				$id_dynaform = $this->get('id_dynaform',array('codigo_centro' => $value['codigo'] ));
	    				if(!empty($id_dynaform)){
	    					$filtroActivo = true;
	    					$whereResult .= "PMT_PEDIDOS_DROGUERIA.CENTROSOLICITANTE = '".$id_dynaform[0]->id_dynaform."' OR ";
	    				}
		    		}
		    		$filtroActivo ? $whereResult = substr($whereResult, 0, -3). ")" : $whereResult = null;
    			}
    	}
    	// Si se cumple la condicion de distincion de centros, muestra la data de ese centro en especifico
    	if(!empty($whereResult)){
	    $this->db->select('COUNT(CATEGORIAPEDIDO) AS TOTAL,CATEGORIAPEDIDO,CATEGORIAPEDIDO_LABEL,MES FROM(SELECT month(APP_DELEGATION.DEL_RISK_DATE) AS MES,CATEGORIAPEDIDO_LABEL,CATEGORIAPEDIDO');
    	$this->db->from('PMT_PEDIDOS_DROGUERIA');
    	$this->db->join('APP_DELEGATION' ,' PMT_PEDIDOS_DROGUERIA.APP_UID = APP_DELEGATION.APP_UID');
    	$this->db->where('APP_DELEGATION.DEL_LAST_INDEX =  1 AND' .$whereResult.' AND YEAR(APP_DELEGATION.DEL_RISK_DATE) = YEAR(CURDATE()) ) AS QUERY GROUP BY CATEGORIAPEDIDO,MES ORDER BY MES ASC ');
    	}
    	// Si no tiene un centro, como un administrador entonces-> else
    	else{
    	$this->db->select('COUNT(CATEGORIAPEDIDO) AS TOTAL,CATEGORIAPEDIDO,CATEGORIAPEDIDO_LABEL,MES FROM(SELECT month(APP_DELEGATION.DEL_RISK_DATE) AS MES,CATEGORIAPEDIDO_LABEL,CATEGORIAPEDIDO');
    	$this->db->from('PMT_PEDIDOS_DROGUERIA');
    	$this->db->join('APP_DELEGATION' ,' PMT_PEDIDOS_DROGUERIA.APP_UID = APP_DELEGATION.APP_UID');
    	$this->db->where('APP_DELEGATION.DEL_LAST_INDEX =  1 AND YEAR(APP_DELEGATION.DEL_RISK_DATE) = YEAR(CURDATE()) ) AS QUERY GROUP BY CATEGORIAPEDIDO,MES ORDER BY MES ASC ');
    	}
	    $query = $this->db->get();
		$data = $query->result_array();
	    return $data;
		}

	public function getMesesUsados(){ //Data para la grafica de pedidos por meses
		$vari = $this->ProcessMaker_model->getAllGraficaDrogueria(); //Utiliza la data ya filtrada de la query obtenida en getAllGraficaDrogueria()
			
	    $nombreMeses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
	    //Variables con tamaño según la cantidad de meses (12), definidas por cada categoría conocida
		$enfermeria = [0,0,0,0,0,0,0,0,0,0,0,0];
	    $farmacia   = [0,0,0,0,0,0,0,0,0,0,0,0];
	    $maternal   = [0,0,0,0,0,0,0,0,0,0,0,0];
	    $sapu       = [0,0,0,0,0,0,0,0,0,0,0,0];
	    $cear       = [0,0,0,0,0,0,0,0,0,0,0,0];
	    $cadenaFrio = [0,0,0,0,0,0,0,0,0,0,0,0];
	    $cirugMenor = [0,0,0,0,0,0,0,0,0,0,0,0];
	    $datos = array('CategoriasNoDefinidas'=> 0); //Son Categorías no definidas las cuales no se muestran en la grafica, pero si existen bd como "nada"
		
		// Completado de la data a las variables mediante ciclos
	    foreach($vari as $dat => $all){
	    	
	        switch($all['CATEGORIAPEDIDO']){
					case 1:
						$farmacia[$all['MES']-1] = intval($all['TOTAL']);
						break;
					case 2:
						$datos['CategoriasNoDefinidas'] += 1;
						break;
					case 3:
						$enfermeria[$all['MES']-1] = intval($all['TOTAL']);
						break;
					case 4:
						$maternal[$all['MES']-1] = intval($all['TOTAL']);
						break;
					case 5:
						$sapu[$all['MES']-1] = intval($all['TOTAL']);
						break;
					case 6:
						$cear[$all['MES']-1] = intval($all['TOTAL']);
						break;
					case 7:
						$datos['CategoriasNoDefinidas'] += 1;
						break;
					case 8:
						$datos['CategoriasNoDefinidas'] += 1;
						break;
					case 9:
						$cadenaFrio[$all['MES']-1] = intval($all['TOTAL']);
						break;
					case 10:
						$cirugMenor[$all['MES']-1] = intval($all['TOTAL']);
						break;
	  			}
	        }
	        // Asignación de la data al arreglo general ($dat)
	        $dat = array();
	        $dat[0] = (array)$farmacia;
	        $dat[1] = (array)$enfermeria;
	        $dat[2] = (array)$cadenaFrio;
	        $dat[3] = (array)$maternal;
	        $dat[4] = (array)$sapu;
	        $dat[5] = (array)$cear;
	        $dat[6] = (array)$cirugMenor;
	        $dat[7] = (array)$nombreMeses;
	
	        return $dat;
    }

    //------------ FIN PEDIDOS DROGUERIA ---------------------------

    //+++++++++++++ utilidades ++++++++++++++++++++++++++
    
    public function unique_multidim_array($array, $key) {
	    $temp_array = array();
	    $i = 0;
	    $key_array = array();
	   
	    foreach($array as $val) {
	        if (!in_array($val[$key], $key_array)) {
	            $key_array[$i] = $val[$key];
	            $temp_array[$i] = $val;
	        }
	        $i++;
	    }
	    return $temp_array;
	} 
    
    public function getUser($x){
    	$this->load->database('processMaker', FALSE, TRUE);
    	
    	$this->table = 'USERS';
    	$username = $this->get('USR_USERNAME', array('USR_POSITION' => $x),array(),array(),'')[0]->USR_USERNAME;
    	
    	$this->db->close();
        return $username;
    }
    
    public function getUserUID($userNAME){
    	$this->load->database('processMaker', FALSE, TRUE);
    	
    	$this->table = 'USERS';
    	$username = $this->get('USR_UID', array('USR_USERNAME' => $userNAME),array(),array(),'')[0]->USR_UID;
    	
    	$this->db->close();
        return $username;
    }
    
    public function volumetria(){
    	//$this->db->select('COUNT(PMT_REEMPLAZO.APP_NUMBER) AS casos');
    	$this->db->select('MonthName(APP_CACHE_VIEW.APP_CREATE_DATE), count(*)');
    	$this->db->from('PMT_PEDIDOS_DROGUERIA');
    	$this->db->join('APP_CACHE_VIEW','APP_CACHE_VIEW.APP_NUMBER = PMT_PEDIDOS_DROGUERIA.APP_NUMBER');
    	//$this->db->join('APP_DELEGATION','APP_DELEGATION.APP_NUMBER = PMT_REEMPLAZO.APP_NUMBER');
    	$this->db->where('APP_CACHE_VIEW.DEL_LAST_INDEX','1');
    	$this->db->where('APP_CACHE_VIEW.APP_CREATE_DATE >=','2021-01-01');
		$this->db->where_in('APP_CACHE_VIEW.APP_STATUS',array('COMPLETED','TO_DO'));
		$this->db->group_by("MonthName(APP_CACHE_VIEW.APP_CREATE_DATE)");

		$query = $this->db->get();
		$data = $query->result_array();
	    var_dump($data);
    }
    
    
}