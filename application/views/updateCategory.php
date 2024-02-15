<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Update Category</h5>
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
						<form class="needs-validation" name="frm_updatebrand" id="frm_updatebrand" method="POST" enctype="multipart/form-data">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="category_name" class="col-xl-3 col-md-4"><span></span>Category</label>
                                                <input type="text" class="form-control  col-md-6" id="category_name" name="category_name" placeholder="Enter Category" required value="<?php echo $categoryInfo[0]['category_name'];?>">
												 <div id="err_category_name" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="parent_id" class="col-xl-3 col-md-4">Parent Category</label>
                                                <?php 
				 $categories=$this->db->query("SELECT id,category_name FROM db_category")->result();
				 
				$parentCat = $categoryInfo[0]['parent_id']; 
				?>
				<select class="form-control col-md-6" id="parent_id" name="parent_id" placeholder="">
					 <?php
                                       $query1="select * from db_category where status=1 AND parent_id = 0";
                                       $q1=$this->db->query($query1);
                                       if($q1->num_rows($q1)>0)
                                        {  echo '<option value="">-Select-</option>'; 
                                            foreach($q1->result() as $res1)
                                          { 
											$selected = '';
                                            if($parentCat==$res1->id)
												$selected = "selected";
											
                                            echo "<option ".$selected." value='".$res1->id."'>".$res1->category_name."</option>";
											
												$query2="select * from db_category where status=1 AND parent_id = ".$res1->id;
												$q2=$this->db->query($query2);
												if($q2->num_rows($q2)>0)
												{   
													foreach($q2->result() as $res2)
												  {
														$selected = '';
														if($parentCat==$res2->id)
															$selected = "selected";
											
														echo "<option ".$selected." value='".$res2->id."'> - ".$res2->category_name."</option>";
													  
												  }
												}
											}
                                        }
                                        else
                                        {
                                           ?>
                                    <option value="">No Records Found</option>
                                    <?php
                                       }
                                       ?>
					</select>
												 <div id="err_parent_id" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="description" class="col-xl-3 col-md-4"> Description</label>
                                               <textarea name="description" id="description" class="form-control  col-md-6"><?php echo $categoryInfo[0]['description'];?></textarea>
                                            </div>
											
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span></span>Status</label>
												<select name="status" id="status" class="form-control  col-md-3" required>
													<option value="">Select Status</option>
													<option value="1" <?php if($categoryInfo[0]['status']=="1"){ echo 'selected="selected"';}?>>Active</option>
													<option value="0" <?php if($categoryInfo[0]['status']=="0"){ echo 'selected="selected"';}?>>Inactive</option>
												</select>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="pull-left">
                            <button type="submit" class="btn btn-primary" name="btn_uptcategory" id="btn_uptcategory">Update</button>
							<a href="<?php echo base_url();?>Categories/index" class="btn btn-primary" >Cancel</a>
                        </div>
						</form>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>