<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model");
	}
	public function index()
	{
		if ($this->session->userdata("login")) {
			redirect(base_url()."dashboard/index");
		}
		else{
			$this->load->view("admin/login");
		}
		

	}

	public function login(){
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$res = $this->Usuarios_model->login($username, $password);

		if (!$res) {
			$this->session->set_flashdata("error","El usuario y/o contraseña son incorrectos");
			redirect(base_url());
		}
		else{
			$data  = array(
				'id' => $res->id, 
				'nombre' => $res->nombres,
				'rol' => $res->rol_id,
				'login' => TRUE
			);
			$this->session->set_userdata($data);
			redirect(base_url()."dashboard/index");
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function store(){

		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$email = $this->input->post("email");
		$rol_id = $this->input->post("rol_id");
		

		$this->form_validation->set_rules("username","Nombre de la Persona","required");
		$this->form_validation->set_rules("password","Contraseña de la Persona","required");
		//$this->form_validation->set_rules("tipocliente","Tipo de Cliente","required");
		//$this->form_validation->set_rules("tipodocumento","Tipo de Documento","required");
		//$this->form_validation->set_rules("numero","Numero del Documento","required|is_unique[clientes.num_documento]");

		if ($this->form_validation->run()) {
			$data  = array(
				'usuario' => $username, 
				'contrasena' => $password,
				'email' => $email,
				'rol_id' => $rol_id,
				'estado' => "1"
			);

			if ($this->Usuarios_model->save($data)) {
				$this->load->view("admin/login");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				
			}
		}
		else{
			$this->add();
		}

		
	}
}
