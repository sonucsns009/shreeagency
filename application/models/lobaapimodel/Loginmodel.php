<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Loginmodel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
			date_default_timezone_set(DEFAULT_TIME_ZONE);
			//global $strUserTable =TBPREFIX."users";
		}

		//Register functions
		function fetchsingledata($username = '' )
		{				
			$this->db->select('*');
			$this->db->from(TBPREFIX.'users');
			$this->db->where('mobile',$username);
			return $this->db->get()->result_array();			
		}
		
		// Read data using username and password
		public function check_login($username,$password)
		{			
			$q = $this->db->where('mobilenumber',$username)
					  ->where('upassword',$password)
					  ->get(TBPREFIX.'users');
			if($q->num_rows()){

				return $q->row();
			}
			else{
				return FALSE;
			}
		}
		public function get_user_login($username)
		{
			 
			$q = $this->db->where('mobilenumber',$username)
					 	  ->get(TBPREFIX.'users');
			 	
			if($q->num_rows()){

				return $q->row();
			}
			else{
				return FALSE;
			}
		}

		
	}