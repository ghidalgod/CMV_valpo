<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Google_auth_model extends General_model {
	public function __construct() {
		$table = 'users_google';
        parent::__construct($table);
    }
    
    function Is_already_register($id) {
        $this->db->where('login_oauth_uid', $id);
        $query = $this->db->get('users_google');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function Update_user_data($data, $id) {
        $this->db->where('login_oauth_uid', $id);
        $this->db->update('users_google', $data);
    }

    function Insert_user_data($data) {
        $this->db->insert('users_google', $data);
    }

}