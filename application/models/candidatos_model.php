<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidatos_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add_candidato($codele, $codcan, $codcur, $codcurul, $numelec, $imagen){
		$sql = "INSERT INTO candidatos (ideleccion, idcandidato, idcurso, idcurul, numero_electoral, foto, estado)
				VALUES (". $this->db->escape($codele) .", ". $this->db->escape($codcan) .", 
				". $this->db->escape($codcur) .", ". $this->db->escape($codcurul) .", 
				". $this->db->escape($numelec) .", '". $imagen ."', 'A')";
		//echo $sql;
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function edit_estudiante($codigo, $nombre, $curso, $tel, $estado, $sexo){
		$sql = "UPDATE Candidatos SET nombre_completo = UPPER(". $this->db->escape($nombre) ."),
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
		$sql = "DELETE FROM Candidatos
				WHERE idestudiante = '$codigo'";
		//echo $sql;			
		if ($this->db->simple_query($sql)){
        	return true;
		}else{
        	return false;
		}
		
	}

	public function get_Candidatos($limit, $segmento){
		$sql = "SELECT *
				FROM Candidatos
				ORDER BY idestudiante ";

		if($limit != 0){
			$sql .= "LIMIT ". $segmento ." , ". $limit;
		}

		//echo $sql;

		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	function get_total_Candidatos(){
		$this->db->from('Candidatos');
		return $this->db->count_all_results();
  	}

  	public function get_estudiante_by_id($id){
  		
  		$sql = "SELECT e.idestudiante, e.nombre_completo, e.sexo, e.telefono, e.idcurso, c.desc_curso, e.estado
				FROM Candidatos e
				INNER JOIN cursos c ON c.idcurso = e.idcurso 
  				WHERE e.idestudiante = '$id'";
  				
		//echo($sql);
		$res = $this->db->query($sql);
		return $res->row();
		
	}

	public function get_Candidatos_by_criterio($filtro){
		$sql = "SELECT *
				FROM Candidatos
				WHERE (idestudiante LIKE '%". $filtro ."%'
				OR nombre_completo like '%". $filtro ."%'
				OR idcurso like '%". $filtro ."%')
				ORDER BY idestudiante ";
				//echo($sql);
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

}