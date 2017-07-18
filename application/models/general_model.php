<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	var $tbl = 'task';

	public function q_display_task()
	{
		$qry = $this->db->get($this->tbl);

		return $qry->result();
	}

	public function q_save_task($data)
	{
		$this->db->insert($this->tbl, $data);
	}

	public function q_update_task($id, $data)
	{
		$this->db->update($this->tbl, $data, array('id' => $id));
	}

	public function q_get_task($id)
	{
		$q = $this->db->get_where($this->tbl, array('id' => $id));

		return $q->row_array();
	}

	public function q_delete_task($id)
	{
		$this->db->delete($this->tbl, array('id' => $id));
	}

	public function q_check_login($uid, $password)
	{
		$pass = md5($password);

		$this->db->where('username', $uid);
		$this->db->where('password', $pass);
		
		$qry = $this->db->get('user');

		if($qry->num_rows() == 1){
			return $qry->result();
		} else {
			return false;
		}
	}

	public function checkSession()
	{
		if(!$this->session->userdata('sess_uid'))
		{
			redirect('login');
		}
	}
}

?>