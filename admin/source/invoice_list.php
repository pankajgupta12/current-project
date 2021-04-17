    <?php  
 
	  
	 $query = mysql_query("SELECT * FROM `bcic_invoice`  WHERE year = '".$_GET['year']."' AND staff_id = ".$_GET['staff_id']." Order by invoice_from_date asc");
	 
	   $getstaffdetails = mysql_fetch_assoc(mysql_query("select * from staff where id = ".$_GET['staff_id']." AND status = 1")); 	
	 
	  $stafftype = $getstaffdetails['better_franchisee'];	
	 
    ?>
	  <span class="staff_text" style="margin-bottom:25px;margin-left: 20px;font-size: 16px;"> <?php echo $getstaffdetails['name']; ?> Invoice Report </span><br>
   <table width="100%" border="0" cellpadding="5" cellspacing="5" class="staff-table">	 
    <tbody>
		<tr class="table_cells">
			  <td><strong>Invoice Month</strong></td>
			  <td><strong>Total Amount</strong></td>
			  <td><strong>Franchisee Share</strong></td>
			   <td><strong>BBC Royalty</strong></td>
			  
			<?php  if($stafftype == 2) { ?>  
			 
			  <td><strong>BCIC Royalty</strong></td>
			  <td><strong>BCIC Managment Fee</strong></td>
			  <td><strong>BCIC Referral Fee</strong></td>
			 
			<?php  } ?>
			
			  <td><strong>Created Date</strong></td>
			  <td><strong>View</strong></td>
			  <td><strong>PDF</strong></td>
			  <td><strong>Check</strong></td>
			  
		</tr>
	<?php  if(mysql_num_rows($query) > 0) { 
	     while($data = mysql_fetch_assoc($query)) {
			 
			 $gettotalamount = mysql_fetch_assoc(mysql_query("SELECT sum(total_amount) as totalamount , sum(bcic_share) as bcic_share ,  sum(staff_share) as staff_share   FROM `staff_journal_new` WHERE staff_id=".$_GET['staff_id']." and journal_date>='".$data['invoice_from_date']."' and journal_date<='".$data['invoice_to_date']."' and job_id != 0 and staff_share > 0 order by job_date"));
			 
			 
				$bbcreyal = $gettotalamount['totalamount']/10;
				$bbcmagan = ($gettotalamount['bcic_share'] - $bbcreyal)*60/100;
				$refferalfee = ($gettotalamount['bcic_share'] - ($bbcmagan+$bbcreyal));
	?>	
			<tr class="table_cells">
			    <td><?php echo ucfirst($data['date_name']); ?> <?php echo date('Y' , strtotime($data['invoice_from_date'])); ?></td>
			    <td>$<?php echo number_format($gettotalamount['totalamount'] ,2); ?></td>
			    <td>$<?php echo number_format($gettotalamount['staff_share'] ,2); ?></td>
				 <td>$<?php echo number_format($gettotalamount['bcic_share'] ,2); ?></td>
				
			    <?php  if($stafftype == 2) { ?>  
				
					<td>$<?php echo number_format($bbcreyal ,2); ?></td>
					<td>$<?php echo number_format($bbcmagan ,2); ?></td>
					<td>$<?php echo number_format($refferalfee ,2); ?></td>
				
				<?php  } ?>
				
			   <td><?php echo $data['createdOn']; ?></td>
			   <td ><a href="javascript:showdiv('ediv<?php echo $data['id'];  ?>');">View</a></td>
			   <td ><a href="javascript:pdfdownload('<?php echo $data['id'];  ?>' , '<?php echo $data['date_name'].'_'.$data['year']; ?>');">PDF</a></td>
			   
			    <td id="show_<?php echo $data['date_name']; ?>">
			   
			        <?php if($data['invoice_send_date'] != '0000-00-00 00:00:00') { echo $data['invoice_send_date']; }else { ?>
			        
					  <input type="button"  name="sendemail" value="Send Invoice" onclick="return send_data('<?php echo $data['id']; ?>' , 406,'show_<?php echo $data['date_name']; ?>');"  />
					 
			      <?php  } ?>
			    </td>
			</tr>
			<tr>
			   <td colspan="8" id="ediv<?php echo $data['id'];  ?>" style="display:none;"><?php echo base64_decode($data['email']); ?></td>
			</tr>
			
			
		 <?php 

		 } ?>
		    
		 <?php   }else { ?>		
			<tr class="table_cells">
			   <td colspan="10">No result</td>
			   
			</tr>
			
	<?php  } ?>
    </tbody>
	</table>
	
         <script type="text/javascript">
			function pdfdownload(id, yearname)
				{
					var prtContent = document.getElementById("ediv"+id);
					var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
					WinPrint.document.write(prtContent.innerHTML);
					WinPrint.document.close();
					WinPrint.document.title = yearname+'.pdf';
					WinPrint.focus();
					WinPrint.print();
					WinPrint.close();
				}
			</script>	
  