<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class FiscalSumario_model extends General_model {
	public function __construct() {
		$table = 'fiscal_sumario';
        parent::__construct($table);
    }
         
    public function getUsuarios(){              //para obtener lista de fiscales
        $this->db->select("*");
    	$this->db->from('fiscal_sumario'); 
    }

    public function getMail($id = null) {
        $this->db->from('fiscal_sumario');
        $this->db->where('fiscal_sumario.id_fiscal',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = [$data['email'], $data['nombre_fiscal']];
        }
        return $values;
    }   

    
    public function getAsignado($rut_fiscal=null){
        $query = $this->db->query('SELECT * FROM fiscal_sumario WHERE fiscal_sumario.rut_fiscal = '.$rut_fiscal);
        foreach($query->result() as $value){
            $asignado = $value->rut_fiscal;
        }
        return $asignado;
    }

    
 

    public function getName($id = null){  //nombre y apellido de abogados

        $query = $this->db->query('SELECT fiscal_sumario.nombre_fiscal,fiscal_sumario.apellido_fiscal FROM fiscal_sumario WHERE fiscal_sumario.id_fiscal = '.$id);
        foreach($query->result() as $value){
            $data['nombre_fiscal'] = $value->nombre_fiscal;
            $data['apellido_fiscal'] = $value->apellido_fiscal;
        }
        return $data;
        
    }
 
 }