<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Reglamentos_model extends General_model {
	public function __construct() {
		$table = 'reglamentos';
        parent::__construct($table);
    }

    public function getreglamentos() {
    	$primaryKey = 'id';
    	$table = 'reglamentos';
    	$whereResult = null;
		$columns = array(
			array( 'db' => 'id', 'dt' => 'id' ),
			array( 'db' => 'nombre', 'dt' => 'nombre' ),
			array( 'db' => 'tipo', 'dt' => 'tipo' ),
			array( 'db' => 'descripcion', 'dt' => 'descripcion' ),
			array( 'db' => 'codigo', 'dt' => 'codigo' ),
		);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult);
        return $data;
    }
    public function getcode($id){
    	$this->db->from('reglamentos');
        $this->db->where('reglamentos.id',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = $data['codigo'];
        }
        return $values;
    }
    
    public function addinstr($data){
    	$this->db->insert('reglamentos', $data);
    }
    
    public function delold($id){
    	$this->db->query("DELETE FROM reglamentos WHERE id='$id';");
    }
}