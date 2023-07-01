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
	public function chkCategoryName($category_name,$res)
	{
		$this->db->select('*');
		$this->db->where('category_name',$category_name);
		$query=$this->db->get("category");
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
	
	public function insert_category($input_data) 
	{
		//Create category unique Number
		$qs4="select coalesce(max(id),0)+1 as maxid from db_category";
		$q1=$this->db->query($qs4);
		$maxid=$q1->row()->maxid;
		$cat_code='CT'.str_pad($maxid, 4, '0', STR_PAD_LEFT);
		$input_data['category_code'] = $cat_code;
		//end
			
		$res = $this->db->insert('category',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
}