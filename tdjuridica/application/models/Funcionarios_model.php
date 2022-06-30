<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Funcionarios_model extends General_model {
	public function __construct() {
		$pr_administracion = $this->load->database('pr_administracion', TRUE);
        parent::__construct("TPersonasLocal", $pr_administracion);
    }
    
    public function getDatosLiquidacionAdministracion($rut, $fechas) {
    	$this->db->where("CodigoPersona = '$rut'");
	    
	    $this->db->where("({$fechas[0][0]}");
	    $this->db->where($fechas[0][1]);

		for ($i = 1; $i < count($fechas) -1; $i++) {
		    $this->db->or_where($fechas[$i][0]);
		    $this->db->where($fechas[$i][1]);
		}
		
		$this->db->or_where("{$fechas[count($fechas) -1][0]}");
		$this->db->where("{$fechas[count($fechas) -1][1]})");
		$this->db->where("(Año > 2019");
		$this->db->or_where("(Año = 2019 AND Mes > 6))");
		$this->db->order_by("Año, CAST(Mes AS Numeric(10, 0))");
		
    	return $this->db->get("liquidacion_view")->result();
    }
    
    //Obtiene haberes y descuentos
    public function getConceptosLiquidacionAdministracion($rut, $fechas) {
    	$this->db->where("CodigoPersona = '$rut'");
	    
	    $this->db->where("({$fechas[0][0]}");
	    $this->db->where($fechas[0][1]);

		for ($i = 1; $i < count($fechas) -1; $i++) {
		    $this->db->or_where($fechas[$i][0]);
		    $this->db->where($fechas[$i][1]);
		}
		
		$this->db->or_where("{$fechas[count($fechas) -1][0]}");
		$this->db->where("{$fechas[count($fechas) -1][1]})");
		$this->db->where("(Año > 2019");
		$this->db->or_where("(Año = 2019 AND Mes > 6))");
    	
    	return $this->db->get("conceptos_planilla_view")->result();
    }
    
    public function getFechasVidaFuncionaria($rut) {
    	$this->db->select("FechaInicio, FechaTermino");
    	$this->db->where("CodigoPersona = '$rut'");
    	$this->db->order_by("FechaInicio");
    	
    	return $this->db->get("TVidaFuncionaria")->result();
    }
    
    public function getInfoFormacionOProfesional($rut) {
    	$this->db->select("Titulo, FechaTitulo, Institucion, Profesion");
	    $this->db->from('TFuncionario');
	    $this->db->join('TPersonasDetalle', 'TFuncionario.CodigoPersona = TPersonasDetalle.CodigoPersona');
    	$this->db->where("TFuncionario.CodigoPersona = '$rut'");
    	
    	return $this->db->get()->row();
    }

	public function getVidaFuncionaria($rut){
		$whereResult = "CodigoPersona = '$rut'";

   		$table = 'pr_administracion.dbo.vida_funcionaria_view';
    	$primaryKey = 'CodigoVidaFuncionaria';
    	
		$columns = array(
	   		array( 'db' => 'CodigoVidaFuncionaria', 'dt' => 'CodigoVidaFuncionaria' ),
	    	array( 'db' => 'FechaInicio', 'dt' => 'FechaInicio' ),
		    array( 'db' => 'FechaTermino', 'dt' => 'FechaTermino' ),
		    array( 'db' => 'CentroCosto', 'dt' => 'CentroCosto' ),
		    array( 'db' => 'TipoFuncionario', 'dt' => 'TipoFuncionario' ),
		    array( 'db' => 'CalidadJuridica', 'dt' => 'CalidadJuridica' ),
		    array( 'db' => 'Cargo', 'dt' => 'Cargo' ),
		    array( 'db' => 'Funcion', 'dt' => 'Funcion' ),
		    array( 'db' => 'Planta', 'dt' => 'Planta' )
	    );
		
		$pr_administracion = $this->load->database('pr_administracion', TRUE);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, null, '', $pr_administracion);

		return $data;
    }
    
	public function getPermisos($rut){
		$whereResult = "CodigoPersona = '$rut'";

   		$table = 'TPermisos';
    	$primaryKey = 'CodigoPermiso';
    	
		$columns = array(
			array( 'db' => 'CodigoPermiso', 'dt' => 'CodigoPermiso' ),
	   		array( 'db' => 'FechaInicio', 'dt' => 'FechaInicio' ),
	   		array( 'db' => 'NumResolucion', 'dt' => 'NumResolucion' ),
		    array( 'db' => 'FechaTermino', 'dt' => 'FechaTermino' ),
		    array( 'db' => 'CantidadPermiso', 'dt' => 'CantidadPermiso' ),
		    array( 'db' => 'DiaHora', 'dt' => 'DiaHora' ),
		    array( 'db' => 'TipoPermiso', 'dt' => 'TipoPermiso' ),
		    array( 'db' => 'Causa', 'dt' => 'Causa' )
	    );
		
		$pr_administracion = $this->load->database('pr_administracion', TRUE);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult, null, '', $pr_administracion);

		return $data;
    }      
}