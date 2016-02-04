<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cursos_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add_curso($codigo, $desc){
		$sql = "INSERT INTO cursos (idcurso, desc_curso, estado)
				VALUES (UPPER(". $this->db->escape($codigo) ."), UPPER(". $this->db->escape($desc) ."), 'A')";
		//echo $sql;
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function edit_curso($codigo, $desc){
		$sql = "UPDATE cursos SET desc_curso = UPPER(". $this->db->escape($desc) .")
				WHERE idcurso = '$codigo'";
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

	public function get_cursos($limit, $segmento){
		$sql = "SELECT *
				FROM cursos
				WHERE estado = 'A'
				ORDER BY idcurso ";

		if($limit != 0){
			$sql .= "LIMIT ". $segmento ." , ". $limit;
		}

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	function get_total_cursos(){
		$this->db->from('cursos')->where('estado','A');
		return $this->db->count_all_results();
  	}

  	public function get_curso_by_id($id){
  		
  		$sql = "SELECT * FROM cursos where idcurso = '$id' and estado = 'A'";
  				
		//echo($sql);
		$res = $this->db->query($sql);
		return $res->row();
		
	}

	public function get_cursos_by_criterio($filtro){
		$sql = "SELECT *
				FROM cursos
				WHERE (idcurso LIKE '%". $filtro ."%'
				OR desc_curso like '%". $filtro ."%') 
				ORDER BY idcurso";
				//echo($sql);
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

}