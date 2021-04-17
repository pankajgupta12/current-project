
<?php  

session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

  if(isset($_POST)) { 
  
		$trackid = $_POST['id'];
		$track_id = $_POST['track_id'];
		$trackid_head = $_POST['trackid_head'];
		
		
		$slq = mysql_query("SELECT * FROM `operation_ans` WHERE  sales_id = ".$trackid." AND track_id = ".$track_id."  and track_head_id = ".$trackid_head."");
		$count = mysql_num_rows($slq);
		
		 $trackdetails = mysql_fetch_assoc(mysql_query("SELECT id , quote_id , job_id   FROM `sales_task_track` WHERE `id` = ".$trackid.""));
		$gettrackdata =  dd_value(112);
		  $getsubdata = getsubheading($track_id);
	if($count == 0) {	
		
		
		$argsql1 = mysql_query("SELECT * FROM `operation_checklist` WHERE tracks_id = ".$track_id." and track_heading = ".$trackid_head." AND status = 1"); 
   
    $countre = mysql_num_rows($argsql1);
   
  
  
 ?> 


    <div class="question_div">
	   <h4> <?php echo $gettrackdata[$track_id]; ?> ( J#<a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php  echo $trackdetails['job_id']; ?>','1200','850')"><?php  echo $trackdetails['job_id']; ?></a>)</h4>
	   <h6 style="font-weight: 600;"><?php echo $getsubdata[$trackid_head]; ?></h6>
	     <?php/*  if(isset($_POST['msg']) && $_POST['msg'] != '') { ?> <p style="color: #097309;font-size: 17px;margin-left: 242px;margin-top: -31px;padding: 3px;"> Your question is saved successfully</p><?php  } */ ?>
			<table class="question_heading">
					  <tr>
						<th>ID</th>
						<th>Qus</th>
						<th>Check</th>
					  </tr>
						  <?php  if($countre > 0) { 
						   $i = 1; while($data = mysql_fetch_assoc($argsql1)) {
						  ?>
							  <tr> 
								<td><?php echo $i; ?></td>
								<td>
								<input type="hidden" id="qus[]" name="qus[]" value="<?php echo $data['id']; ?>">
								<?php echo $data['qus'];	?></td>
								<td><input type="checkbox"  id="ans_data" name="ans_data" value="<?php echo $data['id']; ?>"></td>
							  </tr>
							<?php $i++; }  }else { ?>
							<tr>
								<td colspan="5">No Question</td>
							</tr>	
							<?php  } ?>	
			
			  
			</table>
			<?php  if($countre > 0) {  ?>
			<div class="question_submit_btn">
			  <input type="submit" name="submit" value="submit" onClick="saveFormData('<?php echo $trackid; ?>','<?php echo $track_id; ?>', '<?php  echo $trackid_head; ?>');">
			</div>
			<?php  } ?>
    </div>
	
	<?php } else { include_once('operation_question_view.php');
	} ?>
	
	<style>
.question_div .question_heading, td, th {
  border: 1px solid black;
}

.question_div.question_heading {
     border-collapse: collapse;
    width: 80%;
    margin-left: 5%;
    height: 100%;
}

</style> 
  <?php  } ?>	
  
  