<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index(){
		$data = array();
		$data['title'] = 'Home';
		$data['contacts'] = $this->home_model->getContacts();
		$this->load->view('index',$data);
	}
	public function allContacts(){
		$result = $this->home_model->getContacts();
		echo json_encode($result);
	}
	public function saveContact(){
		$data = array();
		$data['name'] = $this->input->post('name');
		$data['email'] = $this->input->post('email');
		$data['phone'] = $this->input->post('phone');
		$insert = $this->db->insert('contacts',$data);

		$msg['ok'] = false;
		if($insert){
			$msg['ok'] = true;
		}
		echo json_encode($msg);
	}

	public function updateContact(){
		$id = $this->input->post('id');
		$data = array();
		$data['name'] = $this->input->post('name');
		$data['email'] = $this->input->post('email');
		$data['phone'] = $this->input->post('phone');
		$insert = $this->db->where('id',$id)->update('contacts',$data);
		$msg['ok'] = false;
		if($insert){
			$msg['ok'] = true;
		}
		echo json_encode($msg);
	}

	public function editContact($id){
		$result = $this->home_model->getSingleContact($id);
		echo json_encode($result);
	}
	public function deleteContact($id){
		$delete = $this->db->where('id',$id)->delete('contacts');
		$msg['ok'] = false;
		if($delete){
			$msg['ok'] = true;
		}
		echo json_encode($msg);
	}	

}
