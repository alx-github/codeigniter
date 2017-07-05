<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Accounts_model extends CI_Model{
	private $table_name= 'accounts' ;
	public function __construct()
	{
		parent::__construct();
	}

	public function login($username,$password)
	{
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('login_id',$username);
		$this->db->where('password',$password);
		$this->db->where('deleted_at',null);

		$result = $this->db->get();

		$this->db->trans_complete();
		if ( ! $result)
		{
			log_message('error', $this->db->error()['message']);
			return FALSE;
		}
		if (count($result->result()) === 0)
		{
			return FALSE;
		}

		return $result->result()[0];
			
	}

	


	public function loadAll()
	{
		// $result = $this->db->get($table_name);
		// $this->db->trans_complete();
		// if ( ! $result)
		// {
		// 	log_message('error', $this->db->error()['message']);
		// 	return FALSE;
		// }
		// if (count($result->result()) === 0)
		// {
		// 	return FALSE;
		// }
		// return $result->result();


	}

}