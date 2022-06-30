<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends General_model {
	public function __construct() {
		$table = 'users';
        parent::__construct($table);
    }

    public function getmail($rut = null) {
        $this->db->from('users');
        $this->db->where('users.rut',$rut);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = [$data['email'], $data['first_name']];
        }
        return $values;
    }    
    
    public function getmailapoderado($id = null) {
        $this->db->from('users');
        $this->db->where('users.id',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = [$data['email'], $data['first_name']];
        }
        return $values;
    }    
}