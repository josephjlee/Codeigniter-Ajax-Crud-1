<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

	public function getContacts(){
		$this->db->select('*');
		$this->db->from('contacts');
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	public function getSingleContact($id){
		$this->db->select('*');
		$this->db->from('contacts');
		$this->db->where('id',$id);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
}
