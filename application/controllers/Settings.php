<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends CI_Controller {
	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminModel/Settings_model');
		 $this->load->library("pagination");	
		 if(! $this->session->userdata('logged_in'))
		 {
			redirect('backend/login', 'refresh');
		 }
	}
	
	// code for manage Admin Settings
	public function manageadminsetting()
	{
		$data['title']='Update Admin Settings';
		$data['error_msg']='';
		$data['adminsettingsinfo']=$this->Settings_model->getadminsettinginfo();
		
		if(isset($_POST['btn_updatedsettings']))
		{
			$this->form_validation->set_rules('distance_for_customer','Distance for customer','required');
			$this->form_validation->set_rules('distance_for_driver','Distance for driver','required');		
$this->form_validation->set_rules('distance_for_hotdeal','Distance for hot deal','required');					
					
			if($this->form_validation->run())
			{
				$distance_for_customer=$this->input->post('distance_for_customer');
				$distance_for_driver=$this->input->post('distance_for_driver');
				$distance_for_hotdeal=$this->input->post('distance_for_hotdeal');
				
				$input_data3=array('distance_for_customer'=>$distance_for_customer,
									'distance_for_driver'=>$distance_for_driver,
									'distance_for_hotdeal'=>$distance_for_hotdeal,
									'dateupdated'=>date('Y-m-d H:i:s'));
				
											
					$setting_id=$this->Settings_model->upt_adminsettings($input_data3);
					
					//echo $this->db->last_query();exit;
					if($setting_id)
					{	// echo '///';exit;
						$this->session->set_flashdata('success','Admin Setting details updated successfully.');
						redirect(base_url("backend/").'Settings/manageadminsetting');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while updating details.');
						redirect(base_url("backend/").'Settings/manageadminsetting');
					}	
			}
			else
			{
				$this->session->set_flashdata('error',$this->form_validation->error_string());
				redirect(base_url("backend/").'Settings/manageadminsetting');
			}
		}
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/admin_right',$data);
		$this->load->view('admin/adminsettings',$data);
		$this->load->view('admin/admin_footer');
	}

	// code for manage Admin tax
	public function manageadmintaxsetting()
	{
		$data['title']='Update Admin Settings';
		$data['error_msg']='';
		$data['adminsettingsinfo']=$this->Settings_model->getadminsettinginfo();
		
		if(isset($_POST['btn_updatedtaxsettings']))
		{
			$this->form_validation->set_rules('tax_percentage','Tax Value','required');
					
			if($this->form_validation->run())
			{
				$tax_percentage=$this->input->post('tax_percentage');
				
				$input_data3=array('tax_percentage'=>$tax_percentage,
									'dateupdated'=>date('Y-m-d H:i:s'));
				
											
					$setting_id=$this->Settings_model->upt_adminsettings($input_data3);
					
					//echo $this->db->last_query();exit;
					if($setting_id)
					{	// echo '///';exit;
						$this->session->set_flashdata('success','Admin IGIC percentage updated successfully.');
						redirect(base_url("backend/").'Settings/manageadmintaxsetting');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while updating IGIC percentage.');
						redirect(base_url("backend/").'Settings/manageadmintaxsetting');
					}	
			}
			else
			{
				$this->session->set_flashdata('error',$this->form_validation->error_string());
				redirect(base_url("backend/").'Settings/manageadmintaxsetting');
			}
		}
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/admin_right',$data);
		$this->load->view('admin/admintaxsettings',$data);
		$this->load->view('admin/admin_footer');
	}
	
	
}
