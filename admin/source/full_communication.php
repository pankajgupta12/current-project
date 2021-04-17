<?php 

  $job_id = $_REQUEST['job_id'];
  $sql_n =  mysql_query("SELECT *  FROM `job_notes` WHERE `job_id` = ".$job_id." order by date asc");
  $sql_e =  mysql_query("SELECT *  FROM `job_emails` WHERE `job_id` = ".$job_id."  order by date asc");
  
  $count_n = mysql_num_rows($sql_n);
  $count_e = mysql_num_rows($sql_e);
    
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<!------ Include the above in your HEAD tag ---------->
<div class="body_container">
	<div class="body_back">
	  <span class="main_head" style="margin-bottom: -33px;">Job  Communication Time Line</span>
	   <span class="main_head" style="float: right;"><a href="javascript:void(0);" onClick="send_full_info('<?php echo $job_id; ?>');">Send Email</a></span>
	   <span id="message_show"></span>
		<div class="container mt-5 mb-5">
			<div class="row">
				<div class="col-md-10">
					
					<ul class="timeline">
					
					  <?php    if($count_n > 0 || $count_e > 0) {
                                $fullgetdata_n = array();
                                while($getdata_n = mysql_fetch_array($sql_n)) {
									
									// print_r($getdata_n);
									    $fullgetdata_n[] = array
										                (
															 'type' =>'notes',
															 'table' =>'job_notes',
															 'id' =>$getdata_n['id'],
															 'quote_id' =>$getdata_n['quote_id'],
															 'date' =>$getdata_n['date'],
															 'heading' =>$getdata_n['heading'],
															 'comment' =>$getdata_n['comment'],
															 'check_status' =>$getdata_n['check_status'],
															 'staff_name' =>$getdata_n['staff_name']
									                    ); 
								}
								
                                
                                $fullgetdata_e = array();
                                while($getdata_e =  mysql_fetch_array($sql_e)) {
									// print_r($getdata_e);
									   $fullgetdata_e[] = array
									                    (
															 'type' =>'email',
															 'table' =>'job_emails',
															 'id' =>$getdata_e['id'],
															 'email' =>$getdata_e['email'],
															 'date' =>$getdata_e['date'],
															 'heading' =>$getdata_e['heading'],
															 'comment' =>$getdata_e['comment'],
															 'check_status' =>$getdata_e['check_status'],
															 'staff_name' =>$getdata_e['staff_name']
												        );
								}		
                            $fullgetdata  = array_merge($fullgetdata_n , $fullgetdata_e);	
						    usort($fullgetdata, date_compare($a, $b));	
              // print_r($fullgetdata);
								
							foreach($fullgetdata as $key=>$value) {
								
							?>
					
						<li <?php if($value['type'] == 'email') {  ?>class="notes_type" <?php  } ?>>
							
						    <span><input type="checkbox" id="check_notes_id_<?php echo $value['id']; ?>" value="<?php echo $value['id']; ?>" <?php  if($value['check_status'] == 1) {echo 'checked' ; } ?> onclick="cehck_notes('<?php echo $value['id']; ?>' , '<?php echo $value['table']; ?>')" name="value_check"></span>
							
							<div class="job-heading"><?php echo $value['heading']; ?> <?php  if($value['type'] == 'email') { ?> <span class="job_email">( <?php  echo $value['email']; ?>)</span><?php  } ?></div>
							
							<span class="float-right date-heading"><?php // if($value['n_id'] == 'notes') { echo '(Job Notes)'; }else { echo $value['email'].' (Email)'; }?>
							 <?php echo changeDateFormate($value['date'],'timestamp'); ?></span>
							<p class="job-comment"><?php if($value['comment'] != $value['heading']) { if($value['comment'] != '') { echo $value['comment']; }else { $value['heading']; }}?></p>
						</li>
							<?php  } 
							} ?>
					</ul>
				</div>
			</div>
		</div>

	</div>
</div>


<style>
.timeline li.notes_type {
	background: #fbf4f4c9;
}
.job-heading {
    font-size: 18px;
    color: #1e8c9c;
    display: inline-block;
    font-weight: 600;
}
.body_back input[type=checkbox] {
    width: 18px;
    height: 18px;
    margin-right: 5px;
	display: inline-block;
}
.job-comment{margin-left:28px;}
.job_email{font-size:14px; padding-left: 5px;}

 ul.timeline {
    list-style-type: none;
    position: relative;
	padding-left: 30px;
}
ul.timeline:before {
    content: ' ';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 29px;
    width: 2px;
    height: 100%;
    z-index: 400;
}
ul.timeline > li {
    margin: 20px 0;
    border-bottom: solid 1px #bdbdbd;
	padding: 0 30px;
}
ul.timeline > li:before {
    content: ' ';
    background: white;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 3px solid #22c0e8;
    left: 20px;
    width: 20px;
    height: 20px;
    z-index: 400;
}

</style>