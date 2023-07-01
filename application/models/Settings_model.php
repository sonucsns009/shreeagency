<?php
Class Settings_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
		
	public function upt_settings($input_data)
	{
		$this->db->where('dsetting_id','1');
		if($this->db->update(TBPREFIX.'driversettings',$input_data))
			return true;
		else
			return false;
	}	

	public function getdriversettinginfo()
	{
		$this->db->select('*');
		$this->db->where('dsetting_id','1');
		return $this->db->get(TBPREFIX.'driversettings')->result_array();
	}
	public function getadminsettinginfo()
	{
		$this->db->select('*');
		$this->db->where('setting_id','1');
		return $this->db->get(TBPREFIX.'admin_settings')->result_array();
	}	
	
	public function upt_adminsettings($input_data)
	{
		$this->db->where('setting_id','1');
		if($this->db->update(TBPREFIX.'admin_settings',$input_data))
			return true;
		else
			return false;
	}	
	
}