<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Productos_model");
		$this->load->model("Categorias_model");
	}

	public function index()
	{
		$data  = array(
			'productos' => $this->Productos_model->getProductos(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/productos/list",$data);
		$this->load->view("layouts/footer");

	}
	public function add(){
		$data =array( 
			"categorias" => $this->Categorias_model->getCategorias()
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/productos/add",$data);
		$this->load->view("layouts/footer");
	}

	public function store(){
		$nombre = $this->input->post("nombre");
		$marca = $this->input->post("marca");
		$talle = $this->input->post("talle");
		$color = $this->input->post("color");
		$precio = $this->input->post("precio");
		$detalle = $this->input->post("detalle");


		$nombreI = $_FILES['archivoImagen']['name'];
		$tipo = $_FILES['archivoImagen']['type'];
		$tamaño = $_FILES['archivoImagen']['size'];



		if($tamaño<=1000000){
			if($tipo == "image/jpeg" ||$tipo == "image/jpg" ||$tipo == "image/png" || $tipo == "image/gif"){
				//cargar en una carpeta de destino la imagen
				$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . "/Intranet/Carga/";

				//movemos la imagen
				move_uploaded_file($_FILES['archivoImagen']['tmp_name'],$carpeta_destino.$nombreI);

			}else{

				echo "no se admite ese tipo de formato";
			}	

		}else{

			echo "El tamaño de la foto es superior";
		}

		$categoria = $this->input->post("categoria");


		//$this->form_validation->set_rules("codigo","Codigo","required|is_unique[productos.codigo]");
		$this->form_validation->set_rules("nombre","Nombre","required");
		$this->form_validation->set_rules("precio","Precio","required");
		//$this->form_validation->set_rules("stock","Stock","required");

		if ($this->form_validation->run()) {
			$data  = array(
				'nombre' => $nombre, 
				'marca' => $marca,
				'talle' => $talle,
				'color' => $color,
				'precio' => $precio,
				'detalle' => $detalle,
				'imagenes' =>$nombreI,
				'categoria_id' => $categoria,
				
				'estado' => "1"
			);

			if ($this->Productos_model->save($data)) {
				redirect(base_url()."mantenimiento/productos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."mantenimiento/productos/add");
			}
		}
		else{
			$this->add();
		}

		
	}

	public function edit($id){
		$data =array( 
			"producto" => $this->Productos_model->getProducto($id),
			"categorias" => $this->Categorias_model->getCategorias()
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/productos/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$idproducto = $this->input->post("idproducto");
		$nombre = $this->input->post("nombre");
		$marca = $this->input->post("marca");
		$talle = $this->input->post("talle");
		$color = $this->input->post("color");
		$precio = $this->input->post("precio");
		$detalle = $this->input->post("detalle");
		$categoria = $this->input->post("categoria");

		$productoActual = $this->Productos_model->getProducto($idproducto);

		//if ($codigo == $productoActual->codigo) {
		//	$is_unique = '';
		//}
		//else{
		//	$is_unique = '|is_unique[productos.codigo]';
		//}

		//$this->form_validation->set_rules("codigo","Codigo","required".$is_unique);
		$this->form_validation->set_rules("nombre","Nombre","required");
		$this->form_validation->set_rules("precio","Precio","required");
		//$this->form_validation->set_rules("stock","Stock","required");


		if ($this->form_validation->run()) {
			$data  = array(
				'nombre' => $nombre, 
				'marca' => $marca,
				'talle' => $talle,
				'color' => $color,
				'precio' => $precio,
				'detalle' => $detalle,
				'categoria_id' => $categoria,
			);
			if ($this->Productos_model->update($idproducto,$data)) {
				redirect(base_url()."mantenimiento/productos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."mantenimiento/productos/edit/".$idproducto);
			}
		}else{
			$this->edit($idproducto);
		}

		
	}
	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Productos_model->update($id,$data);
		echo "mantenimiento/productos";
	}

}