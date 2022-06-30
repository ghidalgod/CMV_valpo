<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Liquidaciones extends CI_Controller {

    public function __construct(){
		parent::__construct();
		
		if (!$this->session->userdata("login_google")) redirect('Inicio', 'location', 301);
		
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('number');
		
		$this->load->model('Funcionarios_model');
	
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Inicio',
											'link' =>  site_url('inicio/index')
										),
									);
    }

	public function index()	{
		$this->data['menu_items'] = array('remuneraciones', 'liquidaciones');
		$this->data['breadcrumb'][] = 	array(
											'name' => 'Liquidaciones de sueldo',
											'link' =>  ''
										);

		$this->data['title'] = 'Remuneraciones';
		$this->data['subtitle'] = 'Liquidaciones de sueldo';

		$this->data['meses'] = $this->getMeses();
		$this->data['anios'] = $this->getAnios();
		$this->data['mesDesde'] = "id=mesDesde";
		$this->data['mesHasta'] = "id=mesHasta";
		$this->data['anioDesde'] = "id=anioDesde";
		$this->data['anioHasta'] = "id=anioHasta";
		
		$this->view_handler->view('funcionario', 'liquidaciones', $this->data);
	}

	private function getMeses() {
		$meses = array(
	        1 => 'ENERO',
	        2 => 'FEBRERO',
	        3 => 'MARZO',
	        4 => 'ABRIL',
	        5 => 'MAYO',
	        6 => 'JUNIO',
	        7 => 'JULIO',
	        8 => 'AGOSTO',
	        9 => 'SEPTIEMBRE',
	        10 => 'OCTUBRE',
	        11 => 'NOVIEMBRE',
	        12 => 'DICIEMBRE'
		);
		
		return $meses;
	}
	
	private function getAnios() {
		$anioDesde = 2019;
		$anioHasta = (int) date("Y");
		$anios = [];
		
		for ($i = $anioDesde; $i <= $anioHasta; $i++) {
			$anios[$i] = $i;
		}
		
		return $anios;	
	}

	private function getPeriodos($mesDesde, $mesHasta, $anioDesde, $anioHasta) {		
		$fechas = [];
		$x = 0;

		$fechaDesde = new DateTime();
		$fechaHasta = new DateTime();
		$fechaDesde->setDate($anioDesde, $mesDesde, 1);
		$fechaHasta->setDate($anioHasta, $mesHasta, 1);
		
		if ($fechaDesde > $fechaHasta) {
			return false;
		}
		
		while ($fechaDesde <= $fechaHasta) {
			$anio = $fechaDesde->format("Y");
			$mes = (int) $fechaDesde->format("m");
			$fechas[$x] = ["Año = $anio", "Mes = $mes"];
			$fechaDesde->add(new DateInterval("P1M"));
			$x++;
		}

		return $fechas;
	}
	
	private function getFechaContratoLiquidacion($rut) {
		$fechas = $this->Funcionarios_model->getFechasVidaFuncionaria($rut);
		$fechaContrato = $fechas[0]->FechaInicio;
		
		for ($i = 0; $i < count($fechas); $i++) {
		    if ($i === count($fechas) - 1) {
		    	break;
		    }
		    
		    $fechaTermino = date("d-m-Y", strtotime($fechas[$i]->FechaTermino."+ 1 days"));
		    $fechaInicio = date("d-m-Y", strtotime($fechas[$i+1]->FechaInicio));
		    
		    if ($fechaTermino !== $fechaInicio) {
		    	$fechaContrato = $fechas[$i+1]->FechaInicio;
		    }
		}
		
		return date("d/m/Y", strtotime($fechaContrato));
	}
	
	//Se utiliza para que las tablas de haberes y descuentos tengan el mismo tamaño, los espacios vacios de compensan con etiquetas <br>
	private function compensarHaberesDescuentos($haberes, $descuentos) {
		$diferencia = count($descuentos) - count($haberes);

		if ($diferencia > 0) {
		    for ($i = 0; $i < $diferencia; $i++) {
		        $haberes[] = (Object) ["Nombre" => "", "ValorCalculado" => "<br>"];
		    }
		} else {
		    $diferencia *= -1;
		    for ($i = 0; $i < $diferencia; $i++) {
		        $descuentos[] = (Object) ["Nombre" => "", "ValorCalculado" => "<br>"];
		    }
		}
		
		$conceptos = [
			"haberes" => $haberes,
			"descuentos" => $descuentos
		];
		
		return $conceptos;
	}
	
	private function formatearMontos($conceptos) {
		foreach ($conceptos as &$concepto) {
			$concepto->ValorCalculado = number_format((float) $concepto->ValorCalculado, 0, '', '.');
		}
		
		return $conceptos;
	}
	
	//Sirve para separar lo haberes de descuentos y estructurarlos de tal forma que queden Año -> Mes -> Datos
	private function ajustarArreglo($conceptos, $tipo) {
		$nuevoArray = [];
		
		foreach ($conceptos as $concepto) {
			if ($concepto->HaberDescuento === $tipo) {
				if ($tipo === "Haber" && (int) $concepto->HaberDescuento !== 0) {
					$nuevoArray[$concepto->Año][(int) $concepto->Mes][] = $concepto;	
				} else {
					$nuevoArray[$concepto->Año][(int) $concepto->Mes][] = $concepto;
				}
			}
		}
		
		return $nuevoArray;
	}
	
	//Elimina haberes en 0
	private function limpiarHaberes($conceptos) {
		foreach ($conceptos as $clave => $valor ) {
			if ((int) $valor->ValorCalculado === 0 && $valor->HaberDescuento === "Haber") {
				unset($conceptos[$clave]);
			}
		}
		return $conceptos;
	}
	
	private function getTipoPago($tipoPago) {
		switch ($tipoPago) {
		    case 'B':
		        return "VALOR DEPOSITADO TRANSFERENCIA ELECTRÓNICA";
		        break;
		    case 'C':
		        return "VALOR PAGADO EN CHEQUE";
		        break;
		    case 'E':
		        return "VALOR PAGADO EN EFECTIVO";
		        break;
		    default:
		    	return "INFORMACIÓN NO DISPONIBLE";
		}
	}
	
	public function emisionLiquidaciones(){
		require_once APPPATH . 'libraries/vendor/autoload.php';
		require_once("files/funcionario/liquidaciones/liquidacion.php");
		date_default_timezone_set("America/Santiago");

		$mpdf = new \Mpdf\Mpdf(['tempDir' => 'files/funcionario/temp', 'format' => 'Legal']);

	    $mpdf->setDisplayMode('fullpage');
	    
		$rut = "189034377";
		$mesDesde = $this->input->post("mesDesde");
		$mesHasta = $this->input->post("mesHasta");
		$anioDesde = $this->input->post("anioDesde");
		$anioHasta = $this->input->post("anioHasta");
		$fechas = $this->getPeriodos($mesDesde, $mesHasta, $anioDesde, $anioHasta);
		
		if ($fechas === false) {
			echo "ERROR: La fecha de inicio debe ser menor a la de término";
			return;
		}
		
		$data = $this->Funcionarios_model->getDatosLiquidacionAdministracion($rut, $fechas);
		
		if (empty($data)) {
			echo "ERROR: No existe información del período solicitado";
			return;
		}
		
		if($data) {
			$fechaContrato = $this->getFechaContratoLiquidacion($rut);
			$rut = $data[0]->CodigoPersona;
			$rutFormateado = substr($rut, 0, 2) . "." . substr($rut, 2, 3) . "." . substr($rut, 5, 3) . "-" . substr($rut, -1);
			$conceptos = $this->Funcionarios_model->getConceptosLiquidacionAdministracion($rut, $fechas);
			
			$conceptos = $this->formatearMontos($conceptos);
			$conceptos = $this->limpiarHaberes($conceptos);
			$haberes = $this->ajustarArreglo($conceptos, "Haber");
			$descuentos = $this->ajustarArreglo($conceptos, "Descuento");
			
			foreach ($data as $value) {
				$value->TipoPago = $this->getTipoPago($value->TipoPago);
				$value->TotalHaberes = number_format((float) $value->TotalHaberes, 0, '', '.');
				$value->TotalDescuentosLegales = number_format((float) $value->TotalDescuentosLegales, 0, '', '.');
				$value->TotalDescuentosVarios = number_format((float) $value->TotalDescuentosVarios, 0, '', '.');
				$value->TotalDescuentos = number_format((float) $value->TotalDescuentos, 0, '', '.');
				$value->TotalImponible = number_format((float) $value->TotalImponible, 0, '', '.');
				$value->LiquidoAPagar = number_format((float) $value->LiquidoAPagar, 0, '', '.');
				$mesNumero = (int) $value->Mes;
				
				$haberesDescuentos = $this->compensarHaberesDescuentos($haberes[$value->Año][$mesNumero], $descuentos[$value->Año][$mesNumero]);

				$value->Mes = $this->getMeses()[(int) $value->Mes];
				
				$html = getPlantilla($value, $rutFormateado, $fechaContrato, $haberesDescuentos["haberes"], $haberesDescuentos["descuentos"]);
			    $estilos = file_get_contents('files/funcionario/liquidaciones/style.css');
	
				$mpdf->addPage();
			    $mpdf->WriteHTML($estilos,1);
			    $mpdf->WriteHTML($html,2);
			    
			    $mesConCero = sprintf("%02d", $value->Mes);
	    	    $footer = "
				<table id='footer'>
					<tr>
						<td align=\"left\">$rut$value->Año$mesConCero</td>
						<td align=\"right\">Nro {PAGENO}</td>
					</tr>
				</table>";
				$mpdf->setFooter($footer);			    
			}
			
		    ob_clean();
	    
	    	$mpdf->Output();
	    	
		}
	}
}