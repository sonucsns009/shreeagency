<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->model('adminModel/Dashboard_model');
		if($this->session->userdata('logged_in')!=1)
		{ 
			redirect(base_url().'logout','refresh');    
		}
	}


	public function index()
	{
		$data['title']='Dashboard';
		$todays=date('Y-m-d');
		$data['sel_options']='Na';
		$data['totalEarings']=0;
	
		$this->load->view('admin_header',$data);
		$this->load->view('dashboard');
		$this->load->view('admin_footer');
	}
}

