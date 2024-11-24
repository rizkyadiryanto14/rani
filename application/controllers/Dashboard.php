<?php

/**
 * @property $File_model
 * @property $Petugas_model
 */
class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('File_model');
		$this->load->model('Petugas_model');
	}

	public function index()
	{
		$data['public'] 	= $this->File_model->get_public_counts();
		$data['private'] 	= $this->File_model->get_private_counts();
		$data['petugas']		= $this->Petugas_model->get_all_data();
		$data['file']			= $this->File_model->get_all_data();
		$this->load->view('dashboard', $data);
	}
}
