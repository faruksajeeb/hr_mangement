 <?php
    $this->load->view('includes/employee-header');
    ?> 
      <style>
          .reset {
            all: revert;
            border: 1px solid #CCC;
        }
      </style>
        <div class="wrapper">
            <div class="container">
                
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
                <div class="row">
                    <div class="col-md-6"  style="margin-top:20px">
                        <fieldset class="reset">
                            <legend class="reset">Earn Leave Info.</legend>
                            <div class="table-responsive">
                                <table id="" class="table" cellspacing="0" width="100%" >
                                    <tr>
                                        <th colspan="2">Previous years earn leave balance</th>
                                        <th><?php echo $earn_leave_info['opening_balance']; ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">This year earn leave</th>
                                        <th><?php echo $earn_leave_info['this_year_earn_leave']; ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Total Earn Leave Balance<span style="font-size:10px">(Previous+This Year)</span></th>
                                        <th><?php echo ($earn_leave_info['opening_balance']+$earn_leave_info['this_year_earn_leave']); ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Encashment This Year</th>
                                        <th><?php echo $earn_leave_info['encashment']; ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Earn Leave Availed This Year</th>
                                        <th><?php echo $earn_leave_info['availed']; ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Balance</th>
                                        <th><?php echo $earn_leave_info['balance']; ?></th>
                                    </tr>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-6"  style="margin-top:20px">
                        <fieldset class="reset">
                            <legend class="reset">Yearly Leave Info.</legend>
                            <table class="table">
                                    <tr>
                                        <td colspan="2">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>Leave Name</th>
                                                    <th>Total</th>
                                                    <th style="color:red">Availed</th>
                                                    <th>Balance</th>
                                                </tr>
                                                <?php
                                                $thisYearAvailed = 0;
                                                $thisYearTotal =0;
                                                $grandTotalLeave=0;
                                                // print_r($allleavetype);
                                                foreach ($allleavetype as $leave_type) {
                                                    $leave_type_id = $leave_type['id'];
                                                    $leave_type_total = 0;
                                                    $leave_availed = 0;

                                                    $report_date = "$report_year-$report_month-01";
                                                    $default_year_first_day = "01-01-$report_year";
                                                    $default_year_last_day = "31-12-$report_year";
                                                    $leave_availed_info = $this->db->query("SELECT SUM(leave_total_day) as TOTAL FROM emp_leave WHERE content_id=$content_id AND leave_type=$leave_type_id AND leave_year=$report_year AND STR_TO_DATE(leave_start_date,'%d-%m-%Y')>=STR_TO_DATE('$default_year_first_day','%d-%m-%Y') AND STR_TO_DATE(leave_end_date,'%d-%m-%Y')<=STR_TO_DATE('$default_year_last_day','%d-%m-%Y') GROUP BY content_id,leave_type")->row('TOTAL');
                                                    if ($leave_availed_info) {
                                                        $leave_availed = $leave_availed_info;
                                                        $specialLeavesArr = array('594', '782'); // 594=special leave, 782=compensated leave
                                                        if (!in_array($leave_type_id, $specialLeavesArr)) {
                                                            //echo "Don't deduct from total emp leave";                                            
                                                            $thisYearAvailed += $leave_availed;
                                                        }
                                                    }
                                                    $leave_number = $this->db->query("SELECT total_days as TOTAL FROM emp_yearly_leave_cat_history WHERE content_id=$content_id AND leave_type=$leave_type_id 
                                                        AND ((start_year<='$report_date' AND end_year='0000-00-00') OR ('$report_date' BETWEEN start_year AND end_year)) ORDER BY id DESC LIMIT 1")->row('TOTAL');
                                                    if ($leave_number) {
                                                        $leave_type_total = $leave_number;
                                                        $thisYearTotal +=$leave_type_total;
                                                    }
                                                    $totalLeave = ($leave_type['name']=='Earned Leave') ? ($earn_leave_info['opening_balance'] + $earn_leave_info['this_year_earn_leave']) : $leave_type_total;
                                                    $balance = $totalLeave-$leave_availed;
                                                    if(($totalLeave==0) && ($leave_availed==0) && ($balance ==0)){
                                                        continue;
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?php echo $leave_type['name']; ?></td>
                                                        <td><?php echo $totalLeave; ?></td>
                                                        <td style="color:red"><?php echo $leave_availed; ?></td>
                                                        <td style="color:green"><?php echo $balance; ?></td>
                                                    </tr>
                                                    <?php 
                                                    $grandTotalLeave += $totalLeave;
                                                } ?>
                                                    <tfoot>
                                                        <th>TOTAL</th>
                                                        <th><?php echo $grandTotalLeave; ?></th>
                                                        <th style="color:red"><?php echo $thisYearAvailed; ?></th>
                                                        <th style="color:green"><?php echo $grandTotalLeave-$thisYearAvailed; ?></th>
                                                    </tfoot>
                                            </table>
                                        </td>
                                    </tr>
                                <tr>
                                    <td colspan="2">
                                        [NOTE: Special Leave, Compensated Leave not deduct from Yearly Leave]
                                    </td>
                                </tr>
                                </table>
                        </fieldset>
                    </div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-12">
                    <table id="" class="table " cellspacing="0" width="100%" >
                        <thead>
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
                                    //$total_leave=$this->emp_leave_model->getemp_yearlyleave($content_id, $tid);
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
                    </div>
                </div>
               
            </div>
        </div>


 <?php
    $this->load->view('includes/employee-footer');
    ?> 