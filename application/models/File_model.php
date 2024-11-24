<?php

/**
 * @property $db
 */

class File_model extends CI_Model
{

	public function getAllFile()
	{
		return $this->db->get('file')->result_array();
	}

	public function getFileById($id)
	{
		return $this->db->get_where('file', ['id_file' => $id])->row_array();
	}

	public function insert($data)
	{
		return $this->db->insert('file', $data);
	}

	public function delete($id_file)
	{
		$this->db->where('id_file', $id_file);
		return $this->db->delete('file');
	}

	public function update_status($id_file, $data)
	{
		$this->db->where('id_file', $id_file);
		return $this->db->update('file', $data);
	}


	function make_query()
	{
		$this->db->select('file.*')
			->from("file");
		if (isset($_POST["search"]["value"])) {
			$this->db->like("keterangan", $_POST["search"]["value"]);
			$this->db->or_like("nama_file", $_POST["search"]["value"]);
		}
		if (isset($_POST["order"])) {
			$this->db->order_by($_POST['order']['0']['column'], $_POST['order']['0']['dir']);
		} else {
			$this->db->order_by('id_file', 'DESC');
		}
	}

	function make_datatables()
	{
		$this->make_query();
		if ($_POST["length"] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		if ($query === false) {
			// Query gagal, handle error di sini
			return false;
		}

		return $query->result();
	}

	function get_filtered_data()
	{
		$this->make_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_all_data()
	{
		$this->db->select("*");
		$this->db->from("file");
		return $this->db->count_all_results();
	}

	public function get_public_counts()
	{
		$this->db->from('file');
		$this->db->where('status', '1');
		return $this->db->count_all_results();
	}

	public function get_private_counts()
	{
		$this->db->from('file');
		$this->db->where('status', '0');
		return $this->db->count_all_results();
	}


}
