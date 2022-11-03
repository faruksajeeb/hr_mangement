
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>resources/images/favicon.ico" type="image/x-icon">
        <title>HRMS | Login</title>
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="resources/font-end/css/bootstrap.min.css" >
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
.loginPanel{
   padding-top:50px;
    height:200px; 
    border:1px solid #CCC;
    color:#FFF;
/*    line-height:200px;
    vertical-align: bottom;*/
    font-weight: bold;
    font-size:36px;
    text-align: center;
    text-decoration: none;
}
        </style>   
    </head>
    <body class="" >
        <div class="wrapper top-div" style="height: 200px;">
            
        </div>
        <div class="container" >
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3"></div>                
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 loginPanel align-middle" style="background: #006666;">
                    <a href="<?php echo base_url();?>admin-login">
                        <div class="row">
                            <div class="col-md-12" style=" height:200px; color:#FFF;">
                                 <p>Admin Login</p>
                            </div>
                        </div>
                    </a>
                   
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 loginPanel align-middle" style="background: #ff6666; ">
                    
                     <a href="<?php echo base_url();?>employee-login">
                        <div class="row">
                            <div class="col-md-12" style=" height:200px; color:#FFF;">
                                 <p>Employee Login</p>
                            </div>
                        </div>
                    </a>
                </div>

                
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3"></div>
            </div>
        </div>
        <div class="wrapper" style="height: 100px;">
            
        </div>

           <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="resources/font-end/js/jquery.3.4.1.min.js" ></script>		
    <script src="resources/font-end/js/popper.min.js" ></script>
    <script src="resources/font-end/js/bootstrap.min.js" ></script>
    </body>
</html>