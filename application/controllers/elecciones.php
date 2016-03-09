<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Elecciones extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Elecciones_model');
		$this->load->library('form_validation');
	}

	function form_crear(){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: ElectionSys :.";

		    $this->load->view("header", $datos);
		    $this->load->view("elecciones/crear_eleccion", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function crear_eleccion(){

		$this->form_validation->set_rules('codigo', 'Codigo', 'required');
		$this->form_validation->set_rules('fecini', 'Fecha Inicial', 'required');
		$this->form_validation->set_rules('fecfin', 'Fecha Final', 'required');

		$this->form_validation->set_message('required','El campo %s es obligatorio');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Elecciones_model->add_eleccion($this->input->post("codigo"), $this->input->post("descripcion"), $this->input->post("fecini"), $this->input->post("fecfin"));
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
			$config['base_url'] = base_url().'elecciones/form_buscar/';
			$config['total_rows'] = $this->Elecciones_model->get_total_elecciones();
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

			$datos["elecciones"] = $this->Elecciones_model->get_elecciones($config['per_page'], $desde);

			$this->pagination->initialize($config);

		    $this->load->view("header", $datos);
		    $this->load->view("elecciones/buscar_elecciones", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function form_editar($id = null){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: ElectionSys :.";

			$datos["eleccion"] = $this->Elecciones_model->get_eleccion_by_id($id,1);
			
		    $this->load->view("header", $datos);
		    $this->load->view("elecciones/editar_eleccion", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
		}
		
	}

	function editar_eleccion(){

		$this->form_validation->set_rules('fecini', 'Fecha Inicial', 'required');
		$this->form_validation->set_rules('fecfin', 'Fecha Final', 'required');

		$this->form_validation->set_message('required','El campo %s es obligatorio');

	    if($this->form_validation->run()!=false){
			$datos["mensaje"] = $this->Elecciones_model->edit_eleccion($this->input->post("codigo"), $this->input->post("descripcion"), $this->input->post("fecini"), $this->input->post("fecfin"));
		}else{
			$datos["mensaje"] = validation_errors(); //incorrecto
		}

		echo json_encode($datos);

		//$this->form_editar($this->input->post("id"));	
	    
	}

	function eliminar_eleccion($id = null){
		
		$datos["mensaje"] = $this->Elecciones_model->elimina_eleccion($id);
		redirect('elecciones/form_buscar');
	}

	function cerrar_eleccion($id = null){
		
		$datos["mensaje"] = $this->Elecciones_model->cierra_eleccion($id);
		redirect('elecciones/form_buscar');
	}

	function get_elecciones_criterio(){

		//se valida la variable get term para las busquedas que se realizan a traves de jquey UI

		if (isset($_GET['term'])) {
			$filtro = $_GET['term'];
		}else{
			$filtro = $this->input->get("filtro");
		}

		$datos = $this->Elecciones_model->get_elecciones_by_criterio($filtro);

		if (isset($_GET['term'])) {
			
			foreach ($datos as $dato) {
				$new_row['label']=htmlentities(stripslashes($dato['desc_eleccion']));
				$new_row['value']=htmlentities(stripslashes($dato['ideleccion']));
				$row_set[] = $new_row; //build an array
			}
		
			echo json_encode($row_set);

		}else{
			
			echo json_encode($datos);
		}

	}

	function form_ver($id = null){

		if (!$this->session->userdata('sess_id_user')) {
		   	redirect("login");
		}else{
			$datos["titulo"] = " .: ElectionSys :.";

			$datos["eleccion"] = $this->Elecciones_model->get_eleccion_by_id($id, 0);
			
		    $this->load->view("header", $datos);
		    $this->load->view("elecciones/ver_eleccion", $datos);
		    $this->load->view("footer", $datos);
		    $this->load->view("fin", $datos);
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