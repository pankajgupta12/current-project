    <?php  
 
	  
	 $query = mysql_query("SELECT * FROM `franchise_report`  WHERE year = '".$_GET['year']."' AND staff_id = ".$_GET['staff_id']." Order by invoice_from_date asc");
	 
	   $getstaffdetails = mysql_fetch_assoc(mysql_query("select * from staff where id = ".$_GET['staff_id']." AND status = 1")); 	
	 
	  $stafftype = $getstaffdetails['better_franchisee'];	
	 
    ?>
	  <span class="staff_text" style="margin-bottom:25px;margin-left: 20px;font-size: 16px;"> <?php echo $getstaffdetails['name']; ?> Invoice Report </span><br>
   <table width="100%" border="1" cellpadding="5" cellspacing="5" >	 
   	<tr >
            	    <tr>
            			<td>Month</td>            			<td>Total Jobs Offered</td>
            			<td>Total Jobs Done</td>
            			<td>Job Share</td>
            			<td>Denied Jobs</td>
            			<td>Denied jobs Amount </td>
            			<td>Days not available</td>
            			<td>YTD days not available</td>
            			<td>Recleans Offered</td>
            			<td>Reclean %</td>
            			<td>Failed Recleans</td>
            			<td>YTD Reclean %</td>
                    </tr>

		</tr>
	<?php  if(mysql_num_rows($query) > 0) { 
	     while($data = mysql_fetch_assoc($query)) {
        $alldata = explode('__' , base64_decode($data['report_details'])); 				?>
		<tr>			<td style="text-align:center;"><?php echo ucfirst($data['date_name']); ?></td>			<td style="text-align:center;"><?php echo $alldata[0]; ?></td>			<td style="text-align:center;"><?php echo $alldata[1]; ?></td>			<td style="text-align:center;"><?php echo $alldata[2]; ?></td>			<td style="text-align:center;"><?php echo $alldata[3]; ?></td>			<td style="text-align:center;"><?php echo $alldata[4]; ?></td>			<td style="text-align:center;"><?php echo $alldata[5]; ?></td>			<td style="text-align:center;"><?php echo $alldata[6]; ?></td>			<td style="text-align:center;"><?php echo $alldata[7]; ?></td>			<td style="text-align:center;"><?php echo $alldata[8]; ?></td>			<td style="text-align:center;"><?php echo $alldata[9]; ?></td>			<td style="text-align:center;"><?php echo $alldata[10]; ?></td>        </tr>
		 <?php 
unset($alldata);
		 } ?>
		 <?php   }else { ?>		
			<tr class="table_cells">
			   <td colspan="10">No result</td>
			   
			</tr>
			
	<?php  } ?>
    </tbody>
	</table>
	<style>
			.staff-table thead {
				background: #f2f2f2;
				color: #fff;
			}
    </style>
  