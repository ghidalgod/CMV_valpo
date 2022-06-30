<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Cron extends CI_Controller
{
	//Clase que en coordinación con el coordinador de tareas programadas(cron), como cromtab(linux), ejecuta las funciones dependiende
	//de la regla previamente definida, esta puede ser diaria, semanal, semestral o anual.
	//Primera iteración, se usara comando curl
	//				Ej: curl "https://www.cmvalparaiso.cl/td/index.php/Cron/dlDiario" >/dev/null 2>&1
	//Segunda iteración, que se ejecute un scrip que ejecute la función por interprete PHP. De esta forma no tiene que pasar por dns como usando comando curl.
	//Otra ventaja es que esto se puede manejar facilmente de forma local y no exponer las funciónes a la red publica.
	public function __construct(){
		parent::__construct();
		//$this->load->model('Igestion_model');
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index(){

	}
	/////////////////////////////////////////   Dias libres ////////////////////////////////////
	/*
	public function dlDiario($key = null){
		if($key == null || $key != 2983740192837492) return 0;
		//Se ejecuta todos los dias a las 00:00, comprueba si algun funcionario cumple con el año de antiguedad y se le asigna un nuevo periodo de feriados legales
		$this->load->model('Dias_libres_model');
		$this->Dias_libres_model->primerPeriodo();
	}
	
	public function dlAnual($key = null){
		if($key == null || $key != 22974619172344521) return 0;
		//Se ejecuta a inicio del año. Asigna el nuevo periodo por el cambio de año a los funcionarios que cumplan mas de 2 años de antiguedad
		$this->load->model('Dias_libres_model');
		$this->Dias_libres_model->periodoCambioAño();
	}
	
	public function dlAlertaSemestral($key = null){
		return 0;
		if($key == null || $key != 44827659276558301) return 0;
		//Se ejecuta al inicio del segundo semestre(01/07/xxxx), notifica al encargado los funcionarios que aun mantienen feriados disponibles del periodo anterior
		$this->load->model('Dias_libres_model');
		$this->Dias_libres_model->notificarVencimientoPeriodo();
	}
	/////////////////////////////////////////   Dias libres ////////////////////////////////////
	*/
	/*
	public function igestion($key = null){
		if($key == null || $key != 2983740192837492) return 0;
		echo json_encode($this->Igestion_model->getFuncionarios(array(array('codigo' => 'Y810'))));
		 
	}
	
	public function igestion2($key = null, $CodigoPersona = null){
		if($key == null || $key != 2983740192837492) return 0;
		echo json_encode($this->Igestion_model->getVidaFuncionario($CodigoPersona));
		
	}
	*/
}
