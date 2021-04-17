<?php 


if(!isset($_SESSION['total_track']['from_date'])){ $_SESSION['total_track']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['total_track']['to_date'])){ $_SESSION['total_track']['to_date'] = date("Y-m-t"); }


 //print_r($_SESSION['task']);
 

    $arg =  mysql_query("SELECT name , id  FROM `admin` WHERE `is_call_allow` = 1 AND status != 0");
      $getadmin = array();
      $countAdmin = mysql_num_rows($arg);
	  while($adminname = mysql_fetch_assoc($arg)) {
		  $getadmin[$adminname['id']] = $adminname['name'];
	  }

  
  // print_r($getadmin); die;
   
	
	 //array_push($getadmin);
	$task = dd_value(104);
	
?>
    <span class="staff_text" style="margin-bottom: -11px;margin-left: 15px;">Total Task Report</span>
    <br/><br/>
    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
		<tr class="table_cells">
			  <td><strong>Admin Name</strong></td>
			  <?php  foreach($task as $name) { ?>
			    <td><strong><?php echo ucfirst($name); ?></strong></td>
			  <?php  } ?>
			 
			  
		</tr>
		<?php 

            if(!empty($getadmin)) {
				
				 $getadmin[0] = 'Other';
		foreach($getadmin as $adminid=>$aname) {
          
		?>
		  <tr>
		    <td><a href="javascript:scrollWindow('sales_quote_list.php?task=quote&adminid=<?php echo $adminid; ?>&type=1&fromdate=<?php echo $_SESSION['total_track']['from_date']; ?>&to_date=<?php echo $_SESSION['total_track']['to_date']; ?>','1000','800')"><?php echo ucfirst($aname); ?></a></td>
			 <?php  foreach($task as $taskid=>$name11) { 

             $getdata = getTaskReCord($adminid ,$taskid , $_SESSION['total_track']['from_date'] ,  $_SESSION['total_track']['to_date'] ,1 , 1);
			 ?>
		    <td><?php if($getdata != 0) { echo $getdata; }else{echo '-';} ?></td>
			 <?php  } ?>
		 </tr>
			<?php  } }else { echo ' <tr><td  colspan="10">No found</td></td>';} ?>
		 
    </table>