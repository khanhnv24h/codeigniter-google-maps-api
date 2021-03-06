<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapsapi extends CI_Controller {
	public function __construct(){
		parent::__construct();

		$this->load->model('Mapsapi_Model');
	}

	public function index(){
		$this->load->view('home');
	}

	public function locations(){
		$data['locations'] = $this->Mapsapi_Model->get_locations();
		$this->load->view('locations',$data);
	}
	public function insert()
	{
		$data = array(
		    'lat' => $this->input->post('lat'),
		    'lng' => $this->input->post('lng'),
		    'description' => $this->input->post('desc')
		);
		
		$this->Mapsapi_Model->insert($data);
	}

	public function delete($id = null)
	{
		if ($id == null) {
			redirect('');
		}

		$result = $this->Mapsapi_Model->delete(['id' => $id]);
		if ($result) {
			$this->session->set_flashdata('result', '<div class="alert alert-success mt-3" role="alert">Successful.</div>');
			redirect('locations');
		} else {
			$this->session->set_flashdata('result', '<div class="alert alert-success mt-3" role="alert">Failed.</div>');
			redirect('locations');
		}
	}

	public function edit($id = null)
	{
		if ($id == null) {
			redirect('');
		}

		$data['edit_page_data'] = $this->Mapsapi_Model->get_a_location(['id' => $id]);
		$this->load->view('home',$data);
	}

	public function edit_action()
	{
		$data = array(
		    'lat' => $this->input->post('lat'),
		    'lng' => $this->input->post('lng'),
		    'description' => $this->input->post('desc')
		);
		
		$result = $this->Mapsapi_Model->update($data,['id' => $this->input->post('id')]);

		if ($result) {
			$this->session->set_flashdata('result', '<div class="alert alert-success mt-3" role="alert">Successful.</div>');
			redirect('locations');
		} else {
			$this->session->set_flashdata('result', '<div class="alert alert-success mt-3" role="alert">Failed.</div>');
			redirect('locations');
		}
	}
}