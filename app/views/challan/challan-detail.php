<script>
    $(function () {

        $('.edit_data').editable({
            
                          
                           
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
    });

</script>  
<div id="challan-detail" title="Challan Details" style="padding: 50px;">
    <?php
    if ($challanInfo) {
        ?>   
        <style>

        </style>
       
        <br/>
        <br/>
        <table style="" class="table table-condensed">
            <tr>
                <td ></td>
                <td ></td>
                <td style="text-align:right">Challan Number:</td>
                <td ><strong><?php echo $challanInfo->challan_no; ?></strong> </td>
            </tr>
            <tr>
                <td >Dipositor:</td>
                <td ><?php echo $challanInfo->dipositor ?></td>
                <td  style="text-align:right"><strong>Challan Date:</strong></td>
                <td > <?php echo $challanInfo->challan_date; ?></td>
            </tr>    

        </table> 

        <br/>
        <br/>
        <br/>


        <table style="width:100%; ">
            <thead>
                <tr style="background:#CCC">
                    <th style="text-align: left">Sl no.</th>
                    <th style="text-align:left">Emp Name</th>
                    <th>TIN</th>
                    <th style="text-align: center">Month</th>                        
                    <th style="text-align:right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $slNo = 1;
                foreach ($challanDetailInfo AS $item) {
                    ?>
                    <tr>
                        <td style="text-align: left"><?php echo $slNo++; ?></td>
                        <td style="text-align:left"><?php echo $item->emp_name; ?></td>
                        <td>
                            <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class"   class="edit_data" id="tin" data-type="text" data-title="Change Employee TIN" data-pk="<?php echo $item->id; ?>" data-url="<?php echo base_url(); ?>challanController/updateChallanDetailData" >                                         
                                <?php echo $item->tin; ?>
                            </a>
                        </td>                            
                        <td style="text-align: center">

                          
                            <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class" data-format="dd-mm-yyyy"  class="edit_data" id="year" data-type="date"data-title="Change Challan Month" data-pk="<?php echo $item->id; ?>" data-url="<?php echo base_url(); ?>challanController/updateChallanDetailData" >                                         
                                <?php echo $item->month_name . "' " . $item->year; ?>
                            </a>  

                        </td>
                        <td style="text-align: right">
                            <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class"   class="edit_data" id="amount" data-type="text" data-title="Change Amount" data-pk="<?php echo $item->id; ?>" data-url="<?php echo base_url(); ?>challanController/updateChallanDetailData" >                                         
                                <?php echo $item->amount; ?>
                            </a></td>

                    </tr>
                    <?php
                }
                ?>

                <tr>
                    <td colspan="4" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Total:</td>
                    <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">
    <?php
    echo $challanInfo->total;
    ?>
                    </td>
                </tr>


            </tbody>
        </table>


<?php } ?>
</div>