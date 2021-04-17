<?php  

    //print_r($_SESSION['quote_sales_list']);
	
  //$_SESSION['quote_sales_list']['adminid'] tasktype from_date to_date
if($_SESSION['quote_sales_list']['adminid'] != 0) {$adminid =  $_SESSION['quote_sales_list']['adminid'];}else { $adminid =   $adminid; }
if($_SESSION['quote_sales_list']['tasktype'] != '') { $tasktype =  $_SESSION['quote_sales_list']['tasktype'];}else { $tasktype =  0; }
if($_SESSION['quote_sales_list']['from_date'] != '') {$from_date =  $_SESSION['quote_sales_list']['from_date'];}else { $from_date =  $from_date; }
if($_SESSION['quote_sales_list']['to_date'] != '') {$to_date =  $_SESSION['quote_sales_list']['to_date'];}else { $to_date =  $to_date; }
if($_SESSION['quote_sales_list']['quote_type'] != '') {$quote_type =  $_SESSION['quote_sales_list']['quote_type'];}else { $quote_type =  $quote_type; }

 //var_dump($adminid ,$tasktype , $fromdate ,  $to_date);
 //echo  $adminid . $tasktype;
   //echo  $adminid  . ' ==== ' .$tasktype  . ' ==== ' .$fromdate . ' ==== ' .$to_date; die;
   // $adminid = $adminid;
   $typedata = $_GET['type'];
   $getdata = getTaskReCord($adminid ,$tasktype , $fromdate ,  $to_date , 2 , $typedata , 0);
   //getTaskReCord($adminid ,$taskid , $_SESSION['task']['from_date'] ,  $_SESSION['task']['to_date'] ,1 ,'' , 1);
   //getTaskReCord($adminid ,$taskid , $_SESSION['task']['from_date'] ,  $_SESSION['task']['to_date'] ,1 ,'' , 2);
  // print_r($getdata) ;
   
   
   $qlist =  implode(',',$getdata);
   
   //$qunew = mysql_query("select * from quote_new where  id in (".$qlist.") ");
   $arg = "select * from quote_new where  id in (".$qlist.") ";
   
    if($quote_type == 1) {
		$arg.=  " AND moving_from = '' AND is_flour_from = 0  ";
	}elseif($quote_type == 2){
		$arg.=  " AND moving_from != '' AND is_flour_from > 0  ";
	} 
   
    /* if($quote_type == 1) {
      $arg.=  " AND id in (SELECT quote_id from quote_details WHERE job_type_id != 11 )";
    }elseif($quote_type == 2){
     $arg.=  " AND id in (SELECT quote_id from quote_details WHERE job_type_id = 11 )";
    }  */
   
   
   //echo $arg; die;
   $qunew = mysql_query($arg);
   
   $countre = mysql_num_rows($qunew);
  //$countre = 0;
   $step = dd_value(31);
   $adminname = getadminnamedata();
 ?>
  
    <br/>
	 
	 <style>
	.admin_list {
		width: 100%;
		margin: 0;
		padding: 0;
		list-style: none;
	}
	.admin_list li {
    padding: 10px 10px 10px 0px;
    display: inline-block;
}
.admin_list li a {
    background-color: #00BCD4;
    border: solid 1px #f1f1f1;
    padding: 5px 10px;
    border-radius: 6px;
    color: #ffff;
	cursor:pointer;
}
  /*  .red_color{ 
		height: 15px;
		width: 15px;
		background-color: #e52315;
		border-radius: 50%;
		display: inline-block;
   }
   .green_color{ 
		height: 15px;
		width: 15px;
		background-color: #00bcd4;
		border-radius: 50%;
		display: inline-block;
   } */
	 </style>
        
   <div class="right_text_boxData right_text_box">
	  <div class="midle_staff_box"><span class="midle_text"> Total Records <?php  echo   $countre; ?> </span></div>
	</div>
    <!--<br/>
	<span  class="red_color"></span> Sales  &nbsp;&nbsp; <span  class="green_color"></span> Not Sales <br/>
	 <br/>-->
	 <br/>
	    
	   <span id="text_message_data"></span>
            <table class="user-table" border="1px">
					<thead>
						<tr>
							<th><input type="checkbox" id="checkAll" name="checkid" value="<?php  //echo $data['id']; ?>" /></th>
							<th>Q id</th>
							<!--<th>Job id</th>-->
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Step</th>
							<?php if($typedata != 1) { ?>
							<th>Q Admin name</th>
							<?php  } ?>
							<th>Current Admin name</th>
							<?php if($typedata == 1) { ?>
							<th>Task Assigned</th>
							<?PHP  } ?>
							<th>Job Type</th>
						</tr>
					</thead>
					  
				<tbody>
					<?php  if($countre > 0) { 
					     while($data = mysql_fetch_assoc($qunew)) {
							 
							$qdata =  mysql_fetch_assoc(mysql_query("SELECT task_manage_id FROM `sales_task_track`  where quote_id = ".$data['id']." and task_status = 1"));
							
							//$sql_icone = ("select job_type_id , job_type from quote_details where  status != 2 AND quote_id=" . $data['id']);
							$job_type_id = get_sql("quote_details", "job_type_id", " where quote_id=" . $data['id']. " and job_type_id = 11");
							 
					?>
							
									<tr class="allcheckbox">
										<td> <?php  //if($adminname[$data['login_id']] == '') { ?> <input type="checkbox" name="checkid" value="<?php  echo $data['id']; ?>" />  <?php // } ?> </td>
										<td> <?php  echo $data['id']; ?> </td>
										<!--<td> <?php  echo $data['booking_id']; ?> </td>-->
										<td> <?php  echo $data['name']; ?> </td>
										<td> <?php  echo $data['email']; ?> </td>
										<td> <?php  echo $data['phone']; ?> </td>
										<td> <?php  echo $step[$data['step']]; ?> </td>
										<?php if($typedata != 1) { ?>
										<td> <?php  echo $adminname[$data['login_id']]; ?> </td>
										<?php  } ?>
										<td> <?php if($adminname[$adminid] != '') {  echo $adminname[$adminid];  } else {echo 'Not assign';}?> </td>
										<?php if($typedata == 1) { ?>
										<td> <?php if($adminname[$qdata['task_manage_id']] != '') {  echo $adminname[$qdata['task_manage_id']];  } else {echo 'Not assign';}?> </td>
										<?php  } ?>
										<td> <?php if($job_type_id == '11') {  echo 'Removal';  }?> </td>
									</tr>
					   <?php   } }else { ?>
						    <tr>
							 <td colspan="20"> No Found </td>
							</tr>
					   <?php  } ?>						
				</tbody>
            </table>

			
		<script> 
		 
			$( document ).ready(function() {
			   $("#checkAll").click(function(){
				   $('input:checkbox').not(this).prop('checked', this.checked);
				});
			});
				
		
			function moveQuote(adminid ,adminname) {
			  
			    if(adminname == 1) {
			       name = $( "#admin_id option:selected" ).text();
			    }else {
					name = adminname;
				}
				  
				 /*   alert(name);
				   return false; */
					var allqid = [];
						$('table .allcheckbox :checkbox:checked').each(function(i){
						   allqid[i] = $(this).val();
						});
				 var len = allqid.length	
				 //alert(len);
				 
				if(len == 0) {
						 alert('Please select admin name');
						 //$( "#admin_id" ).val(0);
						 return false;
				}else {
					var r = confirm("Are you sure do you want Quote move to " + name);
						 if (r == true) {
							// console.log(allqid);
						  var str = allqid+'|'+adminid;
						// console.log(str);		
						 send_data(str , 578,  'text_message_data');
						 // console.log(str);		 
					 }
				}
			}
		</script>	
			
			