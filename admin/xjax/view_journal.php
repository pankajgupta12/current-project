<?php 



	echo '<table width="60%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">';
	echo '<tr class="table_cells">
		  <td>Job Id</td>
		  <td>Client Name</td>
		  <td>Job Date</td>
		  <td>Comments</td>
		  <td>Received</td>
		  <td>Earned</td>		  
		  <td>Balance</td>
		</tr>';
		
		$staff_arg = "select * from staff_journal_new where staff_id=".$_SESSION['journal']['staff_id']." and `date`>='".$_SESSION['journal']['from_date']."' and `date`<='".$_SESSION['journal']['to_date']."' order by date";
		echo $staff_arg;
		$staff_journal = mysql_query($staff_arg);
		$balance =0;
		
        while($jdetails = mysql_fetch_assoc($staff_journal)){ 
						
			if($jdetails['job_id']!="0"){ 
			
				$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".$jdetails['job_id']));			
				$quote = mysql_fetch_array(mysql_query("select * from quote where id=".$jobs['quote_id']));
				/*$bcic_rec =mysql_fetch_array(mysql_query("select sum(amount) as tamount from job_payments where taken_by='BCIC' and job_id=".$jdetails['job_id'].""));
				$staff_rec =mysql_fetch_array(mysql_query("select sum(amount) as tamount from job_payments where taken_by='".$staff['name']."' and job_id=".$jdetails['job_id'].""));
				
				$amt_staff_row =mysql_fetch_array(mysql_query("select sum(amount_staff) as amount_staff from job_details where staff_id='".$staff['id']."' and job_id=".$jdetails['job_id'].""));
				$amt_profit_row =mysql_fetch_array(mysql_query("select sum(amount_profit) as amount_profit from job_details where staff_id='".$staff['id']."' and job_id=".$jdetails['job_id'].""));
				
				
				if($jdetails['staff_paid']=="0"){ 
					if($staff_rec['tamount']>0){ 
						$balance=($balance-$amt_profit_row['amount_profit']);
					}else{
						$balance=($balance+$amt_staff_row['amount_staff']);
					}
				}
			
				
				if($jdetails['received']>0){ 
					$balance=($balance-$jdetails['received']);
				}else{
					$balance=($balance+$jdetails['earned']);
				}
				*/
			
				if($jdetails['staff_rec']>0 && $jdetails['bcic_rec']>0){
					// staff and bcic both got the payment 
					$staff_gets = ($jdetails['staff_share']-$jdetails['staff_rec']);
					$balance=($balance+$staff_gets);
				}else if ($jdetails['staff_rec']=="" && $jdetails['bcic_rec']>0){
					// bcic got the payment 
					$staff_gets = ($jdetails['bcic_rec']-$jdetails['staff_share']);
					$balance=($balance+$staff_gets);
					
				}else if ($jdetails['staff_rec']>0 && $jdetails['bcic_rec']==""){
					// staff took the payment - bcic didnt get anything = balance reduces 
					$balance=($balance-$jdetails['bcic_share']);
				}
				

				
				echo '<tr class="table_cells" id="jdetails_'.$jdetails['id'].'">
				  <td><a href="javascript:scrollWindow(\'popup.php?task=jobs&job_id='.$jdetails['job_id'].'\',\'1200\',\'850\')">'.$jdetails['job_id'].'</td>
				  <td>'.$quote['name'].'</td>
				  <td>'.$jdetails['date'].'</td>
				  <td>'.$jdetails['comments'].'</td>
				  <td>'.$jdetails['received'].'</td>
				  <td>'.$jdetails['earned'].'</td>	  
				  <td>'.$balance.'</td>
				</tr>';		
			}else{
				echo '<tr class="table_cells">
				  <td></td>
				  <td>Paid By BCIC</td>
				  <td>'.$jdetails['date'].'</td>
				  <td>'.$jdetails['comments'].'</td>
				  <td>'.$jdetails['received'].'</td>
				  <td>'.$jdetails['earned'].'</td>	  
				  <td>'.$balance.'</td>				 
				</tr>';		
			}
		}
		echo "</table>";
?>