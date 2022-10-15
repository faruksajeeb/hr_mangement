 <?php
    $this->load->view('includes/employee-header');
    ?> 
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">  
                        <?php
                                        $msg = $this->session->flashdata('msg');
                                        
                                        if ($msg) {
                                            ?>
                                            <br/>
                                            <div class="alert alert-warning text-left">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong></strong> <?php echo $msg ?>
                                            </div>                                    
                                            <?php
                                            $msg=null;
                                        }
                                        
                        ?>
                        <table class="table table-responsive">
                            <thead>
                                    <th>Sl No.</th>
                                    <th>Leave Date</th>
                                    <th>Leave Type</th>
                                    <th>Pay Status</th>                                    
                                    <th>Department Approval</th>
                                    <th>Administrator Approval</th>
                                    <th>Remarks</th>
                                    <th>Justification</th>
                                    <th></th>
                            </thead>
                            <tbody>
                                <?php
                                $slNo=1;
                                foreach($employee_leaves as $employee_leave){                                    
                                    ?>
                                <tr>
                                    <td><?php echo $slNo++; ?></td>
                                    <td><?php echo $employee_leave->leave_start_date ?></td>
                                    <td><?php echo $employee_leave->leave_type_name; ?></td>
                                    <td><?php echo $employee_leave->pay_status ?></td>
                                    <td style="text-align: center">
                                          <?php 
                                    if($employee_leave->department_approval==0){
                                        echo '<span class="badge badge-default">Pending</span>';
                                    }else if($employee_leave->department_approval==1){
                                        echo '<span class="badge badge-success">Approved</span>';
                                    }else if($employee_leave->department_approval==-1){
                                        echo '<span class="badge badge-danger">Not Approved</span>';
                                    }
                                    ?>
                                    </td>
                                     
                                    <td style="text-align: center"><?php 
                                    if($employee_leave->approve_status=='pending'){
                                        echo '<span class="badge badge-default">Pending</span>';
                                    }else if($employee_leave->approve_status=='not_approved'){
                                        echo '<span class="badge badge-danger">Not Approved</span>';
                                    }else{
                                        echo '<span class="badge badge-success">Approved</span>';
                                    }
                                    ?>
                                    </td>
                                    <td><?php echo $employee_leave->remarks ?></td>
                                    <td><?php echo $employee_leave->justification ?></td>
                                    <td>
                                        <?php if($employee_leave->department_approval==0 && $employee_leave->approve_status=='pending'){ ?>
                                        <a href="<?php echo base_url("employee-leave-application")."/".$employee_leave->id;?>?<?php echo time()."-_+=";?>">edit</a>
                                        <a href="<?php echo base_url("delete-leave-application")."/".$employee_leave->id;?>?<?php echo time()."-_+=";?>" class="btn btn-sm btn-danger" onclick="return ConfirmDelete();">X</a>
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