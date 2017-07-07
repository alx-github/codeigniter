<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends MY_Controller {
	
	public function __construct()
    {
    	parent::__construct();
        $this->load->library(array('form_validation','session'));
        $this->load->helper(array('language','form','common'));
      
    }   



	public function index()
	{
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
