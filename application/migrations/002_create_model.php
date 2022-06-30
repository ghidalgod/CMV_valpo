<?php defined('BASEPATH') OR exit('No direct script access allowed');
// https://www.codeigniter.com/user_guide/database/forge.html
class Migration_Create_model extends CI_Migration {
	public function __construct() {
		parent::__construct();
		$this->load->dbforge();
	}
	
	public function up() {
	}

	public function down() {
	}		
}