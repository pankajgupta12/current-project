<?php 

if(!isset($_SESSION['quote_with_status']['from_date'])){ $_SESSION['quote_with_status']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['quote_with_status']['to_date'])){ $_SESSION['quote_with_status']['to_date'] = date("Y-m-t"); }

echo '<span class="staff_text" style="margin-bottom:25px;">Quote With Status</span><br/>';

echo '<h5 style="margin-left: 615px;margin-top: -50px;font-size: 16px;color: #5abece;">Quote date : '.date("dS M",strtotime($_SESSION['quote_with_status']['from_date'])).' ('.date("D",strtotime($_SESSION['quote_with_status']['from_date'])).')  to  '.date("dS M",strtotime($_SESSION['quote_with_status']['to_date'])).' ('.date("D",strtotime($_SESSION['quote_with_status']['to_date'])).')</h5>';


if($_SESSION['quote_with_status']['site_id'] != '')
	{  
       echo '<h4 style="margin-left: 700px;margin-top: -50px;font-size: 20px;color: #00b8d4;">Site :  '.get_rs_value("sites","name",$_SESSION['quote_with_status']['site_id']).'</h4><br/>';
	}
//SELECT count(id),call_date FROM `c3cx_calls` group by call_date

	$getSql = "SELECT *  FROM `quote_new` where 1 = 1 "; 
	
	//print_r($_SESSION['quote_with_status']);
	 if(isset($_SESSION['quote_with_status']['from_date']) && $_SESSION['quote_with_status']['to_date'] != NULL )
	{ 
		$getSql .= " AND date >= '".date('Y-m-d',strtotime($_SESSION['quote_with_status']['from_date']))."' AND date <= '".$_SESSION['quote_with_status']['to_date']."'"; 
	} 
	 if($_SESSION['quote_with_status']['site_id'] != '' && $_SESSION['quote_with_status']['site_id'] != '0')
	{ 
		$getSql .= " AND site_id = '".$_SESSION['quote_with_status']['site_id']."'"; 
		$site_id = $_SESSION['quote_with_status']['site_id'];
	}else {
		$site_id = '';
	} 
	$getSql .= " GROUP BY date Order By date ASC"; 
	//echo $getSql;
	
 $getQuoteQuery =  mysql_query($getSql);
 
 $getSite = mysql_query("SELECT *  FROM `system_dd` WHERE `type` = 31");
    while($getstatusData = mysql_fetch_array($getSite)) {
		$getStatusname[] = $getstatusData['name'];
		$getStatusid[] = $getstatusData['id'];
	}
	
echo '<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">';
  
     echo '<tr class="table_cells">
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="5"><strong>From Reference</strong></td>
		  <td colspan="20"><strong>From Status</strong></td>
		</tr>';

	 ?>
	<tr class="table_cells">
		  <td>Date</td>
		  <td>Total Quote</td>
		  <td>Total Booking</td>
		  <td>Total Cancelled Booking</td>
		  <td>Total Booking<br/>With OTO</td>
		  <td>Deleted Quote</td>
		  <td>Phone</td>
		  <td>Email</td>
		  <td>Site</td>
		  <td>Chat</td>
		  <td>Others</td>
		<?php  foreach($getStatusname as $getdata) { ?>  
		  <td><?php echo $getdata;  ?></td>
		<?php  } ?>
	</tr>
	<?php if(mysql_num_rows($getQuoteQuery) > 0) { ?>
	<tr class="table_cells">
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Q / B</td>
		  <td>Q / B</td>
		  <td>Q / B</td>
		  <td>Q / B</td>
		  <td>Q / B</td>
		<?php  foreach($getStatusname as $getuser) { ?>  
		   <td>Q / B</td>
		<?php  } ?>
	</tr>

    <?php  		
	  //$sumPhone = 0;
	 
        while($getquote = mysql_fetch_array($getQuoteQuery)){
	     $getQuoteDetails = getQuoteDetailsStatusdata($getquote['date'],$site_id);
		 
		 //print_r($getQuoteDetails);
		 
        $totalQ += $getQuoteDetails['TotalQuote'];
        $totalBook += $getQuoteDetails['Totalbookquote'];
        $totaldeleted += $getQuoteDetails['totaldeletequote']; 
        $totalotobooked += $getQuoteDetails['totalotobooked']; 
        $Totalbookcanquote += $getQuoteDetails['Totalbookcanquote']; 
		
		 $PhoneQ  = getQuoteByStatusRef($getquote['date'],'Phone','quote','ref',$site_id);
		$PhoneB = getQuoteByStatusRef($getquote['date'],'Phone','booking','ref',$site_id);
		$EmailQ = getQuoteByStatusRef($getquote['date'],'Email','quote','ref',$site_id);
		$EmailB = getQuoteByStatusRef($getquote['date'],'Email','booking','ref',$site_id);
		$SiteQ  = getQuoteByStatusRef($getquote['date'],'Site','quote','ref',$site_id);
		$SiteB  = getQuoteByStatusRef($getquote['date'],'Site','booking','ref',$site_id);
		$ChatQ  = getQuoteByStatusRef($getquote['date'],'Chat','quote','ref',$site_id);
		$ChatB  = getQuoteByStatusRef($getquote['date'],'Chat','booking','ref',$site_id);
		$otherQ = getQuoteByStatusRef($getquote['date'],'others','quote','ref',$site_id);
		$otherB = getQuoteByStatusRef($getquote['date'],'others','booking','ref',$site_id); 
		
		
		$sumPhoneQ  += $PhoneQ;
		$sumPhoneB  += $PhoneB;
		$sumEmailQ  += $EmailQ;
		$sumEmailB  += $EmailB;
		$sumSiteQ   += $SiteQ;
		$sumSiteB   += $SiteB;
		$sumChatQ   += $ChatQ;
		$sumChatB   += $ChatB;
		$sumotherQ  += $otherQ;
		$sumotherB  += $otherB;
		
		
		
	?>
	    <tr class="table_cells">
		  <td><?php  echo  date('dS M', strtotime($getquote['date'])); ?> (<?php  echo  date('l', strtotime($getquote['date'])); ?>)</td>
		  <td><?php  echo  $getQuoteDetails['TotalQuote']; ?></td>
		  <td><?php  echo  $getQuoteDetails['Totalbookquote']; ?></td>
		   <td><?php echo $getQuoteDetails['Totalbookcanquote']; ?></td>
		  <td><?php echo $getQuoteDetails['totalotobooked']; ?></td>
		  <td><?php // echo $getQuoteDetails['Totalbookcanquote']; ?></td>
		  <td><?php if($getQuoteDetails['totaldeletequote'] == '0') {echo "-"; }else { echo  $getQuoteDetails['totaldeletequote']; } ?></td>
		  
		  <td><?php if($PhoneQ == '0' && $PhoneB == '0') {echo "-"; } else { echo $PhoneQ; ?>/<?php  echo $PhoneB; } ?></td>
		  
		  <td><?php if($EmailQ == '0' && $EmailB == '0') {echo "-";}else {  echo $EmailQ; ?>/<?php  echo $EmailB; } ?></td>
		  
		  <td><?php if($SiteQ == '0' && $SiteB == '0') {echo "-";}else { echo $SiteQ; ?>/<?php  echo $SiteB; } ?></td>
		  
		  <td><?php if($ChatQ == '0' && $ChatB == '0') {echo "-";}else { echo $ChatQ; ?>/<?php  echo $ChatB; } ?></td>
		  
		  <td><?php if($otherQ == '0' && $otherB == '0') {echo "-";}else { echo $otherQ; ?>/<?php  echo $otherB; } ?></td>
		  
		  <?php   foreach($getStatusid as $key=>$statusID) { 
		     $quotesite  =   getQuoteBystatus($getquote['date'],$statusID,'quote','status',$site_id);
			 $booingsite = getQuoteBystatus($getquote['date'],$statusID,'booking','status',$site_id); 
		  ?>  
		  <td><?php if($quotesite == '0' && $booingsite == '0') {echo "-";}else { echo $quotesite;  ?>/<?php echo $booingsite;  } ?></td>
		  
		  <?php 
		  $sumSitedataQ[$key]  += $quotesite;  
		  $sumSitedataB[$key]  += $booingsite;  
		  }  ?>
		</tr>
    <?php 
	} 
	
	?>
	 <tr class="table_cells">
	    <td><strong>Total</strong></td>
	    <td><strong><?php echo $totalQ; ?></strong></td>
	    <td><strong><?php echo $totalBook; ?></strong></td>
	    <td><strong><?php echo $Totalbookcanquote; ?></strong></td>
	    <td><strong><?php echo $totalotobooked; ?></strong></td>
	    <td><strong><?php echo $totaldeleted; ?></strong></td>
	    <td><strong><?php  echo $sumPhoneQ.'/'.$sumPhoneB; ?></strong></td>
	    <td><strong><?php  echo $sumEmailQ.'/'.$sumEmailB; ?></strong></td>
	    <td><strong><?php  echo $sumSiteQ.'/'.$sumSiteB; ?></strong></td>
	    <td><strong><?php  echo $sumChatQ.'/'.$sumChatB; ?></strong></td>
	    <td><strong><?php  echo $sumotherQ.'/'.$sumotherB; ?></strong></td>
		<?php   foreach($getStatusid as $key=>$statusID) { ?>  	
			<td ><strong><?php  echo ($sumSitedataQ[$key]); ?>/<?php echo ($sumSitedataB[$key]); ?></strong></td>
		<?php  }  ?>	
	 </tr>
	 <?php  }else { ?>  
	    <tr><td colspan="20">No Record found</td></tr>
	 <?php  } ?>
    </table>
	