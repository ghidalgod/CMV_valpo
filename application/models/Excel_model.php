<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Excel_model extends General_model {
	public function __construct() {
		$table = 'instructivos';
        parent::__construct($table);
    }

    public function excel() {
		$data = null;
		
		return $data;
	}

}