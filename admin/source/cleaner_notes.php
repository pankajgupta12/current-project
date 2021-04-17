<?php 

$job_id = $_REQUEST['job_id'];
//$details_data['issue_type'] = 0;
?>

<div class="body_container">
	<div class="body_back">
		<span class="main_head" style="margin-bottom: -33px;">Cleaner Notes</span>
		    <div class="container cleaner_report">   
					<div class="col-md-6">
		               <span><?php echo create_dd("get_staff_name","job_details","staff_id","staff_id","status != 2 AND job_id = ".$job_id." AND staff_id != 0 group by staff_id","","",'');?>  </span>
					   
					    <span><?php echo create_dd("issue_type1","system_dd","id","name","type=69","","",'');?> </span> 
					   
					    <div class="text_box staff_details" style="margin-top:2px;">
					      <textarea name="clener_comments" id="clener_comments" class="textarea_box_notes" placeholder="please enter Notes"></textarea>
					    </div>
				
				        <button type="Submit" onclick="save_clener_notes('<?php  echo $job_id; ?>');reset_notes();">Save</button>
				    </div>
					
					<div id="save_clener_notes" class="col-md-6">
						
					  <?php 
					   $job_id = $_REQUEST['job_id'];
					   include('xjax/view_clener_notes.php'); ?>					
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
  function save_clener_notes(job_id){
	  
	 var get_staff_name =  $('#get_staff_name').val();
	 var issue_type =  $('#issue_type1').val();
	 var clener_comments =  $('#clener_comments').val();
	 clener_comments =  clener_comments.replace("&", "#39;");
	 var str = issue_type+'|'+clener_comments+'|'+job_id+'|'+get_staff_name;
	 send_data(str , 513 , 'save_clener_notes');
	 
  }
  function reset_notes(){
	  $('#get_staff_name').val(0)
	  $('#issue_type1').val(0)
	  $('#clener_comments').val('')
  }
</script>