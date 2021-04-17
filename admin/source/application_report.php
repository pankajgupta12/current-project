<?php
/* if($_SESSION['application']['quote_for'] == 3) {
  $job_type = 'id = 11';	
 } else{
  $job_type = '';		
} */

$jobtypenotin = 'id not in (8,9,10,13)';

unset($_SESSION['application_report_action']); 
unset($_SESSION['application']); 
?>

 

 <div class="view_quote_back_box">
  
    <ul class="bb_4tabs application_tabs">
		<li><a href="/admin/index.php?task=application_report">All</a></li>
		<li><a href="/admin/index.php?task=application_report&action=1">New</a></li>
		<li><a href="/admin/index.php?task=application_report&action=2">Waiting Docs</a></li>
		<li><a href="/admin/index.php?task=application_report&action=3">Docs Received </a></li>
		<li><a href="/admin/index.php?task=application_report&action=4">Waiting Approval</a></li>
		<li><a href="/admin/index.php?task=application_report&action=5">Approved</a></li>
		<li><a href="/admin/index.php?task=application_report&action=6">Denied</a></li>
		<li><a href="/admin/index.php?task=application_report&action=7">Delete</a></li>
		<li><a href="/admin/index.php?task=hr_sms"><span class="hr_sms_notification chat_sms_notification hr_sms_notify" id="hr_sms_notify" style="display:none;"></span>Sms</a></li>
    </ul>
	    
		   
			
			<ul class="dispatch_top_ul application_report_search"> 				
				<li>
					<label>Location</label>
					<span>
					 <?php echo create_dd("site_id","sites","id","name","","", $_SESSION['application']);?>
					</span>
				</li>

				<li><label>Search</label>
				   <input class="search_field" type="text" placeholder="Search" name="search_value" id="search_value" value="">
				</li>
				
				<li><label>Reference</label>
				   <span><?php echo create_dd("application_reference","system_dd","id","name","type=56","", $_SESSION['application']);?></span>
				</li>
				
				<li><label>S/US Status</label>
				    <span><?php echo create_dd("sutab_unsutab","system_dd","id","name","type=38","",$_SESSION['application']);?> </span>
				</li>
				
				<li><label>Resp</label>
				    <span>
					  <?php echo create_dd("response_status","system_dd","id","name","type=71","", $_SESSION['application']);?>
					</span>
				</li>

				<li>
				<label>&nbsp;</label>
				  <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onClick="application_search('submit');" >	
				</li>

				<li>
				  <label>&nbsp;</label>
				    <input type="reset" name="reset" value="Reset" class="offsetZero btnSet a_search_box1"  onClick="application_search('reset');">	
				</li>
			</ul>
			
          <a href="index.php?task=add_application" class="applic-btn"><i class="fa fa-plus" aria-hidden="true"></i>Add Application</a>
		&nbsp;&nbsp;&nbsp;
		 
		    
		
         <a onClick="showHRNotification();" class="applic-btn"><i class="fa fa-bell" aria-hidden="true"></i>Show Notification</a>
		 
			<ul class="dispatch_top_ul application_report_search"> 		
				<li>
			<label>Job type</label>
			<span>
			<?php //echo create_dd("job_type","system_dd","id","name","type=68","Onchange=\"application_job_type(this.value);\"",$_SESSION['application']);?> 
			<?php echo create_dd("job_type","job_type","id","name",$jobtypenotin,"Onchange=\"application_job_type(this.value);\"",$_SESSION['application']);?> 			
			</span>
		</li>
	</ul>

<script> 
     $(document).ready(function(){
          var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
            $('[href$="'+url+'"]').parent().css('background-color','#00b8d4');
    });
    
    
     $(document).ready(function(e)
{
    /*  var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
        $('.heading_view_quote [href$="'+url+'"]').parent().css('background-color','#00b8d4');*/
        
	var global_pick_id = null;
	
	$('body').on('click','td.bc_click_btn',function(e)
	{
		
		 //console.log($(this).closest('tr').find('td')); 
		 
		$(this).closest('tr').find('td').css('background-color','#00b8d4');
		
		if($(this).closest('tr.parent_tr').find('td.pick_row').hasClass('pick_row')){ 
			//global_pick_id = $(this).closest('tr.parent_tr').find('td.pick_row').html();
			
			global_pick_id = $(this).closest('tr.parent_tr').attr('id');
			
			$('.modal').html();			
			// alert(global_pick_id);
			 
			send_data(global_pick_id,'632','myModal');
			$('.modal').toggleClass('toggle');
			$('.black_screen1').fadeIn(700);
		}else{
		} 
		//console.log( 'Clicked : ' , global_pick_id );	
	});
	$('.black_screen1').click(function(e)
	{
		$('.modal').removeClass('toggle');
        $('.black_screen1').fadeOut(700);

    });
});
    
	
	 function showHRNotification(){
	   //$('.parent_tr_'+type+'_'+id).find('td').css('background-color','#00b8d4');
			//str = id+'|'+type;
			send_data('','557','myModal');
			$('.modal').toggleClass('toggle');
			$('.black_screen1').fadeIn(700); 
	 } 
	
	

	   $(document).ready(function(e){
	    $('.black_screen1').click(function(e)
		{
			$('.modal').removeClass('toggle');
			$('.black_screen1').fadeOut(700);

		});
	   });
	
</script>

<div id="application_view">
<? 
if(isset($_GET['action'])){ $_SESSION['application_report_action'] = mres($_GET['action']); }
include("xjax/application_report.php"); ?>
</div>

<div id="myModal"  style="width: 22%;" class="modal">
   
</div>

<script type="text/javascript">
	 getHrSmsNotification();
	
	  function getHrSmsNotification(){
	    var para = "q_id=1";
			 var url = location.protocol + "//" + location.hostname + "/admin/xjax/ajax/get_hr_notification.php";
			$.ajax({
				type: "POST",
				url: url,
				data: para,
				dataType : 'html',
				success: function(res) {					
					if(parseInt(res) == 0 ){
						$('#hr_sms_notify').hide();
					}else if(parseInt(res) > 0){
					    $('#hr_sms_notify').html(res);
						$('#hr_sms_notify').show();
					}
					
					setTimeout(function(){ getHrSmsNotification(); }, 8000);	
					
				}
			}); 
	    }
	
	
</script>
	