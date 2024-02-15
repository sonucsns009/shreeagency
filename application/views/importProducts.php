<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Import Products</h5>
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
						<form class="needs-validation" name="frm_addbrand" id="frm_addbrand" method="POST" enctype="multipart/form-data">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="brand_name" class="col-xl-3 col-md-4"><span>*</span>Import Products</label>
                                                <input type="file" id="import_file" name="import_file">
                                    <span id="import_file_msg" style="display:block;" class="text-danger">
                                      Note: File must be in CSV format.
                                    </span>
												 
                                            </div>
											
											<div class="col-sm-12">
                                            <div class="form-group row">
												<a href="<?php echo base_url();?>uploads/csv/import-products-sample.csv"><button type="button" class="btn btn-info pull-right btnExport" title="Download Data in Excel Format">Download sample csv</button>
												</a>
											</div>
											</div>
			  
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                        <div class="pull-left">
                            <button type="submit" class="btn btn-primary" name="btn_addbrand" id="btn_addbrand">Add</button>
							<a href="<?php echo base_url();?>Brands/index" class="btn btn-primary" >Cancel</a>
                        </div>
						</form>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>