<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardmodel extends CI_Model 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		date_default_timezone_set(DEFAULT_TIME_ZONE);
	}
	
	
	
	//Get User Details functions
	public function getUserDetails($user_id)
	{				
		$this->db->select(TBPREFIX.'users.*');
		$this->db->from(TBPREFIX.'users');
		$this->db->where('user_id',$user_id);
		return $this->db->get()->result_array();
	}
	

}