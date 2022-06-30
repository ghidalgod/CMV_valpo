<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Db_manager_model extends General_model {
	public function __construct() {
		if (!$this->ion_auth->is_admin()){
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		$table = 'anexos';
        parent::__construct($table);
    }
    
    /******* GetTablas***** Regresa un array relacional con el nombre de las tablas, key y value son iguales...
		result: array(
						'nombre_tabla_1' => 'nombre_tabla_1',
						...
						'nombre_tabla_n-1' => 'nombre_tabla_n-1',
						'nombre_tabla_n' => 'nombre_tabla_n',
					)
	*/
    public function getTables(){
    	$row = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='cmvalpar_buscadorprocess'");
    	$result = $row->result();
    	
    	foreach ($result as $key => $value){
    		if((strcmp($value->TABLE_NAME,'ci_sessions') && strcmp($value->TABLE_NAME,'groups') && strcmp($value->TABLE_NAME,'users') && strcmp($value->TABLE_NAME,'users_groups')))
    			$data[$value->TABLE_NAME] = $value->TABLE_NAME;
    	}
    	return $data;

    }
    
    /******* GetColumn***** Regresa un array simple con los nombres de las columnas de la tabla pasada por argumento
     * Input:	$tableName: String: Nombre de la tabla en DB sin incluir ID
     * Result: array(
     *					[0] => 'nombre_column_1',
     *					...
     *					[n-2] => 'nombre_column_n-1',
     *					[n-1] => 'nombre_column_n',
     *				)
	*/
    
    public function getColumn($tableName){

    	$row = $this->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$tableName."'");
    	$result = $row->result();
		
		foreach($result as $key => $value){
			if(strcmp('id', $value->COLUMN_NAME) != 0) $data[] = $value->COLUMN_NAME;
		}
		
		unset($data[0]);
		
    	return $data;

    }
    
    public function saveExcelData($data, $table){
    	$this->table = $table;
    	return	$this->update_or_insert($data, array('id'), $this->getColumn($table));

    }
}