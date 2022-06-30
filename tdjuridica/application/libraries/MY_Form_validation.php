<?php 
defined('BASEPATH') || exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
    public function edit_unique($str, $field)
    {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'id !=' => $id))->num_rows() === 0)
            : FALSE;
    }
    
	public function phone_chile($str)
	{
		return (bool) preg_match('/^(?:\+(56) (?:(?:(32|33|34|35|39|41|42|43|44|45|51|52|53|55|57|58|61|63|64|65|67|68|71|72|73|75) ([0-9]{7}))|(?:(2|9) ([0-9]{8}))))$/', $str);
	}
	
	public function alpha_es($str)
	{
		return (bool) preg_match('/^[A-ZñÑáéíóúÁÉÍÓÚ]+$/i', $str);
	}
	
	public function alpha_spaces_es($str)
	{
		return (bool) preg_match('/^[A-ZñÑáéíóúÁÉÍÓÚ ]+$/i', $str);
	}
	
	public function alpha_numeric_comma_point_es($str)
	{
		return (bool) preg_match("/^[A-Z0-9ñÑáéíóúÁÉÍÓÚ\.\, ]+$/i", $str);
	}

	public function valid_date ($str) {
		if(! (bool) preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/i', $str)) {
			return false;
		} 
		
		list($year, $month, $day) = explode('-', $str);
		
		return (bool) checkdate($month, $day, $year);		
	}
	
	public function rut($str)
	{
		if(!(bool) preg_match("/^([1-9]|[1-9][0-9]|[1-9][0-9]{2})(\.[0-9]{3})*\-([0-9]|k|K)$/i", $str)) {
			return false;
		}
		
		$rut = str_replace(".", "", $str);
		list($numero, $digito_verificador) = explode("-", $rut);
		$digito_verificador = strtolower($digito_verificador);
		
		$numero_invertido = array_reverse(str_split($numero));
		$suma = 0;
		$i = 0;
		foreach($numero_invertido as $v) {
			$c = ($i % 6) + 2;
			$suma += $v * $c;
			$i++;
		}
		$digito_verificador_real = 11 - $suma % 11;
		$digito_verificador_real = $digito_verificador_real == 11 ? '0' : $digito_verificador_real;
		$digito_verificador_real = $digito_verificador_real == 10 ? 'k' : $digito_verificador_real;
		
		return $digito_verificador == $digito_verificador_real;
	}
	
	public function is_in($str, $field) {
		sscanf($field, '%[^.].%[^.]', $table, $field);
        
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 1)
            : FALSE;
	}
	
	public function compare_date_greater_than($str, $field)
	{
		return isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])
			? ($str > $this->_field_data[$field]['postdata'])
			: FALSE;
	}
	
	public function compare_date_greater_than_equal_to($str, $field)
	{
		return isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])
			? ($str >= $this->_field_data[$field]['postdata'])
			: FALSE;
	}
	
	public function compare_date_less_than($str, $field)
	{
		return isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])
		? ($str < $this->_field_data[$field]['postdata'])
		: FALSE;	
	}
	
	public function date_less_than_equal_to($str, $field)
	{
		return isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])
		? ($str > $this->_field_data[$field]['postdata'])
		: FALSE;	
	}
}