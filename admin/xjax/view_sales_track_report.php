<?php 


if(!isset($_SESSION['track']['from_date'])){ $_SESSION['track']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['track']['to_date'])){ $_SESSION['track']['to_date'] = date("Y-m-t"); }


 //print_r($_SESSION['task']);
 

   $arg =  mysql_query("SELECT name , id  FROM `admin` WHERE `is_call_allow` = 1 AND status != 0");
      $getadmin = array();
      $countAdmin = mysql_num_rows($arg);
	  while($adminname = mysql_fetch_assoc($arg)) {
		  $getadmin[$adminname['id']] = $adminname['name'];
	  }

  
	 $getadmin[0] = 'Other';
	 //array_push($getadmin);
	$track = dd_value(103);
	
?>
    <span class="staff_text" style="margin-bottom: -11px;margin-left: 15px;">Sales Track Stages Report</span>
    <br/><br/>
    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
		<tr class="table_cells">
			  <td><strong>Admin Name</strong></td>
			  <?php  foreach($track as $name) { ?>
			    <td><strong><?php echo ucfirst($name); ?></strong></td>
			  <?php  } ?>
			 
			  
		</tr>
		<?php  foreach($getadmin as $adminid=>$aname) {
          
		?>
		  <tr>
		    <td><?php echo ucfirst($aname); ?></td>
			 <?php  foreach($track as $taskid=>$name11) { 

           $getdata = getsalestrackReCord($adminid ,$taskid , $_SESSION['track']['from_date'] ,  $_SESSION['track']['to_date']);
			 ?>
		    <td><?php if($getdata != 0) { echo $getdata; }else{echo '-';} ?></td>
			 <?php  } ?>
		 </tr>
		 <?php  } ?>
		 
    </table>