
<div class="row-fluid">
                        <!-- block -->
                        <div class="block"  style="margin-left: 5%;">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left"><h2><?php echo lang('edit_user_heading');?></h2></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                     	<?php 
											$attributes = array('class' => 'form-horizontal');
											echo form_open(uri_string(),$attributes);?>
                                      <fieldset style="margin-left: 15%;">
                                        <legend><?php echo lang('edit_user_subheading');?></legend>
                                        
                                            
                                        <div class="control-group <?=(form_error('first_name'))?'error':''?>">
                                          <label class="control-label" for="first_name"><?php echo lang('edit_user_fname_label', 'first_name');?></label>
                                          <div class="controls">
                                            <?php echo form_input($first_name);?>
                                            <?php echo form_error('first_name', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                           
                                            
                                          
                                        <div class="control-group <?=(form_error('last_name'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo lang('edit_user_lname_label', 'last_name');?></label>
                                          <div class="controls">
                                            <?php echo form_input($last_name);?>
                                             <?php echo form_error('last_name', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                        <div class="control-group <?=(form_error('email'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo lang('edit_user_company_label', 'email');?></label>
                                          <div class="controls">
                                            <?php echo form_input($email);?>
                                            <?php echo form_error('email', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                        <div class="control-group <?=(form_error('phone'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo lang('edit_user_phone_label', 'phone');?></label>
                                          <div class="controls">
                                            <?php echo form_input($phone);?>
                                            <?php echo form_error('phone', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                        <div class="control-group <?=(form_error('password'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo lang('edit_user_password_label', 'password');?></label>
                                          <div class="controls">
                                            <?php echo form_input($password);?>
                                            <?php echo form_error('password', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                         <div class="control-group <?=(form_error('password_confirm'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo lang('edit_user_password_confirm_label', 'password_confirm');?></label>
                                          <div class="controls">
                                            <?php echo form_input($password_confirm);?>
                                            <?php echo form_error('password_confirm', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                        
	<?php 
	
	
	if($this->ion_auth->is_admin()){ ?>
		 <h3><?php echo lang('edit_user_groups_heading');?></h3>
		 
	<?php	foreach ($groups as $group):?>
		
	<label class="radio">
	<?php
		$gID=$group['id'];
		$checked = null;
		$item = null;
		foreach($currentGroups as $grp) {
			if ($gID == $grp->id) {
				$checked= ' checked="checked"';
			break;
			}
		}
	?>
	
	<input type="radio" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
	<?php echo $group['name'];?>
	</label>
	<?php endforeach?>
	<?php }
else{ ?>
	<br><br>
	
	<?php }
	?>	

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden('csrf',$csrf);  ?>

                                        <div class="form-actions">
                                          <button type="submit" class="btn btn-primary">Save changes</button>
                                          <a href="<?= site_url('auth')?>" type="reset" class="btn">Cancel</a>
                                        </div>
                                      </fieldset>
                                    <?php echo form_close();?>

                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
