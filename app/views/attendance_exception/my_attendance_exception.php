<?php
$this->load->view('includes/employee-header');

?>
<style>
    .exception_form {
        padding: 10px;
        border: 1px dotted #ccc;
        margin: 5px;
        background-color: #F5F5F5;
        border-radius: 5px
    }

    .label {
        font-weight: bold;
    }
</style>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                <h3 style="text-align:center; padding: 10px;">My Attendance Exception</h3>
       
                <?php
                $msg = $this->session->flashdata('success');
                if ($msg) {
                ?>
                    <br />
                    <div class="alert alert-success text-center">
                        <strong>Success!</strong> <?php echo $msg ?>
                    </div>
                <?php
                }
                $msg = null;
                $this->session->set_flashdata('success', null);
                ?>
                <?php
                $error = $this->session->flashdata('errors');
                if ($error) {
                ?>
                    <br />
                    <div class="alert alert-danger text-center">
                        <strong>ERROR!</strong> <?php echo $error ?>
                    </div>
                <?php
                }
                $error = null;
                $this->session->set_flashdata('errors', null);
                ?>
                <table class="table table-sm" style="width:100%">
                    <thead>
                        <th>Sl No.</th>
                        <th>Attendance Date</th>
                        <th>Type Of Exception</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php foreach($attendance_exceptions as $key => $val){?>
                        <tr>
                            <td><?php echo  $key+1; ?></td>
                            <td><?php echo date("F jS, Y", strtotime($val->attendance_date));  ?></td>
                            <td><?php echo str_replace("_"," ",$val->exception_type); ?></td>
                            <td><?php echo $val->reason; ?></td>
                            <td><?php 
                            if($val->status==1){
                                echo "<span class='badge badge-success'> Approved</span>";
                            }else{
                                echo "<span class='badge badge-secondary'> Pending</span>";
                            } 
                            ?></td>
                            <td style="text-align: center;">
                                <?php if($val->status==0){?>
                                    <a href="<?php echo base_url("my-attendance-exceptions/edit")."/".urlencode(base64_encode($val->id));?>?<?php echo time()."-_+=";?>" class="btn btn-outline-dark">Edit</a>
                                    <a href="<?php echo base_url("my-attendance-exceptions/delete")."/".urlencode(base64_encode($val->id));?>?<?php echo time()."-_+=";?>" class="btn btn-outline-danger"  onclick="return confirm('Do you really want to delete the record?');">Delete</a>
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