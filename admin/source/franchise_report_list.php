    <?php  
 
	  
	 $query = mysql_query("SELECT * FROM `franchise_report`  WHERE year = '".$_GET['year']."' AND staff_id = ".$_GET['staff_id']." Order by invoice_from_date asc");
	 
	   $getstaffdetails = mysql_fetch_assoc(mysql_query("select * from staff where id = ".$_GET['staff_id']." AND status = 1")); 	
	 
	  $stafftype = $getstaffdetails['better_franchisee'];	
	 
    ?>
	  <span class="staff_text" style="margin-bottom:25px;margin-left: 20px;font-size: 16px;"> <?php echo $getstaffdetails['name']; ?> Invoice Report </span><br>
   <table width="100%" border="0" cellpadding="5" cellspacing="5" class="staff-table">	 
    <tbody>
		<tr class="table_cells">
			  <td><strong>Invoice Month</strong></td>
			  <td><strong>View</strong></td>
			  <td><strong>Send Email</strong></td>
			  <td><strong>PDF</strong></td>
			  
		</tr>
	<?php  if(mysql_num_rows($query) > 0) { 
	     while($data = mysql_fetch_assoc($query)) {
			 
			 
	?>	
			<tr class="table_cells">
			    <td><?php echo ucfirst($data['date_name']); ?> <?php echo date('Y' , strtotime($data['invoice_from_date'])); ?></td>
			    
			  
			   <td ><a href="javascript:showdiv('ediv<?php echo $data['id'];  ?>');">View</a></td>
			   <td id="email_date_<?php echo $data['id'] ?>"><?php   if($data['invoice_send_date'] != '0000-00-00 00:00:00') { echo  $data['invoice_send_date'];  } else { ?><a href="javascript:send_data('<?php echo $data['id'];  ?>|<?php echo $data['staff_id']; ?>' , '541' , 'email_date_<?php echo $data['id'] ?>');">Send Email</a> <?php  } ?></td>
			   <td ><a href="javascript:pdfdownload('<?php echo $data['id'];  ?>' , '<?php echo $data['date_name'].'_'.$data['year']; ?>');">PDF</a></td>
			   
			   
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
			<style>
					.staff-table thead {
						background: #f2f2f2;
						color: #fff;
					}
</style>
  