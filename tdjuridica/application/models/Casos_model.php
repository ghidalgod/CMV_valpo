<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Casos_model extends General_model {
	public function __construct() {
		$table = 'juridica_casos';
        parent::__construct($table);
    }

    public function datatable($id_curso = null) {
    	$table = 'juridica_casos';
    	$primaryKey = 'juridica_casos.id';
    	$whereResult = null;
    	$whereAll = "en_curso.id_curso = '". $id_curso. "'";
    	$join = 'LEFT JOIN en_curso ON juridica_casos.id = en_curso.id_caso';
		$columns = array(
			array( 'db' => 'juridica_casos.id', 'dt' => 'id' ),
			array( 'db' => 'juridica_casos.rut', 'dt' => 'rut' ),
			array( 'db' => 'juridica_casos.nombres', 'dt' => 'titulo' ),
			array( 'db' => 'juridica_casos.apellido_p', 'dt' => 'apellido_p' ),
			array( 'db' => 'juridica_casos.apellido_m', 'dt' => 'apellido_m' ),
			array( 'db' => 'juridica_casos.fecha', 'dt' => 'fecha' ),
		);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, $whereAll);
        return $data;
    }

     public function data_casos() {             //en esta funcion se llama a los casos presentes en la vista 'casos'. 
    	$table = 'casos';
    	$primaryKey = 'casos.id';
    	$whereResult = null;
		$columns = array(
			array( 'db' => 'casos.id', 'dt' => 'id' ),
			array( 'db' => 'casos.RUC', 'dt' => 'RUC' ),
            array( 'db' => 'casos.asignado', 'dt' => 'asignado' ),
            array( 'db' => 'casos.fecha', 'dt' => 'fecha' ),
			array( 'db' => 'casos.titulo', 'dt' => 'titulo' ),
			array( 'db' => 'casos.etapa', 'dt' => 'etapa' ),
			array( 'db' => 'casos.tipo', 'dt' => 'tipo' ),
			
		);
    	$data = $this->data_tables->complex($_POST, $table, $primaryKey, $columns, $whereResult);
        return $data;
    }


    public function getCaso(){
        $this->db->order_by('id','ASC');
        $query  = $this->get('*', array());
        foreach($query as $value){
            $data[] = $value->titulo.' '.$value->apellido_p;
        }
        return $data;
    }

    public function getidbyname($name = null) {
        $this->db->from('juridica_casos');
        $nombres = explode(" ", $name);
        var_dump($nombres);
       $query = $this->db->get(); 
       $this->db->where('juridica_casos.apellido_p',$nombres[1]);
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = $data['id'];
        }
        return $values;
    }


    public function getEmail($id = null) {
        $this->db->from('juridica_casos');
        $this->db->where('juridica_casos.id',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = $data['correo'];
        }
        return $values;
    }

    public function caso($id = null) {
        $this->db->from('juridica_casos');
        $this->db->where('juridica_casos.id',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = [$data['id'],$data['rut'],$data['nombres'],$data['apellido_p'],$data['apellido_m'], $data['direccion']];
        }
        return $values;
    }

    public function casoporid($id = null) {
        $this->db->from('juridica_casos');
        $this->db->where('juridica_casos.user_id',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = $data['id'];
        }
        return $values;
    }

    public function casoporapoderado($id = null) {
        $this->db->from('juridica_casos');
        $this->db->where('juridica_casos.apoderado_user_id',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = $data['id'];
        }
        return $values;
    }    

    public function IDapoderado($id = null) {
        $this->db->from('juridica_casos');
        $this->db->where('juridica_casos.id',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = [$data['apoderado_user_id']];
        }
        return $values;
    }

    public function address($id = null) {
        $this->db->from('juridica_casos');
        $this->db->where('juridica_casos.user_id',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = $data['direccion'];
        }
        return $values;
    }

    public function actualizar($user, $data){
        $value = $data['direccion'];
        $this->db->query("UPDATE juridica_casos SET direccion='$value' WHERE user_id= $user;");
    }
    
    public function bombero($id = null) {
        $this->db->from('juridica_casos');
        $this->db->where('juridica_casos.id',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $data = $query->row_array();
            $values = [$data['rut'],$data['nombres'],$data['apellido_p'],$data['apellido_m'],$data['nacimiento'],$data['direccion'],$data['apoderado'],$data['apoderado_s'],$data['cesfam'],$data['enfermedades'],$data['alergias']];
        }
        return $values;
    }
}