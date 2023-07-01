<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//$this->load_global();
		$this->load->library("pagination");	
		$this->load->model('Category_model');
	}
	
	public function index()
	{
		$data['title']='Manage Categories';
		
		$data['catcnt']=$this->Category_model->getAllCategories(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'Categories/index/';
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
		$config["total_rows"] =$data['catcnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['categories']=$this->Category_model->getAllCategories(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin_header',$data);
		$this->load->view('manageCategories',$data);
		$this->load->view('admin_footer');
	}

	public function updateCategory()
	{
		$data['title']='Update Category';
		$data['error_msg']='';
		$category_id=base64_decode($this->uri->segment(3));
		if($category_id)
		{
			$categoryInfo=$this->Category_model->getSingleCategoryInfo($category_id,0);
			if($categoryInfo>0)
			{
				$data['categoryInfo'] = $this->Category_model->getSingleCategoryInfo($category_id,1);
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

						$branddata = $this->Category_model->uptdateBrand($input_data,$brand_id);

						if($branddata)
						{	
							$this->session->set_flashdata('success','Brand updated successfully.');

							redirect(base_url().'backend/Brands/manageBrands');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating Category.');

							redirect(base_url().'manageBrands/updateBrand/'.base64_encode($brand_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'manageBrands/updateBrand/'.base64_encode($brand_id));
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
	
	public function addBrand()
	{
		$data['title']='Add Brand';
		$data['error_msg']='';
				
		if(isset($_POST['btn_addcategory']))
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

					$brand_id=$this->Category_model->insert_category($input_data);
					
					if($brand_id)
					{	
						$this->session->set_flashdata('success','Brand added successfully.');

						redirect(base_url().'Brand/manageBrands');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding Brand.');

						redirect(base_url().'Brand/addBrand/'.base64_encode($brand_id));
					}	
				}
				else
				{
					$this->session->set_flashdata('success','Brand name is already exist.');

					redirect(base_url().'Brand/addBrand');	
				}

			}
			else
			{
				$this->session->set_flashdata('error',$this->form_validation->error_string());

				redirect(base_url().'Brand/updateBrand/'.base64_encode($brand_id));
			}
		}

		$this->load->view('admin_header',$data);
		$this->load->view('addBrand',$data);
		$this->load->view('admin_footer');
	}
}

