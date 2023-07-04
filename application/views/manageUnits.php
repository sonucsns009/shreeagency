<?php /*$sessiondata=$this->session->userdata('logged_in');
	#print_r($sessiondata);exit;
$session_admin_id=$sessiondata['admin_id']; 
$session_admin_name=$sessiondata['admin_name'];
$session_user_type=$sessiondata['user_type'];
$session_subroles=$sessiondata['subroles'];

if($session_user_type=="Subadmin" && $session_subroles!="NULL")
{
	$modulesId=$this->Admin_model->getmodulelist($session_subroles);
} 
*/
#echo $this->db->last_query();
 #echo '<pre>';print_r($modulesId);exit;
?>
<div class="page-body">
	<!-- Container-fluid starts-->
	
	<div class="container-fluid">
		<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>UNITS LISTING</h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-primary"  href="<?php echo base_url();?>Units/addUnit" style="float:right">Add Unit</a>
							</div>
							</div>
						</div>	 
					</div>
					<div class="card-body">
					
						<?php if($this->session->flashdata('success')!=""){?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $this->session->flashdata('success');?>
						</div>
						<?php }?>
				
						<?php if($this->session->flashdata('error')!=""){?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $this->session->flashdata('error');?>
						</div>
						<?php }?>
						<?php if($this->session->flashdata('error_msg')!=""){?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $this->session->flashdata('error_msg');?>
						</div>
						<?php }?>										
																
					
						
						<div class="table-responsive">
							<div id="basicScenario" class="product-physical"></div>
							<?php if($unitcnt>0)									
							{
							?>										
								<table class="table table-bordered table-striped mb-0" id="datatable-default">										
									<thead>
										<tr>												
											<th>Sr.No</th>	
											<th>Unit Name</th>
											<th>Status</th>
											<th <?php /*if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if (array_search('CATEGORY', array_column($modulesId, 'edit')) !== FALSE) 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}*/
							?>>Actions</th>	
										</tr>											
									</thead>											
									<tbody>											
										<?php $i=1; 											
										foreach($units as $unit)
										{									?>		
										<tr>
												<td><?php echo $i;?></td>
												<td><?php echo $unit['unit_name'];?></td>
												<td><?php echo 
												($unit['status'] == 1) ? 'Active' : 'Inactive';

												?></td>	
												<td class="actions" <?php
												
												/* if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if (array_search('CATEGORY', array_column($modulesId, 'edit')) !== FALSE) 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							} */
							?>>
													<a href="<?php echo base_url();?>Units/updateUnit/<?php echo base64_encode($unit['id']);?>"><i data-feather="edit"></i></a>
													
													<a href="<?php echo base_url();?>Units/deleteUnit/<?php echo base64_encode($unit['id']);?>" onclick="javascript:return chk_isDeleteComnfirm();">
													<i data-feather="trash-2"></i>
													</a>
											</td>				
											</tr>											
											<?php $i++; }?>
									</tbody>									
								</table>
								<div class="dataTables_paginate paging_simple_numbers" id="datatable-default_paginate" style="margin-top:10px;">
									<?php echo $links; ?>
								</div>									
								<?php } else 
								{?>
								<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No records  found.
								</div>									
								<?php }?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->
	 </div>
	<!-- Container-fluid Ends-->
</div>