<?php 


if(!isset($_SESSION['quote_compare']['from_date'])){ $_SESSION['quote_compare']['from_date'] = date("Y-m-d" , strtotime('-7 day')); }
if(!isset($_SESSION['quote_compare']['to_date'])){ $_SESSION['quote_compare']['to_date'] = date("Y-m-d"); }

echo '<span class="staff_text" style="margin-bottom:25px;">Quote Compare Report</span><br/>';

echo '<h5 style="margin-left: 615px;margin-top: -50px;font-size: 16px;color: #5abece;">Quote date : '.date("dS M",strtotime($_SESSION['quote_compare']['from_date'])).' ('.date("D",strtotime($_SESSION['quote_compare']['from_date'])).')  to  '.date("dS M",strtotime($_SESSION['quote_compare']['to_date'])).' ('.date("D",strtotime($_SESSION['quote_compare']['to_date'])).')</h5>';

//SELECT count(id),call_date FROM `c3cx_calls` group by call_date

	$getSql = "SELECT *  FROM `quote_new` where 1 = 1 "; 
	
	 if(isset($_SESSION['quote_compare']['from_date']) && $_SESSION['quote_compare']['to_date'] != NULL )
	{ 
		$getSql .= " AND date >= '".date('Y-m-d',strtotime($_SESSION['quote_compare']['from_date']))."' AND date <= '".$_SESSION['quote_compare']['to_date']."'"; 
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
	
	
	$yearData =  array('0'=>date('Y') ,'1'=>date('Y' ,  strtotime('-1 year')) , '2'=>date('Y' ,  strtotime('-2 year'))  );
	
echo '<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">';
  
     echo '<tr class="table_cells">';
		  
		 foreach($yearData as $key=>$val) {
		 echo  '<td colspan="8">'.$val.'</td>';
		 }
		echo '</tr>';
		
    ?>
	   <tr class="table_cells">
		 
		 <?php    foreach($yearData as $key=>$val) { ?> 
           <td>Date</td>		 
		 <td>Total Quote</td>
		  <td>Total Booking</td>
		   <td>Phone</td>
		  <td>Email</td>
		  <td>Site</td>
		  <td>Chat</td>
		  <td>Others</td>
		  
		 <?php  } ?> 
		
		
	</tr>';
	<?php if(mysql_num_rows($getQuoteQuery) > 0) { ?>
	<tr class="table_cells">
		 
		 <?php    foreach($yearData as $key=>$val) { ?> 
          <td>&nbsp;</td>		 
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		   <td>&nbsp;</td>		 
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		   <td>&nbsp;</td>		 
		  <td>&nbsp;</td>
		 <?php  } ?> 
	</tr>

    <?php  		
	  //$sumPhone = 0;
	
        while($getquote = mysql_fetch_array($getQuoteQuery)){
			
			
				 
				   
					
				
		
	?>
	    <tr class="table_cells">
		  
		   <?php  foreach($yearData as $key=>$val) {
			   
			    $nowdate  = date('Y-m-d', strtotime('-'.$key.' year', strtotime($getquote['date'])) );;
				 
					 $getQuoteDetails = getQuoteDetailsdata($nowdate);
					 
					 $totalQ[$key] += $getQuoteDetails['TotalQuote'];
					 $totalBook[$key] += $getQuoteDetails['Totalbookquote'];
					
					
			$phoneQ  = getQuoteByrefrence($nowdate,'Phone','quote','ref');
			$phoneB  = getQuoteByrefrence($nowdate,'Phone','booking','ref');
			$emailQ  = getQuoteByrefrence($nowdate,'Email','quote','ref');
			$emailB  = getQuoteByrefrence($nowdate,'Email','booking','ref');
			$siteQ  = getQuoteByrefrence($nowdate,'Site','quote','ref');
			$siteB  = getQuoteByrefrence($nowdate,'Site','booking','ref');
			$chatQ  = getQuoteByrefrence($nowdate,'Chat','quote','ref');
			$chatB  = getQuoteByrefrence($nowdate,'Chat','booking','ref');
			$otherQ  = getQuoteByrefrence($nowdate,'others','quote','ref');
			$otherB  = getQuoteByrefrence($nowdate,'others','booking','ref');
		
		
		$sumPhoneQ[$key]  += $phoneQ;
		$sumPhoneB[$key]  += $phoneB;
		$sumEmailQ[$key] += $emailQ;
		$sumEmailB[$key]  += $emailB;
		$sumSiteQ[$key]  += $siteQ;
		$sumSiteB[$key] += $siteB;
		$sumChatQ[$key]  += $chatQ;
		$sumChatB[$key]  += $chatB;
		$sumotherQ[$key]  += $otherQ;
		$sumotherB[$key]  += $otherB;
		
					
			   
			   ?>
		   <td><?php  echo  date('dS M Y', strtotime($nowdate)); ?> (<?php  echo  date('l', strtotime($nowdate)); ?>)</td>
		  <td><?php  echo  $getQuoteDetails['TotalQuote']; ?></td>
		  <td><?php  echo  $getQuoteDetails['Totalbookquote']; ?></td>
		  
		  <td><?php if($phoneQ == '0' && $phoneB == '0') { echo "-"; }else {  echo $phoneQ; ?>/<?php  echo $phoneB; } ?></td>
		  
		  <td><?php if($emailQ == '0' && $emailB == '0') {echo "-";}else {  echo $emailQ; ?>/<?php  echo $emailB; } ?></td>
		  
		  <td><?php if($siteQ == '0' && $siteB == '0') {echo "-";}else { echo $siteQ; ?>/<?php  echo $siteB; } ?></td>
		  
		  <td><?php if($chatQ == '0' && $chatB == '0') {echo "-"; }else { echo $chatQ; ?>/<?php  echo $chatB; } ?></td>
		  
		  <td><?php if($otherQ == '0' && $otherB == '0') { echo "-"; }else { echo $otherQ; ?>/<?php  echo $otherB; } ?></td>
		  
		   <?php  } ?>
		</tr>
    <?php 
		}  
	
	?>
	 <tr class="table_cells">
	  <?php    foreach($yearData as $key=>$val) { ?> 
	    <td><strong>Total</strong></td>
		
	    <td><strong><?php echo $totalQ[$key]; ?></strong></td>
	    <td><strong><?php echo $totalBook[$key]; ?></strong></td>
		
		 <td><strong><?php  echo $sumPhoneQ[$key].'/'.$sumPhoneB[$key]; ?></strong></td>
	    <td><strong><?php  echo $sumEmailQ[$key].'/'.$sumEmailB[$key]; ?></strong></td>
	    <td><strong><?php  echo $sumSiteQ[$key].'/'.$sumSiteB[$key]; ?></strong></td>
	    <td><strong><?php  echo $sumChatQ[$key].'/'.$sumChatB[$key]; ?></strong></td>
	    <td><strong><?php  echo $sumotherQ[$key].'/'.$sumotherB[$key]; ?></strong></td>
		
	  <?php  } ?>	
	 </tr>
	 <?php  }else { ?>  
	    <tr><td colspan="20">No Record found</td></tr>
	 <?php  } ?>
    </table>