<?php 


if(!isset($_SESSION['quote_report_dashboard']['from_date'])){ $_SESSION['quote_report_dashboard']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['quote_report_dashboard']['to_date'])){ $_SESSION['quote_report_dashboard']['to_date'] = date("Y-m-t"); }

echo '<span class="staff_text" style="margin-bottom:25px;">Quote Report Dashboard</span><br/>';

echo '<h5 style="margin-left: 615px;margin-top: -50px;font-size: 16px;color: #5abece;">Quote date : '.date("dS M",strtotime($_SESSION['quote_report_dashboard']['from_date'])).' ('.date("D",strtotime($_SESSION['quote_report_dashboard']['from_date'])).')  to  '.date("dS M",strtotime($_SESSION['quote_report_dashboard']['to_date'])).' ('.date("D",strtotime($_SESSION['quote_report_dashboard']['to_date'])).')</h5>';

//SELECT count(id),call_date FROM `c3cx_calls` group by call_date

	$getSql = "SELECT *  FROM `quote_new` where 1 = 1 "; 
	
	 if(isset($_SESSION['quote_report_dashboard']['from_date']) && $_SESSION['quote_report_dashboard']['to_date'] != NULL )
	{ 
		$getSql .= " AND date >= '".date('Y-m-d',strtotime($_SESSION['quote_report_dashboard']['from_date']))."' AND date <= '".$_SESSION['quote_report_dashboard']['to_date']."'"; 
	} 
	$getSql .= " GROUP BY date Order By date ASC"; 
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
		  <td>&nbsp;</td>
		  <td colspan="5"><strong>From Reference</strong></td>
		  <td colspan="20"><strong>From Site</strong></td>
		</tr>';

	 ?>
	<tr class="table_cells">
		  <td>Date</td>
		  <td>Total Quote</td>
		  <td>Total Booking</td>
		  <td>Cancelled Job</td>
		  <td>Deleted Quote</td>
		  <td>Phone</td>
		  <td>Email</td>
		  <td>Site</td>
		  <td>Chat</td>
		  <td>Others</td>
		<?php  foreach($getSitename as $getdata) { ?>  
		  <td><?php echo $getdata;  ?></td>
		<?php  } ?>
	</tr>
	<?php if(mysql_num_rows($getQuoteQuery) > 0) { ?>
	<tr class="table_cells">
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Q / B</td>
		  <td>Q / B</td>
		  <td>Q / B</td>
		  <td>Q / B</td>
		<?php  foreach($getSitename as $getuser) { ?>  
		   <td>Q / B</td>
		<?php  } ?>
	</tr>

    <?php  		
	  //$sumPhone = 0;
	 
        while($getquote = mysql_fetch_array($getQuoteQuery)){
	     $getQuoteDetails = getQuoteDetailsdata($getquote['date']);
		 
	     $totalQ += $getQuoteDetails['TotalQuote'];
	     $totalBook += $getQuoteDetails['Totalbookquote'];
	     $totaldeleted += $getQuoteDetails['deletequote'];
	     $totalbookingcanc += $getQuoteDetails['Totalbookingcanc'];
		
		$phoneQ  = getQuoteByrefrence($getquote['date'],'Phone','quote','ref');
		$phoneB  = getQuoteByrefrence($getquote['date'],'Phone','booking','ref');
		$emailQ  = getQuoteByrefrence($getquote['date'],'Email','quote','ref');
		$emailB  = getQuoteByrefrence($getquote['date'],'Email','booking','ref');
		$siteQ  = getQuoteByrefrence($getquote['date'],'Site','quote','ref');
		$siteB  = getQuoteByrefrence($getquote['date'],'Site','booking','ref');
		$chatQ  = getQuoteByrefrence($getquote['date'],'Chat','quote','ref');
		$chatB  = getQuoteByrefrence($getquote['date'],'Chat','booking','ref');
		$otherQ  = getQuoteByrefrence($getquote['date'],'others','quote','ref');
		$otherB  = getQuoteByrefrence($getquote['date'],'others','booking','ref');
		
		
		$sumPhoneQ  += $phoneQ;
		$sumPhoneB  += $phoneB;
		$sumEmailQ  += $emailQ;
		$sumEmailB  += $emailB;
		$sumSiteQ  += $siteQ;
		$sumSiteB  += $siteB;
		$sumChatQ  += $chatQ;
		$sumChatB  += $chatB;
		$sumotherQ  += $otherQ;
		$sumotherB  += $otherB;
		
		
	?>
	    <tr class="table_cells">
		  <td><?php  echo  date('dS M', strtotime($getquote['date'])); ?> (<?php  echo  date('l', strtotime($getquote['date'])); ?>)</td>
		  <td><?php  echo  $getQuoteDetails['TotalQuote']; ?></td>
		  <td><?php  echo  $getQuoteDetails['Totalbookquote']; ?></td>
		  <td><?php  echo  $getQuoteDetails['Totalbookingcanc']; ?></td>
		  <td><?php  if($getQuoteDetails['deletequote'] == '0') {echo "-"; }else { echo  $getQuoteDetails['deletequote']; } ?></td>
		  
		  <td><?php if($phoneQ == '0' && $phoneB == '0') { echo "-"; }else {  echo $phoneQ; ?>/<?php  echo $phoneB; } ?></td>
		  
		  <td><?php if($emailQ == '0' && $emailB == '0') {echo "-";}else {  echo $emailQ; ?>/<?php  echo $emailB; } ?></td>
		  
		  <td><?php if($siteQ == '0' && $siteB == '0') {echo "-";}else { echo $siteQ; ?>/<?php  echo $siteB; } ?></td>
		  
		  <td><?php if($chatQ == '0' && $chatB == '0') {echo "-"; }else { echo $chatQ; ?>/<?php  echo $chatB; } ?></td>
		  
		  <td><?php if($otherQ == '0' && $otherB == '0') { echo "-"; }else { echo $otherQ; ?>/<?php  echo $otherB; } ?></td>
		  
		  
		  <?php  foreach($getSiteid as $key=>$siteID) {
                    $sitequote =  getQuoteByrefrence($getquote['date'],$siteID,'quote','site');
					$sitebooking =   getQuoteByrefrence($getquote['date'],$siteID,'booking','site');
              
		  ?>  
		  <td><?php  if($sitequote == '0' && $sitebooking == '0') {echo "-"; }else { echo $sitequote;  ?>/<?php echo $sitebooking;  }
		  ?></td>
		  <?php 
			  $sumSitedataQ[$key]  += $sitequote;  
			  $sumSitedataB[$key]  += $sitebooking;  
		  } ?>
		</tr>
    <?php 
	} 
	
	?>
	 <tr class="table_cells">
	    <td><strong>Total</strong></td>
	    <td><strong><?php echo $totalQ; ?></strong></td>
	    <td><strong><?php echo $totalBook; ?></strong></td>
	    <td><strong><?php echo $totalbookingcanc; ?></strong></td>
	    <td><strong><?php echo $totaldeleted; ?></strong></td>
	    <td><strong><?php  echo $sumPhoneQ.'/'.$sumPhoneB; ?></strong></td>
	    <td><strong><?php  echo $sumEmailQ.'/'.$sumEmailB; ?></strong></td>
	    <td><strong><?php  echo $sumSiteQ.'/'.$sumSiteB; ?></strong></td>
	    <td><strong><?php  echo $sumChatQ.'/'.$sumChatB; ?></strong></td>
	    <td><strong><?php  echo $sumotherQ.'/'.$sumotherB; ?></strong></td>
		<?php  foreach($getSiteid as $key=>$siteID) { ?>  	
			<td ><strong><?php  echo ($sumSitedataQ[$key]); ?>/<?php echo ($sumSitedataB[$key]); ?></strong></td>
		<?php  } ?>	
	 </tr>
	 <?php  }else { ?>  
	    <tr><td colspan="20">No Record found</td></tr>
	 <?php  } ?>
    </table>