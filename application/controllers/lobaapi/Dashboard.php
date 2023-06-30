
<?php 
require(APPPATH.'/libraries/REST_Controller.php');

	
class Dashboard extends REST_Controller {

	public function __construct()
	{ 
		parent::__construct();
		date_default_timezone_set(DEFAULT_TIME_ZONE);	
		$this->load->model('lobapaimodel /Dashboardmodel');
		$this->load->helper('commonfunctions');
		$this->load->helper('commonfunctions_helper');

		$this->load->library("pagination");
		$this->load->helper('url');
		
	}
	
	## First Home (Dashboard) Screen ###
	public function index_post()
	{
		date_default_timezone_set(DEFAULT_TIME_ZONE);	
		error_reporting(-1);
		ini_set('display_errors', 1);
		$token 				= $this->input->post("token");
		if($token == TOKEN)
		{
			
			$arrCusines   = $this->Homemodel->getAllCusines(0,'',$lng,$catid);

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
	
	public function sort_array_of_array(&$array, $subfield)
	{
		date_default_timezone_set(DEFAULT_TIME_ZONE);	
		$sortarray = array();
		foreach ($array as $key => $row)
		{
			$sortarray[$key] = $row[$subfield];
		}

		array_multisort($sortarray, SORT_DESC, $array);
	}
	
	## cusinies data load ##
	public function cusinies_filter_post()
	{
		date_default_timezone_set(DEFAULT_TIME_ZONE);	
		#ini_set("display_errors",1);
		#error_reporting(E_ERROR);
		$lng		 		= $this->input->post("lng");
		$token 				= $this->input->post("token");
		$catid				= $this->input->post("catid");
		
		$arrCusines   = $this->Homemodel->getAllCusines(0,'',$lng,$catid);
		#echo '<pre>';print_r($arrCusines);
		#echo $this->db->last_query();exit;
		if(is_array($arrCusines) && count($arrCusines) > 0)
		{
			$strCuisineImage="";
			foreach($arrCusines as $intK => $arrCusinesDtls)
			{
				$intCuisineId 	 	= $arrCusinesDtls['cuisine_id'];
				$strCuisineTitle 	= $arrCusinesDtls['cuisine_title'];
				$strCuisineImg 		= $arrCusinesDtls['cuisine_image'];
				
				$strCuisineImage = '';
				if($strCuisineImg!="")
				{
					$strCuisineImage=base_url()."uploads/cuisines/".$strCuisineImg;
				}
				
				$arrDesCuisinesData[] = array( 
												"cuisine_id"=> $intCuisineId,
												"cuisine_title"=>$strCuisineTitle,
												"cuisine_image"=>$strCuisineImage
											 );
			}
			
			$data['data'] = $arrDesCuisinesData;					
			#$data['banners'] = $arrDisBanners;
			$data['responsemessage'] = 'Listing of Cusines.';
			$data['responsecode'] = "200";
			$response_array=json_encode($data);
		}
		else
		{
			$num = array(
							'responsemessage' => 'No Cusinies Available',
							'responsecode' => "210"
						); //create an array
			$obj = (object)$num;//Creating Object from array
			$response_array=json_encode($obj);
		}
		print_r($response_array);		
	}
	## end of cusinies data ##
	
	## Second Home Screen as per category click ###
	public function home_post()
	{
		date_default_timezone_set(DEFAULT_TIME_ZONE);//"Europe/Madrid"
		
		#ini_set("display_errors",1);
		#error_reporting(E_ERROR);
		$lng		 		= $this->input->post("lng");
		$token 				= $this->input->post("token");
		
		#$userCity			= $this->input->post("userCity");
		$userLat			= $this->input->post("userLat");
		$userLong			= $this->input->post("userLong");
		$available_type		= $this->input->post("available_type");
		$catid				= $this->input->post("catid");
		$isNew = $str_tags  = "";
		$testcheck=$this->input->post("testcheck");

		// if($testcheck==1)
		// {
		// 	echo "<pre>";
		// 	print_r(date("Y-m-d h:i:s a"));
		// 	exit;
		// }
		if($token == TOKEN)
		{
			$userCity='';
			if(isset($_POST['userCity']))
			{
				$userCity=$_POST['userCity'];
			}
			if($userLat=='')
			{
				$userLat='28.7293181';
			}
			if($userLong=='')
			{
				$userLong='-13.8663339';
			}
			if( $userLat!="" && $userLong!="" && $catid!="")
			{
				$rating_filter='Na';
				$cuisine_id='';
				$sort_by='';
				if(isset($_POST['cuisine_id']))
				{
					$cuisine_id=$this->input->post("cuisine_id");
				}
				if(isset($_POST['sort_by']))
				{
					$sort_by=$this->input->post("sort_by");
				}
				if(isset($_POST['rating_filter']))
				{
					$rating_filter=$this->input->post("rating_filter");
				}
				$arrCusines   = $this->Homemodel->getAllCusines_for_filter($cuisine_id,$offset,$lng,$catid);
				//echo '<pre>';print_r($arrCusines);
				#echo $this->db->last_query();exit;
				if(is_array($arrCusines) && count($arrCusines) > 0)
				{
					$arrRestCusines = array();
					$strCuisineImage="";
					foreach($arrCusines as $intK => $arrCusinesDtls)
					{
						$arrRestCusines = array();
						$arrRestCusinesAll = array();

						$intCuisineId 	 	= $arrCusinesDtls['cuisine_id'];
						$intCatId 		 	= $arrCusinesDtls['main_cat_id'];
						$strCuisineTitle 	= $arrCusinesDtls['cuisine_title'];
						$strCuisineDesc     = $arrCusinesDtls['cuisine_desc'];
						$strCuisineImg 		= $arrCusinesDtls['cuisine_image'];
						
						$distance_customer=$this->Homemodel->getcustomerdistance();

						$arrGetRestaurantsAll  = $this->Homemodel->AllRestarantsByCusinesAll_for_filter($sort_by,$userLat,$userLong,$available_type,$rating_filter,$intCuisineId,1,$lng,$distance_customer,$strCuisineTitle,$intCatId);
						//echo $this->db->last_query();exit;
						
						$arrGetRestaurants  = $this->Homemodel->AllRestarantsByCusines_for_filter($sort_by,$userLat,$userLong,$available_type,$rating_filter,$intCuisineId,1,$lng,$distance_customer,$strCuisineTitle);
						// if(isset($_POST['print']))
						// {
						// 	echo $this->db->last_query();exit;
						// }
						
						if(is_array($arrGetRestaurantsAll) && count($arrGetRestaurantsAll) > 0)
						{ 
							
							$p=0;
							#echo '<pre>';print_r($arrGetRestaurants);
							
							$opening_flag=0;

							foreach($arrGetRestaurantsAll as $intK => $arrGetRestaurantsDtlsAll)
							{
								$intRstId= $arrGetRestaurantsDtlsAll['rst_id'];
								
								$cntmainList=$this->Homemodel->getRestMainCategories($intRstId,0,$lng);
								//echo $this->db->last_query();exit;
								if($cntmainList>0)
								{
									$rst_tags='';
									$strRestImage='';
									$resDistance=0;
									
									$intRstProfileId = $arrGetRestaurantsDtlsAll['rst_profile_id'];
									$rst_name 		 = $arrGetRestaurantsDtlsAll['rst_name'];
									$rst_email		 = $arrGetRestaurantsDtlsAll['rst_email'];
									$rst_image 		 = $arrGetRestaurantsDtlsAll['rst_image'];
									$rst_avg_cost	 = $arrGetRestaurantsDtlsAll['rst_avg_cost'];
									$rst_tags		 = $arrGetRestaurants[$p]['rst_tags'];
									$rst_address 	 = $arrGetRestaurantsDtlsAll['rst_address'];
									$rst_city 	 = $arrGetRestaurantsDtlsAll['rst_city'];
									$rst_lat 		 = $arrGetRestaurantsDtlsAll['rst_lat'];
									$rst_lng 		 = $arrGetRestaurantsDtlsAll['rst_lng'];
									$rst_opening_status	=	$arrGetRestaurantsDtlsAll['rst_opening_status'];
									$resDistance	=	$arrGetRestaurantsDtlsAll['distance'];
									if($rst_image!="")
									{
										$strRestImage=base_url()."uploads/restaurant/".$rst_image;
									}
									$tagList=array();
									if($rst_tags!="")
									{
										$tagList=$this->Homemodel->getonlyRestTags($rst_tags,$intRstId,1);
									}
									
									$str_tags  = "";
									if(is_array($tagList) && count($tagList)>0)
									{ 
										$str_tags  = "";
										$arrRestTags = array();
										foreach($tagList as $avai)
										{
											$arrRestTags[]=$avai['tags'];
										}
										$str_tags=implode(",",$arrRestTags);
									}
									## AVG Count 
									$rating_avg_cnt=0;
									$rating_avg=$this->Homemodel->getRestAverageRating($intRstId);
									if(isset($rating_avg) && count($rating_avg)>0)
									{
										$rating_avg_cnt=round($rating_avg[0]['avg_ratings']);
									}
									# New Rest Flag
									$isNew=$this->Homemodel->checkRestaurntIsNew($intRstId);
									
									if(isset($isNew) && $isNew>0)
									{
										$isNew ="y";
									}
									else
									{
										$isNew ="n";
									}
									$time=0;
									$rstLat=$rst_lat;
									$rstLng=$rst_lng; 
									/*$resDistance=0;
									echo $rstLat;
									echo '<br/>'.$rstLng;
									echo '<br/>'.$userLat;
									echo '<br/>'.$userLong;
									
									if($rstLat!=0.00000000 && $rstLng!=0.00000000)
									{
										$resDistance=Calculatedistance($rstLat,$rstLng,$userLat,$userLong,'K');
									}*/
									$distance=$resDistance;
									$time =CalculateTime($distance); 
									/*code for getting top offer */
									$strTopCouponName ="";
									$offerrset=$this->Homemodel->checkTopOfferRest($intRstId,"");
									if(isset($offerrset) && count($offerrset)>0)
									{
										if($offerrset[0]['offer_per']!=NULL)
										{
											$strTopCouponName =$offerrset[0]['offer_per']."% OFF";
										}
									}
									/* end of code for getting top offer*/
									/* how to get current time in php */
									$opening_check_status_es="";
									$opening_flag=0;
									$current_time=date('H:i');
								
									$current_day=date('D');
									$opening_flag=$this->Homemodel->getRestuarntopeingtime($current_day,$current_time,$intRstId);
									//echo $this->db->last_query();echo '<br/>';
									/*end of current time in php */
									$checkday="";
									$checktime="";
									$opening_check_status="";
									if($opening_flag==0)
									{
											$checkday=date('Y-m-d');//, strtotime('day')
											$checkday=date('l', strtotime($checkday));
											
											$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);
											
											if($opening_check>0)
											{
												
												$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
												// if($testcheck==1)
												// {
												// 	echo "<pre>";
												// 	print_r($this->db->last_query());
												// 	exit;
												// }
												if(count($opening_check)>0)
												{
													$date1 = date('H:i',strtotime($current_time));
													$date2 = date('H:i', strtotime($opening_check[0]['from_time']));
													$to_time = date('H:i', strtotime($opening_check[0]['to_time']));
													$date3 = date('H:i', strtotime($opening_check[0]['and_from_time']));
													if($testcheck==1)
													{
														echo $date1."/".$date2."/".$to_time."/".$date3;exit;
														print_r($this->db->last_query());exit;
													}
													//echo $date1."/".$date2."/".$to_time."/".$date3;exit;
													if($date2 > $date1)
													{
														$opening_check_status='Opens at  today '.date('h:i A',strtotime($opening_check[0]['from_time']));
														$checkday="today";
														//$opening_check_status='Opens at '.$opening_check[0]['day'].' '.$opening_check[0]['from_time'];
														$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
													}
													else if($date3 > $date1)
													{

														$opening_check_status='Opens at  today '.date('h:i A',strtotime($opening_check[0]['and_from_time']));
														$checkday="today";
														//$opening_check_status='Opens at '.$opening_check[0]['day'].' '.$opening_check[0]['from_time'];
														$checktime=date('h:i A',strtotime($opening_check[0]['and_from_time']));
													}
													else
													{

														$opening_check_status='';
														$checktime='';
													}
													
												}
												else
												{
													$opening_check_status='';
													$checktime='';
													
												}
											}

											if($opening_check_status=='')
											{

													$checkday=date('Y-m-d', strtotime(' +1 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$checkday="tomorrow";
															$opening_check_status='Opens at tomorrow '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status='';
															$checktime='';
															
														}

													}
											}

												
											if($opening_check_status=='')
											{
													$checkday=date('Y-m-d', strtotime(' +2 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$opening_check_status='Opens at '.$opening_check[0]['day'].' '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status='';
															$checktime='';
															
														}
													}
											}

											if($opening_check_status=='')
											{
													$checkday=date('Y-m-d', strtotime(' +3 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$opening_check_status='Opens at '.$opening_check[0]['day'].' '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status='';
															$checktime='';
															
														}
													}
											}

											if($opening_check_status=='')
											{
													$checkday=date('Y-m-d', strtotime(' +4 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$opening_check_status='Opens at '.$opening_check[0]['day'].' '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status='';
															$checktime='';
															
														}
													}
											}


											if($opening_check_status=='')
											{
													$checkday=date('Y-m-d', strtotime(' +5 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$opening_check_status='Opens at '.$opening_check[0]['day'].' '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status='';
															$checktime='';
															
														}
													}
											}

											if($opening_check_status=='')
											{
													$checkday=date('Y-m-d', strtotime(' +6 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$opening_check_status='Opens at '.$opening_check[0]['day'].' '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status='';
															$checktime='';
															
														}
													}
											}

											if($opening_check_status=='')
											{
													$checkday=date('Y-m-d', strtotime(' +7 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$opening_check_status='Opens at '.$opening_check[0]['day'].' '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status="Closed";
															$checktime='';
															
														}
													}
											}

											
									}

									if($lng=="es")
									{

										 if(!empty($checktime))
										{
												switch ($checkday) {
										  case "Monday":
										    $opening_check_status='Abre a las Lunes '.$checktime;
										    break;
										  case "Tuesday":
										    $opening_check_status='Abre a las martes '.$checktime;
										    break;
										  case "Wednesday":
										    $opening_check_status='Abre a las miércoles '.$checktime;
										    break;
										    case "Thursday":
										    $opening_check_status='Abre a las jueves '.$checktime;
										    break;
										     case "Friday":
										    $opening_check_status='Abre a las Viernes '.$checktime;
										    break;
										     case "Saturday":
										    $opening_check_status='Abre a las sábado '.$checktime;
											break;
											case "today":
										    $opening_check_status='abre hoy '.$checktime;
											break;
											case "tomorrow":
										    $opening_check_status='abre mañana '.$checktime;
										    break;
										    default:
										    $opening_check_status='';
										  
											}	
										}
										else
										{
											$opening_check_status='';
										}
									  	
									}
									else
									{
									 	if($checktime=="")
										{
											$opening_check_status='';
										}
									}
									
									

									$arrRestCusinesAll[] = array(
																"rst_id"=>$intRstId,
																"rst_profile_id"=>$intRstProfileId,
																"rst_name"=>$rst_name,
																"rst_tags"=>$str_tags,
																#"rst_tags"=>$rst_tags,
																"rst_avg_cost"=>$rst_avg_cost,
																"rst_image"=>$strRestImage,
																"rating"=>$rating_avg_cnt,
																"isnew"=>$isNew,
																"rstLat"=>$rstLat,
																"rst_opening_status"=>$rst_opening_status,
																"opening_flag"=>$opening_flag,
																"opening_at"=>$opening_check_status,
																"rstLng"=>$rstLng,
																"resDistance"=>$resDistance,
																"querydistance"=>$querydistance,
																"time"=>round($time),
																"rst_address"=>$rst_address,
																"rst_city"=>$rst_city,
																//"time"=>$time,
																"topcoupon"=>$strTopCouponName,
																"rst_availability"=>$arrGetRestaurantsDtlsAll['rst_availability']
															 );
															$p++; 
								}
							}

							foreach($arrGetRestaurants as $intK => $arrGetRestaurantsDtls)
							{
								$intRstId= $arrGetRestaurantsDtls['rst_id'];
								
								$cntmainList=$this->Homemodel->getRestMainCategories($intRstId,0,$lng);
								//echo $this->db->last_query();exit;
								if($cntmainList>0)
								{
									$rst_tags='';
									$strRestImage='';
									$resDistance=0;
									
									$intRstProfileId = $arrGetRestaurantsDtls['rst_profile_id'];
									$rst_name 		 = $arrGetRestaurantsDtls['rst_name'];
									$rst_email		 = $arrGetRestaurantsDtls['rst_email'];
									$rst_image 		 = $arrGetRestaurantsDtls['rst_image'];
									$rst_avg_cost	 = $arrGetRestaurantsDtls['rst_avg_cost'];
									$rst_tags		 = $arrGetRestaurants[$p]['rst_tags'];
									$rst_address 	 = $arrGetRestaurantsDtls['rst_address'];
									$rst_city 	 = $arrGetRestaurantsDtls['rst_city'];
									$rst_lat 		 = $arrGetRestaurantsDtls['rst_lat'];
									$rst_lng 		 = $arrGetRestaurantsDtls['rst_lng'];
									$rst_opening_status	=	$arrGetRestaurantsDtls['rst_opening_status'];
									$resDistance	=	$arrGetRestaurantsDtls['distance'];
									if($rst_image!="")
									{
										$strRestImage=base_url()."uploads/restaurant/".$rst_image;
									}
									$tagList=array();
									if($rst_tags!="")
									{
										$tagList=$this->Homemodel->getonlyRestTags($rst_tags,$intRstId,1);
									}
									
									$str_tags  = "";
									if(is_array($tagList) && count($tagList)>0)
									{ 
										$str_tags  = "";
										$arrRestTags = array();
										foreach($tagList as $avai)
										{
											$arrRestTags[]=$avai['tags'];
										}
										$str_tags=implode(",",$arrRestTags);
									}
									## AVG Count 
									$rating_avg_cnt=0;
									$rating_avg=$this->Homemodel->getRestAverageRating($intRstId);
									if(isset($rating_avg) && count($rating_avg)>0)
									{
										$rating_avg_cnt=round($rating_avg[0]['avg_ratings']);
									}
									# New Rest Flag
									$isNew=$this->Homemodel->checkRestaurntIsNew($intRstId);
									
									if(isset($isNew) && $isNew>0)
									{
										$isNew ="y";
									}
									else
									{
										$isNew ="n";
									}
									$time=0;
									$rstLat=$rst_lat;
									$rstLng=$rst_lng; 
									/*$resDistance=0;
									echo $rstLat;
									echo '<br/>'.$rstLng;
									echo '<br/>'.$userLat;
									echo '<br/>'.$userLong;
									
									if($rstLat!=0.00000000 && $rstLng!=0.00000000)
									{
										$resDistance=Calculatedistance($rstLat,$rstLng,$userLat,$userLong,'K');
									}*/
									$distance=$resDistance;
									$time =CalculateTime($distance); 
									/*code for getting top offer */
									$strTopCouponName ="";
									$offerrset=$this->Homemodel->checkTopOfferRest($intRstId,"");
									if(isset($offerrset) && count($offerrset)>0)
									{
										if($offerrset[0]['offer_per']!=NULL)
										{
											$strTopCouponName =$offerrset[0]['offer_per']."% OFF";
										}
									}
									/* end of code for getting top offer*/
									
									/* how to get current time in php */
									$opening_flag=0;
									$current_time=date('H:i');
									$current_day=date('D');
									$opening_flag=$this->Homemodel->getRestuarntopeingtime($current_day,$current_time,$intRstId);
									//echo $this->db->last_query();echo '<br/>';
									/*end of current time in php */

									$checkday="";
									$checktime="";
									$opening_check_status="";
									if($opening_flag==0)
									{
											$checkday=date('Y-m-d');//, strtotime('day')
											$checkday=date('l', strtotime($checkday));
											
											$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);
											
											if($opening_check>0)
											{
												
												$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
												
												if(count($opening_check)>0)
												{
													$date1 = date('H:i',strtotime($current_time));
													$date2 = date('H:i', strtotime($opening_check[0]['from_time']));
													$to_time = date('H:i', strtotime($opening_check[0]['to_time']));
													$date3 = date('H:i', strtotime($opening_check[0]['and_from_time']));

													//echo $date1."/".$date2."/".$to_time."/".$date3;exit;
													if($date2 > $date1)
													{
														$checkday="today";
														$opening_check_status='Opens at  today '.date('h:i A',strtotime($opening_check[0]['from_time']));
														//$opening_check_status='Opens at '.$opening_check[0]['day'].' '.$opening_check[0]['from_time'];
														$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
													}
													else if($date3 > $date1)
													{
														$checkday="today";
														$opening_check_status='Opens at  today '.date('h:i A',strtotime($opening_check[0]['and_from_time']));
														//$opening_check_status='Opens at '.$opening_check[0]['day'].' '.$opening_check[0]['from_time'];
														$checktime=date('h:i A',strtotime($opening_check[0]['and_from_time']));
													}
													else
													{

														$opening_check_status='';
														$checktime='';
													}
													
												}
												else
												{
													$opening_check_status='';
													$checktime='';
													
												}
											}

											if($opening_check_status=='')
											{

													$checkday=date('Y-m-d', strtotime(' +1 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$checkday="tomorrow";
															$opening_check_status='Opens at tomorrow '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status='';
															$checktime='';
															
														}

													}
											}

												
											if($opening_check_status=='')
											{
													$checkday=date('Y-m-d', strtotime(' +2 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$opening_check_status='Opens at '.$opening_check[0]['day'].' '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status='';
															$checktime='';
															
														}
													}
											}

											if($opening_check_status=='')
											{
													$checkday=date('Y-m-d', strtotime(' +3 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$opening_check_status='Opens at '.$opening_check[0]['day'].' '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status='';
															$checktime='';
															
														}
													}
											}

											if($opening_check_status=='')
											{
													$checkday=date('Y-m-d', strtotime(' +4 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$opening_check_status='Opens at '.$opening_check[0]['day'].' '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status='';
															$checktime='';
															
														}
													}
											}


											if($opening_check_status=='')
											{
													$checkday=date('Y-m-d', strtotime(' +5 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$opening_check_status='Opens at '.$opening_check[0]['day'].' '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status='';
															$checktime='';
															
														}
													}
											}

											if($opening_check_status=='')
											{
													$checkday=date('Y-m-d', strtotime(' +6 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$opening_check_status='Opens at '.$opening_check[0]['day'].' '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status='';
															$checktime='';
															
														}
													}
											}

											if($opening_check_status=='')
											{
													$checkday=date('Y-m-d', strtotime(' +7 day'));
													$checkday=date('l', strtotime($checkday));
													$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,0);

													if($opening_check>0)
													{
														$opening_check=$this->Homemodel->getRestuarntopeingtimeday($checkday,$current_time,$intRstId,1);
														if(count($opening_check)>0)
														{
															$opening_check_status='Opens at '.$opening_check[0]['day'].' '.date('h:i A',strtotime($opening_check[0]['from_time']));
															$checktime=date('h:i A',strtotime($opening_check[0]['from_time']));
														}
														else
														{
															$opening_check_status="Closed";
															$checktime='';
															
														}
													}
											}

											
									}

									if($lng=="es")
									{

										 if(!empty($checktime))
										{
												switch ($checkday) {
										  case "Monday":
										    $opening_check_status='Abre a las Lunes '.$checktime;
										    break;
										  case "Tuesday":
										    $opening_check_status='Abre a las martes '.$checktime;
										    break;
										  case "Wednesday":
										    $opening_check_status='Abre a las miércoles '.$checktime;
										    break;
										    case "Thursday":
										    $opening_check_status='Abre a las jueves '.$checktime;
										    break;
										     case "Friday":
										    $opening_check_status='Abre a las Viernes '.$checktime;
										    break;
										     case "Saturday":
										    $opening_check_status='Abre a las sábado '.$checktime;
											break;
											case "today":
										    $opening_check_status='abre hoy '.$checktime;
											break;
											case "tomorrow":
										    $opening_check_status='abre mañana '.$checktime;
										    break;
										    default:
										    $opening_check_status='';
										  
											}	
										}
										else
										{
											$opening_check_status='';
										}
									  	
									}
									else
									{
									 	if($checktime=="")
										{
											$opening_check_status='';
										}
									}
									
									$arrRestCusines[] = array(
																"rst_id"=>$intRstId,
																"rst_profile_id"=>$intRstProfileId,
																"rst_name"=>$rst_name,
																"rst_tags"=>$str_tags,
																#"rst_tags"=>$rst_tags,
																"rst_avg_cost"=>$rst_avg_cost,
																"rst_image"=>$strRestImage,
																"rating"=>$rating_avg_cnt,
																"isnew"=>$isNew,
																"rstLat"=>$rstLat,
																"rst_opening_status"=>$rst_opening_status,
																"opening_flag"=>$opening_flag,
																"opening_at"=>$opening_check_status,
																"rstLng"=>$rstLng,
																"resDistance"=>$resDistance,
																"querydistance"=>$querydistance,
																"time"=>round($time),
																"rst_address"=>$rst_address,
																"rst_city"=>$rst_city,
																//"time"=>$time,
																"topcoupon"=>$strTopCouponName,
																"rst_availability"=>$arrGetRestaurantsDtls['rst_availability']
															 );
															$p++; 
								}
							}
						}
						$strCuisineImage = '';
						if($strCuisineImg!="")
						{
							$strCuisineImage=base_url()."uploads/cuisines/".$strCuisineImg;
						}
						#echo '<pre>';print_r($arrRestCusines);
						if($sort_by=='')
						{
							$this->sort_array_of_array($arrRestCusines, 'opening_flag');
						}
						
							#echo '<pre>';print_r($arrRestCusines);exit;
						if($cuisine_id=='')
						{	
							$strCuisineImage2=base_url()."uploads/cuisines/supermarket.png";
							$arrDesCuisinesData[0] = array( 
														"cuisine_id"=> 0,
														"main_cat_id"=> $intCatId,
														"cuisine_title"=>"All" ,
														"cuisine_desc"=>"No Desc",													
														"cuisine_image"=>$strCuisineImage2,
														"restaurantList"=>$arrRestCusinesAll
													 );
						}
						
						$arrDesCuisinesData[] = array( 
														"cuisine_id"=> $intCuisineId,
														"main_cat_id"=> $intCatId,
														"cuisine_title"=>$strCuisineTitle ,
														"cuisine_desc"=>$strCuisineDesc,													
														"cuisine_image"=>$strCuisineImage,
														"restaurantList"=>$arrRestCusines
													 );
						#echo "<pre>".$this->db->last_query();print_r($arrGetRestaurants);exit;					
					}
						
						/* code for banner list*/
						$arrDisBanners=array();
						$arrBanners   = $this->Homemodel->getAllBannersHome(1,0,$offset,$lng,$catid);
			
				if(is_array($arrBanners) && count($arrBanners)>0)
				{				
					foreach($arrBanners as $k)
					{
						$strBannersImage = '';	
						if($lng=="en")	
						{							
							if($k['banner_image']!="")
							{
								$strBannersImage=base_url()."uploads/banners/".$k['banner_image'];
							}
						}
						else
						{
							if($k['banner_image_es']!="")
							{
								$strBannersImage=base_url()."uploads/banners/".$k['banner_image_es'];
							}
							else
							{
								if($k['banner_image']!="")
								{
									$strBannersImage=base_url()."uploads/banners/".$k['banner_image'];
								}
							}
						}
						$banner_url='';
						if($k['banner_url']!=NULL || $k['banner_url']!='')
						{
							$banner_url=$k['banner_url'];
						}
						

						$rstImage = '';					
						if($k['rst_image']!="")
						{
							$rstImage=base_url()."uploads/restaurent/".$k['rst_image'];
						}
						
						 if($k['banner_subtype']=="product")
							{
								/*check if product is active or not*/
								$chkstoreactive=$this->Homemodel->checkbannerstoreactive($k['rst_id']);
								if($chkstoreactive>0)
								{
									 $chkproductactive=$this->Homemodel->checkbannerproductactive($k['product_id']);
									 if($chkproductactive>0)
									 {
										$arrDisBanners[] = array(
													"banner_id"=>$k['banner_id'],
													"banner_type"=>$k['banner_subtype'],
													"menuID"=>$k['product_id'],
													"rst_id"=>$k['rst_id'],
													"rst_name"=>$k['rst_name'],
													"banner_title"=>$k['banner_title'],
													"banner_image"=>$strBannersImage,
													"banner_url"=>""												
												  );
									}
								}
							}
							else if($k['banner_subtype']=="store")
							{
								/*check if product is active or not*/
								$chkstoreactive=$this->Homemodel->checkbannerstoreactive($k['rst_id']);
								if($chkstoreactive>0)
								{
									$arrDisBanners[] = array(
												"banner_id"=>$k['banner_id'],
												"rst_id"=>$k['rst_id'],
												"rst_image"=>$rstImage,
												"banner_type"=>$k['banner_subtype'],
												"banner_title"=>$k['banner_title'],
												"banner_image"=>$strBannersImage,
												"banner_url"=>""
											  );
								}
							}
							else
							{
									$arrDisBanners[] = array(
											"banner_id"=>$k['banner_id'],
											"banner_image"=>$strBannersImage,
											"banner_url"=>$banner_url,
											"banner_type"=>'url',
										  );
							}
					}
				}
				
						/*end of code for banner list*/ 
					$data['data'] = $arrDesCuisinesData;					
					$data['banners'] = $arrDisBanners;
					$data['responsemessage'] = 'Listing of Cusines.';
					$data['responsecode'] = "200";
					$response_array=json_encode($data);
				}
				else
				{
					$num = array(
									'responsemessage' => 'No Restaurant/Stores Available',
									'responsecode' => "210"
								); //create an array
					$obj = (object)$num;//Creating Object from array
					$response_array=json_encode($obj);
				}	
				
			}
			else
			{
				$num = array(
								'responsemessage' => 'User details required',
								'responsecode' => "403"
							); //create an array
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
	
	
	## Second Home Screen as per category click ###
	public function homeold_post()
	{
		date_default_timezone_set(DEFAULT_TIME_ZONE);	
		#ini_set("display_errors",1);
		#error_reporting(E_ERROR);
		$lng		 		= $this->input->post("lng");
		$token 				= $this->input->post("token");
		
		$userCity			= $this->input->post("userCity");
		$userLat			= $this->input->post("userLat");
		$userLong			= $this->input->post("userLong");
		$available_type		= $this->input->post("available_type");
		$catid				= $this->input->post("catid");
		$isNew = $str_tags  = "";
		if($token == TOKEN)
		{
			if($userCity!="" && $userLat!="" && $userLong!="" && $catid!="")
			{
				$rating_filter='Na';
				$cuisine_id='';
				$sort_by='';
				if(isset($_POST['cuisine_id']))
				{
					$cuisine_id=$this->input->post("cuisine_id");
				}
				if(isset($_POST['sort_by']))
				{
					$sort_by=$this->input->post("sort_by");
				}
				if(isset($_POST['rating_filter']))
				{
					$rating_filter=$this->input->post("rating_filter");
				}
				$arrCusines   = $this->Homemodel->getAllCusines_for_filter($cuisine_id,$offset,$lng,$catid);
				//echo '<pre>';print_r($arrCusines); exit;
				#echo $this->db->last_query();exit;
				if(is_array($arrCusines) && count($arrCusines) > 0)
				{
					$arrRestCusines = array();
					$strCuisineImage="";
					foreach($arrCusines as $intK => $arrCusinesDtls)
					{
						$intCuisineId 	 	= $arrCusinesDtls['cuisine_id'];
						$intCatId 		 	= $arrCusinesDtls['main_cat_id'];
						$strCuisineTitle 	= $arrCusinesDtls['cuisine_title'];
						$strCuisineDesc     = $arrCusinesDtls['cuisine_desc'];
						$strCuisineImg 		= $arrCusinesDtls['cuisine_image'];
						
						$distance_customer=$this->Homemodel->getcustomerdistance();
						
						$arrGetRestaurants  = $this->Homemodel->AllRestarantsByCusines_for_filter($sort_by,$userLat,$userLong,$available_type,$rating_filter,$intCuisineId,1,$lng,$distance_customer,$strCuisineTitle);
						//echo '<pre>';print_r($arrGetRestaurants); exit;
						//echo $this->db->last_query();exit;
						if(is_array($arrGetRestaurants) && count($arrGetRestaurants) > 0)
						{ 
							
							$p=0;
							#echo '<pre>';print_r($arrGetRestaurants);
							$arrRestCusines = array();
							$opening_flag=0;
							foreach($arrGetRestaurants as $intK => $arrGetRestaurantsDtls)
							{
								$intRstId= $arrGetRestaurantsDtls['rst_id'];
								
								$cntmainList=$this->Homemodel->getRestMainCategories($intRstId,0,$lng);
								//echo $this->db->last_query();exit;
								if($cntmainList>0)
								{
									$rst_tags='';
									$resDistance=0;
									
									$intRstProfileId = $arrGetRestaurantsDtls['rst_profile_id'];
									$rst_name 		 = $arrGetRestaurantsDtls['rst_name'];
									$rst_email		 = $arrGetRestaurantsDtls['rst_email'];
									$rst_image 		 = $arrGetRestaurantsDtls['rst_image'];
									$rst_avg_cost	 = $arrGetRestaurantsDtls['rst_avg_cost'];
									$rst_tags		 = $arrGetRestaurants[$p]['rst_tags'];
									$rst_address 	 = $arrGetRestaurantsDtls['rst_address'];
									$rst_city 	 = $arrGetRestaurantsDtls['rst_city'];
									$rst_lat 		 = $arrGetRestaurantsDtls['rst_lat'];
									$rst_lng 		 = $arrGetRestaurantsDtls['rst_lng'];
									$rst_opening_status	=	$arrGetRestaurantsDtls['rst_opening_status'];
									$resDistance	=	$arrGetRestaurantsDtls['distance'];
									if($rst_image!="")
									{
										$strRestImage=base_url()."uploads/restaurant/".$rst_image;
									}
									$tagList=array();
									if($rst_tags!="")
									{
										$tagList=$this->Homemodel->getonlyRestTags($rst_tags,$intRstId,1);
									}
									
									$str_tags  = "";
									if(is_array($tagList) && count($tagList)>0)
									{ 
										$str_tags  = "";
										$arrRestTags = array();
										foreach($tagList as $avai)
										{
											$arrRestTags[]=$avai['tags'];
										}
										$str_tags=implode(",",$arrRestTags);
									}
									## AVG Count 
									$rating_avg_cnt=0;
									$rating_avg=$this->Homemodel->getRestAverageRating($intRstId);
									if(isset($rating_avg) && count($rating_avg)>0)
									{
										$rating_avg_cnt=round($rating_avg[0]['avg_ratings']);
									}
									# New Rest Flag
									$isNew=$this->Homemodel->checkRestaurntIsNew($intRstId);
									
									if(isset($isNew) && $isNew>0)
									{
										$isNew ="y";
									}
									else
									{
										$isNew ="n";
									}
									$time=0;
									$rstLat=$rst_lat;
									$rstLng=$rst_lng; 
									/*$resDistance=0;
									echo $rstLat;
									echo '<br/>'.$rstLng;
									echo '<br/>'.$userLat;
									echo '<br/>'.$userLong;
									
									if($rstLat!=0.00000000 && $rstLng!=0.00000000)
									{
										$resDistance=Calculatedistance($rstLat,$rstLng,$userLat,$userLong,'K');
									}*/
									$distance=$resDistance;
									$time =CalculateTime($distance); 
									/*code for getting top offer */
									$strTopCouponName ="";
									$offerrset=$this->Homemodel->checkTopOfferRest($intRstId,"");
									if(isset($offerrset) && count($offerrset)>0)
									{
										{
											$strTopCouponName =$offerrset[0]['offer_per']."% OFF";
										}
									}
									/* end of code for getting top offer*/
									
									/* how to get current time in php */
									$opening_flag=0;
									$current_time=date('H:i:s');
									$current_day=date('D');
									$opening_flag=$this->Homemodel->getRestuarntopeingtime($current_day,$current_time,$intRstId);
									//echo $this->db->last_query();echo '<br/>';
									/*end of current time in php */
									
									$arrRestCusines[] = array(
																"rst_id"=>$intRstId,
																"rst_profile_id"=>$intRstProfileId,
																"rst_name"=>$rst_name,
																"rst_tags"=>$str_tags,
																#"rst_tags"=>$rst_tags,
																"rst_avg_cost"=>$rst_avg_cost,
																"rst_image"=>$strRestImage,
																"rating"=>$rating_avg_cnt,
																"isnew"=>$isNew,
																"rstLat"=>$rstLat,
																"rst_opening_status"=>$rst_opening_status,
																"opening_flag"=>$opening_flag,
																"rstLng"=>$rstLng,
																"resDistance"=>$resDistance,
																"querydistance"=>$querydistance,
																"time"=>round($time),
																"rst_address"=>$rst_address,
																"rst_city"=>$rst_city,
																//"time"=>$time,
																"topcoupon"=>$strTopCouponName,
																"rst_availability"=>$arrGetRestaurantsDtls['rst_availability']
															 );
															$p++; 
								}
							}
						}
						$strCuisineImage = '';
						if($strCuisineImg!="")
						{
							$strCuisineImage=base_url()."uploads/cuisines/".$strCuisineImg;
						}
						#echo '<pre>';print_r($arrRestCusines);
						if($sort_by=='')
						{
							$this->sort_array_of_array($arrRestCusines, 'opening_flag');
						}
						
					#	echo '<pre>';print_r($arrRestCusines);exit;
						$arrDesCuisinesData[] = array( 
														"cuisine_id"=> $intCuisineId,
														"main_cat_id"=> $intCatId,
														"cuisine_title"=>$strCuisineTitle ,
														"cuisine_desc"=>$strCuisineDesc,													
														"cuisine_image"=>$strCuisineImage,
														"restaurantList"=>$arrRestCusines
													 );
						#echo "<pre>".$this->db->last_query();print_r($arrGetRestaurants);exit;					
					}
						
					$data['data'] = $arrDesCuisinesData;					
					#$data['banners'] = $arrDisBanners;
					$data['responsemessage'] = 'Listing of Cusines.';
					$data['responsecode'] = "200";
					$response_array=json_encode($data);
				}
				else
				{
					$num = array(
									'responsemessage' => 'No Restaurant/Stores Available',
									'responsecode' => "210"
								); //create an array
					$obj = (object)$num;//Creating Object from array
					$response_array=json_encode($obj);
				}	
				
			}
			else
			{
				$num = array(
								'responsemessage' => 'User details required',
								'responsecode' => "403"
							); //create an array
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
	
	
	### Home Click 3 restaurantdetails page ###
	public function restaurantdetails_post(){
		date_default_timezone_set(DEFAULT_TIME_ZONE);	
		$token 				= $this->input->post("token");
		$rst_id				= $this->input->post("rst_id");
		#$user_id			= $this->input->post("user_id");
		#$intCatId			= $this->input->post("category_id");
		$lng		 		= $this->input->post("lng");
		$userLat			= $this->input->post("userLat");
		$userLong			= $this->input->post("userLong");
		$pageid 			= $this->input->post("page_id");
		//$abc= $this->input->post("abc");

	
		if($token == TOKEN)
		{
			$arr_topmenus=array();$arr_Bestmenus=array();$arr_Othermenus=array();
			$user_id=0;
			if(isset($_POST['user_id']))
			{
				$user_id=$_POST['user_id'];
			}
			if($rst_id!="")
			{
				if($pageid > 1)
				{
					$offset = ($pageid-1) * 40; 	
					$offset +=6;
				}
				else if($pageid == 1)
				{
					$offset = 1 * 6; 	
				}
				else
				{
					$pageid =0;
					$offset = ($pageid) * 5; 
				}
			
						
				$arrRestDetails   = $this->Dashboardmodel->getRestaurantAllDetails($rst_id,$lng);
				//echo $this->db->last_query();exit;
				if(is_array($arrRestDetails) && count($arrRestDetails)> 0)
				{
					$arrMainCategories=array();
					$cntmainList=$this->Homemodel->getRestMainCategories($rst_id,0,$lng);
					//echo $this->db->last_query();exit;
					if($cntmainList>0)
					{
						$getcategories=$this->Homemodel->getRestMainCategories($rst_id,1,$lng);
						$arrMainCategories[]=array('category_id'=>0,
												'category_name'=>'All',
												'cat_image'=>base_url().'uploads/rst_cat_image/supermarket.png'
												);
												
						foreach($getcategories as $g)
						{
							$cat_image="";
							if($g['rst_cat_photo']!="")
							{
								$cat_image=base_url().'uploads/rst_cat_image/'.$g['rst_cat_photo'];
							}
							$arrMainCategories[]=array('category_id'=>$g['rst_cat_id'],
												'category_name'=>$g['rst_cat_name'],
												'cat_image'=>$cat_image
												);
						}
						$intCatId=$getcategories[0]['rst_cat_id'];
						$getMenus=$this->Dashboardmodel->getRestTopMenus_new($rst_id,$lng);
						// if($abc==1)
						// {
						// 	echo "<pre>".$this->db->last_query($getMenus); print_r($getMenus);
						// }	
						if(is_array($getMenus) && count($getMenus)> 0)
						{
							foreach($getMenus as $g)
							{
								$item_image='';
								if($g['menu_item_image']!="")
								{
									$item_image=base_url().'uploads/menu_items/'.$g['menu_item_image'];
								}
								else
									$item_image=base_url().'uploads/menu_items/menu_image_dummy.png';

								// tags for menus
								$arrTopTags=array();
								$str_Toptags='NA';
								$numTags=$this->Homemodel->getMenusAdditional($g['item_id'],'tags',0);
								if($numTags>0)
								{
									$resTags=$this->Homemodel->getMenusAdditional($g['item_id'],'tags',1);
									foreach($resTags as $res)
									{
										$arrTopTags[]=$res['detail_value'];
									}
									$str_Toptags=implode(",",$arrTopTags);
								}
								
								## user cart qty ##
								$product_qty=0;
								$details_id='';
								if($user_id>0)
								{
									$product_qty1=$this->Homemodel->getUsercartqty($user_id,$g['item_id']);
									if(isset($product_qty1) && count($product_qty1)>0)
									{
										$product_qty=$product_qty1[0]['quantity'];
										if($product_qty1[0]['detail_id']!="")
											$details_id=$product_qty1[0]['detail_id'];
									}
								}
								##echo $this->db->last_query();exit;
								## end of cart qty##
								
								##is fav ##
								$fav_flagg = "No";
								if($user_id>0)
								{
								$arrFav = $this->Favouritemodel->checkIsFavProd($g['item_id'],$user_id,1);
								#echo $this->db->last_query();
								if(isset($arrFav) && count($arrFav) > 0)
								$fav_flagg=$arrFav[0]['fav_flag'];
								}
								## end of is fav##
								
						
								$saving_price = $g['item_price'] - $g['selling_price'];

								$sel_price=getSellingPrice($rst_id,$g['item_price']);

								$arr_topmenus[]=array('menu_id'=>$g['item_id'],
														'item_title'=>$g['item_title'],
														'item_price'=>$g['item_price'],
														'selling_price'=>round($sel_price,2),//$g['selling_price'],
														'item_desc'=>$g['item_desc'],
														'saving_price'=>round($saving_price,2),
														'item_image'=>$item_image,
														'topTags'=>$str_Toptags,
														'qty'=>(int)$product_qty,
														'details_id'=>$details_id,
														'fav_flag'=>$fav_flagg
													 );
							}
						}
						$getBestMenus=$this->Dashboardmodel->getRestBestMenus_new($rst_id,$lng);
						#echo $this->db->last_query();exit;
						if(is_array($getBestMenus) && count($getBestMenus)> 0)
						{
							foreach($getBestMenus as $getBestMenusDtls)
							{
								if($getBestMenusDtls['menu_item_image']!="")
								{
									$item_image=base_url().'uploads/menu_items/'.$getBestMenusDtls['menu_item_image'];
								}
								else
									$item_image=base_url().'uploads/menu_items/menu_image_dummy.png';
								
								// tags for menus
								$arrBestTags=array();
								$str_Besttags='NA';
								$numTags=$this->Homemodel->getMenusAdditional($getBestMenusDtls['item_id'],'tags',0);
								if($numTags>0)
								{
									$resTags=$this->Homemodel->getMenusAdditional($getBestMenusDtls['item_id'],'tags',1);
									foreach($resTags as $res)
									{
										$arrBestTags[]=$res['detail_value'];
									}
									$str_Besttags=implode(",",$arrBestTags);
								}
								$saving_price = $getBestMenusDtls['item_price'] - $getBestMenusDtls['selling_price'];
								
								## user cart qty ##
								$product_qty=0;
								$details_id='';
								if($user_id>0)
								{
								$product_qty1=$this->Homemodel->getUsercartqty($user_id,$getBestMenusDtls['item_id']);
								if(isset($product_qty1) && count($product_qty1)>0)
								{
									$product_qty=$product_qty1[0]['quantity'];
									if($product_qty1[0]['detail_id']!="")
										$details_id=$product_qty1[0]['detail_id'];
								}
								}
								## end of cart qty##
								
								## voters count ##
								$voterscnt=0;
								$product_vote1=$this->Dashboardmodel->getvotercount($getBestMenusDtls['item_id'],$rst_id);
								if(isset($product_vote1) && count($product_vote1)>0)
								{
									$voterscnt=$product_vote1;
								}
								## end of voters count ##
								
								##is fav ##
								$fav_flagg = "No";
								if($user_id>0)
								{
								$arrFav = $this->Favouritemodel->checkIsFavProd($getBestMenusDtls['item_id'],$user_id,1);
								if(isset($arrFav) && count($arrFav) > 0)
								$fav_flagg=$arrFav[0]['fav_flag'];
								}
								## end of is fav##
								
								$sel_price2=getSellingPrice($rst_id,$getBestMenusDtls['item_price']);
								
								$arr_Bestmenus[]=array(
														'menu_id'=>$getBestMenusDtls['item_id'],
														'item_title'=>$getBestMenusDtls['item_title'],
														'item_price'=>$getBestMenusDtls['item_price'],
														'selling_price'=>round($sel_price2,2),//$getBestMenusDtls['selling_price'],
														'item_desc'=>$getBestMenusDtls['item_desc'],
														'saving_price'=>round($saving_price,2),
														'voterscnt'=>$voterscnt,
														'item_image'=>$item_image,
														'bestTags'=>$str_Besttags,
														'qty'=>(int)$product_qty,
														'details_id'=>$details_id,
														'fav_flag'=>$fav_flagg
													  );
							}
						}
						
						$numgetOtherMenus=$this->Dashboardmodel->getRestOtherMenus_new($rst_id,$lng,$pageid,$offset,0);
						
						$getOtherMenus=$this->Dashboardmodel->getRestOtherMenus_new($rst_id,$lng,$pageid,$offset,1);
						#echo $this->db->last_query();exit;
						if(is_array($getOtherMenus) && count($getOtherMenus)> 0)
						{
							foreach($getOtherMenus as $getOtherMenusDtls)
							{
								$item_image='';
								if($getOtherMenusDtls['menu_item_image']!="")
								{
									$item_image=base_url().'uploads/menu_items/'.$getOtherMenusDtls['menu_item_image'];
								}
								else
									$item_image=base_url().'uploads/menu_items/menu_image_dummy.png';
								// tags for menus
								$arrOtherTags=array();
								$str_Othertags='NA';
								$numTags=$this->Homemodel->getMenusAdditional($getOtherMenusDtls['item_id'],'tags',0);
								if($numTags>0)
								{
									$resTags=$this->Homemodel->getMenusAdditional($getOtherMenusDtls['item_id'],'tags',1);
									foreach($resTags as $res)
									{
										$arrOtherTags[]=$res['detail_value'];
									}
									$str_Othertags=implode(",",$arrOtherTags);
								}
								$saving_price = $getOtherMenusDtls['item_price'] - $getOtherMenusDtls['selling_price'];
								
								## user cart qty ##
								$product_qty=0;
								$details_id='';
								if($user_id>0)
								{
								$product_qty1=$this->Homemodel->getUsercartqty($user_id,$getOtherMenusDtls['item_id']);
								if(isset($product_qty1) && count($product_qty1)>0)
								{
									$product_qty=$product_qty1[0]['quantity'];
									if($product_qty1[0]['detail_id']!="")
										$details_id=$product_qty1[0]['detail_id'];
								}
								}
								## end of cart qty##
								
								## voters count ##
								$voterscnt=0;
								$product_vote1=$this->Dashboardmodel->getvotercount($getOtherMenusDtls['item_id'],$rst_id);
								if(isset($product_vote1) && count($product_vote1)>0)
								{
									$voterscnt=$product_vote1;
								}
								## end of voters count ##
								
								##is fav ##
								$fav_flagg = "No";
								if($user_id>0)
								{
								$arrFav = $this->Favouritemodel->checkIsFavProd($getOtherMenusDtls['item_id'],$user_id,1);
								if(isset($arrFav) && count($arrFav) > 0)
								$fav_flagg=$arrFav[0]['fav_flag'];
								}
								## end of is fav##

								$sel_price3=getSellingPrice($rst_id,$getOtherMenusDtls['item_price']);
								
								$arr_Othermenus[]=array(
														'menu_id'=>$getOtherMenusDtls['item_id'],
														'item_title'=>$getOtherMenusDtls['item_title'],
														'item_price'=>$getOtherMenusDtls['item_price'],
														'selling_price'=>round($sel_price3,2),//$getOtherMenusDtls['selling_price'],
														'saving_price'=>round($saving_price,2),
														'item_desc'=>$getOtherMenusDtls['item_desc'],
														'voterscnt'=>$voterscnt,
														'item_image'=>$item_image,
														'otherTags'=>$str_Othertags,
														'qty'=>(int)$product_qty,
														'details_id'=>$details_id,
														'numrecord'=>count($getOtherMenus),
														'fav_flag'=>$fav_flagg
													  );
							}
						}
						$rstLat=$arrRestDetails[0]['rst_lat'];
						$rstLng=$arrRestDetails[0]['rst_lng']; 
						$resDistance=0;
						if($rstLat!=0.00000000 && $rstLng!=0.00000000)
						{
							$resDistance=Calculatedistance($rstLat,$rstLng,$userLat,$userLong,'K');
						}

						$distance=$resDistance;
						$formated =CalculateTime($distance);
						if($this->input->post("print") == "1"){
								print "$rstLat => $rstLng <br> $userLat => $userLong <br> $distance => $formated <br> ";exit;
						}
						
						
						// check thers is any  order for this restaurant
						$is_food_ordered='No';
						if($user_id>0)
						{
						$checkIfIsOrder=$this->Homemodel->checkUserIsOrder($rst_id,$user_id);
						#echo $this->db->last_query(); exit;
						if($checkIfIsOrder>0)
							$is_food_ordered='Yes';
						}
						$percent_off='NA';

						$offerrset=$this->Homemodel->checkTopOfferRest($rst_id,"");
						if(isset($offerrset) && count($offerrset)>0)
						{
							if($offerrset[0]['offer_per']!=NULL)
									{
										$percent_off =$offerrset[0]['offer_per']."% OFF";
									}
						}
						$arrRestTags=array();
						$str_tags='';
						$numtagList=$this->Homemodel->getRestTags($rst_id,0);
						if($numtagList>0)
						{
							$str_tags = "";
							$arrRestTag = array();
							$tagList=$this->Homemodel->getRestTags($rst_id,1);
							foreach($tagList as $avai)
							{
								$arrRestTags[]=$avai['tags'];;
							}
							$str_tags=implode(',',$arrRestTags);
						}
						//list of ratings:
						$numratings=$this->Homemodel->getRestAllRatings($rst_id,1,0);
						$sumRatings=0;
						#echo $numratings;exit;
						if($numratings>0)
						{
							$getAllRatings=$this->Homemodel->getRestAllRatings($rst_id,1,1);
							#echo $this->db->last_query(); exit;
							if(isset($getAllRatings) && count($getAllRatings)>0)
							{
								foreach($getAllRatings as $g1)
								{
									$sumRatings +=$g1['ratings'];
								}
							}
						}
						#echo $sumRatings ;exit;
						$avage_ratings=0;
						$total_num_of_ratings=$this->Homemodel->getRestAllRatings($rst_id,0,0);
						if($sumRatings>0)
							$avage_ratings=round($sumRatings/$numratings);
						#echo $avage_ratings ;exit;
						
						#$avage_ratings=5;
						$total_5_ratingCount=$this->Homemodel->getRestRatingsCount($rst_id,5);
						$total_4_ratingCount=$this->Homemodel->getRestRatingsCount($rst_id,4);
						$total_3_ratingCount=$this->Homemodel->getRestRatingsCount($rst_id,3);
						$total_2_ratingCount=$this->Homemodel->getRestRatingsCount($rst_id,2);
						$total_1_ratingCount=$this->Homemodel->getRestRatingsCount($rst_id,1);
						
						//echo $this->db->last_query(); exit;
						
						/* how to get current time in php */
						$opening_flag=0;
						$closing_time='Na';
						$current_time=date('H:i:s');
						$current_day=date('D');
						$opening_flag=$this->Homemodel->getRestuarntopeingtime($current_day,$current_time,$rst_id);
						if($opening_flag==1)
						{
							$arr_closing_flag=$this->Homemodel->getRestuarntopeingtime1($current_day,$current_time,$rst_id);
							$closing_time=$arr_closing_flag[0]['to_time'];
						}
						//echo $this->db->last_query();echo '<br/>';
						/*end of current time in php */
						if($pageid > 0)
						{
							$arrMainCategories=[];
							$arr_topmenus=[];
							$arr_Bestmenus=[];
						}
								
						$arrRestInfo = array(
												"rst_id"=>$arrRestDetails[0]['rst_id'],
												"rst_name"=>$arrRestDetails[0]['rst_name'],
												"percent_off"=>$percent_off,
												"arrTags"=>$arrRestTags,
												"str_tags"=>$str_tags,
												"arrTopMenus"=>$arr_topmenus,
												"arrBestMenus"=>$arr_Bestmenus,
												"arrOtherMenus"=>$arr_Othermenus,
												"arrMainCategories"=>$arrMainCategories,
												"formated_time"=>round($formated),
												"resDistance"=>$resDistance,
												"TotalNumberOfRatings"=>$total_num_of_ratings,
												"AvergeRatings"=>round($avage_ratings,1),
												"is_food_ordered"=>$is_food_ordered,
												"total_5_ratingCount"=>round($total_5_ratingCount,1),
												"total_4_ratingCount"=>round($total_4_ratingCount,1),
												"total_3_ratingCount"=>round($total_3_ratingCount,1),
												"total_2_ratingCount"=>round($total_2_ratingCount,1), 
												"total_1_ratingCount"=>round($total_1_ratingCount,1),
												"opening_flag"=>$opening_flag,
												"closing_time"=>$closing_time,
												"dateadded"=>date('d-m-Y H:i:s',strtotime($arrRestDetails[0]['dateadded'])),
												"dateupdated"=>date('d-m-Y H:i:s',strtotime($arrRestDetails[0]['dateupdated'])),
												"numgetOtherMenus"=>$numgetOtherMenus
											);
						
						
						$data['data'] = $arrRestInfo;
						$data['responsemessage'] = 'Restaurant Next Details';
						$data['responsecode'] = "200";
						$response_array=json_encode($data);	
					}
								
				}
				else
				{
					$num = array(
									'responsemessage' => 'No Records Available',
									'responsecode' => "205"
								); //create an array
					$obj = (object)$num;//Creating Object from array
					$response_array=json_encode($obj);	
				}
			}
			else
			{
				$num = array(
								'responsemessage' => 'Restaurant Id required',
								'responsecode' => "403"
							); //create an array
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
	
	public function restaurantDetailsNext_post()
	{
		date_default_timezone_set(DEFAULT_TIME_ZONE);	
		$login_token 		= $this->input->post("login_token");
		$token 				= $this->input->post("token");
		$rst_id				= $this->input->post("rst_id");
		$user_id			= $this->input->post("user_id");
		$intCatId			= $this->input->post("category_id");
		$lng		 		= $this->input->post("lng");
		$pageid 			= $this->input->post("page_id");
		
		if($token == TOKEN)
		{
			if($rst_id!="" || $user_id!="" || $intCatId!="")
			{
				if($pageid > 0)
				{
					$offset = $pageid * 5; 	
				}
				else
				{
					$pageid =0;
					$offset = ($pageid) * 5; 
				}
				
				$cntRestaurantId   = $this->Homemodel->countRestaurant($rst_id,$lng);
				if($cntRestaurantId > 0)
				{
					$arrRestDetails   = $this->Homemodel->getRestaurantAllDetails($rst_id,1,$lng);
				
					// top recommandation menus
						$arr_topmenus=array(); 
						
						$numMenus=$this->Homemodel->getRestTopMenus_next($rst_id,$intCatId,0,$lng);
						
						if($numMenus>0)
						{
							$getMenus=$this->Homemodel->getRestTopMenus_next($rst_id,$intCatId,1,$lng);
							foreach($getMenus as $g)
							{
								$item_image='';
								if($g['menu_item_image']!="")
								{
									$item_image=base_url().'uploads/menu_items/'.$g['menu_item_image'];
								}
								else
									$item_image=base_url().'uploads/menu_items/menu_image_dummy.png';

								// tags for menus
								$arrTopTags=array();
								$str_Toptags='NA';
								$numTags=$this->Homemodel->getMenusAdditional($g['item_id'],'tags',0);
								if($numTags>0)
								{
									$resTags=$this->Homemodel->getMenusAdditional($g['item_id'],'tags',1);
									foreach($resTags as $res)
									{
										$arrTopTags[]=$res['detail_value'];
									}
									$str_Toptags=implode(",",$arrTopTags);
								}
								
								$isfav='No';
								$isFavexists=$this->Homemodel->checkitemis_fav($g['item_id'],$user_id,$rst_id);
								if($isFavexists>0)
								{
									$isfav='Yes';
								}
								
								$saving_price = $g['item_price'] - $g['selling_price'];
								$arr_topmenus[]=array('menu_id'=>$g['item_id'],
														'item_title'=>$g['item_title'],
														'item_price'=>$g['item_price'],
														'selling_price'=>round($g['selling_price'],2),
														'item_desc'=>$g['item_desc'],
														'saving_price'=>$saving_price,
														'item_image'=>$item_image,
														'topTags'=>$str_Toptags,
														'isfav'=>$isfav
													 );
							}
						}
						
						// Best seller menus
						$arr_Bestmenus=array();
						$numbestMenus=$this->Homemodel->getRestBestMenus_next($rst_id,$intCatId,0,$lng);
						
						if($numbestMenus>0)
						{
							$getBestMenus=$this->Homemodel->getRestBestMenus_next($rst_id,$intCatId,1,$lng);
							#echo $this->db->last_query(); exit;
							foreach($getBestMenus as $g1)
							{
								if($g1['menu_item_image']!="")
								{
									$item_image=base_url().'uploads/menu_items/'.$g1['menu_item_image'];
								}
								else
									$item_image=base_url().'uploads/menu_items/menu_image_dummy.png';
								
								// tags for menus
								$arrBestTags=array();
								$str_Besttags='NA';
								$numTags=$this->Homemodel->getMenusAdditional($g1['item_id'],'tags',0);
								if($numTags>0)
								{
									$resTags=$this->Homemodel->getMenusAdditional($g1['item_id'],'tags',1);
									foreach($resTags as $res)
									{
										$arrBestTags[]=$res['detail_value'];
									}
									$str_Besttags=implode($arrBestTags);
								}
								
								## user cart qty ##
								$product_qty=0;
								$details_id='';
								$product_qty1=$this->Homemodel->getUsercartqty($user_id,$g1['item_id']);
								if(isset($product_qty1) && count($product_qty1)>0)
								{
									$product_qty=$product_qty1[0]['quantity'];
									if($product_qty1[0]['detail_id']!="")
										$details_id=$product_qty1[0]['detail_id'];
								}
								## end of cart qty##
								
								## voters count ##
								$voterscnt=0;
								$product_vote1=$this->Dashboardmodel->getvotercount($g1['item_id'],$rst_id);
								if(isset($product_vote1) && count($product_vote1)>0)
								{
									$voterscnt=$product_vote1;
								}
								## end of voters count ##
								
								$isfav='No';
								$isFavexists=$this->Homemodel->checkitemis_fav($g1['item_id'],$user_id,$rst_id);
								if($isFavexists>0)
								{
									$isfav='Yes';
								}
								
								$saving_price = $g1['item_price'] - $g1['selling_price'];
								$arr_Bestmenus[]=array('menu_id'=>$g1['item_id'],
													'item_title'=>$g1['item_title'],
													'item_price'=>$g1['item_price'],
													'selling_price'=>round($g1['selling_price'],2),
													'item_desc'=>$g1['item_desc'],
													'saving_price'=>$saving_price,
													'voterscnt'=>$voterscnt,
													'item_image'=>$item_image,
													'bestTags'=>$str_Besttags,
													'qty'=>(int)$product_qty,
													'details_id'=>$details_id,
													'isfav'=>$isfav);
							}
						}
						/*if($numbestMenus>0)
						{
							$getBestMenus=$this->Homemodel->getRestBestMenus($rst_id,$intCatId,1,$lng);
							#echo $this->db->last_query(); exit;
							foreach($getBestMenus as $g1)
							{
								if($g1['menu_item_image']!="")
								{
									$item_image=base_url().'uploads/menu_items/'.$g1['menu_item_image'];
								}
								else
									$item_image=base_url().'uploads/menu_items/menu_image_dummy.png';
								
								// tags for menus
								$arrBestTags=array();
								$str_Besttags='NA';
								$numTags=$this->Homemodel->getMenusAdditional($g1['item_id'],'tags',0);
								if($numTags>0)
								{
									$resTags=$this->Homemodel->getMenusAdditional($g1['item_id'],'tags',1);
									foreach($resTags as $res)
									{
										$arrBestTags[]=$res['detail_value'];
									}
									$str_Besttags=implode($arrBestTags);
								}
								$saving_price = $g1['item_price'] - $g1['selling_price'];
								$arr_Bestmenus[]=array('menu_id'=>$g1['item_id'],
													'item_title'=>$g1['item_title'],
													'item_price'=>$g1['item_price'],
													'selling_price'=>$g1['selling_price'],
													'item_desc'=>$g1['item_desc'],
													'saving_price'=>$saving_price,
													'voterscnt'=>0,
													'item_image'=>$item_image,
													'bestTags'=>$str_Besttags);
							}
						}*/
						
						// other menus
						$arr_Othermenus=array();
						$numotherMenus=$this->Homemodel->getRestOtherMenus_next($rst_id,$intCatId,0,$lng,$pageid,$offset);
						
						if($numotherMenus>0)
						{
							$getOtherMenus=$this->Homemodel->getRestOtherMenus_next($rst_id,$intCatId,1,$lng,$pageid,$offset);
							#echo $this->db->last_query(); exit;
							foreach($getOtherMenus as $g1)
							{
								$item_image='';
								if($g1['menu_item_image']!="")
								{
									$item_image=base_url().'uploads/menu_items/'.$g1['menu_item_image'];
								}
								else
									$item_image=base_url().'uploads/menu_items/menu_image_dummy.png';
								// tags for menus
								$arrOtherTags=array();
								$str_Othertags='NA';
								$numTags=$this->Homemodel->getMenusAdditional($g1['item_id'],'tags',0);
								if($numTags>0)
								{
									$resTags=$this->Homemodel->getMenusAdditional($g1['item_id'],'tags',1);
									foreach($resTags as $res)
									{
										$arrOtherTags[]=$res['detail_value'];
									}
									$str_Othertags=implode($arrOtherTags);
								}
								
								## user cart qty ##
								$product_qty=0;
								$details_id='';
								$product_qty1=$this->Homemodel->getUsercartqty($user_id,$g1['item_id']);
								if(isset($product_qty1) && count($product_qty1)>0)
								{
									$product_qty=$product_qty1[0]['quantity'];
									if($product_qty1[0]['detail_id']!="")
										$details_id=$product_qty1[0]['detail_id'];
								}
								## end of cart qty##
								
								## voters count ##
								$voterscnt=0;
								$product_vote1=$this->Dashboardmodel->getvotercount($g1['item_id'],$rst_id);
								if(isset($product_vote1) && count($product_vote1)>0)
								{
									$voterscnt=$product_vote1;
								}
								## end of voters count ##
								
								$isfav='No';
								$isFavexists=$this->Homemodel->checkitemis_fav($g1['item_id'],$user_id,$rst_id);
								if($isFavexists>0)
								{
									$isfav='Yes';
								}
								
								$saving_price = $g1['item_price'] - $g1['selling_price'];
								$arr_Othermenus[]=array('menu_id'=>$g1['item_id'],
													'item_title'=>$g1['item_title'],
													'item_price'=>$g1['item_price'],
													'selling_price'=>round($g1['selling_price'],2),
													'saving_price'=>$saving_price,
													'item_desc'=>$g1['item_desc'],
													'voterscnt'=>$voterscnt,
													'item_image'=>$item_image,
													'otherTags'=>$str_Othertags,
													'qty'=>(int)$product_qty,
													'details_id'=>$details_id,
													'isfav'=>$isfav);
							}
						}
					
					#echo "<pre>";print_r($arr_Bestmenus);
					
					$arrRestInfo = array("rst_id"=>$arrRestDetails[0]['rst_id'],
											"rst_name"=>$arrRestDetails[0]['rst_name'],
											"arrTopMenus"=>$arr_topmenus,
											"arrBestMenus"=>$arr_Bestmenus,
											"arrOtherMenus"=>$arr_Othermenus,
											"dateadded"=>date('d-m-Y H:i:s',strtotime($arrRestDetails[0]['dateadded'])),
											"dateupdated"=>date('d-m-Y H:i:s',strtotime($arrRestDetails[0]['dateupdated']))
										   );
					
					
					$data['data'] = $arrRestInfo;
					$data['responsemessage'] = 'Restaurant Next Details';
					$data['responsecode'] = "200";
					$response_array=json_encode($data);
				
				}
				else
				{
					$num = array(
									'responsemessage' => 'No Records Available',
									'responsecode' => "205"
								); //create an array
					$obj = (object)$num;//Creating Object from array
					$response_array=json_encode($obj);	
				}
			}
			else
			{
				$num = array(
								'responsemessage' => 'category Id required',
								'responsecode' => "403"
							); //create an array
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
	
	
	public function viewMoreResturantDetails_post()
	{
		date_default_timezone_set(DEFAULT_TIME_ZONE);	
		$login_token 		= $this->input->post("login_token");
		$token 				= $this->input->post("token");
		$rst_id				= $this->input->post("rst_id");
		#$user_id			= $this->input->post("user_id");
		$intCatId			= $this->input->post("category_id");
		$lng		 		= $this->input->post("lng");
		$viewmore_type			= $this->input->post("viewmore_type");
		
		if($token == TOKEN)
		{
			$user_id=0;
			if(isset($_POST['user_id']))
			{
				$user_id=$_POST['user_id'];
			}
			if($rst_id!="" ||  $intCatId!="")
			{
				$cntRestaurantId   = $this->Homemodel->countRestaurant($rst_id,$lng);
				if($cntRestaurantId > 0)
				{
					$arrRestDetails   = $this->Homemodel->getRestaurantAllDetails($rst_id,1,$lng);
						
						if($viewmore_type=="topmenu")
						{
						// top recommandation menus
							$arr_topmenus=array(); 
							
							$numMenus=$this->Homemodel->getRestTopMenus_view($rst_id,$intCatId,0,$lng);
							
							if($numMenus>0)
							{
								$getMenus=$this->Homemodel->getRestTopMenus_view($rst_id,$intCatId,1,$lng);
								foreach($getMenus as $g)
								{
									$item_image='';
									if($g['menu_item_image']!="")
									{
										$item_image=base_url().'uploads/menu_items/'.$g['menu_item_image'];
									}
									else
										$item_image=base_url().'uploads/menu_items/menu_image_dummy.png';

									// tags for menus
									$arrTopTags=array();
									$str_Toptags='NA';
									$numTags=$this->Homemodel->getMenusAdditional($g['item_id'],'tags',0);
									if($numTags>0)
									{
										$resTags=$this->Homemodel->getMenusAdditional($g['item_id'],'tags',1);
										foreach($resTags as $res)
										{
											$arrTopTags[]=$res['detail_value'];
										}
										$str_Toptags=implode(",",$arrTopTags);
									}



									$sel_price=getSellingPrice($rst_id,$g['item_price']);

									$saving_price = $g['item_price'] - $sel_price;
									
									$isfav='No';
									if($user_id>0)
									{
								$isFavexists=$this->Homemodel->checkitemis_fav($g['item_id'],$user_id,$rst_id);
								if($isFavexists>0)
								{
									$isfav='Yes';
								}
									}
								## user cart qty ##
								$product_qty=0;
								$details_id='';
								if($user_id>0)
								{
								$product_qty1=$this->Homemodel->getUsercartqty($user_id,$g['item_id']);
								if(isset($product_qty1) && count($product_qty1)>0)
								{
									$product_qty=$product_qty1[0]['quantity'];
									if($product_qty1[0]['detail_id']!="")
										$details_id=$product_qty1[0]['detail_id'];
								}
								}
								## end of cart qty##
								
									$arr_topmenus[]=array('menu_id'=>$g['item_id'],
															'item_title'=>$g['item_title'],
															'item_price'=>$g['item_price'],
															'selling_price'=>round($sel_price,2),//$g['selling_price'],
															'item_desc'=>$g['item_desc'],
															'saving_price'=>$saving_price,
															'item_image'=>$item_image,
															'topTags'=>$str_Toptags,
															'qty'=>(int)$product_qty,
															'isfav'=>$isfav,
															'rst_id'=>$g['rst_id']
														 );
								}
							}
						
						}
						
						if($viewmore_type=="bestmenu")
						{
						// Best seller menus
						$arr_Bestmenus=array();
						$numbestMenus=$this->Homemodel->getRestBestMenus_view($rst_id,$intCatId,0,$lng);
						
						if($numbestMenus>0)
						{
							$getBestMenus=$this->Homemodel->getRestBestMenus_view($rst_id,$intCatId,1,$lng);
							#echo $this->db->last_query(); exit;
							foreach($getBestMenus as $g1)
							{
								if($g1['menu_item_image']!="")
								{
									$item_image=base_url().'uploads/menu_items/'.$g1['menu_item_image'];
								}
								else
									$item_image=base_url().'uploads/menu_items/menu_image_dummy.png';
								
								// tags for menus
								$arrBestTags=array();
								$str_Besttags='NA';
								$numTags=$this->Homemodel->getMenusAdditional($g1['item_id'],'tags',0);
								if($numTags>0)
								{
									$resTags=$this->Homemodel->getMenusAdditional($g1['item_id'],'tags',1);
									foreach($resTags as $res)
									{
										$arrBestTags[]=$res['detail_value'];
									}
									$str_Besttags=implode($arrBestTags);
								}
								
								## user cart qty ##
								$product_qty=0;
								$details_id='';
								if($user_id>0)
								{
								$product_qty1=$this->Homemodel->getUsercartqty($user_id,$g1['item_id']);
								if(isset($product_qty1) && count($product_qty1)>0)
								{
									$product_qty=$product_qty1[0]['quantity'];
									if($product_qty1[0]['detail_id']!="")
										$details_id=$product_qty1[0]['detail_id'];
								}
								}
								## end of cart qty##
								
								## voters count ##
								$voterscnt=0;
								$product_vote1=$this->Dashboardmodel->getvotercount($g1['item_id'],$rst_id);
								if(isset($product_vote1) && count($product_vote1)>0)
								{
									$voterscnt=$product_vote1;
								}
								## end of voters count ##
								$sel_price2=getSellingPrice($rst_id,$g1['item_price']);
								
								$saving_price = $g1['item_price'] - $sel_price;
								$isfav='No';
								if($user_id>0)
								{
								$isFavexists=$this->Homemodel->checkitemis_fav($g1['item_id'],$user_id,$rst_id);
								if($isFavexists>0)
								{
									$isfav='Yes';
								}
								}
								
								$arr_topmenus[]=array('menu_id'=>$g1['item_id'],
													'item_title'=>$g1['item_title'],
													'item_price'=>$g1['item_price'],
													'selling_price'=>round($sel_price2,2),//$g1['selling_price'],
													'item_desc'=>$g1['item_desc'],
													'saving_price'=>$saving_price,
													'voterscnt'=>$voterscnt,
													'item_image'=>$item_image,
													'topTags'=>$str_Besttags,
													'qty'=>(int)$product_qty,
													'details_id'=>$details_id,
													'isfav'=>$isfav,
													'rst_id'=>$g1['rst_id']);
							}
						}
						
					    }
					$arrRestInfo = array("rst_id"=>$arrRestDetails[0]['rst_id'],
											"rst_name"=>$arrRestDetails[0]['rst_name'],
											"arrMenus"=>$arr_topmenus,
											"dateadded"=>date('d-m-Y H:i:s',strtotime($arrRestDetails[0]['dateadded'])),
											"dateupdated"=>date('d-m-Y H:i:s',strtotime($arrRestDetails[0]['dateupdated']))
										   );
					
					
					$data['data'] = $arrRestInfo;
					$data['responsemessage'] = 'Restaurant Next Details';
					$data['responsecode'] = "200";
					$response_array=json_encode($data);
				
				}
				else
				{
					$num = array(
									'responsemessage' => 'No Records Available',
									'responsecode' => "205"
								); //create an array
					$obj = (object)$num;//Creating Object from array
					$response_array=json_encode($obj);	
				}
			}
			else
			{
				$num = array(
								'responsemessage' => 'category Id required',
								'responsecode' => "403"
							); //create an array
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
	
	
	
	public function reviewLists_post()
	{
		date_default_timezone_set(DEFAULT_TIME_ZONE);	
		$login_token 		= $this->input->post("login_token");
		$token 				= $this->input->post("token");
		$rst_id				= $this->input->post("rst_id");
		$user_id			= $this->input->post("user_id");
		
		if($token == TOKEN)
		{
			if($rst_id!="" || $user_id!="")
			{
				$numratings=$this->Homemodel->getRestAllRatings($rst_id,1,0);
				if($numratings > 0)
				{
					$arr_Ratinglist=array();
					$getAllRatings=$this->Homemodel->getRestAllRatings($rst_id,1,1);
						#echo $this->db->last_query(); exit;
					foreach($getAllRatings as $g1)
					{
						$fullname=$g1['fullname'];
						if($g1['fullname']=="")
							$fullname=$g1['profile_id'];
						$arr_Ratinglist[]=array('user_id'=>$g1['user_id'],
											'profile_id'=>$g1['profile_id'],
											'fullname'=>$fullname,
											'ratings'=>$g1['ratings'],
											'comments'=>$g1['comments'],
											'addedDate'=>date('d M Y',strtotime($g1['addedDate'])));
					}
					
					$data['data'] = $arr_Ratinglist;
					$data['responsemessage'] = 'Reviews List';
					$data['responsecode'] = "200";
					$response_array=json_encode($data);
				}
				else
				{
					$checkIsOrder=$this->Homemodel->checkUserIsOrder($rst_id,$user_id);
					$is_review='No';
					if($checkIsOrder)
						$is_review='Yes';
					
					$Isreview[]=array('is_review'=>$is_review);
					
					$data['data'] = $Isreview;
					$data['responsemessage'] = 'No Records Available';
					$data['responsecode'] = "205";
					$response_array=json_encode($data);
				}
			}
			else
			{
				$num = array(
								'responsemessage' => 'category Id required',
								'responsecode' => "403"
							); //create an array
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
	
	// code for menu details
		public function Customermenudetails_post()
		{
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$user_id		= $this->input->post("user_id");
			$token 		= $this->input->post("token");
			$item_id		= $this->input->post("item_id");
			$lng		 		= $this->input->post("lng");
			//print $lng;exit;
			if($token == TOKEN)
			{
				if($user_id == "")
				{
					$num = array(
								  'responsemessage' => 'Enter login details.',
								  'responsecode' => "403"
								); //create an array
					$obj = (object)$num;//Creating Object from array
					$response_array=json_encode($obj);
				}
				else
				{
					if($item_id=="")
					{
						$num = array(
								  'responsemessage' => 'Provide Menu ID',
								  'responsecode' => "404"
								); //create an array
						$obj = (object)$num;//Creating Object from array
						$response_array=json_encode($obj);
					}
					else
					{
						$numitem=$this->Homemodel->getMenuDetails($item_id,0,$lng);
						//echo $this->db->last_query();exit;
						if($numitem>0)
						{
							$resitem=$this->Homemodel->getMenuDetails($item_id,1,$lng);
							//print_r($resitem);exit;
							$cat_id=$resitem[0]['cat_id'];
							$cuisine_id=$resitem[0]['cuisine_id'];
							$menu_item_image=$resitem[0]['menu_item_image'];
							
							$cusinies_name=$category_name=$menu_image="";
							if($cat_id!=0)
							{
								$cat_details=$this->Homemodel->getCateDetails($cat_id);	
								$category_name=$cat_details[0]['category_name'];
							}
							
							if($cuisine_id!=0)
							{
								$cusinies_details=$this->Homemodel->getCusiniesDetails($cuisine_id,$lng);	
								//echo $this->db->last_query();exit;
								$cusinies_name=$cusinies_details[0]['cuisine_title'];
							}
							
							if($menu_item_image!="")
							{
								$menu_image=base_url().'uploads/menu_items/'.$menu_item_image;
							}
							
							// tags for menus
							$arrTags=array();
							$str_tags='';
							$numTags=$this->Homemodel->getMenusAdditional($item_id,'tags',0);
							if($numTags>0)
							{
								$resTags=$this->Homemodel->getMenusAdditional($item_id,'tags',1);
								foreach($resTags as $res)
								{
									$arrTags[]=$res['detail_value'];
								}
								$str_tags=implode(",",$arrTags);
							}
								
							$strAvailible='';
							$numavailibiltyList=$this->Homemodel->getMenusAdditional($item_id,'availability',0);
							if($numavailibiltyList>0)
							{
								$availibiltyList=$this->Homemodel->getMenusAdditional($item_id,'availability',1);
								foreach($availibiltyList as $avai)
								{
									$arrAvailible[]=$avai['detail_value'];
								}
								$strAvailible=implode(',',$arrAvailible);
							}
							
							//serving sizes
							$arrSizes=array();
							$numSizesList=$this->Homemodel->getMenusAdditional($item_id,'sizes',0);
							if($numSizesList>0)
							{
								$sizesList=$this->Homemodel->getMenusAdditional($item_id,'sizes',1);
								foreach($sizesList as $avai)
								{
									$is_select='No';
									$numItemCart=$this->Homemodel->checkAddonAddedInCart($user_id,$item_id,$avai['detail_id'],0);
									
									if($numItemCart>0)
									{
										$is_select='Yes';
									}
							
									$detail_image='';
									if($avai['detail_image']!="")
									{
										$detail_image=base_url().'uploads/item_detail_images/'.$avai['detail_image'];
									}
									$arrSizes[]=array('detail_id'=>$avai['detail_id'],
													  'detail_value'=>$avai['detail_value'],
													  'detail_price'=>$avai['detail_price'],
													  'detail_image'=>$detail_image,
													  'is_select'=>$is_select);
								}
							}
							
							//bread
							$arrBread=array();
							$numBreadList=$this->Homemodel->getMenusAdditional($item_id,'bread',0);
							if($numBreadList>0)
							{
								$BreadList=$this->Homemodel->getMenusAdditional($item_id,'bread',1);
								foreach($BreadList as $avai)
								{
									$is_select='No';
									$numItemCart=$this->Homemodel->checkAddonAddedInCart($user_id,$item_id,$avai['detail_id'],0);
									
									if($numItemCart>0)
									{
										$is_select='Yes';
									}
							
							
									$detail_image='';
									if($avai['detail_image']!="")
									{
										$detail_image=base_url().'uploads/item_detail_images/'.$avai['detail_image'];
									}
									$arrBread[]=array('detail_id'=>$avai['detail_id'],
													  'detail_value'=>$avai['detail_value'],
													  'detail_price'=>$avai['detail_price'],
													  'detail_image'=>$detail_image,
													    'is_select'=>$is_select);
								}
							}
							
							//fillings
							$arrFilling=array();
							$numFillingsList=$this->Homemodel->getMenusAdditional($item_id,'fillings',0);
							if($numFillingsList>0)
							{
								$fillingList=$this->Homemodel->getMenusAdditional($item_id,'fillings',1);
								foreach($fillingList as $avai)
								{
									$is_select='No';
									$numItemCart=$this->Homemodel->checkAddonAddedInCart($user_id,$item_id,$avai['detail_id'],0);
									
									if($numItemCart>0)
									{
										$is_select='Yes';
									}
							
							
									$detail_image='';
									if($avai['detail_image']!="")
									{
										$detail_image=base_url().'uploads/item_detail_images/'.$avai['detail_image'];
									}
									$arrFilling[]=array('detail_id'=>$avai['detail_id'],
													'detail_value'=>$avai['detail_value'],
													  'detail_price'=>$avai['detail_price'],
													  'detail_image'=>$detail_image,
													  'is_select'=>$is_select);
								}
							}
							
							//extra
							$arrExtra=array();
							$numExtrasList=$this->Homemodel->getMenusAdditional($item_id,'extra',0);
							if($numExtrasList>0)
							{
								$extraList=$this->Homemodel->getMenusAdditional($item_id,'extra',1);
								foreach($extraList as $avai)
								{
									$is_select='No';
									$numItemCart=$this->Homemodel->checkAddonAddedInCart($user_id,$item_id,$avai['detail_id'],0);
									
									if($numItemCart>0)
									{
										$is_select='Yes';
									}
									
							
									$detail_image='';
									if($avai['detail_image']!="")
									{
										$detail_image=base_url().'uploads/item_detail_images/'.$avai['detail_image'];
									}
									$arrExtra[]=array('detail_id'=>$avai['detail_id'],
													'detail_value'=>$avai['detail_value'],
													  'detail_price'=>$avai['detail_price'],
													  'detail_image'=>$detail_image,
													  'is_select'=>$is_select);
								}
							}
							
							// first check menu is added in cart or not?
							$itemqty=0;
							$numItemCart=$this->Homemodel->checkItemAddedInCart($user_id,$item_id,0);
							if($numItemCart>0)
							{
								$getItemCart=$this->Homemodel->checkItemAddedInCart($user_id,$item_id,1);
								$numItemCart=$getItemCart[0]['quantity'];
							}
							$itemqty=$numItemCart;
							
							$arrMenuDetails=array('item_title'=>$resitem[0]['item_title'],
												  'item_price'=>$resitem[0]['item_price'],
												  'selling_price'=>round($resitem[0]['selling_price'],2),
												  'cat_id'=>$category_name,
												  'cuisine_id'=>$cusinies_name,
												  'food_type'=>$resitem[0]['food_type'],
												  'is_veg'=>$resitem[0]['is_veg'],
												  'item_desc'=>$resitem[0]['item_desc'],
												  'menu_item_image'=>$menu_image,
												  'strAvailible'=>$strAvailible,
												  'str_tags'=>$str_tags,
												  'arrSizes'=>$arrSizes,
												  'arrBread'=>$arrBread,
												  'arrFilling'=>$arrFilling,
												  'arrExtra'=>$arrExtra,
												  'itemqty'=>$itemqty,
												'dateadded'=>date('d M Y',strtotime($resitem[0]['dateadded']))
												);
													  
							
							$data['menu_details'] = $arrMenuDetails;
							$data['responsemessage'] = 'Menu details.';
							$data['responsecode'] = "200";
							$response_array=json_encode($data);
						}
						else
						{
							$num = array(
								'responsemessage' => 'Error while getting menu details',
								'responsecode' => "202"
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
		
		public function getusercartitem_post()
		{
			date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$token 				= $this->input->post("token");
			$testcheck 				= $this->input->post("testcheck");
			if($token == TOKEN)
			{
				$user_id			= $this->input->post("user_id");
				
				if($user_id>0)
				{
					/* code for quantity in cart*/
					$usercartItem=$this->Homemodel->checkintemincart($user_id);
					// if($testcheck==1)
					// {
					// 	print_r($usercartItem);
					// exit;
					// }
					
					/* end of code for quantity in cart*/
					$data['usercartItem']=(int)$usercartItem;
					
					$data['responsemessage'] = 'number of cart items.';
					$data['responsecode'] = "200";
					$response_array=json_encode($data);
				}
				else
				{
					$num = array(
									'responsemessage' => 'User details required',
									'responsecode' => "403"
								); //create an array
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