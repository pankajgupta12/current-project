 <?php 
 if(!isset($_SESSION['wall_board']['calldate'])){ $_SESSION['wall_board']['calldate'] = date('Y-m-d'); }
 
 $calldate =  $_SESSION['wall_board']['calldate'];
 
 $bookingquote[$val['id']]['totalbookingid'] = 0;
 $sitenoti = array('0'=>'Cmplt', '1'=>'P1','2'=>'P2','3'=>'P3','4'=>'P4','5'=>'P5');
   
   $setofTaskData =  getsetddValue('104,102,149');
   $array_team = $setofTaskData['102'];
   $data1 = getAdmindata();
   $task = $setofTaskData['104'];
   $requote = $setofTaskData['149'];
   //$requote = array_column($setofTaskData['149'], 'name','id');
   
   $getUserData = get3cxUserName($calldate);   
   $bookingquote = getbookingquote($calldate);
   $notificatiobDetails =  getAssinedNotification($calldate);
 
   //$todate = date('Y-m-d');
 
    //$getdate = array()
	$cdate = date('d');
	for($z = 0; $z <= 3; $z++) {
		$dateArr[] = date('Y-m-d' ,  strtotime('-'.$z.' day'));
	}
 
  // echo '<pre>'; print_r($setofTaskData);
 
 ?>

<span class="wall_board_txt" style="float:right;margin-top: -34px;">
                <hr/>
                <h2 class="wall_board_heading" style="text-align: center;margin-bottom: -38px;">Wall Board  <?php echo date('d M Y ( l )', strtotime($calldate)); ?></h2>
                <hr/>
           </span>
<br/>

<table style="width: 100%;">
  <tr>
<?php  $countbox = 0; foreach($array_team as $cid=>$cname) {  

  $countbox++;
     

?>
	<td  style="text-align: center;">
	
	<?php  if(!empty($data1[$cname['id']])) { ?>
	<h2><?php echo $cname['name']; ?></h2>
    </td>
    <td>

	
	  <table style="width: 100%;"><td>
				<tr>

  <?php  
  $h = date('H');
  $i= 0; foreach($data1[$cname['id']] as $key=>$val) 
  {
   $i++;
   
  // echo '<pre>'; print_r($val);
   
   // if($cid == 1) {
   $adminid = $getUserData[$val['id']]['id'];
   $adminname = $getUserData[$val['id']]['3cx_user_name'];
   if(!empty($getUserData[$val['id']])) {
      $intime = $getUserData[$val['id']]['intime'];
   }else{
       $intime = getLoginTIme($val['id'], $calldate);
       
   }
   
    //print_r($intime);
   
   $indata = 0;
   $outdata = 0;
   $inhrdata = 0;
   $outhrdata = 0;
   if($adminid > 0) {
      $calldetailsinfo = get3cxUserCallInout($adminid , $calldate , 2 , $adminname);
  }
  
   $arrdate = (explode(',',$intime));
    if(!empty($arrdate[0])) { usort($arrdate, 'date_compare'); $in_time =  date('h:i A', strtotime($arrdate[0])); 
        $bgcolorintime = '';
        
    }else {$in_time =  '';
        
          $bgcolorintime = '#e48d8d';
    }
  
   if($val['login_status'] == 1) {
       $logstatusbgcolor = '#d8f7d8;';
   }else{
        $logstatusbgcolor = '#e4d2d2;';
   }
  
  ?>
				<td >
				    
    				   
    				  <table style="width: 100%; background : <?php echo $logstatusbgcolor; ?>">
    		    	<tr>
    				  <td><b><?php  echo  ucfirst($val['name']); ?>(<?php if($bookingquote[$val['id']]['totalbookingid'] > 0) { echo $bookingquote[$val['id']]['totalbookingid']; }else {echo 0; } ?>) </b> </td>
    				  <td style="background: <?php echo $bgcolorintime; ?>;">
    				  <?php  echo $in_time; ?> </td>
    				  <td>
    				  
    				  <?php if($adminid > 0) { ?>
    				  <a class="button" onclick="showCallList('<?php echo $adminid; ?>', '<?php echo $val['name']; ?>' ,'<?php echo $cname['name']; ?>' ,1 , '<?php  echo  $val['id']; ?>','<?php echo $calldate; ?>');"  href="#popup1">
    				      <img src="../admin/icones/wall_board/task2.jpg" style="height: 25px;">
    				      
    				      </a>
    				     
    				  <?php  } 
    				  
    				  if($in_time != '') { ?>
    				  |
    				    <a class="button" onclick="showCallList('<?php echo $val['id']; ?>', '<?php echo $val['name']; ?>' ,'<?php echo $cname['name']; ?>' ,2 , '<?php  echo  $val['id']; ?>','<?php echo $calldate; ?>');"   href="#popup1">
    				       <img src="../admin/icones/wall_board/role.png" style="height: 25px;">
    				       </a>
    				   <?php  } ?>
    				   
    				  </td>
    				</tr>	      
    				 
          <?php if($cname['id'] == 24) {  
		  
		  ?>
                    <tr>
    				  <td>Total </td>
					  <?php   foreach($dateArr as $key1=>$date1){ ?>
    				  <td><?php echo date('dS M' ,strtotime($date1)); ?> </td>
                      <?php  }  ?>
    				</tr>
				  <?php  foreach($requote as $kk=>$reval) {  ?>	
					<tr>
    				 <td><?php   echo $reval['name']; ?> </td>
					  <?php   foreach($dateArr as $key1=>$date11){
						  
					    $getReQuote = getRequoteAssign1($val['id'], $date11, $reval['id']);
 						//print_r($getReQuote);
					  ?>
					 <td><?php   echo count($getReQuote); //echo  $date11;  ?> </td>
					  <?php  }  ?>

    				</tr>
				  <?php  } ?>	
				
  
  <?php  } else { ?>
					 
    				<tr>
    				  <td>Total </td>
    				  <td>today </td>
    				  <td>Time </td>
    				</tr>
    				<tr>
    				  <td>In </td>
    				  <td><?php echo $calldetailsinfo['incall']; ?> </td>
    				  <td><?php echo $calldetailsinfo['intotaltime'];  ?></td>
    				</tr>
    				
    				<tr>
    				  <td>Out </td>
    				  <td><?php echo $calldetailsinfo['outcall']; ?> </td>
    				  <td><?php echo $calldetailsinfo['outtotaltime'];  ?></td>
    				</tr>
    			<tr>
    			    
    			<?php
  }
    			if($cname['id'] == 1) { ?>	
    	          <td colspan="<?php echo count($task); ?>"><table style="width: 100%;">
            				<tr>
            	             <?php  foreach($task as $name) { ?> 
            				  <td><strong><?php echo ucfirst($name['name']); ?></strong> </td>
            			     <?php  } ?>  
            				</tr>
        				<tr>
            				<?php  
            				  foreach($task as $taskid=>$name11) {
                                $getdata = getTaskReCord($val['id'] ,$name11['id'] , date('Y-m-1' , strtotime('-2 month')) ,  date('Y-m-t') ,1 ,'' );
            				?>
            				  <td><?php echo $getdata; ?> </td>
            				<?php   }  ?> 
        				</tr>
        	   	</table></td>		
    				<?php  } else if($cname['id'] == 2) {    ?>
    			<td colspan="<?php echo count($sitenoti); ?>"><table style="width: 100%;">	
    				    	<tr>
            	             <?php 
            	             
            	             foreach($sitenoti as $key=>$name) { ?> 
            				  <td><strong><?php echo ucfirst($name); ?></strong> </td>
            			     <?php  } ?>  
            			</tr>
            				<tr>
            				<?php 
            				
            				    $cmpltnoti =   $notificatiobDetails[$val['id']][1];
            				    $taskpending =   $notificatiobDetails[$val['id']][0];
            				    
            				    $penddata =  getOrderpriorty($taskpending);
            				    
            				   foreach($sitenoti as $key=>$name) { 
            				  
            				?>
            				  <td><?php if($key == 0) { echo count($cmpltnoti); }else {   
            				      
            				    echo count($penddata[$key]); } ?> </td>
            				<?php  unset($penddata[$key]); }  ?> 
        				</tr>
        	    	</table></td>
    				<?php  } else if($cname['id'] == 23) {  
    				   // $todate = date('Y-m-d');
    			    	$getdata = getEmailInfodetails($calldate , $val['id']);
    				    $getchatDetails = getChatDetails($calldate , $val['id']);
    				
    				?>
    				
    				   <td colspan="<?php echo count($sitenoti); ?>"><table style="width: 100%;">	
    				      <tr>
                	             <td> </td>
                	             <td><strong>Total</strong></td>
                	             <td><strong>Send</strong></td>
                	             <td><strong>Open</strong></td>
                				 <td><strong>Closed</strong></td>
                           </tr>
    				    	<tr>
                	             <td><strong>Email</strong> </td>
                	             <td></td>
                	             <td><?php echo $getdata['send']; ?></td>
                	             <td><?php echo $getdata['openemail']; ?></td>
                	             <td><?php echo $getdata['closedemail']; ?></td>
                				 
                           </tr>
            				<tr>
                				<td><strong>Chat & SMS</strong> </td>
                				 <td></td>
                				 <td><?php echo $getchatDetails['sent']; ?></td>
                				 <td><?php echo $getchatDetails['recived']; ?></td>
                				 <td></td>
        			     	</tr>
        	    	</table></td>
    				
    				<?php  } ?>
    				</tr>
    			</table> 
		    </td>
	<?php if($i % 4 == 0) { echo '</tr><tr>';  } ?>		
  <?php  //} 
   unset($calldetailsinfo);
  
  }?>
			</td></table> </td></td><?php  } ?>
			
			</tr></tr>
 <?php  /*if($countbox %2 == 0) {echo '</tr></tr>'; 
         }*/ 
 } 
 
 unset($requote);
 ?>
				</tr>
				
				
	</table>	
	
	<div id="popup1" class="overlay" style="display: none;">
	    
	    <div class="getinfo">
        	<div class="popup">
        	      
        		  <h2 id="heading_show"></h2>
            		
        		    <a class="close" href="javascript:void(0);" onclick="closedpopup();">&times;</a>
        		<br/>
        		<div class="content">
        		</div>
        	</div>
    	</div>
   </div>
   
