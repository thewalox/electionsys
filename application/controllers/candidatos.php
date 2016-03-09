<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidatos extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Candidatos_model');
		$this->load->library('form_validation');
	}

	function form_crear(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: ElectionSys :.";

		    $this->load->view("header", $datos);
		    $this->load->view("candidatos/crear_candidato", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function crear_candidato(){

		$config["upload_path"] = realpath(APPPATH."../assets/uploads");
		$config["allowed_types"] = "gif|jpg|png";
		$config["max_size"] = "1000";

		$this->load->library("upload", $config);

		if (!$this->upload->do_upload('file')) {
			
			$datos["mensaje"] = $this->upload->display_errors();			

			echo json_encode($datos);
		}else{
		
			$this->form_validation->set_rules('codele', 'Codigo de Eleccion', 'required');
			$this->form_validation->set_rules('codcan', 'Codigo de Candidato', 'required');
			$this->form_validation->set_rules('codcur', 'Codigo de Curso', 'required');
			$this->form_validation->set_rules('codcurul', 'Codigo de Curul', 'required');
			$this->form_validation->set_rules('numelec', 'Numero Electoral', 'required');
			
			if (empty($_FILES['file']['name'])){
	    		$this->form_validation->set_rules('file', 'Foto', 'required');
			}

			$this->form_validation->set_message('required','El campo %s es obligatorio');

		    if($this->form_validation->run()!=false){
		    	//elimino la foto cargada
				unlink($config["upload_path"].'/'.$_FILES['file']['name']);

		    	//Nombre de la foto
				$nombreArchivo = $_FILES['file']['name'];

		    	//convierte a binario
		    	$imagenBinaria = addslashes(file_get_contents($_FILES['file']['tmp_name']));

				$datos["mensaje"] = $this->Candidatos_model->add_candidato($this->input->post("codele"), $this->input->post("codcan"), $this->input->post("codcur"),$this->input->post("codcurul"), $this->input->post("numelec"), $imagenBinaria);
			}else{
				$datos["mensaje"] = validation_errors(); //incorrecto
				//elimino la foto cargada
				unlink($config["upload_path"].'/'.$_FILES['file']['name']);
			}

			echo json_encode($datos);
		}
		
	}

	function form_buscar(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$this->load->library('pagination');

			/*Se personaliza la paginación para que se adapte a bootstrap*/
			$config['base_url'] = base_url().'candidatos/form_buscar/';
			$config['total_rows'] = $this->Candidatos_model->get_total_candidatos();
			$config['per_page'] = 10;
			$desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		    $config['cur_tag_open'] = '<li class="active"><a href="#">';
		    $config['cur_tag_close'] = '</a></li>';
		    $config['num_tag_open'] = '<li>';
		    $config['num_tag_close'] = '</li>';
		    $config['last_link'] = FALSE;
		    $config['first_link'] = FALSE;
		    $config['next_link'] = '&raquo;';
		    $config['next_tag_open'] = '<li>';
		    $config['next_tag_close'] = '</li>';
		    $config['prev_link'] = '&laquo;';
		    $config['prev_tag_open'] = '<li>';
		    $config['prev_tag_close'] = '</li>';

			$datos["titulo"] = " .: ElectionSys :.";

			$datos["candidatos"] = $this->Candidatos_model->get_candidatos($config['per_page'], $desde);

			$this->pagination->initialize($config);

		    $this->load->view("header", $datos);
		    $this->load->view("candidatos/buscar_candidatos", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function form_editar($ideleccion = null, $idcandidato = null){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: ElectionSys :.";

			$datos["candidato"] = $this->Candidatos_model->get_candidato_by_id($ideleccion, $idcandidato);
			
		    $this->load->view("header", $datos);
		    $this->load->view("candidatos/editar_candidato", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
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

				$datos["mensaje"] = $this->Candidatos_model->edit_candidato($this->input->post("codele"), $this->input->post("codcan"), $this->input->post("codcurul"), $this->input->post("numelec"), $imagenBinaria);
			}else{
				$datos["mensaje"] = validation_errors(); //incorrecto
				//elimino la foto cargada
				unlink($config["upload_path"].'/'.$_FILES['file']['name']);

			}

			echo json_encode($datos);

		}
	    
	}

	function eliminar_candidato($ideleccion = null, $idcandidato = null){
		
		$datos["mensaje"] = $this->Candidatos_model->elimina_candidato($ideleccion, $idcandidato);
		redirect('candidatos/form_buscar');
	}

	function get_candidatos_criterio(){

		//se valida la variable get term para las busquedas que se realizan a traves de jquey UI
		//header("Content-type: image/jpg");

		if (isset($_GET['term'])) {
			$filtro = $_GET['term'];
		}else{
			$filtro = $this->input->get("filtro");
		}

		$datos = $this->Candidatos_model->get_candidatos_by_criterio($filtro);

		if (isset($_GET['term'])) {
			
			foreach ($datos as $dato) {
				$new_row['label']=htmlentities(stripslashes($dato['nombre']));
				$new_row['value']=htmlentities(stripslashes($dato['idempleado']));
				$new_row['dpto']=htmlentities(stripslashes($dato['desc_departamento']));
				$row_set[] = $new_row; //build an array
			}
		
			echo json_encode($row_set);

		}else{

			foreach ($datos as $dato) {
				$candidatos[] = array('ideleccion' => $dato["ideleccion"], 'idcandidato' => $dato["idcandidato"],
								'nombre_completo' => $dato["nombre_completo"], 'idcurso' => $dato["idcurso"],
								'desc_curso' => $dato["desc_curso"], 'numero_electoral' => $dato["numero_electoral"],
								'desc_curul' => $dato["desc_curul"], 'foto' => base64_encode($dato["foto"]));
			}
			
			echo json_encode($candidatos);
		}

	}

	function form_importar(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: ElectionSys :.";
			
		    $this->load->view("header", $datos);
		    $this->load->view("Candidatos/importar_Candidatos", $datos);
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

				$estudiante = $this->Candidatos_model->get_estudiante_by_id($data["A"]);

				//valido si la columna telefono viene vacia
				if (!isset($data["D"])) {
					$data["D"] = "";
				}

				if ($estudiante) {
					$this->Candidatos_model->edit_estudiante($data["A"], $data["B"], $data["E"], $data["D"], $data["F"], $data["C"]);	
					$cont_edit = $cont_edit + 1;
				}else{
					$this->Candidatos_model->add_estudiante($data["A"], $data["B"], $data["E"], $data["D"], $data["F"], $data["C"]);
					$cont_add = $cont_add + 1;	
				}

				
			}

			$datos["add"] = $cont_add;
			$datos["edit"] = $cont_edit;
			
			$datos["tipo"] = 1; //0 = error, 1= success

			echo json_encode($datos);

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