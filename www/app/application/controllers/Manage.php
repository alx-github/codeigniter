<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends MY_Controller {
	
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('form_validation','session'));
        $this->load->helper(array('language','form','common'));
	     
     
      
    }   



	public function index()
	{
		
		
		if($this->session->userdata('login_id'))
		{
			$this->render_list_accounts();
		}
		else
		{
			redirect('/auth');
		}
		
	}


	private function render_list_accounts()
	{
		// $this->load->model('account_model');
		// $list_accounts = $this->account_model->loadAll();

		$this->load->view('templates/header');
	 	$this->load->view('manage/list_accounts');
	 	$this->load->view('templates/footer');
	}





	
}
