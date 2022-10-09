<div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left"><?php echo lang('deactivate_heading');?></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
									<?php
									$attributes = array('class' => 'form-horizontal');
									echo form_open("auth/deactivate/".$user->id,$attributes);?>


                                      <fieldset>
                                        <legend><?php echo lang('deactivate_subheading');?></legend>
                                        
                                            
                                        <div class="control-group <?=(form_error('group_name'))?'error':''?>">
                                          <label class="control-label" for="first_name"><?php echo lang('deactivate_confirm_y_label', 'confirm');?></label>
                                          <div class="controls">
                                          		<input type="radio" name="confirm" value="yes" checked="checked" />
											    
                                          </div>
                                        </div>
                                        <div class="control-group <?=(form_error('group_name'))?'error':''?>">
                                          <label class="control-label" for="first_name"><?php echo lang('deactivate_confirm_n_label', 'confirm');?></label>
                                          <div class="controls">
                                          		
											    <input type="radio" name="confirm" value="no" />
                                            
                                          </div>
                                        </div>
                                           
                                             <?php echo form_hidden($csrf); ?>
  												<?php echo form_hidden(array('id'=>$user->id)); ?>
                                          
                                        
                                        <div class="form-actions">
                                          <button type="submit" class="btn btn-primary"><?= lang('deactivate_submit_btn')?></button>
                                          <a type="reset" href="<?= site_url('auth')?>" class="btn">Cancel</a>
                                        </div>
                                      </fieldset>
                                    <?php echo form_close();?>

                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>