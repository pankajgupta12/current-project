<?php 

     //if($_GET['stafftype'] == '' || $_GET['stafftype'] == 1) {
     
    if($emailtype == 1 || $emailtype == '') {
     
     	$staff_arg = "select * from staff_journal_new where staff_id=".$_SESSION['journal']['staff_id']." AND payment_type != 2 and `journal_date`>='".$_SESSION['journal']['from_date']."' and `journal_date`<='".$_SESSION['journal']['to_date']."' order by journal_date,job_date,job_id desc";
     	
      $staff_journal = mysql_query($staff_arg);
      
      $countbcic = mysql_num_rows($staff_journal);
      
      if($countbcic > 0 ) {
   
	  echo '<span class="add_jobs_text">'.get_rs_value("staff","name",$_SESSION['journal']['staff_id'])." ( BCIC )</span>";

	echo '<table width="60%" border="1" cellpadding="5" cellspacing="5" class="user-payment-table">';
	echo '<tr class="table_cells">
		  <td>Job Id</td>
		  <td>Client Name</td>
		  <td>Suburb</td>
		  <td>Job Date</td>
		  <td>Journal Date</td>
		  <td>Comments</td>
		  <td>Total Amt</td>
		  <td>BCIC Rec</td>
		  <td>Staff Rec</td>
		  <td>BCIC Share</td>
		  <td>Staff Share</td>		  
		  <td>Balance</td>
		</tr>';
		
    	
    		$balance =0;
    		$casetest = "";
    		
    		
          while($jdetails = mysql_fetch_assoc($staff_journal)) 
        {	
			 if($jdetails['total_amount']!=""){ 
				 if($jdetails['total_amount']<$jdetails['bcic_rec']){
					 $jdetails['bcic_rec'] = $jdetails['total_amount'];
				  }
			 }
			
			if($jdetails['bcic_rec']==""){ $jdetails['bcic_rec']=0; }
			if($jdetails['bcic_share']==""){ $jdetails['bcic_share']=0; }
			   		
			if($jdetails['staff_rec']>0 && $jdetails['bcic_rec']>0){
				// staff and bcic both got the payment 
				$staff_gets = ($jdetails['staff_share']-$jdetails['staff_rec']);
				$balance=($balance+$staff_gets);
				$casetest = "1";
			}else if ($jdetails['staff_rec']==0 && $jdetails['bcic_rec']>0){
				
				if (($jdetails['total_amount']=="")){
					// bcic got payment from cleaner
					$balance=($balance+$jdetails['bcic_rec']);
				}else{ 
					// bcic got the payment from client
					$balance=($balance+$jdetails['staff_share']);
				}
				$casetest = "2";
			}else if ($jdetails['staff_rec']>0 && $jdetails['bcic_rec']==0){
				// staff took the payment - bcic didnt get anything = balance reduces 
				//if($jdetails['job_id']!="0"){ 
				$casetest = "3";
				
				if($jdetails['bcic_share']>0){ 
					$balance=($balance-$jdetails['bcic_share']);
					$casetest.=".1";
				}else{
					$balance=($balance-($jdetails['staff_rec']-$jdetails['staff_share']));	
					$casetest.=".2";
				}

			}else if (($jdetails['total_amount']=="") && ($jdetails['staff_rec']>0)){
				$balance=($balance-$jdetails['staff_rec']);
				$casetest = "4";
			}

			//$jdetails['comments'].=" =>".$casetest;
			
			if($jdetails['job_id']!="0"){ 
			
		
				$suburb = get_sql("quote_new","suburb"," where booking_id=".$jdetails['job_id']."");
				
				
				echo '<tr class="table_cells" id="jdetails_'.$jdetails['id'].'">
				  <td><a href="javascript:scrollWindow(\'popup.php?task=jobs&job_id='.$jdetails['job_id'].'\',\'1200\',\'850\')">'.$jdetails['job_id'].'</td>
				  <td>'.$jdetails['client_name'].'</td>
				  <td>'.$suburb.'</td>
				  <td>'.$jdetails['job_date'].'</td>
				  <td>'.$jdetails['journal_date'].'</td>
				  <td>'.$jdetails['comments'].'</td>
				  <td>'.$jdetails['total_amount'].'</td>';
				  if($jdetails['total_amount']<=$jdetails['bcic_rec']){
					 echo '<td>'.$jdetails['total_amount'].'</td>';
				  }else{
					 echo '<td>'.$jdetails['bcic_rec'].'</td>';
				  }
				  echo '<td>'.$jdetails['staff_rec'].'</td>
				  <td>'.$jdetails['bcic_share'].'</td>
				  <td>'.$jdetails['staff_share'].'</td>	
				  <td>'.number_format($balance,2).'</td>
				</tr>';		
			}else{				
				echo '<tr class="table_cells">
						  <td colspan="4"><strong>Paid By BCIC</strong></td>
						  <td>'.$jdetails['journal_date'].'</td>
						  <td>'.$jdetails['comments'].'</td>
						  <td>'.$jdetails['total_amt'].'</td>
						  <td>'.$jdetails['bcic_rec'].'</td>
						  <td>'.$jdetails['staff_rec'].'</td>
						  <td>'.$jdetails['bcic_share'].'</td>
						  <td>'.$jdetails['staff_share'].'</td>		  
						  <td>'.number_format($balance,2).'</td>
				</tr>';		
			}
		}
		echo "</table>";
      }	
     }
     
    if($emailtype == 2 || $emailtype == '') {
         
      	$staff_arg1 = "select * from staff_journal_new where staff_id=".$_SESSION['journal']['staff_id']."  AND payment_type = 2  and `journal_date`>='".$_SESSION['journal']['from_date']."' and `journal_date`<='".$_SESSION['journal']['to_date']."' order by journal_date,job_date,job_id desc";
    		//echo $staff_arg;
    		$staff_journal1 = mysql_query($staff_arg1);
    
       $countbcic1 = mysql_num_rows($staff_journal1);
      if($countbcic1 > 0  ||  $emailtype == 2) {
   // }else {
        
         $StaddType = ' ( BBC Lead ) ';
         
         //o	Job id, client name, suburb, job date, journal date, Comments , 
        // o	Total amount, 10% Royalty, 2.5% Merchant Fees, Lead Cost, 

        
        	  echo '<span class="add_jobs_text">'.get_rs_value("staff","name",$_SESSION['journal']['staff_id']).$StaddType."</span>";

	echo '<table width="80%" border="1" cellpadding="5" cellspacing="5" class="user-payment-table">';
	echo '<tr class="table_cells">
		  <td>Job Id</td>
		  <td>Lead Type</td>
		  <td>Client Name</td>
		  <td>Suburb</td>
		  <td>Job Date</td>
		  <td>Journal Date</td>
		  <td>Comments</td>
		  <td>Total Amt</td>
		  <td>BCIC Rec</td>
		  <td>Staff Rec</td>
		  <td>Staff Share</td>
		  <td>10% Royalty</td>
		  <td>2.5% Merchant Fees</td>
		  
		  <td>BCIC Share</td>
		  <td>Balance</td>
		</tr>';
		
    	
    		$balance =0;
    		$casetest = "";
    		
    		
          while($jdetails = mysql_fetch_assoc($staff_journal1)) 
        {	
    			if($jdetails['total_amount']!=""){ 
    				 if($jdetails['total_amount']<$jdetails['bcic_rec']){
    					 $jdetails['bcic_rec'] = $jdetails['total_amount'];
    				  }
    			 }
    			
    			if($jdetails['bcic_rec']==""){ $jdetails['bcic_rec']=0; }
    			if($jdetails['bcic_share']==""){ $jdetails['bcic_share']=0; }
    			   		
    			if($jdetails['staff_rec']>0 && $jdetails['bcic_rec']>0){
    				// staff and bcic both got the payment 
    				$staff_gets = ($jdetails['staff_share']-$jdetails['staff_rec']);
    				$balance=($balance+$staff_gets);
    				$casetest = "1";
    			}else if ($jdetails['staff_rec']==0 && $jdetails['bcic_rec']>0){
    				
    				if (($jdetails['total_amount']=="")){
    					// bcic got payment from cleaner
    					$balance=($balance+$jdetails['bcic_rec']);
    				}else{ 
    					// bcic got the payment from client
    					$balance=($balance+$jdetails['staff_share']);
    				}
    				$casetest = "2";
    			}else if ($jdetails['staff_rec']>0 && $jdetails['bcic_rec']==0){
    				// staff took the payment - bcic didnt get anything = balance reduces 
    				//if($jdetails['job_id']!="0"){ 
    				$casetest = "3";
    				
    				if($jdetails['bcic_share']>0){ 
    					$balance=($balance-$jdetails['bcic_share']);
    					$casetest.=".1";
    				}else{
    					$balance=($balance-($jdetails['staff_rec']-$jdetails['staff_share']));	
    					$casetest.=".2";
    				}
    
    			}else if (($jdetails['total_amount']=="") && ($jdetails['staff_rec']>0)){
    				$balance=($balance-$jdetails['staff_rec']);
    				$casetest = "4";
    			}

		//	$jdetails['comments'].=" =>".$casetest;
			
			$leadcoast = 0;
			if($jdetails['job_id']!="0"){ 
			
		
				$suburb = get_sql("quote_new","suburb"," where booking_id=".$jdetails['job_id']."");
				
               /* $jobtype = '';
                $bbcapp_staff_id = get_sql("quote_new","bbcapp_staff_id"," where booking_id=".$jdetails['job_id']."");
                if($bbcapp_staff_id > 0) {$jobtype = 'BBC'; }	*/
				
				if($jdetails['payment_type'] == 1) {$leadtype = 'BCIC'; }else {   $leadtype = 'BBC'; }
				
				//$re
				
				//$bcicshare = $jdetails['bcic_share'];
				
				$roylty = (($jdetails['total_amount']*10)/100);
				$marchent = (($jdetails['total_amount']*2.5)/100);
				
				
				
				  echo '<tr class="table_cells" id="jdetails_'.$jdetails['id'].'">
				  <td><a href="javascript:scrollWindow(\'popup.php?task=jobs&job_id='.$jdetails['job_id'].'\',\'1200\',\'850\')">'.$jdetails['job_id'].'</td>
				  <td>'.$leadtype.'</td>
				  <td>'.$jdetails['client_name'].'</td>
				  <td>'.$suburb.'</td>
				  <td>'.$jdetails['job_date'].'</td>
				  <td>'.$jdetails['journal_date'].'</td>
				  <td>'.$jdetails['comments'].'</td>
				  <td>'.$jdetails['total_amount'].'</td>';
				  if($jdetails['total_amount']<=$jdetails['bcic_rec']){
					 echo '<td>'.$jdetails['total_amount'].'</td>';
				  }else{
					 echo '<td>'.$jdetails['bcic_rec'].'</td>';
				  }
				  echo '<td>'.$jdetails['staff_rec'].'</td>
				  <td>'.$jdetails['staff_share'].'</td>';
		          echo  '<td>'.$roylty.'</td>';
				  echo '<td>'.$marchent.'</td>
				  
				   <td>'.$jdetails['bcic_share'].'</td>
				  <td>'.number_format($balance,2).'</td>
				</tr>';		
			}else{		
			    
			     if($jdetails['payment_type'] == 2) {
			          $comm = 'Paid By BBC ';
			     }else {
			         $comm = 'Paid By BCIC';
			     }
			    
			    
				echo '<tr class="table_cells">
						  <td colspan="5"><strong>'.$comm.'</strong></td>
						  <td>'.$jdetails['journal_date'].'</td>
						  <td style="word-break: break-all;width: 85%;text-align: center;">'.$jdetails['comments'].'</td>
						  <td>'.$jdetails['total_amt'].'</td>
						  <td>'.$jdetails['bcic_rec'].'</td>
						  <td>'.$jdetails['staff_rec'].'</td>
						  <td>'.$jdetails['staff_share'].'</td>
						  <td></td>
						  <td></td>	
						   <td>'.$jdetails['bcic_share'].'</td>
						  <td>'.number_format($balance,2).'</td>
				</tr>';		
			}
			
		
			
		}
		echo "</table>";
      }
    }
        
    //}
?>