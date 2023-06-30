<?php
Class Customerprofilemodel extends CI_Model {
	function __construct()
	{	// Call the Model constructor
		parent::__construct();
	}	
	
	public function getUserProfileInfo($user_id,$qty)
	{
		$this->db->select('*');
		$this->db->where('dseos_users.user_id',$user_id);
		$query=$this->db->get('dseos_users');

		if($qty==1)

			return $query->result_array();

		else

			return $query->num_rows();
	}
	
	public function updateUserProfileInfo($user_datas,$user_id)
	{
		$this->db->where('dseos_users.user_id',$user_id);
		$query=$this->db->update('dseos_users',$user_datas);

		if($query)

			return true;

		else

			return false;
	}
	
	public function updateUserPhoto($user_datas,$user_id)
	{
		$this->db->where('dseos_users.user_id',$user_id);
		$query=$this->db->update('dseos_users',$user_datas);

		if($query)

			return true;

		else

			return false;
	}
	
}