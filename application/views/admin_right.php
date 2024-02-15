<!-- Page Sidebar Start-->
 <?php //$sessiondata=$this->session->userdata('logged_in');
// 	#print_r($sessiondata);exit;
// $session_admin_id=$sessiondata['admin_id']; 
// $session_admin_name=$sessiondata['admin_name'];
// $session_user_type=$sessiondata['user_type'];
// $session_subroles=$sessiondata['subroles'];

// //if($session_user_type=="Subadmin" && $session_subroles!="NULL")
// {
// 	$modulesId=$this->Admin_model->getmodulelist($session_subroles);
// }
#echo $this->db->last_query();
 #echo '<pre>';print_r($modulesId);exit;
?>

        <div class="page-sidebar" style="width:270px;">
            <div class="main-header-left d-none d-lg-block" style="background-color: #dddddd;border: solid #75299d 5px;">
                <div class="logo-wrapper" style="padding: 5px; font-size:x-large; font-weight: bold;">
                	Shree Agency
                </div>
            </div>
            <div class="sidebar custom-scrollbar">
               
                <ul class="sidebar-menu">
                   
					 <li <?php if($this->router->fetch_class()=='Dashboard'){?> style="background-color: rgb(255, 97, 97);"
					<?php } ?> class="<?php if($this->router->fetch_method()=='index'){?>nav-expanded nav-active <?php }?>"<?php if(isset($modulesId)&& count($modulesId)>0)
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
						<a class="sidebar-header" href="<?php echo base_url();?>Dashboard/index"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/dashboard.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span <?php if($this->router->fetch_class()=='Dashboard'){?>style="color: #fff;"<?php }?>>DASHBOARD</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_class()=='Brands'){?> style="background-color: rgb(255, 97, 97);"
					<?php } ?> class="<?php if($this->router->fetch_method()=='index'){?>nav-expanded nav-active <?php }?>"<?php if(isset($modulesId)&& count($modulesId)>0)
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
						<a class="sidebar-header" href="<?php echo base_url();?>Brands/index"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/category.png"?>" style="max-height: 30px;max-width: 30px;">  &nbsp;&nbsp;<span <?php if($this->router->fetch_class()=='Brands'){?>style="color: #fff;"<?php }?>>BRANDS</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_class()=='Categories'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='index'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
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
						<a class="sidebar-header" href="<?php echo base_url();?>Categories/index"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/category.png"?>" style="max-height: 25px;max-width: 25px;">  &nbsp;&nbsp;<span>CATEGORIES</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_class()=='Units'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='index'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
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
						<a class="sidebar-header" href="<?php echo base_url();?>Units/index"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/category.png"?>" style="max-height: 25px;max-width: 25px;">  &nbsp;&nbsp;<span>UNITS</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_class()=='Products'){?> style="background-color: rgb(255, 97, 97);" <?php }?>class="nav-parent <?php /*if($this->router->fetch_method()=='manageMerchants' || $this->router->fetch_method()=='viewMerchantReviews' || $this->router->fetch_method()=='managestoreCategory' || $this->router->fetch_method()=='managestoreProduct'){ */
					?>nav-expanded<?php // } ?>" <?php if(isset($modulesId)&& count($modulesId)>0)
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
				  ?>><a class="sidebar-header" href="javascript:void(0);" style="color: #fff;"><i data-feather="box"></i> <span>PRODUCTS</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
            
							<li><a class="sidebar-header" href="<?php echo base_url();?>Products" style="color: #fff;"><i data-feather="grid"></i><span>Manage Products</span></a></li>
							
								
							<li><a class="sidebar-header" href="<?php echo base_url();?>Products/import" style="color: #fff;"><i data-feather="star"></i><span>Import Products</span></a></li>
							
							<!--<li><a class="sidebar-header" href="<?php //echo base_url();?>backend/Storecategory/managestoreCategory" style="color: #fff;"><i data-feather="star"></i><span>Export Products</span></a></li>-->
							
                        </ul>
                    </li>
					
					<li <?php if($this->router->fetch_class()=='Transport'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='index'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
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
						<a class="sidebar-header" href="<?php echo base_url();?>Transport/index"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/Driver.png"?>" style="max-height: 25px;max-width: 25px;">  &nbsp;&nbsp;<span>TRANSPORT</span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_class()=='Suppliers'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='index'){?>nav-expanded nav-active <?php } ?>" <?php if(isset($modulesId)&& count($modulesId)>0)
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
						<a class="sidebar-header" href="<?php echo base_url();?>Suppliers/index"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/manager.png"?>" style="max-height: 25px;max-width: 25px;">  &nbsp;&nbsp;<span>SUPPLIERS</span></a>                        
					</li>
					
					<li class="nav-parent <?php if($this->router->fetch_class()=='Users' || $this->router->fetch_class()=='Roles'){ 
					?>nav-expanded<?php } ?>" <?php if(isset($modulesId)&& count($modulesId)>0)
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
				  ?>><a class="sidebar-header" href="javascript:void(0);" <?php if($this->router->fetch_class()=='Users'){?>style="background-color: rgb(255, 97, 97);"<?php }?>><i data-feather="box"></i> <span>USERS</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
            
							<li><a class="sidebar-header" href="<?php echo base_url();?>Users" style="color: #fff;"><i data-feather="grid"></i><span>Manage Users</span></a></li>
							
								
							<li><a class="sidebar-header" href="<?php echo base_url();?>Roles" style="color: #fff;"><i data-feather="star"></i><span>Manage Roles</span></a></li>
							
                        </ul>
                    </li>
					
					<li><a class="sidebar-header" href="<?php echo base_url();?>Login/logout"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/exit.png"?>" style="max-height: 25px;max-width: 25px;">  &nbsp;&nbsp;<span>LOGOUT</span></a>
                    </li>	
                 </ul>
            </div>
        </div>

        <!-- Page Sidebar Ends-->

        
