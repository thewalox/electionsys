<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Votantes_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add_votantes($codele, $codcur, $votantes){
		
		if ($this->db->insert_batch('votantes', $votantes)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function elimina_votantes($ideleccion, $idcurso){
		$sql = "DELETE FROM votantes
				WHERE ideleccion = ". $this->db->escape($ideleccion) ." 
				AND idcurso = ".$this->db->escape($idcurso);
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function get_votantes($limit, $segmento){
		$sql = "SELECT c.ideleccion, c.idcandidato, es.nombre_completo, c.idcurso, cu.desc_curso, 
				c.numero_electoral, cur.desc_curul, c.foto
				FROM Votantes c
				INNER JOIN elecciones e ON e.ideleccion = c.ideleccion
				INNER JOIN estudiantes es ON es.idestudiante = c.idcandidato
				INNER JOIN cursos cu ON cu.idcurso = c.idcurso
				INNER JOIN curules cur ON cur.idcurul = c.idcurul
				ORDER BY c.ideleccion DESC, c.idcandidato ";

		if($limit != 0){
			$sql .= "LIMIT ". $segmento ." , ". $limit;
		}

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	function get_total_votantes(){
		$this->db->from('Votantes');
		return $this->db->count_all_results();
  	}

  	public function get_votantes_by_eleccion_curso($ideleccion, $idcurso){
  		
  		$sql = "SELECT e.idestudiante, e.nombre_completo, e.idcurso, v.idvotante
				FROM estudiantes e
				LEFT JOIN votantes v ON v.idvotante = e.idestudiante 
				AND v.ideleccion = ". $this->db->escape($ideleccion) ."
				WHERE e.estado = 'A' AND e.idcurso = ". $this->db->escape($idcurso) ."
				ORDER BY e.nombre_completo";
  				
		//echo($sql);
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	public function get_votantes_by_criterio($filtro){
		$sql = "SELECT c.ideleccion, c.idcandidato, es.nombre_completo, c.idcurso, cu.desc_curso, 
				c.numero_electoral, cur.desc_curul, c.foto
				FROM Votantes c
				INNER JOIN elecciones e ON e.ideleccion = c.ideleccion
				INNER JOIN estudiantes es ON es.idestudiante = c.idcandidato
				INNER JOIN cursos cu ON cu.idcurso = c.idcurso
				INNER JOIN curules cur ON cur.idcurul = c.idcurul
				WHERE (c.ideleccion LIKE '%". $filtro ."%'
				OR c.idcandidato like '%". $filtro ."%'
				OR es.nombre_completo like '%". $filtro ."%'
				OR c.idcurso like '%". $filtro ."%')
				ORDER BY c.ideleccion DESC, c.idcandidato ";
				//echo($sql);
		$res = $this->db->query($sql);

		return $res->result_array();
		
	}

}