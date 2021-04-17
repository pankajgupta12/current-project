<?php unset($_SESSION['slot_quote_action'],$_SESSION['slot_quote_action'],$_SESSION['slot_quote_action'] , $_SESSION['slot_quote_action']); ?>

<script>
$(document).ready(function(e)
{
	var global_pick_id = null;
	
	$('body').on('click','td.bc_click_btn',function(e)
	{
		
		$(this).closest('tr').find('td').css('background-color','#00b8d4');
		
		if($(this).closest('tr').find('td.pick_row').hasClass('pick_row')){ 
			global_pick_id = $(this).closest('tr').find('td.pick_row a').html();
			
			//alert(global_pick_id);
			
			$('.modal').html();			
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

$(document).ready(function(e) {
	  $('.menu').click(function(e) {
	      $('.main_menu').slideToggle(700);    
	  });
});
 
$(document).ready(function(){
      var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
        $('.bb_4tabs [href$="'+url+'"]').parent().css('background-color','#00b8d4');
});
 
function uncheck() {
	  $('.user-table tbody td').css('background-color',''); 
	  $( ".bc_click" ).prop( "checked" , false );
}

</script>

<div class="body_container">
	<div class="body_back body_back_disp">
	
    	<div class="wrapper">
            <div class="nav_form_main">
			<p id="time" style="font-weight: 600;float: right;font-size: 13px;">Current AU Time : <?php echo date('dS M Y H:i:s A');?></p>
			
				<ul class="dispatch_top_ul call_quote_searching" >
				   
					<li>
						<label>Schedule From </label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php  if( isset($_SESSION['schedule']['from_date']) && $_SESSION['schedule']['from_date']!= NULL  ) { echo $_SESSION['schedule']['from_date']; }?>" />
					</li>
					
					<li>
						<label>Schedule To</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php if( isset($_SESSION['schedule']['to_date']) && $_SESSION['schedule']['to_date']!= NULL  ) { echo $_SESSION['schedule']['to_date'];  } ?>" />
					</li>
					
					<li>
						<label>Location</label>
						<span><?php echo create_dd("site_id","sites","id","name","", $_SESSION['schedule']);?></span>
					</li>
					
					<li>
						<label>Quote ID</label>
						<input class="" type="text" name="quote_id" id="quote_id" value="<?php if( isset($_SESSION['schedule']['quote_id']) && $_SESSION['schedule']['quote_id']!= NULL  ) { echo $_SESSION['schedule']['quote_id'];  } ?>" />
					</li>
					
					<li>
						<label>Job Date</label>
						<input class="date_class" type="text" name="job_date" id="job_date" value="<?php if( isset($_SESSION['schedule']['job_date']) && $_SESSION['schedule']['job_date']!= NULL  ) { echo $_SESSION['schedule']['job_date'];  } ?>" />
					</li>
					
					<li><label>Response</label>
						<span><?php echo create_dd("response","system_dd","id","name","type=33","",$_SESSION['schedule']['response']);?></span>
					</li>
					
					<li><label>Status</label>
						<span><?php echo create_dd("step","system_dd","id","name","type=31","",$_SESSION['schedule']);?></span>
					</li>
					
					<li>
						<label>Mobile</label>
						<input class="" type="text" name="mobile" id="mobile" value="<?php if( isset($_SESSION['schedule']['mobile']) && $_SESSION['schedule']['mobile']!= NULL  ) { echo $_SESSION['schedule']['mobile'];  } ?>" />
					</li>
					
					<li>					
					    <label>&nbsp;</label>
				    	<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box_one" 
						onClick="get_schedule_slot_page();" />
					</li>
					
					<li>					
					    <label>&nbsp;</label>
				    	<input type="reset" onclick="javascript:reset_get_schedule_slot_page('<?php //echo date("Y-m-1");?>' , '<?php // echo date("Y-m-t"); ?>');" name="reset" value="Reset" style="cursor: pointer;" />
					</li>
					
				</ul>
			</div>
        </div>
        <ul class="bb_4tabs" style="margin-left: 39px;">
			  <li><a href="/admin/index.php?task=slot_list">All</a></li>
			  <li><a href="/admin/index.php?task=slot_list&action=1">Pending</a></li>
			  <li><a href="/admin/index.php?task=slot_list&action=2">Current</a></li>
			  <li><a href="/admin/index.php?task=slot_list&action=3">Upcoming</a></li>
			  <li><a href="/admin/index.php?task=slot_list&action=4">Call Done</a></li>
			  <li><a href="/admin/index.php?task=slot_list&action=5">Removal</a></li>
	    	</ul>
	 		
  
			<div id="quote_view">
			  <? 
			  if(isset($_GET['action'])){ $_SESSION['slot_quote_action'] = mres($_GET['action']); }
			  include("xjax/view_slot_list.php"); ?>
			</div>

			<div id="myModal" class="modal"></div>
			
    </div>
</div>
</div>

   