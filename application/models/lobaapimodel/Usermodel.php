<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Usermodel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
			date_default_timezone_set(DEFAULT_TIME_ZONE);
		}

		## GET  LATEST APP VERSION
		
		public function insertVersion($arrAppVersion) 
		{
			if($this->db->insert(TBPREFIX.'app_version',$arrAppVersion))
			{
				return $this->db->insert_id();
			}
			else
				return false;
		}
		## GET  LATEST APP VERSION
		
		public function getVersion() 
		{
			$this->db->order_by("releasing_date","desc");
			$this->db->limit(1);
			$result=$this->db->get(TBPREFIX.'app_version')->result_array();
			return $result;  
		}
		//Register functions
		function fetchsingledata($email = '' , $mobile_no = '')
		{				
			$this->db->select('*');
			$this->db->from(TBPREFIX.'users');
			#$this->db->where('emailaddress',$email);
			$this->db->where('mobilenumber',$mobile_no);
			return $this->db->get()->result_array();			
		}
		
		//Register functions
		function checkReferalCodeExists($referal_code = '')
		{				
			$q = $this->db->where('referal_code',$referal_code)
					  ->get(TBPREFIX.'users');
			if($q->num_rows()){

				return $q->result_array();
			}
			else{
				return FALSE;
			} 
		}
		
		
		//Register functions
		function checksingledata($username = '')
		{	
			$this->db->select('*');
			$this->db->from(TBPREFIX.'users');
			$this->db->where('mobilenumber',$username);
			return $this->db->get()->result_array();
		}
		
		function checkUserDetails($uid)
		{
			if($uid > 0)
			{
				$this->db->select('*');
				$this->db->from(TBPREFIX.'user_details');
				$this->db->where('user_id',$uid);
				return $this->db->get()->result_array();
			}
			else
			{	
				return "";
			}
		}
		function checkUserByMobile($mobile)
		{
			if($mobile > 0)
			{
				$this->db->select('*');
				$this->db->from(TBPREFIX.'users');
				$this->db->where('mobile',$mobile);
				return $this->db->get()->result_array();
			}
			else
			{	
				return "";
			}
		}
		function getUserDetails($uid)
		{
			if($uid > 0)
			{
				$this->db->select('*');
				$this->db->from(TBPREFIX.'users');
				$this->db->where(TBPREFIX.'users.user_id',$uid);
				return $this->db->get()->result_array();			
			}
			else
			{
				return "";
			}
			
		}
		## CHECK  OTP from  Mob and OPT CODE
		function checkOtp($mobile_no = '' , $otp = '')
		{				
			$this->db->select('*');
			$this->db->from(TBPREFIX.'users');
			$this->db->where('temp_otp',$otp);
			$this->db->where('mobile',$mobile_no);
			return $this->db->get()->result_array();
		}
		 
		public function insert_new_user($data)
		{
			if($this->db->insert(TBPREFIX.'users',$data))
			{
				return $this->db->insert_id();
			}
			else
				return false;
			#return $query=$this->db->insert('birth',$data);
		}
		
		public function insert_new_socialuser($data)
		{
			if($this->db->insert(TBPREFIX.'users_social',$data))
			{
				return $this->db->insert_id();
			}
			else
				return false;
			 
		}
		
		### UPDATE PROFILE  ID  
		public function updateProfileNo($uid,$profile_id,$strRegStep) {
		   if($uid){
				$this->db->set('profile_id',$profile_id);
				$this->db->where('user_id',$uid);
				$this->db->update(TBPREFIX.'users');    
		   }
		   #print $this->db->last_query(); exit;

		}

		public function updateProfileRegStep($uid,$strRegStep) {
		   if($uid){
				$this->db->set('reg_step',$strRegStep);
				$this->db->set('user_status',"Active");
				$this->db->where('user_id',$uid);
				$this->db->update(TBPREFIX.'users');    
		   }
		   #print $this->db->last_query(); exit;

		}
		public function insert_new_user_details($data)
		{
			if($this->db->insert(TBPREFIX.'user_details',$data))
			{
				return $this->db->insert_id();
			}
			else
				return false;
			#return $query=$this->db->insert('birth',$data);
		}
		
		public function update_new_user_details($updateUserDetails, $uid)
		{
			$this->db->where('user_id', $uid);
			 
			if($this->db->update(TBPREFIX.'user_details',$updateUserDetails))
			{
				return $this->db->affected_rows();
			}
			else
				return false;
		}

		public function checkpassword($oldpassword = '', $user_id = '')
		{
			$query = $this->db->query("SELECT * FROM ".TBPREFIX."users WHERE password='$oldpassword' AND user_id='$user_id' ");

			return $query->num_rows();	
		}
		
		public function updateData($user_id,$data = array(),$user = '') {
		  	if($user_id > 0) 
			{
				if($data['temp_otp'] != "")
					$this->db->set('temp_otp',$data['temp_otp']);
		  		
				if($data['fcm_token'] != "")
					$this->db->set('device_id',$data['fcm_token']);
		  		
				
				
			  	$this->db->where('user_id',$user_id);
			  	$this->db->update(TBPREFIX.'users'); 
		  	}
		} 
		public function updateUserData($user_id,$data = array()) {
		  	if($user_id > 0) 
			{
				
				
			  	$this->db->where('user_id',$user_id);
			  	$this->db->update(TBPREFIX.'users',$data); 
		  	}
		} 
		public function updateStep2Data($user_id,$gender="") {
		  	if($user_id > 0) 
			{
		  		$this->db->set('ugender',$gender);
		  		$this->db->where('user_id',$user_id);
			  	$this->db->update(TBPREFIX.'users'); 
		  	}
		} 
		public function updateDatatoken($user_id,$utoken,$user = '')
		{
		  	if($user_id > 0 ) {
		  		$this->db->set('utoken',$utoken);
			  	$this->db->where('user_id',$id);
			  	$this->db->update(TBPREFIX.'users'); 
		  	} 
		} 
		
		### CHECK IF USER EXISTS
		function getDataByForgotOTP($username = '' , $otp = '')
		{				
			$this->db->select('*');
			$this->db->from(TBPREFIX.'users');
			$this->db->where('mobilenumber',$username);
			$this->db->where('otp_forgot_code',$otp);
			return $this->db->get()->result_array();
		}
		
		  	
		public function updateForgotPasswordOtp($user_id,$data = array()) {
			if($user_id > 0) {
		  		$this->db->set('otp_forgot_code',$data['otp_code']);
		  		$this->db->set('dateupdated',date('Y-m-d H:i:s'));
		  		$this->db->where('user_id',$user_id);
			  	$this->db->update(TBPREFIX.'users'); 
		  	}
		} 
		
		### UPDATE paswword (FORGOT PWD)
		public function updatePassword($user_id,$otp_code,$strPassword,$mobile_no)
		{
		  	if($user_id > 0 && $strPassword !="" ) {
		  		$this->db->set('upassword',md5($strPassword));
			  	$this->db->where('user_id',$user_id);
			  	$this->db->where('otp_forgot_code',$otp_code);
			  	$this->db->where('mobilenumber',$mobile_no);
			  	$this->db->update(TBPREFIX.'users'); 
				return 1;
		  	}
			else
				return 0;
		} 
		
		public function getPointsSetting($selectMode)
		{
			$this->db->select($selectMode);
			$this->db->where('setting_id',1);
			$query=$this->db->get(TBPREFIX."admin_settings");
			$res=$query->result_array();
			return $points=$res[0][$selectMode];
		}
			
		public function updateUserTotalPoints($uid,$registerPoints)
		{
			$this->db->set('total_points', 'total_points + ' . (int) $registerPoints, FALSE);
			$this->db->where('user_id',$uid);
			$query=$this->db->update(TBPREFIX."users");
			if($query)
				return true;
			else
				return false;
		}
		
		public function addUserPoints($arrUserPoints)
		{
			if($this->db->insert(TBPREFIX.'user_points',$arrUserPoints))
			{
				return $this->db->insert_id();
			}
			else
				return false;
		}
		
		public function updatestep1_user($updateUserDetails, $uid)
		{
			$this->db->where('user_id', $uid);
			 
			if($this->db->update(TBPREFIX.'users',$updateUserDetails))
			{
				return $this->db->affected_rows();
			}
			else
				return false;
		}
		
		
		
		
		public function calcualteAge($dob)
		{
			if(!empty($dob))
			{
				$birthdate = new DateTime($dob);
				$today   = new DateTime('today');
				$age = $birthdate->diff($today)->y;
				return $age;
			}
			else
			{
				return 0;
			}
		}
		
		public function updateUserPhoto($arrupdtPhoto, $uid)
		{
			$this->db->where('user_id', $uid);
			 
			if($this->db->update(TBPREFIX.'users',$arrupdtPhoto))
			{
				return $this->db->affected_rows();
			}
			else
				return false;
		}
		
		public function updatestep3_user($updateUserDetails, $uid)
		{
			$this->db->where('user_id', $uid);
			 
			if($this->db->update(TBPREFIX.'user_details',$updateUserDetails))
			{
				return $this->db->affected_rows();
			}
			else
				return false;
		}
		
		function checkOldPasswordAvailable($old_password, $uid)
		{				
			$this->db->select('user_id');
			$this->db->from(TBPREFIX.'users');
			$this->db->where('user_id', $uid);
			$this->db->where('upassword',$old_password);
			return $this->db->get()->num_rows();			
		}
		
		public function updatestep4_user($arrUpdateData1, $uid)
		{
			$this->db->where('user_id', $uid);
			if($this->db->update(TBPREFIX.'users',$arrUpdateData1))
			{
				return $this->db->affected_rows();
			}
			else
				return false;
		}
		
		public function checkMobileUsers($mobilenumber,$uid)
		{
			$this->db->where('user_id !=', $uid);
			$this->db->where('mobilenumber', $mobilenumber);
			$res=$this->db->get(TBPREFIX.'users');
			return $res->num_rows();
		}
		
		public function checkEmialUSers($emailaddress,$uid)
		{
			$this->db->where('user_id !=', $uid);
			$this->db->where('emailaddress', $emailaddress);
			$res=$this->db->get(TBPREFIX.'users');
			return $res->num_rows();
		}
		
		public function getUserDetailsProfile($uid,$qty)
		{
			$this->db->select('*');
				$this->db->from(TBPREFIX.'users');
				$this->db->where(TBPREFIX.'users.user_id',$uid);
				if($qty==1)
				return $this->db->get()->result_array();
			else
				return $this->db->get()->num_rows();
			
		}
		
		public function getUserIDFRomOrder($order_id,$qty)
		{
			$this->db->select('user_id');
				$this->db->from(TBPREFIX.'item_orders');
				$this->db->where(TBPREFIX.'item_orders.order_id',$order_id);
				if($qty==1)
				return $this->db->get()->result_array();
			else
				return $this->db->get()->num_rows();
		}
		
		public function addUserNotificationSpecially($noti_array)
		{
			if($this->db->insert(TBPREFIX.'notification',$noti_array))
			{
				return $this->db->insert_id();
			}
			else
				return false;
		}
		
		public function checkUserNotificationExists($uid,$qty,$type)
		{
			$this->db->select('*');
			$this->db->from(TBPREFIX.'notification');
			if($type != "")
				$this->db->where(TBPREFIX.'notification.noti_user_type',$type);
			
			$this->db->where(TBPREFIX.'notification.noti_user_id',$uid);
			$this->db->order_by(TBPREFIX.'notification.noti_id','DESC');
			$this->db->limit(100);
			if($qty==1)
			return $this->db->get()->result_array();
			else
				return $this->db->get()->num_rows();
			
		}
		/*public function getOrderINFOS($noti_order_id)
		{
			$this->db->select('order_selling_amount as ,order_no');
			$this->db->from(TBPREFIX.'item_orders');
			$this->db->where(TBPREFIX.'item_orders.order_id',$noti_order_id);
			return $this->db->get()->result_array();
			
		}*/
		
		public function updateuserupdatedTime($order_id)
		{
			$this->db->set(TBPREFIX.'item_orders.dateupdated',date('Y-m-d H:i:s'));
				$this->db->where(TBPREFIX.'item_orders.order_id',$order_id);
				$this->db->update(TBPREFIX.'item_orders');
				return $this->db->affected_rows();
		}

		public function newupdateDataadded($user_id,$name) {
		  	if($user_id > 0) 
			{
				$this->db->set('fullname',$name);
					$this->db->where('user_id',$user_id);
			  	$this->db->update(TBPREFIX.'users'); 
		  	}
		} 

		public function newupdateDataadded1($user_id,$emailaddress) {
		  	if($user_id > 0) 
			{
					$this->db->set('email',$emailaddress);
					$this->db->where('user_id',$user_id);
			  	$this->db->update(TBPREFIX.'users'); 
		  	}
		} 
	}
	
	
	
	
	/* End of file userModel.php */
	/* Location: ./application/models/userModel.php */
?>