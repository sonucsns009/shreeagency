<?php $sessiondata=$this->session->userdata('logged_in');
	#print_r($sessiondata);exit;
$session_user_type=$sessiondata['user_type'];
?>
<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-12">
					
				</div>
				
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->

	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-xl-3 xl-30">
				<div class="card o-hidden widget-cards">
					<div class="bg-warning card-body" >
						<div class="media static-top-widget row">
						
							<a <?php if($session_user_type=='Admin') {?>href="<?php echo base_url();?>backend/Users/manageUsers" target="_new" <?php } else { ?>href="javascript:void(0);"<?php } ?>>
							<div class="media-body col-12 de-icon">
								<div class="de-customer-icon">
									<img src="<?php echo base_url();?>template/admin/assets/images/dashboard/customer.svg" alt="">
								</div>
								<div>
									<span class="m-0" style="color: #ffffff;"><strong>TOTAL CUSTOMERS</strong></span>
								<h3 class="mb-0" ><span class="counter"><?php echo $totalCustomer;?></span></h3>
								</div>
								
							</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-xl-3 xl-30" >
				<div class="card o-hidden  widget-cards">
					<div class="bg-secondary card-body" >
						<div class="media static-top-widget row">
							<a <?php if($session_user_type=='Admin') {?> href="<?php echo base_url();?>backend/Merchant/manageMerchants" target="_new" <?php }  else { ?>href="javascript:void(0);"<?php } ?>>
							<div class="media-body col-12 de-icon">
								<div class="de-customer-icon">
									<img src="<?php echo base_url();?>template/admin/assets/images/dashboard/merchants.svg" alt="">
								</div>
								<div>
								<span class="m-0" style="color: #ffffff;">TOTAL MERCHANTS/ PARTNERS</span>
								<h3 class="mb-0"><span class="counter"><?php echo $totalRestauarant;?></span></h3>
								</div>
							</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-xl-3 xl-30">
				<div class="card o-hidden widget-cards">
					<div class="bg-primary card-body" >
						<div class="media static-top-widget row">
							<a <?php if($session_user_type=='Admin') {?> href="<?php echo base_url();?>backend/Orders/manageOrders" target="_new" <?php } else { ?>href="javascript:void(0);"<?php }?>>
							<div class="media-body col-12 de-icon">
								<div class="de-customer-icon">
									<img src="<?php echo base_url();?>template/admin/assets/images/dashboard/order.svg" alt="">
								</div>
								<div>
								<span class="m-0" style="color: #ffffff;">TOTAL ORDERS</span>
								<h3 class="mb-0"><span class="counter"><?php echo $totalOrders;?></span></h3>
								</div>
							</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-xl-3 xl-30" >
				<div class="card o-hidden widget-cards">
					<div class="bg-danger card-body"  >
						<div class="media static-top-widget row">
							
							<div class="media-body col-12 de-icon">
								<div class="de-customer-icon">
									<img src="<?php echo base_url();?>template/admin/assets/images/dashboard/revenue.svg" alt="">
								</div>
								<div>
								<span class="m-0">TOTAL REVENUE</span>
								<h3 class="mb-0">€ <span class="counter"><?php echo round($admintotalRevenus[0]['total_admin_commission'],2);?></span></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
		<div class="row">
			
			<div class="col-xl-6 xl-50">
				<div class="card">
					<div class="card-header">
						<h6 style="font-weight: 600;">LATEST CUSTOMERS</h6>
						
					</div>
					<div class="card-body">
					<?PHP if(isset($getLatestCustomers) && count($getLatestCustomers)>0)
					{ ?>
						<div class="user-status table-responsive latest-order-table">
							<table class="table table-bordernone table-striped">
								
								<tbody>
								<?php $i=1;
								foreach($getLatestCustomers as $g) {?>
								<tr>
									<td style="border-top:0px;">#<?php echo $i;?></td>
									<td class="digits" style="border-top:0px;"><?php echo $g['profile_id'];?></td>
									<td class="digits" style="border-top:0px;"><?php if($g['fullname']!="") { echo ucfirst($g['fullname']);} else { echo '-';}?></td>
									
									<td class="digits" style="border-top:0px;"><?php echo $g['country_code']." ".$g['mobilenumber'];?></td>
									
								</tr>
								<?php $i++;} ?>
								</tbody>
							</table>
							
						</div>
						<?PHP } else { ?>
						<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No records  found.
								</div>									
								<?php }?>
					</div>
				</div>
			</div>
			
			<div class="col-xl-6 xl-50">
				<div class="card">
					<div class="card-header">
						<h6 style="font-weight: 600;">TOP MERCHANT</h6>
					</div>
					<div class="card-body">
					<?php 
					if(isset($getTopStores) && count($getTopStores)>0)
					{
						foreach($getTopStores as $g) {?>
						<div class="row">
                                    <div class="col-6">
                                       MERCHANT NAME
                                    </div>
                                    <div class="col-6">
                                      <?php echo $g['rst_name'];?>
                                    </div>
                                </div>
						<div class="row">
                                    <div class="col-6">
                                       CONTACT 
                                    </div>
                                    <div class="col-6">
                                       <?php echo $g['rst_countrycode']."".$g['rst_contact_no'];?>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-6">
                                      <?php echo $g['rst_email'];?>
                                    </div>
                                    <div class="col-6">
									<?php if($session_user_type=='Admin') {?>
                                    <a href="<?php echo base_url();?>backend/Merchant/viewMerchant/<?php echo base64_encode($g['rst_id']);?>" class="btn btn-primary" target="_new">VIEW DETAILS</a>
									<?php } ?>
                                    </div>
                                </div>
								
								<hr/>
								
					<?php } 
					} else { ?>
					<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No records  found.
								</div>									
								<?php }?>	
					</div>
				</div>
			</div>
			
			<!--<div class="col-xl-6 xl-50">
				<div class="card">
					<div class="card-header">
						<h6 style="font-weight: 600;">REVENUE BY STRIPE</h6>
						
					</div>
					<div class="card-body">
					<?PHP 
					//print_r($getlastorders);exit;
					if(isset($getrevene_card) && count($getrevene_card)>0)
					{ ?>
						<div class="user-status table-responsive latest-order-table">
							<table class="table table-bordernone">
								
								<tbody>
								<?php $k=1;
								foreach($getrevene_card as $g) 
								{
									$strProduct ='';$i=1;$strcustt ='';
									$arrproduct_name=$this->Dashboard_model->getProducthistory($g['order_id']);	
									foreach($arrproduct_name as $arr)
									{
										
										$strProduct .=$i.")". $arr['item_title']."<br/>";
										$i++;
									}
									
									$arrcust_name=$this->Dashboard_model->getCustomerName($g['user_id']);
									foreach($arrcust_name as $arr)
									{
										$strcustt =$arr['fullname'];
									}
									?>
								<tr>
									<td style="border-top:0px;">#<?php echo $k;?></td>
									<td class="digits" style="border-top:0px;"><?php echo $g['order_no'];?></td>
							<td class="digits" style="border-top:0px;max-height:15px;scroll:auto;"><?php //echo $strProduct;?></td>
									<td class="font-danger" style="border-top:0px;"><?php echo $strcustt;?></td>
									<td class="font-danger" style="border-top:0px;"><?php echo  date('d M Y',strtotime($g['order_date']));?></td>
									<td class="font-danger" style="border-top:0px;"><a href="<?php echo base_url();?>backend/Orders/vieworder/<?php echo base64_encode($g['order_id']);?>">View</a></td>
								</tr>
								<?php $k++;} ?>
								</tbody>
							</table>
							
						</div>
						<?PHP } else { ?>
						<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No records  found.
								</div>									
								<?php }?>	
					</div>
				</div>
			</div>
			<div class="col-xl-6 xl-50">
				<div class="card">
					<div class="card-header">
						<h6 style="font-weight: 600;">REVENUE BY CASH</h6>
						
					</div>
					<div class="card-body">
					<?PHP 
					//print_r($getlastorders);exit;
					if(isset($getrevene_cash) && count($getrevene_cash)>0)
					{ ?>
						<div class="user-status table-responsive latest-order-table">
							<table class="table table-bordernone">
								
								<tbody>
								<?php $k=1;
								foreach($getrevene_cash as $g) 
								{
									$strProduct ='';$i=1;$strcustt ='';
									$arrproduct_name=$this->Dashboard_model->getProducthistory($g['order_id']);	
									foreach($arrproduct_name as $arr)
									{
										
										$strProduct .=$i.")". $arr['item_title']."<br/>";
										$i++;
									}
									
									$arrcust_name=$this->Dashboard_model->getCustomerName($g['customer_id']);
									foreach($arrcust_name as $arr)
									{
										$strcustt =$arr['fullname'];
									}
									?>
								<tr>
									<td style="border-top:0px;">#<?php echo $k;?></td>
									<td class="digits" style="border-top:0px;"><?php echo $g['order_no'];?></td>
									<td class="digits" style="border-top:0px;max-height:15px;scroll:auto;"><?php //echo $strProduct;?></td>
									<td class="font-danger" style="border-top:0px;"><?php echo $strcustt;?></td>
									<td class="font-danger" style="border-top:0px;"><?php echo  date('d M Y',strtotime($g['order_date']));?></td>
									<td class="font-danger" style="border-top:0px;"><a href="<?php echo base_url();?>backend/Orders/vieworder/<?php echo base64_encode($g['order_id']);?>">View</a></td>
								</tr>
								<?php $k++;} ?>
								</tbody>
							</table>
							
						</div>
						<?PHP } else { ?>
						<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No records  found.
								</div>									
								<?php }?>
					</div>
				</div>
			</div>-->
			
			
			<div class="col-xl-6 xl-50">
				<div class="card">
					<div class="card-header">
						<h6 style="font-weight: 600;">TOP DRIVER</h6>
						
					</div>
					<div class="card-body">
					<?PHP 
					//print_r($getlastorders);exit;
					if(isset($topdrivers) && count($topdrivers)>0)
					{ ?>
						<div class="user-status table-responsive latest-order-table">
							<table class="table table-bordernone table-striped">
								
								<tbody>
								<?php $k=1;
								foreach($topdrivers as $g) 
								{
									$str_driver_photo='-';
									if($g['driver_photo']!="")
									{
										$str_driver_photo=base_url().'uploads/fbdrivers/'.$g['driver_photo'];
									}
									
									?>
								<tr>
									<td style="border-top:0px;">#<?php echo $k;?></td>
									<td class="digits" style="border-top:0px;"><?php echo $g['driver_name'];?></td>
									<td class="font-danger" style="border-top:0px;"><?php echo $g['driver_countrycode'].$g['driver_mobile'];?></td>
									<td class="digits" style="border-top:0px;">€ <?php echo $g['total_comm'];?></td>
									<?php if($session_user_type=='Admin') {?>
									<td class="font-danger" style="border-top:0px;"><a href="<?php echo base_url();?>backend/Driver/viewcommission/<?php echo base64_encode($g['driver_id']);?>">View</a></td>
									<?php } ?>
								</tr>
								<?php $k++;} ?>
								</tbody>
							</table>
							
						</div>
						<?PHP } else { ?>
						<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No records  found.
								</div>									
								<?php }?>	
					</div>
				</div>
			</div>
			<div class="col-xl-6 xl-50">
				<div class="card">
					<div class="card-header">
						<h6 style="font-weight: 600;">MOST ORDER MENU</h6>
						
					</div>
					<div class="card-body">
					<?PHP 
					//print_r($getlastorders);exit;
					if(isset($topMENUS) && count($topMENUS)>0)
					{ ?>
						<div class="user-status table-responsive latest-order-table">
							<table class="table table-bordernone table-striped">
								
								<tbody>
								<?php $k=1;
								foreach($topMENUS as $g) 
								{
									$strimage='-';
									if($g['menu_item_image']!='')
									{
										$strimage='<img src='.base_url().'uploads/menu_items/'.$g['menu_item_image'].' width="40px"/>';
									}
									?>
								<tr>
									<td style="border-top:0px;">#<?php echo $k;?></td>
									<td class="digits" style="border-top:0px;"><?php echo $strimage;?></td>
									<td class="font-danger" style="border-top:0px;"><?php echo  $g['rst_name'];?></td>
									<td class="font-danger" style="border-top:0px;"><?php echo $g['item_title'];?></td>
									<td class="font-danger" style="border-top:0px;">€ <?php echo $g['selling_price'];?></td>
								</tr>
								<?php $k++;} ?>
								</tbody>
							</table>
							
						</div>
						<?PHP } else { ?>
						<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No records  found.
								</div>									
								<?php }?>
					</div>
				</div>
			</div>
			

		</div>
	</div>
	<!-- Container-fluid Ends-->

</div>