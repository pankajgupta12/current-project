<script>

function check_press_enter(e) {
   if(e && e.keyCode == 13) {
      //document.forms[0].submit();
	  search_dispatch_report();
   }
}

function check_press_enter_quote(e) {
   if(e && e.keyCode == 13) {
      //document.forms[0].submit();
	  document.getElementById('comments_button').click();
   }
}

$(document).ready(function(){
      var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
      // $('[href$="'+url+'"]').parent().css('background-color','#00b8d4');
});

function resetfilter(backdate){
    $('#from_date').val(backdate);
    $('#to_date').val(backdate);
    $('#status').val(1);
    $('#quote_type').val(0);
    $('#called_type').val(0);
    $('#site_id').val(0);
    $('#team_id').val(0);
}

</script>
<? 
if($_SESSION['daily_dispatch']['report_from_date'] == "") {
      $_SESSION['daily_dispatch']['report_from_date'] = date('Y-m-d',strtotime('yesterday'));
    } 
	if($_SESSION['daily_dispatch']['to_date'] == "") {
      $_SESSION['daily_dispatch']['to_date'] = date('Y-m-d',strtotime('yesterday'));
    } 
if($_SESSION['daily_dispatch']['status'] == "") { $_SESSION['daily_dispatch']['status'] = 1;} 
unset($_SESSION['daily_dispatch']['site_id']);
?>

<style>
  .dispatch_top_ul li {
    width: 10%;
    float: left;
    display: inline-block;
    margin-left: 2%;
}
</style>


<div class="body_container">
	<div class="body_back body_back_disp">
    	<div class="wrapper">
            <div class="nav_form_main">
				<form name="dispatch_report" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" name="task" value="dispatch_report">
				<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
				
				    <li>
						<label>Quote  Type</label>
						<span><?php echo create_dd("quote_type","system_dd","id","name","type=68","",$_SESSION['dispatch_1']);?> </span>
					</li>
				   
					<li>
						<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php if( isset($_SESSION['daily_dispatch']['report_from_date']) && $_SESSION['daily_dispatch']['report_from_date']!= NULL  ) { echo $_SESSION['daily_dispatch']['report_from_date']; } else { echo  date('Y-m-d',strtotime('yesterday')); } ?>" >
					</li>
					<li>
						<label>To Date</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php if( isset($_SESSION['daily_dispatch']['to_date']) && $_SESSION['daily_dispatch']['to_date']!= NULL  ) { echo $_SESSION['daily_dispatch']['to_date']; } else { echo  date('Y-m-d',strtotime('yesterday')); } ?>" >
					</li>
					<li>
						<label>Called Type</label>
						<span>
						    <select name="called_type" class="formfields"  id="called_type"> 
						     <option value="1" <?php if($_SESSION['daily_dispatch']['called_type'] == 1) { echo "selected"; } ?>>Booking date</option>
							 <option value="2"<?php if($_SESSION['daily_dispatch']['called_type'] == 2) { echo "selected"; } ?>>Job Date</option>
							</select>						
						</span>
					</li>
					<li>
						<label>Status</label>
							<span>
                        <?php  echo create_dd("status","system_dd","id","name",'type=26',"",$_SESSION['daily_dispatch']); 	?>
                         </span>
					</li>
					<li>
						<label>Location</label>
						<span>
						<?php echo create_dd("site_id","sites","id","name","","", $_SESSION['daily_dispatch']);?>
						</span>
					</li>
					
					<li>
						<label>Team Type</label>
							<span>
                        <?php  echo create_dd("team_id","system_dd","id","name",'type=87',"",$_SESSION['daily_dispatch']); 	?>
                         </span>
					</li>
					
					<li>
					   <label>&nbsp;</label>
					    <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:search_daily_dashboard_report();">
					</li>
					
					<li>					
					 <label>&nbsp;</label>
				    	 <input type="reset" onclick="javascript:send_data('reset',94,'quote_view'); resetfilter('<?php echo date('Y-m-d',strtotime('yesterday')); ?>');" name="reset" value="Reset" style="cursor: pointer;" />
					</li>
					
				</ul>
				</form>
				
			</div>
  <br>  
  
			<div id="quote_view">
			<? 
			
			include("xjax/dispatch_report.php"); ?>
			</div>
</div>
</div>
</div>

<script>
  function search_daily_dashboard_report(){
	  
		  var quote_type = $('#quote_type').val();
		  var from_date =  $('#from_date').val();
		  var to_date =   $('#to_date').val();
		  var called_type =   $('#called_type').val();
		  var status =   $('#status').val();
		  var site_id =   $('#site_id').val();
		  var team_id =   $('#team_id').val();
		  
		  str = quote_type +'|'+from_date+'|'+to_date +'|'+called_type+'|'+status +'|'+site_id +'|'+team_id;
		  
		  console.log(str);
		  
		  send_data(str , 91 ,'quote_view');
	  
	  
  }
</script>