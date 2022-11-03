<script>
    $(function () {
        $(".delete_salary").click(function () {
            var id = $(this).attr('sal_id');
//            alert(id);
            var x = confirm("Are you sure you want to delete?");
            if (x) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>salary/deletesalary",
                    data: {id: id},
                    dataType: "text",
                    cache: false,
                    success: function (data) {
                        alert(data);
                        //$("#payRollModal").html(data);
                        $('#dialog-form').dialog("close");
                        window.location.reload(true);
                    }
                });
            } else {
                return false;
            }


        });
    });
</script>
<div id="dialog-form" title="Salary Increament History">
	<p class="validateTips"></p>
	<table  class="pop-up-table" cellspacing="0" width="100%" border="1">
		<thead>
			<tr class="">                                
				<th>Gross Salary</th>
				<th>Increament Amount</th>
				<th>Increament Percentage</th>
				<th>Fulfill Date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$salary_join_counter=1;
			$salary_count=count($salary_allamount_ascorder);
			foreach ($salary_allamount_ascorder as $single_salary) {
				$gross_salary =$single_salary['gross_salary'];
				$increment_amount =$single_salary['increment_amount'];
				$increment_percentage =$single_salary['increment_percentage'];
				$increment_date =$single_salary['increment_date'];
				$id =$single_salary['id'];

				?>
				<tr>                                    
					<td><?php print $gross_salary; ?></td>
                                        <td><?php  if($salary_join_counter!=1){ print $increment_amount; }?></td>
                                        <td><?php  if($salary_join_counter!=1){ print $increment_percentage; } ?></td>
					<td><?php if($salary_join_counter==1){
						print $emp_starting_date;
					}else{ print $increment_date; } ?>
				</td>
				<td>
				<?php 
				if($salary_count==$salary_join_counter && $this->session->userdata('user_type')==1){ ?>
					 <!--<a href="#" data-id="<?php echo $id; ?>" class="operation-edit operation-link salary-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit Details" /></a>--> 
					
                                        <button sal_id="<?php echo $id; ?>" class="operation-cut operation-link delete_salary btn-xs"> 
                                            <span class="glyphicon glyphicon-remove" style="color:red"></span>
                                        </button>
                                    
				<?php } ?>
				</td>
			</tr>
			<?php 
			$salary_join_counter++;
		} ?>
	</tbody>
</table>  				
</div>	