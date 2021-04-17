	<link rel="stylesheet" href="source/popup/colorbox.css" />
	<script src="source/popup/jquery.colorbox.js"></script>
<!--LightBox--------->		

<br/><br/>
	<?php  
	 $job_id = $_REQUEST['job_id'];
	 /* echo  "SELECT * FROM `signature_image`  WHERE job_id = '".$job_id."' ORDER BY `id` DESC";
	 die; */
	 $sql = mysql_query("SELECT * FROM `signature_image`  WHERE job_id = '".$job_id."' ORDER BY `id` DESC");
	 
	 ?>
	
	<div class="body_container">
	<div class="body_back">
		<span class="main_head" style="margin-bottom: -22px;">Staff Signature</span>
		    <div class="container cleaner_report">   
					  <table border="1px" id="quote_questions_list2" class="quote_que quote_questions" style="width:100%; margin-top: 36px;">
					   							
							<thead>
								<tr>
									<th>Status</th>
									<th>Signature Img</th>
									<th>Date Time</th>
								</tr>
							</thead>
							<?php  
							if(mysql_num_rows($sql) > 0) {
							while($dataimg = mysql_fetch_assoc($sql)) { ?>
							<tbody>
							 <tr>
							    <td><?php if($dataimg['status'] == 1) { echo 'Success'; }else { echo 'Failed'; }?></td>
							    <td><a href="<?php  echo $dataimg['imglink'];  ?>" class="group1"><img style="width: 200px;" src="<?php echo $dataimg['imglink']; ?>"/></a></td>
							    <td><?php echo $dataimg['createdOn']; ?></td>
							 </tr>
							<?php  } }else { ?>
								<tr>
								  <td colspan= "4">Not Found</td>
								</tr>
							<?php } ?>
							</tbody>
					   							
						</table>
		    </div>
		
    </div>
</div>
    </div>	<script> 
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1' , width:'75%'});
				
			});
		</script>	