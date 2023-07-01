<?php

Class Dashboard_model extends CI_Model {

	function __construct()

	{

		// Call the Model constructor

		parent::__construct();

	}

	
	public function getTotalRestaurant($qty,$status)
	{
		$this->db->select('rst_id');
		$this->db->from(TBPREFIX.'restaurant');
		if($status!="")
		$this->db->where('rst_status',$status);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		
		if ($qty==0) 
		{
			return $query->num_rows();
		} 
		else 
		{
			return $query->result_array();
		}
	}


	public function getRestName($rst_id,$qty)
	{
		$this->db->select('rst_name');
		$this->db->from(TBPREFIX.'restaurant');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		
		if ($qty==0) 
		{
			return $query->num_rows();
		} 
		else 
		{
			return $query->result_array();
		}
	}

public function getTotalCustomers($status)
	{
		$this->db->select('user_id');
		$this->db->from(TBPREFIX.'users');
		if($status!="")
		{
			$this->db->where('user_status',$status);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function getTotalOrders($date)
	{
		$this->db->select('order_id');
		$this->db->from(TBPREFIX.'item_orders');
		if($date!="")
		{
			$this->db->where('DATE(order_date)',$date);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

public function getTopRestSelling($sel_options)
	{
		$this->db->select('SUM('.TBPREFIX.'item_order_transaction.total_order_amount) AS total_amt,'.TBPREFIX.'restaurant.rst_name');
		$this->db->from(TBPREFIX.'item_order_transaction');
		$this->db->join(TBPREFIX.'restaurant',TBPREFIX.'item_order_transaction.rst_id='.TBPREFIX.'restaurant.rst_id','left');
		
		if($sel_options!="")
		{
			if($sel_options=='Todays')
			{
				$TODAY=date('Y-m-d');
				$this->db->where("DATE(".TBPREFIX."item_order_transaction.dateadded)",$TODAY);
			}
			if($sel_options=='Weekly')
			{ 
				$day = date('w');
				$week_start = date('Y-m-d', strtotime('-'.$day.' days'));
				$week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
				$this->db->where("DATE(".TBPREFIX."item_order_transaction.dateadded) >= ",$week_start);
				$this->db->where("DATE(".TBPREFIX."item_order_transaction.dateadded) <= ",$week_end);
			}
			if($sel_options=='Monthly')
			{
				$month_start = date('Y-m-01');
				$month_last = date('Y-m-t');
				$this->db->where("DATE(".TBPREFIX."item_order_transaction.dateadded) >= ",$month_start);
				$this->db->where("DATE(".TBPREFIX."item_order_transaction.dateadded) <= ",$month_last);
			}
			if($sel_options=='Yearly')
			{
				$year_start = date('Y-01-01');
				$year_last = date('Y-12-t');
				
				$this->db->where("DATE(".TBPREFIX."item_order_transaction.dateadded) >= ",$year_start);
				$this->db->where("DATE(".TBPREFIX."item_order_transaction.dateadded) <= ",$year_last);
			}
		}
		else
		{
			$this->db->order_by('SUM(offer_amount)','DESC');
			$this->db->limit(5);
		}
		
		$this->db->where('payment_status','Succeeded');
		
		$this->db->group_by(TBPREFIX.'item_order_transaction.rst_id');
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function getLatestCustomers()
	{
		$this->db->select(TBPREFIX.'users.user_id,profile_id,fullname,mobilenumber,country_code');
		$this->db->where('user_status','Active');
		$this->db->limit(5);
		$this->db->order_by(TBPREFIX.'users.user_id','DESC');
		$res=$this->db->get(TBPREFIX.'users');
		return $res->result_array();
	}	
	
	public function getTopStores()
	{
	 	 $sql="SELECT COUNT(".TBPREFIX."item_orders.rst_id) AS CNT_STORES ,".TBPREFIX."item_orders.rst_id,".TBPREFIX."restaurant.rst_name,".TBPREFIX."restaurant.rst_contact_no,rst_countrycode,".TBPREFIX."restaurant.rst_email FROM ".TBPREFIX."item_orders join ".TBPREFIX."restaurant on ".TBPREFIX."item_orders.rst_id=".TBPREFIX."restaurant.rst_id  GROUP BY ".TBPREFIX."item_orders.rst_id HAVING COUNT(".TBPREFIX."item_orders.rst_id) >= 1 order by COUNT(".TBPREFIX."item_orders.rst_id) desc limit 3";
	
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	public function displaylast5revenue($type,$order_report_start,$order_report_end)
	{
		if($order_report_start!="" && $order_report_end=="")
		{
			$this->db->where('DATE('.TBPREFIX.'item_orders.order_date)',$order_report_start);	   
		}
		if($order_report_start!="" && $order_report_end!="")
		{
			$this->db->where('DATE('.TBPREFIX.'item_orders.order_date) >=',$order_report_start);	 
			$this->db->where('DATE('.TBPREFIX.'item_orders.order_date) <=',$order_report_end);	 			
		}
		$this->db->select(TBPREFIX.'item_orders.*,fullname,mobilenumber,country_code');
		#$this->db->where(TBPREFIX.'item_orders.rst_id',0);
		if($type=="cash")
		{
			$this->db->where(TBPREFIX.'item_order_transaction.payment_type','cod');
			$this->db->where(TBPREFIX.'item_order_transaction.payment_status','completed');
		}
		else 
		{
			$this->db->where(TBPREFIX.'item_order_transaction.payment_type','stripe');
			$this->db->where(TBPREFIX.'item_order_transaction.payment_status','Succeeded');
		}
		
		$this->db->where(TBPREFIX.'item_orders.order_status','order_delivered');
		$this->db->join(TBPREFIX.'users',TBPREFIX.'users.user_id='.TBPREFIX.'item_orders.user_id','left');
		$this->db->join(TBPREFIX.'item_order_transaction',TBPREFIX.'item_order_transaction.order_id='.TBPREFIX.'item_orders.order_id','left');
		$this->db->order_by(TBPREFIX.'item_orders.order_id','DESC');
		$this->db->limit(5);
		$res=$this->db->get(TBPREFIX.'item_orders');
		return $res->result_array();
	}
	
	public function getProducthistory($order_id)
	{
		$this->db->select(TBPREFIX.'menu_items.item_id,item_title,'.TBPREFIX.'item_order_details.selling_price');
		$this->db->where(TBPREFIX.'item_order_details.order_id',$order_id);
		$this->db->join(TBPREFIX.'menu_items',TBPREFIX.'item_order_details.item_id='.TBPREFIX.'menu_items.item_id','left');
		$query=$this->db->get(TBPREFIX.'item_order_details');
		return $query->result_array();		
	}
	
	public function getCustomerName($user_id)
	{
		$this->db->select('fullname');
		$this->db->where(TBPREFIX.'users.user_id',$user_id);
		$query=$this->db->get(TBPREFIX.'users');
		return $query->result_array();		
	}
	
	public function getTotaladminRevenues($date)
	{
		$str = "(".TBPREFIX."item_order_transaction.payment_status='Succeeded' || ".TBPREFIX."item_order_transaction.payment_status='completed')";
		$this->db->select('SUM('.TBPREFIX.'item_orders.rst_commission_actual_amt) as total_admin_commission');
		$this->db->where(TBPREFIX.'item_orders.order_status','order_delivered');
		$this->db->where($str);
		$this->db->join(TBPREFIX.'item_order_transaction',TBPREFIX.'item_order_transaction.order_id='.TBPREFIX.'item_orders.order_id','left');
		$this->db->from(TBPREFIX.'item_orders');
		if($date!="")
		{
			$this->db->where('DATE(order_date)',$date);
		}
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	public function gettopdrivers()
	{
		$this->db->select('SUM(commission_amt) AS total_comm,'.TBPREFIX.'driver.driver_id,'.TBPREFIX.'driver.driver_name,driver_mobile,driver_countrycode,driver_photo');
		$this->db->where(TBPREFIX.'driver_commission.commission_status','delivered');
		$this->db->group_by(TBPREFIX.'driver_commission.driver_id');
		$this->db->join(TBPREFIX.'driver',TBPREFIX.'driver.driver_id='.TBPREFIX.'driver_commission.driver_id','left');
		$this->db->order_by('total_comm','DESC');
		$this->db->limit(5);
		$query=$this->db->get(TBPREFIX.'driver_commission');
		return $query->result_array();		
	}
	
	public function getTOPMenus()
		{
			$this->db->select(TBPREFIX.'menu_items.*,count('.TBPREFIX.'item_order_details.item_id) as cnt_item_id,rst_name');
			$this->db->join(TBPREFIX.'item_order_details',TBPREFIX.'item_order_details.item_id='.TBPREFIX.'menu_items.item_id','left');
			$this->db->join(TBPREFIX.'item_orders',TBPREFIX.'item_orders.order_id='.TBPREFIX.'item_order_details.order_id','left');
			$this->db->join(TBPREFIX.'restaurant',TBPREFIX.'restaurant.rst_id='.TBPREFIX.'menu_items.rst_id','left');
			$this->db->where(TBPREFIX.'item_orders.order_status','order_delivered');
			$this->db->where(TBPREFIX.'restaurant.is_hot_deal','No');
			$this->db->group_by(TBPREFIX.'item_order_details.item_id');
			$this->db->order_by('cnt_item_id','DESC');
			$this->db->having('cnt_item_id>1');
			$this->db->LIMIT(5);
			$query=$this->db->get(TBPREFIX.'menu_items');
			return $query->result_array();
		}
}