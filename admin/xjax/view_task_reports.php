<?php 


if(!isset($_SESSION['task']['from_date'])){ $_SESSION['task']['from_date'] = date("Y-m-1",  strtotime('-2 month')); }
if(!isset($_SESSION['task']['to_date'])){ $_SESSION['task']['to_date'] = date("Y-m-t"); }


 //print_r($_SESSION['task']);
 

		$arg =  mysql_query("SELECT name , id, auto_role , login_status ,   (SELECT name from system_dd WHERE id = auto_role AND type = 102 ) as roles , permanent_role   FROM `admin` WHERE `is_call_allow` = 1 AND status != 0  order by auto_role asc");
		//$arg =  mysql_query("SELECT name , id, auto_role , login_status ,   (SELECT name from system_dd WHERE id = auto_role AND type = 102 ) as roles , permanent_role   FROM `admin` WHERE `is_call_allow` = 1 AND status != 0 AND ( auto_role = 1 OR permanent_role = 1 )");
		$getadmin = array();
        $countAdmin = mysql_num_rows($arg);
			while($adminname = mysql_fetch_assoc($arg)) {
				  $getadmin[$adminname['id']] = $adminname;
			}

  
	 $getadmin[0] = array('name'=>'Other','id'=>0,'roles'=>'Others');
	 //array_push($getadmin);
	$task = dd_value(104);
	

	
?>
    <span class="staff_text" style="margin-bottom: -11px;margin-left: 15px;">Sales Task Report</span>
    <br/><br/>
    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
	   
	     <tr class="table_cells">
			  <td><strong>Admin Name</strong></td>
			  <td colspan="3"><strong>Cleaning</strong></td>
			  <td colspan="3"><strong>Removal</strong></td>
			  
		</tr>
	
		<tr class="table_cells">
			  <td><strong>Admin Name</strong></td>
			  <?php  foreach($task as $name) { ?>
			    <td><strong><?php echo ucfirst($name); ?></strong></td>
			  <?php  } ?>
			 
			 <?php  foreach($task as $name) { ?>
			    <td><strong><?php echo ucfirst($name); ?></strong></td>
			  <?php  } ?>
			  
		</tr>
		<?php  foreach($getadmin as $adminid=>$aname) {
		 
		?>
			<tr>
				<td>
				    <?php//  echo $adminid;  ?>
				    <a style="color:<?php if($aname['login_status'] == 1) { echo '#038c17';  }else { echo '#ec2819'; } ?>" href="javascript:scrollWindow('sales_quote_list.php?task=quote&adminid=<?php echo $adminid; ?>&type=0&fromdate=<?php echo $_SESSION['task']['from_date']; ?>&to_date=<?php echo $_SESSION['task']['to_date']; ?>','1200','1000')">
				    <?php echo ucfirst($aname['name']); ?></a>
				    
				    <?php  echo  '('.$aname['roles'].')'; ?>
				</td>
				 <?php  foreach($task as $taskid=>$name11) { 

				 $getdata = getTaskReCord($adminid ,$taskid , $_SESSION['task']['from_date'] ,  $_SESSION['task']['to_date'] ,1 ,'' , 1);
				 ?>
				<td><?php if($getdata != 0) { echo $getdata; }else{echo '-';} ?></td>
				 <?php  } ?>
				 
				  <?php  foreach($task as $taskid=>$name11) { 

				 $getdata = getTaskReCord($adminid ,$taskid , $_SESSION['task']['from_date'] ,  $_SESSION['task']['to_date'] ,1, '', 2);
				 ?>
				<td><?php if($getdata != 0) { echo $getdata; }else{echo '-';} ?></td>
				 <?php  } ?>
			</tr>
		 <?php  } ?>
		 
    </table>