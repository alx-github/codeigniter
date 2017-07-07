<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Brands_model extends CI_Model{
	private $table_brands= 'brands';
	private $table_accounts_brands= 'account_brand';
	
	public function __construct()
	{
		parent::__construct();
	}

	public function load_list_brands()
	{
		$this->db->select('*');
		$this->db->from($this->table_brands. ' BR');
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
		return $result->result_array();
	}


	public function load_brand_by_account($account_id)
	{
		$this->db->distinct();
		$this->db->select('BR.*');
		$this->db->from($this->table_brands. ' BR');
		$this->db->join($this->table_accounts_brands .' ABR', 'BR.id=ABR.brand_id','LEFT JOIN');
		$this->db->where('ABR.account_id',$account_id);
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
		return $result->result_array();
	}

	public function update_brands($account_id, $list_brands)
	{
		// delete first
		$this->db->trans_start();		
		$this->db->where('account_id', $account_id);
		$this->db->delete($this->table_accounts_brands);
		$this->db->trans_complete();

		for ($i=0; $i<sizeof($list_brands);$i++)
		 {
			$query = $this->db->insert_string($this->table_accounts_brands,['account_id'=>$account_id,'brand_id'=>$list_brands[$i]]);
			$result = $this->db->query($query);
			if ( ! $result)
			{
				throw new Exception($this->db->error()['message']);
			}
		}
		return $this->db->trans_status();

	
	}

}