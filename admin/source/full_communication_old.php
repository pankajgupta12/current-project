<?php 

  $job_id = $_REQUEST['job_id'];
  $sql_n =  mysql_query("SELECT *  FROM `job_notes` WHERE `job_id` = ".$job_id." order by date asc");
  $sql_e =  mysql_query("SELECT *  FROM `job_emails` WHERE `job_id` = ".$job_id."  order by date asc");
  
  $count_n = mysql_num_rows($sql_n);
  $count_e = mysql_num_rows($sql_e);
    
?>

<div class="body_container">
	<div class="body_back">
		<span class="main_head" style="margin-bottom: -33px;">Job Full Communication Time Line</span>
		<span class="main_head" style="float: right;"><a href="javascript:void(0);" onclick="send_full_info('<?php echo $job_id; ?>');">Send Email</a></span>
		<span id="message_show"></span>
		    <div class="container cleaner_report">   
					<div class="col-md-6">
		                <ul class="list_box_img all_notes">
							<?php    if($count_n > 0 || $count_e > 0) {
                                $fullgetdata_n = array();
                                while($getdata_n = mysql_fetch_array($sql_n)) {
									
									// print_r($getdata_n);
									    $fullgetdata_n[] = array
										                (
															 'n_id' =>'notes',
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
									   $fullgetdata_e[] = array
									                    (
															 'e_id' =>'email',
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
								
							foreach($fullgetdata as $key=>$value) {
								
							?>
							<li>
								<div class="main_images_box">
								<div class="job_created_left">
								
								<span class="job_created_text">
									 <span><input type="checkbox" id="check_notes_id_<?php echo $value['id']; ?>" value="<?php echo $value['id']; ?>" <?php  if($value['check_status'] == 1) {echo 'checked' ; } ?> onclick="cehck_notes('<?php echo $value['id']; ?>' , '<?php echo $value['table']; ?>')" name="value_check"></span>
									 <?php echo $value['heading']; ?><span class="right_date"><?php if($value['n_id'] == 'notes') { echo '(Job Notes)'; }else { echo $value['email'].' (Email)'; }?></span>
								</span>
								<span class="manish_text">By <?php echo $value['staff_name']; ?>
								<span class="right_date"><?php echo changeDateFormate($value['date'],'timestamp'); ?></span></span>
								</div> 
								</div>
								<span class="message_below_text"><?php if($value['comment'] != '') { echo $value['comment']; }else { $value['heading']; }?></span>	  
							</li>
							<?php } } ?>
						</ul>	
				    </div>
					
					<div id="save_clener_notes" class="col-md-6">
						
								
					</div>
		    </div>
		
    </div>
</div>
<style>
 .cleaner_report .col-md-6 {
    width: 76%;
    float: left;
}
</style>

<script>
    function cehck_notes(id , table_name){
			if($('#check_notes_id_'+id). prop("checked") == true){
			  var checked = 1; 
			}else if($('#check_notes_id_'+id). prop("checked") == false){
			  var checked = 0;
			}
			var str = id+'|'+checked+'|'+table_name;
			send_data(str,524 , 'check_notes_id_'+id);
	   //alert(id +'==='+table_name);
    }
	
	 function send_full_info(job_id){
		 if(confirm("Do You Want Send Email")) {
			 
			 send_email(job_id , 525 , 'message_show');
		 }
	 }
</script>

<?php  
 function date_compare($a, $b)
{
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t1 - $t2;
} 

?>