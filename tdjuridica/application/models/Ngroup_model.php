<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ngroup_model extends General_model {
	public function __construct() {
		$table = 'Ngroups';
        parent::__construct($table);
    }

    public function getusers() {
    	$primaryKey = 'id';
    	$table = 'Ngroups';
        $whereResult = null;
		$columns = array(
			array( 'db' => 'id', 'dt' => 'id' ),
            array( 'db' => 'nombre', 'dt' => 'nombre' ),
			array( 'db' => 'apellido', 'dt' => 'apellido' ),
		    array( 'db' => 'email', 'dt' => 'email' ),
            array( 'db' => 'name', 'dt' => 'grupo' ),
            array( 'db' => 'active', 'dt' => 'estado' ),
		);
    	$data = $this->data_tables->complex($_POST , $table, $primaryKey, $columns, $whereResult);
        return $data;
    }
}
/*

CREATE VIEW Ngroups  AS  SELECT users.id AS id, users.active AS active, users.first_name AS nombre, users.last_name AS apellido, users.email AS email, GROUP_CONCAT( 
CASE groups.name 
WHEN 'admin' THEN 'Administrador'
WHEN 'bpeducacion' THEN 'Buscador Process (Personal Educación general)'
WHEN 'lmedicascentro' THEN 'Licencia médica (filtro por centro(s))'
WHEN 'lmedicas' THEN 'Licencia médica (ingreso y búsqueda general)'
WHEN 'lmpersonal' THEN 'Licencia médica (búsqueda general)'
WHEN 'bpsalud' THEN 'Buscador Process (Personal Salud general)'
WHEN 'bpcsalud' THEN 'Buscador Process (Compras Salud general)'
WHEN 'bpfiltroscentros' THEN 'Buscador Process (Filtro por centro(s))'
WHEN 'dlibresView' THEN 'Días libres (Búsqueda general)'
WHEN 'dlibresfiltro' THEN 'Días libres (filtro por centro(s))'
WHEN 'dlibresAdd' THEN 'Días libres (Ingreso y búsqueda general)'
WHEN 'diaslibrescorreo' THEN 'Días libres (notificar días libres)'
WHEN 'dlibresValidador' THEN 'Validador de días libres (valida permisos de días libres)'
END SEPARATOR '<br>') AS name from ((users JOIN users_groups on((users.id = users_groups.user_id))) join groups on((users_groups.group_id = groups.id))) group by users.id ;

 */
