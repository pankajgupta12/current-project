<?php 


if(!isset($_SESSION['operation_task']['from_date'])){ $_SESSION['operation_task']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['operation_task']['to_date'])){ $_SESSION['operation_task']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['operation_task']['operation_type'])){ $_SESSION['operation_task']['operation_type'] = 1; }

//print_r($_SESSION['operation_task']); 

		$arg =  mysql_query("SELECT name , id  FROM `admin` WHERE `is_call_allow` = 1 AND status != 0");
		$getadmin = array();
        $countAdmin = mysql_num_rows($arg);
			while($adminname = mysql_fetch_assoc($arg)) {
			    $getadmin[$adminname['id']] = $adminname['name'];
			}

    $operationtype = $_SESSION['operation_task']['operation_type'];
	
	 $getadmin[0] = 'Other';
	 if($operationtype == 1) {
	   $task = dd_value(113);
	   $tasktype = 'Befor jobs';
	 }elseif($operationtype == 2){
		 //$task[0] = 'Total';
		  $task = dd_value(116);
		  $tasktype = 'On the day jobs';
		  $task['0'] = 'Total';
	 }elseif($operationtype == 3){
		 $task = dd_value(117);
		 $tasktype = 'After Jobs';
	 }elseif($operationtype == 4){
		 $task = dd_value(123);
		 $tasktype = 'Re-Clean Jobs';
	 }
	 ksort($task);
	 //print_r($task) ; 
	
	
?>
    <span class="staff_text" style="margin-bottom: -11px;margin-left: 15px;"><?php echo $tasktype; ?> Task Report</span>
    <br/><br/>
    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
		<tr class="table_cells">
			  <td><strong>Admin Name</strong></td>
			  <?php  foreach($task as $name) { ?>
			    <td><strong><?php echo ucfirst($name); ?></strong></td>
			  <?php  } ?>
			  <td><strong>Total</strong></td>
		</tr>
		
		<?php 
		//$totalre = arr; 
  		foreach($getadmin as $adminid=>$aname) 
		{
			?>
			<tr>
				<!--<td><a href="javascript:scrollWindow('sales_quote_list.php?task=quote&adminid=<?php echo $adminid; ?>&type=0&fromdate=<?php echo $_SESSION['task']['from_date']; ?>&to_date=<?php echo $_SESSION['task']['to_date']; ?>','1000','800')"><?php echo ucfirst($aname); ?></a></td>-->
				<td><?php echo ucfirst($aname); ?></td>
				 <?php  
				 
				   foreach($task as $taskid=>$name11) 
				    { 
                     
					  if($operationtype == 1) {
							 if($taskid != 7) {
								  if(in_array($taskid , array(5,6))) {		 
									 $getdata =  getOpr_Payment($taskid , $adminid);
									  $count = count($getdata[$taskid]);
									 // $type = 1;
								  }else{
									  $getdata = getBefor_jobDay($taskid, $adminid , $_SESSION['operation_task']['from_date'] , $_SESSION['operation_task']['to_date']);
									 $count = count($getdata[$taskid]);
									 //$type = 2;
								  }
							}else{
								$count = '';
							}
					  }else if($operationtype == 2) {
					      //$count = '-';
						  $today = date('Y-m-d');
						  $getdata =  OndayJobs($taskid , $today, 1 ,$adminid);
						  $count = count($getdata[$taskid]);
					}else if($operationtype == 3) {
						//$count = ''; 
						$getdata = getAfterJobs_data($taskid, $adminid , 1);
						$count = count($getdata[$taskid]);
					} else if($operationtype == 4) {
						$getdata = reclean_data($taskid, $adminid ,1);
						$count = count($getdata[$taskid]);
					} 
					 
					$totalre[$taskid] =  $count;
					$totalre1[$taskid][] =  $count;
				 ?>
				   <td><?php if($count != 0){  echo $count; } else {echo '-'; }  ?></td>
				 <?php  } ?>
				 
				<td><?php echo  array_sum($totalre); ?></td> 
			</tr> 
			
			
		 <?php  
		  
		   $alltotal11[] = array_sum($totalre);
		 
		}   
		  // print_r($alltotal11);
		 
		 ?>		
		    <tr>
			<td><strong>Total</strong></td>
		<?php   
		
		 foreach($totalre1 as $key=>$val) { 
			    
				 //print_r($val);
				 ?>
			 <td><strong><?php echo  array_sum($val); ?></strong></td>
		  <?php  }
        		?> 
			<td><strong><?php echo  array_sum($alltotal11); ?></strong></td>	
         </tr>		
		 
    </table>