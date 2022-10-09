<div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left"><?php echo lang('create_group_heading');?></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                     	<?php
									$attributes = array('class' => 'form-horizontal');
									echo form_open("auth/create_group",$attributes);?>

                                      <fieldset>
                                        <legend><?php echo lang('create_group_subheading');?></legend>
                                        
                                            
                                        <div class="control-group <?=(form_error('group_name'))?'error':''?>">
                                          <label class="control-label" for="first_name"><?php echo lang('create_group_name_label', 'group_name');?></label>
                                          <div class="controls">
                                            <?php echo form_input($group_name);?>
                                            <?php echo form_error('group_name', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                           
                                            
                                          
                                        <div class="control-group <?=(form_error('description'))?'error':''?>">
                                          <label class="control-label" for="focusedInput"><?php echo lang('create_group_desc_label', 'description');?></label>
                                          <div class="controls">
                                            <?php echo form_input($description);?>
                                             <?php echo form_error('description', '<span class="help-inline">', '</span>'); ?>
                                          </div>
                                        </div>
                                        <div class="form-actions">
                                          <button type="submit" class="btn btn-primary">Save changes</button>
                                          <a type="reset" href="<?= site_url('auth')?>" class="btn">Cancel</a>
                                        </div>
                                      </fieldset>
                                    <?php echo form_close();?>

                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>