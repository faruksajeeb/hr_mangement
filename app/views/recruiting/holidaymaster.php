<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS || Holiday Master</title>
    <?php
    $this->load->view('includes/cssjs');
    ?> 
    <script>
        $(document).ready(function(){

        // dialog
        function addholiday() {
            var valid = true;
            var emp_division_tid = $('#emp_division_tid').val(); 
            var emp_department_tid = $('#emp_department_tid').val(); 
            var holiday_category = $('#holiday_category').val(); 
            var holiday_start_date = $('#holiday_start_date').val(); 
            var holiday_end_date = $('#holiday_end_date').val();  
            var comments = $('#comments').val(); 
            var base_url='<?php echo base_url();?>';

            var postData = {
                "emp_division_tid" : emp_division_tid,
                "emp_department_tid" : emp_department_tid,
                "holiday_category" : holiday_category,
                "holiday_start_date" : holiday_start_date,
                "holiday_end_date" : holiday_end_date,
                "comments" : comments,
            };
            //console.log(postData);
            if(emp_division_tid && holiday_category && holiday_start_date && holiday_end_date){ 
                  var strtdate = holiday_start_date.split("-");
                  var enddate = holiday_end_date.split("-");
                  var d1 = new Date(strtdate[2]+"-"+strtdate[1]+"-"+strtdate[0]);
                  var d2 = new Date(enddate[2]+"-"+enddate[1]+"-"+enddate[0]);
                 // console.log(d1+" "+d2);
                 if( d1 <= d2){        
                $.ajax({
                   type: "POST",
                   url: ""+base_url+"holidaymaster/entryholiday",
                   data: postData,
                   dataType:'json',
                   success: function(data){
                    //console.log(data);
                  //  location.reload();
                     window.location.reload(true);
                    //dialog.dialog( "close" );
                }
                });
            }else{
                $('#holiday_end_date').css({"border-color":"red"});
            }
            }else{
                if(!emp_division_tid){
                    alert("Select company please");
                    $('#emp_division_tid').css({"border-color":"red"});
                }
                if(!holiday_category){
                     alert("Select holiday type please.");
                    $('#holiday_category').css({"border-color":"red"});
                }
                if(!holiday_start_date){
                    $('#holiday_start_date').css({"border-color":"red"});
                }
                if(!holiday_end_date){
                    $('#holiday_end_date').css({"border-color":"red"});
                }        
            }
        }
        var dialog, form;
        dialog = $( "#dialog-form" ).dialog({
          autoOpen: false,
          height: "auto",
          width: 500,
          modal: true,
          buttons: {
           // "Add field": addField,
           "Add holiday":     {
             text: "Submit",
             id: "add-holiday-btn",
             click: addholiday   
         },
         Cancel: function() {
          dialog.dialog( "close" );
        }
        },
        position: { my: "center center", at: "center center" },
        close: function() {
            form[ 0 ].reset();
                // allFields.removeClass( "ui-state-error" );
            }
        });

        form = dialog.find( "form" ).on( "submit", function( event ) {
          event.preventDefault();
            //  addField();
        });

        $( ".calendar .day" ).on( "click", function(event) {
            event.preventDefault();
            day_num=  $(this).find('.day_num').html();
            if(day_num){
            var year=  $('tr th[colspan=5]').html();
            var arr = year.split('&nbsp;');
            var dat = new Date('1 ' + arr[0] + ' 1999');
            var month_number=getMonthFromString(arr[0]);
            var month_leangth=month_number.toString().length;
            var day_leangth=day_num.toString().length;
            if(month_leangth==1){
                month_number="0"+month_number;
            }
            if(day_leangth==1){
                day_num="0"+day_num;
            }

            $("#holiday_start_date").val(day_num+"-"+month_number+"-"+arr[1]);
            $("#holiday_end_date").val(day_num+"-"+month_number+"-"+arr[1]);
            var holiday_date=day_num+"-"+month_number+"-"+arr[1];    
            var holiday_type=$(this).find('.content').html();
            var base_url='<?php echo base_url();?>';
            var postData = {
                "holiday_date"    : holiday_date
            };
            if(holiday_type){
                $.ajax({
                 type: "POST",
                 url: ""+base_url+"holidaymaster/getEmployeeholiday",
                 data: postData,
                 dataType:'json',
                 success: function(data){
                    //alert(data);
                    if (data) {
                       $('#holiday_category').val(data.tid);
                       $('#comments').val(data.description);
                   }
               }

           });
           
            }
                dialog.dialog( "open" );
            }

        });
        $( "div.content" ).closest( "td.day" ).css({
            "background-color":"#FA8072",
            "color":"#FFF",
            "font-weight":"bold",
            "font-size":"15px"
        });
        <?php
        
        $sat_off=$emp_holiday['sat_off'];
        $sun_off=$emp_holiday['sun_off'];
        $mon_off=$emp_holiday['mon_off'];
        $tue_off=$emp_holiday['tue_off'];
        $wed_off=$emp_holiday['wed_off'];
        $thus_off=$emp_holiday['thus_off'];
        $fri_off=$emp_holiday['fri_off'];
        if($sat_off=='off'){
            echo '$( ".calendar tbody tr td:nth-child(1)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
        }
        if($sun_off=='off'){
            echo '$( ".calendar tbody tr td:nth-child(2)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
        }
        
        if($mon_off=='off'){
            echo '$( ".calendar tbody tr td:nth-child(3)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
        }
        if($tue_off=='off'){
            echo '$( ".calendar tbody tr td:nth-child(4)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
        }
        if($wed_off=='off'){
            echo '$( ".calendar tbody tr td:nth-child(5)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
        }
        if($thus_off=='off'){
            echo '$( ".calendar tbody tr td:nth-child(6)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
        }
        if($fri_off=='off'){
            echo '$( ".calendar tbody tr td:nth-child(7)" ).closest( "td.day" ).css( "background-color", "#FFA07A" );';
        }
        
        ?>
        function getMonthFromString(mon){
            var d = Date.parse(mon + "1, 2012");
            if(!isNaN(d)){
             return new Date(d).getMonth() + 1;
            }
            return -1;
        }
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        // diolog
        //end
        //$.noConflict(); 
});
 //Not to conflict with other scripts
 jQuery(document).ready(function($) {
    $( ".ddatepicker" ).datepicker({ 
        dateFormat:"dd-mm-yy"
    });

    $( "#emp_division" ).change(function(e) {
            var division_tid = $(this).val(); 
            var base_url='<?php echo base_url();?>';
            var postData = {
                "division_tid" : division_tid
            };
         $.ajax({
          type: "POST",
          url: ""+base_url+"holidaymaster/getdepartmentidbydivisionid",
          data: postData,
          dataType:'json',
          success: function(data){
            //alert(data);
            //location.reload();   
             window.location.reload(true);
          }
        });
     });
     
     $( "#emp_department" ).change(function(e) {
        var department_tid = $(this).val(); 
        var division_tid = $("#emp_division").val(); 
        var base_url='<?php echo base_url();?>';
        var postData = {
             "division_tid" : division_tid,
             "department_tid" : department_tid
        };
        $.ajax({
            type: "POST",
            url: ""+base_url+"holidaymaster/getEmpIdByDepartmenTid",
            data: postData,
            dataType:'json',
            success: function(data){
               window.location.reload(true);  
           }
       });
    });
    $("#emp_division_tid").change(function (e) {
                    var division_tid = $(this).val();
                    var base_url = '<?php echo base_url(); ?>';
                    var postData = {
                        "division_tid": division_tid
                    };
                    $.ajax({
                        type: "POST",
                        url: "" + base_url + "addprofile/getdepartmentidbydivisionid",
                        data: postData,
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            var options = "";
                            options += '<option value="">All</option>';
                            $(data).each(function (index, item) {
                                options += '<option value="' + item.tid + '">' + item.name + '</option>';
                            });
                            $('#emp_department_tid').html(options);
                        }
                    });
                   
                });
//     $( "#emp_name" ).change(function(e) {
//        var emp_code = $(this).val(); 
//        var base_url='<?php echo base_url();?>';
//        var postData = {
//         "emp_code" : emp_code
//     };
//     $.ajax({
//      type: "POST",
//      url: ""+base_url+"holidaymaster/getdivisionidbyempid",
//      data: postData,
//      dataType:'json',
//      success: function(data){
//          location.reload();

//      }
//  });
// });
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
        padding: 10px;
        border: 1px solid #FFF;
        border-style: groove;
        vertical-align: top;
        background-color: #FFE4B5;
    }
    .calendar .days td:hover{
        background-color: #FFF;
    }
    .calendar .highlight{
        font-weight: bold; 
        color: #00F;
    }
/*    .calendar tbody tr td:nth-child(5n+0) {
        background: #84B3D0;
    }*/ 
tr.days_headng td{
        background: #FFE4B5 ;
        font-weight: bold;
    }
    tr.days_headng td:nth-child(7) {
        background: #FFDAB9 !important;
        
    }
    tr.days td:nth-child(7) {
        background: #FFDAB9 ;
    }

    .ui-dialog-buttonset button{
        width: initial;
    }
    select option {
    
    
    border-bottom:1px solid #FFF;
    /*font-weight: bold;*/
    /*padding:5px;*/
}
</style>  
</head>
<body class="logged-in dashboard current-page add-division">
    <!-- Page Content -->  

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            echo load_css("jquery-ui.css");
            echo load_js("jquery-ui.js");
            $this -> load -> view('includes/menu');
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Holiday Master</h4>         
            </div> 
            <div class="wrapper">
                <br/>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-2 bgcolor_D8D8D8">Company : </div>
                            <div class="col-md-4">
                                <select name="emp_division" id="emp_division" class="form-control">
                                    <?php 
                                     if($user_type_id !=1){
                                        echo '<option value="'.$alldivision['tid'].'" selected="selected" data-id="'.$alldivision['weight'].'">'.$alldivision['name'].'</option>';
                                     }else{
                                        echo '<option value="">All</option>';
                                        foreach ($alldivision as $single_division) {
                                            if($default_division==$single_division['tid']){
                                                echo '<option value="'.$single_division['tid'].'" selected="selected" data-id="'.$single_division['weight'].'">'.$single_division['name'].'</option>';
                                            }else{
                                                echo '<option value="'.$single_division['tid'].'" data-id="'.$single_division['weight'].'">'.$single_division['name'].'</option>';
                                            }
                                        } 
                                    }
                                    ?>                                                        
                                </select>         
                            </div>
                            <div class="col-md-1 bgcolor_D8D8D8">Division : </div>
                            <div class="col-md-4">
                                <select name="emp_department" id="emp_department" class="form-control">
                                    <option value="">all</option>
                                    <?php foreach ($alldepartment as $single_department) {
                                        if($default_department==$single_department['tid']){
                                            echo '<option value="'.$single_department['tid'].'" selected="selected">'.$single_department['name'].'</option>';
                                        }else{
                                            echo '<option value="'.$single_department['tid'].'">'.$single_department['name'].'</option>';
                                        }
                                    } ?>
                                </select>         
                            </div>
                        </div>
                                           
<!--                        <div class="row">
                            <div class="col-md-4 bgcolor_D8D8D8">Employee Code</div>
                            <div class="col-md-8"><input type="text" name="emp_id" id="emp_id" title="Press CTRL+B after typing Emp id or select Emp Name" placeholder="Press CTRL+B after typing Emp id or select Emp Name" autocomplete="off" value="<?php if($default_emp['emp_id']){ echo $default_emp['emp_id'];} ?>"/></div>
                        </div>  -->                                                 
<!--                         <div class="row">
                            <div class="col-md-4 bgcolor_D8D8D8">Name</div>
                            <div class="col-md-8">
                                <select name="emp_name" id="emp_name">
                                    <option value="">Select</option>
                                    <?php foreach ($allemployee as $single_employee) {
                                        $default_emp_id=$default_emp['emp_id'];
                                        $content_id=$single_employee['content_id'];
                                        $emp_id=$single_employee['emp_id'];
                                        $emp_name=$single_employee['emp_name'];
                                        if($default_emp_code==$emp_id){
                                            print '<option value="'.$emp_id.'" selected="selected">'.$emp_name.'</option>';
                                        }else{
                                            print '<option value="'.$emp_id.'">'.$emp_name.'</option>';
                                        }

                                    } ?>

                                </select>
                            </div>
                        </div> -->                    
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                         <?php print_r($emp_holiday);  ?>
                        <br>
                        <?php echo $calendar; ?>
                        <br>
                        <br>
                    </div>
                </div> 
<!--                 <div class="row">
                    <div class="col-md-12">
                        <?php 
                        if($content_id){
                            ?>
                            <table id="example" class="display" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr class="heading">
                                        <th>holiday Type</th>
                                        <th>Total Days</th>
                                        <th>Spent holiday</th>
                                        <th>Available</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $casual_holiday=$emp_holiday['casual_holiday'];
                                    $annual_holiday=$emp_holiday['annual_holiday'];
                                    $maternity_holiday=$emp_holiday['maternity_holiday'];
                                    $paternity_holiday=$emp_holiday['paternity_holiday'];
                                    $medical_holiday=$emp_holiday['medical_holiday'];
                                    $compassionate_holiday=$emp_holiday['compassionate_holiday'];
                                    $holiday_without_pay=$emp_holiday['holiday_without_pay'];
                                    foreach ($allholidaytype as $single_holiday) {
                                        $id = $single_holiday['id'];
                                        $holidaytype = $single_holiday['name'];
                                        $vid = $single_holiday['vid'];
                                        $tid = $single_holiday['tid'];
                                        $description = $single_holiday['description'];
                                        if($defaultcontent_id){
                                            $total_holiday=$this->emp_holiday_model->getemp_yearlyholiday($defaultcontent_id, $tid);
                                            date_default_timezone_set('Asia/Dhaka');
                                            $servertime = time();
                                            $holiday_year = date("Y", $servertime); 
                                            $total_holiday_spent_query=$this->emp_holiday_model->getemp_spentholiday($defaultcontent_id, $tid, $holiday_year);
                                            $total_holiday_spent=0;
                                            foreach ($total_holiday_spent_query as $single_spent_holiday) {
                                               $total_holiday_spent=$total_holiday_spent+$single_spent_holiday['holiday_total_day'];
                                           }
                                           $available_holiday=$total_holiday['total_days']-$total_holiday_spent;
                                       }   
                                       if($total_holiday['total_days'] || $total_holiday_spent){                            
                                        ?>
                                        <tr>
                                            <td><?php print $holidaytype; ?></td>
                                            <td><?php if($total_holiday){ echo $total_holiday['total_days'];} ?></td>
                                            <td><?php if($total_holiday_spent){ echo $total_holiday_spent;} ?></td>
                                            <td><?php if($available_holiday){ echo $available_holiday;} ?></td>
                                        </tr>
                                        <?php
                                    }
                                } ?>
                            </tbody>
                        </table>  
                        <?php } ?>
                        <br>
                        <br>
                    </div>
                </div> -->
                <div id="dialog-form" title="Add Holiday">
                  <p class="validateTips"></p>
                <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Company : </label>
                    <div class="col-sm-9">
                      <select name="emp_division_tid" id="emp_division_tid" class="form-control">
                                    <option value="">--select company--</option>
                                    <option value="all">All</option>
                                    <?php foreach ($alldivision as $single_division) {
                                        if($default_division==$single_division['tid']){
                                            echo '<option value="'.$single_division['tid'].'" selected="selected">'.$single_division['name'].'</option>';
                                        }else{
                                            echo '<option value="'.$single_division['tid'].'">'.$single_division['name'].'</option>';
                                        }
                                    } ?>
                                                                 
                                </select> 
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="colFormLabel" class="col-sm-3 col-form-label">Division : </label>
                    <div class="col-sm-9">
                      <select name="emp_department_tid" id="emp_department_tid" class="form-control form-control-lg" id="colFormLabelLg">
                                    <option value="">all</option>
                                    
                                    <?php
                                    if(!$department_selected){
                                        foreach ($alldepartment as $single_department) {
                                        if($default_department==$single_department['tid']){
                                            echo '<option value="'.$single_department['tid'].'" selected="selected">'.$single_department['name'].'</option>';
                                        }else{
                                            echo '<option value="'.$single_department['tid'].'">'.$single_department['name'].'</option>';
                                        }
                                    }}else{
                                    foreach ($department_selected as $single_department) {
                                        
                                            echo '<option value="' . $single_department['tid'] . '">' . $single_department['name'] . '</option>';
                                        
                                    }
                                    }   
                                    ?>
                                                                 
                                </select> 
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-3 col-form-label col-form-label-lg">Holiday Type : </label>
                    <div class="col-sm-9">
                      <select name="holiday_category" id="holiday_category" class="select ui-widget-content ui-corner-all form-control form-control-lg" class="" >
                            <option value="">Select</option>
                            <?php foreach ($allholidaytype as $single_holidaytype) {
                                $id = $single_holidaytype['id'];
                                $holidaytype = $single_holidaytype['name'];
                                $vid = $single_holidaytype['vid'];
                                $tid = $single_holidaytype['tid'];
                                $description = $single_holidaytype['description'];
                                ?>
                                <option value="<?php print $tid; ?>"><?php print $holidaytype; ?></option>
                                <?php } ?>
                                <option value="cancel_holiday">Cancel Holiday</option>
                            </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Holiday Start Date</label>
                    <div class="col-sm-9">
                      <input type="text" name="holiday_start_date" class="ddatepicker numbersOnly form-control form-control-sm" id="holiday_start_date" class="text ui-widget-content ui-corner-all"> 
                            
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Holiday End Date</label>
                    <div class="col-sm-9">
                      <input type="text" name="holiday_end_date" class="ddatepicker numbersOnly form-control form-control-sm" id="holiday_end_date" class="text ui-widget-content ui-corner-all">                       
                               
                    </div>
                  </div>
                  <form>
                    <fieldset>                              
                <label for="comments">Comments</label>
                            <textarea name="comments" id="comments" cols="10" rows="5" class="text ui-widget-content ui-corner-all"></textarea>
                            <!-- <input type="text" name="comments" id="comments" class="text ui-widget-content ui-corner-all"> -->                                                                           
                            <!-- Allow form submission with keyboard without duplicating the dialog button -->
                            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                        </fieldset>
                    </form>
                </div>                                 
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->        
</body>
</html>