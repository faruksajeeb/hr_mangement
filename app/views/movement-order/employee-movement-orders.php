 <?php
    $this->load->view('includes/employee-header');
    ?> 
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">  
                        <h3 style="text-align:center; padding: 10px;">Employee Movement Orders</h3>
                        
                        <?php
                                        $msg = $this->session->flashdata('msg');
                                        if ($msg) {
                                            ?>
                                            <br/>
                                            <div class="alert alert-success text-center">
                                                <strong>Success!</strong> <?php echo $msg ?>
                                            </div>                                    
                                            <?php
                                        }
                        ?>
                        <table class="table table-responsive table-sm">
                            <thead>
                                    <th>Sl No.</th>
                                    <th>Date Of Movement</th>
                                    <th>Type Of Movement</th>
                                    
                                    <th>Department Approval</th>
                                    <th>Administrator Approval</th>
                                    <th>Remarks</th>
                                    <th>Work Location</th>
                                    <th>Informed Earlier</th>
                                    <th>Reason</th>                                    
                                    <th>Location From</th>                                    
                                    <th>Location To</th>                             
                                    <th>Out Time</th>
                                    <th>In Time</th>
                                    <th>Possibility Of Return</th>
                                    <th></th>
                            </thead>
                            <tbody>
                                <?php
                                $slNo=1;
                                foreach($employee_movement_orders as $employeeMovementOrder){                                    
                                    ?>
                                <tr>
                                    <td><?php echo $slNo++; ?></td>
                                    <td><?php echo $employeeMovementOrder->attendance_date ?></td>
                                    <td><?php echo $employeeMovementOrder->type_of_movement; ?></td>
                                    <td>
                                        <?php 
                                        if($employeeMovementOrder->first_approval==0){
                                            echo '<span class="badge badge-warning">Pending</span>';
                                        } if($employeeMovementOrder->first_approval==-1){
                                            echo '<span class="badge badge-danger">Not Approved</span>';
                                        }else if($employeeMovementOrder->first_approval==1){
                                            echo '<span class="badge badge-success">Approved</span>';
                                        }
                                         
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        if($employeeMovementOrder->second_approval==0){
                                            echo '<span class="badge badge-warning">Pending</span>';
                                        }else  if($employeeMovementOrder->second_approval==1){
                                            echo '<span class="badge badge-success">Approved</span>';
                                        }else  if($employeeMovementOrder->second_approval==-1){
                                            echo '<span class="badge badge-danger">Not Approved</span>';
                                        }
                                         
                                        ?>
                                    </td>
                                    <td><?php echo $employeeMovementOrder->status_comments; ?></td>
                                    <td><?php echo $employeeMovementOrder->work_location; ?></td>
                                    <td><?php echo $employeeMovementOrder->informed_earlier; ?></td>
                                    <td><?php echo $employeeMovementOrder->reason; ?></td>
                                    <td><?php echo $employeeMovementOrder->location_from; ?></td>
                                    <td><?php echo $employeeMovementOrder->location_to; ?></td>
                                    <td><?php echo $employeeMovementOrder->out_time; ?></td>
                                    <td><?php echo $employeeMovementOrder->expected_in_time; ?></td>
                                    <td><?php echo $employeeMovementOrder->possibility_of_return; ?></td>                                    
                                      <td>
                                        <?php if($employeeMovementOrder->first_approval==0 && $employeeMovementOrder->second_approval==0){ ?>
                                        <a href="<?php echo base_url("edit-employee-movement")."/".$employeeMovementOrder->id;?>?<?php echo time()."-_+=";?>">edit</a>
                                        <a href="<?php echo base_url("delete-employee-movement")."/".$employeeMovementOrder->id;?>?<?php echo time()."-_+=";?>" class="btn btn-sm btn-danger" onclick="return ConfirmDelete();">X</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

 <?php
    $this->load->view('includes/employee-footer');
    ?> 