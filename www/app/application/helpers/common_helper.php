<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists('hash_password'))
{
	function hash_password($password)
	{
		return hash("sha256",$password);
	}
}