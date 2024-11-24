<?php

/**
 *
 * @property $db
 */

class Petugas_model extends CI_Model
{
	public function insert($data)
	{
		return $this->db->insert('petugas', $data);
	}

	public function getPetugasById($id_petugas)
	{
		return $this->db->get_where('petugas', ['id_petugas' => $id_petugas])->row_array();
	}

	public function getPetugasByIdUser($id_user)
	{
		return $this->db->get_where('petugas', ['id_user' => $id_user])->row_array();
	}

	public function update($id_users, $data)
	{
		$this->db->where('id_users', $id_users);
		return $this->db->update('petugas', $data);
	}

	public function delete($id_petugas)
	{
		$this->db->where('id_petugas', $id_petugas);
		return $this->db->delete('petugas');
	}

	function make_query()
	{
		$this->db->select('petugas.*')
			->from("petugas");
		if (isset($_POST["search"]["value"])) {
			$this->db->like("alamat", $_POST["search"]["value"]);
			$this->db->or_like("nama_lengkap", $_POST["search"]["value"]);
		}
		if (isset($_POST["order"])) {
			$this->db->order_by($_POST['order']['0']['column'], $_POST['order']['0']['dir']);
		} else {
			$this->db->order_by('id_petugas', 'DESC');
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
		$this->db->from("petugas");
		return $this->db->count_all_results();
	}
}
