<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	public function login($username, $password){
		$this->db->where("usuario", $username);
		$this->db->where("contrasena", $password);

		$resultados = $this->db->get("usuario");
		if ($resultados->num_rows() > 0) {
			return $resultados->row();
		}
		else{
			return false;
		}
	}

	public function save($data){
		return $this->db->insert("usuario",$data);
	}
}
