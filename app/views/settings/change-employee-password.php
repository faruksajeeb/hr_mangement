<?php
$this->load->view('includes/employee-header');
?> 
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">   </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"> 
            <div class="jumbotron ">    
                <h1 class="text-center">Change Password</h1>
                 <?php
                $msg = $this->session->flashdata('success');
                if ($msg) {
                    ?>
                    <br/>
                    <div class="alert alert-success text-center">
                        <strong>Success!</strong> <?php echo $msg ?>
                    </div>                                    
                    <?php
                }
                $msg = null;
                ?>
                <?php
                $error = $this->session->flashdata('errors');
                if ($error) {
                    ?>
                    <br/>
                    <div class="alert alert-danger text-center">
                        <strong>ERROR!</strong> <?php echo $error ?>
                    </div>                                    
                    <?php
                }
                $error = null;
                ?>
                <form action="<?php echo base_url();?>update-employee-password" method="POST">
                    <div class="form-group">
                        <label class="label">Old Password <span style="color:red"></span>:</label>
                        <input value=""  class="form-control " type="text" name="old_password" id="old_password"  />
                    </div>
                    <div class="form-group">
                        <label class="label">New Password <span style="color:red">*</span>:</label>
                        <input value=""  class="form-control " type="text" name="new_password" id="new_password" required="" />
                    </div>
                    <div class="form-group">
                        <label class="label">Confirm Password <span style="color:red">*</span>:</label>
                        <input value=""  class="form-control " type="text" name="confirm_password" id="confirm_password" required="" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-lg pull-right form-control" type="submit" name="save_pass_update" id="save_pass_update"/> Submit</button>
                    </div>
                </form>
            </div>  
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">   </div>

    </div>
</div>
<?php
$this->load->view('includes/employee-footer');
?> 