<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card tab2-card">
                            <div class="card-header">
                                <h5> ADD PRODUCT</h5>
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
						
						<form class="needs-validation" name="frm_addunit" id="frm_addunit" method="POST" enctype="multipart/form-data">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="item_name" class="col-xl-3 col-md-4"><span>*</span>Product Name</label>
                                                <input type="text" class="form-control  col-md-6" id="item_name" name="item_name" placeholder="Enter Product Name" required value="">
												 <div id="err_item_name" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="brand_id" class="col-xl-3 col-md-4"><span>*</span>Brand</label>
                                                <select class="form-control  col-md-6" id="brand_id" name="brand_id"  style="width: 100%;"  >
                                    <?php
                                       $query1="select * from db_brands where status=1";
                                       $q1=$this->db->query($query1);
                                       if($q1->num_rows($q1)>0)
                                        {  echo '<option value="">-Select-</option>'; 
                                            foreach($q1->result() as $res1)
                                          { 
                                            $selected = ($brand_id==$res1->id)? 'selected' : '';
                                            echo "<option $selected value='".$res1->id."'>".$res1->brand_name."</option>";
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
												 <div id="err_brand_id" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="phone" class="col-xl-3 col-md-4">Category</label>
                                                <select class="form-control  col-md-6" id="category_id" name="category_id"  style="width: 100%;"  value="<?php print $category_id; ?>">
                                    <?php
                                       $query1="select * from db_category where status=1 AND parent_id = 0";
                                       $q1=$this->db->query($query1);
                                       if($q1->num_rows($q1)>0)
                                        {  echo '<option value="">-Select-</option>'; 
                                            foreach($q1->result() as $res1)
                                          { 
                                            $selected = ($category_id==$res1->id)? 'selected' : '';
                                            echo "<option $selected value='".$res1->id."'>".$res1->category_name."</option>";
											
												$query2="select * from db_category where status=1 AND parent_id = ".$res1->id;
												$q2=$this->db->query($query2);
												if($q2->num_rows($q2)>0)
												{   
													foreach($q2->result() as $res2)
												  {
													  $selected = ($category_id==$res2->id)? 'selected' : '';
														echo "<option $selected value='".$res2->id."'> - ".$res2->category_name."</option>";
													  
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
                                            </div>
											
											<div class="form-group row">
                                                <label for="email" class="col-xl-3 col-md-4"><span>*</span>Unit</label>
                                                <input type="text" class="form-control  col-md-6" id="email" name="email" placeholder="Enter Email" required value="">
												 <div id="err_email" class="error_msg"></div>
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
                                                <label for="vehicle_number" class="col-xl-3 col-md-4"><span>*</span>Vehicle Number</label>
                                                <input type="text" class="form-control  col-md-6" id="vehicle_number" name="vehicle_number" placeholder="Enter Vehicle Number" required value="">
												 <div id="err_vehicle_number" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="charges" class="col-xl-3 col-md-4"><span>*</span>Charges</label>
                                                <input type="text" class="form-control  col-md-6" id="charges" name="charges" placeholder="Enter Per KM charges" required value="">
												 <div id="err_charges" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="gst_number" class="col-xl-3 col-md-4"><span>*</span>GST Number</label>
                                                <input type="text" class="form-control  col-md-6" id="gst_number" name="gst_number" placeholder="Enter Post Code" required value="">
												 <div id="err_gst_number" class="error_msg"></div>
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
                            <button type="submit" class="btn btn-primary" name="btn_addtrans" id="btn_addtrans">Add</button>
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