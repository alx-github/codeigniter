<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function generate_password()
	{
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->helper('string');
		$password = array('password' => random_string('alnum', 10));
		
		$this->output->set_output(json_encode($password, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}
}