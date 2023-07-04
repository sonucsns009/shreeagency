<?php
Class Transport_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleTransportInfo($transport_id,$res)
	{
		$this->db->select('*');
		$this->db->where('id',$transport_id);
		$query = $this->db->get("transport");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	public function chkTransportName($transport_name,$res)
	{
		$this->db->select('*');
		$this->db->where('transport_name',$transport_name);
		$query=$this->db->get("transport");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function getAllTransports($res,$per_page,$page)
	{
		$this->db->select('*');

		$this->db->order_by('id','ASC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get('transport');
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function uptdateTransport($input_data,$transport_id) 
	{
		$transport = $input_data['transport_name'];
		$query=$this->db->query("select * from db_transport where upper(transport_name)=upper('$transport') and id<>$transport_id");
		if($query->num_rows()>0){
			return false;
		}
		else {
			print_r($input_data);exit;
			$this->db->where('id',$transport_id);
			$res = $this->db->update('transport',$input_data);
			if($res)
			{
				return true;
			}
			else
				return false;
		}
	}
	
	public function insert_transport($input_data) 
	{
		$res = $this->db->insert('transport',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	public function deleteTransport($transport_id)
	{
		$this->db->where('id',$transport_id);
		$res = $this->db->delete('transport');
		if($res)
			return true;
		else
			return false;
	}
}