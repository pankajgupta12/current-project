<?php 


if(!isset($_SESSION['bbc_leads']['from_date'])){ $_SESSION['bbc_leads']['from_date'] = date("Y-m-d"); }

			$staffname =  GetLeadStaff(2);
	
?>
    <span class="staff_text" style="margin-bottom: -11px;margin-left: 15px;">On The Day BBC Lead Quote</span>
    <br/><br/>
	
    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
		<tr class="table_cells">
			  <td><strong>Staff Name</strong></td>
			   <td>BBC Lead</td>
			   <td>Total Leades</td>
			   <td>Cretaed Lead</td>
			    <td>Rest lead</td>
		</tr>
			<?php  foreach($staffname as $sname) {
				 $countre =  getQuoteCnt($sname['id'], $_SESSION['bbc_leads']['from_date']);
				 
				 $restq = ($sname['maxleadcnt'] - $countre);
			?>
			<tr>
				<td><?php echo ucfirst($sname['name']); ?></td>
				 <td><?php  if($sname['bbc_leads'] == 1) {echo 'No'; }else{echo 'Yes';} ?></td>
				<td><?php echo $sname['maxleadcnt'];  ?></td>
				<td><?php echo $countre; ?></td>
				<td><?php  echo $restq; ?></td>	
			</tr>
			<?php  } ?>
    </table>