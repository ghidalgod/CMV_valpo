<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KpiProcess extends MY_Controller {

    public function __construct(){
		parent::__construct();
	    $this->ion_auth->redirectLoginIn();
		$this->load->model('ProcessMaker_model');
	    $this->data['breadcrumb'] = array(
								    	array(
											'name' => 'Inicio',
											'link' =>  site_url('inicio/index')
										),
									);
    }

	public function index()	{
		$this->data['menu_items'] = array(
										'kpi',
										'educacion'
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'KPI: Reemplazos Educación',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'Datos Estadisticos';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Proceso de reemplazo educación';
		// Llamada a constructor de vista
		
		echo 'Aca no hay nada.';
	}
	
	public function personalEducacion(){
		if($this->session->flashdata('preloader') !== TRUE) {$this->preloader("KpiProcess/personalEducacion"); return;}
	    $group = array('bpkpi');
		if(!$this->ion_auth->in_group($group)) redirect('Inicio', 'location', 301);
		
		function compare_date_keys($dt1, $dt2) {
		    $tm1 = strtotime($dt1);
		   	$tm2 = strtotime($dt2);
		    return ($tm1 < $tm2) ? -1 : (($tm1 > $tm2) ? 1 : 0);
		}
		
		$this->data['menu_items'] = array(
										'educacion',
										'personal',
										'kpi'
									);
		$this->data['breadcrumb'][] = 	array(
											'name' => 'KPI: Personal Educación',
											'link' =>  ''
										);
		// Título del contenido
		$this->data['title'] = 'Datos Historicos';
		// Subtítulo del contenido
		$this->data['subtitle'] = 'Procesos de personal educación';
		// Llamada a constructor de vista

		//REEMPLAZOS
		$dato = $this->ProcessMaker_model->getAllDelegate('5523126275c45deb1bbf7e3078315074');
		$fechas = array();
		foreach($dato as $key => $value){
			empty($value['DEL_FINISH_DATE']) ? $finish = date('Y-m-d') : $finish = $value['DEL_FINISH_DATE'];
			while($value['DEL_DELEGATE_DATE'] <= $finish){
				if(isset($fechas[date('d-m-Y', strtotime($value['DEL_DELEGATE_DATE']))][$value['TAS_UID']])) $fechas[date('d-m-Y', strtotime($value['DEL_DELEGATE_DATE']))][$value['TAS_UID']] += 1;
					else $fechas[date('d-m-Y', strtotime($value['DEL_DELEGATE_DATE']))][$value['TAS_UID']] = 1;
				$value['DEL_DELEGATE_DATE'] = date('Y-m-d', strtotime($value['DEL_DELEGATE_DATE']. ' + 1 days'));
			}
		}
		uksort($fechas, "compare_date_keys");
		$this->data['kpi'] = $fechas;
		
		//PRORROGAS
		$dato = $this->ProcessMaker_model->getAllDelegate('9241604965cc1b6b665afe9040611591');
		$fechas = array();
		foreach($dato as $key => $value){
			empty($value['DEL_FINISH_DATE']) ? $finish = date('Y-m-d') : $finish = $value['DEL_FINISH_DATE'];
			while($value['DEL_DELEGATE_DATE'] <= $finish){
				if(isset($fechas[date('d-m-Y', strtotime($value['DEL_DELEGATE_DATE']))][$value['TAS_UID']])) $fechas[date('d-m-Y', strtotime($value['DEL_DELEGATE_DATE']))][$value['TAS_UID']] += 1;
					else $fechas[date('d-m-Y', strtotime($value['DEL_DELEGATE_DATE']))][$value['TAS_UID']] = 1;
				$value['DEL_DELEGATE_DATE'] = date('Y-m-d', strtotime($value['DEL_DELEGATE_DATE']. ' + 1 days'));
			}
		}
		uksort($fechas, "compare_date_keys");
		$this->data['kpi2'] = $fechas;
		
		//AMPLIACION
		$dato = $this->ProcessMaker_model->getAllDelegate('7838015715cf14e3aa017f4010542138');
		$fechas = array();
		foreach($dato as $key => $value){
			empty($value['DEL_FINISH_DATE']) ? $finish = date('Y-m-d') : $finish = $value['DEL_FINISH_DATE'];
			while($value['DEL_DELEGATE_DATE'] <= $finish){
				if(isset($fechas[date('d-m-Y', strtotime($value['DEL_DELEGATE_DATE']))][$value['TAS_UID']])) $fechas[date('d-m-Y', strtotime($value['DEL_DELEGATE_DATE']))][$value['TAS_UID']] += 1;
					else $fechas[date('d-m-Y', strtotime($value['DEL_DELEGATE_DATE']))][$value['TAS_UID']] = 1;
				$value['DEL_DELEGATE_DATE'] = date('Y-m-d', strtotime($value['DEL_DELEGATE_DATE']. ' + 1 days'));
			}
		}
		uksort($fechas, "compare_date_keys");
		$this->data['kpi3'] = $fechas;
		
		$this->view_handler->view('kpiprocess', 'educacion/personal', $this->data);
	}
}