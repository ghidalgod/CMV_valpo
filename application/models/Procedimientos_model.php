<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Procedimientos_model extends General_model {
	public function __construct() {
		$table = 'juridica_procedimientos';
        parent::__construct($table);
    }

    public function datatable($id_caso = null) {
    	$table = 'juridica_procedimientos';
    	$primaryKey = 'id';
    	$whereResult = null;
    	$whereAll = "id_caso = $id_caso AND estado = 'FINALIZADO'";
		$columns = array(
			array( 'db' => 'id', 'dt' => 'id' ),
			array( 'db' => 'id_caso', 'dt' => 'id_caso' ),
            array( 'db' => 'estado', 'dt' => 'estado' ),
			array( 'db' => 'fecha', 'dt' => 'fecha' )
		);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll);
        return $data;
    }

    
    public function bombero($id = null) {
        $this->db->from('juridica_procedimientos');
        $this->db->where('juridica_procedimientos.id_caso',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = $data['id'];
        }
        return $values;
    }
}