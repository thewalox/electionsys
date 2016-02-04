<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Usuarios_model");
	}

	function index(){
		$datos["titulo"] = " .: ElectionSys :.";
		
		if ($this->session->userdata('sess_id_user')) {
		   	redirect("home");
		}else{
			$this->load->view("login", $datos);	
			//print_r($this->session->all_userdata());
		} 
	    
	}

	function validar_usuario(){
		if (isset($_POST["clave"])) {
			//print_r($_POST);
			$res = $this->Usuarios_model->login($this->input->post("usuario"), $this->input->post("clave"));
			
			if($res){
				$sesiones = array();
				$sesiones["sess_id_user"] = $res->login;
				$sesiones["sess_name_user"] = $res->nombre_completo;
				$sesiones["sess_perfil"] = $res->perfil;
				$this->session->set_userdata($sesiones);
				echo "ok";
			}else{
				echo "error";
			}
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect("login");
	}

}