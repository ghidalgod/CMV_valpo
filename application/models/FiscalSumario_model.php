<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class FiscalSumario_model extends General_model {
	public function __construct() {
		$table = 'fiscal_sumario';
        parent::__construct($table);
    }

    public function getUsuarios(){              //funcion para obtener usuarios que van a ser asignados.
    $query = $this->db->query('SELECT * FROM abogados');
    $data = $query->result();
    return $data;
}
     
    public function getName($id){
        $query = $this->db->query('SELECT abogados.first_name,abogados.last_name FROM abogados WHERE abogados.id = '.$id);
        foreach($query->result() as $value){
            $data['nombre_asignado'] = $value->first_name;
            $data['apellido_asignado'] = $value->last_name;
        }
        return $data;
    }
    
 
 }