<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio_model extends General_model {
	public function __construct() {
		$table = 'resumen_inicio';
        parent::__construct($table);
    }

	public function getResumen(){
		
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
		
		$codigosCentros = '';
		
		if(!empty($codigos)){
			foreach($codigos as $key => $value){
    				$codigosCentros .= $value['codigo']." / ";
	    		}
	    	$codigosCentros = substr($codigosCentros,0,-2);
		} else $codigosCentros = "Administración general";
		
		$this->db->select('*');
		$this->db->from($this->table);
    	if(!empty($whereResult)) $this->db->where($whereResult);
		$data = $this->db->get()->result_array();
		
		$resumen = array(
			'activos' => 0,
			'precentes' => 0,
			'ausentes' => 0,
			'feriados' => 0,
			'administrativos' => 0,
			'licencias' => 0,
			'otros' => 0,
			'plantas' => 0,
			'reemplazos' => 0,
			'contratos' => 0,
			);
			
		foreach($data as $value){
			$resumen['plantas'] += $value['plantas'];
			$resumen['contratos'] += $value['contratos'];
			$resumen['reemplazos'] += $value['reemplazos'];
			$resumen['feriados'] += $value['feriados'];
			$resumen['administrativos'] += $value['administrativos'];
			$resumen['licencias'] += $value['licencias'];
			$resumen['otros'] += $value['otros'];
		}
		
		$resumen['activos'] += $resumen['plantas'] + $resumen['contratos'] + $resumen['reemplazos'];
		$resumen['ausentes'] += $resumen['otros'] + $resumen['licencias'] + $resumen['administrativos'] + $resumen['feriados'];
		$resumen['precentes'] += $resumen['activos'] - $resumen['ausentes'];
		$resumen['centros'] = $codigosCentros;
		
		return $resumen;
	}
	
	#Con esto se crea un archivo para guardar la tabla que se mostrara con los feriados
	#se genera la tabla y luego se escribe dentro de un txt para luego ser leido sin hacer la consulta a la api
	#retorna una tabla HTML
	private function dateData(){
		$this->load->helper("file");
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://apis.digital.gob.cl/fl/feriados/".date("Y"),
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache"
		  ),
		));
		
		$response = utf8_encode(curl_exec($curl));
		$err = curl_error($curl);
		$response = json_decode($response, true);
		
		curl_close($curl);
		
		$thead = '<thead>
		    <tr>
		    	<th scope="col">Nombre</th>
				<th scope="col">Fecha</th>
		    	<th scope="col">Irrenunciable</th>
		    </tr>
		  </thead>';
		$tbody = "<tbody>";
		
		setlocale(LC_TIME,"es_CL","esp");
		foreach($response as $fecha => $val){
			if($val['irrenunciable'] == 1){
				$val['irrenunciable'] = "Si";
			}else{
				$val['irrenunciable'] = "No";
			}
			
			$tbody = $tbody."<tr id='fechas'>"."<td>".$val['nombre']."</td>"."<td>".iconv('ISO-8859-2', 'UTF-8', strftime("%A %d de %B",strtotime($val['fecha'])))."</td>"."<td>".$val['irrenunciable']."</td>"."</tr>";
			
		}
		$tbody = $tbody."</tbody>";
		
		$response = $thead.$tbody;
		
		delete_files("./files/feriados/", true, false);
		
		$myfile = fopen("./files/feriados/".date("Y").".txt", "w") or die("Unable to open file!");
		fwrite($myfile, $response);
		fclose($myfile);
		
		return $response;
	}
	
	/*FUNCION QUE COMPRUEBA SI EL ARCHIVO EN FILES/FERIADOS CREADO POR dateData EXISTE O NO
	EN CASO DE NO EXISTIR SE EJECUTA dateData Y SE ENTREGAN LOS FERIADOS DEL AÑO, DE LO
	CONTRARIO SOLO SE LEE EL ARCHIVO CON LOS FERIADOS COMO LISTA DE HTML*/
	public function verifyDatesFile(){
		$path = "./files/feriados/";
		$file = "./files/feriados/".date("Y").".txt";
		if (!is_dir($path)){
    		mkdir($path, 0755, TRUE);
    	}
		if(file_exists($file)){
			$fechas = fopen($file, "r") or die("Unable to open file!");
			$datos = fread($fechas,filesize($file));
			fclose($fechas);
			return $datos;
		}else{
			$datos = $this->dateData();
			return $datos;
		}
	}
}