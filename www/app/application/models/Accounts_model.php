<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Accounts_model extends CI_Model{
	private $table_name= 'accounts' ;
	public function __construct()
	{
		parent::__construct();
	}



	public function get_account($login_id)
	{
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('login_id',$login_id);
		$result = $this->db->get();

		$this->db->trans_complete();
		if ( !$result)
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

	public function get_type($login_id)
	{
		$this->db->select('type');
		$this->db->from($this->table_name);
		$this->db->where('login_id',$login_id);
		$result = $this->db->get();

		$this->db->trans_complete();
		if ( !$result)
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

	public function get_account_by_id($id)
	{
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('id',$id);
		$this->db->where('deleted_at',null);
		$result = $this->db->get();

		$this->db->trans_complete();
		if ( !$result)
		{
			log_message('error', $this->db->error()['message']);
			return FALSE;
		}
		if (count($result->result()) === 0)
		{
			return FALSE;
		}
		return $result->result_array()[0];
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
		$update_last_login_result = $this->update_data($result->result()[0]->id,['last_login' => date('Y-m-d H:i:s')]); 


	

		return $result->result()[0];
			
	}

	public function get_quantity_of_accounts()
	{
		$this->db->select('count(*) as total');
		$this->db->where('deleted_at', null);
		$result = $this->db->get($this->table_name);
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
		return $result->result()[0]->total;
	}

	public function load_all_account($limit, $offset)
	{   


		$this->db->limit($limit);
		$this->db->offset($offset);
		$this->db->where('deleted_at', null);
		$result = $this->db->get($this->table_name);
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
		return $result->result();
	}


	public function insert_account($account)
	{
		$query = $this->db->insert_string($this->table_name,$account);
		$result = $this->db->query($query);
		if ( ! $result)
		{
			throw new Exception($this->db->error()['message']);
		}
		return $this->db->insert_id();
	}

	public function update_account($account)
	{
		$this->db->trans_start();
		
		$this->db->where('id', $account['id']);
		$this->db->update($this->table_name, $account);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	public function update_data($id,$update_data)
	{
		$this->db->trans_start();
		$this->db->where('id',$id);
		$this->db->update($this->table_name,$update_data);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function delete_id($delete_id)
	{
		$this->db->trans_start();
		$this->db->where('id', $delete_id);
		$this->db->update($this->table_name, ['deleted_at'=>date('Y-m-d H:i:s')]);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

}