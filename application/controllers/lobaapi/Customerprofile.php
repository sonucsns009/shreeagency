<?php
	require(APPPATH.'/libraries/REST_Controller.php');
	class Customerprofile extends REST_Controller {
		public function __construct()
		{
			parent::__construct();
			date_default_timezone_set(DEFAULT_TIME_ZONE);
			$this->load->model('apimdvsk/Customerprofilemodel');
			$this->load->helper('url');
		}
		
		public function myprofile_post()
		{
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$user_id	= $this->input->post("user_id");
			$token 		= $this->input->post("token");
			
			
			if($token == TOKEN)
			{
				if($user_id == "")
				{
					$num = array(
								  'responsemessage' => 'Provide user id',
								  'responsecode' => "403"
								); //create an array
					$obj = (object)$num;//Creating Object from array
					$response_array=json_encode($obj);
				}
				else
				{
					$numusersInfo = $this->Customerprofilemodel->getUserProfileInfo($user_id,0);
					if($numusersInfo > 0)
					{	
						$getusersInfo = $this->Customerprofilemodel->getUserProfileInfo($user_id,1);
						
						$user_photo='';
						if($getusersInfo[0]['user_photo']!="")
						{
							$user_photo=base_url().'uploads/users/'.$getusersInfo[0]['user_photo'];
						}
						$user_datas =array("profile_id"=>$getusersInfo[0]['profile_id'],
											"fullname"=>$getusersInfo[0]['fullname'],
											"emailaddress"=>$getusersInfo[0]['emailaddress'],
											"country_code"=>$getusersInfo[0]['country_code'],
											"mobilenumber"=>$getusersInfo[0]['mobilenumber'],
											"user_photo"=>$user_photo,
											"dateadded"=>date('d M Y H:i:s',strtotime($getusersInfo[0]['dateadded'])),
											"dateupdated"=>date('d M Y H:i:s',strtotime($getusersInfo[0]['dateupdated']))
										 );
							$data['userdata'] = $user_datas;
							$data['responsemessage'] = 'User profile details';
							$data['responsecode'] = "200";
							$response_array=json_encode($data);
					}
				}
			}
			else
			{
				$num = array(
								'responsemessage' => 'Token not match',
								'responsecode' => "201"
							); //create an array
				$obj = (object)$num;//Creating Object from array
				$response_array=json_encode($obj);
			}
			print_r($response_array);
		}
		
		public function updateCustomerProfile_post()
		{
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$user_id	= $this->input->post("user_id");	
			$fullname	 = $this->input->post("fullname");		
			$emailaddress = $this->input->post("emailaddress");
			$token 		= $this->input->post("token");
			
			if($token == TOKEN)
			{
				if($fullname=="" || $emailaddress == "" )
				{
					 
					$num = array('responsemessage' => 'Please provide valid data ',
						'responsecode' => "403"); //create an array
					$obj = (object)$num;//Creating Object from array
						
					$response_array=json_encode($obj);
					 
				}
				else
				{
					$user_datas =array("fullname"=>$fullname,
											"emailaddress"=>$emailaddress,
											"dateupdated"=>date('d M Y H:i:s')
										 );
									  
					$updateinfos = $this->Customerprofilemodel->updateUserProfileInfo($user_datas,$user_id);
					
					if($updateinfos)
					{ 							
					 	$data['responsemessage'] = 'Profile info updated successfully.';
						$data['responsecode'] = "200";
						$response_array=json_encode($data);
					}
					else  
					{
						$num = array(
										'responsemessage' => 'Error while updating',
										'responsecode' => "401"
									); //create an array
						$obj = (object)$num;//Creating Object from array
						$response_array=json_encode($obj);
					}
				}
			}
			else
			{
				$num = array(
								'responsemessage' => 'Token not match',
								'responsecode' => "201"
							); //create an array
				$obj = (object)$num;//Creating Object from array
				$response_array=json_encode($obj);
			}	
			print_r($response_array);

		}
		
		
		public function updateProfilePhoto_post()
		{
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$user_id	= $this->input->post("user_id");	
			$user_photo	 = $this->input->post("user_photo");
			$token 		= $this->input->post("token");
			
			if($token == TOKEN)
			{
				$photo_imagename='';
				//echo $_FILES['user_photo']['name'];exit;
				if($_FILES['user_photo']['name']!="")
				{
					$photo_imagename='';
					$new_image_name = rand(1, 99999).$_FILES['user_photo']['name'];
						
						$config = array(
							'upload_path' => "uploads/users/",
							'allowed_types' => "gif|jpg|png|bmp|jpeg",
							'max_size' => "0", 
							'file_name' =>$new_image_name
							);
						$this->load->library('upload', $config);
						if($this->upload->do_upload('user_photo'))
						{ 
							$imageDetailArray = $this->upload->data();								
							$photo_imagename =  $imageDetailArray['file_name'];
						}
						else
						{
							//echo $this->upload->display_errors();
						} 
						
						$user_datas =array("user_photo"=>$photo_imagename,
											"dateupdated"=>date('d M Y H:i:s')
										 );
									  
									  
						$updateinfos = $this->Customerprofilemodel->updateUserPhoto($user_datas,$user_id);
					
						if($updateinfos)
						{ 							
							$data['responsemessage'] = 'Profile photo updated successfully.';
							$data['responsecode'] = "200";
							$response_array=json_encode($data);
						}
						else  
						{
							$num = array(
											'responsemessage' => 'Error while updating profile photo',
											'responsecode' => "401"
										); //create an array
							$obj = (object)$num;//Creating Object from array
							$response_array=json_encode($obj);
						}
				}
				else
				{
					$num = array('responsemessage' => 'Please provide profile photo ',
						'responsecode' => "403"); //create an array
					$obj = (object)$num;//Creating Object from array
						
					$response_array=json_encode($obj);
					 
				}
			}
			else
			{
				$num = array(
								'responsemessage' => 'Token not match',
								'responsecode' => "201"
							); //create an array
				$obj = (object)$num;//Creating Object from array
				$response_array=json_encode($obj);
			}	
			print_r($response_array);

		}
		
	}
 ?>