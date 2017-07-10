<?php 
    class MY_Controller extends CI_Controller{
        // protected $data = [];
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->database();
	        $this->load->library(array('form_validation','session'));
	        $this->load->helper(array('language','form','common'));
		    $this->load->model('accounts_model');
			$this->load->model('brands_model');
	    }

		public function check_expired_account()
		{
			$id = $this->session->userdata('account_id');
			$userinfo = $this->accounts_model->get_account_by_id($id);

			if(!$userinfo)
			{
				redirect('auth/logout');
				return ;
			}
	    }  

    }

?>