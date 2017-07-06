<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_order extends PX_Model{
	public function __construct() {
		parent::__construct();
	}

	function select_where_api($table,$column,$where,$column1,$where1){
		$this->load->database('default',TRUE);
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($column,$where);
		$this->db->where($column1,$where1);
		$data = $this->db->get()->result_array();
		return $data;
	}
}