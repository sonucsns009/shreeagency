<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//$this->load_global();
		if($this->session->userdata('logged_in')!=1)
		{ 
			redirect(base_url().'logout','refresh');    
		}
		$this->load->library("pagination");	
		$this->load->model('Role_model');
	}
	
	public function index()
	{
		$data['title']='Manage Roles';
		
		$data['rolecnt']=$this->Role_model->getAllRoles(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'Roles/index/';
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
		$config["total_rows"] =$data['rolecnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['roles']=$this->Role_model->getAllRoles(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin_header',$data);
		$this->load->view('manageRoles',$data);
		$this->load->view('admin_footer');
	}
	
	public function addRole()
	{
		$data['title']='Add Role';
		$data['error_msg']='';
				
		if(isset($_POST['btn_addrole']))
		{
			$this->form_validation->set_rules('role_name','Role Name','required');
			
			if($this->form_validation->run())
			{
				$role_name=$this->input->post('role_name');
				$description=$this->input->post('description');
				$status=$this->input->post('status');
							
				$rolename=$this->Role_model->chkRoleName($role_name,0);

				if($rolename==0)
				{
					$input_data = array(
						'role_name'=>trim($role_name),
						'description'=>addslashes($description),
						'status'=>$status
						);

					$role_id = $this->Role_model->insert_role($input_data);
					
					if($role_id)
					{	
						$this->session->set_flashdata('success','Role added successfully.');

						redirect(base_url().'Roles/index');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding Role.');

						redirect(base_url().'Roles/addRole');
					}	
				}
				else
				{
					$this->session->set_flashdata('success','Role name is already exist.');

					redirect(base_url().'Roles/addRole');	
				}

			}
		}

		$this->load->view('admin_header',$data);
		$this->load->view('addRole',$data);
		$this->load->view('admin_footer');
	}
	
	public function updateRole()
	{
		$data['title']='Update Role';
		$data['error_msg']='';
		$role_id=base64_decode($this->uri->segment(3));
		if($role_id)
		{
			$roleInfo=$this->Role_model->getSingleRoleInfo($role_id,0);
			if($roleInfo > 0)
			{
				$data['RoleInfo'] = $this->Role_model->getSingleRoleInfo($role_id,1);
				if(isset($_POST['btn_uptrole']))
				{
					$this->form_validation->set_rules('role_name','Role Name','required');
					
					if($this->form_validation->run())
					{
						$role_name = $this->input->post('role_name');
						$description = $this->input->post('description');
						$status = $this->input->post('status');
									
						$input_data = array(
								'role_name'=>trim($role_name),
								'status'=>$status,
								'description'=>addslashes($description)
								);

						$roledata = $this->Role_model->updateRole($input_data,$role_id);

						if($roledata)
						{	
							$this->session->set_flashdata('success','Role updated successfully.');

							redirect(base_url().'Roles/index');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating role.');

							redirect(base_url().'Roles/updateRole/'.base64_encode($role_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'Roles/updateRole/'.base64_encode($role_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Role not found.';
			}
		}
		
		$this->load->view('admin_header',$data);
		$this->load->view('updateRole',$data);
		$this->load->view('admin_footer');
	}
	
	public function deleteRole()
	{
		$data['error_msg']='';
		$role_id = base64_decode($this->uri->segment(3));
		if($role_id)
		{
			$roleInfo = $data['roleInfo'] = $this->Role_model->getSingleRoleInfo($role_id,1);
			if(count($roleInfo) > 0)
			{
				$delrole=$this->Role_model->deleteRole($role_id);
				if($delrole > 0)
				{
					$this->session->set_flashdata('success','Role deleted successfully.');
					redirect(base_url().'Roles/index');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting role.');
					redirect(base_url().'Roles/index');
				}
			}
			else
			{
				$data['error_msg'] = 'Role not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Role not found.');
			redirect(base_url().'Roles/index');
		}
	}
}