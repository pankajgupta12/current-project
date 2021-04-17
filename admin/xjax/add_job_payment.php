 <table class="start_table_tabe3">
        <thead>
          <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Taken By</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <td><input name="p_date" type="text" id="p_date" value="<?php echo date("Y-m-d");?>" placeholder="60" /></td>
          <td><input name="p_amount" type="text" id="p_amount" value="<?php echo $total_amount;?>" /></td>
          <td>
		  <span class="left_drop_down" style="width:90%">
             <span style="width:90%">
		  <?php echo create_dd("p_payment_method","system_dd","name","name",'type=27',"onchange=\"javascript:cehck_account_realestate(this,".$jobs['id'].");\"",$details); ?>
          	</span>
           </span>
           </td>
          <td>
          	<span class="left_drop_down" style="width:90%">
                <span style="width:90%">
                  <select id="p_taken_by" name="p_taken_by">
                    <option value="0">Select</option>                
                    <option value="BCIC">BCIC</option>
                    <?
                    $staff_data = mysql_query("select * from staff where id in (select staff_id from job_details where job_id=".$job_id.")");
                    while($staff = mysql_fetch_assoc($staff_data)){                     
                        echo '<option value="'.$staff['name'].'">'.$staff['name'].'</option>';
                    }
                    ?>
                </select> 
                </span>
            </span>
          </td>
          <td><input type="button" name="submit_button" id="submit_button" value="Add Job Payment" onclick="javascript:add_job_payment(<?php echo $job_id;?>);" /></td>
        </tr>
        </tbody>
      </table>
	  
<script>
	    function cehck_account_realestate(id, jid){
		   
		    if(id.value == 'Account') {
			  var str = id.value+'|'+jid;
			  div = id.jid;
			  send_data(str , 563,div);
		    }
	    }  
</script>	  