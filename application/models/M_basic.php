<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_basic extends CI_Model {

	function __construct()
	{
		parent::__construct();
		// $this->mhs = 'mahasiswa';
		// $this->account = 'login';
	}

// GET DATA

	function getAllData($table, $where = null, $order = null)
	{
		if ($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}

		if ($order !== null) {
			foreach ($order as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}

		$query = $this->db->get($table);

		return $query;
	}

	function getAllDataOr($table, $where = null, $order = null)
	{
		if ($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->or_where($key, $value);
			}
		}

		if ($order !== null) {
			foreach ($order as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}

		$this->db->where('tahun_ajaran', $this->session->tahun_ajaran);
		$query = $this->db->get($table);

		return $query;
	}

	function getNumRows($table, $where = null)
	{
		if ($where !== null) {
			$query = $this->db->get_where($table, $where);
		} else {
			$query = $this->db->get($table);
		}

		return $query->num_rows();
	}

	function getDistinctData($table, $row, $order = null)
	{
		$this->db->distinct();

		$this->db->select($row);

		if ($order !== null) {
			foreach ($order as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}

		$query = $this->db->get($table);

		return $query;
	}

	function getDistinctWhereData($table, $row, $where)
	{
		$this->db->distinct();

		$this->db->select($row);

		$this->db->where($where);

		$this->db->order_by('tahun_ajaran', 'DESC');

		$query = $this->db->get($table);

		return $query;
	}

	function getDistinctDataOrder($table, $where = null, $row, $order)
	{
		$this->db->distinct();

		$this->db->select($row);

		if ($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}

		foreach ($order as $key => $value) {
			$this->db->order_by($key, $value);
		}

		$query = $this->db->get($table);

		return $query;
	}

// INSERT DATA

	function insertData($table, $data)
	{
		$this->db->insert($table, $data);
	}

	function insertAllData($table, $data)
	{
		$this->db->insert_batch($table, $data);
	}

	function insertMultiple($table1, $data1, $table2, $data2)
	{
		$this->db->trans_start();
		$this->db->insert_batch($table1, $data1);
		$this->db->insert($table2, $data2);
		$this->db->trans_complete();
	}

// UPDATE DATA

	function updateData($table, $data, $where){
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	function updateMultipleData($data1, $data2, $where)
	{
		$this->db->trans_start();
		$this->db->where($where);
		$this->db->update('mhs_profil', $data1);
		$this->db->where($where);
		$this->db->update('mhs', $data2);
		$this->db->trans_complete();
	}
}
