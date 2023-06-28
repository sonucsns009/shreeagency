<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{

		 parent::__construct();

		 $this->load->model('ApiModels/TourexpensesModel');
		 $this->load->model('ApiModels/LocalConveyanceModel');
		 $this->load->model('adminModel/Dashboard_model');
		 $this->load->model('adminModel/Admin_model');
		 $this->load->model('adminModel/CommonModel');

		 if(! $this->session->userdata('logged_in'))

		 {

			redirect('backend/login', 'refresh');

		 }

	}

	

	public function index()
	{
		$data['title']='Dashboard';
		
		$filter = $company_id = "";
		
		$status = $from_date = $to_date = $state = $district = 'Na';
		
		if($this->uri->segment(4)!='')
		{
			if($this->uri->segment(4)!="Na")
			{
				$from_date=($this->uri->segment(4));
			}
		}
		
		if($this->uri->segment(5)!='')
		{
			if($this->uri->segment(5)!="Na")
			{
				$to_date=($this->uri->segment(5));
			}
		}
		
		if($this->uri->segment(6)!='')
		{
			if($this->uri->segment(6)!="Na")
			{
				$state=($this->uri->segment(6));
			}
		}
		
		if($this->uri->segment(7)!='')
		{
			if($this->uri->segment(7)!="Na")
			{
				$district=($this->uri->segment(7));
			}
		}
		
		$TourTotalExpenses = $this->Dashboard_model->getTravelTotalExpenses($filter,$from_date,$to_date);
		$TourNoOfExpenses = $this->Dashboard_model->getTravelNoOfExpenses($status,$filter,$from_date,$to_date);
		$TourPendingExpenses = $this->Dashboard_model->getTravelNoOfExpenses('In Progress',$filter,$from_date,$to_date);
		$TourApprovedExpenses = $this->Dashboard_model->getTravelNoOfExpenses('Approved',$filter,$from_date,$to_date);
		
		$OfficeTotalExpenses = $this->Dashboard_model->getTotalOfficeExpenses($filter,$from_date,$to_date,$company_id);
		$OfficeNoOfExpenses = $this->Dashboard_model->getNoOfOfficeExpenses($status,$from_date,$to_date);
		$OfficePendingExpenses = $this->Dashboard_model->getNoOfOfficeExpenses('In Progress',$from_date,$to_date);
		$OfficeApprovedExpenses = $this->Dashboard_model->getNoOfOfficeExpenses('Approved',$from_date,$to_date);
		
		$LCTotalExpenses = $this->Dashboard_model->getTotalLocalConveyanceExpenses($filter,$from_date,$to_date,$company_id);
		$LCNoOfExpenses = $this->Dashboard_model->getNoOfLocalConveyanceExpenses($status,$from_date,$to_date);
		$LCNoOfPendingExpenses = $this->Dashboard_model->getNoOfLocalConveyanceExpenses('In Progress',$from_date,$to_date);
		$LCNoOfApprovedExpenses = $this->Dashboard_model->getNoOfLocalConveyanceExpenses('Approved',$from_date,$to_date);
		
		$OtherTotalExpenses = $this->Dashboard_model->getTotalOtherExpenses($filter,$from_date,$to_date,$company_id);
		$OtherNoOfExpenses = $this->Dashboard_model->getNoOfOtherExpenses($status,$from_date,$to_date);
		$OtherNoOfPendingExpenses = $this->Dashboard_model->getNoOfOtherExpenses('In Progress',$from_date,$to_date);
		$OtherNoOfApprovedExpenses = $this->Dashboard_model->getNoOfOtherExpenses('Approved',$from_date,$to_date);
		
		$TourThisMonthExpenses = $this->Dashboard_model->getTravelTotalExpenses('Current Month',$from_date,$to_date);
		
		$TourPastMonthExpenses = $this->Dashboard_model->getTravelTotalExpenses('Past Month',$from_date,$to_date);
		
		/*
		$TourNoOfPendingExpenses = $this->TourexpensesModel->getNoOfExpenses($employee_id,'In Progress',$filter,$from_date,$to_date);
		
		$TourNoOfPaidExpenses = $this->TourexpensesModel->getNoOfExpenses($employee_id,'Approved',$filter,$from_date,$to_date);
		
		$TourNoOfUnPaidExpenses = $this->TourexpensesModel->getNoOfExpenses($employee_id,'Rejected',$filter,$from_date,$to_date);
		*/
		$data['TourTotalExpenses'] = $TourTotalExpenses;
		$data['TourPendingExpenses'] = $TourPendingExpenses;
		$data['TourApprovedExpenses'] = $TourApprovedExpenses;
		$data['TourNoOfExpenses'] = $TourNoOfExpenses;
		$data['OfficeTotalExpenses'] = $OfficeTotalExpenses;
		$data['OfficePendingExpenses'] = $OfficePendingExpenses;
		$data['OfficeApprovedExpenses'] = $OfficeApprovedExpenses;
		$data['OfficeNoOfExpenses'] = $OfficeNoOfExpenses;
		$data['LCTotalExpenses'] = $LCTotalExpenses;
		$data['LCNoOfExpenses'] = $LCNoOfExpenses;
		$data['LCNoOfPendingExpenses'] = $LCNoOfPendingExpenses;
		$data['LCNoOfApprovedExpenses'] = $LCNoOfApprovedExpenses;
		$data['OtherNoOfExpenses'] = $OtherNoOfExpenses;
		$data['OtherNoOfPendingExpenses'] = $OtherNoOfPendingExpenses;
		$data['OtherNoOfApprovedExpenses'] = $OtherNoOfApprovedExpenses;
		$data['OtherTotalExpenses'] = $OtherTotalExpenses;
		$data['EmpTotalExpenses'] = $LCTotalExpenses + $OtherTotalExpenses;
		$data['EmpNoOfExpenses'] = $LCNoOfExpenses + $OtherNoOfExpenses;
		$data['TourThisMonthExpenses'] = $TourThisMonthExpenses;
		$data['TourPastMonthExpenses'] = $TourPastMonthExpenses;
		
		//$TourTotalExpenses = $this->TourexpensesModel->getTotalExpensesStat($employee_id,$filter);
					
		$totalConveyances = $this->Dashboard_model->getTotalConveyances($from_date,$to_date);
		
		$totalFoodExpenses = $this->Dashboard_model->getTotalFood($from_date,$to_date);
		
		$totalAccommodation = $this->Dashboard_model->getTotalAccommodation($from_date,$to_date);
		
		$totalOther = $this->Dashboard_model->getTotalOther($from_date,$to_date);
		
		$percentageConveyance = $percentageFood = $percentageAccommodation = $percentageOther = 0;
		//echo $totalConveyances.' '.$TourTotalExpenses;
		if($TourTotalExpenses != 0)
		{
			$data['percentageConveyance'] = ($totalConveyances / $TourTotalExpenses) * 100; 
			$data['percentageFood'] = ($totalFoodExpenses / $TourTotalExpenses) * 100; 
			$data['percentageAccommodation'] = ($totalAccommodation / $TourTotalExpenses) * 100; 
			$data['percentageOther'] = ($totalOther / $TourTotalExpenses) * 100; 
		}
		

		$officeExpenses = $this->Dashboard_model->getOfficeExpenses();
		
		if(!empty ($officeExpenses))
		{
			$expType = '';
			//$expenses = array();
			foreach($officeExpenses as $expense)
			{
				$expType = str_replace(' ', '_', $expense['expense_type']);
				$expType = str_replace('/', '_', $expType);							
				$data[$expType.'TotalExpenses'] = 0;
				
				$data[$expType.'Percentage'] = 0; 
			}
		}
			
		if($OfficeTotalExpenses != 0)
		{
			if(!empty ($officeExpenses))
			{
				$expType = '';
				//$expenses = array();
				foreach($officeExpenses as $expense)
				{
					$expType = str_replace(' ', '_', $expense['expense_type']);
					$expType = str_replace('/', '_', $expType);							
					$data[$expType.'TotalExpenses'] = $this->Dashboard_model->getTotalOfficeExpensesByType($expense['expense_type_id'],$from_date,$to_date);
					
					$data[$expType.'Percentage'] = round(($data[$expType.'TotalExpenses'] / $OfficeTotalExpenses) * 100); 
				}
			}
		}
		
		$convModes = $this->LocalConveyanceModel->getConveyanceModesAll();
		
		if(!empty ($convModes))
		{
			foreach($convModes as $k=>$conv)
			{
				$conv = str_replace(' ', '_', $conv);
				$conv = str_replace('/', '_', $conv);
				
				$data[$conv.'TotalExpenses'] = 0;
				
				$data[$conv.'Percentage'] = 0; 
			}
		}
			
		if($LCTotalExpenses != 0)
		{
			if(!empty ($convModes))
			{
				foreach($convModes as $k=>$conv)
				{
					$conv = str_replace(' ', '_', $conv);
					$conv = str_replace('/', '_', $conv);
					
					$data[$conv.'TotalExpenses'] = $this->Dashboard_model->getTotalLocalConveyByType($k,$from_date,$to_date);
					
					$data[$conv.'Percentage'] = round(($data[$conv.'TotalExpenses'] / $LCTotalExpenses) * 100); 
				}
			}
		}
		/*
		$data['percentageLC'] = $data['percentageOtherExp'] = 0;
		
		if($data['EmpTotalExpenses'] != 0)
		{
			$data['percentageLC'] = ($LCTotalExpenses / $data['EmpTotalExpenses']) * 100; 		
			
			$data['percentageOtherExp'] = ($OtherTotalExpenses / $data['EmpTotalExpenses']) * 100; 
			
		}
		*/
		
		$otherExpenses = $this->TourexpensesModel->getOtherExpenseType('');
		
		if(!empty ($otherExpenses))
		{
			foreach($otherExpenses as $k=>$othr)
			{
				$othr = str_replace(' ', '_', $othr);
				$othr = str_replace('/', '_', $othr);
				
				$data[$othr.'TotalExpenses'] = 0;
				
				$data[$othr.'Percentage'] = 0; 
			}
		}
			
		if($OtherTotalExpenses != 0)
		{
			if(!empty ($otherExpenses))
			{
				foreach($otherExpenses as $k=>$othr)
				{
					/*$othr = str_replace(' ', '_', $othr);
					$othr = str_replace('/', '_', $othr);*/
					$othr = preg_replace('/[^a-zA-Z0-9]/', '_', $othr);

					$data[$othr.'TotalExpenses'] = $this->Dashboard_model->getTotalOtherExpByType($k,$from_date,$to_date);
					
					$data[$othr.'Percentage'] = round(($data[$othr.'TotalExpenses'] / $OtherTotalExpenses) * 100); 
				}
			}
		}
		
		
		
		$data['Companies'] = $this->TourexpensesModel->getGstCompanies();
		$data['otherExpensesTypes'] = $otherExpenses;
		//echo "<pre>"; print_r($data);
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/dashboard',$data);
		$this->load->view('admin/admin_footer');
	}

	
	public function home()
	{

		$data['title']='Dashboard';
		$todays=date('Y-m-d');
		$data['sel_options']='Na';
		$data['totalEarings']=0;

		$session_data=$this->session->userdata('logged_in');
		$user_type=$session_data['user_type'];
		
			$this->load->view('admin/admin_header',$data);
			
			$this->load->view('admin/home');

			$this->load->view('admin/admin_footer');
		
		
	}
	
	public function ajax_search()
	{
		$data['title']='Dashboard';
		
		$session_data=$this->session->userdata('logged_in');
		$user_type=$session_data['user_type'];
		$filter = $company_id = '';
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");
		
		$TourTotalExpenses = $this->Dashboard_model->getTravelTotalExpenses($filter,$from_date,$to_date);
		$TourNoOfExpenses = $this->Dashboard_model->getTravelNoOfExpenses($filter,$from_date,$to_date);
		
		$OfficeTotalExpenses = $this->Dashboard_model->getTotalOfficeExpenses($filter,$from_date,$to_date,$company_id);
		$OfficeNoOfExpenses = $this->Dashboard_model->getNoOfOfficeExpenses($from_date,$to_date);
		
		$LCTotalExpenses = $this->Dashboard_model->getTotalLocalConveyanceExpenses($filter,$from_date,$to_date,$company_id);
		$LCNoOfExpenses = $this->Dashboard_model->getNoOfLocalConveyanceExpenses($from_date,$to_date);
		
		$OtherTotalExpenses = $this->Dashboard_model->getTotalOtherExpenses($filter,$from_date,$to_date,$company_id);
		$OtherNoOfExpenses = $this->Dashboard_model->getNoOfOtherExpenses($from_date,$to_date);
		
		$data['TourTotalExpenses'] = $TourTotalExpenses;
		$data['TourNoOfExpenses'] = $TourNoOfExpenses;		
		$data['OfficeTotalExpenses'] = $OfficeTotalExpenses;
		$data['OfficeNoOfExpenses'] = $OfficeNoOfExpenses;
		$data['EmpTotalExpenses'] = $LCTotalExpenses + $OtherTotalExpenses;
		$data['EmpNoOfExpenses'] = $LCNoOfExpenses + $OtherNoOfExpenses;

		//$this->load->view('admin/admin_header',$data);
		
		$this->load->view('admin/ajax_search',$data);

		//$this->load->view('admin/admin_footer');
		
		
	}

	public function search()
	{
		$from_date = $to_date = $state = $district = 'Na';
		//echo "<pre>"; print_r($_POST); exit;
		if(isset($_POST['btn_search']))
		{
			if($_POST['from_date']!="")
			{
				$from_date=strtotime(trim($_POST['from_date']));
			}
			if($_POST['to_date']!="")
			{
				$to_date=strtotime(trim($_POST['to_date']));
			}
			if($_POST['state']!="")
			{
				$state=trim($_POST['state']);
			}
			if($_POST['district']!="")
			{
				$district=trim($_POST['district']);
			}
		    
			redirect(base_url().'backend/dashboard/index/'.$from_date.'/'.$to_date.'/'.$state.'/'.$district);
		}
		redirect('backend/dashboard/index', 'refresh');		
	}

}

