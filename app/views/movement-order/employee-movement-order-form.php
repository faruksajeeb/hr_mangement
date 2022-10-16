<?php
$this->load->view('includes/employee-header');
?> 
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">   </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" style="padding: 10px; border:1px dotted #ccc;margin: 5px; background: #FFE4B5">
                <h3 style="text-align:center; padding: 10px;">Employee Movement Order</h3>
                <hr/>

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
                <form class="" action="<?php echo base_url(); ?>empattendance/saveEmployeeMovementOrder" method="POST">
                    <input type="hidden" name="edit_movement_id" ID="edit_movement_id" value="<?php if($edit_info){ echo $edit_info['id']; }?>" />
                    <div class="form-group">

                        <span class="label pull-right">[<span style="color:red">*</span> Fileds are required.]</span>
                    </div>
                    <div class="form-group">
                        <label class="label">Date Of Movement <span style="color:red">*</span>:</label>
                        <input value="<?php if($edit_info){ echo $edit_info['attendance_date']; }?>"  class="form-control datepicker"  data-date-format="mm/dd/yyyy" type="text" name="date_of_movement" id="date_of_movement" required="" />
                    </div>

                    <div class="form-group">
                        <label class="label">Work Location <span style="color:red">*</span>:</label>
                        <input value="<?php if($edit_info){ echo $edit_info['work_location']; }?>" class="form-control " type="text" name="work_location" id="work_location" required="" />
                    </div>

                    <!--                            <div class="form-group">
                                                    <label class="label">Res. Hand Over:</label>
                                                    <input class="form-control" type="text" name="res_hand_over" id="res_hand_over"/>
                                                </div>-->
                    <div class="form-group">
                        <label class="label">Contact Number:</label>
                        <input value="<?php if($edit_info){ echo $edit_info['contact_number']; }?>" class="form-control" type="text" name="contact_number" id="contact_number"/>
                    </div>
                    <div class="form-group">
                        <label for="type_of_movement" class="label">Informed Earlier For Such Movement <span style="color:red">*</span>:</label>
                        <br/>
                        <label class="radio-inline">
                            <input type="radio" name="informed_earlier" value="yes" checked  <?php if($edit_info['informed_earlier']=="yes"){ echo "checked";} ?>> Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="informed_earlier" value="no"  <?php if($edit_info['informed_earlier']=="no"){ echo "checked";} ?>> No
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="type_of_movement" class="label">Type Of Movement <span style="color:red">*</span>:</label>
                        <select name="type_of_movement" id="type_of_movement" class="form-control" required="" >
                            <option value="official" <?php if($edit_info['type_of_movement']=="official"){ echo "selected='selected'";} ?>>Official</option>
                            <option value="personal" <?php if($edit_info['type_of_movement']=="personal"){ echo "selected='selected'";} ?>>Personal</option>
                        </select>  
                    </div>

                    <div class="form-group">
                        <label for="" class="label">Justification/ Reason <span style="color:red">*</span>:</label>
                        <textarea name="reason" id="reason" class="form-control" required="" ><?php if($edit_info){ echo $edit_info['reason']; }?></textarea>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="label">Out/ Start Time:</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">[24 H. Format]  </div>
                                </div>
                                <input value="<?php if($edit_info){ echo $edit_info['out_time']; }?>" type="text" class="form-control timepicker" id="out_time" name="out_time"  placeholder="Eg.11:00">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label">Expected Return/ In Time:</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">[24 H. Format]  </div>
                                </div>
                                <input value="<?php if($edit_info){ echo $edit_info['expected_in_time']; }?>" type="text" class="form-control timepicker"  name="in_time" id="in_time"  placeholder="Eg.19:00">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="label">Location From:</label>
                            <input value="<?php if($edit_info){ echo $edit_info['location_from']; }?>" class="form-control " type="text" name="location_form" id="location_form"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label">Location To:</label>
                            <input value="<?php if($edit_info){ echo $edit_info['location_to']; }?>" class="form-control " type="text" name="location_to" id="location_to"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label">Possibility Of Return:</label>
                        <br/>
                        <label class="radio-inline">
                            <input  type="radio" name="possibility_of_return" value="yes" checked  <?php if($edit_info['possibility_of_return']=="yes"){ echo "checked";} ?>> Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="possibility_of_return" value="no" <?php if($edit_info['possibility_of_return']=="no"){ echo "checked";} ?>> No
                        </label>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary pull-right" type="submit" name="save_movement_order" id="save_movement_order"/> <?php if($edit_info){ echo "Save Changes"; }else{ echo "Submit";}?> </button>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">   </div>
        </div>
    </div>
</div>
<?php
$this->load->view('includes/employee-footer');
?> 