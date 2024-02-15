<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card tab2-card">
                            <div class="card-header">
                                <h5> ADD SUPPLIER</h5>
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
						
						<form class="needs-validation" name="frm_addsup" id="frm_addsup" method="POST" enctype="multipart/form-data">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="supplier_name" class="col-xl-3 col-md-4"><span>*</span>Supplier Name</label>
                                                <input type="text" class="form-control  col-md-6" id="supplier_name" name="supplier_name" placeholder="Enter Supplier Name" required value="">
												 <div id="err_supplier_name" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="mobile" class="col-xl-3 col-md-4"><span>*</span>Mobile Number</label>
                                                <input type="text" class="form-control  col-md-6" id="mobile" name="mobile" placeholder="Enter Mobile" required value="">
												 <div id="err_mobile" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="phone" class="col-xl-3 col-md-4">Phone Number</label>
                                                <input type="text" class="form-control  col-md-6" id="phone" name="phone" placeholder="Enter Phone"  value="">
                                            </div>
											
											<div class="form-group row">
                                                <label for="email" class="col-xl-3 col-md-4"><span>*</span>Email Address</label>
                                                <input type="text" class="form-control  col-md-6" id="email" name="email" placeholder="Enter Email" required value="">
												 <div id="err_email" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="gstin" class="col-xl-3 col-md-4"><span>*</span>GST Number</label>
                                                <input type="text" class="form-control  col-md-6" id="gstin" name="gstin" placeholder="Enter GST No" required value="">
												 <div id="err_gstin" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="tax_number" class="col-xl-3 col-md-4"><span>*</span>Tax Number</label>
                                                <input type="text" class="form-control  col-md-6" id="tax_number" name="tax_number" placeholder="Enter Tax No" required value="">
												 <div id="err_tax_number" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="address" class="col-xl-3 col-md-4"> <span>*</span>Address</label>
                                               <textarea name="address" id="address" class="form-control  col-md-6"></textarea>
											   <div id="err_address" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="postcode" class="col-xl-3 col-md-4"><span>*</span>Post Code</label>
                                                <input type="text" class="form-control  col-md-6" id="postcode" name="postcode" placeholder="Enter Post Code" required value="">
												 <div id="err_postcode" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span></span>Status</label>
												<select name="status" id="status" class="form-control  col-md-3" required>
													<option value="">Select Status</option>
													<option value="1">Active</option>
													<option value="0">Inactive</option>
												</select>
                                            </div>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                        <div class="pull-left">
                            <button type="submit" class="btn btn-primary" name="btn_addsupl" id="btn_addsupl">Add</button>
							<a href="<?php echo base_url();?>Suppliers/index" class="btn btn-primary" >Cancel</a>
                        </div>
						</form>
                            </div>
                        </div>
                    </div>
                </div>
				
            </div>
	<!-- Container-fluid Ends-->
</div>