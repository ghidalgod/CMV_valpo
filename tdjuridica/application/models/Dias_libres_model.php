<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Dias_libres_model extends General_model {
	const TOTAL_DIAS_ADMINISTRATIVOS = 6;
	const TOTAL_PSGS = 90;
	const LINK_BASE = 'http://34.75.155.229/codiad/workspace/preproduccion/';
	const PERIODOS_ADICIONALES = 1;
	
	public function __construct() {
		
		$table = ''; //--------------------------------CAMBIAR-----------------------
        parent::__construct($table);
        $this->load->helper('directory');
        $this->load->model('ProcessMaker_model');
    }
    
    public function getPersonal(){
    	$centros = $this->ProcessMaker_model->getEstablecimiento();

    	$this->table = 'personal';
    	
    	$table = 'personal';
    	$primaryKey = 'ID';
		$whereAll = null;
		$whereResult = null;
		
		$group = array('dlibresfiltro');
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
    	
    	$rutDescansando = array();
    	$rutAcumulado = array();
    	if(empty($whereResult))  $x = $this->db->query("SELECT * FROM `feriados_legales` JOIN `personal` ON `feriados_legales`.`rut` = `personal`.`rut` WHERE `inicio` <= '".date('Ymd')."' AND `termino` >= '".date('Ymd')."'")->result_array();
    		else $x = $this->db->query("SELECT * FROM `feriados_legales` JOIN `personal` ON `feriados_legales`.`rut` = `personal`.`rut` WHERE `inicio` <= '".date('Ymd')."' AND `termino` >= '".date('Ymd')."' AND " . $whereResult)->result_array();
		foreach($x as $value) {
			$rutDescansando[] = $value['rut'];
		}
		
		
		if(empty($whereResult))  $x = $this->db->query("SELECT * FROM `dias_administrativos` JOIN `personal` ON `dias_administrativos`.`rut` = `personal`.`rut` WHERE `inicio` = '".date('Ymd')."'")->result_array();
    		else $x = $this->db->query("SELECT * FROM `dias_administrativos` JOIN `personal` ON `dias_administrativos`.`rut` = `personal`.`rut` WHERE `inicio` = '".date('Ymd')."' AND " . $whereResult)->result_array();
		foreach($x as $value) {
			$rutDescansando[] = $value['rut'];
		}
		
		if(empty($whereResult))  $x = $this->db->query("SELECT * FROM `permisos_adicionales` JOIN `personal` ON `permisos_adicionales`.`rut` = `personal`.`rut` WHERE `estado` != 2 AND `inicio` <= '".date('Ymd')."' AND `termino` >= '".date('Ymd')."'")->result_array();
    		else $x = $this->db->query("SELECT * FROM `permisos_adicionales` JOIN `personal` ON `permisos_adicionales`.`rut` = `personal`.`rut` WHERE `estado` != 2 AND `inicio` <= '".date('Ymd')."' AND `termino` >= '".date('Ymd')."' AND " . $whereResult)->result_array();
		foreach($x as $value) {
			$rutDescansando[] = $value['rut'];
		}
		
		$añoAnterior = date('Y') - 1;
		if(empty($whereResult))  $x = $this->db->query("SELECT * FROM `periodos_feriado` JOIN `personal` ON `periodos_feriado`.`rut` = `personal`.`rut` WHERE `año` = '". $añoAnterior. "' AND periodos_feriado.disponible > 0")->result_array();
    		else $x = $this->db->query("SELECT * FROM `periodos_feriado` JOIN `personal` ON `periodos_feriado`.`rut` = `personal`.`rut` WHERE `año` = '".$añoAnterior."' AND periodos_feriado.disponible > 0 AND " . $whereResult)->result_array();
		foreach($x as $value) {
			$rutAcumulado[] = $value['rut'];
		}
		
		$columns = array(
			//Datos de caso
	   		array( 'db' => 'ID', 'dt' => 'ID' ),
	   		array( 'db' => 'RUT', 'dt' => 'RUT' ),
	   		array( 'db' => 'DIGITO_RUT', 'dt' => 'DIGITO' ),
	   		array( 'db' => 'NOMBRES', 'dt' => 'NOMBRES' ),
	   		array( 'db' => 'APELLIDO_PATERNO', 'dt' => 'APELLIDO_PATERNO' ),
	   		array( 'db' => 'APELLIDO_MATERNO', 'dt' => 'APELLIDO_MATERNO' ),
	   		array( 'db' => 'RECONOSIMIENTO', 'dt' => 'FECHA_RECONOSIMIENTO' ),
	   		array( 'db' => 'CENTRO', 'dt' => 'CENTRO' ),
	   		array( 'db' => 'CARGO', 'dt' => 'CARGO' ),
	   		array( 'db' => 'CATEGORIA', 'dt' => 'CATEGORIA' ),
	   		array( 'db' => 'NIVEL', 'dt' => 'NIVEL' ),
	   		array( 'db' => 'TERMINO_CONTRATO', 'dt' => 'TERMINO_CONTRATO' ),
	   		array( 'db' => 'INICIO_CONTRATO', 'dt' => 'INICIO_CONTRATO' ),
	    );
	    
		$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll);
		$datatable = $data['data'];

		$fecha_hoy = new DateTime();
		$añoActual = (int)$fecha_hoy->format('Y');
		
		foreach($datatable as $key => $value){
			if(in_array($value['RUT'], $rutDescansando)) $datatable[$key]['DESCANSANDO'] = 1;
				else $datatable[$key]['DESCANSANDO'] = 0;
			
			if(in_array($value['RUT'], $rutAcumulado)) $datatable[$key]['ACUMULADO'] = 1;
				else $datatable[$key]['ACUMULADO'] = 0;
			
			if(strtotime($value['TERMINO_CONTRATO']) > strtotime(date('Y-m-d')) || $value['TERMINO_CONTRATO'] == '0000-00-00') $datatable[$key]['ACTIVO'] = 1;
				else $datatable[$key]['ACTIVO'] = 0;
			
			if($value['TERMINO_CONTRATO'] == "0000-00-00") $datatable[$key]['TERMINO_CONTRATO'] = "Indefinido";
				else $datatable[$key]['TERMINO_CONTRATO'] = date("d-m-Y", strtotime($value['TERMINO_CONTRATO']));
			
			$datatable[$key]['INICIO_CONTRATO'] = date("d-m-Y", strtotime($value['INICIO_CONTRATO']));
			
			$KeyCentro = array_search($value['CENTRO'], array_column($centros, 'codigo'));
    		if($KeyCentro !== FALSE) $datatable[$key]['CENTRO'] = $centros[$KeyCentro]['nombre'];

    		$datatable[$key]['FECHA_RECONOSIMIENTO'] = date("d-m-Y", strtotime($value['FECHA_RECONOSIMIENTO']));
    		
			$datatable[$key]['DIAS_LIBRES'] = $this->calcularDA($value['RUT']);
			$datatable[$key]['PSGS'] = $this->calcularPSGS($value['RUT']);
			
			$datatable[$key]['FERIADOS_LEGALES'] = $this->calcularFeriadosNegativos($value['RUT']) * -1;
			$datatable[$key]['PERIODO_ACTUAL'] = $datatable[$key]['FERIADOS_LEGALES'];
			$datatable[$key]['USADOS_ACTUAL'] = 0;
			$datatable[$key]['PERIODO_ANTERIOR'] = 0;
			$datatable[$key]['USADOS_ANTERIOR'] = 0;
			$datatable[$key]['PERIODOS_ADICIONALES'] = false;
			
			$periodos = $this->getPeriodosActivos($value['RUT']);
			
			if(!empty($periodos)){
				$datatable[$key]['PERIODO_ACTUAL'] += (int)$periodos[0]->disponible;
				$datatable[$key]['USADOS_ACTUAL'] += (int)$periodos[0]->total - (int)$periodos[0]->disponible;
				
				if(count($periodos) > 1){
					$datatable[$key]['PERIODO_ANTERIOR'] += (int)$periodos[1]->disponible;
					$datatable[$key]['USADOS_ANTERIOR'] += (int)$periodos[1]->total - (int)$periodos[1]->disponible;
					
					if(count($periodos) > 2){
						$datatable[$key]['PERIODOS_ADICIONALES'] = array_slice($periodos, 2);
					}
				}
			}

			foreach($periodos as $periodo){
				
				$datatable[$key]['FERIADOS_LEGALES'] += (int)$periodo->disponible;
				
			}
			
		}
		
		return $datatable;
    }
    
    public function getPeriodosActivos($rut){
    	
    	$añoCorte = date('Y') - (self::PERIODOS_ADICIONALES + 2);
    	$this->table = 'periodos_feriado';
		$periodos = $this->get('*', array('rut' => $rut, 'año>' => $añoCorte),array(),array(),'año DESC');
		
		return $periodos;
    	
    }
    
    public function getPersona($rut){
    	
    	$centros = $this->ProcessMaker_model->getEstablecimiento();
    	
    	$this->table = 'personal';
    	$persona = (array)$this->get('*', array('rut' => $rut))[0];
    	
    	$fecha_hoy = new DateTime();
		$añoActual = (int)$fecha_hoy->format('Y');
		
		$KeyCentro = array_search($persona['centro'], array_column($centros, 'codigo'));
		if($KeyCentro !== FALSE) $persona['centro'] = $centros[$KeyCentro]['nombre'];
		
		$persona['reconosimiento'] = date("d-m-Y", strtotime($persona['reconosimiento']));
		
		$persona['dias_libres'] = $this->calcularDA($persona['rut']);
		
		$persona['psgs'] = $this->calcularPSGS($persona['rut']);
		
		$persona['feriados_legales'] = $this->calcularFeriadosNegativos($persona['rut']) * -1;
		$persona['periodo_actual'] = $this->calcularFeriadosNegativos($persona['rut']) * -1;
		$persona['usados_actual'] = 0;
		$persona['periodo_anterior'] = 0;
		$persona['usados_anterior'] = 0;
		
		if($persona['termino_contrato'] == "0000-00-00") $persona['termino_contrato'] = "No registrado";
				else $persona['termino_contrato'] = date("d-m-Y", strtotime($persona['termino_contrato']));
			
		$persona['inicio_contrato'] = date("d-m-Y", strtotime($persona['inicio_contrato']));
		$persona['periodos_adicionales'] = false;
		
		$periodos = $this->getPeriodosActivos($rut);
		
		if(!empty($periodos)){
			$persona['periodo_actual'] += (int)$periodos[0]->disponible;
			$persona['usados_actual'] += (int)$periodos[0]->total - (int)$periodos[0]->disponible;
			
			if(count($periodos) > 1){
				$persona['periodo_anterior'] += (int)$periodos[1]->disponible;
				$persona['usados_anterior'] += (int)$periodos[1]->total - (int)$periodos[1]->disponible;
				
				if(count($periodos) > 2){
					$persona['periodos_adicionales'] = array_slice($periodos, 2);
				}
			}
		}

		foreach($periodos as $periodo){
			
			$persona['feriados_legales'] += (int)$periodo->disponible;
			
		}
		
		return $persona;
    }
    
    /**************************
     * Agrega un nuevo personal, calculando y registrando su periodo actual para los dias libres.
     * 
     * entrada: array(
     *			'rut' => (INT),
     *			'digito_rut' => (CHAR),
     *			'nombres' => (varchar100),
     *			'apellido_paterno' => (varchar100),
     *			'apellido_materno' => (varchar100),
     *			'reconosimiento' => (date(Y-m-d)),
     *			'centro'	=> (varchar50), //Codigo interno de igestion Admin central = Z001
     *			'correo' => (varchar100), //Puede ser NULL
     *			'cargo' => (varchar100),
     *			'categoria' => (varchar100), // solo aplica a salud, puede ser null
     *			'nivel' => (varchar100), // solo aplica a salud, puede ser null
     *			);
     * Salida: true/false
     * 
     * **/

    
    public function getMesesUsados(){
    	$group = array('dlibresfiltro');
    	
    	$whereResult = 'TRUE';
		if($this->ion_auth->in_group($group)) {
    		$codigos = $this->ion_auth->getCodigosIgestion();
    		if(empty($codigos)){
				$whereResult = 'TRUE';
    		}	else {
    				$whereResult = "(";
	    			foreach($codigos as $key => $value){
	    				$whereResult .= "centro = '".$value['codigo']."' OR ";
		    		}
		    		$whereResult = substr($whereResult, 0, -3). ")";
    			}
    	}
    	
		$ultimoMes = $this->db->query("SELECT month(MAX(inicio)) as mes FROM `feriados_legales`")->result_array()[0]['mes'];
		
		$nombreMeses = [
				"",
	            "Enero",
	            "Febrero",
	            "Marzo",
	            "Abril",
	            "Mayo",
	            "Junio",
	            "Julio",
	            "Agosto",
	            "Septiembre",
	            "Octubre",
	            "Noviembre",
	            "Diciembre",
	        ];
		
		$total = 12;
		$mes   = 1;
		
		$data = array();
		for($mes ; $mes <= 12; $mes++){
			if($mes <= $ultimoMes){
				$x = $this->db->query("SELECT count(*) AS cantidad FROM `feriados_legales` JOIN `personal` ON `feriados_legales`.`rut` = `personal`.`rut` WHERE month(inicio) = '".$mes."' AND " . $whereResult)->result_array();
				$data[0][] = $x[0]['cantidad'];
				$data[1][] = $nombreMeses[(int)$mes];
			}else{
				$data[0][] = 0;
				$data[1][] = $nombreMeses[(int)$mes];
			}
		}
		return $data;
    }
    /************Calcula el periodo considerando feriados progresivos*******
     *	Input: 
     *			antiguedad: DATE, formato sugerido Y-m-d, Fecha que ingreso personal a trabajar(Reconosimiento)
     *			fecha: DATE, formato suguerido Y-m-d, fecha del periodo que se quiere calcular, puede ser la actual, o futura
     * Output:
     *			Array(
     *					año => INT, Año del periodo calculado
     *					total => INT, Total de feriados legales
     *				), Si se puede calcular el periodo
     *			NULL, Si personal no cumple los 365 dias de antiguedad y no se puede calcular periodo
     * 
     ************************************************************************/
    public function calcularPeriodo($antiguedad, $fecha){
    	$fecha_hoy = new DateTime();
		$fecha_hoy->setTimestamp(strtotime($fecha));
		
		$fecha_ingreso = new DateTime();
		$fecha_ingreso->setTimestamp(strtotime($antiguedad));
		
		$periodo = array(
			'año' => $fecha_hoy->format('Y'),
			);

		if((int)$fecha_hoy->format('Y') - (int)$fecha_ingreso->format('Y') >= 20){ //20 años de antiguedad
			$periodo['total'] = 25;
			return $periodo;
		}	else{
				if((int)$fecha_hoy->format('Y') - (int)$fecha_ingreso->format('Y') >= 15){ //15 años de antiguedad
					$periodo['total'] = 20;
					return $periodo;
				}	else{
						if($fecha_hoy->diff($fecha_ingreso)->days > 365) {
							$periodo['total'] = 15;
							return $periodo;
						}	else{
								return null;
							}
					}
			}
    }
    
    //Retorna la cantidad de dias pedidos como feriados legales negativos (Se considera negativo, a los feriados pedidos cuando no se tenia disponibilidad)
    //Cuando se ingrese su proximo periodo, se descontara por otra función los dias pedidos
    public function calcularFeriadosNegativos($rut){
    	$this->table = "feriados_legales";
    	$feriadosNegativos = $this->get('*',array('rut' => $rut, 'negativo' => 1));
    	
    	$valorTotal = 0;
    	if(empty($feriadosNegativos)) return $valorTotal;
    	foreach($feriadosNegativos as $value){
    		$valorTotal += $this->contarDHabiles($value->inicio,$value->termino); 
    	}
    	return $valorTotal;
    	
    }
    
    //Elimina los feriados negativos, esta funcion se tiene que ejecutar despues de restar los dias pedidos al nuevo periodo
    public function actualizarFeriadosNegativos($rut){
    	$this->table = "feriados_legales";
    	$feriadosNegativos = $this->get('*',array('rut' => $rut, 'negativo' => 1));
    	
    	foreach($feriadosNegativos as $value){
    		$value->negativo = 0;
    		if(!$this->update($value, array('id' => $value->id))) return false;
    	}
    	
    	return true;
    }
    
    //agrega un periodo nuevo, correspondiente al año en curso (esta función solo esta diseñada para usarce para agregar el periodo del año en curso, la linea 323 es la que crea un periodo y se le pasa el año actual. si
    //si se quiere agregar un periodo de año anterior o futuro, se usa calcularPeriodo() y el segundo parametro sera la fecha del periodo anterior, despues se agrega manualmente cono add a la tabla.
    public function agregarPeriodo($rut, $antiguedad){
    	//aca el parametro antiguedad es el que en la DB llamamos reconosimiento. osea la fecha que se reconose que el funcionario empezo a trabajar(no solo en la empresa, sino en su vida laboral).
    	
    	$this->table = 'personal';
    	$inicioContrato = $this->get('inicio_contrato', array('rut' =>$rut))[0];
    	
    	$fecha_hoy = new DateTime();
		$fecha_hoy->setTimestamp(strtotime(date("Y-m-d")));
		
		$fecha_ingreso = new DateTime();
		$fecha_ingreso->setTimestamp(strtotime($inicioContrato->inicio_contrato));
		
		if($fecha_hoy->diff($fecha_ingreso)->days <= 365) return true; //Aun no cumple 1 año, es correcto no agregar periodo
		
    	$periodoActual = $this->calcularPeriodo($antiguedad, date('Y-m-d'));
    	
    	if(!empty($periodoActual)){
    		$periodoActual['rut'] = $rut;
    		//$periodoActual['alerta'] = 0;
    		
    		$totalNegativos = $this->calcularFeriadosNegativos($rut);
    		$periodoActual['disponible'] = $periodoActual['total'] - $totalNegativos;
    		$this->table = 'periodos_feriado';
    		$this->add($periodoActual);
    		return $this->actualizarFeriadosNegativos($rut);
    	}	else {
    			return true;
    		}
    }
    
    //Calcula los dias administrativos disponibles para el año en curso
    public function calcularDA($rut, $fecha = null){
    	$diasRestantes = self::TOTAL_DIAS_ADMINISTRATIVOS;
    	if($fecha == null) $fecha = date('Y');
    	$this->table = 'dias_administrativos';
    	$permisos = $this->get('*',array('year(inicio)' => $fecha, 'rut' => $rut));
    	
    	foreach($permisos as $value){
    		$diasRestantes -= (float)$value->dias;
    	}
    	
    	return $diasRestantes;
    }
    
    public function calcularPSGS($rut){
    	$diasRestantes = self::TOTAL_PSGS;
    	$fecha = date('Y');
    	$this->table = 'permisos_adicionales';
    	$permisos = $this->get('*',array('year(inicio)' => $fecha, 'rut' => $rut));
    	
    	foreach($permisos as $value){
    		if($value->estado != 2){
	    		$start = new DateTime($value->inicio);
				$end = new DateTime($value->termino);
		
				$end->modify('+1 day'); //Incluye el ultimo dia
				
				$interval = $end->diff($start);
				
				// total dias
				$days = $interval->days;
	    		$diasRestantes -= $days;
    			
    		}
    	}
    	
    	return $diasRestantes;
    }
	
	//Calcula cuantos dias disponibles le queda de feriados legales a la persona, si no lo quedan, se envia la cantidad de dias disponibles del periodo siguiente
	//para que pueda registrar el feriado como negativo
	public function calcularEspacioFL($rut){
		
		$periodos = $this->getPeriodosActivos($rut);
		$diasDisponibles = 0;
		$fecha_hoy = new DateTime();
		$añoActual = (int)$fecha_hoy->format('Y');
		
		foreach($periodos as $periodo){
			//cuenta dias periodos
			$diasDisponibles += (int)$periodo->disponible;
		}
		
		if($diasDisponibles > 0 ){
			$espacioDisponible = array(
				'negativo' => 0,
				'disponibles' => $diasDisponibles,
				'detalle' => $periodos
			);
			return $espacioDisponible;
		}	else{
				$this->table = 'personal';
				$personal = $this->get('*', array('rut' => $rut))[0];
				$proximoPeriodo = $this->calcularPeriodo($personal->reconosimiento, date('Y') + 1);
				
				$disponibles = $proximoPeriodo['total'] - $this->calcularFeriadosNegativos($rut);
				
				$espacioDisponible = array(
					'negativo' => '1',
					'disponibles' => $disponibles,
				);
				return $espacioDisponible;
			}
	}
	
	public function addFL($data = null){
		if(empty($data)) return ['NULL_DATA'];
		
		$disponibles = $this->calcularEspacioFL($data['rut']);

		$diasHabiles = $this->contarDHabiles($data['inicio'], $data['termino']);
		
		if($disponibles['disponibles'] >= $diasHabiles){
			
			if($disponibles['negativo']) $data['negativo'] = 1;
			
			$this->table = 'feriados_legales';
			$idIngresado = $this->add_id($data);
			
			
			if($idIngresado > 0){
				//TO-DO:Controlar la excepción cuando la actualización falla
				
				if($disponibles['negativo']){
					//FERIADO NEGATIVO, CUANDO TIENE 0 DIAS EN SU PERIODO ACTUAL, O NO TIENE PERIODO. SE LES DESCONTARA CUANDO LO TENGA,
					$updateDatatable = array(
						'disponibles' => - $this->calcularFeriadosNegativos($data['rut']),
						'disponiblesPeriodoActual' => - $this->calcularFeriadosNegativos($data['rut']),
					);
					return ['SUCCESSFUL', $idIngresado, $diasHabiles, $updateDatatable];
				}	else {
						if($this->descontarFL($data['rut'], $diasHabiles, $disponibles['detalle'])) {

							$updateDatatable = array(
								'disponibles' => $disponibles['disponibles'] - $diasHabiles,
							);
							$periodos = $this->getPeriodosActivos($data['rut']);
							
							$updateDatatable['disponiblesPeriodoActual'] = $periodos[0]->disponible;
							$updateDatatable['utilizadosPeriodoActual'] = $periodos[0]->total - $periodos[0]->disponible;
							$updateDatatable['disponiblesPeriodoAnterior'] = empty($periodos[1]) ? 0 : $periodos[1]->disponible;
							$updateDatatable['utilizadosPeriodoAnterior'] = empty($periodos[1]) ? 0 :  $periodos[1]->total - $periodos[1]->disponible;
							$updateDatatable['periodosAdicionales'] = array_slice($periodos, 2);
							
							return ['SUCCESSFUL', $idIngresado, $diasHabiles, $updateDatatable];
						}	else return ['ERROR_DB2', $idIngresado];
					}
			}	else {
					return ['ERROR_DB', $idIngresado];
				}
		}	else{
				return ['NOT_DAYS'];
			}
	}
	
	public function descontarFL($rut, $dias, $periodos = null){
		//Descueta de los periodos que tiene los dias tomados
		$this->table = 'periodos_feriado';
		if(empty($periodos)) $periodos = $this->getPeriodosActivos($rut);
		
		$periodos = array_reverse($periodos);
		
		foreach($periodos as $periodo){
			
			if($periodo->disponible >= $dias) {
				$periodo->disponible -= $dias;
				return $this->update($periodo, array('id' => $periodo->id));
			}else{
				$dias -= $periodo->disponible;
				$periodo->disponible = 0;
				if(!$this->update($periodo, array('id' => $periodo->id))) return false;
			}
		}
	}
	
	public function contarDHabiles($inicio, $termino, $descontar = true){
		$start = new DateTime($inicio);
		$end = new DateTime($termino);

		$end->modify('+1 day'); //Incluye el ultimo dia
		
		$interval = $end->diff($start);
		
		// total dias
		$days = $interval->days;
		
		$period = new DatePeriod($start, new DateInterval('P1D'), $end); //Intervalo de fechas por dia (P1D)
		
		// Implementar mantenedor de feriados legales, en BD, y actualizar regla para considerar feriados del año en curso.
		$holidays = array('2019-12-25','2020-01-01','2020-04-10','2020-05-21','2020-06-29', '2020-07-16', '2020-07-16', '2020-09-18', '2020-10-12', '2020-12-08', '2020-12-25','2021-01-01','2021-04-02','2021-05-21','2021-06-21','2021-06-28','2021-07-16','2021-09-17','2021-10-11','2021-11-01','2021-12-08'); //Arreglo de festivos

		if($descontar) {
			foreach($period as $dt) {
			    $curr = $dt->format('D');
			
			    // Elimina sabados y domingos
			    if ($curr == 'Sat' || $curr == 'Sun') {
			        $days--;
			    }
			
			    // Si no es sabado o domingo, comprueba que no sea feriado
			    elseif (in_array($dt->format('Y-m-d'), $holidays)) {
			        $days--;
			    }
			}
		}
		return $days;
	}
	
	//Elimina un Feriado legal con una id especifica
	//esta funcion lo elimina y devuelve los dias usados por este FL
	//a sus periodos correspondientes, tambien incluye unos echos para saber cuantos
	//dias le estoy devolviendo a que periodo, estos echo pueden ser comentados si se encuentran innecesarios
	
	public function removeFL($id = null){
		if(empty($id)) return ['NULL_ID'];
		
		$fecha_hoy = new DateTime();
		$añoActual = (int)$fecha_hoy->format('Y');
		$this->table = 'feriados_legales';
		
		$feriado = $this->get('*', array('id' => $id))[0];
		$periodos = $this->getPeriodosActivos($feriado -> rut);
		$dias = $this->contarDHabiles($feriado->inicio, $feriado->termino); //dias que se tomo como FL
		
		if($feriado->negativo != 1){
			$this->table = 'periodos_feriado';
			$periodoActual = $this->get('*', array('rut' => $feriado->rut, 'año' => $añoActual))[0];
			echo($periodoActual->año."<br>");
			echo($periodoActual->total."<br>");
			if($periodoActual->total >= $dias + $periodoActual->disponible){ //Si es que el total del periodo es igual o mayor a los dias disponibles mas los dias pedidos
				echo("He entrado al primer if");
				$this->update(array('disponible' => $dias + $periodoActual->disponible),array('id' => $periodoActual->id)); //se le devuelven los dias, esto solo pued ocurrir si el trabajador no esta en negativo
			} else{
				for($i = 0; $i < sizeof($periodos); $i++ ){
					$feriadoAnterior = $this->get('*', array('rut' => $feriado->rut, 'año' => $añoActual - $i))[0];;
					if($feriadoAnterior -> total == $feriadoAnterior -> disponible){
						echo("El periodo ".$feriadoAnterior -> año." posee todos los dias disponibles<br>");
					}else{
						$diasFaltantes = ($feriadoAnterior->total - $feriadoAnterior->disponible);
						
						if($dias > 0 and $dias > $diasFaltantes){
							$this->update(array('disponible' => $feriadoAnterior->disponible + $diasFaltantes),array('id' => $feriadoAnterior->id));
							$dias = $dias - $diasFaltantes;
							echo("Le estoy devolviendo ".$diasFaltantes." dia al periodo ".$feriadoAnterior -> año."<br>");
						}else{
							if($dias != 0){
								echo("Le estoy devolviendo los ultimos  ".$dias." dia(s) al periodo".$feriadoAnterior -> año."<br>");
								$this->update(array('disponible' => $feriadoAnterior->disponible + $dias),array('id' => $feriadoAnterior->id));
								$dias = 0;
							}else{
								echo("No quedan dias que devolver<br>");
							}
						}
					}
				}
			}
		}
		
		$this->table = 'feriados_legales';
		return $this->remove(array('id' => $id));
	}
	
	public function addDA($data = null){
		if(empty($data)) return ['NULL_DATA'];
		
		$diasActuales = $this->calcularDA($data['rut'], date('Y', strtotime($data['inicio'])));
		if($diasActuales < (float)$data['dias']){
			return ['NOT_DAYS'];
		}
		
		$this->table = 'dias_administrativos';
		
		$idIngresado = $this->add_id($data);
		if($idIngresado > 0){
			return ['SUCCESSFUL', $idIngresado, $diasActuales - (float)$data['dias']];
		} else {
			return ['ERROR_DB', $idIngresado];
		}
	}
	
	public function addOtros($data = null){
		if(empty($data)) return ['NULL_DATA'];
		$dias = $this->contarDHabiles($data['inicio'], $data['termino'],false);
		$diasActuales = $this->calcularPSGS($data['rut']);
		if($diasActuales < $dias){
			return ['NOT_DAYS'];
		}
		
		$this->table = 'permisos_adicionales';
		
		$idIngresado = $this->add_id($data);
		if($idIngresado > 0){
			return ['SUCCESSFUL', $idIngresado, $diasActuales - $dias];
		} else {
			return ['ERROR_DB', $idIngresado];
		}
	}
	
	/*con el id y la data que se entrega para actualizar (id,fecha,dias) se intenta realizar un update en la bd
	en caso de no poder se captura el error y se entrega, como el controlador espera el resultado "ACTUALIZADO"
	se mostrará el hecho de que no se pudo realizar la actualización*/
	public function updateDA($id,$data_DA){
		$result = "ACTUALIZADO";
		try {
			$this->db->where('id', $id);
			$this->db->update('dias_administrativos', $data_DA);
		} catch (Exception $e) {
    		$result = 'Excepción capturada: '.$e->getMessage()."\n";
		}
		return $result;
	}
	
	public function removeDA($id = null){
		if(empty($id)) return ['NULL_ID'];
		
		$this->table = 'dias_administrativos';
		
		return $this->remove(array('id' => $id));
	}
	
	public function getPermisos($rut = null){
		
		//GET FERIADOS LEGALES
		$table = 'feriados_legales';
    	$primaryKey = 'ID';
		$whereAll = "RUT = '".$rut."'";
		$whereResult = null;
		
		$columns = array(
			//Datos de caso
	   		array( 'db' => 'ID', 'dt' => 'ID' ),
	   		array( 'db' => 'RUT', 'dt' => 'RUT' ),
	    	array( 'db' => 'INICIO', 'dt' => 'INICIO' ),
	    	array( 'db' => 'TERMINO', 'dt' => 'TERMINO' ),
	    );
	    
		$dataFL = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll);
		
		foreach($dataFL['data'] as $key => $value){
			$dataFL['data'][$key]['PERMISO'] = 'Feriado Legal';
			
			$downloadPath = './files/diasLibres/'.$value['RUT'].'/fl/'.$value['ID'].'/';
			$map = directory_map($downloadPath,1);
			if(!empty($map[0])){
				$downloadPath = $downloadPath . $map[0];
				$dataFL['data'][$key]['DOCUMENTO'] = self::LINK_BASE . substr($downloadPath,2);
			}
				
			$dataFL['data'][$key]['DIAS'] = $this->contarDHabiles($value['INICIO'], $value['TERMINO']);
		}
		
		//GET DIAS ADMINISTRATIVOS
		$table = 'dias_administrativos';
    	$primaryKey = 'ID';
		$whereAll = "RUT = '".$rut."'";
		$whereResult = null;
		
		$columns = array(
			//Datos de caso
	   		array( 'db' => 'ID', 'dt' => 'ID' ),
	   		array( 'db' => 'RUT', 'dt' => 'RUT' ),
	    	array( 'db' => 'INICIO', 'dt' => 'INICIO' ),
	    	array( 'db' => 'DIAS', 'dt' => 'DIAS' ),
	    );
	    
	    $dataDA = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll);
	    
	    foreach($dataDA['data'] as $key => $value){
			$dataDA['data'][$key]['PERMISO'] = 'Día Administrativo';
			$dataDA['data'][$key]['TERMINO'] = '';
			$downloadPath = './files/diasLibres/'.$value['RUT'].'/da/'.$value['ID'].'/';
			$map = directory_map($downloadPath,1);
			if(!empty($map[0])){
				$downloadPath = $downloadPath . $map[0];
				$dataDA['data'][$key]['DOCUMENTO'] = self::LINK_BASE . substr($downloadPath,2);
			}else{
				$dataDA['data'][$key]['DOCUMENTO'] = '*';
			}
		}
		
		//GET OTROS
		$table = 'permisos_adicionales';
    	$primaryKey = 'ID';
		$whereAll = "RUT = '".$rut."'";
		$whereResult = null;
		
		$columns = array(
			//Datos de caso
	   		array( 'db' => 'ID', 'dt' => 'ID' ),
	   		array( 'db' => 'RUT', 'dt' => 'RUT' ),
	    	array( 'db' => 'INICIO', 'dt' => 'INICIO' ),
	    	array( 'db' => 'TERMINO', 'dt' => 'TERMINO' ),
	    	array( 'db' => 'TIPO', 'dt' => 'TIPO' ),
	    	array( 'db' => 'ESTADO', 'dt' => 'ESTADO' ),
	    );
	    
	    $dataOtros = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll);
	    
	    foreach($dataOtros['data'] as $key => $value){
	    	if($value['TIPO'] == 1) {
	    		$dataOtros['data'][$key]['PERMISO'] = 'Permiso sin goce de sueldo ';
	    		if($value['ESTADO'] == 0) $dataOtros['data'][$key]['PERMISO'] .= '(EN APROBACIÓN)';
	    		if($value['ESTADO'] == 1) $dataOtros['data'][$key]['PERMISO'] .= '(ACEPTADO)';
	    		if($value['ESTADO'] == 2) $dataOtros['data'][$key]['PERMISO'] .= '(RECHAZADO)';
	    	}
	    	if($value['TIPO'] == 2) $dataOtros['data'][$key]['PERMISO'] = 'Beca';
	    	
			$downloadPath = './files/diasLibres/'.$value['RUT'].'/otros/'.$value['ID'].'/';
			$map = directory_map($downloadPath,1);
			if(!empty($map[0])){
				$downloadPath = $downloadPath . $map[0];
				$dataOtros['data'][$key]['DOCUMENTO'] = self::LINK_BASE . substr($downloadPath,2); //cambiar base url
			}	else {
					$dataOtros['data'][$key]['DOCUMENTO'] = "*";
				}
			$dataOtros['data'][$key]['DIAS'] = $this->contarDHabiles($value['INICIO'], $value['TERMINO'],false);
		}
		
		$data = array(
			"draw"            => 0,
			"recordsTotal"    => $dataFL['recordsTotal'] + $dataDA['recordsTotal'],
			"recordsFiltered" => $dataFL['recordsFiltered'] + $dataDA['recordsFiltered'],
			"data"            => array_merge($dataFL['data'], $dataDA['data'])
		);
		$data["data"] = array_merge($data["data"], $dataOtros['data']);
		return $data;
	}
	
	public function getPermisosValidar(){
		//GET FERIADOS LEGALES
		$centros = $this->ProcessMaker_model->getEstablecimiento();
		$table = 'permisos_adicionales';
    	$primaryKey = 'permisos_adicionales.ID';
		$whereAll = "estado = 0 AND tipo = 1";
		$whereResult = null;
    	$join = 'JOIN personal ON personal.rut = permisos_adicionales.rut';

		
		$columns = array(
			//Datos de caso
	   		array( 'db' => 'permisos_adicionales.ID', 'dt' => 'ID' ),
	   		array( 'db' => 'permisos_adicionales.RUT', 'dt' => 'RUT' ),
	   		array( 'db' => 'DIGITO_RUT', 'dt' => 'DIGITO' ),
	    	array( 'db' => 'INICIO', 'dt' => 'INICIO' ),
	    	array( 'db' => 'TERMINO', 'dt' => 'TERMINO' ),
	    	array( 'db' => 'TIPO', 'dt' => 'TIPO' ),
	    	array( 'db' => 'CENTRO', 'dt' => 'CENTRO' ),
	    	array( 'db' => 'NOMBRES', 'dt' => 'NOMBRES' ),
	   		array( 'db' => 'APELLIDO_PATERNO', 'dt' => 'APELLIDO_PATERNO' ),
	   		array( 'db' => 'APELLIDO_MATERNO', 'dt' => 'APELLIDO_MATERNO' ),
	    );
	    
		$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll, $join);
		
		foreach($data['data'] as $key => $value){
			if($value['TIPO'] == 1) $data['data'][$key]['PERMISO'] = 'PSGS';
			
			$KeyCentro = array_search($value['CENTRO'], array_column($centros, 'codigo'));
    		if($KeyCentro !== FALSE) $data['data'][$key]['CENTRO'] = $centros[$KeyCentro]['nombre'];
			
			$downloadPath = './files/diasLibres/'.$value['RUT'].'/otros/'.$value['ID'].'/';
			$map = directory_map($downloadPath,1);
			if(!empty($map[0])){
				$downloadPath = $downloadPath . $map[0];
				$data['data'][$key]['DOCUMENTO'] = self::LINK_BASE . substr($downloadPath,2);
			}
				
			$data['data'][$key]['DIAS'] = $this->contarDHabiles($value['INICIO'], $value['TERMINO'],false);
		}
		return $data;
	}
	
	public function aceptarPermiso($id = null){
		if(empty($id)) return 0;
		
		$this->table = 'permisos_adicionales';
		return $this->update(array('estado' => 1), array('id' => $id));
	}
	
	public function rechazarPermiso($id = null){
		if(empty($id)) return 0;
		
		$this->table = 'permisos_adicionales';
		return $this->update(array('estado' => 2), array('id' => $id));
	}
	
	public function getFL($id){
		$this->table = "feriados_legales";
		$feriadoL = $this->get('*', array('id' => $id));
		
		if(empty($feriadoL)) return false;
			else return (array)$feriadoL[0];
	}
	
	/*con el id de un dia administrativo se entrega la data de la persona a quien pertenece el dia administrativo
	la data del dia administrativo y lo disponible para agregar da's*/
	public function getDA($id){
		$this->table = "dias_administrativos";
		$dataDiaAdm = (array)$this->get('*', array('id' => $id))[0];
		$disponible = $this->calcularDA($dataDiaAdm['rut']);
		
		$this->table = 'personal';
		$persona  = (array)$this->get('*', array('rut' => $dataDiaAdm['rut']))[0];
		
		/*para entregar un string con el rut y el nombre con formato xx.xxx.xxx-d y n-ap-am*/
		preg_match("/(\d{3})(\d{3})(\d{2})/",strrev( $dataDiaAdm['rut']),$matches, PREG_OFFSET_CAPTURE, 0);
		$rut_comp = join("",array(strrev($matches[3][0]),".",strrev($matches[2][0]),".",strrev($matches[1][0]),"-",$persona['digito_rut']));
		$nombre   = join("",array($persona['nombres']," ",$persona['apellido_paterno']," ",$persona['apellido_materno']));
		
		$diaADM = array(
				"diaADM"	 => (array)$dataDiaAdm,
				"disponible" => $disponible,
				'nombre'     => $nombre,
				'rut'        => $rut_comp
			);
		
		if(empty($diaADM)) return false;
			else return $diaADM;
	}	
	// Notificaciónes ingreso permiso psgs
	public function notificarPSGS($permiso){
		$users = $this->ion_auth->users(18)->result();
		$persona = $this->getPersona($permiso['rut']);
		
		$cuerpoCorreo = $this->formatBodyMailPSGS($permiso, $persona);
		$nombreRemitente = 'Personal CMV';
		foreach($users as $user){
			$correoRemitente = $user->email;
				
			$this->sendMail($nombreRemitente, $correoRemitente, $cuerpoCorreo, 'Nuevo permiso psgs');
		}
	}

	//Funciones para cron
	
	public function primerPeriodo(){
		//Comprueba si algun funcionario tiene ya el año cumplido de antiguedad. Si se da el caso, el sistema le asigna su primer periodo de feriados legales
		$añoAnterior = date('Y') - 1;
		
		$this->table = 'personal';
		$personal = $this->get('*',array('year(inicio_contrato)' => $añoAnterior));
		
		foreach($personal as $key => $persona ){
			$fecha_hoy = new DateTime();
			$fecha_hoy->setTimestamp(strtotime(date('Y-m-d')));
			
			$fecha_ingreso = new DateTime();
			$fecha_ingreso->setTimestamp(strtotime($persona->reconosimiento));
			
			if($fecha_hoy->diff($fecha_ingreso)->days > 365) {		//Comprueba si le corresponde el primer periodo
				$this->table = 'periodos_feriado';
				$periodo = $this->get('*',array('rut' => $persona->rut));
				if(empty($periodo)){	
					//Si no tiene un periodo agregado, se le crea
					$this->agregarPeriodo($persona->rut, $persona->reconosimiento);
				}
				
			}
							
		}
		
		return 1;
	}
	
	public function periodoCambioAño(){
		//Cuando empieza un año(02-01-xxxx), se ingresa el nuevo periodo para todo funcionario que tiene mas de 2 años de antiguedad. siguiendo la regla de feriados progresivos
		$dosAñoAnterior = date('Y') - 2;
		
		$this->table = 'personal';
		$personal = $this->get('*',array('year(reconosimiento) <=' => $dosAñoAnterior));
		
		foreach($personal as $key => $persona ){
			$this->agregarPeriodo($persona->rut, $persona->reconosimiento);
		}
	}
	
	public function notificarVencimientoPeriodo(){
		$añoAnterior = date('Y') - 1;
		
		$this->db->from('periodos_feriado');
		$this->db->where('año',$añoAnterior);
		$this->db->where('disponible >',0);
		$this->db->join('personal', 'periodos_feriado.rut = personal.rut' );

		$periodoPersonal = $this->db->get()->result_array();
		
		$personalAgrupado = array();
		
		foreach($periodoPersonal as $key => $value){
			
			if(!empty($value['correo'])){
				$cuerpoCorreo = $this->formatBodyMail2($value);
				$correoRemitente = $value['correo'];
				$nombreRemitente = 'Personal CMV';
				$this->sendMail($nombreRemitente, $correoRemitente, $cuerpoCorreo);
			}
			
			$personalAgrupado[$value['centro']][] = $value;
		}
		
		foreach($personalAgrupado as $key => $value){
			$this->db->from('users_igestion');
			$this->db->where('users_igestion.codigo',$key);
			$this->db->where('users_groups.group_id',16);
			$this->db->join('users_groups', 'users_igestion.user_id = users_groups.user_id' );
			$usuarioCentro = $this->db->get()->result_array();
			
			if(!empty($usuarioCentro)){
				foreach($usuarioCentro as $value2){
					$idUser = $value2['user_id'];
					$cuerpoCorreo = $this->formatBodyMail($value);
					$correoRemitente = $this->db->query("SELECT email FROM users WHERE id='$idUser'")->row_array()['email'];
					$nombreRemitente = 'Centro CMV';
					$this->sendMail($nombreRemitente, $correoRemitente, $cuerpoCorreo);
				}
			}
		}
		
	}
	
	private function sendMail($nombre = null, $email = null, $cuerpoCorreo, $subject = null){
        $this->load->library('PHPMailer_Lib');
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
		$mail->Username = "notificaciones.td@cmvalparaiso.cl";
		$mail->Password = "td456CMV";
		$mail->setFrom('notificaciones.td@cmvalparaiso.cl', 'Notificación Días libres TD');
		$mail->addAddress($email, $nombre);
		$mail->Subject = 'Feriados proximos a vencer';
		$mail->MsgHTML($cuerpoCorreo);
		$mail->CharSet = 'UTF-8';
		
		if(!empty($subject)){
			$mail->Subject = $subject;
		}
		return $mail->send();
	}
	
	private function formatBodyMail($personal){
		
		$cuerpo =	'<h4>Buenos días,</h4>
					<br>
					Los siguientes funcionarios disponen de feriados legales del periodo anterior:
					<br>
					';
		foreach($personal as $key => $value){
			$cuerpo .=	'<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Nombre funcionario: '.$value['nombres'].' '.$value['apellido_paterno'].' '.$value['apellido_materno'].'
						<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - RUN: '.$value['rut'].'-'.$value['digito_rut'].'
						<br>';
		}
		$cuerpo .=	'<br>
					<br>
					Instamos a que puedan hacer seguimiento de los casos para que ocupen dichos días, sino perderán el derecho a ellos.
					<br>
					Recuerde que puede consultar esta información en detalle en <A href="https://www.td.cmvalparaiso.cl">https://www.td.cmvalparaiso.cl</A> 
					<br>
					<br>
					Saludos.(Este mensaje es una notificación automatica. favor no responder el correo)
					<br>
					* Este mensaje es una notificación automatica. favor no responder el correo. 
					** Si tiene dudas respecto a la información o al funcionamiento de la plataforma registrar duda o problema en https://soporte.cmvalparaiso.cl';
		return $cuerpo;
	}
	
	private function formatBodyMail2($personal){
		
		$cuerpo =	'<h4>Estimado/da,</h4>
					<br>
					Se recuerda que tiene feriados legales del periodo anterior sin utilizar.
					<br>
					';

		$cuerpo .=	'<br>
					<br>
					Saludos.(Este mensaje es una notificación automatica. favor no responder el correo)';
		return $cuerpo;
	}
	
	private function formatBodyMailPSGS($permiso, $persona){
		
		$cuerpo =	'<h4>Estimado/da,</h4>
					<br>
					Se notifica que el centro e costo: '.$persona['centro'].', a solicitado un PSGS para.
					<br>
					<br>
					Nombres: '.$persona['nombres'].' '.$persona['apellido_paterno'].' <br>
					Rut: '.$persona['rut'].'-'.$persona['digito_rut'].'<br>
					Fecha inicio: '.$permiso['inicio'].'<br>
					Fecha termino: '.$permiso['termino'].'<br>
					<br>
					Favor ingresar a plataforma TD ( www.td.cmvalparaiso.cl ), para mayor información.
					';

		$cuerpo .=	'<br>
					<br>
					Saludos.(Este mensaje es una notificación automatica. favor no responder el correo)';
		return $cuerpo;
	}
	
	public function cargaMasiva(){
		$this->load->model('Excel_model');
		$datos = $this->Excel_model->excel();
		
		$x = 0;
		
		foreach($datos as $value){
			$this->table = 'personal';
			
			$query  = $this->get('*', array('rut' => $value['rut']));
			

			if(!empty($query)){
				
				$this->update(array('calidad' => $value['calidad']), array('rut' => $value['rut']));
				echo $value['rut']." Falta calidad <br/>";
				echo $x++;
				echo '<br/>';
				

			}	else{
				
					echo $value['rut']." No encontrado. <br/>";
					echo "<br/>";
					
				}

			echo "<br/>------------------------<br/>";
		}
	}
	
	public function updateFun(){
		$this->load->model('Excel_model');
		$datos = $this->Excel_model->excel();
		foreach($datos as $value){
			if(strcmp($value['termino_contrato'], "") == 0) $value['termino_contrato'] = "0000-00-00";

			$this->table = 'personal';
			$query  = $this->get('*', array('rut' => $value['rut']));
			$datosPersona = array();
			
			if(!empty($query)){
				$query = (array)$query[0];
				
				if(strcmp($query['termino_contrato'], "0000-00-00") == 0) $query['termino_contrato'] = "2100-01-01";
				if(strcmp($value['termino_contrato'], "0000-00-00") == 0) $value['termino_contrato'] = "2100-01-01";
				
				
				if(strtotime($value['termino_contrato']) != strtotime($query['termino_contrato'])){
					echo $value['rut'] . '<br/>';
					if(strcmp($value['termino_contrato'],$query['termino_contrato']) != 0) {

						echo 'Termino_contrato: '. $query['termino_contrato'] . '   ->   ' . $value['termino_contrato'] . '<br/>';
						if(strcmp($value['termino_contrato'], "2100-01-01") == 0) $value['termino_contrato'] = "0000-00-00";
						$this->update(array('termino_contrato' => $value['termino_contrato']), array('rut' => $value['rut']));
						$query  = $this->get('*', array('rut' => $value['rut']));
						$query = (array)$query[0];
						echo 'Termino_contrato: '. $query['termino_contrato'] . '   ->   ' . $value['termino_contrato'] . '<br/>';
					}
					echo "<br/>------------------------<br/>";
				}
			}
		}
	}
		
	public function actualizarPersonalIgestion(){
		$this->load->model('Igestion_model');
		$this->table = 'personal';
		
		$query  = $this->get('*', array());
		
		
		$countInicio = 0;
		$countTermino = 0;
		$iteraciones = 0;
		foreach($query as $key => $value){
			echo 'N: '. $value->nombres . ' ' . $value->apellido_paterno .' '. $value->apellido_materno . '| '.$value->rut. $value->digito_rut.'<br/>';
			
			if($value->rut < 10000000) $codigoPersona = '0'. $value->rut . '' .$value->digito_rut;
				else $codigoPersona =  ''. $value->rut . '' . $value->digito_rut;
			
			$funcionario = $this->Igestion_model->getVidaFuncionario($codigoPersona);
			
			if(!empty($funcionario)){
				$dataUpdate = null;
				$funcionario = $funcionario[0];
				$calidad = null;
				if($funcionario['CodigoCalidadJuridica'] == 12) $calidad = 'REEMPLAZO';
				if($funcionario['CodigoCalidadJuridica'] == 7) $calidad = 'PLAZO FIJO';
				if($funcionario['CodigoCalidadJuridica'] == 8) $calidad = 'INDEFINIDO';
				
				if(empty($funcionario['FechaTermino'])) $funcionario['FechaTermino'] = '0000-00-00';
				echo 'Calidad: ' . $calidad . '<br/>';
				echo 'termino : ' . $value->termino_contrato . ' -> ' .$funcionario['FechaTermino']. '<br/>';

				$dateTimestamp1 = strtotime($value->termino_contrato);
				$dateTimestamp2 = strtotime($funcionario['FechaTermino']);
				
				if(!empty($calidad))$dataUpdate['calidad'] = $calidad;
				
				if($dateTimestamp1 < $dateTimestamp2){
					$dataUpdate['termino_contrato'] = $funcionario['FechaTermino'];
					$countTermino++;
				} 
				if(!empty($dataUpdate)){
					echo 'SE ACTUALIZA <br/>';
					$this->update($dataUpdate, array('rut' => $value->rut));
					var_dump($dataUpdate);
				} else {
					echo 'NO SE actualiza<br/>';
				}
				
				
				
			echo 'Termino count: ' .$countTermino. '<br/>';	
			}else {
				echo 'No encontrado en Igestion <br/>';
			}
			echo '<br/><br/>';
			//
			//var_dump($value);
		}
		
		
	}
	
	public function ingresarPersonal($codigoPersona = null){
		
		if(empty($codigoPersona)) return null;
		
		$this->load->model('Igestion_model');
		$vidaFun = $this->Igestion_model->getFuncionario($codigoPersona);
		
		if(!empty($vidaFun)){

			if(empty($vidaFun[0]["FechaTermino"])) $vidaFun[0]["FechaTermino"] = '0000-00-00';
			$personal = array(
						'rut' => (int)substr($vidaFun[0]['CodigoPersona'],0,-1),
						'digito_rut' => substr($vidaFun[0]['CodigoPersona'],-1),
						'nombres' => $vidaFun[0]["Nombres"],
						'apellido_paterno' => $vidaFun[0]["ApellidoPaterno"],
						'apellido_materno' => $vidaFun[0]["ApellidoMaterno"],
						'centro' => $vidaFun[0]["CodigoCentro"],
						'cargo' => $vidaFun[0]["Cargo"],
						'categoria' => substr($vidaFun[0]["Categoria"],-1),
						'nivel' => $vidaFun[0]["CodigoNivel"],
						'calidad' => $vidaFun[0]["CalidadJuridica"]
					);
			$vidaFun = $this->Igestion_model->fechasContrato($codigoPersona);
			$personal['inicio_contrato'] = $vidaFun["inicio_contrato"];
			$personal['termino_contrato'] = $vidaFun["termino_contrato"];
			$personal['reconosimiento'] = $vidaFun["reconosimiento"];
			//var_dump($personal);
			var_dump($this->Dias_libres_model->addPersonal($personal));		

		}
	}
	
	/*CON ESTO SE ENTREGAN LOS DATOS PARA LA VISTA DEL EDITARFL EN CASO DE SER NEGATIVO SE ENTREGAN
	DATOS EXTRAS YA QUE SE DEBEN OBTENER LOS DIAS DISPONIBLES DEL AÑO PROXIMO, SE ENTREGAN LOS 
	FERIADOS NEGATIVOS PARA VERIFICAR SI EXISTE UN FERIADO NEGATIVO O NO, YA QUE SI EXISTE UNO, LOS FERIADOS
	POSITIVOS NO SE PUEDEN EDITAR HASTA QUE LLEGUE EL PROXIMO AÑO
	RETORNA UN ARREGLO ASOCIATIVO CON LA DATA REQUERIDA PARA LA VISTA*/
	public function dataForUpdateFL($rut,$negativo){
		$this->table = 'personal';
		$persona  = (array)$this->get('*', array('rut' => $rut))[0];

		$periodo;
		
		if($negativo == 0){
			$periodos = $this->getPeriodosActivos($rut);
			$diasDisponibles = 0;
			
			foreach($periodos as $periodo){
				$diasDisponibles += (int)$periodo->disponible;
			}
			$periodo = array('disponibles' => $diasDisponibles,'detalle' => $periodos);
		}else{
			$proximoPeriodo = $this->calcularPeriodo($persona['reconosimiento'], date('Y') + 1);
			$disponibles = $proximoPeriodo['total'] - $this->calcularFeriadosNegativos($rut);
			$periodo = array('disponibles' => $disponibles,'detalle' => null);
		}
		
		/*formato xx.xxx.xxx-d para rut y (n ap am) para nombre*/
		preg_match("/(\d{3})(\d{3})(\d{2})/",strrev($rut),$matches, PREG_OFFSET_CAPTURE, 0);
		$rut_comp = join("",array(strrev($matches[3][0]),".",strrev($matches[2][0]),".",strrev($matches[1][0]),"-",$persona['digito_rut']));
		$nombre   = join("",array($persona['nombres']," ",$persona['apellido_paterno']," ",$persona['apellido_materno']));
		
		if($this->calcularFeriadosNegativos($rut) != 0){
			$disponibles  = $this->calcularFeriadosNegativos($rut)*-1;
		}else{
			$disponibles = $diasDisponibles;
		}
		
		$datos = array(
				'periodos'    => $periodo,
				'rut'         => $rut_comp,
				'nombre'      => $nombre,
				'disponibles' => $disponibles,
				'negativos'   => $this->calcularFeriadosNegativos($rut)*-1,
			);
		
		return $datos;
	}
	
	/*LA DATA CONTIENE EL ID DEL FL, RUT DE QUIEN ES EL FL Y LA CANTIDAD DE DIAS HABILES QUE TENIA ANTES DE
	REALIZAR EL CAMBIO EN LA VISTA, LOS PERIODOS SON LOS PERIODOS DE LA PERSONA, EL RETORNO DEPENDE DE 
	DESCONTARFL*/
	public function updateFL($data,$periodos){
	
		$id  = $data['id'];
		$rut = $data['rut'];
		$hab_ant = $data['diasHabIni'];
		$cont = 0;
		
		$data_FL = array(
				'inicio'  => $data['inicio'],
				'termino' => $data['termino']
			);

		if($periodos == null){
			$this->db->where('id', $id);
			$this->db->update('feriados_legales', $data_FL);
			return true;
		}else{
			$dias = $this->Dias_libres_model->contarDHabiles($data['inicio'], $data['termino']);

			$periodos = array_reverse($periodos);
			$suma_d   = 0;
		
			#los dias anteriores a la actualización deben ser sumados para aplicar el nuevo periodo
			foreach($periodos as $periodo){
				$suma_d = $periodo->disponible+$hab_ant;
				if($periodo->total < $suma_d){
					$hab_ant = $suma_d - $periodo->total;
					$periodo->disponible = $periodo->total;
				}else {
					$periodo->disponible = $suma_d;
					$hab_ant = 0;
				}
			}
			
			$periodos = array_reverse($periodos);
			if($this->Dias_libres_model->descontarFL($rut,$dias,$periodos)){
				$this->db->where('id', $id);
				$this->db->update('feriados_legales', $data_FL);
				return true;
			}else return false;
		}
	}
	
	//Esta funcion recibe un arreglo de data de un funcionario para su insercion en la BD
	//Toma en consideracion la editada del rut en el caso de que se necesite editar este
	public function updatePersonal($data){
		$rut_inicial = $data['rut_inicial'];
		$codigo = (explode(" ",$data['centro']));	//Se consigue el codigo del centro en el formato correcto
		
		$data_Personal = array(
				'rut' => $data['rut'],
				'digito_rut' => $data['digito_rut'],
				'nombres' => $data['nombres'],
				'apellido_paterno' => $data['apellido_paterno'],
				'apellido_materno'  => $data['apellido_materno'],
				'correo' => $data['correo'],
				'reconosimiento' => $data['reconosimiento'],
				'inicio_contrato' => $data['inicio_contrato'],
				'termino_contrato' => $data['termino_contrato'],
				'cargo' => $data['cargo'],
				'categoria' => $data['categoria'],
				'calidad' => $data['contrato'],
				'nivel' => $data['nivel'],
				'centro' => $codigo[0]
				
			);
			
		$this->db->where('rut', $rut_inicial);
		$this->db->update('personal', $data_Personal);
		return true;
	}
	
	//Ingresa un funcionario, primero lo agrega a la tabla personal. y despues calcula y agrega su periodo para los feriados legales
    public function addPersonal($personal){
   		$codigo = (explode(" ",$personal['centro']));
   		$personal['centro'] = $codigo[0];
   		$this->table = 'personal';
   		if($this->add($personal)){
   			return $this->agregarPeriodo($personal['rut'], $personal['reconosimiento']);
   		}else{
	   		echo $this->db->error();
	    	return false;
    	}	
    }
    
    //Entrega el nombre del centro en base a un codigo recibido
	public function getNombreCentro($codigo){
		$nombreCentro='';
		$centros = $this->ProcessMaker_model->getEstablecimiento();
		$wantedCode = (explode(" ",$codigo));

		for ($i = 0; $i < sizeof($centros); $i++) {
			foreach($centros[$i] as $key => $value){
				if($key == 'codigo' && $value == $wantedCode[0]){
					$nombreCentro = $centros[$i]['nombre'];
					}
				}
			}
		
		return $nombreCentro;
	}
	
	/*ENTREGA UN ARREGLO ASOCIATIVO CON [RUT=>[id's]] DEPENDIENDO DE QUE SE INGRESE COMO TIPO
	"da" o "fl"*/
	public function getIDs($tipo){
		if($tipo == "da") $this->table = 'dias_administrativos';
		else $this->table = 'feriados_legales';
    	$datosBD = (array)$this->get('rut,id',array(),array(),array(),'id DESC',true);
    	$datos = array();
		foreach($datosBD as $val){
			$datos[$val['rut']][] = $val['id'];
		}
    
    	return $datos;
	}
	

}