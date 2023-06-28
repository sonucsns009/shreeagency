<!-- Page Sidebar Start-->
<?php $sessiondata=$this->session->userdata('logged_in');
	#print_r($sessiondata);exit;
$session_admin_id=$sessiondata['admin_id']; 
$session_admin_name=$sessiondata['admin_name'];
$session_user_type=$sessiondata['user_type'];
$session_subroles=$sessiondata['subroles'];

//if($session_user_type=="Subadmin" && $session_subroles!="NULL")
{
	$modulesId=$this->Admin_model->getmodulelist($session_subroles);
}
//echo $this->db->last_query();
// echo '<pre>';print_r($modulesId);exit;
?>

        <div class="page-sidebar" style="width:270px;">
            <div class="main-header-left d-none d-lg-block">
                <div class="logo-wrapper"><a href="<?php echo base_url();?>backend/dashboard"><img class="blur-up lazyloaded" src="<?php echo base_url('template/admin/');?>assets/images/dashboard/deseos-white-logo.png" alt="Deseos logo"></a></div>
            </div>
            <div class="sidebar custom-scrollbar">
               
                <ul class="sidebar-menu">
                   
					 <li <?php if($this->router->fetch_class()=='dashboard'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class="  <?php if($this->router->fetch_method()=='dashboard'){?>nav-expanded nav-active <?php }?>" <?php //if(isset($modulesId)&& count($modulesId)>0)
							//{ 
								// if ($modulesId[0]['view'] == 'Yes') 
								// { 
								// 	echo 'style="display:block;"';
							    // } 
								// else 
								// { 
									echo 'style="display:block;"'; 
								//}
							//}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>dashboard"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/dashboard.png"?>" style="max-height: 30px;max-width: 30px;"> &nbsp;&nbsp;<span>DASHBOARD</span></a>                        
					</li>
					<!--<li class=" <?php if($this->router->fetch_method()=='manageUsers'){?>nav-expanded nav-active <?php }?>">
						<a class="sidebar-header" href="<?php //echo base_url("backend/");?>dashboard"><i data-feather="file-text"></i><span>ANALYTICS & REPORTS</span></a>                        
					</li>-->
					<li  <?php if($this->router->fetch_class()=='Category'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageCategory'){?>nav-expanded nav-active <?php }?>"<?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Category/manageCategory"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/categories.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>CATEGORY</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_class()=='Users' || $this->router->fetch_class()=='users'){?>style="background-color: rgb(255, 97, 97);"<?php }?> class=" <?php if($this->router->fetch_method()=='manageUsers'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[2]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Users/manageUsers"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/value.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>CUSTOMER</span></a>                        
					</li>
					
					<li  <?php if($this->router->fetch_class()=='Merchant'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageMerchants' || $this->router->fetch_method()=='viewMerchantReviews'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[3]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Merchant/manageMerchants"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/merchant.png"?>" style="max-height: 30px;max-width: 30px;">   &nbsp;&nbsp;<span>MERCHANTS</span></a>                        
					</li>
					
					<li  <?php if($this->router->fetch_class()=='Products'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageProductsCsv'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[22]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Products/manageProductsCsv"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/products.png"?>" style="max-height: 30px;max-width: 30px;">   &nbsp;&nbsp;<span>PRODUCTS</span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Orders' && $this->router->fetch_method()=='manageOrdersCommission'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageOrdersCommission'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[0]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Orders/manageOrdersCommission"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/commission.png"?>" style="max-height: 30px;max-width: 30px;">   &nbsp;&nbsp;<span>COMMISSION</span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Partner'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='managePartners' || $this->router->fetch_method()=='viewPartner'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[18]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Partner/managePartners"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/hand-shake.png"?>" style="max-height: 30px;max-width: 30px;">   &nbsp;&nbsp;<span>PARTNER EXP</span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Hotdeals'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageHotdeals' || $this->router->fetch_method()=='viewHotdeals'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[17]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Hotdeals/manageHotdeals"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/hot-deal.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>EXPERIENCES</span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Hotdealorders' && $this->router->fetch_method()=='manageHotdealorders' || $this->router->fetch_method()=='viewhotdealOrders'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageHotdealorders' || $this->router->fetch_method()=='viewhotdealOrders'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[25]['view'] == 'Yes' || $modulesId[17]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Hotdealorders/manageHotdealorders"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/Orders.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>HOTDEAL ORDERS</span></a>                        
					</li>
					
					<li  <?php if($this->router->fetch_class()=='Orders' && $this->router->fetch_method()=='manageOrders' || $this->router->fetch_method()=='viewmanageOrders'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageOrders' || $this->router->fetch_method()=='viewmanageOrders'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[4]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Orders/manageOrders"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/Orders.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>ORDERS</span></a>                        
					</li>

					<li  <?php if($this->router->fetch_class()=='Cuisine'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageCuisines'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[5]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Cuisine/manageCuisines"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/category.png"?>" style="max-height: 25px;max-width: 25px;">  &nbsp;&nbsp;<span>SUB CATEGORY</span></a>                        
					</li>
					<!--<li class=" <?php if($this->router->fetch_method()=='manageCuisines'){?>nav-expanded nav-active <?php }?>">
						<a class="sidebar-header" href="#"><i data-feather="tag"></i> <span>OFFERS</span></a>                        
					</li>-->
					<li <?php if($this->router->fetch_class()=='Settings'){?>style="background-color: rgb(255, 97, 97);"<?php }?> class=" <?php if($this->router->fetch_method()=='manageadminsetting'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[6]['view'] == 'Yes')  
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/Settings/manageadminsetting"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/Admin settings.png"?>" style="max-height: 30px;max-width: 30px;">   &nbsp;&nbsp;<span>ADMIN SETTINGS</span></a>                        
					</li>
					
					
					
					<li <?php if($this->router->fetch_class()=='Delivery'){?>style="background-color: rgb(255, 97, 97);"<?php }?> class=" <?php if($this->router->fetch_method()=='managedelivery'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[10]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/Delivery/managedelivery"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/Delivery Settings.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>DELIVERY SETTINGS</span></a>                        
					</li>
					
					
					<li <?php if($this->router->fetch_class()=='Driver'){?>style="background-color: rgb(255, 97, 97);"<?php }?>  class=" <?php if($this->router->fetch_method()=='managedriver'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[11]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/Driver/managedriver"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/Driver.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>DRIVER</span></a>                        
					</li>
					
					
					<li <?php if($this->router->fetch_class()=='Driverpayment'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='managedriverpayment'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[12]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/Driverpayment/managedriverpayment"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/Driver payment.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>DRIVER PAYMENT</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_class()=='Notification'){?>style="background-color: rgb(255, 97, 97);"<?php }?>  class=" <?php if($this->router->fetch_method()=='manageNotfication'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[7]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/Notification/manageNotfication"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/notification.png"?>" style="max-height: 30px;max-width: 30px;">   &nbsp;&nbsp;<span>NOTIFICATIONS</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_method()=='manageTransactions'){?>style="background-color: rgb(255, 97, 97);"<?php }?> class=" <?php if($this->router->fetch_method()=='manageTransactions'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[8]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Orders/manageTransactions"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/transaction.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>TRANSACTION HISTORY</span></a>                        
					</li>

					<li <?php if($this->router->fetch_method()=='manageHotdealTransactions'){?>style="background-color: rgb(255, 97, 97);"<?php }?> class=" <?php if($this->router->fetch_method()=='manageHotdealTransactions'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[23]['view'] == 'Yes' || $modulesId[8]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Hotdealorders/manageHotdealTransactions"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/transaction.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>HOT DEAL TRANSACTION HISTORY</span></a>                        
					</li>
					<li <?php if($this->router->fetch_method()=='manageHotdealsquestions'){?>style="background-color: rgb(255, 97, 97);"<?php }?> class=" <?php if($this->router->fetch_method()=='manageHotdealsquestions'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[24]['view'] == 'Yes' || $modulesId[8]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Hotdealquestion/manageHotdealsquestions"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/transaction.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>HOT DEAL QUESTIONS</span></a>                        
					</li>
					
					
					<li <?php if($this->router->fetch_class()=='Subadmin'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='managesubadmin'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[13]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/Subadmin/managesubadmin"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/manager.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>SUBADMIN</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_class()=='Roles'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageroles'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[14]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/Roles/manageroles"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/roles.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>ROLES</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_class()=='Driverview'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='managedriverview'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[9]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/Driverview/managedriverview"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/god.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span>GODS VIEW</span></a>                        
					</li>


					<li <?php if($this->router->fetch_class()=='CMS'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='managecms'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[15]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/CMS/managecms"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/cms.png"?>" style="max-height: 30px;max-width: 30px;">   &nbsp;&nbsp;<span>MANAGE CMS</span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Cancelreason'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='managecancel'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[16]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/Cancelreason/managecancel"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/cancel.png"?>" style="max-height: 25px;max-width: 25px;">  &nbsp;&nbsp;<span>CANCEL REASON</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_method()=='managerestenquiry'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='managerestenquiry'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[19]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/Enquiry/managerestenquiry"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/preview.png"?>" style="max-height: 30px;max-width: 30px;">   &nbsp;&nbsp;<span>RESTAURANT ENQUIRY</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_method()=='managedelenquiry'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='managedelenquiry'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[20]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/Enquiry/managedelenquiry"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/support.png"?>" style="max-height: 30px;max-width: 30px;">   &nbsp;&nbsp;<span>DELIVERY ENQUIRY</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_class()=='Banner'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageBanners'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[21]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url();?>backend/Banner/manageBanners"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/Banners .png"?>" style="max-height: 25px;max-width: 25px;">  &nbsp;&nbsp;<span>BANNERS</span></a>                        
					</li>
					
					
					<li><a class="sidebar-header" href="<?php echo base_url();?>backend/Login/logout"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/exit.png"?>" style="max-height: 25px;max-width: 25px;">  &nbsp;&nbsp;<span>LOGOUT</span></a>
                    </li>	
                 </ul>
            </div>
        </div>

        <!-- Page Sidebar Ends-->

        
