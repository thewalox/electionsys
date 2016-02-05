<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudiantes extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Estudiantes_model');
		$this->load->library('form_validation');
	}

	function form_crear(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: ElectionSys :.";

		    $this->load->view("header", $datos);
		    $this->load->view("estudiantes/crear_estudiante", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function crear_estudiante(){

		$this->form_validation->set_rules('codigo', 'Codigo', 'required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('curso', 'Curso', 'required');
		$this->form_validation->set_rules('estado', 'Estado', 'required|callback_check_default');
		$this->form_validation->set_rules('sexo', 'Sexo', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Estudiantes_model->add_estudiante($this->input->post("codigo"), $this->input->post("nombre"), $this->input->post("curso"),$this->input->post("tel"), $this->input->post("estado"), $this->input->post("sexo"));
		}else{
			$datos["mensaje"] = validation_errors(); //incorrecto
		}

		echo json_encode($datos);
		
	}

	function form_buscar(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$this->load->library('pagination');

			/*Se personaliza la paginación para que se adapte a bootstrap*/
			$config['base_url'] = base_url().'estudiantes/form_buscar/';
			$config['total_rows'] = $this->Estudiantes_model->get_total_estudiantes();
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

			$datos["estudiantes"] = $this->Estudiantes_model->get_estudiantes($config['per_page'], $desde);

			$this->pagination->initialize($config);

		    $this->load->view("header", $datos);
		    $this->load->view("estudiantes/buscar_estudiantes", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function form_editar($id){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: ElectionSys :.";

			$datos["estudiante"] = $this->Estudiantes_model->get_estudiante_by_id($id);
			
		    $this->load->view("header", $datos);
		    $this->load->view("estudiantes/editar_estudiante", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function editar_estudiante(){

		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('curso', 'Curso', 'required');
		$this->form_validation->set_rules('estado', 'Estado', 'required|callback_check_default');
		$this->form_validation->set_rules('sexo', 'Sexo', 'required|callback_check_default');

		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('check_default','Seleccione un valor para el campo %s');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Estudiantes_model->edit_estudiante($this->input->post("codigo"), $this->input->post("nombre"), $this->input->post("curso"),$this->input->post("tel"), $this->input->post("estado"), $this->input->post("sexo"));
		}else{
			$datos["mensaje"] = validation_errors(); //incorrecto
		}

		echo json_encode($datos);

		//$this->form_editar($this->input->post("id"));	
	    
	}

	function eliminar_estudiante($id){
		
		$datos["mensaje"] = $this->Estudiantes_model->elimina_estudiante($id);
		redirect('estudiantes/form_buscar');
	}

	function get_estudiantes_criterio(){

		//se valida la variable get term para las busquedas que se realizan a traves de jquey UI

		if (isset($_GET['term'])) {
			$filtro = $_GET['term'];
		}else{
			$filtro = $this->input->get("filtro");
		}

		$datos = $this->Estudiantes_model->get_estudiantes_by_criterio($filtro);

		if (isset($_GET['term'])) {
			
			foreach ($datos as $dato) {
				$new_row['label']=htmlentities(stripslashes($dato['nombre']));
				$new_row['value']=htmlentities(stripslashes($dato['idempleado']));
				$new_row['dpto']=htmlentities(stripslashes($dato['desc_departamento']));
				$row_set[] = $new_row; //build an array
			}
		
			echo json_encode($row_set);

		}else{
			
			echo json_encode($datos);
		}

	}

	function form_importar(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: ElectionSys :.";
			
		    $this->load->view("header", $datos);
		    $this->load->view("estudiantes/importar_estudiantes", $datos);
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

				$estudiante = $this->Estudiantes_model->get_estudiante_by_id($data["A"]);

				//valido si la columna telefono viene vacia
				if (!isset($data["D"])) {
					$data["D"] = "";
				}

				if ($estudiante) {
					$this->Estudiantes_model->edit_estudiante($data["A"], $data["B"], $data["E"], $data["D"], $data["F"], $data["C"]);	
					$cont_edit = $cont_edit + 1;
				}else{
					$this->Estudiantes_model->add_estudiante($data["A"], $data["B"], $data["E"], $data["D"], $data["F"], $data["C"]);
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