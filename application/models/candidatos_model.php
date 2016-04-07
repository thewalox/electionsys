<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidatos_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add_candidato($codele, $codcan, $codcur, $codcurul, $numelec, $imagen){
		$sql = "INSERT INTO candidatos (ideleccion, idcandidato, idcurso, idcurul, numero_electoral, foto)
				VALUES (". $this->db->escape($codele) .", ". $this->db->escape($codcan) .", 
				UPPER(". $this->db->escape($codcur) ."), UPPER(". $this->db->escape($codcurul) ."), 
				UPPER(". $this->db->escape($numelec) ."), '". $imagen ."')";
		//echo $sql;
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function edit_candidato($codele, $codcan, $codcurul, $numelec, $imagen){

		$sql = "UPDATE candidatos SET idcurul = UPPER(". $this->db->escape($codcurul) ."),
				numero_electoral = UPPER(". $this->db->escape($numelec) .") "; 

		if (!empty($imagen)){
			$sql .= ", foto = '". $imagen ."' ";
		}
		
		$sql .= "WHERE ideleccion = ". $this->db->escape($codele) ." AND idcandidato = ". $this->db->escape($codcan);
		//echo($sql);
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function elimina_candidato($ideleccion, $idcandidato){
		$sql = "DELETE FROM candidatos
				WHERE ideleccion = ". $this->db->escape($ideleccion) ." 
				AND idcandidato = ".$this->db->escape($idcandidato);
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function get_candidatos($limit, $segmento){
		$sql = "SELECT c.ideleccion, c.idcandidato, es.nombre_completo, c.idcurso, cu.desc_curso, 
				c.numero_electoral, cur.desc_curul, c.foto
				FROM candidatos c
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

	function get_total_candidatos(){
		$this->db->from('candidatos');
		return $this->db->count_all_results();
  	}

  	public function get_candidato_by_id($ideleccion, $idcandidato){
  		
  		$sql = "SELECT c.ideleccion, e.desc_eleccion, c.idcandidato, es.nombre_completo, c.idcurso, cu.desc_curso, 
				c.numero_electoral, c.idcurul, cur.desc_curul, c.foto
				FROM candidatos c
				INNER JOIN elecciones e ON e.ideleccion = c.ideleccion
				INNER JOIN estudiantes es ON es.idestudiante = c.idcandidato
				INNER JOIN cursos cu ON cu.idcurso = c.idcurso
				INNER JOIN curules cur ON cur.idcurul = c.idcurul
  				WHERE c.ideleccion = '$ideleccion' AND c.idcandidato = '$idcandidato'";
  				
		//echo($sql);
		$res = $this->db->query($sql);
		return $res->row();
		
	}

	public function get_candidatos_by_criterio($filtro){
		$sql = "SELECT c.ideleccion, c.idcandidato, es.nombre_completo, c.idcurso, cu.desc_curso, 
				c.numero_electoral, cur.desc_curul, c.foto
				FROM candidatos c
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

	public function get_candidatos_by_eleccion($ideleccion){
		$sql = "SELECT c.ideleccion, c.idcandidato, es.nombre_completo, c.idcurso, cu.desc_curso, 
				c.numero_electoral, c.idcurul, cur.desc_curul, c.foto
				FROM candidatos c
				INNER JOIN elecciones e ON e.ideleccion = c.ideleccion
				INNER JOIN estudiantes es ON es.idestudiante = c.idcandidato
				INNER JOIN cursos cu ON cu.idcurso = c.idcurso
				INNER JOIN curules cur ON cur.idcurul = c.idcurul
				WHERE c.ideleccion = ". $this->db->escape($ideleccion);
				//echo($sql);
		$res = $this->db->query($sql);

		return $res->result_array();
		
	}

}