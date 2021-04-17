<?php 
// die;
	if(!isset($_SESSION['tpayment_report']['from_date'])){ $_SESSION['tpayment_report']['from_date'] = date("Y-m-1"); }
	if(!isset($_SESSION['tpayment_report']['to_date'])){ $_SESSION['tpayment_report']['to_date'] = date("Y-m-t"); }
	if(!isset($_SESSION['tpayment_report']['site_id'])){ $_SESSION['tpayment_report']['site_id'] = "0"; }
	if(!isset($_SESSION['tpayment_report']['staff_id'])){ $_SESSION['tpayment_report']['staff_id'] = "0"; }
	if(!isset($_SESSION['tpayment_report']['staff_type'])){ $_SESSION['tpayment_report']['staff_type'] = "1"; }
	
  // print_r($_SESSION['tpayment_report']); 


	$staff_arg = "select  DISTINCT(staff_id) as staff_id from job_details where (job_date>='".date('Y-m-d' , strtotime($_SESSION['tpayment_report']['from_date']))."'
	   and job_date<='".date('Y-m-d', strtotime($_SESSION['tpayment_report']['to_date']))."') ";

//	$staff_arg.=" and payment_completed=1 and acc_payment_check=0 and pay_staff=1 ";
	
	if($_SESSION['tpayment_report']['site_id']!="0"){ $staff_arg.= " and site_id=".$_SESSION['tpayment_report']['site_id']; } 

	if($_SESSION['tpayment_report']['staff_id']!="0"){ $staff_arg.= " and staff_id=".$_SESSION['tpayment_report']['staff_id']; } 
	
	if($_SESSION['tpayment_report']['staff_type'] =="2" ) { 
	    $staff_arg.= " and staff_id in ( select id from staff where status = 1 AND better_franchisee = 2 AND bbc_leads = 2 )"; 
	    
	 }else{
	     	$staff_arg.= " and job_id in (select id from jobs where status=3) ";
	     	
	     	$staff_arg.=" and payment_completed=1 and acc_payment_check=0 and pay_staff=1 ";
	 }
	
	



	//echo $staff_arg;
	
    $staffs = mysql_query($staff_arg);

    $count = mysql_num_rows($staffs);
    //echo  '('.$count.')';
    if($count > 0) 
	{
     //$kk = 0;
		while($r = mysql_fetch_assoc($staffs))
		{
			// $kk++;
            if($r['staff_id'] != '') 
		    {
				
				$staff = mysql_fetch_assoc(mysql_query("select id, name,site_id, bbc_leads  from staff where id=".$r['staff_id'].""));
				$site_name = get_rs_value("sites","name",$staff['site_id']);
                 $stafftype = '';
                 $stafftypeid = '';
                 if($staff['bbc_leads'] == 2) { $stafftypeid = 2; $stafftype = '<span style="color:red"> (BBC Lead)</span>'; }
                 
                 
			      echo '<div class="userpayment-overflow">';	
				  
					$job_total = 0; $staff_amount_total = 0; $bcic_amount_total =0; $bcic_rec_total =0; $staff_rec_total=0; $balance=0;
					
				   	    $job_picker_x = "";
				   	    
				   	if($stafftypeid == 2) {
				   	    
				   	    $job_details_arg = "select  id, job_id, staff_paid, job_date  from job_details where staff_id=".$r['staff_id']."  and status!=2  and payment_completed=1 and acc_payment_check=0 and pay_staff=1 ";
				   	    $job_details_arg .= " AND job_id in ( SELECT booking_id from quote_new WHERE bbcapp_staff_id = ".$r['staff_id']." AND booking_id > 0 )";
						$job_details_arg.= " and (job_date>='".$_SESSION['tpayment_report']['from_date']."' and job_date<='".$_SESSION['tpayment_report']['to_date']."') group by job_id ";
						
				   	    
				   	}
				   	  else 
				   	{
				   	    
				   	    $job_details_arg = "select  id, job_id, staff_paid , job_date  from job_details where staff_id=".$r['staff_id']." and payment_completed=1 and acc_payment_check=0 and pay_staff=1 
				   	    and job_id in(select id from jobs where status=3) and status!=2";
				   	    $job_details_arg .= " AND job_id in ( SELECT booking_id from quote_new WHERE bbcapp_staff_id = 0 AND booking_id > 0 )";
						$job_details_arg.= " AND (job_date>='".$_SESSION['tpayment_report']['from_date']."' and job_date<='".$_SESSION['tpayment_report']['to_date']."') group by job_id";
				   	    
				   	}   
				    	
						//echo $job_details_arg;
						$job_details = mysql_query($job_details_arg);
						$count_details = mysql_num_rows($job_details);
						
						
		   	$leadquotes = '';
       
        	 $sql =  mysql_query("SELECT GROUP_CONCAT(id) as quoteid  FROM `quote_new` WHERE  bbcapp_staff_id > 0  AND date >= '".$_SESSION['tpayment_report']['from_date']."' AND date <= '".$_SESSION['tpayment_report']['to_date']."' AND step != 10 AND   (step != 7 AND denied_id != 3) AND bbcapp_staff_id = ".$r['staff_id']."  AND lead_payment_status = 1");			
		
    		 if(mysql_num_rows($sql) > 0) {
    		  $quoteids = mysql_fetch_assoc($sql);		
    		  
    		    if(!empty($quoteids)) {
    		        $leadquotes = $quoteids['quoteid'];
    		    }
    		  
    		 }
						
				if($count_details > 0 || $leadquotes != '')
				{	
                 
                 
                 
				echo '<div class="view_quote_back_box">';
				echo '<div class="left_text_box"><span class="add_jobs_text" style="white-space: nowrap;"><a href="/admin/index.php?task=journal&stafftype='.$stafftypeid.'&staff_id='.$staff['id'].'">'.$staff['name'].'</a> ('.$site_name.').'.$stafftype.'</span></div>';
				
				?>
				<div class="right_staff_box"><input onclick="javascript:window.location='/admin/index.php?task=7&amp;action=add&staff_id=<? echo $staff['id'];?>';" type="button" class="staff_button" value="+&nbsp;Journal"></div>
			  <?php  
					
							echo '<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">';
							echo '<tr class="table_cells">
								  <td>Job Id</td>
								   <td>Lead Type</td>
								  <td>Client Name</td>
								  <td>Job Date</td>
								  <td>Total Amount</td>
								  <td>BCIC Received</td>
								  <td>Staff Received</td>		  
								  <td>BCIC Share</td>
								  <td>Staff Share</td>
								  <td>Balance</td>
								  <td></td>
								  <td></td>
								</tr>';
								
				
			
					$balance =0;
					$alljobID = array();
					 while($jdetails = mysql_fetch_assoc($job_details))
					{	
						
					    	$journal_check = get_sql("staff_journal_new","id"," where staff_id=".$r['staff_id']." and job_id=".$jdetails['job_id']."");
						
						   
						
						if($journal_check==""){ 
						
    					     	$jobs = mysql_fetch_array(mysql_query("select quote_id from jobs where id=".$jdetails['job_id']));				
    							$quote = mysql_fetch_array(mysql_query("select id, booking_id ,lead_fee ,bbc_staff_paid_date, lead_payment_status, booking_lead_payment , booking_lead_payment_date ,  name ,bbcapp_staff_id,lead_payment_status , bbc_fee,lead_pay_date,  amount  from quote_new where booking_id=".$jdetails['job_id']));
    							
    						
    					// print_r($quote);
    						    /*	if($quote['bbcapp_staff_id'] > 0) { 
    						    	    $taken = 'BBC';
    						    	}else{
    						    	    $taken = 'BCIC';
    						    	}*/
    						
    							$bcic_rec =mysql_fetch_array(mysql_query("select sum(amount) as tamount from job_payments where taken_by='BCIC' and job_id=".$jdetails['job_id'].""));
    							$staff_rec =mysql_fetch_array(mysql_query("select sum(amount) as tamount from job_payments where taken_by='".$staff['name']."' and job_id=".$jdetails['job_id'].""));
    							
    							$amt_staff_row =mysql_fetch_array(mysql_query("select sum(amount_staff) as amount_staff from job_details where staff_id='".$staff['id']."' and job_id=".$jdetails['job_id']." and status!=2"));
    							
    							$amt_profit_row =mysql_fetch_array(mysql_query("select sum(amount_profit) as amount_profit from job_details where staff_id='".$staff['id']."' and job_id=".$jdetails['job_id']." and status!=2"));
    							
    						
    							    
    						$leadtype ='BCIC';
    							          
							if($quote['bbcapp_staff_id'] > 0) { 
                				    
                				    /*if($quote['lead_payment_status']=="1"){ 
                				        $lead_fee = $quote['lead_fee'];
                				    }else{
                				        $lead_fee = 0;
                				    }*/
                				    
                				     $lead_fee = 0;
                				     
                				    $leadtype ='BBC'; 
                				    $jobtype = 1;
                				    $amount_profit = ($quote['bbc_fee'] + $lead_fee);
                				    $amt_staff_row['amount_staff'] = $quote['amount'] - $amount_profit;  
                				    $amt_profit_row['amount_profit'] = $amount_profit;
                				    
                			}      
    							          
                							 	//	$payment_row = 0;
                                if($staff_rec['tamount']>0 && $bcic_rec['tamount']>0){
                                    // staff and bcic both got the payment 
                                    $staff_gets = ($amt_staff_row['amount_staff']-$staff_rec['tamount']);
                                    $balance=($balance+$staff_gets);
                                    //	$payment_row = $staff_gets;
                                }else if ($staff_rec['tamount']=="" && $bcic_rec['tamount']>0){
                                    // bcic got the payment 
                                    $staff_gets = ($amt_staff_row['amount_staff']-$staff_rec['tamount']);
                                    $balance=($balance+$staff_gets);
                                    //	$payment_row = $staff_gets;
                                
                                }else if ($staff_rec['tamount']>0 && $bcic_rec['tamount']==""){
                                    // staff took the payment - bcic didnt get anything = balance reduces 
                                    $balance=($balance-$amt_profit_row['amount_profit']);
                                    //$payment_row = $amt_profit_row['amount_profit'];
                                }else if ($staff_rec['tamount']>0 && $bcic_rec['tamount']=="0"){
                                    
                                    // staff took the payment - bcic didnt get anything = balance reduces 
                                    $balance=($balance-$amt_profit_row['amount_profit']);
                                    //$payment_row = $amt_profit_row['amount_profit'];
                                }
                			
    							
    							$staff_gets=0;
    							
				
    						
							
						    	//$getAllAmount[$staff['id']][] = $payment_row;
						    	 $alljobID[] = $jdetails['job_id'];
							
							      
							
        							echo '<tr class="table_cells" id="jdetails_'.$jdetails['id'].'">
        							  <td><a href="javascript:scrollWindow(\'popup.php?task=jobs&job_id='.$jdetails['job_id'].'\',\'1200\',\'850\')">'.$jdetails['job_id'].'</td>
        							  <td>'.$leadtype.'</td>
        							  <td>'.$quote['name'].'</td>
        							  <td>'.$jdetails['job_date'].'</td>
        							  <td>'.$quote['amount'].'</td>
        							  <td>'.$bcic_rec['tamount'].'</td>
        							  <td>'.$staff_rec['tamount'].'</td>	  
        							  <td>'.$amt_profit_row['amount_profit'].'</td>
        							  <td>'.$amt_staff_row['amount_staff'].'</td>
        							  <td>'.$balance.'</td>';
        							 
        							 
        							  
        							 if($jobtype == 1) { 
            							echo  '<td id="paid_'.$quote['id'].'">';
            							
            							
            							$j_str = "'".$quote['id']."__1'";
            							  if($quote['booking_lead_payment']=="1"){ 
            							       $str = "'".$quote['id']."__1'";
            							       
            								echo '<a href="javascript:send_data('.$str.',36,\'paid_'.$quote['id'].'\');">Make Paid</a>';
            							  }else{
            								echo date('Y-m-d' ,strtotime($quote['bbc_staff_paid_date']));  
            							  }
            							  echo '</td>
            							  
            							   <td id="journal_'.$quote['id'].'"><a href="javascript:send_data('.$j_str.',40,\'journal_'.$quote['id'].'\');">Add Journal</a></td>';
            							 
            							 
        							 }
        							   else
        							 {
        							 
        							   echo  '<td id="paid_'.$jdetails['id'].'">';
        							   $j_str = "'".$jdetails['id']."__2'";
        							 
        							   if($jdetails['staff_paid']=="0"){ 
        							      $str = "'".$jdetails['id']."__2'";
            								echo '<a href="javascript:send_data('.$str.',36,\'paid_'.$jdetails['id'].'\');">Make Paid</a>';
            							  }else{
            								echo 'Already Paid';  
            							  }
            							  echo '</td>
            							   <td id="journal_'.$jdetails['id'].'"><a href="javascript:send_data('.$j_str.',40,\'journal_'.$jdetails['id'].'\');">Add Journal</a></td>';
        							       
        							 }
        							   
        							echo '</tr>';
        							
    						
        							
							
						} // journal check 
						
						unset($jdetails);
					}
					
					if($leadquotes != '') {
					    
    				 	$leadq = explode(',', $leadquotes);
    				 	$quoteamount = 0;
    				 	if(count($leadq) > 0 && !empty($leadq)) {
    				     $quoteamount = count($leadq)*10;
    				 	}
    				 	
				     $divstaffid  = 'lead_message_'.$r['staff_id'];
				
				     echo  "<input type='hidden' value='".implode('/',$leadq)."' id='quoteids_".$staff['id']."' /><input type='hidden' value='".$quoteamount."' id='quoteamount_".$staff['id']."'>";
    					echo "<tr><td ><strong>QuoteID</strong></td>
    					<td colspan='9' id='".$divstaffid."' style='word-break: break-all;width: 85%;text-align: center;'>".implode('/',$leadq)."</td>
    					<td colspan='' style='text-align: center;'><strong> " .$quoteamount."</strong></td>
    					<td colspan='' style='text-align: center;'><input type='button' id='lead_pay' style='cursor: pointer' onClick='leadPay(".$staff['id'].");' value='Lead Pay'></td>
    					</tr>";
					}
						$alljobid = implode('/',$alljobID);	
					echo "<tr><td colspan='15' style='text-align: left;'><strong>JOB ID ".$alljobid."</strong></td></tr>";
					echo '</table></div></div></div>';
				}
	//	echo  '</div></div></div>';		
				
			  unset($r['staff_id']);
			  unset($staff['id']);
			  unset($leadquotes);
			  unset($leadq);
			  unset($quoteamount);
			  
		    }
		}
    }
	
?>


<script>
 
  function  leadPay(staffid) {
      var quoteids = $('#quoteids_'+staffid).val();
      var quoteamount = $('#quoteamount_'+staffid).val();
      //alert(staffid + '=========== ' +quoteids + ' ===== '+quoteamount);
      var str = staffid + '|' +quoteids + '| '+quoteamount;
    //  alert(str); 
    //  send_data(str ,644, 'lead_message_'+staffid);
      divid = 'lead_message_'+staffid;
      send_data(str,644,divid);
  }
  
</script>
