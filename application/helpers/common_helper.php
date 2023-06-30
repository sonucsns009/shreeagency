<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function __construct()
    {
		// Call the Model constructor
        $this->load->library('email');
		date_default_timezone_set('Asia/Kolkata');
    }
	
	function create_thumb($width,$height,$file_path)
	{
		$ci = get_instance();
		$ci->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $file_path; 
		$config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = $file_path;               
        $ci->image_lib->initialize($config);
        if(!$ci->image_lib->resize())
        { 
            echo $ci->image_lib->display_errors();exit;
        }     
	}
	
 function smt_send_mail($userEmail,$output_arr,$input_arr)
	{
		$ci = get_instance();
		$config = Array('protocol' => 'smtp',
								'smtp_host' => 'csns.co.in',
								'smtp_port' => 587,
								'smtp_user' => 'rahul@csns.co.in',
								'smtp_pass' => 'csns123$',
								'mailtype'  => 'html', 
								'charset'   => 'iso-8859-1'
								);
					
		$ci->email->set_newline("\r\n");  
		$ci->email->initialize($config);
		$ci->email->from($input_arr['admin_email'],'Jaybhim Shadi');
		$ci->email->to($userEmail); 		 
		$ci->email->subject($input_arr['subject_mail']);
		
		$mesg = $ci->load->view('frontend/email/'.$output_arr['view_load'],$input_arr,true);
		
		$ci->email->message($mesg);
		//
		$str_email=$ci->email->send();
		//print_r($ci->email);exit;
		if($str_email)
		{
			  return true;
		}
		else
		{
			//print_r($this->email);echo $str;exit;
			return false;
		}
	}
	
	### FUNCTION TO SEND SMS
	function fnSendSms($strMessage, $strMobile)
	{
		$strUserName = "kreedak";
		$strPassword = "kreedak";
		$strSenderId = "KREEDO";
		$strMobile 	 = "91".$strMobile;
		
		$strUrl = "http://49.50.67.32/smsapi/httpapi.jsp?username=$strUserName&password=$strPassword&from=$strSenderId&to=$strMobile&text=$strMessage";
		
		$curl 		 = curl_init() or die("Error");  		
		curl_setopt($curl, CURLOPT_URL, $strUrl);  // Web service for OTP sending 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($curl, CURLOPT_HEADER, 0);
		$output = curl_exec($curl); 
		curl_close($curl);
		//var_dump($output);
	} 
?>