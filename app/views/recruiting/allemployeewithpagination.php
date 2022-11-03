<html> 
    <head> 
        <meta charset="utf-8">
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS- Employee List</title> 
        <?php 
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        $user_division = $this->session->userdata('user_division');
        $user_department = $this->session->userdata('user_department');
        
        $view_salary_in_emp_list= $this->users_model->getuserwisepermission("view_salary_in_emp_list",$user_id);
        $view_employee_profile=$this->users_model->getuserwisepermission("view_employee_profile", $user_id);
        $view_employee_mobile_number = $this->users_model->getuserwisepermission("view_employee_mobile_number",$user_id);
        $view_employee_email_address = $this->users_model->getuserwisepermission("view_employee_email_address",$user_id);
        $view_employee_age = $this->users_model->getuserwisepermission("view_employee_age",$user_id);
        $view_employee_date_of_birth = $this->users_model->getuserwisepermission("view_employee_date_of_birth",$user_id);
        
     
        $add_edit_profile= $this->users_model->userpermission("add_edit_profile", $user_type);
        $this->load->view('includes/cssjs');
        $start = microtime(true);

        ?>
                  <!--chosen--> 
         <link rel="stylesheet" href="<?php echo base_url();?>resources/plugins/chosenSelect/chosen.css">
                <!-- XEditable -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.css">
       
          <style>
             .ui-dialog { z-index: 9999 !important ;
   
             }
         </style>
           <script src="<?php echo base_url();?>plugins/export/tableToExcel.js">

               
           </script>
        <script type="text/javascript">
             $(function() {
                 
                                 $('.employee_status').editable({
                            prepend: "-- select status --",
                            showbuttons: false,                            
                            source: [
                 
                                             {
                                                value: 1,
                                                text: "Unlock"
                                            }, {
                                                value: 0,
                                                text: "Locked"
                                            },    
                                                         
                            ]
                   });
                // setTimeout() function will be fired after page is loaded
                // it will wait for 5 sec. and then will fire
                // $("#successMessage").hide() function
                setTimeout(function() {
                    $("#successMessage").hide('blind', {}, 500)
                    }, 5000);
            });                                                                             
            $(document).ready(function () {

                 $('.datePic').datepicker({ dateFormat: 'dd-mm-yy' });
                 $('#myFormmultiple').on('submit',function(e) {
                    var task_val=$('#multiple_task').val();
                    if(task_val=="update_shift_history_for_selected" || task_val=='Download Selected Employee List' 
                            || task_val=="terminated_selected" || task_val=="left_selected" || 
                            task_val=="Update Total Leave For Selected"){
                        var checkValues = $('.sub_chk:checked').map(function ()
                        {
                            return $(this).val();
                        }).get();
                        console.log(checkValues);
                        $.each(checkValues, function (i, val) {
                            $("#" + val).remove();
                        });
//                    return  false;
                        if (checkValues.length === 0) //tell you if the array is empty
                        {
                            alert("Please Select your desired employee");
                            return false;
                        } else {
                            
                        }
                    }
                      if(task_val == "Download All Employee List" || task_val == "Download Selected Employee List" || task_val=="download_emp_list_excel" || task_val=="print_emp_list"){
                          $(this).attr('target', '_blank');
                      }else if(task_val=='update_shift_history_for_all' || task_val=='update_shift_history_for_selected'){ 
                         var emp_job_change_date=$('#emp_job_change_date2').val();
                         if(emp_job_change_date==''){
                            alert("Please enter effected date");                          
                                $('#emp_job_change_date2').focus().css("border", '1px solid red');
                          return false;
                        }else{
                            return true;
                        }
                      }else if(task_val=='Update Total Leave For All' || task_val=='Update Total Leave For Selected'){
                          var emp_job_change_date=$('#emp_job_change_date').val();
                          var total_leave=$('#annual_leave_total').val();
                         if(emp_job_change_date=='' & total_leave==''){
                            alert("Please fill out this field.");             
                                $("#emp_job_change_date").focus().css("border", '1px solid red');
                                $('#annual_leave_total').focus().css("border", '1px solid red');
                          return false;
                        }else if(emp_job_change_date!='' & total_leave==''){
                            alert("Please fill out total leave field."); 
                                $('#annual_leave_total').focus().css("border", '1px solid red');
                           
                          return false;
                        }else if(emp_job_change_date=='' & total_leave!=''){
                            alert("Please fill out effective date field."); 
                                $('#emp_job_change_date').focus().css("border", '1px solid red');                           
                          return false;
                        }else{
                            return true;
                        }
                      }else if(task_val=="terminated_selected" || task_val=="left_selected"){
                          var effective_date=$('#effective_date').val();
                          if(effective_date==''){
                            alert("Please select effective date.");             
                                $("#effective_date").focus().css("border", '1px solid red');
                          return false;
                        }
                      }
                      $( "#myFormmultiple" ).submit();
                });
                $('#example').dataTable({
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    //paging: false,
                    paging: true, //changed by sajeeb
                    "autoWidth": false,
                    //"searching": false,
                    "info": false,
                    //"aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,10 ] }  ]
                });
               /* 
                //multiple terminate/ restore......................................................................
                resetcheckbox();
                function  resetcheckbox() {
                    $('input:checkbox').each(function () { //loop through each checkbox
                        this.checked = false; //deselect all checkboxes with class "checkbox1"
                    });
                }
                $('#terminate_all').css("visibility","hidden");
                $('#resign_all').css("visibility","hidden");
                $("#resign_all").on('click', function (e) {
                    e.preventDefault();
                    if (confirm("Are you sure these employee have left?"))
                    {
                        var checkValues = $('.sub_chk:checked').map(function ()
                        {
                            return $(this).val();
                        }).get();
                        console.log(checkValues);
                        $.each(checkValues, function (i, val) {
                            $("#" + val).remove();
                        });
//                    return  false;
                        if (checkValues.length === 0) //tell you if the array is empty
                        {
                            alert("Please Select atleast one checkbox");
                        } else {
                            if (confirm("Left/ Resign these employee.")) {
                                //alert(checkValues);
                                $.ajax({
                                    url: '<?php echo base_url(); ?>commoncontroller/multiple_resign_employee',
                                    type: 'post',
                                    data: 'content_id=' + checkValues
                                }).done(function (data) {
                                    $("#respose").html(data);
                                    $('#check_all').attr('checked', false);
                                    window.location.reload();

                                });
                            } else {
                                return false;
                            }
                        }

                    } else {
                        return false;
                    }
                });
                $("#terminate_all").on('click', function (e) {
                    e.preventDefault();
                    if (confirm("Are you sure these employee have terminated?"))
                    {
                        var checkValues = $('.sub_chk:checked').map(function ()
                        {
                            return $(this).val();
                        }).get();
                        console.log(checkValues);
                        $.each(checkValues, function (i, val) {
                            $("#" + val).remove();
                        });
//                    return  false;
                        if (checkValues.length === 0) //tell you if the array is empty
                        {
                            alert("Please Select atleast one checkbox");
                        } else {
                            if (confirm("Terminated these employee.")) {
                                //alert(checkValues);
                                $.ajax({
                                    url: '<?php echo base_url(); ?>commoncontroller/multiple_terminate_employee',
                                    type: 'post',
                                    data: 'content_id=' + checkValues
                                }).done(function (data) {
                                    $("#respose").html(data);
                                    $('#check_all').attr('checked', false);
                                    window.location.reload();

                                });
                            } else {
                                return false;
                            }
                        }

                    } else {
                        return false;
                    }
                });
                */
/*
                jQuery("#applicant_per_page").change(function (e) {
                    var applicant_per_page = $(this).val();
                    var search_page = "contentwithpagination";
                    if (!applicant_per_page) {
                        applicant_per_page = 12;
                    }
                    var base_url = '<?php echo base_url(); ?>';
                    var postData = {
                        "applicant_per_page": applicant_per_page,
                        "search_page": search_page                         
                    };
 
                    $.ajax({
                        type: "POST",
                        url: "" + base_url + "findemployeelist/insertItemperpage",
                        data: postData,
                        dataType: 'json',
                        success: function (data) {
                             $(data).each(function (index, item) {
                                //console.log(data);
                                if (item.per_page == 1000) {
                                    window.location.href = "" + base_url + "findemployeelist/contentwithpagination";
                               } else{

                                    //window.location.reload();
                                     window.location.reload(true);
                                }                                
                             });
                        }

                    });
                }); 
           */  
            $( "#emp_division" ).change(function(e) {
                var division_tid = $(this).val(); 
                var base_url='<?php echo base_url();?>';
                var postData = {
                    "division_tid" : division_tid
                };
                $.ajax({
                    type: "POST",
                    url: ""+base_url+"addprofile/getdepartmentidbydivisionid",
                    data: postData,
                    dataType:'json',
                    success: function(data){
                // console.log(data);
                var options="";
                options += '<option value="">Select Division</option>';
                $(data).each(function(index, item) {
                    options += '<option value="' + item.tid + '">' + item.name + '</option>'; 
                });
                $('#emp_department').html(options);    
            }
            });
            });

            $("#multiple_task").change(function(e){
                var multiple_task_val = $(this).val(); 
                if(multiple_task_val=="Update Total Leave For All" || multiple_task_val=="Update Total Leave For Selected"){
                    $(".total_leave_text").show();
                    $("#edit_shift_history_area").hide();
                    $(".left_terminated_area").hide();
                    $('.download_date').hide();
                }else if(multiple_task_val=='update_shift_history_for_all' || multiple_task_val=='update_shift_history_for_selected'){
                    $("#edit_shift_history_area").show();
                    $(".total_leave_text").hide();
                    $(".left_terminated_area").hide();
                    $('.download_date').hide();
                }else if(multiple_task_val=='terminated_selected'){
                    $(".left_terminated_area").show();
                    $("#edit_shift_history_area").hide();
                    $(".total_leave_text").hide();
                    $('.download_date').hide();
                }else if(multiple_task_val=='left_selected'){
                    $(".left_terminated_area").show();
                    $("#edit_shift_history_area").hide();
                    $(".total_leave_text").hide();
                    $('.download_date').hide();
                }else if(multiple_task_val=='download_emp_list_excel'){
                    $(".total_leave_text").hide();
                    $("#edit_shift_history_area").hide();
                    $(".left_terminated_area").hide();
                    $('.download_date').show();
                }else{
                    $(".total_leave_text").hide();
                    $("#edit_shift_history_area").hide();
                    $(".left_terminated_area").hide();
                    $('.download_date').hide();
                }
            });
        // multipe delete ---------------------------------------------------------------
        $("#submit_task").on('click', function (e) {
                var multiple_task_val = $(this).val(); 
                if(multiple_task_val=='update_shift_history_for_all'){
                    var emp_job_change_date = $('#emp_job_change_date').val(); 
                    if(emp_job_change_date==''){
                        alert(0);
                    }
                    
                }
                else if(multiple_task_val=='terminated_selected' || multiple_task_val=='left_selected'){
                var checkValues = $('.sub_chk:checked').map(function ()
                {
                    return $(this).val();
                }).get();
                console.log(checkValues);
                $.each(checkValues, function (i, val) {
                    $("#" + val).remove();
                });
//                    return  false;

                if (checkValues.length === 0) //tell you if the array is empty
                {
                    alert("Please Select atleast one employee");
                     return false;
                } else {
                    
                        return true;
                    
                }
            }

          
        });
// edit pay roll ------------------------------------------------

//$('.edit_payroll').click(function () {
    $('#example').on('click', 'a', function () {
        $('#emp_salary_increment').attr('checked', false); // Unchecks it
        $("#increment_area").hide();
        $('#emp_gross_salary').attr('readonly', 'readonly');
        $("#payroll_edit_btn").attr("disabled", "disabled");
        $('#deduction_area').find('input').attr('readonly', 'readonly').css("background-color","#F0E68C");
        $('#salary_area').find('input').attr('readonly', 'readonly').css("background-color","#F0E68C");
        $('#payment_area').find('input,select').attr('readonly', 'readonly').css("background-color","#F0E68C");
        
        document.getElementById("payroll-form").reset();
    //    alert(0);
    //    alert($(this).attr('href'));
         $('#content_id').val($(this).data('content_id'));
        
         var gross_salary=$(this).data('gross_salary');
         var basic_salary=gross_salary*50/100;
         var house_rent=basic_salary*60/100;
         var medical_allow=basic_salary*20/100;
         var transport_allow=basic_salary*10/100;
         var other_allow=basic_salary*10/100;
         var festival_bonus=50;
         var total_benifit=parseInt(house_rent)+parseInt(medical_allow)+parseInt(transport_allow)+parseInt(other_allow);
         
         // $('#basic_salary').val($(this).data('basic_salary'));
         $('#emp_basic_salary').val(basic_salary);
         // $('#house_rent').val($(this).data('house_rent'));
         $('#emp_house_rent').val(house_rent);
         $('#emp_medical_allowance').val(medical_allow);
        // $('#conveyance_allow').val($(this).data('conveyance_allow'));
        var tel_allow=$(this).data('tel_allow');
//        alert(tel_allow);
        if(!tel_allow){
            tel_allow= 0;
        }
        var provident_fund_deduction=$(this).data('provident_fund_deduction');
        if(!provident_fund_deduction){
            provident_fund_deduction= 0;
        }
        var tax_deduction=$(this).data('tax_deduction');
        if(!tax_deduction){
            tax_deduction= 0;
        }
        var other_deduction=$(this).data('other_deduction');
        if(!other_deduction){
            other_deduction= 0;
        }
        var total_deduction=$(this).data('total_deduction');
        if(!total_deduction){
            total_deduction= 0;
        }
         $('#emp_telephone_allowance').val(tel_allow);
        // $('#special_allowa').val($(this).data('special_allowa'));
       //  $('#provident_allow').val($(this).data('provident_allow'));
         $('#emp_transport_allowance').val(transport_allow);
         $('#emp_other_allowance').val(other_allow);
        // $('#performance_bonus').val($(this).data('performance_bonus'));
         $('#emp_festival_bonus').val(festival_bonus);
         $('#emp_total_benifit').val(total_benifit);
    //     $('#increment_amount').val($(this).data('increment_amount'));
    //     $('#increment_percentage').val($(this).data('increment_percentage'));
    //     $('#increment_date').val($(this).data('increment_date'));
         $('#emp_gross_salary').val(gross_salary);
         $('#present_salary').val($(this).data('gross_salary'));
         $('#emp_yearly_paid').val($(this).data('yearly_paid'));
         $('#emp_provident_fund_deduction').val($(this).data('provident_fund_deduction'));
         $('#emp_tax_deduction').val($(this).data('tax_deduction'));
         $('#emp_other_deduction').val($(this).data('other_deduction'));
         $('#emp_total_deduction').val($(this).data('total_deduction'));
         $('#emp_bank').val($(this).data('bank_name'));
         $('#emp_bank_branch').val($(this).data('emp_bank_branch'));
         $('#emp_bank_account').val($(this).data('emp_bank_account'));
         $('#emp_pay_type').val($(this).data('emp_pay_type'));
    });
    var dialog, form;
	dialog = $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: "auto",
		width: "auto",
		modal: true,
        position: {
            my: "center",
            at: "center",
            of: $('#salary_history')
         },
		Cancel: function() {
			dialog.dialog( "close" );
		},
	});

    $('#salary_history').click(function(){
		//	alert(0);
          var id =  $('#content_id').val();
         // alert(id);
         // dialog.dialog( "open" );
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>salary/detail_salary_info_by_id",
            data: {id: id},
            dataType: "html",
            cache: false,
            success: function (data) {
              // alert(data);
                $("#dialog-form").html(data);
                dialog.dialog( "open" );

            }, error: function (){
                alert('ERROR!');
            }
        });
	});

    // end edit payroll ------------------------------
    
        // Scroll to top after search ---------------------------------
        $("#search_button").click(function() {
            $('html, body').animate({
                scrollTop: $("#list").offset().top
            }, 2000);
        });
         // Setup - add a text input to each footer cell
        $('#example tfoot th').each(function () {
            var title = $('#example thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="Search" />');
        });
        // select all checkbox in tables
        $('#check_all').click(function () {
            var checked_status = this.checked;
            $(this).closest('table').find('input:checkbox').each(function () {
                if(checked_status){
                    this.checked=true;
                  $('#resign_all').css("visibility","visible");
                 $('#terminate_all').css("visibility","visible");
             }else{
                 this.checked=false;
                 $('#resign_all').css("visibility","hidden");
                 $('#terminate_all').css("visibility","hidden");
             }
            });
        });
        $('.sub_chk').click(function () {
            if($(".sub_chk:checked").length >=1 &&  $('.sub_chk').is(":checked") == true){
                 //$('#del_all').show();
                 $('#resign_all').css("visibility","visible");
                 $('#terminate_all').css("visibility","visible");
            } else {
                 //$('#del_all').hide(); 
                 $('#resign_all').css("visibility","hidden");
                 $('#terminate_all').css("visibility","hidden");
            }
        });

        <?php 
            if($user_type_id==1)
            { 
        ?>
        //resign by dialog...................................................................................................
        /*
        $('#resignation_form').dialog({
            autoOpen: false,
            height: "auto",
            width: "auto",
            modal: true,
            cache: false,
            position: { my: "center center", at: "center top" },
            buttons: {
                'Save': function () {
                            var content_id=$(".resign").val();
                            var resignation_date = $("#resignation_date").val();
                            var resignation_reason = $("#resignation_reason").val();
                           
                           //alert(content_id);
                            if (resignation_date == '') {
                                alert('Please enter resignation date');
                                 $( "#resignation_date" ).focus().css('border','1px solid red');
                            }else if (resignation_reason == '') {
                                alert('Please enter resignation reason');
                                 $( "#resignation_reason" ).focus().css('border','1px solid red');
                            }else {
                                //alert(content_id);
                                if(confirm('Are you sure you want to resign this employee?')){                            
                                    $.ajax({
                                    url: '<?php echo base_url(); ?>commoncontroller/resignation_employee',
                                    type: 'post',
                                    data: {
                                        content_id:content_id,
                                        resign_date: resignation_date,
                                        resign_reason: resignation_reason                                        
                                    }
                                }).done(function (data) {
                                    alert('Resigned successfully!');
                                    window.location.reload();
                                }).error(function(data) {
                                   alert("some error");
                                });
                         
                                }else{
                                    return false;
                                }

                            }
                        },
                        "Cancel": function () {
                            $(this).dialog("close");
                            //  location = '<?php //echo base_url(); ?>welcome/supplier_info';
                        }


            }

        });
        $('.resign').click(function () {
                    $("#resignation_form").dialog('open');
                     $('#employee_name').val( $(this).attr('content_name')); 
                     //alert($(this).attr('content_name'));
        });
        */
    //terminated by dialog.............................................................................
    /*
    $('#termination_form').dialog({
            autoOpen: false,
            height: "auto",
            width: "auto",
            modal: true,
            cache: false,
            position: { my: "center center", at: "center top" },
            buttons: {
                'Save': function () {
                            var cont_id=$("#terminate_id").val();
                            var termination_date = $("#terminated_date").val();
                            var termination_reason = $("#terminated_reason").val();
                           // alert(content_id);
                            if (termination_date == '') {
                                alert('Please enter termination date');
                                 $( "#terminated_date" ).focus().css('border','1px solid red');
                            }else if (termination_reason == '') {
                                alert('Please enter termination reason');
                                 $( "#terminated_reason" ).focus().css('border','1px solid red');
                            } else {
                              //alert(termination_reason);
                                if(confirm('Are you sure you want to terminated this employee?')){                            
                                    $.ajax({
                                    url: '<?php echo base_url(); ?>commoncontroller/termination_employee',
                                    type: 'post',
                                    data: {
                                        cont_id:cont_id,
                                        terminate_date: termination_date,
                                        terminate_reason: termination_reason                                        
                                    }
                                }).done(function (data) {
                                    alert('Terminated successfully!');
                                    window.location.reload();

                                });
                         
                                }else{
                                    return false;
                                }

                            }
                        },
                        "Cancel": function () {
                            $(this).dialog("close");
                            //  location = '<?php //echo base_url(); ?>welcome/supplier_info';
                        }


            }

        });
        $('.terminate').click(function () {
            $("#termination_form").dialog('open');
            $('#ter_employee_name').val( $(this).attr('ter_content_name'));
        });
        */
        <?php } ?>
});

 
    function ConfirmDelete()
    {
        var x = confirm("Are you sure you want to delete?");
        if (x)
            return true;
        else
            return false;
    } 
    function ConfirmDeactive()
    {
        var x = confirm("Are you sure you want to deactive this employee?");
        if (x)
            return true;
        else
            return false;
    } 
    function ConfirmLeft()
    {
        var x = confirm("Are you sure this employee has left?");
        if (x)
            return true;
        else
            return false;
    }
    function ConfirmTerminated()
    {
        var x = confirm("Are you sure you want to terminated this employee?");
        if (x)
            return true;
        else
            return false;
    }          
  

</script> 
        
<style>
            .container-fluid {
                width: 100%;
            }
            #search_button {
              width: 100%;
              margin-top: 15px;
            }
                        .chosen-container.chosen-container-single {
    width: 100% !important; /* or any value that fits your needs */
}
.multiple_task_type {
    border-bottom: 1px solid #000;
}
        
</style>   
    </head>
    <body>
<!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
        $searchpage="contentwithpagination";
        $per_page_query = $this->search_field_emp_model->getsearchQuery($searchpage);  
        if($this->session->flashdata('success')){
            ?>
              <div class="alert alert-block alert-success colo-md-8" id="successMessage">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading"><i class="fa fa-check-square-o"></i> <?php   echo  $this->session->flashdata('success');  ?></h4>

                    </div>
            <?php }?>
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>findemployeelist/contentwithpagination#list" method="post" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default" style="margin-top: 15px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Search by Multiple Options</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- sfsaf -->
                                            <div class="row">
                                                <div class="col-md-4">Company Name:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_division" id="emp_division">
                                                    
                                                    <?php 
                                                 if(($user_type_id !=1)){
                                                        if($user_id == 16 || $user_id == 36 || $user_type_id==10){
                                                            echo '<option value="">Select Company</option>';
                                                            foreach ($alldivision as $single_division) {
                                                                  if($emp_division==$single_division['tid']){
                                                                    echo '<option value="'.$single_division['tid'].'" selected="selected">'.$single_division['name'].'</option>';
                                                                  }else{
                                                                    echo '<option value="'.$single_division['tid'].'">'.$single_division['name'].'</option>';
                                                                  }
                                                            }
                                                        }else{
                                                            echo '<option value="'.$alldivision['tid'].'" selected="selected" data-id="'.$alldivision['weight'].'">'.$alldivision['name'].'</option>';
                                                        }
                                                    }else{
                                                        echo '<option value="">Select company</option>';
                                                        foreach ($alldivision as $single_division) {
                                                              if($emp_division==$single_division['tid']){
                                                                echo '<option value="'.$single_division['tid'].'" selected="selected">'.$single_division['name'].'</option>';
                                                              }else{
                                                                echo '<option value="'.$single_division['tid'].'">'.$single_division['name'].'</option>';
                                                              }
                                                        } 
                                                    }
                                                    ?>
                                                  </select>                     
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">Division/ Branch:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_department" id="emp_department">
                                                    <option value="">Select Division</option>
                                                    <?php 
                                                    
                                                    foreach ($department_selected as $single_department) {
                                                      if($emp_department==$single_department['tid']){
                                                        echo '<option value="'.$single_department['tid'].'" selected="selected">'.$single_department['name'].'</option>';
                                                    }else{
                                                        echo '<option value="'.$single_department['tid'].'">'.$single_department['name'].'</option>';
                                                      }
                                                    } 
                                                    ?>
                                                  </select>                       
                                                </div>
                                            </div>                                                                                       
                                            <div class="row">
                                                <div class="col-md-4">Job Title:</div>
                                                <div class="col-md-8">
                                                      <select name="emp_position" id="emp_position"  data-placeholder="Choose a Position..." class="chosen-select" >
                                                        <option value=""></option>
                                                        <?php 
                                                            foreach ($alljobtitle as $single_jobtitle) {
                                                              if($emp_position==$single_jobtitle['tid']){
                                                                echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
                                                              }else{
                                                                echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
                                                              }
                                                            } 
                                                        ?>
                                                      </select>                        
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4">Type of Employee:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_type" id="emp_type">
                                                    <option value="">Select Type</option>
                                                    <?php foreach ($alltypeofemployee as $single_emp_type) {
                                                      if($emp_type==$single_emp_type['tid']){
                                                        echo '<option value="'.$single_emp_type['tid'].'" selected="selected">'.$single_emp_type['name'].'</option>';
                                                      }else{
                                                        echo '<option value="'.$single_emp_type['tid'].'">'.$single_emp_type['name'].'</option>';
                                                      }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Joining Date:</div>
                                                <div class="col-md-8">From<input type="text" class="datepicker numbersOnly" name="joining_date_from1" id="joining_date_from1" placeholder="dd-mm-yyyy"></div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">To<input type="text" class="datepicker numbersOnly" name="joining_date_to1" id="joining_date_to1" placeholder="dd-mm-yyyy"></div>
                                            </div>                                             
                                            <div class="row">
                                                <div class="col-md-4">Pay Type:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_pay_type" id="emp_pay_type">
                                                    <option value="">Select Pay Type</option>
                                                    <?php foreach ($allpaytype as $single_paytype) {
                                                      if($emp_pay_type==$single_paytype['tid']){
                                                        echo '<option value="'.$single_paytype['tid'].'" selected="selected">'.$single_paytype['name'].'</option>';
                                                      }else{
                                                        echo '<option value="'.$single_paytype['tid'].'">'.$single_paytype['name'].'</option>';
                                                      }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">Sort By:</div>
                                                <div class="col-md-8">
                                                  <select name="sort_by" id="sort_by">
                                                      <option value="emp_id">Employee Code</option>
                                                    <option value="grade">Employee Grade</option>
                                                    
                                                    <option value="emp_name">Employee Name</option>
                                                    <option value="emp_division">Company</option>
                                                    <option value="gender">Gender</option>
                                                    <option value="marital_status">Marital Status</option>
                                                    <option value="religion">Religion</option>
                                                    <option value="joining_date">Joining Date</option>
                                                    <option value="type_of_employee">Type_of Employee</option>
                                                    <option value="distict">Distict</option>
                                                  </select>                       
                                                </div>
                                            </div>                                             
                                            <div class="row">
                                                <div class="col-md-4">Visa Selling:</div>
                                                <div class="col-md-8"><input type="checkbox" name="emp_visa_selling" id="emp_visa_selling"/>    </div>
                                            </div>                                                                                                                                                        
                                            <!-- sldks -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- sjdksjd -->                                           
                                            <div class="row">
                                                <div class="col-md-4">Gender:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_gender" id="emp_gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Others">Others</option>
                                                  </select>   
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Age:</div>
                                                <div class="col-md-8">From
                                                    <select name="age_from" id="age_from">
                                                        <option value="">All</option>
                                                        <?php
                                                        foreach ($age as $single_age) {
                                                            if ($single_age['age']) {
                                                                echo '<option value="' . $single_age['age'] . '">' . $single_age['age'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">To
                                                    <select name="age_to" id="age_to">
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($age as $single_age) {
                                                            if ($single_age['age']) {
                                                                echo '<option value="' . $single_age['age'] . '">' . $single_age['age'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>                                                                                                                                                                  
                                            <div class="row">
                                                <div class="col-md-4">Religion:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_religion" id="emp_religion">
                                                    <option value="">Select Religion</option>
                                                    <?php foreach ($allreligion as $single_religion) {
                                                      if($emp_religion==$single_religion['tid']){
                                                        echo '<option value="'.$single_religion['tid'].'" selected="selected">'.$single_religion['name'].'</option>';
                                                      }else{
                                                        echo '<option value="'.$single_religion['tid'].'">'.$single_religion['name'].'</option>';
                                                      }
                                                    } ?>
                                                  </select>  
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Marital Status:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_marital_status" id="emp_marital_status">
                                                    <option value="">Select Status</option>
                                                    <?php foreach ($allmarital_status as $single_maritial_status) {
                                                      if($emp_marital_status==$single_maritial_status['tid']){
                                                        echo '<option value="'.$single_maritial_status['tid'].'" selected="selected">'.$single_maritial_status['name'].'</option>';
                                                      }else{
                                                        echo '<option value="'.$single_maritial_status['tid'].'">'.$single_maritial_status['name'].'</option>';
                                                      }
                                                    } ?>
                                                  </select> 
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Mobile No:</div>
                                                <div class="col-md-8"><input type="text" class="phonenumbersOnly" name="mobile_no" id="mobile_no"></div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4">Name:</div>
                                                <div class="col-md-8">
                                                    <input type="text" name="searchbyname" id="searchbyname">
                                                </div>
                                            </div>                                             
                                            <div class="row">
                                                <div class="col-md-4">Distict:</div>
                                                <div class="col-md-8">
                                                <select name="emp_current_distict" id="emp_current_distict">
                                                  <option value="">Select Distict</option>
                                                  <?php foreach ($alldistict as $single_distict) {
                                                    if($emp_current_distict==$single_distict['tid']){
                                                      echo '<option value="'.$single_distict['tid'].'" selected="selected">'.$single_distict['name'].'</option>';
                                                    }else{
                                                      echo '<option value="'.$single_distict['tid'].'">'.$single_distict['name'].'</option>';
                                                    }
                                                  } ?>
                                                </select>  
                                                </div>
                                            </div>                                                                                      
                                            <!-- kdjsfkd -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"><input type="submit" name="multiple_search_btn" value="Search" id="search_button"></div>
                                        <div class="col-md-4"></div>
                                    </div>
                                </div>
                            </div>                                  
                        </div>
                    </div>
                        </form>

                    <div class="row" id="list">
                        <div class="col-md-12">
                            <div class="title-area">
                                <h1 class="title text-center" id="page-title">The Employees List </h1>
                                <!--<span  class="total-query" style="  float: right;  margin-top: -19px; font-size: 15px;">Total with deactive employee:<?php print $total_search; ?></span>-->
                            </div> 

                        </div>
                    </div>                
                        <!--
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <nav>
                            <?php print $this->pagination->create_links(); ?>
                            </nav>
                        </div>
                    </div>   
                        -->
                        <!--<button  class="btn btn-md btn-info pull-right" style="width:150px;" onclick="tableToExcel('example',  'Employee List', 'employee_list')" ><span class="glyphicon glyphicon-file"></span>Export to Excel</button>-->

                        <?php if ($user_type == 1){?>
                        <a href="<?php echo site_url('findemployeelist/trash_employee'); ?>"  class="pull-right btn btn-default"><span style="font-size:15px" class="glyphicon glyphicon-trash"> </span> Deactive employee</a>
                        <?php } ?>
                        <?php if (!empty($this->session->userdata('add_status'))) { ?>
                                        <script type="text/javascript">
                                            $(window).on('load', function () {
                                                $('#myModal').modal('show');
                                            }); 
                                        </script>
                                    <?php
                                      $this->session->unset_userdata('add_status');
                                    
                                    } ?>
                         <form  action="<?php echo base_url(); ?>findemployeelist/submitmultipletask"  method="post" class="myForm"  id="myFormmultiple"  name="myFormmultiple" enctype="multipart/form-data">                
                            <input type="hidden" name="emp_division" value="<?php echo $emp_division; ?>" />                         
                            <?php if($user_type==1 || $user_id==16 ){ ?>
                            <div class="row" >
                                <div class="col-md-2" style="width: 123px;font-size: 20px;line-height: 40px;"> Task Type </div>
                                <div class="col-md-3" style="padding-left: 0; border: 1px solid #000;padding: 2px; background-color: #ff9966; border-radius: 3px">
                               
                                    <select name="multiple_task" id="multiple_task" style="padding: 8px;font-size: 15px;" required="">
                                        <option class="multiple_task_type" value="">Select task</option>
                                        <?php      if($user_type_id ==1) {?>
                                            <option class="multiple_task_type" value="update_shift_history_for_all" <?php if ($per_page_query['per_page'] == 'update_shift_history_for_all') { echo "selected='selected'";  } ?>>Update Shift History For All</option>
                                            <option class="multiple_task_type" value="update_shift_history_for_selected" <?php if ($per_page_query['per_page'] == 'update_shift_history_for_selected') { echo "selected='selected'";  } ?>>Update Shift History For Selected</option>
                                            <option class="multiple_task_type" value="terminated_selected" <?php if ($per_page_query['per_page'] == 'terminated_selected') { echo "selected='selected'";  } ?>>Terminated </option>
                                            <option class="multiple_task_type" value="left_selected" <?php if ($per_page_query['per_page'] == 'terminated_selected') { echo "selected='selected'";  } ?>>Left </option>
                                            <option class="multiple_task_type" value="Update Total Leave For All" <?php if ($per_page_query['per_page'] == 'Update Total Leave For All') { echo "selected='selected'";  } ?>>Update Total Leave  For All</option>
                                            <option class="multiple_task_type" value="Update Total Leave For Selected" <?php if ($per_page_query['per_page'] == 'Update Total Leave For Selected') { echo "selected='selected'";  } ?>>Update Total Leave  For Selected</option>
                                        <?php }?>
                                        <option class="multiple_task_type" value="Download All Employee List" <?php if ($per_page_query['per_page'] == 'Download All Employee List') { echo "selected='selected'";  } ?>>Download All Employee List-PDF</option>
                                        <option class="multiple_task_type" value="Download Selected Employee List" <?php if ($per_page_query['per_page'] == 'Download Selected Employee List') { echo "selected='selected'";  } ?>>Download Selected Employee List-PDF</option>
                                        
                                        <option class="multiple_task_type" value="download_emp_list_excel" <?php if ($per_page_query['per_page'] == 'download_emp_list_excel') { echo "selected='selected'";  } ?>>Download Excel</option>
                                       
                                        <option class="multiple_task_type" value="print_emp_list" <?php if ($per_page_query['per_page'] == 'print_emp_list') { echo "selected='selected'";  } ?>>Print</option>
                                    
                                    </select>
                                    <div class="download_date" style="display:none;  background-color: #FFEBCD !important">
                                         <?php
                                            $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                            $current_date = $dt->format('d-m-Y');                                               
                                        ?>
                                        Effect Date:<input type="text" name="download_date" id="download_date" value="<?php echo $current_date; ?>"  class="datepicker numbersOnly" placeholder="dd-mm-yyyy"/>
                                    </div>
                                    <div class="total_leave_text" style="display:none;  background-color: #FFEBCD !important">
                                        Effective Date:<input type="text" name="emp_job_change_date" id="emp_job_change_date"  class="datepicker numbersOnly" placeholder="dd-mm-yyyy"/>  <br>        
                                        Total Leave:<input type="text" name="annual_leave_total" id="annual_leave_total"  onkeypress="return isNumber(event);" />        
                                    </div>
                                    <div class="left_terminated_area" style="display:none;  background-color: #FFEBCD !important">
                                        Effective Date:<input type="text" name="effective_date" id="effective_date"  class="datepicker numbersOnly" placeholder="dd-mm-yyyy"/>  <br>        
                                        Reason:<textarea name="reason" id="reason"></textarea>        
                                    </div>
                                    <div id="edit_shift_history_area" style="display:none; background-color: #FFEBCD !important ">
                                        <div class="col-md-12">   
                                                <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Effective Date</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_job_change_date"  id="emp_job_change_date2"  class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php //if($emp_starting_date){ echo $emp_starting_date;} //if($emp_job_change_date){ echo $emp_job_change_date;} ?>"/>        
                                                        </div>
                                                </div> 																																																			 
                                                <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Attendance Required</div>
                                                        <div class="col-md-8">
                                                                <select name="attendance_required" id="attendance_required">
                                                                        <option value="Required" <?php if($attendance_required=='Required'){print 'selected="selected"';} ?>>Required</option>
                                                                        <option value="Not_Required" <?php if($attendance_required=='Not_Required'){print 'selected="selected"';} ?>>Not Required</option>
                                                                        <option value="Optional" <?php if($attendance_required=='Optional'){print 'selected="selected"';} ?>>Optional</option>
                                                                </select> 													        
                                                        </div>
                                                </div> 												
                                                <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Work Starting Time</div>
                                                        <div class="col-md-8">
                                                                <input type="text" placeholder="e.g. hh:mm:ss" name="emp_working_time_from" id="emp_working_time_from" value="<?php if($emp_working_time_from){ echo $emp_working_time_from;}else{ echo "09:30:00";} ?>"/>        
                                                        </div>
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Work Ending Time</div>
                                                        <div class="col-md-8">
                                                                <input type="text" name="emp_working_end_time" id="emp_working_end_time" placeholder="e.g. hh:mm:ss"  value="<?php if($emp_working_end_time){ echo $emp_working_end_time;}else{ echo "17:30:00";} ?>"/>        
                                                        </div>
                                                </div>	
                                                <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Late Count Time</div>
                                                        <div class="col-md-8">
                                                                <input type="text" name="emp_latecount_time" id="emp_latecount_time" placeholder="e.g. hh:mm:ss"  value="<?php if($emp_latecount_time){ echo $emp_latecount_time;}else{ echo "09:46:00";} ?>"/>        
                                                        </div>
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Early Count Time</div>
                                                        <div class="col-md-8">
                                                                <input type="text" name="emp_earlycount_time" id="emp_earlycount_time" placeholder="e.g. hh:mm:ss"  value="<?php if($emp_earlycount_time){ echo $emp_earlycount_time;}else{ echo "17:20:00";} ?>"/>        
                                                        </div>
                                                </div>												
                                                <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Logout Required</div>
                                                        <div class="col-md-8">
                                                                <select name="logout_required" id="logout_required">
                                                                        <option value="Required" <?php if($logout_required=='Required'){print 'selected="selected"';} ?>>Required</option>
                                                                        <option value="Not_Required" <?php if($logout_required=='Not_Required'){print 'selected="selected"';} ?>>Not Required</option>
                                                                        <option value="Optional" <?php if($logout_required=='Optional'){print 'selected="selected"';} ?>>Optional</option>
                                                                </select> 													        
                                                        </div>
                                                </div> 		
                                                <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Half Day Absent</div>
                                                        <div class="col-md-8">
                                                                <select name="half_day_absent" id="half_day_absent">
                                                                        <option value="Not_Eligible" <?php if($half_day_absent=='Not_Eligible'){print 'selected="selected"';} ?>>Not Eligible</option>														
                                                                        <option value="Eligible" <?php if($half_day_absent=='Eligible'){print 'selected="selected"';} ?>>Eligible</option>
                                                                </select> 													        
                                                        </div>
                                                </div> 
                                                <div class="row absent_cnt_time" style="<?php if($absent_count_time){ echo "display:block";} ?>">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Absent Count Time</div>
                                                        <div class="col-md-8">
                                                                <input type="text" name="absent_count_time" id="absent_count_time" placeholder="e.g. hh:mm:ss"  value="<?php if($absent_count_time){ echo $absent_count_time;} ?>"/> 													        
                                                        </div>
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Overtime Count</div>
                                                        <div class="col-md-8">
                                                                <select name="overtime_count" id="overtime_count">
                                                                        <option value="Not_Eligible" <?php if($overtime_count=='Not_Eligible'){print 'selected="selected"';} ?>>Not Eligible</option>														
                                                                        <option value="Eligible" <?php if($overtime_count=='Eligible'){print 'selected="selected"';} ?>>Eligible</option>
                                                                </select>         
                                                        </div>
                                                </div>
                                                <div class="row overtime_rate" style="<?php if($overtime_hourly_rate){ echo "display:block";} ?>">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Overtime Hourly Rate</div>
                                                        <div class="col-md-8">
                                                                <input type="text" name="overtime_hourly_rate" id="overtime_hourly_rate"  onkeypress="return isNumber(event);" value="<?php if($overtime_hourly_rate){ echo $overtime_hourly_rate;} ?>" placeholder="Amount in taka"/>        
                                                        </div>
                                                </div>

                                        </div>
                                    </div>
                                
                                </div>
                                <div class="col-md-1" style="padding-left: 0px;"><input type="submit" id="submit_task"  value="Submit"></div>
                                <div class="col-md-3"></div>
                                <!--
                                <div class="col-md-3" style="width:260px;padding-right:0px;  padding-top: 5px;  text-align: right;">Applicant per page</div>
                                <div class="col-md-1" style="padding-left: 0px; padding-right: 0px; margin-left: 13px;">

                                    <select name="applicant_per_page" id="applicant_per_page">
                                        <option value="">Select</option>
                                        <option value="8" <?php if ($per_page_query['per_page'] == '8') { echo "selected='selected'";  } ?>>8</option>
                                        <option value="12" <?php if ($per_page_query['per_page'] == '12') { echo "selected='selected'";  } ?>>12</option>
                                        <option value="24" <?php if ($per_page_query['per_page'] == '24') { echo "selected='selected'"; } ?>>24</option>
                                        <option value="48" <?php if ($per_page_query['per_page'] == '48') { echo "selected='selected'"; } ?>>48</option>
                                        <option value="96" <?php if ($per_page_query['per_page'] == '96') { echo "selected='selected'"; } ?>>96</option>
                                        <option value="1000" <?php if ($per_page_query['per_page'] > 96) { echo "selected='selected'"; } ?>>All</option>
                                    </select>
                                </div>
                                -->
                            </div> 
                            <?php }?>
                                 <div class="row clear_fix"><div class="col-md-12" id="respose" style="margin-bottom:5px "></div></div>      
                        <table class="display " id="example" summary="Code page support in different versions of MS Windows." rules="groups" frame="hsides" border="2"  width="100%" border="0">
                      <?php      if($user_type_id ==1) {?>
                <!--<button class="btn btn-danger btn-sm pull-right disabled" style="width:150px;margin-top: -15px;" id="terminate_all"><span class="glyphicon glyphicon-remove"  title=""></span> Terminated selected</button>-->
                <!--<button class="btn btn-warning btn-sm pull-right disabled" style="width:150px;margin-top: -15px;margin-right: 5px;" id="resign_all"><span class="glyphicon glyphicon-repeat"  title=""></span> Resign selected</button>-->
                      <?php }  ?> 
            
                            <thead>
                                <tr class="heading">
                                    <th style="padding-left: 10px;text-align: left;width:10px!important"><input type='checkbox' class="check_all" id="check_all" value='all' /></th>                                
                                    <th>Sl</th>
                                    <th>Emp. Code</th>
                                    <th>Name</th>
                                   <th>Grade</th>
                                    <th>Company </th>
                                    <th>Division/Branch</th>
                                    <th>Position</th>
                                    <th>Type of Employee</th>
                                    <?php if ($user_type == 1 || $view_salary_in_emp_list['status']== 1 ) { ?>                                     
                                         <!-- <th>Salary</th> -->
                                    <?php } ?>
                                         <!--<th>Gender</th>-->
                                    <?php if ($user_type == 1 || $view_employee_mobile_number['status']==1){ ?>
                                    <th>Mobile No</th>
                                    
<!--                                    <th>Date of Birth</th>
                                         <th>Age</th>-->
                                    <th>Status</th>
                                    <?php } if ($user_type == 1 || $add_edit_profile[0]['status'] == 1) { ?> 
                                         <th style="width:100px">Action</th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>
                                 <?php
                                $sl=1;
                            //    echo "<pre/>";
                            //    print_r($records);
                            //    exit;
                                foreach ($records as $sigle_content) {
                                    $content_id = $sigle_content['content_id'];
                                    $emp_code = $sigle_content['emp_id'];
                                    $emp_name = $sigle_content['emp_name'];
                                    $emp_grade = $sigle_content['grade'];                                   
                                    //$emp_grade_data=$this->taxonomy->getTaxonomyBytid($emp_grade);
                                    $emp_division = $sigle_content['emp_division'];
                                    $emp_division_data=$this->taxonomy->getTaxonomyBytid($emp_division);
                                    $emp_department = $sigle_content['emp_department'];
                                    $emp_department_data=$this->taxonomy->getTaxonomyBytid($emp_department);
                                    $emp_post_id = $sigle_content['emp_post_id']; 
                                    $emp_post_id_data=$this->taxonomy->getTaxonomyBytid($emp_post_id);
                                    $type_of_employee = $sigle_content['type_of_employee'];
                                    $type_of_employee_data=$this->taxonomy->getTaxonomyBytid($type_of_employee);
                                    $joining_date = $sigle_content['joining_date'];
                                    $gender = $sigle_content['gender'];
                                    $mobile_no = $sigle_content['mobile_no'];
                                    $distict = $sigle_content['distict'];
                                    $distict_data=$this->taxonomy->getTaxonomyBytid($distict);
                                    $emp_gross_salary=$sigle_content['gross_salary']; 
                                   # $salary_info = $this->emp_salary_model->get_salary_info_by_content_id($content_id); 

                                    ?>
                                    <tr>
                                        <td style="width:10px!important"><input type='checkbox' class="sub_chk" name='content_id[]' value='<?php print $content_id; ?>' /></td>                                    
                                        <td><?php echo $sl; ?></td>
                                        <td><?php print $emp_code; ?></td>
                                        <td> 
                                            <?php
                                                if($sigle_content['status']==1){
                                                    echo "<span class='glyphicon glyphicon-ok-sign' style='color:green'></span> ";
                                                }else if($sigle_content['status']==0){
                                                    echo "<span class='glyphicon glyphicon-lock' style='color:red'></span>";
                                                }
                                                ?>    
                                            <?php if($user_type == 1 || $view_employee_profile['status']==1){?>
                                            <a href="<?php echo site_url("employee-profile") . '/' . $content_id; ?>" target="_blank" style="font-style:italic; text-decoration: underline; font-size: 14px;"  ><?php print $emp_name; ?></a>
                                            <?php }else{ echo $emp_name; }?>
                                        </td>
                                       <td><?php  echo $sigle_content['grade_name']; ?></td>
                                        <td><?php echo $emp_division_data['keywords']; ?></td>
                                        <td><?php echo $emp_department_data['name']; ?></td>
                                        <td><?php echo $emp_post_id_data['name']; ?></td>
                                        <td><?php echo $type_of_employee_data['name']; ?></td>
<!--                                        <td><?php //print $joining_date; ?></td>-->
                                        <?php if ($user_type == 1 || $view_salary_in_emp_list['status'] == 1) { ?> 
                                        <!-- <td >
                                            <a href="<?php echo $content_id; ?>" class="label label-default edit_payroll"  content_id="<?php echo $content_id; ?>" data-toggle="modal" style="font-size:10px;text-decoration:underline; font-style: italic;" data-target="#payRollModal" 
                                               data-content_id="<?php echo $content_id; ?>" 
                                               data-id="<?php echo $sigle_content['emp_salary_id']; ?>"
                                               <?php 
                                               foreach($salary_info as  $key => $value){
                                                   echo "data-$key='$value'";
                                               }
                                               ?>
                                               data-tel_allow="<?php echo $sigle_content['telephone_allow']; ?>" 
                                               data-gross_salary="<?php echo $sigle_content['gross_salary']; ?>" 
                                               data-yearly_paid="<?php echo $sigle_content['yearly_paid']; ?>" 
                                               data-provident_fund_deduction="<?php echo $sigle_content['provident_fund_deduction']; ?>"
                                               data-tax_deduction="<?php echo $sigle_content['tax_deduction']; ?>" 
                                               data-other_deduction="<?php echo $sigle_content['other_deduction']; ?>" 
                                               data-total_deduction="<?php echo $sigle_content['total_deduction']; ?>" 
                                               data-bank_name="<?php echo $sigle_content['bank_name']; ?>" 
                                               data-emp_bank_branch="<?php echo $sigle_content['emp_bank_branch']; ?>" 
                                               data-emp_bank_account="<?php echo $sigle_content['emp_bank_account']; ?>" 
                                               data-emp_pay_type="<?php echo $sigle_content['emp_pay_type']; ?>" 
                                               >    
                                                 <?php print number_format($emp_gross_salary)." TK"; ?>
                                             </a>
                                        </td> -->
                                        <?php } ?>
                                        <!--<td><?php // print $gender; ?></td>-->
                                          <?php if ($user_type == 1 || $view_employee_mobile_number['status']==1){ ?>
                                        <td><?php print $mobile_no; ?></td>
                                      
                                        <!--<td><?php //print $sigle_content['dob']; ?></td>-->
                              
<!--                                        <td><?php //print $distict_data['name']; ?></td>-->
                                <?php } ?>
                                        <td>
                                            <?php
                                            if($user_type == 1){
                                            ?>
                                            <a href="#" rel="tooltip" data-placement="top" data-inputclass="select_class"  class="employee_status" id="status" data-type="select" data-title="Change Lock Status" data-pk="<?php echo $content_id; ?>" data-url="<?php echo base_url(); ?>findemployeelist/employeeLockSystem/search_field_emp" >                                         
                                                <?php
                                            }
                                                if($sigle_content['status']==1){
                                                    echo "<span class='' style='color:green'>active</span> ";
                                                }else if($sigle_content['status']==0){
                                                    echo "<span class='' style='color:red'>Locked</span>";
                                                }
                                                 if($user_type == 1){
                                                     echo "</a>";
                                                 }
                                                ?>     
                                       
                                        
                                        </td>
                                <?php
                                if ($user_type == 1 || $add_edit_profile[0]['status'] == 1) { ?> 
                                        <td style="width:50px !important;">
                                            <a class="btn btn-info btn-xs" href="<?php echo site_url("addprofile/addEmployee") . '/' . $content_id; ?>" class="operation-edit operation-link ev-edit-link"><span class="glyphicon glyphicon-edit" title="edit"></span>  </a>
                                           <!-- <a class="btn btn-warning btn-xs" href="<?php echo site_url("commoncontroller/type_of_employee/search_field_emp/left"). '/' . $content_id; ?>#list" class="operation-edit operation-link ev-edit-link resign" onClick="return ConfirmLeft()">  eResign</a>
                                            <button type="button"  class="btn btn-warning btn-xs resign" content_name="<?php echo $emp_name;?>" value="<?php echo $content_id;?>" style="width:60px;" >  Resign</button>
                                            <button type="button"  class="btn btn-danger btn-xs terminate" ter_content_name="<?php echo $emp_name;?>"  id="terminate_id" value="<?php echo $content_id;?>" style="width:80px;" >  Terminated</button>
                                            <!--<a class="btn btn-danger btn-xs" href="<?php // echo site_url("CommonController/type_of_employee/search_field_emp/terminated"). '/' . $content_id; ?>#list" class="operation-edit operation-link ev-edit-link" onClick="return ConfirmTerminated()"> Terminated</a> -->

                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php 
                                    $sl++;
                                    
                                           }
                                           
                                           ?> 
                                </tbody>
                            </table>  
                            </form>
                        <!--
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <nav>
                                    <?php //print $this->pagination->create_links(); ?>
                                    </nav>
                                </div>
                            </div>  
                        -->
                        </div>
                    </div>              
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->   
  
                  <?php if ($user_type == 1 || $view_salary_in_emp_list['status'] == 1) {
//                    <!-- Modal -->
                   $this->load->view('recruiting/payroll', true);
//                    <!-- /.modal -->
               
        
           $this->load->view('recruiting/salary_history', true);
          } ?>
             <!--Chosen--> 
        <script src="<?php echo base_url();?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
            <!-- XEditable -->
        <script src="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.min.js"></script>
    </body>
</html>
<?php
$end = microtime(true);
$exe_time = $end - $start;
echo "Page generated time: " . number_format($exe_time, 2) . " Seconds.";
?>