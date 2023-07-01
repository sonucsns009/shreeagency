<?php
Class Products_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleBrandInfo($brand_id,$res)
	{
		$this->db->select('*');
		$this->db->where('id',$brand_id);
		$query = $this->db->get("brands");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	public function chkBrandName($brand_name,$res)
	{
		$this->db->select('*');
		$this->db->where('brand_name',$brand_name);
		$query=$this->db->get("brands");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function getAllProducts($res,$per_page,$page)
	{
		$this->db->select('*');

		$this->db->order_by('id','ASC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get('items');
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function uptdateBrand($input_data,$brand_id) 
	{
		$brand = $input_data['brand_name'];
		$query=$this->db->query("select * from db_brands where upper(brand_name)=upper('$brand') and id<>$brand_id");
		if($query->num_rows()>0){
			return false;
		}
		else {
			$this->db->where('id',$brand_id);
			$res = $this->db->update('brands',$input_data);
			if($res)
			{
				return true;
			}
			else
				return false;
		}
	}
	
	public function insert_brand($input_data) 
	{
		$res = $this->db->insert('brands',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	public function deleteBrand($brand_id)
	{
		$this->db->where('id',$brand_id);
		$res = $this->db->delete('brands');
		if($res)
			return true;
		else
			return false;
	}
}