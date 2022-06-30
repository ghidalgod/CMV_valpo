<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Actividad1d_model extends General_model {
	public function __construct() {
		$table = 'juridica_actividad1';
        parent::__construct($table);
    }
    
    public function updateAsignado($id, $value){
        $this->db->query("UPDATE juridica_actividad1 SET asignado='$value' WHERE id= $id;");
    }

    public function bombero($id = null) {
        $this->db->from('juridica_actividad1');
        $this->db->where('juridica_actividad1.id_procedimientos',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = [$data['id_procedimientos'],$data['ingreso'],$data['integrantes'],$data['habitaciones'],$data['servicios'],$data['RAE'],$data['preferente'],$data['prioritario']];
        }
        return $values;
    }
}