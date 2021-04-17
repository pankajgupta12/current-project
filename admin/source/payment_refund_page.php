<?php  

if(!isset($_SESSION['payment_refund_page']['from_date'])){ $_SESSION['payment_refund_page']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['payment_refund_page']['to_date'])){ $_SESSION['payment_refund_page']['to_date'] = date("Y-m-t"); }
 ?>

<div class="body_container">
            <form action='../admin/index.php?task=refund_page_export' method="POST">    
              
            <div class="nav_form_main">
				<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5 ">
				    
				   
				   
					<li>
						<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['payment_refund_page']['from_date']; ?>" autocomplete="off">
					</li>
					<li>
						<label>To Date</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['payment_refund_page']['to_date']; ?>" autocomplete="off">
					</li>
					<li>
						<label>Location</label>
						<span>
						    <?php echo  create_dd("site_id","sites","id","name","","",$_SESSION['payment_refund_page']); ?>				
						</span>
					</li>
					<li>
					   <label>&nbsp;</label>
					    <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:payment_refund_page();">
					</li>
					
					<li>					
					 <label>&nbsp;</label>
				    	 <input type="reset" onclick="reserefundtfilter('<?php echo date("Y-m-1"); ?>' , '<?php echo date("Y-m-t"); ?>');" name="reset" value="Reset" style="cursor: pointer;">
					</li>
				<?php if(in_array($_SESSION['admin'] , array(1,3,17))) { ?>	
					
					<li style="margin-top: 28px;">
					   <label>&nbsp;</label>
					    <input type="submit" name="" value="Export" class="offsetZero btnSent a_search_box" onclick="javascript:export_refund_data();">
					</li>
				<?php  } ?>	
				</ul>
			</div>
	
	<div id="quote_view">
		<?php
			include('xjax/view_refund_page.php' );
		?>
	</div>
	</form>
<script>
	 
	 function payment_refund_page(){
		  
		 
		 var from_date =  $('#from_date').val();
		 var to_date =  $('#to_date').val();
		 var site_id =   $('#site_id').val();
		  
		  var str = from_date +'|'+to_date+'|'+site_id;
		  
		  send_data(str,585,'quote_view');
		 
	 }
	 
	 function reserefundtfilter(fromdate , todate){
		 
		 
			 $('#from_date').val(fromdate);
			 $('#to_date').val(todate);
			 $('#site_id').val(0);
			 
			var str = fromdate +'|'+todate+'|0';
		  
		  send_data(str,585,'quote_view');
	 }
	 
</script>	