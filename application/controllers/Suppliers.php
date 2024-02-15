<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//$this->load_global();
		$this->load->library("pagination");	
		$this->load->model('Supplier_model');
	}
	
	public function index()
	{
		$data['title']='Manage Supplier';
		
		$data['suppliercnt']=$this->Supplier_model->getAllSuppliers(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'Supplier/index/';
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
		$config["total_rows"] =$data['suppliercnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['suppliers']=$this->Supplier_model->getAllSuppliers(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin_header',$data);
		$this->load->view('manageSuppliers',$data);
		$this->load->view('admin_footer');
	}

	public function addSupplier()
	{
		$data['title']='Add Supplier';
		$data['error_msg']='';
				
		if(isset($_POST['btn_addbrand']))
		{
			$this->form_validation->set_rules('supplier_name','Supplier Name','required');
			$this->form_validation->set_rules('mobile','Mobile No.','required');
			$this->form_validation->set_rules('email','Email Address','required');
			$this->form_validation->set_rules('gstin','GST Number','required');
			$this->form_validation->set_rules('tax_number','Tax Number','required');
			$this->form_validation->set_rules('address','Address','required');
			$this->form_validation->set_rules('postcode','Post Code','required');
			
			if($this->form_validation->run())
			{
				$supplier_name = $this->input->post('supplier_name');
				
				$supname = $this->Supplier_model->chkSupplierName($supplier_name,0);

				if($brandname==0)
				{
					$input_data = array(
						'brand_name'=>trim($brand_name),
						'status'=>$status,
						'description'=>addslashes($description)
						);

					$brand_id = $this->Brand_model->insert_brand($input_data);
					
					if($brand_id)
					{	
						$this->session->set_flashdata('success','Brand added successfully.');

						redirect(base_url().'Brands/index');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding Brand.');

						redirect(base_url().'Brands/addBrand/');
					}	
				}
				else
				{
					$this->session->set_flashdata('success','Brand name is already exist.');

					redirect(base_url().'Brands/addBrand');	
				}

			}
		}

		$this->load->view('admin_header',$data);
		$this->load->view('addSupplier',$data);
		$this->load->view('admin_footer');
	}
	
	public function updateSupplier()
	{
		$data['title']='Update Supplier';
		$data['error_msg']='';
		$supplier_id = base64_decode($this->uri->segment(3));
		if($supplier_id)
		{
			$supplierInfo=$this->Supplier_model->getSingleSupplierInfo($supplier_id,0);
			if($supplierInfo>0)
			{
				$data['SupplierInfo'] = $this->Supplier_model->getSingleSupplierInfo($supplier_id,1);
				if(isset($_POST['btn_uptsupl']))
				{
					$this->form_validation->set_rules('supplier_name','Supplier Name','required');
					$this->form_validation->set_rules('mobile','Mobile No.','required');
					$this->form_validation->set_rules('email','Email Address','required');
					$this->form_validation->set_rules('gstin','GST Number','required');
					$this->form_validation->set_rules('tax_number','Tax Number','required');
					$this->form_validation->set_rules('address','Address','required');
					$this->form_validation->set_rules('postcode','Post Code','required');

					if($this->form_validation->run())
					{
						$brand_name = $this->input->post('brand_name');
						$status = $this->input->post('status');
						$description = $this->input->post('description');
									
						$input_data = array(
								'brand_name'=>trim($brand_name),
								'status'=>$status,
								'description'=>addslashes($description)
								);

						$branddata = $this->Brand_model->uptdateBrand($input_data,$brand_id);

						if($branddata)
						{	
							$this->session->set_flashdata('success','Brand updated successfully.');

							redirect(base_url().'Brands/index');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating brand.');

							redirect(base_url().'Brands/updateBrand/'.base64_encode($brand_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'Brands/updateBrand/'.base64_encode($brand_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Brand not found.';
			}
		}
		
		$this->load->view('admin_header',$data);
		$this->load->view('updateSupplier',$data);
		$this->load->view('admin_footer');
	}
	
	public function deleteSupplier()
	{
		$data['error_msg']='';
		$brand_id = base64_decode($this->uri->segment(3));
		if($brand_id)
		{
			$brandInfo = $data['brandInfo'] = $this->Brand_model->getSingleBrandInfo($brand_id,1);
			if(count($brandInfo) > 0)
			{
				$delbrand=$this->Brand_model->deleteBrand($brand_id);
				if($delbrand > 0)
				{
					$this->session->set_flashdata('success','Supplier deleted successfully.');
					redirect(base_url().'Supplier/index');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting supplier.');
					redirect(base_url().'Supplier/index');
				}
			}
			else
			{
				$data['error_msg'] = 'Supplier not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Supplier not found.');
			redirect(base_url().'Supplier/index');
		}
	}
}