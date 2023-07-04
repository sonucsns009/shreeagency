<?php
Class Units_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleUnitInfo($unit_id,$res)
	{
		$this->db->select('*');
		$this->db->where('id',$unit_id);
		$query = $this->db->get("units");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	public function chkUnitName($unit_name,$res)
	{
		$this->db->select('*');
		$this->db->where('unit_name',$brand_name);
		$query=$this->db->get("units");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function getAllUnits($res,$per_page,$page)
	{
		$this->db->select('*');

		$this->db->order_by('id','ASC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get('units');
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function uptdateUnit($input_data,$unit_id) 
	{
		$unit = $input_data['unit_name'];
		$query=$this->db->query("select * from db_units where upper(unit_name)=upper('$unit') and id<>$unit_id");
		if($query->num_rows()>0){
			return false;
		}
		else {
			$this->db->where('id',$unit_id);
			$res = $this->db->update('units',$input_data);
			if($res)
			{
				return true;
			}
			else
				return false;
		}
	}
	
	public function insert_unit($input_data) 
	{
		$res = $this->db->insert('units',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	public function deleteUnit($unit_id)
	{
		$this->db->where('id',$unit_id);
		$res = $this->db->delete('units');
		if($res)
			return true;
		else
			return false;
	}
}