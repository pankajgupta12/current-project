<?php 

  
  if($_SESSION['daily_email_report_data']['from_date'] != '') {
		$today = $_SESSION['daily_email_report_data']['from_date'];
	}else{
		$today = date("Y-m-d");
	}
  
   $typeheading1 = array('Admin Name');
   $typeheading = array('2'=>'New' , '3'=>'Reply' , '4'=>'Forward' , '5'=>'Re-Clean Reply' , '6'=>'Re-clen Complaint' , '7'=>'Send reply email');
   
   
  
 ?>


    <table class="start_table_tabe3"> 
	
			<thead>
				<tr>
				     <th>Admin Name</th>
					 <?php  foreach($typeheading as $key=>$value) { ?>
					  <th><?php echo str_replace('clen','Clean', $value); ?></th>
					 <?php  } ?>
				</tr>
			</thead>	
				
	<?php  
		   
	?>			
			<tbody>
			    
				 <?php  
				  foreach(getadminnamedata() as $adminid=>$admiiname) { 
				 ?>
				  <tr id="delete_data_1">
					  <td><?php echo $admiiname; ?></td>
						  <?php  
						  $admindata1[$adminid][] = $admiiname;
						  $getdata =  getaemaildailySend($today, $adminid );
						  foreach($typeheading as $key=>$value) { 
						   
						     $admindata1[$adminid][] = $getdata[$value];
						  
						  ?>
						  <td><?php  if($getdata[$value] != '') { echo $getdata[$value];  }else {echo '-'; } ?></td>
						  <?php  } ?>
				 <?php  } ?>
				</tr>
			</tbody>
			
			
			
			
	   <?php 
	   $heading = array_merge($typeheading1 , $typeheading);
	   //echo '<pre>';  print_r($admindata1);
	   ?>	
			
	</table>
	<textarea name='fheading' style='display: none;'><?php echo serialize($heading); ?></textarea>
	<textarea name='export_data' style='display: none;'><?php echo serialize($admindata1); ?></textarea>
	
	