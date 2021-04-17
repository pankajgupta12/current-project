<div class="black_screen1"></div>
<div class="view_quote_back_box">
    <?php 
	 unset($_SESSION['status_action']);
    ?>
    
    <div class="">
		<span class="add_jobs_text">Job UnAssigned</span>        
	</div>
<script>	
 $(document).ready(function(){
      var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
        $('.heading_view_quote [href$="'+url+'"]').parent().css('background-color','#00b8d4');
});

		$(document).ready(function(e)
		{	
			 $('.black_screen1').click(function(e)
			{
				$('#quote_div3').removeClass('toggle');
				$('#get_panel').removeClass('parentDisable');
				$('.black_screen1').fadeOut(700);		
			});  
		});

</script>	

    <ul class="bb_4tabs heading_view_quote">
          <li><a href="/admin/index.php?task=job_unassigned">Unassigned </a></li>
          <li><a href="/admin/index.php?task=job_unassigned&action=6">Removal Unassigned </a></li>
          <li><a href="/admin/index.php?task=job_unassigned&action=1">Waiting </a></li>
          <li><a href="/admin/index.php?task=job_unassigned&action=2">Accepted </a></li>
          <li><a href="/admin/index.php?task=job_unassigned&action=3">Denied</a></li>
          <li><a href="/admin/index.php?task=job_unassigned&action=4">Re-Assign</a></li>
          <li><a href="/admin/index.php?task=job_unassigned&action=5">Re-Clean</a></li>
    </ul>
	                
					
					<ul class="unassignedsearch dispatch_top_ul dispatch_top_ul2 dispatch5" style="float: right;width: 61%;position: relative;top: -70px;margin-right: -15px;">
					  
					    <li>
							<strong>Job ID</strong>
							<input class="job_id" type="text"  placeholder="Enter job id" name="job_id" id="job_id" value="<?php if($_SESSION['view_unassigned']['job_id'] != '') {echo $_SESSION['view_unassigned']['job_id'];} ?>" >
						</li>
						
						<li>
							<strong>Location</strong>
							<span>
							<?php echo create_dd("site_id","sites","id","name","","", $_SESSION['view_unassigned']);?>
							</span>
						</li>
						
						
						<li><strong>Job date From</strong>
							<input class="date_class" type="text"  placeholder="From date" name="booking_date" id="from_date" value="<?php if($_SESSION['view_unassigned']['booking_date'] != '') {echo $_SESSION['view_unassigned']['booking_date'];} ?>" >
						</li>
						
						<li><strong>Job date To</strong>
							<input class="date_class" type="text"  placeholder="To date" name="booking_to" id="from_to" value="<?php if($_SESSION['view_unassigned']['booking_to'] != '') {echo $_SESSION['view_unassigned']['booking_to'];} ?>" >
						</li>
						
						
						<li>
							<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box_one" onclick="javascript:search_unassigned();">	
						</li>
						
						<li>
							<input type="button" name="reset" value="Reset" onclick="unassigned_reset();" class="offsetZero btnSet a_search_box_two">	
						</li>
					</ul>
					
		    <ul class="dispatch_top_ul my-select">
			   <li><span><?php echo create_dd("job_type_id","system_dd","id","name","type=68","Onchange=\"send_data(this.value , 507 , 'job_unassinged');\"",$_SESSION['view_unassigned']);?> </span></li>   
			</ul>			
	
<div id="job_unassinged">
<? 
if(isset($_GET['action'])){ $_SESSION['status_action'] = mres($_GET['action']); }
include("xjax/job_unassinged.php"); ?>
</div>
   
                <script>
					$(function() {
						$("#from_date").datepicker({dateFormat:'yy-mm-dd'});
						$("#from_to").datepicker({dateFormat:'yy-mm-dd'});			   
					}); 
				</script>

<style rel="stylesheet" type="text/css">

.a_search_box_one { 
	background-color: #00b8d4!important;
    color: #fff!important;
    margin-top: 25px!important;
	border:none!important;
	    cursor: pointer;


}
.a_search_box_two { 
	margin-top: 25px!important;
	    cursor: pointer;

}

</style>