<script>
	$(function() {
		  $("#a_job_date").datepicker({dateFormat:'yy-mm-dd'});
	});		
</script>
<br>
<br>


<span class="job_detail_text">View Email</span>
<div class="f_table_main">
   <div class="">
    <table>
        <thead>
            <th>Date</th>
            <th>Email</th>
            <th>Subject</th>
			<th>Mail Type</th>
        </thead>
        <tbody>
        <?
		$getEmailID = array();
        $emails = mysql_query("select * from job_emails where job_id=".mysql_real_escape_string($_REQUEST['job_id'])." order by date desc");
		while($r = mysql_fetch_assoc($emails)){ 
		
			if($r['bcic_email_id'] != 0 && $r['bcic_email_id'] != '') {
				$getEmailID[] = $r['bcic_email_id'];
		    }
		
		?>
            <tr>                
                <td><?php echo $r['date'];?></td>
                <td><?php echo $r['email'];?></td>
                <td><a href="javascript:showdiv('ediv<?php echo $r['id'];?>');"><?php echo $r['heading'];?></a></td>
				<td><?php echo $r['mail_type'];?></a></td>
            </tr>
            <tr>                
                <td colspan="3" id="ediv<?php echo $r['id'];?>" style="display:none;"><?php echo $r['comment'];?></td>
            </tr>
          <? } ?>        
        </tbody>
    </table>
    </div>
</div>
<?php  if(!empty($getEmailID)) { ?>
<br/>
<span class="job_detail_text">Email Notes</span>
<div class="f_table_main">
   <div class="">
    <table>
        <thead>
            <th>Date</th>
            <th>Heading</th>
            <!--<th>Comment</th>-->
			<th>Staff By</th>
        </thead>
        <tbody>
        <?
		
         $emailsnotes = mysql_query("SELECT *  FROM `email_notes` WHERE `email_id` IN (".implode(',', $getEmailID).")  order by id desc");
		 // echo  $emailsnotes;
		 while($getEmailNotes = mysql_fetch_assoc($emailsnotes)){ 

		?>
            <tr>                
                <td><?php  echo date("h:i a dS M Y",strtotime($getEmailNotes['date']));?></td>
                <!--<td><?php echo $getEmailNotes['heading'];?></td>-->
                <td><a href="javascript:showdiv('ediv<?php echo $getEmailNotes['id'];?>');"><?php echo $getEmailNotes['heading'];?></a></td>
                <td><?php  echo $getEmailNotes['staff_name'];?></a></td>
            </tr>
            <tr>                
                <td colspan="3" id="ediv<?php echo $getEmailNotes['id'];?>" style="display:none;"><?php echo $getEmailNotes['comment'];?></td>
            </tr>
          <? }  ?>        
        </tbody>
    </table>
    </div>
</div>
<?php } ?>


