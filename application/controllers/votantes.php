<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Votantes extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Elecciones_model');
		$this->load->model('Cursos_model');
		$this->load->model('Curules_model');
		$this->load->model('Candidatos_model');
		$this->load->model('Votantes_model');
		$this->load->library('form_validation');
	}

	function index(){
		$datos["titulo"] = " .: ElectionSys :.";
		
		if ($this->session->userdata('sess_id_votante')) {
		   	redirect("votantes/tarjeton");
		}else{
			$this->load->view("votantes/login_votantes", $datos);	
			//print_r($this->session->all_userdata());
		} 
	    
	}

	function form_crear(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: ElectionSys :.";

			$datos["elecciones"] = $this->Elecciones_model->get_elecciones_by_estado('A');
			$datos["cursos"] = $this->Cursos_model->get_cursos(0, 0);

		    $this->load->view("header", $datos);
		    $this->load->view("votantes/crear_votantes", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function get_votantes_eleccion_curso(){

		$this->form_validation->set_rules('eleccion', 'Eleccion', 'required|callback_check_default');
		$this->form_validation->set_rules('curso', 'Curso', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

	    if($this->form_validation->run()!=false){
			$datos = $this->Votantes_model->get_votantes_by_eleccion_curso($this->input->post("eleccion"), $this->input->post("curso"));
		}else{
			$datos["error"] = validation_errors(); //incorrecto
		}

		echo json_encode($datos);
		
		
	}

	function crear_votantes(){
		$votantes = $this->input->post("votantes");
		$votantes = substr($votantes, 0, -1);
		$votantes = explode(",", $votantes);

		foreach ($votantes as $votante) {
			if (!empty($votante)) {
				$registros[] = array('ideleccion' => $this->input->post("eleccion"), 'idvotante' => trim($votante), 'idcurso' => $this->input->post("curso"));
			}
		}

		$this->Votantes_model->elimina_votantes($this->input->post("eleccion"), $this->input->post("curso"));

		//print_r($datos);
		$this->form_validation->set_rules('eleccion', 'Eleccion', 'required|callback_check_default');
		$this->form_validation->set_rules('curso', 'Curso', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

		if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Votantes_model->add_votantes($this->input->post("eleccion"), $this->input->post("idcurso"), $registros);
		}else{
			$datos["mensaje"] = validation_errors(); //incorrecto
		}
			
		echo json_encode($datos);
		
	}

	function editar_candidato(){

		$config["upload_path"] = realpath(APPPATH."../assets/uploads");
		$config["allowed_types"] = "gif|jpg|png";
		$config["max_size"] = "1000";

		$this->load->library("upload", $config);

		if (!$this->upload->do_upload('file') AND !empty($_FILES['file']['name']) ) {
			
			$datos["mensaje"] = $this->upload->display_errors();			

			echo json_encode($datos);
		}else{
			

			$this->form_validation->set_rules('codcurul', 'Codigo de Curul', 'required');
			$this->form_validation->set_rules('numelec', 'Numero Electoral', 'required');

			$this->form_validation->set_message('required','El campo %s es obligatorio');

		    if($this->form_validation->run()!=false){
		    	
		    	if (!empty($_FILES['file']['name'])){
		    		//elimino la foto cargada
					unlink($config["upload_path"].'/'.$_FILES['file']['name']);

			    	//Nombre de la foto
					$nombreArchivo = $_FILES['file']['name'];

			    	//convierte a binario
			    	$imagenBinaria = addslashes(file_get_contents($_FILES['file']['tmp_name']));
		    	}else{
		    		$imagenBinaria = "";
		    	}

				$datos["mensaje"] = $this->Votantes_model->edit_candidato($this->input->post("codele"), $this->input->post("codcan"), $this->input->post("codcurul"), $this->input->post("numelec"), $imagenBinaria);
			}else{
				$datos["mensaje"] = validation_errors(); //incorrecto
				//elimino la foto cargada
				unlink($config["upload_path"].'/'.$_FILES['file']['name']);

			}

			echo json_encode($datos);

		}
	    
	}


	function form_importar(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: ElectionSys :.";
			
		    $this->load->view("header", $datos);
		    $this->load->view("Votantes/importar_Votantes", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	public function importar(){
		$config["upload_path"] = realpath(APPPATH."../assets/files");
		$config["allowed_types"] = "xlsx";
		$config["max_size"] = "0";

		$this->load->library("upload", $config);

		if (!$this->upload->do_upload('file')) {
			
			$datos["tipo"] = 0; //0 = error, 1= success
			$datos["errores"] = $this->upload->display_errors();

			echo json_encode($datos);
		}else{
			$data = array("upload_data" => $this->upload->data());

			$this->load->library("PHPExcel");

			$objPHPExcel = PHPExcel_IOFactory::load(APPPATH."../assets/files/".$data['upload_data']['file_name']);

			unlink($config["upload_path"].'/'.$data['upload_data']['file_name']);

			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

			//print_r($cell_collection);
			$header = array();
			$array_data = array();

			foreach ($cell_collection as $cell) {
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn(); //obtenemos las columnas
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow(); //obtenemos el numero de filas

				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

				if($row == 1){
					$header[$row][$column] = $data_value;
				}else{
					$array_data[$row][$column] = $data_value;
				}
			}
			//print_r($array_data);
			//$datos["header"] = $header;
			//$datos["values"] = $array_data;
			$cont_add = 0;
			$cont_edit = 0;

			foreach ($array_data as $data) {

				$estudiante = $this->Votantes_model->get_estudiante_by_id($data["A"]);

				//valido si la columna telefono viene vacia
				if (!isset($data["D"])) {
					$data["D"] = "";
				}

				if ($estudiante) {
					$this->Votantes_model->edit_estudiante($data["A"], $data["B"], $data["E"], $data["D"], $data["F"], $data["C"]);	
					$cont_edit = $cont_edit + 1;
				}else{
					$this->Votantes_model->add_estudiante($data["A"], $data["B"], $data["E"], $data["D"], $data["F"], $data["C"]);
					$cont_add = $cont_add + 1;	
				}

				
			}

			$datos["add"] = $cont_add;
			$datos["edit"] = $cont_edit;
			
			$datos["tipo"] = 1; //0 = error, 1= success

			echo json_encode($datos);

		}

	}

	function validar_votante(){
		if (isset($_POST["documento"])) {
			//print_r($_POST);
			$num = $this->Elecciones_model->get_total_elecciones_activas();

			if ($num == 1) {
				//correcto, solo debe haber una eleccion activa
				
				//busco la eleccion que esta activa
				$eleccion = $this->Elecciones_model->get_elecciones_by_estado('A');
				
				foreach ($eleccion as $ele) {
					$ideleccion = $ele["ideleccion"];
					$desc_eleccion = $ele["desc_eleccion"];
				}

				$votante = $this->Votantes_model->get_votantes_by_eleccion_estudiante($ideleccion, $this->input->post("documento"));

				//valido si el estudiante esta habilitado para esta jornada
				if ($votante) {

					//valido si el estudiante ya voto en la jornada
					$voto = $this->Votantes_model->get_registro_voto($ideleccion, $this->input->post("documento"));

					if ($voto) {
						$datos["mensaje"] = "Lo sentimos, este documento ya fue participe de esta jornada electoral";
					}else{
						$sesiones = array();
						$sesiones["sess_id_votante"] = $this->input->post("documento");
						$sesiones["sess_eleccion"] = $ideleccion;
						$this->session->set_userdata($sesiones);

						$datos["mensaje"] = "ok";	
					}
					
				}else{
					$datos["mensaje"] = "Lo sentimos, este documento de identidad no esta habilitado para esta jornada electoral";
				}

				//print_r($votante);
				
			}elseif($num > 1){
				//incorrecto, solo debe haber una eleccion activa
				$datos["mensaje"] = "Existe mas de una jornada electoral activa. Por favor comuniquise inmediatamente con el coordinador de la jornada.";
			}else{
				//no existe eleccion activa
				$datos["mensaje"] = "En este momento no existe ninguna jornada electoral activa. Si esto es incorrecto por favor comuniquise inmediatamente con el coordinador de la jornada.";
			}

			echo json_encode($datos);

			/*if($res){
				$sesiones = array();
				$sesiones["sess_id_user"] = $res->login;
				$sesiones["sess_name_user"] = $res->nombre_completo;
				$sesiones["sess_perfil"] = $res->perfil;
				$this->session->set_userdata($sesiones);
				echo "ok";
			}else{
				echo "error";
			}*/
		}
	}

	function tarjeton(){
		$datos["titulo"] = " .: ElectionSys :.";
		
		if (!$this->session->userdata('sess_id_votante')) {
		   	redirect("votantes");	
		}else{

			$datos["curules"] = $this->Curules_model->get_curules_by_eleccion($this->session->userdata('sess_eleccion'));
			$datos["candidatos"] = $this->Candidatos_model->get_candidatos_by_eleccion($this->session->userdata('sess_eleccion'));
			$this->load->view("votantes/tarjeton", $datos);	
			//print_r($this->session->all_userdata());
		}
		
	}

	function check_default($valor_post){
		if($valor_post == '0'){ 
      		return FALSE;
    	}else{
  			return TRUE;
  		}
	}

}