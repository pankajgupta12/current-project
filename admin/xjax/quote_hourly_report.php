<?php 




if($_SESSION['hourly_quote']['quote_date'] == "") {
      $_SESSION['hourly_quote']['quote_date'] = date('Y-m-d',strtotime('-1 week'));
    } 
	
	if($_SESSION['hourly_quote']['to_date'] == "") {
      $_SESSION['hourly_quote']['to_date'] = date('Y-m-d',strtotime('yesterday'));
    } 
//print_r($_SESSION['hourly_quote']); die;

echo '<span class="staff_text" style="margin-bottom:25px;">Quote Hourly Reports</span><br/>';
echo '<h4 style="margin-left: 615px;margin-top: -50px;font-size: 16px;color: #5abece;">Quote date : '.date("dS M",strtotime($_SESSION['hourly_quote']['quote_date'])).' ('.date("D",strtotime($_SESSION['hourly_quote']['quote_date'])).')  to  '.date("dS M",strtotime($_SESSION['hourly_quote']['to_date'])).' ('.date("D",strtotime($_SESSION['hourly_quote']['to_date'])).')</h4>';

//SELECT count(id),call_date FROM `c3cx_calls` group by call_date

	$getSql = "SELECT *  FROM `quote_new` where 1 = 1 "; 
	//$getSql = "SELECT HOUR(createdOn) AS hours, COUNT(id) as totalQ from quote_new where 1 = 1"; 
	//$_SESSION['quote']['quote_date'] = '2017-09-29';
	/*  if(isset($_SESSION['hourly_quote']['quote_date']))
	{ 
		$getSql .= " AND date = '".date('Y-m-d',strtotime($_SESSION['hourly_quote']['quote_date']))."'"; 
	}  */
	
	if(isset($_SESSION['hourly_quote']['quote_date']) && $_SESSION['hourly_quote']['to_date'] != NULL )
	{ 
		$getSql .= " AND date >= '".date('Y-m-d',strtotime($_SESSION['hourly_quote']['quote_date']))."' AND date <= '".$_SESSION['hourly_quote']['to_date']."'"; 
	} 
	
	$getSql .= "  GROUP by date"; 
	//echo $getSql;
	
 $getQuoteQuery =  mysql_query($getSql);
 
 
 $getSite = mysql_query("SELECT name,id,abv from sites");
    while($getSiteData = mysql_fetch_array($getSite)) {
		$getSitename[] = $getSiteData['name'];
		$getSiteabv[] = $getSiteData['abv'];
		$getSiteid[] = $getSiteData['id'];
	}
	
echo '<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">';
  
     echo '<tr class="table_cells">
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="5"><strong>From Reference</strong></td>
		  <td colspan="11"><strong>From Site</strong></td>
		</tr>';

	 ?>
	 
	 <style>
	  .quote_font_size td{
		font-size: 14px;
	  }
	 </style>
	 
	<tr class="table_cells">
		  <td><strong>Date</strong></td>
		  <td><strong>Total Quote</strong></td>
		  <td><strong>Total Booking</strong></td>
		  <td><strong>Phone</strong></td>
		  <td><strong>Email</strong></td>
		  <td><strong>Site</strong></td>
		  <td><strong>Chat</strong></td>
		  <td><strong>Others</strong></td>
		<?php  foreach($getSitename as $getdata) { ?>  
		  <td><strong><?php echo $getdata;  ?></strong></td>
		<?php  } ?>
	</tr>
	<?php  if(mysql_num_rows($getQuoteQuery) > 0) { ?>
	<tr class="table_cells">
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Q / B</td>
		  <td>Q / B</td>
		  <td>Q / B</td>
		  <td>Q / B</td>
		  <td>Q / B</td>
		<?php  foreach($getSitename as $getuser) { ?>  
		   <td>Q / B</td>
		<?php  } ?>
	</tr>
	
	<?php 
    	//echo "ok11111";
	
		//echo "ok1";
		
		//$getdatea  =mysql_fetch_array($getQuoteQuery);
		//print_r($getdatea);
		
	  for($h = 0; $h<24; $h++) {
		  
		$getdatea['date'] = $_SESSION['hourly_quote']['quote_date'];
		$todate = $_SESSION['hourly_quote']['to_date']; 
		  
		$getQuoteDetails = getTotalRecordHourly($getdatea['date'], $todate, $h);
		
		$totalQ  += $getQuoteDetails['totalQuote1'];
		$totalBook  += $getQuoteDetails['totalbook'];
		
		
		
		$qhr_phone  = gethourlyref($getdatea['date'], $todate, $h , 'Phone','quote');
		$bhr_phone =  gethourlyref($getdatea['date'], $todate, $h , 'Phone','booking');
		
		
		$qhr_email = gethourlyref($getdatea['date'], $todate, $h , 'Email','quote');
		$bhr_email = gethourlyref($getdatea['date'], $todate, $h , 'Email','booking');
		
		
		$qhr_site = gethourlyref($getdatea['date'], $todate, $h , 'Site','quote');
		$bhr_site = gethourlyref($getdatea['date'], $todate, $h , 'Site','booking');
		
		
		$qhr_chat = gethourlyref($getdatea['date'],  $todate, $h , 'Chat','quote');
		$bhr_chat = gethourlyref($getdatea['date'],  $todate,  $h , 'Chat','booking');
		
		$qhr_other = gethourlyref($getdatea['date'],  $todate, $h , '0','quote');
		$bhr_other = gethourlyref($getdatea['date'],  $todate, $h , '0','booking');
		
		/* ======= */
		$totalQ_phone += $qhr_phone;
		$totalB_phone += $bhr_phone;
		
		$totalQ_email += $qhr_email;
		$totalB_email += $bhr_email;
		
		$totalQ_site += $qhr_site;
		$totalB_site += $bhr_site;
		
		$totalQ_chat += $qhr_chat;
		$totalB_chat += $bhr_chat;
		
		$totalQ_other += $qhr_other;
		$totalB_other += $bhr_other;
	?>
		<tr class="quote_font_size">
		   <td><?php   echo str_pad($h, 2, "0", STR_PAD_LEFT); ?>:<?php  echo str_pad($h+1, 2, "0", STR_PAD_LEFT); ?></td>
		   <td><?php  echo  $getQuoteDetails['totalQuote1']; ?></td>	
		   <td><?php  echo  $getQuoteDetails['totalbook']; ?></td>	
		   
	       <td><?php if($qhr_phone == '0' && $bhr_phone == '0') { echo "-"; }else { echo $qhr_phone; ?>/<?php echo $bhr_phone;  } ?></td>	
		   
		   <td><?php if($qhr_email == '0' && $bhr_email == '0') {  echo "-"; }else { echo $qhr_email; ?>/<?php echo $bhr_email;  } ?></td>	
		   
		   <td><?php if($qhr_site == '0' && $bhr_site == '0') { echo "-";  }else { echo $qhr_site; ?>/<?php echo $bhr_site; } ?></td>
		   
		   <td><?php if($qhr_chat == '0' && $bhr_chat == '0') {echo "-"; }else { echo $qhr_chat; ?>/<?php echo $bhr_chat; } ?></td>
		   
		   <td><?php if($qhr_other == '0' && $bhr_other == '0') { echo "-";}else { echo $qhr_other; ?>/<?php echo $qhr_other; } ?></td>	
		   
		   <?php  foreach($getSiteid as $key=>$siteid) { 
		      
		     $sitehr_q =  gethourlysite($getdatea['date'], $todate,  $h ,$siteid ,'quote');
			 $sitehr_b = gethourlysite($getdatea['date'], $todate,  $h ,$siteid ,'booking');
		   
		   ?>  
		    <td><?php if($sitehr_q == '0' && $sitehr_b == '0') {echo "-"; }else { echo $sitehr_q; ?>/<?php echo $sitehr_b; } ?></td>
			
		   <?php  
		      $sumSitedataQ[$key]  += $sitehr_q;  
		      $sumSitedataB[$key]  += $sitehr_b; 
		    } 
		   ?>		   
		</tr>	  
	<?php } ?>
      <tr class="table_cells">
	    <td><strong>Total</strong></td>
	    <td><strong><?php echo $totalQ; ?></strong></td>
	    <td><strong><?php echo $totalBook; ?></strong></td>
	    <td><strong><?php echo $totalQ_phone.'/'.$totalB_phone; ?></strong></td>
	    <td><strong><?php echo $totalQ_email.'/'.$totalB_email; ?></strong></td>
	    <td><strong><?php echo $totalQ_site.'/'.$totalB_site; ?></strong></td>
	    <td><strong><?php echo $totalQ_chat.'/'.$totalB_chat; ?></strong></td>
	    <td><strong><?php echo $totalQ_other.'/'.$totalB_other; ?></strong></td>
		<?php  foreach($getSiteid as $key=>$siteID) { ?>  	
			<td ><strong><?php  echo ($sumSitedataQ[$key]); ?>/<?php echo ($sumSitedataB[$key]); ?></strong></td>
	<?php  } }else { ?>	
	  <td colspan="25">No Record found</td>
	<?php  } ?>
	 </tr>
    </table>