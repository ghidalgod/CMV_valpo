<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_model extends CI_Model {
	public function construct(){
		parent::__construct();
	}
}

abstract class General_model extends CI_Model {
	protected $table;
	
	public function __construct($table,$seconDB = null) {
        parent::__construct();
        $this->load->helper('array');
        $this->load->library('data_tables');
        $this->table = $table;
        if(!empty($seconDB)) $this->db = $seconDB;
        
    }
    
	public function add($data = array()) {
        return $this->db->insert($this->table, $data);
    }
    
    public function add_id($data = array()) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function add_batch($data = array()) {
    	if(empty($data)) {
    		return false;
    	}
    	return $this->db->insert_batch($this->table, $data); 
    }
    
    /*
    	$data = array(array(
        	'title' => 'My title',
        	'name'  => 'My Name',
        	'date'  => 'My date'
		));
		
		$primaries_key = array('title');
    */
    public function update_or_insert($data = array(), $primary_key = array(), $no_primary_key = array()) {
    	if(empty($data) or empty($primary_key)) {
    		return false;
    	}
    	
    	$this->db->trans_begin();
    	$new_primary_key = array();
    	foreach($primary_key as $value) {
    		$new_primary_key[$value] = $value;
    	}
    	
    	$new_no_primary_key = array();
    	foreach($no_primary_key as $value) {
    		$new_no_primary_key[$value] = $value;
    	}
    	
    	$pk = array_column($data, $primary_key);
    	
    	$join_pk = array();
    	foreach($pk as $values) {
			$join_pk[] = implode('&', $values);
    	}
    	$string_data_pk = implode("', '", $join_pk);
		$string_pk = implode(', ', $primary_key);

		$repeated_pk = $this->db->query("SELECT CONCAT_WS('&', $string_pk) as PK FROM {$this->table} WHERE CONCAT_WS('&', $string_pk) IN('$string_data_pk')")->result();
    	$new_repeated_pk = array();
    	foreach($repeated_pk as $row) {
    		$new_repeated_pk[] = $row->PK; 
    	}
    
    	$insert = array();
		foreach($data as $row) {
			$data_pk = array_intersect_key($row, $new_primary_key);
			$data_npk = array_intersect_key($row, $new_no_primary_key);
			
			$current_pk = implode('&', $data_pk);
			if(in_array($current_pk, $new_repeated_pk)) {
				$this->update($data_npk, $data_pk);
			} else {
				$insert[] = $row;
			}
		}
		$this->add_batch($insert);
    	
    	$this->db->trans_commit();
    	return true;
    }
    
    public function update($data = array(), $where = array(), $where_in = array(), $where_not_in = array()) {
    	if(!empty($where)) {
    		$this->db->where($where);
    	}
    	if(!empty($where_in)) {
    		foreach($where_in as $key => $value) {
    			$this->db->where_in($key, $value);
    		}
    	}
    	if(!empty($where_not_in)) {
    		foreach($where_not_in as $key => $value) {
    			$this->db->where_not_in($key, $value);
    		}
    	}
    	foreach($data as $key => $value) {
    		$this->db->set($key, $value, true);
    	}
    	return $this->db->update($this->table);
    	
    }
    
    public function update_batch($value, $data = array()) {
    	return $this->db->update_batch($this->table, $data, $value);
    }
    
    public function remove($where = array(), $where_in = array(), $where_not_in = array()) {
    	if(!empty($where)) {
    		$this->db->where($where);
    	}
    	if(!empty($where_in)) {
    		foreach($where_in as $key => $value) {
    			$this->db->where_in($key, $value);
    		}
    	}
    	
    	if(!empty($where_not_in)) {
    		foreach($where_not_in as $key => $value) {
    			$this->db->where_not_in($key, $value);
    		}
    	}
        return $this->db->delete($this->table);
    }
    
    public function get($select = '*', $where = array(), $where_in = array(), $where_not_in = array(), $order_by = 'id DESC', $row_array = false) {
    	if(!empty($where)) {
    		$this->db->where($where);
    	}
    	
    	if(!empty($where_in)) {
    		foreach($where_in as $key => $value) {
    			$this->db->where_in($key, $value);
    		}
    	}
    	
    	if(!empty($where_not_in)) {
    		foreach($where_not_in as $key => $value) {
    			$this->db->where_not_in($key, $value);
    		}
    	}
    	if($row_array ){
    		if(!empty($order_by)) {
	    		$rows = $this->db->select($select)->from($this->table)->order_by($order_by)->get()->result_array();
	    	}else {
	    	    $rows = $this->db->select($select)->from($this->table)->get()->result_array();
	    	}
    		
    	} else {
    		if(!empty($order_by)) {
	    		$rows = $this->db->select($select)->from($this->table)->order_by($order_by)->get()->result();
	    	}else {
	    	    $rows = $this->db->select($select)->from($this->table)->get()->result();
	    	}
    		
    	}

        
        return $rows;
    }
    
    public function is_exists($where = array()) {
        return $this->db->from($this->table)->where($where)->count_all_results() >= 1 ? true : false;
    }
    
    public function count_all($where = array()) {
    	if(!empty($where)) {
    		$this->db->where($where);
    	}
        return $this->db->from($this->table)->count_all_results();
    }
}