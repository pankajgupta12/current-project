<?php 


if(!isset($_SESSION['sales']['from_date'])){ $_SESSION['sales']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['sales']['to_date'])){ $_SESSION['sales']['to_date'] = date("Y-m-t"); }

   $arg =  mysql_query("SELECT name , id  FROM `admin` WHERE `is_call_allow` = 1 AND status != 0");
      $getadmin = array();
      $countAdmin = mysql_num_rows($arg);
	  while($adminname = mysql_fetch_assoc($arg)) {
		  $getadmin[$adminname['id']] = $adminname['name'];
	  }

     $getSql =  "SELECT DISTINCT(date) as date FROM `quote_new`  where 1=  1 ";
  
	  if(isset($_SESSION['sales']['from_date']) && $_SESSION['sales']['to_date'] != NULL )
		{ 
			$getSql .= " AND date >= '".date('Y-m-d',strtotime($_SESSION['sales']['from_date']))."' AND date <= '".$_SESSION['sales']['to_date']."'"; 
		} 
    //$getSql .= ' GROUP by date';
     //echo $getSql;	
	 //die;
	 
	
    $Sql  = 	mysql_query($getSql);
	
	//print_r($getadmin);
	
?>
   <span class="staff_text" style="margin-bottom: -11px;margin-left: 15px;">Sales Reports A/C to Quote Date</span>
<br/><br/>
    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
		<tr class="table_cells">
			  <td>Date</td>
			  <?php  foreach($getadmin as $name) { ?>
			    <td><?php echo ucfirst($name); ?></td>
			  <?php  } ?>
			  <td><?php echo 'Other'; ?></td>
			
		</tr>
		<tr class="table_cells">
			  <td>&nbsp;</td>
			  <?php  foreach($getadmin as $name) { ?>
			  <td>Q - B</td>
			  <?php  } ?>
			  <td>Q - B</td>
		</tr>	  
        <?php  
				//echo $key;
		 if(mysql_num_rows($Sql) > 0) {		
					
				while($getquote = mysql_fetch_assoc($Sql)) { 
				/* $sumQ = 0;
				$sumB = 0; */
				
			?>  
				<tr class="table_cells">
						
				  <td><?php  echo  date('dS M', strtotime($getquote['date'])); ?> (<?php  echo  date('l', strtotime($getquote['date'])); ?>)</td>
				  
				 <?php foreach($getadmin as $key=>$name) {
                       $getquote1 =     getquotebyloginID($key , $getquote['date'] , 1);
                       $getbooked1 =     getquotebyloginID($key , $getquote['date'] , 2);


				 ?>
				  <td><?php if($getquote1 == '0' && $getbooked1 == '0') { echo '--'; }else{ echo $getquote1; ?>-<?php echo $getbooked1;  } ?></td>
				 <?php 
				  $sumQ[$key]  += $getquote1;
				  $sumB[$key]  += $getbooked1;
				 } 
				 
				$getnonloginq =  getquotebyloginID(0 , $getquote['date'] , 1);
				$getnonloginb =  getquotebyloginID(0 , $getquote['date'] , 2);
				 ?>
				 <td><?php if($getnonloginq == '0' && $getnonloginb == '0') { echo '--'; }else{ echo $getnonloginq; ?>-<?php echo $getnonloginb;  } ?></td>
				</tr>
		 <?php   
		 
						$othsumQ[]  += $getnonloginq;
						$othsumB[]  += $getnonloginb;
		 
		 }

      //print_r($sumQ);
		 ?>
		    <tr class="table_cells">
				<td><strong>Total (<?php  echo (array_sum($sumQ) + array_sum($sumB) + (array_sum($othsumQ)) + (array_sum($othsumB)));?>)</strong></td>
				 <?php foreach($getadmin as $key=>$name) { ?>
				   <td><strong><?php  echo ($sumQ[$key]); ?>-<?php echo ($sumB[$key]); ?></strong></td>
				 <?php  } ?>
				 <td><strong><?php  echo array_sum($othsumQ); ?>-<?php echo array_sum($othsumB); ?></strong></td> 
            </tr>
			
			<tr class="table_cells">
				<td><strong>Average  </strong></td>
				 <?php foreach($getadmin as $key=>$name) { ?>
				   <td><strong><?php  if($sumB[$key] > 0) { echo  round((($sumB[$key])*100)/($sumQ[$key]) , 2); } ?>%</strong></td>
				 <?php  } ?>
				 <td><strong><?php  if($othsumB > 0) {  echo round((array_sum($othsumB)*100)/array_sum($othsumQ) , 2); } ?>%</strong></td> 
            </tr>
			
		 <?php  }else {  ?>	
           <tr class="table_cells">
		     <td colspan='15'>No Record found</td>
		   </tr>
   
		 <?php  } ?>
    </table>