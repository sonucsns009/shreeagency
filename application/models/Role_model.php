<?php
Class Role_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleRoleInfo($role_id,$res)
	{
		$this->db->select('*');
		$this->db->where('id',$role_id);
		$query = $this->db->get("roles");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	public function chkRoleName($role_name,$res)
	{
		$this->db->select('*');
		$this->db->where('role_name',$role_name);
		$query=$this->db->get("roles");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function getAllRoles($res,$per_page,$page)
	{
		$this->db->select('*');

		$this->db->order_by('id','ASC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get('roles');
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function updateRole($input_data,$role_id) 
	{
		$role = $input_data['role_name'];
		$query=$this->db->query("select * from db_roles where upper(role_name)=upper('$role') and id<>$role_id");
		if($query->num_rows()>0){
			return false;
		}
		else {
			$this->db->where('id',$role_id);
			$res = $this->db->update('roles',$input_data);
			if($res)
			{
				return true;
			}
			else
				return false;
		}
	}
	
	public function insert_role($input_data) 
	{
		$res = $this->db->insert('roles',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	public function deleteRole($role_id)
	{
		$this->db->where('id',$role_id);
		$res = $this->db->delete('roles');
		if($res)
			return true;
		else
			return false;
	}
}