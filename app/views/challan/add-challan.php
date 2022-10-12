<style>
    table {border-collapse: collapse;}
    td,th   {padding: 5px; text-align: center}
    th{border:1px solid #FFF}
</style>
<div class="modal fade " id="add_challan"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 1180px;"  role="document">
        <div class="modal-content ">
             <form action="<?php echo base_url(); ?>add-challan"  id="myForm"  name="myForm"  action=""  onSubmit="return validate();"  method="POST" class='form form-bordered'>
                        
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </a>
                <h4 class="modal-title" id="myModalLabel"><strong><span id="tag"></span> Add Challan</strong></h4>
            </div>
            <div class="modal-body">

                <div class="row"  >
                    <div class="col-md-12 col-xs-12 " style="">                          
                           <div id="errors" style="color:red">
                                <?php
                                $errMsg = $this->session->flashdata('errors');
                                if ($errMsg) {
                                    echo $errMsg;
                                    $this->session->set_flashdata('errors', '');
                                }
                                ?>
                            </div>

                            <div class="form-group" style="">
                                   <div class="row">
                                <label for="textfield" class="control-label col-sm-2">Challan No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="" name="challan_no" id="challan_no" />
                                </div>

                                <label for="textfield" class="control-label col-md-2">Challan Date</label>
                                <div class="col-md-4">
                                    <?php
                                    $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                    $current_date = $dt->format('d-m-Y');
                                    $current_year = $dt->format('Y');
                                    ?>
                                    <input type="text" placeholder="" value="<?php echo $current_date; ?>"  class="form-control datepicker" id="challan_date" name="challan_date"/>  
                                </div>
                                </div>
                                <div class="row">
                                    <label for="textfield" class="control-label col-sm-2">Depositor</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="" name="dipositor" id="dipositor" />
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row"  style="border-bottom:1px solid #FFF;margin-bottom:20px;"></div>

                            <div class="form-group">
                                <table class="grand_table" style="width:100%;font-size: 10px;">

                                    <tr  style="height:35px; "> 
                                        <td style="">Chose Employee Name -->: </td>
                                        <td  colspan="7" >
                                            <select style="width:100%" name="emp_name" id="emp_name" class="emp_name chosen-select form-control"  data-placeholder="Choose an employee..." >
                                                <option value="">-- Choose an employee --</option>
                                                <?php print_r($employees);
                                                foreach ($employees AS $employee) { ?>
                                                    <option value="<?php echo $employee['content_id']; ?>"><?php echo $employee['emp_name']; ?></option>
<?php } ?>

                                            </select>
                                            <input type="hidden" placeholder="xx"  class="emp_tin" value=""  id="emp_tin" name="emp_tin"/>
                                            <input type="hidden" placeholder="xx"  class="amount" value=""  id="amount" name="amount"/>
                                            <input type="hidden" placeholder="xx"  class="update_emp" value=""  id="update_emp" name="update_emp"/>
                                        </td>
                                        <td colspan="7"></td>
                                    </tr>
                                    <tr style="height:150px; vertical-align: top;">
                                        <td colspan="14" style="background-color:#FFF;padding:5px; border-radius: 5px;">
                                            <table class="grid_area" style=" width:100%;" cellpadding="0" >
                                                <thead>
                                                    <tr style="background-color:#2F4F4F;color: #fff;">
                                                        <th style="width:10px;padding:0"></th>
                                                        <th style="width:300px;">যাহার পক্ষ হইতে প্রদত্ত  হইল তাহার নাম </th>
                                                        <th title="TIN Number"></th>
                                                        <th colspan="">জমা প্রদানের বিবরণ </th>                                                       
                                                        
                                                        <th title="Amount"></th>
                                                        <th></th>
                                                    </tr>
                                                    <tr style="background-color:#2F4F4F;color: #fff;">
                                                        <th>Sl.</th>
                                                        <th>Emp Name   </th>    
                                                         
                                                        <th title="TIN Number" style="width:270px;">TIN</th>
                                                        <th >Month Name </th>                                                       
<!--                                                        <th >From Date </th>                                                       
                                                        <th >To Date </th> -->
                                                        <th title="Amount">Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="item_grid grid" >

                                                    <!--displaying flying value-->
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tfoot>               
                                        <tr style="background: #FFF">
                                            <th >NOTE:</th>  
                                            <th colspan="11">
                                                <textarea  class="form-control note" id="note" name="note" row="1"></textarea>
                                            </th>
                                            <th style="text-align: right;">Total</th>
                                            <th class="subtotal" style="text-align: center;">
                                                <input type="text" class="form-control sub_total" id="total" name="total"/>
                                            </th>                
                                        </tr>
                                   
                                    </tfoot>
                                </table>
                            </div>

                     

                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <a class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
                <input type="submit" name="save_challan" class="btn btn-primary " value="Submit Challan" /> 
            </div>
               </form>




        </div>

        <!--</form>-->
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".emp_name").change(function () {
            var id = $(this).val();
            var gridEmp = $('.grid_emp_name').val();
            var checkExist = '';
            //alert(gridItem);
            var slNo = 0;
            $('#update_emp').val('');
            $('.grid_emp_name').each(function (i, e) {
                //alert(slNo);
                var existProductId = $(this).val();
                if (id === existProductId) {                   
                   // totalCal();
                  //  checkExist = 'true';
                }

            });
            if ((!gridEmp) || (checkExist != 'true')) {
                addEmp();
            }
        });
        // Delete item -----------
        $('body').delegate('.remove', 'click', function () {
            $(this).parent().parent().remove();
            totalCal();
        });
        
        // Grid items area caculation --------------
        $('.grid_area').delegate('.grid_amount', 'keyup', function () {
            var tr = $(this).parent().parent();
            var amount = tr.find('.grid_amount').val();
            totalCal();
        });
        
         // If item change into grid --------------------------
                $('.grid_area').delegate('#grid_emp_name', 'change', function () {
                    var id = $(this).val();
                    var tr = $(this).parent().parent();
                    // alert(id);
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo base_url('ChallanController/empInfoById'); ?>",
                        data: {id: id},
                        dataType: "JSON",
                        cache: false,
                        success: function (data) {
                            tr.find('.grid_emp_tin').val(data.tin);
                        },
                        error: function () {
                            alert("error");
                        }
                    });
                });
        
    });
    
    
    
    function addEmp(){
        var id = $("#emp_name").val();
        $.ajax({
            type: 'POST',
            url: "<?PHP echo base_url('ChallanController/empInfoById'); ?>",
            data: {id: id},
            dataType: "JSON",
            cache: false,
            success: function (data) {
                //alert(data);
                $("#emp_tin").val(data.tin);
                var amt = $('#amount').val();
                $('#amount').val(amt);
                var selectedEmpId = $('#emp_name').val();
                var selectedEmp = $('#emp_name option:selected').text();
                var n = ($('.grid tr').length - 0) + 1;
                var sl = '<td style="width:10px;padding:0">' + n + '</td>';
                var a = '<td style="padding:0"> <select name="grid_emp_name[]" id="grid_emp_name" class="grid_emp_name  chosen-select"  value="' + $('#emp_name').val() + '"  class="" style="width:250px; z-index:9999" data-placeholder="Please select employee">' +
                        '<option value=' + selectedEmpId + '>' + selectedEmp + '</option>' +
                <?php
                foreach ($employees AS $employee) {
                    //$x = "<script>document.writeln(productId);</script>";
                    ?>
                    '<option value="<?php echo $employee['content_id']; ?>"><?php echo $employee['emp_name']; ?></option>' +
                <?php
                }
                ?>          
                '</select></td>';
                var b = '<td style="padding:0"> <input type="text" placeholder=""  class="grid_emp_tin" value="' + $('#emp_tin').val() + '" id="grid_emp_tin' + n + '" name="grid_emp_tin[]" style="width:270px; z-index:9999" /> </td>';
//                var c = '<td style="padding:0"> <input type="text" placeholder=""  class="datepicker" value="" id="from_month' + n + '" name="from_month[]" style=" z-index:9999" /> </td>';
//                var d = '<td style="padding:0"> <input type="text" placeholder=""  class="datepicker" value="" id="to_month' + n + '" name="to_month[]" style="z-index:9999" /> </td>';
                var c= '<td style="padding:0"> <input type="text" placeholder=""  class="date-picker" value="" id="challan_month' + n + '" name="challan_month[]" style=" z-index:9999" /> </td>';
                var d = '<td style="padding:0"> <input type="text" placeholder="XX" class="grid_amount"  value="' + $('#amount').val() + '" id="grid_amount' + n + '" name="grid_amount[]" style="width:100px; z-index:9999" /></td> ';
                 var e = '<td style="padding:0"> <span class="glyphicon glyphicon-remove remove btn btn-xs btn-danger"></span></td>';
                $(".item_grid").append('<tr style="border: 1px solid #2F4F4F;">' + sl + a + b + c + d + e + '</tr>');

                totalCal();
                // for date-month-year
                $(".datepicker").datepicker({
                dateFormat: 'dd-mm-yy'
            });
            // month-year
            $('.date-picker').datepicker( {
                        changeMonth: true,
                        changeYear: true,
                        showButtonPanel: true,
                        dateFormat: 'MM yy',
                        onClose: function(dateText, inst) { 
                            $(document).on('focusin.bs.modal');
                            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                            $(this).datepicker('setDate', new Date(year, month, 1));
                            
                        },
                        beforeShow : function(input, inst) {
                            $(document).off('focusin.bs.modal');
                            var datestr;
                            if ((datestr = $(this).val()).length > 0) {
                                year = datestr.substring(datestr.length-4, datestr.length);
                                month = jQuery.inArray(datestr.substring(0, datestr.length-5), $(this).datepicker('option', 'monthNamesShort'));
                                $(this).datepicker('option', 'defaultDate', new Date(year, month, 1));
                                $(this).datepicker('setDate', new Date(year, month, 1));
                            }
                        }

            });
            }
        });
    }
    function totalCal(){
                 var grandTotal = 0;
                $('.grid_amount').each(function (i, e) {
                    var amount = $(this).val();
                    amount = amount - 0;
                    //vat = $('.grid_vat').val();
                    grandTotal += amount;
                });

                $('.sub_total').val(grandTotal.toFixed(2));

    }
</script>
