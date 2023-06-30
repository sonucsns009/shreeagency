<?php
	require(APPPATH.'/libraries/REST_Controller.php');
	class Login extends REST_Controller {
		public function __construct()
		{
			parent::__construct();
			date_default_timezone_set(DEFAULT_TIME_ZONE);
			$this->load->model('lobaapimodel/Usermodel');
			$this->load->model('lobaapimodel/Loginmodel');
			$this->load->helper('url');
			$this->load->helper('commonfunctions');
		}
		
		public function mobilecheck_post()
		{
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$mobile_no	= $this->input->post("mobilenumber");
			$country_code	= $this->input->post("country_code");
			$fcm_token	= $this->input->post("fcm_token");
			$token 		= $this->input->post("token");
			$is_social  		= $this->input->post("is_social");
			if($token == TOKEN)
			{
				if($mobile_no == "")
				{
					$num = array(
								  'responsemessage' => 'Enter mobile number',
								  'responsecode' => "403"
								); //create an array
					$obj = (object)$num;//Creating Object from array
					$response_array=json_encode($obj);
				}
				else
				{
					$users_username = $this->Loginmodel->fetchsingledata($mobile_no);
					if(count($users_username) < 1)
					{	
						$rnd_number=rand(pow(10, 4),pow(10, 5)-1);// Crate 4 Digit Random Number for OTP 
							
						$rnd_number = "12345"; //default SMS
						
						if($mobile_no=='8087877835')
						{
							$rnd_number = "12345";
						}
						
						
						$x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$utoken 	= md5(substr(str_shuffle($x), 0, 5));
						$name=$emailaddress="";
						if(isset($_POST['name']))
						{
							$name=$_POST['name'];
						}
						if(isset($_POST['emailaddress']))
						{
							$emailaddress=$_POST['emailaddress'];
						}
						if($is_social ==1)
						{
							$name  			= $this->input->post("soc_name"); 
							$emailaddress  		= $this->input->post("soc_email");
						}
						$namec=explode(" ", $name);
						$firstname=$namec[0];
						$lastname=$name[1];
						$data1 = array(
											"mobile" 	    => $mobile_no,
											"country_code" 	    => $country_code,
											//'utoken'   			=> $utoken,
											"fullname"     		=> 	$name,
											"first_name"     		=> 	$firstname,
											"last_name"     		=> 	$lastname,
											"email"     	=> 	$emailaddress,
											"device_id"     	=> $fcm_token,
											//"upassword" 		=> md5($password),
											"temp_otp" 	 	=> $rnd_number,
											"status_flag" 	 	=> 'Active',
											"added_date"         => date('Y-m-d H:i:s'),
											"date_updated"       => date('Y-m-d H:i:s'),
									  );
						
						$result   = $this->Usermodel->insert_new_user($data1);
						if($result 	== TRUE)
						{
							$strMessage  = urlencode("OTP for your Deseos App registration is $rnd_number . Do not share it with anyone.");
							$this->load->helper('commonfunctions');
							//$strMessageSid  = fnSendSms($strMessage, $country_code.$mobile_no,$country_code);
							
							$insert_id = $this->db->insert_id();
							$strProfileId  = "LB-".$insert_id;
							$strRegStep = 1;
							$strRegNo = $this->Usermodel->updateProfileNo($insert_id,$strProfileId,$strRegStep);
							
							if($is_social ==1)
							{
								$account_id 	= $this->input->post("account_id");
								$account_type 	= $this->input->post("account_type");
								$name  			= $this->input->post("soc_name"); 
								$email  		= $this->input->post("soc_email");
								
								$arrDataSocial = array(
											"account_id"    	=> $account_id,
											"account_type" 	    => $account_type,
											//"user_id"      		=> $users_username[0]['user_id'],
											"user_id"	=>$insert_id,
											"name"     			=> $name,
											"email"   			=> $email,
											"dateadded"         => date('Y-m-d H:i:s'),
											"dateupdated"       => date('Y-m-d H:i:s'),
									  );
								$resultSocial   = $this->Usermodel->insert_new_socialuser($arrDataSocial);	  
							}
							
							/* code for send mail to customer */
							if($emailaddress!="")
							{
								//$strMessage  = urlencode($strMessage1);
								$strSubject = "Successfully registration on Deseos";
								$output_arr=array('view_load'=>'registration_mail_for_customer');
								
								$rst_profile_id="DSEOSRST00".$rst_id;
								$input_arr=array('strCustName'=>$name,
											'base_pat'=>base_url(),
											'custprofileID'=>$strProfileId,
											'custmobile_number'=>$country_code.$mobile_no,
											'subject_mail'=>$strSubject);
								
								$strMessageSid  = smt_send_mail($emailaddress,$output_arr,$input_arr);
								
							}
							/* end of code for send mail to customer */
							
							$data1['user_id'] = $insert_id;
							$data1['profile_id'] = $strProfileId;
							$data['data']            = $data1;
							$data['responsemessage'] = 'New User Added successfully';
							$data['responsecode']    = "200";
							$response_array          = json_encode($data);
						}
						
						/*$num = array('responsemessage' => 'Mobile Number does not exist. Please Register to Login',
									 'responsecode' => "405"
									); //create an array
						$obj = (object)$num;//Creating Object from array
						
						$response_array=json_encode($obj); */
					}
					else
					{
						// check here user is active?
						if($users_username[0]['status_flag']=='Inactive')
						{
							$data['responsemessage'] = 'User is block by admin.';
							$data['responsecode'] = "202";
							$response_array=json_encode($data);
						}
						else if($users_username[0]['status_flag']=='Delete')
						{
							$data['responsemessage'] = 'User is deleted by admin or yourself. Please contact admin.';
							$data['responsecode'] = "203";
							$response_array=json_encode($data);
						}
						else
						{
							$name=$emailaddress="";
							if(isset($_POST['name']))
							{
								$name=$_POST['name'];
								if($name!='')
									$this->Usermodel->newupdateDataadded($users_username[0]['user_id'],$name);
							}
							if(isset($_POST['emailaddress']))
							{
								$emailaddress=$_POST['emailaddress'];
								if($emailaddress!='')
									$this->Usermodel->newupdateDataadded1($users_username[0]['user_id'],$emailaddress);
							}
							$rnd=rand(pow(10, 4),pow(10, 5)-1);// Crate 5 Digit Random Number for OTP 
							$rnd = "12345";
							if($mobile_no=='8087877835')
							{
								$rnd = "12345";
							}
							$x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							$updateData['utoken'] 		= md5(substr(str_shuffle($x), 0, 5));
							$updateData['temp_otp'] 	= $rnd;
							$updateData['fcm_token'] 	= $fcm_token;
							$updateOtp 					= $this->Usermodel->updateData($users_username[0]['user_id'],$updateData);
							#echo $this->db->last_query();exit;
							$strMessage  = urlencode("OTP for your Deseos App login is $rnd . Do not share it with anyone.");
							#if($login_data->country == "India")
							{
								$this->load->helper('commonfunctions');
								//$strMessageSid  = fnSendSms($strMessage, $users_username[0]['country_code'].$users_username[0]['mobilenumber'],$users_username[0]['country_code']);
							}
							$is_social  		= $this->input->post("is_social");
							if($is_social ==1)
							{
								$account_id 	= $this->input->post("account_id");
								$account_type 	= $this->input->post("account_type");
								$name  			= $this->input->post("soc_name"); 
								$email  		= $this->input->post("soc_email");
								
								$arrDataSocial = array(
											"account_id"    	=> $account_id,
											"account_type" 	    => $account_type,
											"user_id"      		=> $users_username[0]['user_id'],
											"name"     			=> $name,
											"email"   			=> $email,
											"dateadded"         => date('Y-m-d H:i:s'),
											"dateupdated"       => date('Y-m-d H:i:s'),
									  );
								$resultSocial   = $this->Usermodel->insert_new_socialuser($arrDataSocial);
								
							}

							$users_username = $this->Loginmodel->fetchsingledata($mobile_no);
							$datas =array(
											"user_id"=>$users_username[0]['user_id'],
											"profile_id"=>$users_username[0]['profile_id'],
											"mobilenumber"=>$users_username[0]['mobile'],
											"country_code"=>$users_username[0]['country_code'],
											//"username"=>$users_username[0]['username'],
											"fullname"=>$users_username[0]['fullname'],
											"ugender"=>$users_username[0]['gender'],
											"emailaddress"=>$users_username[0]['email'],
											"country"=>$users_username[0]['country'],
											//"user_step"=>$users_username[0]['user_step'],
											"temp_otp "=>$rnd,
											//"strMessageSid"=>$strMessageSid,
										 );
							$data['data'] = $datas;
							$data['responsemessage'] = 'Login Successfully';
							$data['responsecode'] = "200";
							$response_array=json_encode($data);
						}
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
		public function signup_post()
		{
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$token 			= $this->input->post("token");
			$fullname		= $this->input->post("fullname");
			$mobile			= $this->input->post("mobilenumber");
			$emergency_contact			= $this->input->post("emergency_contact");
			$address	= $this->input->post("address");
			if($token == TOKEN)
			{
				if($fullname=="" || $mobile == ""){
					$num = array('responsemessage' => 'Please provide valid data ',
						'responsecode' => "403"); //create an array
					$obj = (object)$num;//Creating Object from array
						
					$response_array=json_encode($obj);
				}	
				else
				{
					$userExists = $this->Usermodel->checkUserByMobile($mobile);
					if(count($userExists) > 0)
					{	
						$data['responsemessage'] = 'User already exists';
						$data['responsecode'] = "202";
						$response_array=json_encode($data);
					}
					else
					{
						$rnd=rand(pow(10, 4),pow(10, 5)-1);// Crate 5 Digit Random Number for OTP 
							$rnd = "12345";
							if($mobile=='8087877835')
							{
								$rnd = "12345";
							}
						$arrDriverData = array(
												'fullname'  	 	   => $fullname,
												'mobile'  	   => $mobile,
												'alt_mobile'  	   => $emergency_contact,
												'temp_otp'  	  	   => $rnd,
												//'restaurnt_id'  	   => $restid,
												'address_1'  	   => $address,
												'is_login'        	   => 1,
												'status_flag'          	   => 'Inactive',
												'added_date'       	   => date("Y-m-d H:i:s"),
												'date_updated'     	   => date("Y-m-d H:i:s"),
											  );
									  
						$result   = $this->Usermodel->insert_new_user($arrDriverData);	
						$data['data'] = $arrDriverData;
						$data['responsemessage'] = 'Driver added successfully';
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
		public function updateUser_post()
		{
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$token 			= $this->input->post("token");
			$user_id		= $this->input->post("user_id");
			$gender		= $this->input->post("gender");
			$weight			= $this->input->post("weight");
			$id_front			= $this->input->post("id_front");
			$id_back	= $this->input->post("id_back");
			$mobility	= $this->input->post("mobility");
			$medical_history	= $this->input->post("medical_history");
			$fingerprint	= $this->input->post("fingerprint");

			if($token == TOKEN)
			{
				if($gender=="" || $weight == ""){
					$num = array('responsemessage' => 'Please provide valid data ',
						'responsecode' => "403"); //create an array
					$obj = (object)$num;//Creating Object from array
						
					$response_array=json_encode($obj);
				}	
				else
				{
						$photo_front='';
						//echo $_FILES['user_photo']['name'];exit;
						if($_FILES['id_front']['name']!="")
						{
							
							$new_image_name1 = rand(1, 99999).$_FILES['id_front']['name'];
								
								$config = array(
									'upload_path' => "uploads/user/id_proof",
									'allowed_types' => "gif|jpg|png|bmp|jpeg",
									'max_size' => "0", 
									'file_name' =>$new_image_name1
									);
								$this->load->library('upload', $config);
								if($this->upload->do_upload('id_front'))
								{ 
									$imageDetailArray = $this->upload->data();								
									$photo_front =  $imageDetailArray['file_name'];
								}
								else
								{
									//echo $this->upload->display_errors();
								} 
								
								
						}

						$photo_back='';
						//echo $_FILES['user_photo']['name'];exit;
						if($_FILES['id_back']['name']!="")
						{
							
							$new_image_name2 = rand(1, 99999).$_FILES['id_back']['name'];
								
								$config = array(
									'upload_path' => "uploads/user/id_proof",
									'allowed_types' => "gif|jpg|png|bmp|jpeg",
									'max_size' => "0", 
									'file_name' =>$new_image_name2
									);
								$this->load->library('upload', $config);
								if($this->upload->do_upload('id_back'))
								{ 
									$imageDetailArray = $this->upload->data();								
									$photo_back =  $imageDetailArray['file_name'];
								}
								else
								{
									//echo $this->upload->display_errors();
								} 
								
								
						}

						$photo_fingerprint='';
						//echo $_FILES['user_photo']['name'];exit;
						if($_FILES['fingerprint']['name']!="")
						{
							
							$new_image_name3 = rand(1, 99999).$_FILES['fingerprint']['name'];
								
								$config = array(
									'upload_path' => "uploads/user/fingerprints",
									'allowed_types' => "gif|jpg|png|bmp|jpeg",
									'max_size' => "0", 
									'file_name' =>$new_image_name3
									);
								$this->load->library('upload', $config);
								if($this->upload->do_upload('fingerprint'))
								{ 
									$imageDetailArray = $this->upload->data();								
									$photo_fingerprint =  $imageDetailArray['file_name'];
								}
								else
								{
									//echo $this->upload->display_errors();
								} 
								
								
						}
						
						
						$arrDriverData = array(
												'gender'  	 => $gender,
												'weight'  	   => $weight,
												'id_front'  	   => $photo_front,
												'id_back'  	   => $photo_back,
												'mobility'  	   => $mobility,
												'medical_history'  	  	   => $medical_history,
												//'restaurnt_id'  	   => $restid,
												'fingerprint'  	   => $photo_fingerprint,
												'date_updated'     	   => date("Y-m-d H:i:s"),
											  );
									  
						$result   = $this->Usermodel->updateUserData($user_id,$arrDriverData);	
						$data['data'] = $arrDriverData;
						$data['responsemessage'] = 'Driver added successfully';
						$data['responsecode'] = "200";
						$response_array=json_encode($data);						
					
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
		public function confirmotp_post()
		{	
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$username	= $this->input->post("mobilenumber");
			$otp_code	= $this->input->post("otp_code");			 
			$token 		= $this->input->post("token");
			if($token == TOKEN)
			{
				if($username=="" || $otp_code == "")
				{
					 
					$num = array('responsemessage' => 'Please provide valid data ',
						'responsecode' => "403"); //create an array
					$obj = (object)$num;//Creating Object from array
						
					$response_array=json_encode($obj);
					 
				}
				else
				{
					$login_data = $this->Usermodel->checkOtp($username,$otp_code);
					#print $this->db->last_query(); exit;
					if(count($login_data) > 0)
					{ 							
					 	$datas = array(
										'id'          => $login_data[0]['user_id'],
										'name'  	  => $login_data[0]['fullname'],
										'mobile'      => $login_data[0]['mobile'],
										'email'       => $login_data[0]['email'],
										'otp'         => $otp_code,
									  );
						$data['data'] = $datas;
						$data['responsemessage'] = 'Login Successfully';
						$data['responsecode'] = "200";
						$response_array=json_encode($data);
					}
					else  
					{
						$num = array(
										'responsemessage' => 'OTP does not match.',
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
		##### RESEND OTP ##### 
		public function resendOtp_post()
		{
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$token 		= $this->input->post("token");
			$username	= $this->input->post("mobilenumber");
			
			if($token == TOKEN)
			{
				$users_username = $this->Loginmodel->fetchsingledata($username);
				$user_id 		= $users_username[0]['user_id'];
				
				if(count($users_username) > 0)
				{
					$rnd=rand(pow(10, 4),pow(10, 5)-1);// Crate 4 Digit Random Number for OTP 
					$rnd = "12345"; //default SMS
					if($username=='8087877835')
					{
						$rnd = "12345";
					}
					if($this->input->post("print") == 1)
					{
						//print_r($users_username); exit;
					}		
					$rnd= $strOtp = $users_username[0]['temp_otp'];
					 
					$updateData['temp_otp'] 	= $rnd;
					$updateData['fcm_token'] 	=$users_username[0]['device_id'];
					$updateOtp 					= $this->Usermodel->updateData($user_id,$updateData);
					$strMessage  = urlencode("OTP for your Deseos App is $rnd . Do not share it with anyone.");
					$this->load->helper('commonfunctions');
					fnSendSms($strMessage, $users_username[0]['country_code'].$username,$users_username[0]['country_code']);
					
					$datas = array(
										'username'   	=> $username,
										'temp_otp' 	=> $updateData['temp_otp'],
								   );
					$data['data'] = $datas;
					$data['responsemessage'] = 'OTP Send Successfully';
					$data['responsecode'] = "200";
					$response_array=json_encode($data);
				}
				else
				{
					$num = array(
								'responsemessage' => 'User Not Available, please contact admin or register again.',
								'responsecode' => "202"
							); //create an array
					$obj = (object)$num;//Creating Object from array
					$response_array=json_encode($obj);
				}
				print_r($response_array);
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
		}
		
		
		
		public function changePassword_post()
		{
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$password		= $this->input->post("password");
			$oldpassword	= $this->input->post("oldpassword");
			$id				= $this->input->post("id");
			$token 			= $this->input->post("token");
			if($token == TOKEN)
			{				
				if($password == "" || $id == "")
				{
					 
					$num = array('responsemessage' => 'Enter agent id and password ',
						'responsecode' => "403"); //create an array
					$obj = (object)$num;//Creating Object from array
						
					$response_array=json_encode($obj);
					 
				}
				else if(strlen($password) < 6 && strlen($password) > 16)
				{
					$num = array('responsemessage' => 'password should be between 6 to 15 characters. ',
						'responsecode' => "403"); //create an array
					$obj = (object)$num;//Creating Object from array
						
					$response_array=json_encode($obj);
				}
				else
				{
					$result1   = $this->Usermodel->checkpassword(md5($oldpassword), $id);
					//print_r($this->db->last_query()); die;
					if($result1 != '1')
					{
						$num = array(
											'responsemessage' => 'old password not match',
											'responsecode' => "209"
										); //create an array
						$obj = (object)$num;//Creating Object from array
						$response_array=json_encode($obj);
					}
					else
					{
						$result = $this->Usermodel->changePassword($id,$password);
						if($result)
						{
							$data['data'] = '';
							$data['responsemessage'] = 'Password changed successfully';
							$data['responsecode'] = "200";
							$response_array=json_encode($data);
						}
						else  
						{
							
							$num = array(
											'responsemessage' => 'Something went wrong',
											'responsecode' => "401"
										); //create an array
							$obj = (object)$num;//Creating Object from array
							$response_array=json_encode($obj);
						}
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
		public function forgotPassword_post()
		{
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$username	= $this->input->post("username");
			$token 		= $this->input->post("token");
			if($token == TOKEN)
			{
				if($username == "")
				{				 
					$num = array('responsemessage' => 'Enter User name',
						'responsecode' => "403"); //create an array
					$obj = (object)$num;//Creating Object from array
						
					$response_array=json_encode($obj);
					 
				}
				else
				{
				    $users_username = $this->Usermodel->checksingledata($username);
					if(count($users_username) < 1)
					{					
						$num = array('responsemessage' => 'Username does not exist',
									 'responsecode' => "405"
									); //create an array
						$obj = (object)$num;//Creating Object from array						
						$response_array=json_encode($obj);						 
					}
					else if(count($users_username) > 0)
					{ 
						$login_data = $this->Loginmodel->get_user_login($username);
						if( $this->input->get("print") ==1) 
						{
						  	print $this->db->last_query(); exit;					
						}
						
						#$rnd = "1111";
						if($login_data)
						{
							$rnd=rand(pow(10, 3),pow(10, 4)-1);// Crate 4 Digit Random Number for OTP 
							//$rnd = "12345";
							if($username=='8087877835')
							{
								$rnd = "12345";
							}
					
							$user_id = $login_data->user_id;
							$updateData['otp_code'] 	= $rnd;
							$updateOtp 					= $this->Usermodel->updateForgotPasswordOtp($user_id,$updateData);
							$strMessage  = urlencode("OTP to recover you password is for your your Deseos App login is $rnd . Do not share it with anyone.");
							$this->load->helper('commonfunctions');
							fnSendSms($strMessage, $login_data->country_code.$username,$login_data->country_code);
							  
							$datas=array(
											'user_id'  		=> $login_data->user_id,
											'fullname'      => $login_data->fullname,
											'mobile'  		=> $login_data->mobilenumber,
											'username'   	=> $login_data->username,
											'email'    	    => $login_data->emailaddress,
											'otp_forgot_code'=> $updateData['otp_code'],
										);
							$data['data'] = $datas;
							$data['responsemessage'] = 'Forgot Password OTP Sent Successfully';
							$data['responsecode'] = "200";
							$response_array=json_encode($data);
						}
						else
						{
							$num = array(
											'responsemessage' => 'User not Available',
											'responsecode' => "203s"
										); //create an array
							$obj = (object)$num;//Creating Object from array
							$response_array=json_encode($obj);
						}	
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

		public function forgotPasswordOtp_post()
		{
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$username	= $this->input->post("username");
			$uid	= $this->input->post("user_id");
			$otp_code	= $this->input->post("otp_forgot_code");			 
			$password	= $this->input->post("password");			 
			$token = $this->input->post("token");
			if($token == TOKEN)
			{
				if($username=="" || $otp_code == "" || $password == "")
				{
					 
					$num = array('responsemessage' => 'Enter username and OTP sent ',
						'responsecode' => "403"); //create an array
					$obj = (object)$num;//Creating Object from array
						
					$response_array=json_encode($obj);
					 
				}
				else
				{
					$login_data=$this->Usermodel->getDataByForgotOTP($username,$otp_code);
					 if(count($login_data) > 0){
						$strUpdatePwd = $this->Usermodel->updatePassword($uid,$otp_code,$password,$username);
						if($strUpdatePwd == 1)
						{
							#$data['data'] = $datas;
							$data['updateval'] = $strUpdatePwd;
							$data['responsemessage'] = 'Password Changed Successfully';
							$data['responsecode'] = "200";
							$response_array=json_encode($data);
						}
					}
					else 
					{
						$num = array(
										'responsemessage' => 'OTP does not match.',
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
		
	}
 ?>