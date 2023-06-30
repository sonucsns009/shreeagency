<?php
Class Service_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	
	public function check_adminexists($admin_email,$username,$adminId="")
	{
		if($adminId> 0)
			$query="SELECT admin_id FROM ".TBPREFIX."admin WHERE (admin_email = '$admin_email' OR username ='$username') AND admin_id != $adminId"; 
		else
			$query="SELECT admin_id FROM ".TBPREFIX."admin WHERE (admin_email = '$admin_email' OR username ='$username') "; 
		$sts = $this->db->query($query);
		return $sts->num_rows();
	}
	// Read data using username and password
	
	
	# Add Admin Details  
	public function add_admin($input_data) 
	{
		$res	=	$this->db->insert(TBPREFIX.'admin',$input_data);
		if($res)
		{
			$fdbrd_admin_id=$this->db->insert_id();
			return $fdbrd_admin_id;
		}
		else
		return false;
	}
	
	# Update Admin Details 
	public function upt_admin($input_data,$admin_id)
	{
		$this->db->where('admin_id',$admin_id);
		$query=$this->db->update(TBPREFIX."admin",$input_data);
		if($query==1)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	
	public function getAllServices()
	{
		$this->db->select(TBPREFIX.'main_services.*,'.TBPREFIX.'main_services_ch.service_name as service_name_ch,'.TBPREFIX.'main_services_ch.service_description as service_description_ch');
		$this->db->from(TBPREFIX.'main_services');
		$this->db->join(TBPREFIX.'main_services_ch',TBPREFIX.'main_services_ch.service_id = '.TBPREFIX.'main_services.service_id');
		#$this->db->where('user_type',"Company");
		$res=$this->db->get();
		return $tsr=$res->result_array();
	}
	
	public function getAdminInfo()
	{
		$this->db->select(TBPREFIX.'admin.*');
		$res=$this->db->get(TBPREFIX.'admin');
		return $tsr=$res->result_array();
	}
	
	
	// Read data using username and password
	public function getAdminDetails($admin_id,$qty) 
	{
		$this->db->select('*');
		$this->db->from(TBPREFIX.'admin');
		$this->db->where('admin_id',$admin_id);
		$query = $this->db->get();
		if($qty==1)
			return $query->result_array();
		else
			return $query->num_rows();
	}
	
	public function checkAdminPassword($old_password,$admin_id)
	{
		$this->db->select('admin_id');
		$this->db->from(TBPREFIX.'admin');
		$this->db->where('admin_id',$admin_id);
		$this->db->where('admin_password',md5($old_password));
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function udatPassord($admin_password,$adminId)
	{
	    $sts = "";
	    if($adminId > 0){
	     $admin_password = md5($admin_password);
		    $sts = $this->db->query("Update ".TBPREFIX."admin SET admin_password = '$admin_password' WHERE admin_id = '$adminId' ");
	    }
		return $sts;
	}
	
	public function getaddones($detail_id)
	{
		$this->db->select('detail_type,detail_value');
		$this->db->from(TBPREFIX.'menu_items_details');
		$this->db->where('detail_id',$detail_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getmodulelist($parent_role_id)
	{
		$this->db->select(TBPREFIX.'roles.role_type,'.TBPREFIX.'roles_modules.module_id,module_name,'.TBPREFIX.'roles.view,'.TBPREFIX.'roles.add,'.TBPREFIX.'roles.edit,'.TBPREFIX.'roles.delete');
		$this->db->join(TBPREFIX.'roles_modules',TBPREFIX.'roles_modules.module_id='.TBPREFIX.'roles.module_id','left');
		$this->db->where('parent_role_id',$parent_role_id);
		$this->db->from(TBPREFIX.'roles');
		
		$query = $this->db->get();
		return $query->result_array();	
	}
}