      <table class="start_table_tabe3">
        <thead>
          <tr>
            <th>Amount</th>
            <th>Transaction ID</th>
            <th>Fault Status</th>
            <th>Cleaner Name</th>
            <th>Comments</th>
            <th></th>
            <!--<th></th>-->
          </tr>
        </thead>
        <tbody>
         <tr>
         
           <td><input name="refund_amount" type="text" id="refund_amount" onkeypress="return isNumberKey(event)" placeholder="Amount" /></td>
		    <td><input name="transaction_id" type="text" id="transaction_id"  placeholder="Transaction ID" /></td>
           <td> <span class="left_drop_down" style="width:90%"> <span style="width:90%"><?php echo create_dd("fault_status","system_dd","id","name","type=97","",'');?>  </span>  </span> </td>
            <td> <span class="left_drop_down" style="width:90%"> 
				<span style="width:90%">
				  <?php 
					   echo create_dd_staff("cleaner_name","staff","id","name","  id  in (SELECT staff_id FROM `job_details` WHERE job_id=".$job_id." AND status != 2)","",""); 
				   ?>  
				</span>  </span>
			</td>
		   <td><textarea name="refund_comments" id="refund_comments" style="margin: 0px; width: 415px; height: 76px;" class="textarea_box_notes" placeholder="Please enter refund notes"></textarea></td>
          <td><input type="button" name="submit_button" id="submit_button" value="Payment Refund" onclick="javascript:add_refund_amount('<?php echo $job_id;?>');" /></td>
		  <!--<td><a onclick="showList();" style="cursor: pointer;"> View  List</a></td>-->
        </tr>
		
		<tr><td colspan="15" id="refund_list_data">
		 <?php include('view_refund_amount.php'); ?>
		</td></tr>
        </tbody>
		
		
		
      </table>
	  
	 <script>
	 
	    function showList(){
		  $('#refund_list_data').toggle();
	    }
			function add_refund_amount(job_id){
			  
				var refund_amount =  $('#refund_amount').val();
				var fault_status =  $('#fault_status').val();
				var refund_comments =  $('#refund_comments').val();
				var transaction_id =  $('#transaction_id').val();
				var cleaner_name =  $('#cleaner_name').val();
				if (isNaN(refund_amount) || refund_amount < 1 || refund_amount == '' || refund_amount == null || refund_amount == undefined) {
					  alert('Please enter valid  amount');
					  document.getElementById("refund_amount").value = '';
						return false;						  
				}
				else if(transaction_id == ''){
						alert('Please Enter valid Transaction ID ');
						return false;						
				}
				else if(fault_status == ''){
						alert('Please Select Fault Status ');
						return false;						
				}
				else if(refund_comments == ''){
						alert('Please enter comments ');
						return false;						
				}else {
							 var refund_comments =  $('#refund_comments').val();
							 refund_comments =  refund_comments.replace("&", "#39;");
							 var str = refund_amount+'|'+refund_comments+'|'+job_id+'|'+fault_status+'|'+transaction_id+'|'+cleaner_name;
							// alert(str);
							 $('#refund_list_data').show();
							send_data(str , 544 , 'refund_list_data');
							$('#refund_amount').val('');
							$('#refund_comments').val('');
					}
			}
	 </script> 