<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bootstrap {
	public function __get($var)
	{
		return get_instance()->$var;
	}
	
	public function alert($type = '', $message = '') {
		$alert = $message;
		if(in_array($type, array('success', 'info', 'warning', 'danger'))) {
			$alert = "<div class=\"alert alert-$type\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\"><i class=\"ace-icon fa fa-times\"></i></button>$message</div>";
		} 
		return $alert;
	}
}

