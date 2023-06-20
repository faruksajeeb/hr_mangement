 <?php
    $this->load->view('includes/employee-header');
    ?> 
      
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">   
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
             if($emp_total_leave){ 
                
                //print_r($earn_leave_info);
                ?>
             <br/>
                        <table id="" class="table table-responsive table-bordered" cellspacing="0" width="100%" border="1">
                        <thead>
                            <tr>
                                <th colspan="2">Previous years earn leave balance</th>
                                <th><?php echo $previous_carry_forward_leave_balance; ?></th>
                            </tr>
                            <tr>
                                <th colspan="2">This year earn leave</th>
                                <th><?php echo $this_year_earn_leave; ?></th>
                            </tr>
                            <tr>
                                <th colspan="2">Total Earn Leave <span style="font-size:10px">(Previous+This Year)</span></th>
                                <th><?php echo ($previous_carry_forward_leave_balance+$this_year_earn_leave); ?></th>
                            </tr>
                            <tr>
                                <th colspan="2">Total Leave This Year</th>
                                <th><?php echo $emp_total_leave; ?></th>
                            </tr>
                            <tr>
                                <th colspan="2">Total Leave</th>
                                <th><?php echo $totalLeave = $emp_total_leave+$previous_carry_forward_leave_balance; ?></th>
                            </tr>
                            <tr class="heading" style="background-color:#CCC">
                                <th>Leave Type</th>
                                <th>Spent Leave</th>
                                <th>Dates</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $grand_total_spant=0;
                            foreach ($allleavetype as $single_leave) {
                                $id = $single_leave['id'];
                                $leavetype = $single_leave['name'];
                                $vid = $single_leave['vid'];
                                $tid = $single_leave['tid'];
                                $description = $single_leave['description'];
                                if($content_id){
                                    //$total_leave=$this->emp_leave_model->getemp_yearlyleave($defaultcontent_id, $tid);
                                    date_default_timezone_set('Asia/Dhaka');
                                    $servertime = time();
                                    $leave_year = date("Y", $servertime); 
                                    $total_leave_spent_query=$this->emp_leave_model->getemp_spentleave($content_id, $tid, $leave_year);
                                    $total_leave_spent=0;
                                    $leave_spent_date="";
                                    foreach ($total_leave_spent_query as $single_spent_leave) {                                     
                                     $total_leave_spent=$total_leave_spent+$single_spent_leave['leave_total_day'];
                                     $specialLeavesArr =array('594','782'); // 594=special leave, 782=compensated leave
                                     if (in_array($single_spent_leave['leave_type'], $specialLeavesArr))
                                    {
                                        //echo "Don't deduct from total emp leave";
                                    }else{
                                        $grand_total_spant=$grand_total_spant+$single_spent_leave['leave_total_day'];
                                    }
                                     $leave_spent_date .="<u>".$single_spent_leave['leave_start_date']."</u>, ";
                                 }
                                 $available_leave=$emp_total_leave-$total_leave_spent;
                                 $available_leave_grant_total=$emp_total_leave-$grand_total_spant;
                             }   
                             if($total_leave_spent){                            
                                ?>
                                <tr>
                                    <td><?php print $leavetype; ?></td>
                                    <td><?php if($total_leave_spent){ echo $total_leave_spent;} ?></td>
                                    <td><?php if($leave_spent_date){ echo $leave_spent_date;} ?></td>
                                    <!--<td><?php //if($available_leave_grant_total){ echo $available_leave_grant_total;} ?></td>--> 
                                </tr>
                                <?php
                            }
                        } ?>
                    </tbody>
                </table>
                              <?php if($available_leave_grant_total){ ?>
         <div class="row">
             <div class="col-md-12 leave-total-days bg-success " style="color:#FFF">
                <?php 
                echo "<span class='leave-total-days-span'>Total Available Days=".($available_leave_grant_total+$previous_carry_forward_leave_balance)."</span><br>";
                ?>
            </div>
        </div>        
        <?php 
      }
              }?>
                    </div>
                </div>
            </div>
        </div>


 <?php
    $this->load->view('includes/employee-footer');
    ?> 