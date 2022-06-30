<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Igestion_model extends General_model {
	public function __construct() {
		$table = 'td_view_funcionarios';
		$dbProcess = $this->load->database('iGestion', TRUE);
        parent::__construct($table, $dbProcess);
    }
    
    public function getTest(){
    	
    	$group = array('bpfiltroscentros');
		if($this->ion_auth->in_group($group)) {
    		$codigos = $this->ion_auth->getCodigosIgestion();
    		if(empty($codigos)){
				$whereResult = null;
    		}	else {
    				$whereResult = "(";
	    			foreach($codigos as $key => $value){
	    				$whereResult .= "CodigoCentro = '".$value['codigo']."' OR ";
		    		}
		    		$whereResult = substr($whereResult, 0, -3). ")";
    			}
    	}
    	
    	$this->db->select('*');
    	$this->db->from('td_view_funcionarios');
    	if(!empty($whereResult)) $this->db->where($whereResult);
    	
    	$query = $this->db->get();
		$user = $query->result_array();
		return $user;
		
		/*
    	$this->load->database('iGestion', FALSE, TRUE);
    	
    	
    	$this->db->close();
    	*/
    }
    
    public function getFuncionarios( $codigos = null ){
    	
    	if(empty($codigos)){
				$whereResult = null;
    		}	else {
    				$whereResult = "(";
	    			foreach($codigos as $key => $value){
	    				$whereResult .= "CodigoCentro = '".$value['codigo']."' OR ";
		    		}
		    		$whereResult = substr($whereResult, 0, -3). ")";
    			}
    	
    	$this->db->select('*');
    	$this->db->from('td_view_funcionarios');
    	if(!empty($whereResult)) $this->db->where($whereResult);
    	
    	$query = $this->db->get();
		$user = $query->result_array();
		return $user;
		
		/*
    	$this->load->database('iGestion', FALSE, TRUE);
    	
    	
    	$this->db->close();
    	*/
    }
    
    public function getFuncionario( $codigoPersona = null ){
    	if(empty($codigoPersona)) return null;

    	$this->db->select('*');
    	$this->db->from('td_view_historico');
    	$this->db->where("codigoPersona = '".$codigoPersona."'");
    	$query = $this->db->get();
		$user = $query->result_array();
		return $user;
		
		/*
    	$this->load->database('iGestion', FALSE, TRUE);
    	
    	
    	$this->db->close();
    	*/
    }
    
    public function getVidaFuncionario( $CodigoPersona = null ){
    	
    	$this->db->select('*');
    	$this->db->from('TVidaFuncionaria');
    	if(!empty($CodigoPersona)) {
    		$this->db->where("CodigoPersona = '".$CodigoPersona."'");
			$query = $this->db->get();
			$row = $query->result_array();
			
			if(empty($row)) return null;
			
			$fechaMenor = null;
			$idRowFechaMenor = 0;
			foreach($row as $key => $value){
				if(empty($fechaMenor)){
					$idRowFechaMenor = $key;
					$fechaMenor = $value['FechaInicio'];
				} else {
					$dateTimestamp1 = strtotime($fechaMenor);
					$dateTimestamp2 = strtotime($value['FechaInicio']);
					if($dateTimestamp1 < $dateTimestamp2){
						$idRowFechaMenor = $key;
						$fechaMenor = $value['FechaInicio'];
					}
				}
				
			}
			return array($row[$idRowFechaMenor]);
    	} else {
    		return null;
    	}
    }
    
    public function fechasContrato($CodigoPersona = null){
    	$this->db->select('*');
    	$this->db->from('TVidaFuncionaria');
    	$fechasContrato = array();
    	if(!empty($CodigoPersona)) {
    		$this->db->where("CodigoPersona = '".$CodigoPersona."'");
			$query = $this->db->get();
			$row = $query->result_array();
			
			if(empty($row)) return null;
			
			
			$fechaMenor = null;
			foreach($row as $key => $value){
				if(empty($fechaMenor)){
					$fechaMenor = $value['FechaInicio'];
				} else {
					$dateTimestamp1 = strtotime($fechaMenor);
					$dateTimestamp2 = strtotime($value['FechaInicio']);
					if($dateTimestamp1 > $dateTimestamp2){
						$fechaMenor = $value['FechaInicio'];
					}
				}
				
			}
			
			$fechaMayor = null;
			foreach($row as $key => $value){
				if(empty($fechaMayor)){
					$fechaMayor = $value['FechaTermino'];
				} else {
					$dateTimestamp1 = strtotime($fechaMayor);
					$dateTimestamp2 = strtotime($value['FechaTermino']);
					if($dateTimestamp1 < $dateTimestamp2){
						$fechaMayor = $value['FechaTermino'];
					}
				}
				
			}
			
			
			$fechasContrato['inicio_contrato'] = $fechaMenor;
			$fechasContrato['reconosimiento'] = $fechaMenor;
			$fechasContrato['termino_contrato'] = $fechaMayor;
			
			return $fechasContrato;

    	} else {
    		return null;
    	}
    		
    }

}