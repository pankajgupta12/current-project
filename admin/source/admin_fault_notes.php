<?php 

$job_id = $_REQUEST['job_id'];
//$details_data['issue_type'] = 0;
$q_details =  mysql_fetch_assoc(mysql_query("SELECT id , ssecret FROM quote_new WHERE booking_id=".mres($job_id).""));
?>

<div class="body_container">
	<div class="body_back">
		<span class="main_head" style="margin-bottom: -33px;">Admin Fault Notes</span>
		    <div class="container cleaner_report">   
					<div class="col-md-6">
		               <span><?php   echo   create_dd("admin_id","admin","id","name","is_call_allow = 1 AND status = 1","",'',$r); ?> </span>
					   
					    <div class="text_box staff_details" style="margin-top:2px;">
					      <textarea name="message_comments" id="message_comments" class="textarea_box_notes" placeholder="please enter Notes"></textarea>
					    </div>
				
				        <button type="Submit" onclick="admin_faults_notes('<?php  echo $q_details['id']; ?>' ,'<?php echo $job_id; ?>');reset_notes();">Save</button>
				    </div>
					
					<div id="save_clener_notes" class="col-md-6">
						
					  <?php 
					   $quote_id = $q_details['id'];
					   // include('xjax/view_fault_notes.php'); ?>					
					</div>
		    </div>
		
    </div>
</div>

<style>

  .cleaner_report {
    margin-top: 35px;
}
.cleaner_report .col-md-6 {
    width: 48%;
    float: left;
}
  .cleaner_report span select {
    max-width: 535px;
    width:98%;
    display: block;
    padding: 8px;
    border-radius: 4px;
    margin: 5px 0px;
}
.cleaner_report .staff_details textarea { border-radius: 4px; width:96%;  }
.cleaner_report button {
    background-color: #00b8d4;
    border: none;
    color: #fff;
    padding: 10px 30px;
    display: block;
    border-radius: 4px;
    font-size: 16px;
    font-weight: 600;
}
#save_clener_notes .all_notes {
    margin: 4px 0px;
    border-radius: 4px;
}
</style>

<script>
  function admin_faults_notes(qid ,jobid){
	  
	 var admin_id =  $('#admin_id').val();
	 var message_comments =  $('#message_comments').val();
	 
	 var str = qid+'|'+jobid+'|'+admin_id+'|'+btoa(message_comments)+'|1';
	 
	// var str = issue_type+'|'+clener_comments+'|'+job_id+'|'+get_staff_name;
	/*  var clener_comments =  $('#clener_comments').val();
	 clener_comments =  clener_comments.replace("&", "#39;");
	 var str = issue_type+'|'+clener_comments+'|'+job_id+'|'+get_staff_name; */
	 send_data(str , 568 , 'save_clener_notes');
	 
  }
  function reset_notes(){
	  $('#admin_id').val(0)
	  $('#message_comments').val('')
	 // $('#clener_comments').val('')
  }
</script>