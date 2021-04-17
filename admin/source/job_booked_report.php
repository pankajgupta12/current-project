 <br/>  <br/>
<?php  
 if(!isset($_SESSION['job_booked_report']['from_date'])){ $_SESSION['job_booked_report']['from_date'] = date('Y-m-d' , strtotime('-1 day')); }
  if(!isset($_SESSION['job_booked_report']['to_date'])){ $_SESSION['job_booked_report']['to_date'] = date('Y-m-d'); }
    if(!isset($_SESSION['job_booked_report']['login_id'])){ $_SESSION['job_booked_report']['login_id'] = 0; }

 
 $cdate = date('Y-m-d' , strtotime('-1 day'));
 $tdate = date('Y-m-d');

 ?>
<div class="body_container">
              
            <div class="nav_form_main">
				<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
					<li>
						<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['job_booked_report']['from_date']; ?>" autocomplete="off">
					</li>
					
					<li>
						<label>TO date</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['job_booked_report']['to_date']; ?>" autocomplete="off">
					</li>
					
					<li>
						<label>Admin Name</label>
						<span><?php 	echo  create_dd("login_id","admin","id","name","is_call_allow = 1 AND status = 1","",$_SESSION['job_booked_report']); ?></span>
					</li>
				
					<li>
					   <label>&nbsp;</label>
					    <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="search_bookedJobs(1);">
					</li>
					
					
					<li>
					   <label>&nbsp;</label>
					    <input type="button" name="" value="Reset" class="offsetZero btnSent a_search_box" onclick="search_reset('<?php  echo $cdate; ?>','<?php  echo $tdate; ?>' );">
					</li>
					
				</ul>
			</div>
                 
	<div>
		
	</div>
	<div id="quote_view">
		<?php
			include('xjax/view_job_booked_report.php');
		?>
	</div>
	
<script>

	   function search_bookedJobs(id){
	       
            var from_date =  $('#from_date').val();
            var to_date =  $('#to_date').val();
            var login_id =  $('#login_id').val();
    		 var str = from_date+'|'+to_date+'|'+login_id;
    		 send_data(str , 640, 'quote_view');
	  }
	  
	  function search_reset(fromdate, todate){
	      
                $('#from_date').val(fromdate);
                $('#to_date').val(todate);
                $('#login_id').val(0);
                
        	 var str = fromdate+'|'+todate+'|0';        
	      send_data(str , 640, 'quote_view');
	  }
	  
	function checkCall(id){
	      //alert(id); 
	        if($('#checkadmin_'+id).prop("checked") == true){
                //console.log("Checkbox is checked.");
                str1 = 1;
            }else if($('#checkadmin_'+id).is(":not(:checked)")){
                 str1 = 0;
            }
            
            var str = str1+'|'+id;
            
           // alert(str);
          send_data(str , 641, 'checkadmin_'+id);
	}
	  
</script>	