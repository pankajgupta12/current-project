
	<style>
	   .send_invoice_sms{
			float: right;
			margin-top: -55px;
			margin-right: 51px;
			border: 1px solid #00b8d4;
			padding: 5px;
			cursor: pointer;
			position: relative;
			font-size: 19px;
			background: #00b8d4;
			color: #fff;
		}
		
		#message_show{
			color: green;
			margin-left: 966px;
			margin-bottom: 0px;
		}
		 
	</style>

    <div id="daily_view">
	   <span class="staff_text" style="margin-bottom:25px;"> Invoice Report </span><br>
	
		<span id="message_show"></span>
		<?php  
		  
		  $arg = "SELECT DISTINCT(staff_id) as staffid FROM `bcic_invoice`"; 
		  $sql = mysql_query($arg);
		  
		?>
	  
	<table width="100%" border="0" cellpadding="5" cellspacing="5" class="staff-table">	 
		<tbody>
			<tr class="table_cells">
				  <td><strong>ID</strong></td>
				  <td><strong>Staff name</strong></td>
				  <td><strong>Email</strong></td>
				  <td><strong>Mobile</strong></td>
				  <td><strong>Status</strong></td>
				  <td><strong>Staff type</strong></td>
				  <td><strong>View</strong></td>
			</tr>
			<?php  
			if(mysql_num_rows($sql) > 0) { 
				 while($data = mysql_fetch_assoc($sql)) {
					 
					  $getstaffdata = mysql_fetch_assoc(mysql_query("SELECT name ,status , mobile ,better_franchisee, email FROM `staff` where id = ".$data['staffid']."")); 
					
			?>	
				<tr class="table_cells" <?php if($getstaffdata['status'] == 0) { echo 'style="background-color:#cab3b3;"';} ?> >
				   <td><?php echo $data['staffid']; ?></td>
				   <td><?php echo $getstaffdata['name']; ?></td>
				   <td><?php echo $getstaffdata['email']; ?></td>
				   <td><?php echo $getstaffdata['mobile']; ?></td>
				   <td><?php echo getSystemvalueByID($getstaffdata['status'],1); ?></td>
				   <td><?php echo get_rs_value('quote_for_option' , 'name' , $getstaffdata['better_franchisee']); ?></td>
				   <td><a href="javascript:scrollWindow('show_invoice_popup.php?task=invoice_list&year=<?php echo date('Y'); ?>&staff_id=<?php echo $data['staffid']; ?>','1200','850')">View</a></td>
				   <!--<td><input type="checkbox" class="checkedstaff" name="staff_id" style="width: 30px;" value="<?php echo $data['id']; ?>"></td>-->
				</tr>
			 <?php  } }else { ?>		
				<tr class="table_cells">
				   <td colspan="10">No result</td>
				   
				</tr>
				
		<?php  } ?>
		</tbody></table>
	</div>
	
	<script>
	    function check_checkbox(from_date , todate){			
            var staff_check = [];
            $.each($("input[name='staff_id']:checked"), function(){            
                staff_check.push($(this).val());
            });
			var string = staff_check.join(",");
			if(string == '') {
				alert('Checked at least one staff');
				return false;
			}
			
			var str = string+'|'+from_date+'|'+todate;
			
			send_data(str , 403 , 'message_show');
           // alert("My favourite sports are: " + staff_check.join(", "));
		}
	</script>
	