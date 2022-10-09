<div id="page-heading">
			
			<h1><?php echo lang('change_password_heading');?></h1>
			
		</div>
		<div class="container">
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-midnightblue">
<div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                              
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12" style="margin-left: 20%;">
								<?php
								$attributes = array('class' => 'form-horizontal');
								echo form_open("auth/change_password",$attributes);?>


                                      <fieldset>
                                        
                                        
                                            
                                        <div class="control-group <?=(form_error('old'))?'error':''?>">
                                          <label class="control-label" for="first_name"><?php echo lang('change_password_old_password_label', 'old_password');?></label>
                                          <div class="controls">
                                            <?php echo form_input($old_password);?>
                                            <?php echo form_error('old_password', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                           
                                            
                                          
                                        <div class="control-group <?=(form_error('new'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label>
                                          <div class="controls">
                                            <?php echo form_input($new_password);?>
                                             <?php echo form_error('new_password', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                        
                                        
                                        <div class="control-group <?=(form_error('new_confirm'))?'error':''?>">
                                          <label class="control-label" for="first_name"><?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?></label>
                                          <div class="controls">
                                            <?php echo form_input($new_password_confirm);?>
                                            <?php echo form_error('new_password_confirm', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                        
                                        
                                        
                  
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="btn-toolbar" >
                                          <button type="submit" class="btn btn-primary">Update Password</button>
                                          <a type="reset" href="<?= site_url('auth')?>" class="btn">Cancel</a>
                                        </div>
                                        </div>
                                        </div>
                                     
                                        
                                      </fieldset>
                                    <?php echo form_close();?>

                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    