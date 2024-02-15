<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Update Unit</h5>
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
						<form class="needs-validation" name="frm_updateunit" id="frm_updateunit" method="POST" enctype="multipart/form-data">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="unit_name" class="col-xl-3 col-md-4"><span></span>Unit</label>
                                                <input type="text" class="form-control  col-md-6" id="unit_name" name="unit_name" placeholder="Enter Unit" required value="<?php echo $UnitInfo[0]['unit_name'];?>">
												 <div id="err_unit_name" class="error_msg"></div>
                                            </div>
											<div class="form-group row">
                                                <label for="description" class="col-xl-3 col-md-4"><span>*</span> Description</label>
                                               <textarea name="description" id="description" class="form-control  col-md-6"><?php echo $UnitInfo[0]['description'];?></textarea>
                                            </div>
											
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span></span>Status</label>
												<select name="status" id="status" class="form-control  col-md-3" required>
													<option value="">Select Status</option>
													<option value="1" <?php if($UnitInfo[0]['status']=="1"){ echo 'selected="selected"';}?>>Active</option>
													<option value="0" <?php if($UnitInfo[0]['status']=="0"){ echo 'selected="selected"';}?>>Inactive</option>
												</select>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="pull-left">
                            <button type="submit" class="btn btn-primary" name="btn_uptunit" id="btn_uptunit">Update</button>
							<a href="<?php echo base_url();?>Units/index" class="btn btn-primary" >Cancel</a>
                        </div>
						</form>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>