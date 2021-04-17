<?php  
    if(!isset($_SESSION['bbc_invoice']['from_date'])){ $_SESSION['bbc_invoice']['from_date'] = date('Y-m-d' ,  strtotime('-7 day'));  }
    if(!isset($_SESSION['bbc_invoice']['to_date'])){ $_SESSION['bbc_invoice']['to_date'] = date('Y-m-d'); }


$sql = mysql_query(" select id , name from staff where status = 1 AND better_franchisee = 2 AND bbc_leads = 2 ");
$query = mysql_num_rows($sql);


?>

    <div id="daily_view">
       <span class="staff_text" style="margin-bottom: -11px;margin-left: 15px;text-align: center;">BBC Invoice ( <?php echo date('dS M Y', strtotime($_SESSION['bbc_invoice']['from_date'])).' to '.date('dS M Y', strtotime($_SESSION['bbc_invoice']['to_date'])) ?> ) </span>
    <br><br>
    
    

<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
	   
	     <tbody>
        	   <tr class="table_cells">
        			  <td style="width: 20%;"><strong>BBC Staff</strong></td>
        			  <td colspan="4"><strong>invoice</strong></td>
        		</tr>
	           
	            <?php  
	            
	             $getdata =  getleadsBooking($_SESSION['bbc_invoice']['from_date'] , $_SESSION['bbc_invoice']['to_date']);
	          
	            while($data = mysql_fetch_assoc($sql)) { 
	            
	            
	                   /****************************************** Toatl ******************************************/
	            
	                    /* Booking Lead Info*/
	                    $bookedlead = $getdata[1];
                        $totaljobs = count($bookedlead[$data['id']]);
                        
                        $amountjob  = array_column($bookedlead[$data['id']] , 'amount');
                        $totalamount = array_sum($amountjob);
                        
                        $roylty = ($totalamount*10)/100;
                        $marchentfee = ($totalamount*2.5)/100;
                        
                        $bookingleadPayment = $totaljobs*10;
                        
                        
                        /* Not Booking Lead Info*/
                        $notbookedgetdata = $getdata[0];
                        $totalleadsnotbooked = count($notbookedgetdata[$data['id']]);
                        $totalleadamount = $totalleadsnotbooked*10;
                        
                        /* Payment TO Pay*/
                        
                         // $totalpay = $totalamount - ($roylty + $marchentfee + $bookingleadPayment + $totalleadamount);
                         
                          $totalpay = $totalamount - ($roylty + $marchentfee  + $totalleadamount);
                          
                          
                   /****************************************** Paid ******************************************/                          
                         /* Booking Lead Info*/
	                    $paid_bookedlead = $getdata['paid'];
                        $paid_totaljobs = count($paid_bookedlead[$data['id']]);
                        
                        $paid_amountjob  = array_column($paid_bookedlead[$data['id']] , 'amount');
                        $paid_totalamount = array_sum($paid_amountjob);
                        
                        $paid_roylty = ($paid_totalamount*10)/100;
                        $paid_marchentfee = ($paid_totalamount*2.5)/100;
                        
                        $paid_bookingleadPayment = $paid_totaljobs*10;
                        
                        
                        /* Not Booking Lead Info*/
                        $paid_notbookedgetdata = $getdata['unpaid'];
                        $paid_totalleadsnotbooked = count($paid_notbookedgetdata[$data['id']]);
                        $paid_totalleadamount = $paid_totalleadsnotbooked*10;
                        
                        /* Payment TO Pay*/
                        
                          //$paid_totalpay = $paid_totalamount - ($paid_roylty + $paid_marchentfee + $paid_bookingleadPayment + $paid_totalleadamount);
                          
                          $paid_totalpay = $paid_totalamount - ($paid_roylty + $paid_marchentfee + $paid_totalleadamount);
	            
	            ?>
	
					      <tr>
			
				 				<td><?php echo  $data['name']; ?></td>
				 				<td>
				 				     <table border="1" style="width: 100%;">
				 				         
				 				          <tr> 
                                              <th>From 1st March to 31st March </th> 
                                              <th>Total  (  <?php  echo $totaljobs;  ?> )</th> 
                                              <th>Paid  ( <?php  echo $paid_totaljobs;  ?> )</th> 
                                              <th>Balance (<?php echo ( $totaljobs - $paid_totaljobs )  ?>) </th> 
                                           </tr>
				 				         
                                           <tr> 
                                              <td>Total Jobs Booked</td> 
                                              <td><?php  echo ($totalamount);  ?></td> 
                                              <td><?php  echo ($paid_totalamount);  ?></td> 
                                              <td> <?php echo ( $totalamount - $paid_totalamount )  ?> </td> 
                                           </tr>
                                           
                                            <tr> 
                                              <td>10% Royalty Fees</td> 
                                              <td><?php  echo $roylty;  ?></td> 
                                              <td><?php  echo $paid_roylty;  ?></td> 
                                              <td> <?php echo ( $roylty - $paid_roylty )  ?> </td> 
                                           </tr>
                                           
                                            <tr> 
                                              <td>2.5 % Merchant Fees </td> 
                                              <td><?php  echo $marchentfee;  ?></td> 
                                              <td><?php  echo $paid_marchentfee;  ?></td> 
                                              <td><?php echo ( $marchentfee - $paid_marchentfee )  ?></td> 
                                           </tr>
                                            <!--<tr> 
                                              <td>Total Booking Leads fee</td> 
                                              <td><?php echo  $bookingleadPayment;  ?></td> 
                                              <td><?php  echo $paid_bookingleadPayment;  ?></td> 
                                              <td><?php echo ( $bookingleadPayment - $paid_bookingleadPayment )  ?></td>  
                                            </tr>-->
                                            
                                             <tr> 
                                              <td>Total Booking Leads fee ( <?php echo  $totalleadsnotbooked; ?> )</td> 
                                              <td><?php echo  $totalleadamount;  ?></td> 
                                              <td><?php  echo $paid_totalleadamount;  ?></td> 
                                              <td><?php echo ( $totalleadamount - $paid_totalleadamount )  ?></td>  
                                            </tr>
                                            
				 				          <tr> 
                                              <td>IT Management Fees	</td> 
                                               <td></td> 
                                              <td></td> 
                                              <td></td> 
                                           </tr>
                                           
                                           <tr> 
                                              <td>Total Balance to Pay</td> 
                                               <td><?php echo $totalpay;  ?></td> 
                                              <td><?php  echo $paid_totalpay;  ?></td> 
                                              <td><?php echo ( $totalpay - $paid_totalpay )  ?></td> 
                                           </tr>
				 				    </table>  
				 				</td>
				 				
				 			</tr>
				 			
				 <?php  }  ?>	
    </tbody></table>
    
    </div>
    
    
    <style>
        table tr th {
          text-align: center;
            padding: 10px;
        }
      }
      
    </style>