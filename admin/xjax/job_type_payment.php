
    <div class="tab3_table1">
      <table class="start_table_tabe3">
        <thead>
          <tr>
            <th>Job Type New</th>
            <th>Staff Name</th>
            <!--<th>SMS Paid</th>-->
            <th>Amount</th>
            <th>Staff Amount</th>
            <th>Profit</th>
          </tr>
        </thead>
        <tbody>
<?php
		
		// ($field_name, $table,$id_field,$name_field,$cond = " 1 ",$onchng,$details)
		
		$job_details = mysql_query("select * from job_details where job_id=".$job_id." and status!=2");
	
		while($jdetails = mysql_fetch_assoc($job_details)){ 
		
			$total_amount+=$jdetails['amount_total'];
			$staff_name  = get_rs_value("staff","name",$jdetails['staff_id']);
			$onchng = "onchange=\"javascript:edit_field(this,'job_details.paid_sms',".$jdetails['id'].");\"";
			echo '<tr>
				  <td>'.$jdetails['job_type'].'</td>
				  <td>'.$staff_name.'</td>';
			//echo '<td>'.create_dd_value('paid_sms_'.$jdetails['id'],"system_dd","id","name"," type=30 ",$onchng,$jdetails['paid_sms']);
			
			//echo '</td>';
			
				  echo '<td><input name="amount_total_'.$jdetails['id'].'" type="text" id="amount_total_'.$jdetails['id'].'" value="'.$jdetails['amount_total'].'" onblur="javascript:edit_field(this,\'job_details.amount_total\','.$jdetails['id'].');" readonly></td>
				  <td><input name="amount_staff_'.$jdetails['id'].'" type="text" id="amount_staff_'.$jdetails['id'].'" value="'.$jdetails['amount_staff'].'" onblur="javascript:edit_field(this,\'job_details.amount_staff\','.$jdetails['id'].');" readonly></td>
				  <td><input name="amount_profit_'.$jdetails['id'].'" type="text" id="amount_profit_'.$jdetails['id'].'" value="'.$jdetails['amount_profit'].'" onblur="javascript:edit_field(this,\'job_details.amount_profit\','.$jdetails['id'].');" readonly></td>
				</tr>';
			}
			?>
        </tbody>
      </table>
    </div>