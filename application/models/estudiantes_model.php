<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudiantes_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add_estudiante($codigo, $nombre, $curso, $tel, $estado, $sexo){
		$sql = "INSERT INTO estudiantes (idestudiante, nombre_completo, sexo, telefono, idcurso, estado)
				VALUES (". $this->db->escape($codigo) .", UPPER(". $this->db->escape($nombre) .
				"), ". $this->db->escape($sexo) .", ". $this->db->escape($tel) .
				", UPPER(". $this->db->escape($curso) ."), ". $this->db->escape($estado) .")";
		//echo $sql;
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function edit_estudiante($codigo, $nombre, $curso, $tel, $estado, $sexo){
		$sql = "UPDATE estudiantes SET nombre_completo = UPPER(". $this->db->escape($nombre) ."),
				sexo = ". $this->db->escape($sexo) .", idcurso = UPPER(". $this->db->escape($curso) ."),
				telefono = ". $this->db->escape($tel) .", estado = ". $this->db->escape($estado) ."
				WHERE idestudiante = '$codigo'";
		//echo($sql);
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function elimina_estudiante($codigo){
		$sql = "DELETE FROM estudiantes
				WHERE idestudiante = '$codigo'";
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function get_estudiantes($limit, $segmento){
		$sql = "SELECT *
				FROM estudiantes
				ORDER BY idestudiante ";

		if($limit != 0){
			$sql .= "LIMIT ". $segmento ." , ". $limit;
		}

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	function get_total_estudiantes(){
		$this->db->from('estudiantes');
		return $this->db->count_all_results();
  	}

  	public function get_estudiante_by_id($id){
  		
  		$sql = "SELECT e.idestudiante, e.nombre_completo, e.sexo, e.telefono, e.idcurso, c.desc_curso, e.estado
				FROM estudiantes e
				INNER JOIN cursos c ON c.idcurso = e.idcurso 
  				WHERE e.idestudiante = '$id'";
  				
		//echo($sql);
		$res = $this->db->query($sql);
		return $res->row();
		
	}

	public function get_estudiantes_by_criterio($filtro){
		$sql = "SELECT e.idestudiante, e.nombre_completo, e.sexo, e.telefono, e.idcurso, c.desc_curso, e.estado
				FROM estudiantes e
				INNER JOIN cursos c ON c.idcurso = e.idcurso
				WHERE (e.idestudiante LIKE '%". $filtro ."%'
				OR e.nombre_completo like '%". $filtro ."%'
				OR e.idcurso like '%". $filtro ."%')
				ORDER BY e.idestudiante ";
				//echo($sql);
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

}