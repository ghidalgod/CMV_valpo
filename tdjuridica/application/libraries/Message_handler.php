<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	El formato de los objetos errores son:
	{
		tpye: 'error',
		name: 'IntentionDoesNotExist',
		message: 'No existe la intención.',
		data: mixed
	}
	
	obs: 
		data: por defecto es null, puede contener cualquier dato
*/

class Message_handler {
	public function __construct() {
		$this->lang->load('message');
	}
	
	public function __get($var)
	{
		return get_instance()->$var;
	}

    public function get($type = '', $name = '', $data = null, $createObjectData = false)
    {
    	if(empty($type) or empty($name) or empty($this->lang->line($type)) or empty($this->lang->line($type)[$name])) {
			$type = 'error';
			$name = 'MessageDoesNotExist';
    	} 
    	$message = $this->lang->line($type)[$name];

    	return $this->createMessageObject($type, $name, $message, $data, $createObjectData);
    }
    
    private function createMessageObject($type = '', $name = '', $message = '', $data = null, $createObjectData = false) {
    	$messageObject = new stdClass;
    	$messageObject->type = $type;
    	$messageObject->name = $name;
    	$messageObject->message = $message;
    	if(!empty($data)) {
    		if($createObjectData) {
    			$messageObject->data = $this->createDataObject($data);	
    		} else {
    			$messageObject->data = $data;		
    		}
    		
    	}
    	return $messageObject;
    }
    
    private function createDataObject($data = array()) {
    	$dataObject = new stdClass;
    	foreach($data as $key => $value) {
    		$dataObject->{$key} = $value;
    	}
    	return $dataObject;
    }  
}