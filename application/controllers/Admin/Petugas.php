<?php

/**
 * @property $Petugas_model
 * @property $Auth_model
 * @property $input
 * @property $session
 */

class Petugas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Petugas_model');
		$this->load->model('Auth_model');
	}

	/**
	 * @return void
	 */
	public function index():void
	{
		$this->load->view('admin/petugas/list');
	}

	/**
	 * @param $id_petugas
	 *
	 * @return void
	 */
	public function update($id_petugas): void
	{
		// Cek apakah petugas ditemukan
		$data['cek_petugas'] = $this->Petugas_model->getPetugasByIdUser($id_petugas);

		if (is_null($data['cek_petugas'])) {
			// Jika cek_petugas null, kirimkan data kosong
			$data['petugas'] = [];
			$data['id_petugas'] = null;
		} else {
			// Jika cek_petugas tidak null, ambil data petugas berdasarkan id_petugas
			$data['petugas'] = $this->Petugas_model->getPetugasById($data['cek_petugas']['id_petugas']);
			$data['id_petugas'] = $data['cek_petugas']['id_petugas'];
		}

		// Load view dengan data
		$this->load->view('admin/petugas/edit', $data);
	}


	/**
	 * @param $id
	 *
	 * @return void
	 */
	public function edit($id):void
	{
		$id_users 		= $this->input->post('id_users');
		$nama_lengkap 	= $this->input->post('nama_lengkap');
		$alamat	 		= $this->input->post('alamat');
		$jenis_kelamin 	= $this->input->post('jenis_kelamin');
		$tanggal_lahir 	= $this->input->post('tanggal_lahir');

		$data = [
			'id_users'		=> $id_users,
			'nama_lengkap'	=> $nama_lengkap,
			'alamat'		=> $alamat,
			'jenis_kelamin'	=> $jenis_kelamin,
			'tanggal_lahir'	=> $tanggal_lahir,
		];

		$update_petugas = $this->Petugas_model->update($data['id_users'], $data);

		if($update_petugas){
			$this->session->set_flashdata('success', 'Berhasil update petugas');
		}else {
			$this->session->set_flashdata('error', 'Gagal update petugas');
		}
		redirect(base_url('admin/petugas'));
	}

	/**
	 * @return void
	 */
	public function register(): void
	{
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$data = [
			'username'	=> $username,
			'email'		=> $email,
			'password'	=> password_hash($password, PASSWORD_DEFAULT),
			'role'		=> 'petugas'
		];

		$insert = $this->Auth_model->insert($data);

		if ($insert) {
			$this->session->set_flashdata('success', 'Data berhasil ditambahkan');
		}else {
			$this->session->set_flashdata('error', 'Data gagal ditambahkan');
		}
		redirect('admin/petugas');
	}

	/**
	 * @return void
	 */
	public function insert():void
	{
		$id_users = $this->input->post('id_users');
		$nama_lengkap = $this->input->post('nama_lengkap');
		$alamat = $this->input->post('alamat');
		$jenis_kelamin = $this->input->post('jenis_kelamin');
		$tanggal_lahir = $this->input->post('tanggal_lahir');

		$data = [
			'id_users' => $id_users,
			'nama_lengkap' => $nama_lengkap,
			'alamat' => $alamat,
			'jenis_kelamin' => $jenis_kelamin,
			'tanggal_lahir' => $tanggal_lahir
		];

		$insert = $this->Petugas_model->insert($data);

		if ($insert) {
			$this->session->set_flashdata('success', 'Data berhasil ditambahkan');
		}else {
			$this->session->set_flashdata('error', 'Data gagal ditambahkan');
		}
		redirect('admin/petugas');
	}

	public function get_data_petugas(): void
	{
		$fetch_data = $this->Auth_model->make_datatables();
		if (is_array($fetch_data)) {
			$data = array();
			$start = $_POST['start'];
			$no = $start + 1;
			foreach ($fetch_data as $row) {
				$sub_array = array();
				$sub_array[] = $no++;
				$sub_array[] = $row->username;
				$sub_array[] = $row->email;
				$sub_array[] = $row->role;
				$sub_array[] = '<a href="' . site_url('admin/edit_petugas/' . $row->id_users) . '" class="btn btn-info btn-xs update"><i class="fa fa-edit"></i></a>
                     <a href="' . site_url('admin/deletePetugas/' . $row->id_users) . '" onclick="return confirm(\'Apakah anda yakin?\')" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></a>';
				$data[] = $sub_array;
			}

			$output = array(
				"draw" => intval($_POST["draw"]),
				"recordsTotal" => $this->Auth_model->get_all_data(),
				"recordsFiltered" => $this->Auth_model->get_filtered_data(),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			echo "Error: Fetch data is not an array.";
		}
	}

	public function delete($id_petugas)
	{
		$delete_petugas = $this->Petugas_model->delete($id_petugas);

		if ($delete_petugas) {
			$this->session->set_flashdata('success', 'Data berhasil dihapus');
		}else {
			$this->session->set_flashdata('error', 'Data gagal dihapus');
		}
		redirect(base_url('admin/petugas'));
	}
}
