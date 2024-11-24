<?php

/**
 * @property $File_model
 * @property $upload
 * @property $input
 * @property $session
 */

class File extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('File_model');
	}

	public function index()
	{
		$this->load->view('admin/file/list');
	}

	public function update($id_file)
	{
		$files['files'] = $this->File_model->getFileById($id_file);

		$this->load->view('admin/file/edit', $files);
	}

	public function insert()
	{
		$config['upload_path'] = './uploads/files/';
		$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|xls|xlsx|txt';
		$config['max_size'] = 8192; // Maksimal 8 MB
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			$this->session->set_flashdata('error', 'Gagal mengunggah file: ' . $this->upload->display_errors('', ''));
			redirect(base_url('admin/file'));
			return;
		}

		$fileData = $this->upload->data();
		$filePath = 'uploads/files/' . $fileData['file_name'];

		$data = [
			'kategori' => $this->input->post('kategori'),
			'nama_file' => $this->input->post('nama_file'),
			'file' => $filePath,
			'status' => $this->input->post('status'),
			'keterangan' => $this->input->post('keterangan'),
			'created_at' => date('Y-m-d H:i:s'),
		];

		$insert = $this->File_model->insert($data);

		if ($insert) {
			$this->session->set_flashdata('success', 'Sukses menambahkan data.');
		} else {
			$this->session->set_flashdata('error', 'Gagal menambahkan data.');
		}

		redirect(base_url('admin/file'));
	}

	public function get_data_file(): void
	{
		$fetch_data = $this->File_model->make_datatables();
		if (is_array($fetch_data)) {
			$data = array();
			$start = $_POST['start'];
			$no = $start + 1;
			foreach ($fetch_data as $row) {
				$sub_array = array();
				$sub_array[] = $no++;
				$sub_array[] = $row->kategori;
				$sub_array[] = $row->nama_file;
				$sub_array[] = '<a href="' . base_url($row->file) . '" class="btn btn-danger btn-xs" target="_blank">Lihat File</a>';
				if ($row->status == 1) {
					$sub_array[] = '<a href="' . site_url('admin/public/' . $row->id_file) . '" class="btn btn-info"><i class="fa fa-check"></i></a>';
				} else {
					$sub_array[] = '<a href="' . site_url('admin/private/' . $row->id_file) . '" class="btn btn-danger"><i class="fa fa-times"></i></a>';
				}
				$sub_array[] = $row->keterangan;
				$sub_array[] = '<a href="' . site_url('admin/edit/' . $row->id_file) . '" class="btn btn-info btn-xs update"><i class="fa fa-edit"></i></a>
                     <a href="' . site_url('admin/deleteFile/' . $row->id_file) . '" onclick="return confirm(\'Apakah anda yakin?\')" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></a>';
				$data[] = $sub_array;
			}

			$output = array(
				"draw" => intval($_POST["draw"]),
				"recordsTotal" => $this->File_model->get_all_data(),
				"recordsFiltered" => $this->File_model->get_filtered_data(),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			echo "Error: Fetch data is not an array.";
		}
	}

	/**
	 * @param $id_file
	 *
	 * @return void
	 */
	public function delete($id_file):void
	{
		$data = $this->File_model->delete($id_file);

		if ($data) {
			$this->session->set_flashdata('success', 'Sukses menghapus data.');
		}else {
			$this->session->set_flashdata('error', 'Gagal menghapus data.');
		}
		redirect(base_url('admin/file'));
	}

	/**
	 * @param $id_file
	 *
	 * @return void
	 */
	public function public($id_file):void
	{
		$data = [
			'status' => '0',
		];

		$update_status = $this->File_model->update_status($id_file, $data);

		if ($update_status){
			$this->session->set_flashdata('success', 'Data berhasil di publik');
		}else {
			$this->session->set_flashdata('error', 'Data gagal di publik');
		}
		redirect(base_url('admin/file'));
	}

	public function private($id_file)
	{
		$data = [
			'status' => '1',
		];

		$update_status = $this->File_model->update_status($id_file, $data);

		if ($update_status){
			$this->session->set_flashdata('success', 'Data berhasil di private');
		}else {
			$this->session->set_flashdata('error', 'Data gagal di private');
		}
		redirect(base_url('admin/file'));
	}

}
