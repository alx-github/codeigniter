<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends MY_Controller {
	
	public function __construct()
    {
    	parent::__construct();
 
    }   



	public function index()
	{	
		parent::check_expired_account();
		if($this->session->userdata('login_id'))
		{
			redirect('/account');
		}
		else
		{
			redirect('/auth');
		}
		
	}
	
}
