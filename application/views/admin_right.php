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
                <div class="logo-wrapper" style="padding: 5px;">
                	
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
					
					<li <?php if($this->router->fetch_class()=='Products'){?>style="background-color: rgb(255, 97, 97);"<?php }?>class=" <?php if($this->router->fetch_method()=='index'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
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
						<a class="sidebar-header" href="<?php echo base_url();?>Products/index"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/products.png"?>" style="max-height: 25px;max-width: 25px;">  &nbsp;&nbsp;<span>PRODUCTS</span></a>                        
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
					
					<li><a class="sidebar-header" href="<?php echo base_url();?>Login/logout"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/exit.png"?>" style="max-height: 25px;max-width: 25px;">  &nbsp;&nbsp;<span>LOGOUT</span></a>
                    </li>	
                 </ul>
            </div>
        </div>

        <!-- Page Sidebar Ends-->

        
