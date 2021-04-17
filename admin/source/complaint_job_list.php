<?php  

if(!isset($_SESSION['complaint_page']['from_date'])){ $_SESSION['complaint_page']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['complaint_page']['to_date'])){ $_SESSION['complaint_page']['to_date'] = date("Y-m-t"); }
 ?>
 
 <script>
        function show_notes(id,jobid) 
		{
			$('.parent_tr_'+id).find('td').css('background-color','#00b8d4');
			str = id+'|'+jobid;
			send_data(str,'596','get_notes_div');
			$('.modal').toggleClass('toggle');
			$('.black_screen1').fadeIn(700); 
		}
		
		function uncheck() 
		{
			// alert('sdsd');
			$('.user-table tbody td').css('background-color',''); 
			$( ".bc_click" ).prop( "checked" , false );
			$('.modal').removeClass('toggle');
			$('.black_screen1').fadeOut(700);
			
		}
 </script>

<div class="body_container">
              
            <div class="nav_form_main">
				<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5 ">
				    
				   
				   
					<li>
						<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['complaint_page']['from_date']; ?>" autocomplete="off">
					</li>
					<li>
						<label>To Date</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['complaint_page']['to_date']; ?>" autocomplete="off">
					</li>
					<li>
						<label>Location</label>
						<span>
						    <?php echo  create_dd("site_id","sites","id","name","","",$_SESSION['complaint_page']); ?>				
						</span>
					</li>
					
					<li>
						<label>Complaint Status</label>
						<span>
						    <?php echo  create_dd("complaint_status","system_dd","id","name","type=124","",$_SESSION['complaint_page']); ?> 		
						</span>
					</li>
					
					<li>
						<label>Complaint Type</label>
						<span>
						    <?php echo  create_dd("complaint_type","system_dd","id","name","type=125","",$_SESSION['complaint_page']); ?> 		
						</span>
					</li>
					
					<li>
					   <label>&nbsp;</label>
					    <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onClick="javascript:complaint_page_page_1();">
					</li>
					
					<li>					
					 <label>&nbsp;</label>
				    	 <input type="reset" onclick="reserefundtfiltercomplaint('<?php echo date("Y-m-1"); ?>' , '<?php echo date("Y-m-t"); ?>');" name="reset" value="Reset" style="cursor: pointer;">
					</li>
				</ul>
			</div>
	
	<!-- Trigger/Open The Modal -->
	<button id="my_heading">+ Job Complaint</button>

	<!-- The Modal -->
	<div id="popup_new" class="modal-new">

	  <!-- Modal content -->
	  <div class="modal-content">
		<span class="close">&times;</span>
		<p>Add New job Complaint</p>
		 <input type="text" name="job_id" id="job_id" value=""  placeholder="Enter job id or client name" onKeyup="getjobid(this.value);">
		   <div class="job-list" id="job_list_data" style="display:none;">
		  </div>
		  <br/>
		   <!--<span class="staff_class_drop"><select name="cleaner_name" id="cleaner_name"></select></span>-->
		   <span  id="cleaner_name" style="display:none;"></span>
           <br/>		 
           <br/>		 
		 <input type="button" name="save" id="save" onClick="SaveJobIDInComplaint();" value="Save">
	  </div>

	</div>

	
	<script>
	// Get the modal
	var modal = document.getElementById("popup_new");


	// Get the button that opens the modal
	var btn = document.getElementById("my_heading");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
	  modal.style.display = "block";
	      $('#cleaner_name').hide();
	      $('#staff_id_data').val('');
		  $('#job_id').val('');
		  $('#job_list_data').hide();
		 $('#job_list_data').html('');
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
		modal.style.display = "none";
	  }
	}
	
	
	
	function getjobid(id){
		length = id.length;
		
		if(length > 3) {
			
			var value = id;
			
			send_data(id, 598,'job_list_data');
		}
	}
	
	function get_job_details(name,status, id) {
		
		$('#job_id').val(id+' ('+name+')');
		$('#job_list_data').hide();
		$('#job_list_data').html('');
		$('#cleaner_name').show();
		
		send_data( id, 607, 'cleaner_name');
	}
	
	function SaveJobIDInComplaint(jobid){
		var jobid = $('#job_id').val();
		var staff_id_data = $('#staff_id_data').val();
		
		//alert(jobid);
		var str = jobid+'|'+staff_id_data;
		send_data(str, 599,'quote_view');
		$('#popup_new').hide();
	}
	
	function complaint_page_page_1(){
		  
		 
		 var from_date =  $('#from_date').val();
		 var to_date =  $('#to_date').val();
		 var site_id =   $('#site_id').val();
		 var complaint_status =   $('#complaint_status_').val();
		 var complaint_status =   $('#complaint_status_').val();
		  
		  var str = from_date +'|'+to_date+'|'+site_id+'|'+complaint_status;
		  
		  //alert(str);
		  
		  send_data(str,595,'quote_view');
		 
	 }
	 
	 function reserefundtfiltercomplaint(fromdate , todate){
		 
		 
			 $('#from_date').val(fromdate);
			 $('#to_date').val(todate);
			 $('#site_id').val(0);
			 $('#complaint_status_').val(0);
			 
			var str = fromdate +'|'+todate+'|0';
		  
		  send_data(str,595,'quote_view');
	 }
	</script>
	
	<div id="quote_view">
		<?php include('xjax/view_complaint_job_list.php'); ?>
	</div>
	<div id="get_notes_div" class="modal" style="width: 40%;"></div>
	
	