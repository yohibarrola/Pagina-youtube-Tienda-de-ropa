<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Clientes_model");
	}

	public function index()
	{
		$data  = array(
			'clientes' => $this->Clientes_model->getClientes(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/clientes/list",$data);
		$this->load->view("layouts/footer");

	}
	public function add(){

//		$data = array(
//			"tipoclientes" => $this->Clientes_model->getTipoClientes(),
//			"tipodocumentos" => $this->Clientes_model->getTipoDocumentos()
//		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/clientes/add");
		$this->load->view("layouts/footer");
	}
	public function store(){

		$nombre = $this->input->post("nombre");
		$apellido = $this->input->post("apellido");
		$telefono = $this->input->post("telefono");
		$direccion = $this->input->post("direccion");
		$ruc = $this->input->post("RUC");
		$empresa = $this->input->post("empresa");

		$this->form_validation->set_rules("nombre","Nombre del Cliente","required");
		//$this->form_validation->set_rules("tipocliente","Tipo de Cliente","required");
		//$this->form_validation->set_rules("tipodocumento","Tipo de Documento","required");
		//$this->form_validation->set_rules("numero","Numero del Documento","required|is_unique[clientes.num_documento]");

		if ($this->form_validation->run()) {
			$data  = array(
				'nombres' => $nombre, 
				'apellidos' => $apellido,
				'telefono' => $telefono,
				'direccion' => $direccion,
				'ruc' => $ruc,
				'empresa' => $empresa,
				'estado' => "1"
			);

			if ($this->Clientes_model->save($data)) {
				redirect(base_url()."mantenimiento/clientes");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."mantenimiento/clientes/add");
			}
		}
		else{
			$this->add();
		}

		
	}
	public function edit($id){
		$data  = array(
			'cliente' => $this->Clientes_model->getCliente($id), 
			//"tipoclientes" => $this->Clientes_model->getTipoClientes(),
			//"tipodocumentos" => $this->Clientes_model->getTipoDocumentos()
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/clientes/edit",$data);
		$this->load->view("layouts/footer");
	}


	public function update(){
		$idcliente = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$apellido = $this->input->post("apellido");
		$telefono = $this->input->post("telefono");
		$direccion= $this->input->post("direccion");
		$ruc = $this->input->post("ruc");
		$empresa = $this->input->post("empresa");

		//$clienteActual = $this->Clientes_model->getCliente($idcliente);

		//if ($num_documento == $clienteActual->num_documento) {
		//	$is_unique = "";
		//}else{
		//	$is_unique= '|is_unique[clientes.num_documento]';
		//}

		//$this->form_validation->set_rules("nombre","Nombre del Cliente","required");
		//$this->form_validation->set_rules("tipocliente","Tipo de Cliente","required");
		//$this->form_validation->set_rules("tipodocumento","Tipo de Documento","required");
		//$this->form_validation->set_rules("numero","Numero del Documento","required".$is_unique);

		//if ($this->form_validation->run()) {
			$data = array(
				'nombres' => $nombre, 
				'apellidos' => $apellido,
				'telefono' => $telefono,
				'direccion' => $direccion,
				'ruc' => $ruc,
				'empresa' => $empresa,
			);

			if ($this->Clientes_model->update($idcliente,$data)) {
				redirect(base_url()."mantenimiento/clientes");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."mantenimiento/clientes/edit/".$idcliente);
			}
		//}else{
		//	$this->edit($idcliente);
		//}

		

	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Clientes_model->update($id,$data);
		echo "mantenimiento/clientes";
	}
}