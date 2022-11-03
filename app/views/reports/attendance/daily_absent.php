<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS- Report</title>
    <?php
    $this->load->view('includes/cssjs');
    ?> 
        <script>
    $(document).ready(function(){
        setTimeout(function () {
            // $("#errors").hide("slide", {direction: "up" }, "slow"); 
            $(".alert").hide("slide", {direction: "up"}, "slow");

        }, 10000);
    });
    </script>
	<style>
	.short_info_div .value{font-size:35px; padding-top:10px}
	.short_info_div{
		border:10px solid #FFFFFF;
		border-radius:5px;
		background-color: #fe821e;
		 box-shadow: -2px 2px #CCC;
		padding:30px;
		font-size:30px;
		color:white;
		text-align:center;
		background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.2) 49%, rgba(0, 0, 0, 0.15) 51%, rgba(0, 0, 0, 0.05));
            background-repeat: repeat-x;
	}
	</style>
</head>
<body class="logged-in dashboard">
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
            ?>
            <div class="row under-header-bar">          
            </div> 
            <div class="wrapper">
                <div class="row " style="margin-top:20px">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 col-lg-8 col-sm-8">
					<h3 class="text-center bg-warning" style="padding:20px; background-color:#CCC; color:#FFF"> TODAY'S ABSENT </h3>
					<table class="table table-striped custom-table mb-0">
						<thead>
							<tr>
								<th>SL NO</th>
								<th>Employee Name</th>
								<th>Employee ID</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($today_absent_data as $key => $val):?>
							<tr>
								<td><?php echo $key+1; ?></td>
								<td><?php echo $val->emp_name; ?></td>
								<td><?php echo $val->emp_id; ?></td>
								<th>A</th>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					</div>   
					<div class="col-md-2"></div>					
                </div>
            </div>              
        </div>
    </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->   
</body>
</html>