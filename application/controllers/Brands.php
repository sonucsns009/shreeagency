<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//$this->load_global();
		$this->load->library("pagination");	
		$this->load->model('Brand_model');
	}
	
	public function index()
	{
		$data['title']='Manage Brands';
		
		$data['brandcnt']=$this->Brand_model->getAllBrands(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'Brands/index/';
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
		$config["total_rows"] =$data['brandcnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['brands']=$this->Brand_model->getAllBrands(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin_header',$data);
		$this->load->view('manageBrands',$data);
		$this->load->view('admin_footer');
	}
	
	public function addBrand()
	{
		$data['title']='Add Brand';
		$data['error_msg']='';
				
		if(isset($_POST['btn_addbrand']))
		{
			$this->form_validation->set_rules('brand_name','Brand Name','required');
			$this->form_validation->set_rules('status','Brand Status','required');
			if($this->form_validation->run())
			{
				$brand_name=$this->input->post('brand_name');
				$status=$this->input->post('status');
				$description=$this->input->post('description');
							
				$brandname=$this->Brand_model->chkBrandName($brand_name,0);

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
		$this->load->view('addBrand',$data);
		$this->load->view('admin_footer');
	}
	
	public function updateBrand()
	{
		$data['title']='Update Brand';
		$data['error_msg']='';
		$brand_id=base64_decode($this->uri->segment(3));
		if($brand_id)
		{
			$brandInfo=$this->Brand_model->getSingleBrandInfo($brand_id,0);
			if($brandInfo>0)
			{
				$data['BrandInfo'] = $this->Brand_model->getSingleBrandInfo($brand_id,1);
				if(isset($_POST['btn_uptbrand']))
				{
					$this->form_validation->set_rules('brand_name','Brand Name','required');
					$this->form_validation->set_rules('status','Brand Status','required');

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
		$this->load->view('updateBrand',$data);
		$this->load->view('admin_footer');
	}
	
	public function deleteBrand()
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
					$this->session->set_flashdata('success','Brand deleted successfully.');
					redirect(base_url().'Brands/index');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting brand.');
					redirect(base_url().'Brands/index');
				}
			}
			else
			{
				$data['error_msg'] = 'Brand not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Brand not found.');
			redirect(base_url().'Brands/index');
		}
	}
}