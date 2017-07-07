<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    protected $data = ['login_id' => null,
                    'password' => null];
    

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('form_validation','session'));
        $this->load->helper(array('language','form','common'));
          
    }   

    public function index()
    {
        $this->login();
    } 

    public function login()
    {
     if($this->session->userdata('login_id'))
        {
            redirect('/manage');
        }

        if($this->input->post())
        {
            $this->verify_login();
        }
        else
        {
           
            $this->render_login();
        }
    }

    public function logout()
    {
        $this->render_logout();
    }
    
    
    
    private function verify_login()
    {
        
       
        $this->form_validation->set_rules('login_id','ID','trim|required|regex_match[/^[a-zA-Z0-9_\-]+$/]');
        $this->form_validation->set_rules('password','password','trim|required|regex_match[/^[a-zA-Z0-9_\-]+$/]');
        if(!$this->form_validation->run())
        {
            $this->session->set_flashdata('error_message',validation_errors());
            $this->render_login();
            return;
        }
        $this->data['login_id'] =  $this->input->post('login_id');
        $this->data['password'] =  $this->input->post('password');
       
        $password_hash = hash_password($this->data['password']);
        $this->load->model('accounts_model');
        $result = $this->accounts_model->login($this->data['login_id'],$password_hash);
        if(!$result)
        {
            $message="ログインできませんでした。";
            $this->session->set_flashdata('error_message',$message);
            $this->render_login();
            return;
        }
        
        $this->session->set_userdata('account_id',$result->id);
        $this->session->set_userdata('login_id', $result->login_id);
        $this->session->set_userdata('type', $result->type);
        redirect('/manage');

    }
    
    private function render_login()
    {
		$this->load->view('templates/header');
		$this->load->view('auth/form_login',$this->data);
		$this->load->view('templates/footer');
	} 



    private function render_logout()
    {
        $this->session->unset_userdata('login_id');
        $this->session->unset_userdata('account_id');
        $this->session->unset_userdata('type');
        $this->session->sess_destroy();
        redirect('/auth');
    }

}