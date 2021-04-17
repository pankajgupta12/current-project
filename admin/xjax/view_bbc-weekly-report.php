<?php 

$sql = mysql_query(" select id , name from staff where status = 1 AND better_franchisee = 2 AND bbc_leads = 2 ");
$query = mysql_num_rows($sql);

 ?>

<span class="staff_text" style="margin-bottom: -11px;margin-left: 15px;text-align: center;">BBC Weekly Report </span>
<br/>

<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
	   
	     <tbody>
                	   <tr class="table_cells">
                			  <td style="width: 20%;"><strong>BBC Staff</strong></td>
                			  <td colspan="4"><strong>invoice</strong></td>
                		</tr>    
                		
                		<?php 
                		
                		    while($data = mysql_fetch_assoc($sql)) { 
                		        
                		?>
					      <tr>
				 				<td><?php echo  $data['name'];  ?></td>
				 				<td>
				 				     <table border="1" style="width: 100%;">
				 				         
				 				          <tbody><tr> 
                                              <th style="text-align:center;">From 1st March to 31st March </th> 
                                              <th style="text-align:center;">Amount</th> 
                                           </tr>
				 				         
                                           <tr> 
                                              <td>Total Jobs Booked</td> 
                                              <td></td>
                                           </tr>
                                           
                                            <tr> 
                                              <td>10% Royalty Fees</td> 
                                              <td>0</td> 
                                           </tr>
                                           
                                            <tr> 
                                              <td>2.5 % Merchant Fees </td> 
                                              <td>0</td> 
                                           </tr>
                                           
                                            <tr> 
                                              <td>Total Leads Not Booked Fee ( 0 ) </td> 
                                              <td>0</td> 
                                           </tr>
                                            <tr> 
                                              <td>Upaid Leads before </td> 
                                              <td>0</td> 
                                           </tr>
                                           
                                            <tr> 
                                              <td>TOTAL Balance to Pay </td> 
                                              <td>0</td> 
                                           </tr>
                                           
				 				    </tbody></table>  
				 				</td>
				 				
				 			</tr>
				 			
				 <?php  } ?>			
				 	
    </tbody></table>