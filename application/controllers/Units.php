<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Units extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//$this->load_global();
		$this->load->library("pagination");	
		$this->load->model('Units_model');
	}
	
	public function index()
	{
		$data['title']='Manage Units';
		
		$data['unitcnt']=$this->Units_model->getAllUnits(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'Units/index/';
		$config['per_page'] = 10;
		$config["uri_segment"] = 4;
		$config['full_tag_open'] = '<ul class="pagination">'; 
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = "<li class='paginate_button  page-item'>";
		$config['first_tag_close'] = "</li>"; 
		$config['prev_tag_open'] =	"<li class='paginate_button  page-item'>"; 
		$config['prev_tag_close'] = "</li>";
		$config['next_tag_open'] = "<li class='paginate_button  page-item'>";
		$config['next_tag_close'] = "</li>"; 
		$config['last_tag_open'] = "<li class='paginate_button  page-item'>"; 
		$config['last_tag_close'] = "</li>";
		$config['cur_tag_open'] = "<li class='paginate_button  page-item active'><a class='page-link active' href=''>"; 
		$config['cur_tag_close'] = "</a></li>";
		$config['num_tag_open'] = "<li class='paginate_button  page-item'>";
		$config['num_tag_close'] = "</li>"; 
		$config['attributes'] =array('class' => 'page-link');
		$config["total_rows"] =$data['unitcnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['units']=$this->Units_model->getAllUnits(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin_header',$data);
		$this->load->view('manageUnits',$data);
		$this->load->view('admin_footer');
	}
	
	
	public function addUnit()
	{
		$data['title']='Add Unit';
		$data['error_msg']='';
				
		if(isset($_POST['btn_addunit']))
		{
			$this->form_validation->set_rules('unit_name','Unit Name','required');
			$this->form_validation->set_rules('status','Unit Status','required');
			if($this->form_validation->run())
			{
				$unit_name=$this->input->post('unit_name');
				$status=$this->input->post('status');
				$description=$this->input->post('description');
							
				$unitname=$this->Units_model->chkUnitName($unit_name,0);

				if($unitname==0)
				{
					$input_data = array(
						'unit_name'=>trim($unit_name),
						'status'=>$status,
						'description'=>addslashes($description)
						);

					$unit_id = $this->Units_model->insert_unit($input_data);
					
					if($unit_id)
					{	
						$this->session->set_flashdata('success','Unit added successfully.');

						redirect(base_url().'Units/index');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding Unit.');

						redirect(base_url().'Units/addUnit/');
					}	
				}
				else
				{
					$this->session->set_flashdata('success','Unit name is already exist.');

					redirect(base_url().'Units/addUnit');	
				}

			}
		}

		$this->load->view('admin_header',$data);
		$this->load->view('addUnit',$data);
		$this->load->view('admin_footer');
	}

	public function updateUnit()
	{
		$data['title']='Update Unit';
		$data['error_msg']='';
		$unit_id=base64_decode($this->uri->segment(3));
		if($unit_id)
		{
			$unitInfo = $this->Units_model->getSingleUnitInfo($unit_id,0);
			if($unitInfo>0)
			{
				$data['UnitInfo'] = $this->Units_model->getSingleUnitInfo($unit_id,1);
				if(isset($_POST['btn_uptunit']))
				{
					$this->form_validation->set_rules('unit_name','Unit Name','required');
					$this->form_validation->set_rules('status','Unit Status','required');

					if($this->form_validation->run())
					{
						$unit_name = $this->input->post('unit_name');
						$status = $this->input->post('status');
						$description = $this->input->post('description');
									
						$input_data = array(
								'unit_name'=>trim($unit_name),
								'status'=>$status,
								'description'=>addslashes($description)
								);

						$unitdata = $this->Units_model->uptdateUnit($input_data,$unit_id);

						if($unitdata)
						{	
							$this->session->set_flashdata('success','Unit updated successfully.');

							redirect(base_url().'Units/index');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating unit.');

							redirect(base_url().'Units/updateUnit/'.base64_encode($unit_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'Units/updateUnit/'.base64_encode($unit_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Unit not found.';
			}
		}
		
		$this->load->view('admin_header',$data);
		$this->load->view('updateUnit',$data);
		$this->load->view('admin_footer');
	}
		
	public function deleteUnit()
	{
		$data['error_msg']='';
		$unit_id = base64_decode($this->uri->segment(3));
		if($unit_id)
		{
			$unitInfo = $data['unitInfo'] = $this->Units_model->getSingleUnitInfo($unit_id,1);
			if(count($unitInfo) > 0)
			{
				$delunit=$this->Units_model->deleteUnit($unit_id);
				if($delunit > 0)
				{
					$this->session->set_flashdata('success','Unit deleted successfully.');
					redirect(base_url().'Units/index');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting unit.');
					redirect(base_url().'Units/index');
				}
			}
			else
			{
				$data['error_msg'] = 'Unit not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Unit not found.');
			redirect(base_url().'Units/index');
		}
	}
}