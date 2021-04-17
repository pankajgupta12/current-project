<script>
$(document).ready(function(e)
{
	var global_pick_id = null;
	
	$('body').on('click','td.bc_click_btn',function(e)
	{
		
		$(this).closest('tr').find('td').css('background-color','#00b8d4');
		
		if($(this).closest('tr.parent_tr').find('td.pick_row').hasClass('pick_row')){ 
			global_pick_id = $(this).closest('tr.parent_tr').find('td.pick_row').html();
			$('.modal').html();			
			 //alert(global_pick_id);
			 
			send_data(global_pick_id,'53','myModal');
			$('.modal').toggleClass('toggle');
			$('.black_screen1').fadeIn(700);
		}else{
		} 
		console.log( 'Clicked : ' , global_pick_id );	
	});
	$('.black_screen1').click(function(e)
	{
		$('.modal').removeClass('toggle');
        $('.black_screen1').fadeOut(700);

    });
});


function check_press_enter(e) {
   if(e && e.keyCode == 13) {
      //document.forms[0].submit();
	  search_view_quote();
   }
}



$(document).ready(function(){
      var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
        $('.heading_view_quote [href$="'+url+'"]').parent().css('background-color','#00b8d4');
});

function show_filter(){
	 $("#search_filter").toggle(1500);
}
 
</script>
<? 
 if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }Else If(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); }
 
unset($_SESSION['view_quote_field'],$_SESSION['view_quote_keyword'],$_SESSION['view_quote_action'] , $_SESSION['view_quote_aSearching_job_type']);
?>

 <div class="view_quote_back_box">
	<div class="topbBarItems">
     <ul class="bb_4tabs heading_view_quote">
          <li><a href="/admin/index.php?task=staff_view_quote">All</a></li>
          <li><a href="/admin/index.php?task=staff_view_quote&action=1">No Info</a></li>
          <li><a href="/admin/index.php?task=staff_view_quote&action=2">Info</a></li>
          <li><a href="/admin/index.php?task=staff_view_quote&action=4">A-Approved</a></li>
          <li><a href="/admin/index.php?task=staff_view_quote&action=9">C-Approved</a></li>
          <li><a href="/admin/index.php?task=staff_view_quote&action=3">Booked</a></li>
          <li><a href="/admin/index.php?task=staff_view_quote&action=5">C-Denied</a></li> 
		  <li><a href="/admin/index.php?task=staff_view_quote&action=6">A-Denied</a></li> 
		  <li><a href="/admin/index.php?task=staff_view_quote&action=7">My Quote</a></li> 
		  <li><a href="/admin/index.php?task=staff_view_quote&action=8">Delete Quote</a></li> 
    </ul>
	<div class="rightSideBox" >
		<ul class="view_quote">  
		      
			  
					
		    
			<li id="search_box_div">
			
				<input name="view_quote_search" type="text" class="search_field" id="view_quote_search" placeholder="Search" onkeypress="return check_press_enter(event);">  
				
				<input name="booking_date" type="text" class="date_class  search_field" id="booking_date" placeholder="Booking date" style="display:none;" onchange="get_booking_date(this.value,'booking_date');a_reset(2);"/>  
				
				<input name="quote_date" type="text" class="date_class  search_field" id="quote_date" placeholder="Quote Date" style="display:none;" onchange="get_booking_date(this.value,'quote_date');a_reset(2);"/>  
				
				<input type="button" name="" value="" class="search_box" onClick="javascript:search_view_quote();a_reset(2);">	
			</li>   
		  
			<li id="show_statusdiv" style="display:none;">
				<span>
				 <?php echo create_dd("view_quote_search","system_dd","id","name","type=31","Onchange=\"search_view_quote_status(this.value);\"","");?>   
				</span>
			</li>
					
			
			<li>
				<span>
				 <?php echo create_dd("view_qute_field","system_dd","name","name","type=32","onchange=\"showstatusdiv(this.value);\"","");?>    
				</span>	
			</li>    
		</ul>

	<!--<span class="adSearch" Onclick="show_filter();"><a href="#" class="advance_search">Advance Search</a></span>-->
	</div>
	</div>

	
			<div id="search_filter">		  
					<ul class="menuListingArea dispatch_top_ul dispatch_top_ul_viewquote dispatch5" style="background: rgba(17, 19, 19, 0.1);">
					   
					    <li>
							<strong>Quote For</strong>
							<span>
							<?php echo create_dd("quote_for","quote_for_option","id","name","status = 1","", $_SESSION['view_quote_aSearching'] ,'quote_a');	?>
							</span>
						</li>
						<!--<input class="search_field"  type="hidden"  id="quote_for" value="">-->
						<input class="search_field"  type="hidden"  id="page_type" value="2">
						
					
						<li>
							<strong>Location</strong>
							<span>
							<?php echo create_dd("site_id","sites","id","name","","", $_SESSION['view_quote_aSearching']);?>
							</span>
						</li>
						
						<li><strong>RE</strong>
							<input class="" type="text"  style="margin-top: 0px;" placeholder="RE Name" name="real_estate_id" id="real_estate_id" onKeyup="javascript:get_real_estate_name(this)" autocomplete="off" value="<?php if($_SESSION['view_quote_aSearching']['real_estate_id'] != '') { echo get_rs_value("real_estate_agent","name",$_SESSION['view_quote_aSearching']['real_estate_id']); } ?>" >
							<div class="clear"></div>
							<div id="real_estate_name_div" style="left: 186px;width: 250px;top: 74px;display:none;"></div>
						</li>
						
						<li>
							<strong>Reference</strong>
							<span>
							<?php echo create_dd("job_ref","system_dd","name","name","type=28","",$_SESSION['view_quote_aSearching']);?>
							</span>
						</li>
						
						<li><strong>Quote Type</strong>
							<span>
							    <?php echo create_dd("quote_type","system_dd","id","name","type=63","",$_SESSION['view_quote_aSearching']);?>
							</span>
						</li>
						
						<li><strong>From date</strong>
							<input class="date_class" type="text"  placeholder="From date" name="from_date" id="from_date" value="<?php if($_SESSION['view_quote_aSearching']['from_date'] != '') {echo $_SESSION['view_quote_aSearching']['from_date'];} ?>" >
						</li>
						
						
						<li><strong>To date</strong>
							<input class="date_class" type="text"  placeholder="To date" name="to_date" id="to_date" value="<?php if($_SESSION['view_quote_aSearching']['to_date'] != '') {echo $_SESSION['view_quote_aSearching']['to_date'];} ?>" >
						</li>
						
						
						
					
						<input class="search_field"  type="hidden" placeholder="Amount" name="amount" id="amount" value="<?php if($_SESSION['view_quote_aSearching']['amount'] != '') {echo $_SESSION['view_quote_aSearching']['amount'];} ?>">
					
						<li><strong>1st call</strong>
							<span><?php echo create_dd("called_date","system_dd","id","name","type=44","",$_SESSION['view_quote_aSearching']);?></span>   
						</li>
						
						<li><strong>2nd call</strong>
							<span><?php echo create_dd("second_called_date","system_dd","id","name","type=44","",$_SESSION['view_quote_aSearching']);?></span>   
						</li>
						
						<li><strong>3rd call</strong>
							<span><?php echo create_dd("seven_called_date","system_dd","id","name","type=44","",$_SESSION['view_quote_aSearching']);?></span>   
						</li>
						
						<li><strong>Response</strong>
							<span><?php echo create_dd("response","system_dd","id","name","type=33","",$_SESSION['view_quote_aSearching']);?></span>
						</li>
						
						<li><strong>Status</strong>
							<span><?php echo create_dd("step","system_dd","id","name","type=31","",$_SESSION['view_quote_aSearching']);?></span>
						</li>
						
						<li><strong>Removal</strong>
							<span><?php echo create_dd("have_removal","system_dd","id","name","type = 90","",$_SESSION['view_quote_aSearching']);?></span>
						</li>
						
						<li><strong>Admin</strong>
							<span><?php echo create_dd("login_id","admin","id","name","is_call_allow=1 AND status = 1","",$_SESSION['view_quote_aSearching']);?></span>
						</li>
						
						<li><strong>CRM Quote</strong>
							<span><?php echo create_dd("production_id","admin","id","name","find_in_set (3 , admin_type) AND status = 1","",$_SESSION['view_quote_aSearching']);?></span>
						</li>
						
						<li>
							<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onClick="javascript:a_search_view_quote();">	
						</li>
						
						<li>
							<input type="button" name="reset" value="Reset"  onClick="a_reset(2);" class="offsetZero btnSet a_search_box" >	
						</li>
					</ul>
			</div>	

			
						
			 
			
			</div>	
                <div id="quote_view" style="margin-top: -50px;">
                    <? 
                    if(isset($_GET['action'])){ $_SESSION['view_quote_action'] = mres($_GET['action']); }
                    include("xjax/staff_view_quote.php"); ?>
                </div>

<div id="myModal" class="modal">

</div>
<script>
	$(window).scroll(function() {
		if($(this).scrollTop() > 10 ) {
			$(".view_quote_back_box").addClass("fixed");
			$(".usertable-overflow").addClass("usertable-overflowNew");
		} else {
			$(".view_quote_back_box").removeClass("fixed");
			$(".usertable-overflow").removeClass("usertable-overflowNew");
		}
	});
	
</script>