<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card tab2-card">
                            <div class="card-header">
                                <h5> UPDATE SUPPLIER</h5>
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
						
						<form class="needs-validation" name="frm_updsupl" id="frm_updsupl" method="POST" enctype="multipart/form-data">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="supplier_name" class="col-xl-3 col-md-4"><span>*</span>Transport Name</label>
                                                <input type="text" class="form-control  col-md-6" id="supplier_name" name="supplier_name" placeholder="Enter Supplier Name" required value="<?php echo $SupplierInfo[0]['supplier_name'];?>">
												 <div id="err_transport_name" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="mobile" class="col-xl-3 col-md-4"><span>*</span>Mobile Number</label>
                                                <input type="text" class="form-control  col-md-6" id="mobile" name="mobile" placeholder="Enter Mobile" required value="<?php echo $SupplierInfo[0]['mobile'];?>">
												 <div id="err_mobile" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="phone" class="col-xl-3 col-md-4">Phone Number</label>
                                                <input type="text" class="form-control  col-md-6" id="phone" name="phone" placeholder="Enter Phone"  value="<?php echo $SupplierInfo[0]['phone'];?>">
                                            </div>
											
											<div class="form-group row">
                                                <label for="email" class="col-xl-3 col-md-4"><span>*</span>Email Address</label>
                                                <input type="text" class="form-control  col-md-6" id="email" name="email" placeholder="Enter Email" required value="<?php echo $SupplierInfo[0]['email'];?>">
												 <div id="err_email" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="gstin" class="col-xl-3 col-md-4"><span>*</span>GST Number</label>
                                                <input type="text" class="form-control  col-md-6" id="gstin" name="gstin" placeholder="Enter GST No" required value="<?php echo $SupplierInfo[0]['gstin'];?>">
												 <div id="err_gstin" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="tax_number" class="col-xl-3 col-md-4"><span>*</span>Tax Number</label>
                                                <input type="text" class="form-control  col-md-6" id="tax_number" name="tax_number" placeholder="Enter Tax No" required value="<?php echo $SupplierInfo[0]['tax_number'];?>">
												 <div id="err_tax_number" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="address" class="col-xl-3 col-md-4"> Address</label>
                                               <textarea name="address" id="address" class="form-control  col-md-6"><?php echo $SupplierInfo[0]['address'];?></textarea>
                                            </div>
											
											<div class="form-group row">
                                                <label for="postcode" class="col-xl-3 col-md-4"><span>*</span>Post Code</label>
                                                <input type="text" class="form-control  col-md-6" id="postcode" name="postcode" placeholder="Enter Post Code" required value="<?php echo $SupplierInfo[0]['postcode'];?>">
												 <div id="err_postcode" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span></span>Status</label>
												<select name="status" id="status" class="form-control  col-md-3" required>
													<option value="">Select Status</option>
													<option value="1" <?php if($SupplierInfo[0]['status']=="1"){ echo 'selected="selected"';}?>>Active</option>
													<option value="0" <?php if($SupplierInfo[0]['status']=="0"){ echo 'selected="selected"';}?>>Inactive</option>
												</select>
                                            </div>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary" name="btn_upttrans" id="btn_upttrans">Update</button>
							<a href="<?php echo base_url();?>Transport/index" class="btn btn-primary" >Cancel</a>
                        </div>
						</form>
                            </div>
                        </div>
                    </div>
                </div>
				
            </div>
	<!-- Container-fluid Ends-->
</div>