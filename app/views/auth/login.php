
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HR Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Avant">
    <meta name="author" content="The Red Team">

    <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all"> -->
    <?php
    $this->load->view('includes/cssjs');
    ?> 
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
    <style type="text/css">
.margin-top-50 {
    margin-top: 10px;
}
    </style>
    <!-- <script type="text/javascript" src="assets/js/less.js"></script> -->
</head>
<body class="focusedform">
    <div id="wrapper">
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row header">
                    <div class="col-md-2">
                        <div class="logo">
                            <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="company_name">
                            <h1>Ahmed Amin Group</h1>
                        </div>
                    </div>               
                </div>
                <div class="row under-header-bar">              
                </div> 
                <div class="row login-form">
                    <div class="col-md-7"></div>
                    <div class="col-md-5 login-panel">
                    <div class="row text-center margin-top-50">
                          <h2>Login</h2>
                      </div>
                       				<form action="<?= site_url('auth/login')?>" method="post" class="form-horizontal" style="margin-bottom: 0px !important;">
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
									<input type="text" class="form-control" name="identity" id="identity" placeholder="Email">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
									<input type="password" class="form-control" id="password" name="password" placeholder="Password">
								</div>
							</div>
						</div>
					
		<div class="panel-footer">
			<a href="<?= site_url('auth/forgot_password')?>" class="pull-left btn btn-link" style="padding-left:0">Forgot password?</a>
			
			<div class="pull-right">
				<button type="submit" class="btn btn-primary">Log In</button>
			</div>
		</div>
		</form>                                     
              </div>
          </div>               
          <div class="row">
            <div class="footer">
                <h2>Corporate Head Office</h2>
                House - 25, Road - 34,<br>
                Gulshan - 2, Dhaka - 1212. Bangladesh.<br>
                Phone : +88 02 8812395,9880916,9880916,9881424,9892111.<br>
                Fax : +88-02 8826439<br>
                E-mail : info@ahmedamin.com,misaag@ahmedamin.com<br>
            </div>
        </div>
        <div class="row text-right">
            <p>Developed by: <a href="http://www.muslah.com/" target="_blank">Mosleh</a></p>
        </div>
    </div>
</div>
</div>
<!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->  







      
</body>
</html>