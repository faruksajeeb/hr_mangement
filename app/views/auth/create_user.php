<div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left"><?php echo lang('create_user_heading');?></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                     	<?php 
										$attributes = array('class' => 'form-horizontal');
										echo form_open("auth/create_user",$attributes);?>
                                      <fieldset>
                                        <legend><?php echo lang('create_user_subheading');?></legend>
                                        
                                            
                                        <div class="control-group <?=(form_error('first_name'))?'error':''?>">
                                          <label class="control-label" for="first_name"><?php echo lang('create_user_fname_label', 'first_name');?></label>
                                          <div class="controls">
                                            <?php echo form_input($first_name);?>
                                            <?php echo form_error('first_name', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                           
                                            
                                          
                                        <div class="control-group <?=(form_error('last_name'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo lang('create_user_lname_label', 'last_name');?></label>
                                          <div class="controls">
                                            <?php echo form_input($last_name);?>
                                             <?php echo form_error('last_name', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                        <div class="control-group <?=(form_error('company'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo lang('create_user_company_label', 'company');?></label>
                                          <div class="controls">
                                            <?php echo form_input($company);?>
                                            <?php echo form_error('company', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                        <div class="control-group <?=(form_error('email'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo lang('create_user_email_label', 'email');?></label>
                                          <div class="controls">
                                            <?php echo form_input($email);?>
                                            <?php echo form_error('email', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                        <div class="control-group <?=(form_error('phone'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo lang('create_user_phone_label', 'phone');?></label>
                                          <div class="controls">
                                            <?php echo form_input($phone);?>
                                            <?php echo form_error('phone', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                        <div class="control-group <?=(form_error('password'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo lang('create_user_password_label', 'password');?></label>
                                          <div class="controls">
                                            <?php echo form_input($password);?>
                                            <?php echo form_error('password', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                         <div class="control-group <?=(form_error('password_confirm'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo lang('create_user_password_confirm_label', 'password_confirm');?></label>
                                          <div class="controls">
                                            <?php echo form_input($password_confirm);?>
                                            <?php echo form_error('password_confirm', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                        <div class="form-actions">
                                          <button type="submit" class="btn btn-primary">Save changes</button>
                                          <button type="reset" class="btn">Cancel</button>
                                        </div>
                                      </fieldset>
                                    <?php echo form_close();?>

                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>