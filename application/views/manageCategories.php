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
						<h5>CATEGORY LISTING</h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-primary"  href="<?php echo base_url();?>Categories/addCategory" style="float:right">Add Category</a>
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
							<?php if($catcnt>0)									
							{
							?>										
								<table class="table table-bordered table-striped mb-0" id="datatable-default">										
									<thead>
										<tr>												
											<th>Sr.No</th>	
											<th>Category Name</th>
											<th>Parent Category</th>	
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
										foreach($categories as $category)
										{									?>		
										<tr>
												<td><?php echo $i;?></td>
												<td><?php echo $category['category_name'];?></td>
												<td><?php 
												$parent_name=$this->db->query("SELECT category_name FROM db_category where id='".$category['parent_id']."'")->row();
												$parentcategory = '';
												if(!empty ($parent_name) )
													$parentcategory = $parent_name->category_name;
												
			$parentCat = ($parentcategory) ? ($parentcategory) : "---";
												echo $parentCat; ?></td>
												<td><?php echo 
												($category['status'] == 1) ? 'Active' : 'Inactive';

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
													<a href="<?php echo base_url();?>Categories/updateCategory/<?php echo base64_encode($category['id']);?>"><i data-feather="edit"></i></a>
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