<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MY_Controller {
	
	
	protected $data = null;
	protected $limit = 2;
	protected $range = 2;
	protected $pagination = [ 'pages' => null,
	                        'curPage' => 1,
	                       'prevPage' => 1,
	                       'nextPage' => 1,
	                   'showPrevPage' => false,
	                   'showNextPage' => false,
	                   	    'minPage' => 0,
	                        'maxPage' => 0,
	                  'showFisrtPage' =>false,
	                   'showLastPahe' =>false,
	                      'totalPage' => 0                    
	];  

	public function __construct()
    {
        parent::__construct();
		define('INSERT_MODE', 1);
		define('UPDATE_MODE', 2);
     
      
    }   



	public function index()
	{
		parent::check_expired_account();
		if($this->session->userdata('login_id'))
		{	
			if($this->session->userdata('type') == 1 )
			{
				$this->pagination['curPage'] = 1;
			
				if($this->input->get('page') > 1 )
				{	
					$quantity_accounts =  $this->accounts_model-> get_quantity_of_accounts();

					if($quantity_accounts< $this->input->get('page')*$this->limit)
					{
						$this->pagination['curPage'] =ceil( $quantity_accounts/$this->limit);
					}
					else
					{
						$this->pagination['curPage'] = $this->input->get('page');
					}
				}
				$offset = ($this->pagination['curPage'] - 1)*$this->limit;

				$this->render_list_accounts($this->limit, $offset);
			}
			else
			{
				$this->render_list_accounts(1, 0);	
			}		
			

		}
		else
		{
			redirect('/auth');
		}
		
	}

	public function create()
	{
		parent::check_expired_account();
		if($this->session->userdata('type') !=  1 )
		{
			redirect('/account');
		}
		print_r($this->data['account']['login_id']);
		$this->data['account'] = $this->create_empty_account();
		$this->data['list_brands'] = $this->brands_model->load_list_brands();
		$this->render_form_account();
	}

	public function edit()
	{
		parent::check_expired_account();
		if($this->session->userdata('type') !=  1 )
		{

			if($this->session->userdata('account_id') != $this->input->get('id'))
			{
				// redirect('account');
			}
		}

		$current_account = $this->accounts_model->get_account_by_id($this->input->get('id'));
		if(!$current_account)
		{
			redirect('/account');
			return;
		}
		$account_brands = $this->brands_model->load_brand_by_account($current_account['id']);
		$current_account['brands']= $account_brands;
		$this->data['account'] = $current_account;
		$this->data['list_brands'] = $this->brands_model->load_list_brands();
		$this->data['mode'] = UPDATE_MODE;
		$this->render_form_account();
	}

	public function delete()
	{
		parent::check_expired_account();
		if($this->session->userdata('type') !=  1 )
		{
			redirect('/account');
		}

		$delete_id = $this->input->post('id');
		if(empty($delete_id) || $delete_id == $this->session->userdata('account_id') )
		{
			redirect('account');
			return;
		}
		$result = $this->accounts_model->delete_id($delete_id);
		if($result)
		{
			
			$this->session->set_flashdata('message','ユーザーを削除しました');
			redirect('/account');
		}
		else
		{
			$this->session->set_flashdata('error_message', 'ユーザーを削除することができません');
		}
		redirect('account/edit?id='.$delete_id);


	}

	private function validate_form($mode)
	{
		if($mode == INSERT_MODE)
		{
			$this->form_validation->set_rules('login_id','ID','trim|required|regex_match[/^[a-zA-Z0-9_\-]+$/]');
			$this->form_validation->set_rules('password','password','trim|required|min_length[6]|regex_match[/^[a-zA-Z0-9_\-]+$/]');
			if($this->accounts_model->get_account($this->input->post('login_id')))
	        {
	        	$this->session->set_flashdata('error_message','ID exists');
	            return false;
	        }
		}
		else
		{
			$this->form_validation->set_rules('password','password','trim|min_length[6]|regex_match[/^[a-zA-Z0-9_\-]+$/]');
		}
        if(!$this->form_validation->run())
        {


            $this->session->set_flashdata('error_message',validation_errors());
            return false;
        }

        return true;
	}


	public function insert()
	{
		parent::check_expired_account();
	    $this->data['mode'] = INSERT_MODE;
		$this->data['account']['login_id'] =  $this->input->post('login_id');
        $this->data['account']['password'] = hash_password($this->input->post('password')) ;
        $this->data['account']['type'] = $this->input->post('type');
        $this->data['list_brands'] = $this->brands_model->load_list_brands();
      
		if($this->validate_form(INSERT_MODE) == false)
		{
			$this->data['account']['brands'] = $this->input->post('brands[]');
			$this->render_form_account();
			return;	
		} 

        

        $insert_id = $this->accounts_model->insert_account($this->data['account']);

        $result= null;
        if($this->data['account']['type'] == 1)
        {
        	$list_id_brands = $this->brands_model->load_list_id_brands();
        	$list_all_brands=[];
        	foreach ($list_id_brands as $key => $value)
        	{
        		$list_all_brands[$key] = $value['id'];
        	}
        	$result = $this->brands_model->update_brands($insert_id, $list_all_brands);
        }
        else
        {
        	$result = $this->brands_model->update_brands($insert_id, $this->input->post('brands[]'));
        }
       
        if ($result)
		{
			$this->session->set_flashdata('message', "アカウント情報を更新しました");
		}
		else
		{
			$this->session->set_flashdata('error_message', 'アカウント情報を更新することができません');
		}
        redirect('/account');
	}

	public function update()
	{
		parent::check_expired_account();
		$this->data['mode'] = UPDATE_MODE;
		$this->data['account']['id'] =  $this->input->post('id');
		$this->data['account']['login_id'] =  $this->input->post('login_id');
        $this->data['account']['password'] = hash_password($this->input->post('password')) ;
        $this->data['account']['type'] = $this->input->post('type');
        $this->data['list_brands'] = $this->brands_model->load_list_brands();
		if($this->validate_form(UPDATE_MODE) == false)
		{
			$this->data['account']['brands'] = $this->input->post('brands[]');
			$this->render_form_account();
			return;	
		} 
		if($this->input->post('password'))
		{
			$this->data['account']['password'] = hash_password($this->input->post('password'));
		}
		else 
		{
			$old_password = $this->accounts_model->get_account_by_id($this->data['account']['id'])['password'];
			$this->data['account']['password'] = $old_password;
		}
       	
		$result_update  = $this->accounts_model->update_account($this->data['account']);

		if($this->session->userdata('type') == 1)
		{

			$result= null;
	        if($this->data['account']['type'] == 1)
	        {
	        	$list_id_brands = $this->brands_model->load_list_id_brands();
	        	$list_all_brands=[];
	        	foreach ($list_id_brands as $key => $value)
	        	{
	        		$list_all_brands[$key] = $value['id'];
	        	}
	        	$result = $this->brands_model->update_brands($this->data['account']['id'], $list_all_brands);
	        }
	        else
	        {
	        	$result = $this->brands_model->update_brands($this->data['account']['id'], $this->input->post('brands[]'));
	        }
	       
	        if ($result)
			{
				$this->session->set_flashdata('message', "アカウント情報を更新しました");
			}
			else
			{
				$this->session->set_flashdata('error_message', 'アカウント情報を更新することができません');
			}
		}
       

        
        redirect('account');
	}


	private function render_list_accounts($limit,$offset)
	{
		$list_accounts =[];
		if($this->session->userdata('type') ==1)
		{
			$list_accounts = $this->accounts_model->load_all_account($limit,$offset);

		}
		else
		{
			
			$current_account = $this->accounts_model->get_account($this->session->userdata('login_id'));
			$list_accounts[0]=$current_account;
		}
		

		for( $i = 0 ; $i < sizeof($list_accounts) ; $i++)
		{
		 $item = $list_accounts[$i];
		 $list_accounts[$i]->list_brands= $this->brands_model->load_brand_by_account($item->id);
			
		}

		$quantity_accounts =  $this->accounts_model-> get_quantity_of_accounts();
		$number_of_pages  = round( $quantity_accounts / $this->limit ,0);
		
		$middle = ceil($this->range/2);
		if($number_of_pages< $this->range )
		{
			$this->pagination['minPage'] = 1;
			$this->pagination['maxPage'] = $number_of_pages;
		}
		else
		{
			$this->pagination['minPage'] = $this->pagination['curPage'] - ($middle );
			$this->pagination['maxPage'] = $this->pagination['curPage'] + ($middle );
			if($this->pagination['minPage'] <= 1)
			{
				$this->pagination['minPage'] = 1;
				$this->pagination['maxPage'] = $this->range;
			}
			if ($this->pagination['maxPage'] >= $number_of_pages ) 
			{
				$this->pagination['maxPage'] = $number_of_pages;
				$this->pagination['minPage'] = $number_of_pages - $this->range+1;
				
			}	
		}
		

		$pages = [];
		for($i = $this->pagination['minPage'] ; $i <= $this->pagination['maxPage'] ; $i++)
		{
			 array_push($pages,['key'=>$i, 'isActive'=> $i == +$this->pagination['curPage']]);
		}

		$this->pagination['pages'] = $pages;
		$this->pagination['prePage'] =$this->pagination['curPage'] - 1;
		$this->pagination['nextPage'] = $this->pagination['curPage'] +1;
 		$this->pagination['showPrePage'] = $this->pagination['curPage'] > 1 ;
		$this->pagination['showNextPage'] = $this->pagination['curPage'] < ($number_of_pages);
		$this->pagination['showFirstPage'] = $this->pagination['curPage'] !=1 &&($this->pagination['minPage'] != 1);
		$this->pagination['showLastPage'] = ($this->pagination['curPage'] != ($number_of_pages)) &&($this->pagination['maxPage'] != $number_of_pages);
		$this->pagination['totalPage'] = ($number_of_pages);

		$this->data['pagination'] = $this->pagination;
		$this->data['list_accounts'] = $list_accounts;
		
		$this->load->view('templates/header',array('current' =>'account'));
	 	$this->load->view('account/list_accounts',$this->data);
	 	$this->load->view('templates/footer');
	}


	private function render_form_account()
	{
		$this->load->view('templates/header',array('current' =>'account'));
	 	$this->load->view('account/form',$this->data);
	 	$this->load->view('templates/footer');
	}
	private function create_empty_account()
	{

		return ['id'=>null,
				'login_id'=> null,
				'password'=> null,
				'type'=> null
				];
	}



	
}
