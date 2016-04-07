<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Elecciones_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add_eleccion($codigo, $desc, $fecini, $fecfin){
		$sql = "INSERT INTO elecciones (ideleccion, desc_eleccion, fecha_inicio, fecha_fin, estado)
				VALUES (UPPER(". $this->db->escape($codigo) ."), UPPER(". $this->db->escape($desc) .
				"), ". $this->db->escape($fecini) .", ". $this->db->escape($fecfin) .", 'A')";
		//echo $sql;
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function edit_eleccion($codigo, $desc, $fecini, $fecfin){
		$sql = "UPDATE elecciones SET desc_eleccion = UPPER(". $this->db->escape($desc) ."),
				fecha_inicio = ". $this->db->escape($fecini) .",
				fecha_fin = ". $this->db->escape($fecfin) ."
				WHERE ideleccion = '$codigo'";
		//echo($sql);
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function elimina_eleccion($codigo){
		$sql = "UPDATE elecciones SET estado = 'X'
				WHERE ideleccion = '$codigo'";
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function cierra_eleccion($codigo){
		$sql = "UPDATE elecciones SET estado = 'C'
				WHERE ideleccion = '$codigo'";
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function get_elecciones($limit, $segmento){
		$sql = "SELECT ideleccion, desc_eleccion,
				CASE 
				WHEN estado = 'A' THEN 'ABIERTA' ELSE 'CERRADA' END AS estado
				FROM elecciones
				WHERE estado != 'X'
				ORDER BY ideleccion DESC ";

		if($limit != 0){
			$sql .= "LIMIT ". $segmento ." , ". $limit;
		}

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	function get_total_elecciones(){
		$this->db->from('elecciones')->where('estado !=','X');
		return $this->db->count_all_results();
  	}

  	function get_total_elecciones_activas(){
		$this->db->from('elecciones')->where('estado','A');
		return $this->db->count_all_results();
  	}

  	public function get_eleccion_by_id($id, $opcion){
  		if ($opcion == 1) {
  			//Editar Solicitud
  			$sql = "SELECT * FROM elecciones where ideleccion = '$id' and estado = 'A'";
  		}else{
  			//Ver Solicitud
  			$sql = "SELECT * FROM elecciones where ideleccion = '$id'";
  		}
		
		//echo($sql);
		$res = $this->db->query($sql);
		return $res->row();
		
	}

	public function get_elecciones_by_criterio($filtro){
		$sql = "SELECT ideleccion, desc_eleccion,
				CASE WHEN estado = 'A' THEN 'ABIERTA' ELSE 'CERRADA' END AS estado
				FROM elecciones
				WHERE (ideleccion LIKE '%". $filtro ."%'
				OR desc_eleccion like '%". $filtro ."%') 
				ORDER BY ideleccion DESC ";
				//echo($sql);
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	public function get_elecciones_by_estado($estado){
		$sql = "SELECT ideleccion, desc_eleccion
				FROM elecciones
				WHERE estado = ". $this->db->escape($estado) ."
				ORDER BY ideleccion DESC ";

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

}