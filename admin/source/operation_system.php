<?php  
if($_GET['task_type'] != ''  && $_GET['task_type'] != 0) {
	$_SESSION['operation']['task_type'] = $_GET['task_type'];
}else{
	$_SESSION['operation']['task_type'] = 1;
}


if($_GET['job_type_id'] != '') {
	$_SESSION['operation']['job_type_id'] = $_GET['job_type_id'];
}else{
	$_SESSION['operation']['job_type_id'] = 1;
}

 //$_SESSION['op_adminid']['task_manage_type'] = 0;
 if(!isset($_SESSION['op_adminid']['task_manage_type'])){ $_SESSION['op_adminid']['task_manage_type'] = 0; }
 
 $auto_role = get_rs_value("admin","auto_role",$_SESSION['admin']); 
 
 if($auto_role == 15) {
   //$admindetails1 = array('15'=>$_SESSION['admin']);
   $_SESSION['op_adminid']['task_manage_type'] = 'all';
 }
  $admindetails1 =  array_keys(getAdminDetailsData());
  //echo 'pankajtest';
  //print_r($admindetails1);
 
?>

  <link rel="stylesheet" href="../admin/sales_system/css/bootstrap.min.css">
  <link rel="stylesheet" href="../admin/sales_system/css/style.css">
   
	
   <div class="before_job_drp">
     <?PHP  if(in_array($_SESSION['admin'], $admindetails1)) { ?>
	
       <span class="selt-left"><?php echo  create_dd("task_manage_type","admin","id","name","is_call_allow = 1 AND status = 1","onchange=javascript:get_op_data(this.value);",$_SESSION['op_adminid'], '' , 'all'); ?></span>
	 
    <?php  } ?>
	
       <span class="selt-left"><?php echo  create_dd("task_type","system_dd","id","name","type = 112","onchange=javascript:get_operation_page(this.value);",$_SESSION['operation']); ?></span>
	   
	   <p id="time" style="">Current AU Time : <?php echo date('dS M H:i:s A');?> </p>
	 
   </div>
   
  
    <div id="quote_view">
	  <? 
	  // print_r($_SESSION['op_adminid']);
	  
	  /*  unset($_SESSION['op_adminid']['task_manage_type']);
	   $_SESSION['op_adminid']['task_manage_type'] = 0; */
	  include("xjax/view_operation_system.php"); 
	  ?>
  
    </div>
	
<script>
	 function get_operation_page(id) {
		 //alert('ddddd'+ id)
		 window.location.href = "../admin/index.php?task=operation_system&task_type="+id;
	 }
	 function get_operation_jib_type_id_page(id) {
		 window.location.href = "../admin/index.php?task=operation_system&task_type=2&job_type_id="+id;
	 }
	 
	 function get_op_data(id) {
	   send_data(id , 588 , 'quote_view');
    }
	function op_savefallowdate(id,type){
					  
					 if(type == 1) {			  
					  var fallowdate = $('#fallow_created_date').val();
					  var schedule_time = $('#schedule_time').val();
					 }else {
						var fallowdate = '';
						var  schedule_time = '';
					 }
					   
					// var DataString = 'id='+id+'&type='+type+'&fname='+fname+'&page=emailsms&textid='+textid;
					var DataString = 'id='+id+'&fallowdate='+fallowdate+'&page=schedule&schedule_time='+schedule_time+'&scheduletype='+type;
					
					//alert(DataString);
					   
								$.ajax({
									//url: 'xjax/ajax/sales_button_show.php',
									url: 'xjax/ajax/operations_button_show.php',
									type: 'POST',
									datatype: 'html',
									data: DataString,
									success: function(resp){
										$('#getdata').html(resp);
									} 

								});  
		}	
			
		function op_show_schedule(id){
			    if(id == 3){
			       $('#show_schedule').toggle();
				}else if(id == 2) {
					$('#quote_step').toggle();
				}
		   }
		   
		function send_noti(id,  jbid , contact_number, strhead){
			
			message = $('#message_content_'+id).val();
			var final_string = jbid+'|'+contact_number+'|'+btoa(message)+'|'+strhead;
		 divid = 'sms_result_'+id;
		 send_data( final_string , 253, divid);
		
			//alert(final_string);
		}   
</script>	

