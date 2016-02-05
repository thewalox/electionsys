<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curules_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add_curul($codigo, $desc, $tipo){
		$sql = "INSERT INTO curules (idcurul, desc_curul, tipo_curul, estado)
				VALUES (UPPER(". $this->db->escape($codigo) ."), UPPER(". $this->db->escape($desc) .
				"), ". $this->db->escape($tipo) .", 'A')";
		//echo $sql;
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function edit_curul($codigo, $desc, $tipo){
		$sql = "UPDATE curules SET desc_curul = UPPER(". $this->db->escape($desc) ."),
				tipo_curul = ". $this->db->escape($tipo) ."
				WHERE idcurul = '$codigo'";
		//echo($sql);
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function elimina_curso($codigo){
		$sql = "UPDATE cursos SET estado = 'I'
				WHERE idcurso = '$codigo'";
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function get_curules($limit, $segmento){
		$sql = "SELECT idcurul, desc_curul, 
				CASE WHEN tipo_curul = 'G' THEN 'GLOBAL' ELSE 'PRIVADO' END AS tipo_curul
				FROM curules
				WHERE estado = 'A'
				ORDER BY idcurul ";

		if($limit != 0){
			$sql .= "LIMIT ". $segmento ." , ". $limit;
		}

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	function get_total_curules(){
		$this->db->from('curules')->where('estado','A');
		return $this->db->count_all_results();
  	}

  	public function get_curul_by_id($id){
  		
  		$sql = "SELECT * FROM curules where idcurul = '$id' and estado = 'A'";
  				
		//echo($sql);
		$res = $this->db->query($sql);
		return $res->row();
		
	}

	public function get_curules_by_criterio($filtro){
		$sql = "SELECT idcurul, desc_curul, 
				CASE WHEN tipo_curul = 'G' THEN 'GLOBAL' ELSE 'PRIVADO' END AS tipo_curul
				FROM curules
				WHERE estado = 'A' AND (idcurul LIKE '%". $filtro ."%'
				OR desc_curul like '%". $filtro ."%') 
				ORDER BY idcurul ";
				//echo($sql);
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

}