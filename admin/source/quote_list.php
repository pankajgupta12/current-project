<?php  
	$adminid = $_REQUEST['adminid'];
	$fromdate = $_REQUEST['fromdate'];
	$to_date = $_REQUEST['to_date'];
   $adminname = getadminnamedata();
   
   
  // if($_SESSION['quote_sales_list']['from_date'] != '') {echo $_SESSION['quote_sales_list']['from_date'];}
 ?>
 
    <script>
	   
	    function a_search_quote_list(adminid){
			quotetype =  $('#tasktype').val();
			from_date =  $('#from_date').val();
			to_date =  $('#to_date').val();
			quote_type =  $('#quote_type').val();
			adminid =  adminid;
			
			var str = quotetype +'|'+from_date+'|'+to_date+'|'+adminid+'|'+quote_type;
			//alert(str);
			send_data(str , 580 , 'quote_view');
		}
		
		function a_rest_sales_quote_list(fromdate , todate , adminid)
		{
			 $('#tasktype').val(0);
			 $('#from_date').val(fromdate);
			$('#to_date').val(todate);
			$('#quote_type').val(0);
			adminid =  adminid;
			
			var str = '0|'+fromdate+'|'+todate+'|'+adminid+'|0';
			
			send_data(str , 580 , 'quote_view');
		}
	  
	</script>
   <span><h3>Admin Name <?php echo $adminname[$adminid]; ?> <br/> Quote From <?php  echo $fromdate;  ?> To  <?php  echo $to_date;  ?></h3></span>
  
	<div id="search_filter">		  
			    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
	                <li>
						<strong>Task Type</strong>
						<span>
						<?php echo create_dd("tasktype","system_dd","id","name","type = 104","", $_SESSION['quote_sales_list']);	?>
						</span>
					</li>
					<li><strong>From date</strong>
							<input class="date_class" type="text"  placeholder="From date" name="from_date" id="from_date" value="<?php if($_SESSION['quote_sales_list']['from_date'] != '') {echo $_SESSION['quote_sales_list']['from_date'];}else { echo  $fromdate; }  ?>" >
					</li>
						
						
					<li><strong>To date</strong>
							<input class="date_class" type="text"  placeholder="To date" name="to_date" id="to_date" value="<?php if($_SESSION['quote_sales_list']['to_date'] != '') {echo $_SESSION['quote_sales_list']['to_date'];}else { echo  $to_date; }  ?>" >
					</li>
					
					<li><strong>Quote Type</strong>
							<span><select name="quote_type" id="quote_type">
							    
								 <option value="0">Select</option>
								 <option value="1">Cleaning</option>
								 <option value="2">Removal</option>
							    
							</select></span>
					</li>

                    <li style="margin-top: 28px;">
						<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onClick="javascript:a_search_quote_list('<?php echo $adminid; ?>');">	
					</li>
						
					<li style="margin-top: 28px;">
							<input type="button" name="reset" value="Reset"  onClick="a_rest_sales_quote_list('<?php echo $fromdate; ?>' , '<?php echo $to_date; ?>' , '<?php echo $adminid; ?>');" class="offsetZero btnSet a_search_box" >	
					</li>						
	      
                </ul>
						
	</div>					
	
	<BR/>
	    <ul class="admin_list">
		   <li><a onClick="moveQuote('0' , 'EveryOne');">Share To EveryOne</a></li>
		   
		            <li>
						<strong>Assign To</strong>
						<span><?php echo create_dd("admin_id","admin","id","name","status = 1 AND is_call_allow = 1 AND id != ".$adminid."","onChange=\"javascript:moveQuote(this.value,'1');\"", $_SESSION['quote_sales_list']);	?></span>
					</li>
		   <?php  /* foreach($adminname as $key=>$aid) {  if($adminid != $key) {

            $auto_role =  get_rs_value("admin","auto_role",$key);
		   ?>
			<li > <a onClick="moveQuote('<?php echo $key; ?>' , '<?php echo $adminname[$adminid]; ?>');" <?php if($auto_role == 1) { ?> style="background: #e52315;" <?php } ?> ><?php echo $aid; ?></a></li>
		   <?php  }  }  */?>
	    </ul>
  <br/>
	
	 <div id="quote_view">
	  <? 
	  unset($_SESSION['quote_sales_list']);
	  $_SESSION['quote_sales_list']['tasktype'] = 0;
	  
	  include("xjax/view_quote_list.php"); 
	  ?>
    </div>
	
	