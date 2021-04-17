<?php 

if(!isset($_SESSION['my_quote']['from_date'])){ $_SESSION['my_quote']['from_date'] = date("Y-m-1", strtotime('-30 day')); }
if(!isset($_SESSION['my_quote']['to_date'])){ $_SESSION['my_quote']['to_date'] = date("Y-m-t", strtotime('-30 day')); }

echo '<span class="staff_text" style="margin-bottom:25px;">Quote Report Dashboard</span><br/>';

/* echo '<h5 style="margin-left: 615px;margin-top: -50px;font-size: 16px;color: #5abece;">Quote date : '.date("dS M",strtotime($_SESSION['quote_report_dashboard']['from_date'])).' ('.date("D",strtotime($_SESSION['quote_report_dashboard']['from_date'])).')  to  '.date("dS M",strtotime($_SESSION['quote_report_dashboard']['to_date'])).' ('.date("D",strtotime($_SESSION['quote_report_dashboard']['to_date'])).')</h5>'; */

//SELECT count(id),call_date FROM `c3cx_calls` group by call_date

	/* $getSql = "SELECT *  FROM `quote_new` where 1 = 1 AND login_id = ".$_SESSION['admin'].""; 
	
	 if(isset($_SESSION['my_quote']['from_date']) && $_SESSION['my_quote']['to_date'] != NULL )
	{ 
		$getSql .= " AND date >= '".date('Y-m-d',strtotime($_SESSION['my_quote']['from_date']))."' AND date <= '".$_SESSION['my_quote']['to_date']."'"; 
	} 
	$getSql .= " GROUP BY date Order By date ASC"; 
	echo $getSql; */
	$getSql =  "SELECT date FROM `quote_new` where 1 = 1 AND login_id = 3 AND date >= '2017-12-01' AND date <= '2017-12-30' GROUP BY date Order By date ASC";
	
 $arg =  mysql_query($getSql);
 
 
 $admin_sql = mysql_query("SELECT * FROM `admin` where is_call_allow = 1");
  while($getAdmin = mysql_fetch_assoc($admin_sql)) {
	  $admindata[$getAdmin['id']] = $getAdmin['name'];
  }
  
	
echo '<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">';
  
    /*  echo '<tr class="table_cells">
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="5"><strong>From Reference</strong></td>
		  <td colspan="11"><strong>From Site</strong></td>
		</tr>'; */

	 ?>
	<tr class="table_cells">
		  <td>Date</td>
		 <?php foreach($admindata as $key=>$adminname) { ?>
          <td><?php  echo $adminname.'<br>Q/B'; ?></td>
		 <?php  } ?>
	</tr>
	

    <?php  
	   while($data = mysql_fetch_assoc($arg)) {
		
	?>
	    <tr class="table_cells">
		  <td><?php echo $data['date']; ?></td>
		  <?php foreach($admindata as $key=>$adminname) {
             $sumquotedata_Q[$key]  += getMyQuoteDetails($data['date'] , $key,1);
             $sumquotedata_B[$key]  += getMyQuoteDetails($data['date'] , $key,2);
			// echo getMyQuoteDetails($data['date'] , $key, 1);
		  ?>
			  <td><?php if((getMyQuoteDetails($data['date'] , $key,1) == '0') || (getMyQuoteDetails($data['date'] , $key, 2)) == '0') {  echo '-'; } else { echo getMyQuoteDetails($data['date'] , $key, 1);  ?>/<?php echo getMyQuoteDetails($data['date'] , $key, 2); } ?></td>   
		  <?php  } ?>
		</tr>
		<?php  } ?>
		<tr>
		 <td>Total Quote</td>
			<?php  foreach($admindata as $key=>$adminname) { ?>  	
				<td ><strong><?php echo ($sumquotedata_Q[$key]); ?>/<?php echo ($sumquotedata_B[$key]); ?></strong></td>
			<?php  } ?>	
		</tr>
		<tr>
		 <td colspan="20">Total Quote <?php echo (array_sum($sumquotedata_Q)); ?>/<?php echo (array_sum($sumquotedata_B)); ?> </td>
		</tr>
	  
    </table>