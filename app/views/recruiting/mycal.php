<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendar</title>
    <?php
    $this->load->view('includes/cssjs');
    ?> 
    <script>
        $(document).ready(function(){
                // Setup - add a text input to each footer cell
                $('.calendar .day').click(function(){
                    day_num=  $(this).find('.day_num').html();
                    day_data=prompt('Enter Stuff', $(this).find('.content').html());
                    if(day_data != null){
                        $.ajax({
                            url:window.location,
                            type:'POST',
                            data:{
                                day:day_num,
                                data:day_data
                            },
                            success:function(msg){
                                location.reload();
                            }
                        });
                    }
                });
              

        });
function ConfirmDelete()
{
    var x = confirm("Are you sure you want to delete?");
    if (x)
        return true;
    else
        return false;
}
      
    </script>  
    <style>
    .calendar{
        font-family: Arial;
        font-size: 12px;
    }
    table.calendar{
        margin: auto; 
        border-collapse: collapse;
    }
    .calendar .days td{
        width: 80px;
        height: 80px;
        padding: 4px;
        border: 1px solid #999;
        vertical-align: top;
        background-color: #DEF;
    }
    .calendar .days td:hover{
        background-color: #FFF;
    }
    .calendar .highlight{
        font-weight: bold; 
        color: #00F;
    }
.calendar tbody tr td:nth-child(5n+0) {
    background: #84B3D0;
}    
 tr.days_headng td:nth-child(5) {
    background: #C4DCF0 !important;
}    


    </style>  
</head>
<body class="logged-in dashboard current-page add-division">
    <!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Holiday Master</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                    <br>
                        <?php echo $calendar; ?>
                        </div>
                    </div>              
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->        
    </body>
    </html>