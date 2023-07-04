<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transport extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//$this->load_global();
		$this->load->library("pagination");	
		$this->load->model('Transport_model');
	}
	
	public function index()
	{
		$data['title']='Manage Transport';
		
		$data['transportcnt']=$this->Transport_model->getAllTransports(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'Transport/index/';
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
		$config["total_rows"] =$data['transportcnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['transports']=$this->Transport_model->getAllTransports(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin_header',$data);
		$this->load->view('manageTransport',$data);
		$this->load->view('admin_footer');
	}
	
	public function addTransport()
	{
		$data['title']='Add Transport';
		$data['error_msg']='';
				
		if(isset($_POST['btn_addtrans']))
		{
			$this->form_validation->set_rules('transport_name','Transport Name','required');
			$this->form_validation->set_rules('status','Transport Status','required');
			if($this->form_validation->run())
			{
				$transport_name = $this->input->post('transport_name');
				
				$transportName = $this->Transport_model->chkTransportName($transport_name,0);

				if($transportName==0)
				{
					$input_data = array(
						'transport_name'=>trim($transport_name),
						'mobile' => $this->input->post('mobile'),
						'phone' => $this->input->post('phone'),
						'email' => $this->input->post('email'),
						'address' => $this->input->post('address'),
						'postcode' => $this->input->post('postcode'),
						'vehicle_number' => $this->input->post('vehicle_number'),
						'gst_number' => $this->input->post('gst_number'),
						'charges' => $this->input->post('charges'),
						'created_date' => date('Y-m-d'),
						'created_time' => date('H:i:s'),
						'created_by' => '',
						'status' => $this->input->post('status')
					);

					$transport_id = $this->Transport_model->insert_transport($input_data);
					
					if($transport_id)
					{	
						$this->session->set_flashdata('success','Transport added successfully.');

						redirect(base_url().'Transport/index');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding Transport.');

						redirect(base_url().'Transport/addTransport');
					}	
				}
				else
				{
					$this->session->set_flashdata('success','Transport name is already exist.');

					redirect(base_url().'Transport/addTransport');	
				}

			}
		}

		$this->load->view('admin_header',$data);
		$this->load->view('addTransport',$data);
		$this->load->view('admin_footer');
	}
	
	public function updateTransport()
	{
		$data['title']='Update Transport';
		$data['error_msg']='';
		$transport_id=base64_decode($this->uri->segment(3));
		if($transport_id)
		{
			$transportInfo=$this->Transport_model->getSingleTransportInfo($transport_id,0);
			if($transportInfo > 0)
			{
				$data['TransportInfo'] = $this->Transport_model->getSingleTransportInfo($transport_id,1);
				
				if(isset($_POST['frm_updtrans']))
				{
					$this->form_validation->set_rules('transport_name','Transport Name','required');
					//print_r($this->form_validation);exit;
					if ($this->form_validation->run() == TRUE) 
					{
						echo "<pre>"; print_r($_POST);exit;
						$transport_name = $this->input->post('transport_name');
									
						$input_data = array(
								'transport_name'=>trim($transport_name),
								'mobile' => $this->input->post('mobile'),
								'phone' => $this->input->post('phone'),
								'email' => $this->input->post('email'),
								'address' => $this->input->post('address'),
								'postcode' => $this->input->post('postcode'),
								'vehicle_number' => $this->input->post('vehicle_number'),
								'gst_number' => $this->input->post('gst_number'),
								'charges' => $this->input->post('charges'),
								'status' => $this->input->post('status')
							);

						$transdata = $this->Transport_model->uptdateTransport($input_data,$transport_id);

						if($transdata)
						{	
							$this->session->set_flashdata('success','Transport updated successfully.');

							redirect(base_url().'Transport/index');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating transport.');

							redirect(base_url().'Transport/updateTransport/'.base64_encode($transport_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'Transport/updateTransport/'.base64_encode($transport_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Transport not found.';
			}
		}
		
		$this->load->view('admin_header',$data);
		$this->load->view('updateTransport',$data);
		$this->load->view('admin_footer');
	}
	
	public function deleteTransport()
	{
		$data['error_msg']='';
		$transport_id = base64_decode($this->uri->segment(3));
		if($transport_id)
		{
			$transportInfo = $data['transportInfo'] = $this->Transport_model->getSingleTransportInfo($transport_id,1);
			if(count($transportInfo) > 0)
			{
				$deltrans=$this->Transport_model->deleteTransport($transport_id);
				if($deltrans > 0)
				{
					$this->session->set_flashdata('success','Transport deleted successfully.');
					redirect(base_url().'Transport/index');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting transport.');
					redirect(base_url().'Transport/index');
				}
			}
			else
			{
				$data['error_msg'] = 'Transport not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Transport not found.');
			redirect(base_url().'Transport/index');
		}
	}
}