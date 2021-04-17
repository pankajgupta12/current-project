<?php  
   
   $adminid = $_REQUEST['id']; 
    if(isset($_POST['submit']) && $_POST['step'] == 1) {
		
		$logdate = $_POST['logdate'];
		$logdate_1 = implode("','", $logdate);
		
		//echo  $logdate_1;
		$sqlq1 =   mysql_query("DELETE from `admin_roster`  WHERE admin_id = ".$adminid." AND date in ('".$logdate_1."')");
		//$count = mysql_num_rows($sqlq);
		 
		  $sql = "INSERT INTO `admin_roster`  (`admin_id`,  `status`, `date`, `start_time_au`, `end_time_au`, `lunch_time_au`, `lunch_end_time_au`, `createdOn`)  VALUES ";
		 
		 $start_time_au = $_POST['start_time_au'];
		 $logdate = $_POST['logdate'];
		 $lunch_time_au = $_POST['lunch_time_au'];
		 $lunch_end_time_au = $_POST['lunch_end_time_au'];
		 $end_time_au = $_POST['end_time_au'];
		 $createdOn = date('Y-m-d H:i:s');
		 $status = 1;
		 if($start_time_au[$key] == 0) {
			 $status = 0;
		 }
		 
		 //if(!empty($start_time_au) && !empty($logdate) ) {
		 foreach($start_time_au as $key=>$val) {
		 
		   $sql .= " (".$adminid.",  '".$status."' , '".$logdate[$key]."', ".$start_time_au[$key].", ".$end_time_au[$key].", ".$lunch_time_au[$key].", ".$lunch_end_time_au[$key].",'".$createdOn."'),";
		 }
		 
	   // }
		
		$arg = rtrim($sql , ',');
		//echo  $arg;
	    $query = mysql_query($arg);	 
		header('Location: '.$_SERVER['REQUEST_URI']);
		//echo '<script type="text/javascript">location. reload(true);</script>';
	}
 
    $buttontype = 'Submit';
 
    $nextmonday = date('Y-m-d' ,  strtotime('next monday'));
	   for($i = 0; $i<=6; $i++) {
		  $getDate[] = date('Y-m-d', strtotime('+'.$i.' day', strtotime($nextmonday)));
		  $getDate1[] = '"'.date('Y-m-d', strtotime('+'.$i.' day', strtotime($nextmonday))).'"';
	  }
	
	 $sqlq =   mysql_query("SELECT * FROM `admin_roster`  WHERE admin_id = ".$adminid." AND date in (".implode(',', $getDate1).")");
	
	   $count = mysql_num_rows($sqlq);
	   
	    if($count > 0) {
		   while($gettimedata = mysql_fetch_assoc($sqlq)) {
			   $getdata[$gettimedata['date']] = $gettimedata;
		   }
		   
		   $buttontype = 'Update';
	    }
	   
	 // echo '<pre>'; print_r($getdata);
	
	$listarray = array('start_time_au'=>'Start Time','lunch_time_au'=>'Lunch start Time','lunch_end_time_au'=>'Lunch Finish Time','end_time_au'=>'End time');
	
	 
	
	?>

  
 <br/>
 <br/>
		
<br/>
  <h2><?php  echo  get_rs_value('admin','name',$adminid); ?> Upcoming Weekly Working<h2>
            <table class="user-table" border="1px">
			
			        <form id="time_shif" method="POST" action="">
						<thead>
							<tr>
							<th>Date</th> 
							<?php  foreach($getDate as $key=>$val) {  ?>
								<th><?php echo $val.' ('.date('l', strtotime($val)).')'; ?></th> 
							<?php  } ?>
							</tr>
						</thead>
						   
						   <?php 

						 
							foreach($listarray as $key=>$list) { 
							?>
							<tr>
								<td><?php echo $list; ?></td>
								<?php  foreach($getDate as $key1=>$val) {  
								
								?>
								<td><?php echo create_dd($key.'[]',"admin_time_shift","id",$key,'',"",$getdata[$val]); ?>
								<input type="hidden" name="logdate[<?php echo $key1; ?>]" id="logdate[]" value="<?php echo $val; ?>"/>
								</td> 
								<?php  } ?>
							</tr>
						   <?php } ?>
						   
							<tr>
								<td colspan="7"></td>
								
								<td>
								<input type="hidden" name="step" id="step" value="1"/>
								<h4><input style="font-size: 27px;cursor: pointer;" type="submit" name="submit" value="<?php echo $buttontype; ?>"></h4></td>
							</tr>	
					</form> 
				<tbody>
				</tbody>
            </table>