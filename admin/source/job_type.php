<?php

$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($_REQUEST['job_id']).""));
//$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($_REQUEST['job_id']).""));


?>

<script>
	$(function() {
		  $(".a_job_date").datepicker({dateFormat:'yy-mm-dd'});
	});		
</script>
<br>
<br>


<span class="job_detail_text">Add Job Type</span>
<div class="f_table_main">
   <div class="input_list_table_below">
    <table>
        <thead>
            <th>Type</th>
            <th>Staff</th>
            <th>Date</th>
            <th>Time</th>
            <th>Amount</th>
            <th>Staff Amount</th>
            <th>Profit</th>
            <th></th>
        </thead>
        <tbody>
            <tr>
                <td style="padding-left:5px;">
				<span><?php 
                // get_staff_adetails
                //$a_onchange = "onchange=\"javascript:send_data('a_job_type','','get_staff_div');\"";
                $a_onchange = "onchange=\"javascript:get_staff_adetails('".$jobs['site_id']."');\"";
                echo create_dd("a_job_type","job_type","id","name"," id not in (select job_type_id from job_details where job_id=".$jobs['id']." and status!=2) AND id != 11 ",$a_onchange,$details); ?></span></td>
                <td><div id="get_staff_div">
                <span>
            <?php echo create_dd_staff("a_staff_id","staff","id","name"," (site_id=".$jobs['site_id']." OR site_id2=".$jobs['site_id']." OR all_site_id in (".$jobs['site_id'].")) and status=1","",""); ?></span>
            </div></td>
                <td><input name="a_job_date" type="text" id="a_job_date"  class="a_job_date" size="10" value="<?php echo $jdetails['job_date'];?>"></td>
                <td><input name="a_job_time" type="text" id="a_job_time" size="10" value="8:00 AM"></td>
                <td><input name="a_amount_total" type="text" id="a_amount_total" size="10" value=""></td>
                <td><input name="a_amount_staff" type="text" id="a_amount_staff" size="10" value=""></td>
                <td><input name="a_amount_profit" type="text" id="a_amount_profit" size="10" value=""></td>
                <td style="background:#7b7b7b;"><input type="button" name="submit_button" id="submit_button" value="Add Job Type" onclick="javascript:add_job_type(<?php echo $_REQUEST['job_id'];?>);" /></td>
            </tr>
        </tbody>
    </table>
    </div>
</div>


<span class="job_detail_text">Job Types</span>
<div class="f_table_main">
   <div class="input_list_table_below" id="job_type_div">
	<?php
		$job_id=$_REQUEST['job_id'];
		include("xjax/view_job_details.php");
	?>  
    </div>
</div>
<script>
	$("#comments").keyup(function(event){
		if(event.keyCode == 13){
			$("#comments_button").click();
		}
	});
</script>

