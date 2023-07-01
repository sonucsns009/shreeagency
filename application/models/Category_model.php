<?php
Class Category_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleCategoryInfo($category_id,$res)
	{
		$this->db->select('*');
		$this->db->where('id',$category_id);
		$query = $this->db->get("category");
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

	public function getAllCategories($res,$per_page,$page)
	{
		$this->db->select('*');

		$this->db->order_by('id','ASC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get('category');
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function uptdateCategory($input_data,$category_id) 
	{
		$this->db->where('id',$category_id);
		$res = $this->db->update('category',$input_data);
		if($res)
		{
			return true;
		}
		else
			return false;
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
	
	public function insert_category_es($input_data) 
	{
		//$this->db->where('category_id',$category_id);
		$res=$this->db->insert(TBPREFIX.'main_category_es',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	public function upt_category_es($input_data,$category_id) 
	{
		$this->db->where('category_id',$category_id);
		$res=$this->db->update(TBPREFIX.'main_category_es',$input_data);
		if($res)
		{
			return true;
		}
		else
			return false;
	}
}