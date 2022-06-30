<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
//JOEL SANTANA
class Noticias_model extends General_model {
	public function __construct() {
		$table = 'noticias';
        parent::__construct($table);
    }
    
    /*INTENTA AGREGAR UNA NOTICIA A LA BD, EN CASO DE NO PODER
    CAPTURA EL ERROR Y LO ENTREGA YA QUE EL CONTTROLADOR ESPERA UN "AGREGADA"
    SE MOSTRARA QUE HUBO UN ERROR PERO NO QUE ERROR FUE*/
    public function agregarNoticia($datos){
    	//print_r($datos);
    	$result = "AGREGADA";
    	try{
    		$this->db->insert('noticias', $datos);
    	}catch(Exception $e){
    		$result = $e;
    	}
    	return $result;
    }
    
    /*TOMA TODAS LAS NOTICIAS Y LAS ENTREGA*/
    public function getAllNews(){
    	$this->table = 'noticias';
		$news = $this->get('*');
    	return $news;
    }
    
    /*CON EL ID DE UNA NOTICIA TOMA LOS DATOS PARA PODER REALIZAR UNA UPDATE O MOSTRALA*/
    public function getNoticia($id){
    	$this->table = "noticias";
		$noticia = $this->get('*', array('id' => $id));
		
		if(empty($noticia)) return false;
			else return (array)$noticia[0];
    }
    
    /*CODIGO DE DIAS_LIBRE_MODEL REMOVEDA YA QUE NO REQUIERE VALIDACIONES
    SOLO SE REMUEVE DE LA BD*/
    public function removeNoticia($id){
    	if(empty($id)) return ['NULL_ID'];
		
		$this->table = 'noticias';
		
		return $this->remove(array('id' => $id));
    }
    
    //retorna actualizado en caso de poder actualizar una noticia
    //de lo contrario captura el error y lo retorna
    public function updateNoticia($id,$datos){
		$result = "ACTUALIZADO";
		try {
			$this->db->where('id', $id);
			$this->db->update('noticias', $datos);
		} catch (Exception $e) {
    		$result = 'Excepción capturada: '.$e->getMessage()."\n";
		}
		return $result;
	}
	
	//retorna las noticias que estan dentro del tiempo de un año	
	public function getNewsBetweenYear(){
   		$this->db->select('*');
    	$this->db->from('noticias');
    	$this->db->where('fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 365 DAY) AND CURDATE()');
    	
    	$query = $this->db->get();
		$news = $query->result_array();
		
		return $news;
    }
		
		//retorna un string con todas las noticias como cards
	public function cardsNoticias(){
		$noticias = $this->getNewsBetweenYear();
		$bootsCards = '';
		$ic_adm = '<i class="ace-icon fa fa-university smaller-80"></i>';
		$ic_gen = '<i class="ace-icon fa fa-handshake-o smaller-80"></i>';
		$ic_soc = '<i class="ace-icon fa fa-comments-o smaller-80"></i>';
		foreach($noticias as $news => $noticia){
			$noticia = (array)$noticia;
			switch($noticia['tipo']){
				case "Administrativo":
					$icon = '<i class="ace-icon fa fa-university smaller-80"></i>';
					break;
				case "General":
					$icon = '<i class="ace-icon fa fa-handshake-o smaller-80"></i>';
					break;
				case "Social":
					$icon = '<i class="ace-icon fa fa-comments-o smaller-80"></i>';
					break;
			}
			$card = 
			   '<div class="row">
				    <div class="card border-dark border border-dark mb-3">
						<div class="card-header">
							<h5>'.$noticia['titulo'].'</h5>
							<footer>'.$noticia['fecha'].'</footer>
						</div>
						
						<div class="card-body">
							'.html_entity_decode($noticia['cuerpo']).'
						</div>
						<div class="card-footer text-muted">
    						'.$icon.' '.$noticia['tipo'].'
						</div>
					</div>
				</div>
				<hr>';
			$bootsCards = $bootsCards.$card;
		}
		return $bootsCards;
	}
}