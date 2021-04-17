

  <link rel="stylesheet" href="../admin/sales_system/css/bootstrap.min.css">
  <link rel="stylesheet" href="../admin/sales_system/css/style.css">
   
	<style type="text/css">

 .selt-left {
    position: absolute;
    left: -108%;
    top: -9px;
    bottom: 0px;
}
.selt-left .formfields {
    font-family: Arial,Helvetica,sans-serif;
    font-size: 14px;
    color: #483f3f;
    text-decoration: none;
    background-color: #FFF;
    border: 1px solid #00b8d4;
    padding: 10px 10px 10px 5px;
    border-radius: 5px;
}
		.add_popup {
			position: absolute;
			right: 575px;
			top: 105px;
			z-index:1;
			background-color: #00b8d4;
			padding: 5px 15px;
			color: #fff;
			border-radius: 4px;
			font-size: 18px;
		}
		.add_popup_main .modal {
			width: inherit;
		}
		
		.add_popup_main .modal-dialog {
			z-index: 9999;
			top: 20%;
		}
		
		.add_popup_main .modal-body input {
    width: 100%;
    padding: 15px 10px;
    background-color: #f1f1f1;
    border: solid 1px #eaeaea;
    border-radius: 4px;
}
		#get_quote_details ul {
    height: 300px;
    overflow: auto;
    margin: 0px 15px;
    border-radius: 4px;
}
		#get_quote_details ul li {
    display: inherit;
    padding: 15px 10px;
    margin: 2px 0px;
    background-color: #f4f4f4;
    cursor: pointer;
	font-size: 17px;
    font-weight: 600;
}
#show_infodata {
    margin: 0px 15px;
}

 .add_popup_main .modal-content #show_infodata p { font-size: 17px; padding:3px 0px}
 #show_schedule input {
    padding: 8px;
    margin: 5px 10px 5px 0px;
    background-color: #f1f1f1;
    border: solid 1px #eaeaea;
    border-radius: 4px;
}
#show_schedule span select {
    background-color: #f1f1f1;
    border: solid 1px #eaeaea;
    padding: 7px;
    margin: 2px 10px 0px 2px;
    border-radius: 4px;
}
#show_infodata .show_system select {
    background-color: #f1f1f1;
    border: solid 1px #eaeaea;
    padding: 7px 20px 7px 20px;
    margin: 2px 10px 0px 2px;
    border-radius: 4px;
	font-size:17px;
	font-family: 'Titillium Web', sans-serif;
}
 .add_popup_main #show_infodata .btn-success {
    color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;
    padding: 6px 20px!important;
    font-size: 17px!important;
    position: relative;
    top: -2px;
}
.search_sales_data {
    position: relative;
    z-index:2;
    top: 10px;
    top: 10px;
    left: 30px;
	width:60%;
}
.search_sales_data li {
    list-style: none;
    display: inline-block;
    padding: 0px 10px 0px 0px;
}
.search_sales_data li input {
    padding: 5px;
    margin-left: 5px;
}
.search_sales_data li select {
    padding: 10px 5px;
    margin-left: 5px;
}
.search_sales_data li input[type=button] {
    background-color: #00b8d4;
    border: none;
    color: #fff;
    border-radius: 4px;
    padding: 6px 10px;
    font-size: 16px;
}
	
	</style>

  
   <?php  
   /*  $fromtoday = date('Y-m-d H:i:s' , strtotime('-30 minutes'));
	$lasttoday = date('Y-m-d H:i:s' , strtotime("+90 minutes")); 
    $today1 = date('Y-m-d');
	
	$argsql11 = "select id from sales_system  where 1 = 1  AND task_manage_id = ".$_SESSION['admin']." AND   quote_id in (select id  from quote_new where 1 = 1 AND ( booking_date >= '".$today1."'  OR booking_date = '0000:00:00' ) AND booking_id = 0 AND step not in (8,9,10) AND  denied_id = 0)"; 

	$argsql11 .=  " AND  fallow_date >= '".$fromtoday."' AND fallow_date <= '".$lasttoday."'";
   
   //echo $argsql11; 
	$argsql1 = mysql_query($argsql11);
	$count223 = mysql_num_rows($argsql1); */

 ?>
 
 
  
    <ul class="search_sales_data">
	        <li><strong>Quote Type</strong>
							<span>
							    <?php echo create_dd("quote_type","system_dd","id","name","type=63 AND id != 3","",$_SESSION['view_quote_aSearching']);?>
							</span>
						</li>
						
					<li><strong>From date</strong>
							<input class="date_class" type="text"  placeholder="From date" name="from_date" id="from_date" value="<?php if($_SESSION['view_quote_aSearching']['from_date'] != '') {echo $_SESSION['view_quote_aSearching']['from_date'];} ?>" >
						</li>
						
						
						<li><strong>To date</strong>
							<input class="date_class" type="text"  placeholder="To date" name="to_date" id="to_date" value="<?php if($_SESSION['view_quote_aSearching']['to_date'] != '') {echo $_SESSION['view_quote_aSearching']['to_date'];} ?>" >
						</li>
                      <li><strong>Response</strong>
							<span><?php echo create_dd("response","system_dd","id","name","type=33","",$_SESSION['view_quote_aSearching']);?></span>
						</li>	

                        <li>
							<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onClick="javascript:a_search_sales_search();">	
						</li>
						
						<li>
							<input type="button" name="reset" value="Reset"  onClick="a_search_sales_reset();" class="offsetZero btnSet a_search_box" >	
						</li>						
	 <span><h3>Task Manager</h3></span>
    </ul>
  
   
  
	
   <p id="time" style="font-weight: 600;font-size: 13px;color: #333;position: absolute;top: 114px;z-index: 2;right: 300px;">Current AU Time : <?php echo date('dS M Y H:i:s A');?>
   
    <?PHP  if(in_array($_SESSION['admin'], array(1,72, 12,3,17))) { ?>
	
       <span class="selt-left"><?php echo  create_dd("task_type","admin","id","name","is_call_allow = 1 AND status = 1","onchange=javascript:get_data(this.value);",$_SESSION['adminid']); ?></span>
	 
    <?php  } ?>
   </p>
   
  
    <div class="ser-botm">
	 
	 <div class="sales_noti task_noti"><!--<a class="applic-btn"><i class="fa fa-bell" aria-hidden="true"></i><?php  //echo $count223; ?></a>-->

	  <a onKeyup="search_task_list(1);" class="serch-but"><input type="text" id="search_val" autocomplete="off" name="serch"></a>
	  

	</div>
	 
	 </div>
    <div id="quote_view">
	  <? 
	   unset($_SESSION['task_manage']['value']);
	   unset($_SESSION['adminid']['id']);
	   $_SESSION['task_manage']['value'] = '';
	   $_SESSION['task_manage']['value'] = 0;
	  include("xjax/view_task_manager.php"); 
	  ?>
  
    </div>

<div class="add_popup_main">
	 <button type="button" class="btn btn-info btn-lg add_popup" data-toggle="modal" data-target="#add_popup" onClick="showpopup();">Add Task</button>
	 
	
  
	  <!-- Modal -->
		<div id="add_popup" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add New Task</h4>
			  </div>
			  <span id="message_data" style="padding: 16px;font-size: 15px;font-weight: 600; color: green;"></span>
			  <div class="modal-body">
				  <input type="text" id="get_value" onkeyup="getquoteDetails(this.value);" placeholder="Task Search">
			  </div>
			  <span id="get_quote_details"> </span>
			   
			   
			   
			<div id="show_infodata" style="display:none;">  
			 
						<p id="get_name"></p>
						<p id="get_mobile"></p>
						<p id="get_emails"></p>
			  
			    
			  
			  
			           <span id="show_schedule" >
								   <input size="16" type="text"  name="fallow_created_date" autocomplete="off" value="<?php // echo $getdata['fallow_created_date']; ?>" id="fallow_created_date" class="follow_date_class_1">
									<span>
										<select name="fallow_time"  id="schedule_time_id">
										<option value=''>Select</option>
										  <?php  
											$minutes = get_minutes('01:00', '23:00');  
											foreach($minutes as $key=>$minute) {
												//if(($getdata['fallow_time'] == $minute)) { $selected = 'selected'; }else { $selected = '';} 
											   echo '<option value='.$minute.'>'.$minute .'</option>';  
											}  
										  ?>
										
										</select>
									
									</span>
							</span>
							
					<span class="show_system"><?php  echo create_dd("stage_id","system_dd","id","name","type=103","",$r);  ?>	</span>
			       <button type="button" class="btn btn-success btn-sm" onClick="save_details();">Save</button>
			</div>	   
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>
</div>

<script>

   $(document).ready(function () {
				 $('.follow_date_class_1').datepicker({dateFormat:'yy-mm-dd'});
            }); 
			
			
	function save_details(){
		
		
		
		 var qid = $('#get_value').val();
		 var fallow_created_date = $('#fallow_created_date').val();
		 var schedule_time_id = $('#schedule_time_id').val();
		 var stage_id = $('#stage_id').val();
		 
		  if(fallow_created_date == '' || schedule_time_id == '') {
			  alert('Please select Follow up date');
			  return false;
		  }
		 

		  var DataString = 'qid='+qid+'&fallow_created_date='+fallow_created_date+'&schedule_time_id='+schedule_time_id+'&stage_id='+stage_id;
		
		  $.ajax({
							url: 'xjax/ajax/save_quote_in_sales_system.php',
							type: 'POST',
							datatype: 'html',
							data: DataString,
							success: function(resp){
								$('#message_data').text('#Q'+qid+' Follow up date saved on '+fallow_created_date);
								$('#fallow_created_date').val('');
								$('#schedule_time_id').val(0);
								$('#stage_id').val(0);
								//$('#show_infodata').hide();
							} 
					});  
	}			

 function showpopup(){
	  $('#get_value').val('');
	  $('#get_quote_details').html('');
	  $('#message_data').text('');
	  $('#show_infodata').hide();
	  $('#show_infodata').css('display','none');
 }
 function getquoteDetails(id){
	    if(id.length > 3) {
			  
			   var qid = id;
			  
		    var DataString = 'qid='+qid;
		  
		            $.ajax({
							url: 'xjax/ajax/get_quote_details_data.php',
							type: 'POST',
							datatype: 'html',
							data: DataString,
							success: function(resp){
								$('#get_quote_details').html(resp);
								$('#show_infodata').hide();
								 $('#message_data').text('');
								
								
							} 
					});  
	    }else{
			$('#get_quote_details').html('');
			$('#show_infodata').hide();
			 $('#message_data').text('');
		}
	 
 }
 
  function get_data(id) {
	   send_data(id , 576 , 'quote_view');
  }
 
 function a_search_sales_search(){
	 // quote_type  from_date to_date response
	 
	 var quote_type = $('#quote_type').val();
	 var from_date = $('#from_date').val();
	 var to_date = $('#to_date').val();
	 var response = $('#response_').val();
	 
	 var str = quote_type + ' | '+from_date +'|'+to_date +'|'+response;
	  send_data(str , 579 , 'quote_view');
	 
 }
	 function a_search_sales_reset(){
			$('#quote_type').val(0);
			$('#from_date').val('');
			$('#to_date').val('');
			$('#response_').val(0);

			var str = '0|||0';
			send_data(str , 579 , 'quote_view');
	 }
</script>
