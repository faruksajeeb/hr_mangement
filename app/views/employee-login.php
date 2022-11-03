
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>resources/images/favicon.ico" type="image/x-icon">
        <title>HRMS | Employee Login</title>
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/font-end/css/bootstrap.min.css" >

        <script type="text/javascript">
            // var macAddress = "";
            // var ipAddress = "";
            // var computerName = "";
            // var wmi = GetObject("winmgmts:{impersonationLevel=impersonate}");
            // e = new Enumerator(wmi.ExecQuery("SELECT * FROM Win32_NetworkAdapterConfiguration WHERE IPEnabled = True"));
            // for(; !e.atEnd(); e.moveNext()) {
            //     var s = e.item(); 
            //     macAddress = s.MACAddress;
            //     alert(unescape(macAddress));
            //     ipAddress = s.IPAddress(0);
            //     computerName = s.DNSHostName;
            // } 
        </script> 
        <style>
         
            @media screen and (max-width: 768px) {
    .top-div {
        display: none;
    }
}
#employeeLoginForm{
    background:#ff6666; padding: 10px; border-radius: 5px;
}
h1{
    text-align:center; font-weight: bold; color:#ff6666;
}

        </style>   
    </head>
    <body class="" >
        <div class="wrapper top-div" style="height: 150px;">
            
        </div>
        <div class="container" >
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"></div>                
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 " >
                    <h1 >Employee Login</h1>
                    <?php
                            if($msg){
                                echo $msg;
                            }
                        ?>
                    <form id="employeeLoginForm" action="<?php echo base_url();?>login/employeeLoginGet"  method="POST">
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Employee ID:</label>
                            <input type="text" class="form-control" id="userName" name="employeeID" id="employeeID" aria-describedby="emailHelp" placeholder="Enter employee id">
                            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password:</label>
                            <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Enter Password">
                        </div>
<!--                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>-->
                        <button type="submit" class="btn btn-block btn-info btn-lg">Submit</button>
                    </form>
                </div>                
               
                    
                
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"></div>
            </div>
        </div>
        <div class="wrapper" style="height: 100px;">
            
        </div>
           <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo base_url(); ?>resources/font-end/js/jquery.3.4.1.min.js" ></script>		
    <script src="<?php echo base_url(); ?>resources/font-end/js/popper.min.js" ></script>
    <script src="<?php echo base_url(); ?>resources/font-end/js/bootstrap.min.js" ></script>
  
    </body>
</html>