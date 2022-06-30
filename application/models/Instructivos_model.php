<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Instructivos_model extends General_model {
	public function __construct() {
		$table = 'instructivos';
        parent::__construct($table);
    }

    public function getinstructivos() {
    	$primaryKey = 'id';
    	$table = 'instructivos';
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
    	$this->db->from('instructivos');
        $this->db->where('instructivos.id',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = $data['codigo'];
        }
        return $values;
    }
    
    public function addinstr($data){
    	$this->db->insert('instructivos', $data);
    }
    
    public function delold($id){
    	$this->db->query("DELETE FROM instructivos WHERE id='$id';");
    }
}