<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Anexos_model extends General_model {
	public function __construct() {
		$table = 'anexos';
        parent::__construct($table);
    }

    public function getanexos() {
    	$primaryKey = 'id';
    	$table = 'anexos';
    	$whereResult = null;
		$columns = array(
			array( 'db' => 'id', 'dt' => 'id' ),
			array( 'db' => 'anexo', 'dt' => 'anexo' ),
			array( 'db' => 'nombre', 'dt' => 'nombre' ),
			array( 'db' => 'cargo', 'dt' => 'cargo' ),
			array( 'db' => 'departamento', 'dt' => 'departamento' ),
			array( 'db' => 'email', 'dt' => 'email' ),
		);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult);
        return $data;
    }
    
    public function addnexo($data){
    	$this->db->insert('anexos', $data);
    }
    
    public function delold($id){
    	$this->db->query("DELETE FROM anexos WHERE id='$id';");
    }
    
    public function edi_tor($id, $data){
    	$this->db->set($data);
    	$this->db->where('id',$id);
    	$this->db->update('anexos');
    }
}