<?php 
 //if($_SESSION['dispatch']['quote_for']==""){ $_SESSION['dispatch']['quote_for'] = 1; }
?>

<style>
.dispatchboard_page.bb_tabs {
	margin: 0px;
	padding: 0px;
	list-style: none;
}
.dispatchboard_page.bb_tabs li {
	background: none;
	color: #222;
	display: inline-block;
	padding: 10px 15px;
	cursor: pointer;
}
.dispatchboard_page.bb_tabs li.current {
	background: #ededed;
	color: #222;
}
.tab-content {
	display: none;
	background: #ededed;
	padding: 15px;
}
.tab-content.current {
	display: inherit;
}

</style>
<?php  if($_SESSION['dispatch']['quote_for'] == 3) {
  $job_type = 'id = 11';	
 } else{
  $job_type = '';		
}
?>

<script>
$(document).ready(function(){
	$('ul.bb_tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');
		$('ul.bb_tabs li').removeClass('current');
		$('.tab-content').removeClass('current');
		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	});
});
</script>

<div class="body_container">
	<div class="body_back body_back_disp">
    	<div class="wrapper">
        	<div class="cret_left cret_left2">
            <div class="nav_form_main">
            	<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
				   
				   <li>
                    	<label>Quote Type</label>
						 <span>
						  <?php echo create_dd("quote_for","quote_for_option","id","name","status=1","onchange=\"javascript:send_data(this.value,511,'dispatch_div');\"",$_SESSION['dispatch']);?>  
						  
						   <?php //echo create_dd("quote_for","quote_for","id","name","","onchange=\"javascript:send_data(this.value,511,'dispatch_div');\"", $_SESSION['dispatch']);?>
                         </span>
						<!--<input class="quote_type" type="text" name="quote_type" id="quote_type" value="<?php echo $_SESSION['dispatch']['quote_type']?>">-->
                    </li>
				
                	<li>
                    	<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['dispatch']['from_date']?>" onchange="javascript:show_data('from_date',16,'dispatch_div');">
                    </li>
                    <li>
                    	<label>Location</label>
                       	<span>
						<?php echo create_dd("site_id","sites","id","name","","onchange=\"javascript:send_data(this.value,14,'dispatch_div');\"", $_SESSION['dispatch']);?>
                        </span>
                    </li>
                    <li>
                    	<label>Job Type</label>
                       	<span>
						<?php echo create_dd("job_type","job_type","name","name",$job_type,"onchange=\"javascript:send_data(this.value,15,'dispatch_div');\"", $_SESSION['dispatch']);?>
                         </span>
                    </li>
					
					<li style="position: relative;">
					    <label>Staff Name</label>
						 <input name="staff_id" type="text" placeholder="Search Staff" class="input_search" id="staff_id" onkeyup="javascript:get_staff_name(this.value,'245','postcode_div')" autocomplete="off" value="<?php echo  get_rs_value("staff","name",$_SESSION['dispatch']['staff_id']);; ?>">
						  <div class="clear"></div>
						  <div class="searchList staff_postcode_div shatff_search_box" id="postcode_div" style="display:none;"></div>
					</li>
					<li style="margin-top: 22px;">
					    <input type="button"  class="dispatch_reset_button" onclick="dispatch_reset_button('<?php echo date('Y-m-d'); ?>');" value="Reset" id="dispatch_reset" >
					</li>
					
					
                   <!-- <li>
                    	<label>Staff</label>
                       	<span id="dispatch_staff_div">
						<?php echo create_dd("staff_id","staff","id","name","status=1","onchange=\"javascript:show_data('staff_id',17,'dispatch_div');\"", $_SESSION['dispatch']); ?>
                         </span>
                    </li>-->				 
					 
                </ul>
				
		
                <ul class="pre_next_ul">
					<li><a href="javascript:movecal('prev_week');">&lt;&lt;</a></li>
					<li><a href="javascript:movecal('prev_day');">&lt;</a></li>
					<li><a href="javascript:movecal('next_day');">&gt;</a></li>
					<li><a href="javascript:movecal('next_week');">&gt;&gt;</a></li>
                </ul>
				
				<div class="view_job_btn">
					<a href="#" class="view_job_text">View job</a>
				</div>
            </div>
                
             <div class="table_dispatch" id="dispatch_div">
				<?php  include_once "xjax/dispatch.php";?>
             </div>
        	</div>
            <div class="cret_right cret_right2">
           		<ul class="search_main search_main2">
                	<li>
                       	<span>
                        <?php  echo create_dd("status","system_dd","id","name",'type=26',"onchange=\"javascript:show_data('status',19,'tab-1');\"",$_SESSION['dispatch']); 	?>
                         </span>
                    </li>
                    <li>
                    	<input type="text" class="search_field_box" placeholder="Search" name="keyword" id="keyword" value="<?php echo $_SESSION['dispatch']['keyword']?>" onchange="javascript:show_data('keyword',18,'tab-1');">
                        <input type="submit" name="" value="" class="search_img" onClick="javascript:show_data('keyword',18,'tab-1');">
                    </li>                    
                </ul>
                
                
                <div id="horizontalTab" class="r-tabs dispatchboard_page">                    
                    <ul class="bb_tabs">
                        <li class="tab-link current" data-tab="tab-1">Assigned</li>
                        <li class="tab-link" data-tab="tab-2">Not Assigned</li>
                    </ul>
                     
					    <div id="tab-1" class="tab-content current" >
                           <?php include("xjax/dispatch_side.php"); ?>
                        </div>
						
                    <div id="tab-2" class="tab-content">                       		
                       <?php include("xjax/dispatch_side_not_assigned.php"); ?>
                    </div>
                </div>
                <!--<div class="cret_right_table_main" id="dispatch_side_div">				
				<?php //include("xjax/dispatch_side.php"); ?>				
				</div>-->
            </div>
        </div>
    </div>
	<style>
	
		.shatff_search_box{
			width: 100% !important;
			left: 0 !important;
			right: 0 !important;
			top:70px !important;
		}
		
	</style>
	
	<script>
	
	 //$('.body_container').click();
	 $(".body_container").click(function(){
        //$('#staff_id').val('');
        $('#postcode_div').hide();
     });
	 
	 function dispatch_reset_button(today){
		 $('#from_date').val(today);
		 $('#quote_for').val(1);
		 $('#site_id').val(0);
		 $('#job_type').val(0);
		 $('#staff_id').val('');
		 send_data(today,246,'dispatch_div');
	 }

    /* 	$('.table-scroll').scroll(function(){
				var ref = $('.table-scroll');
				clearTimeout($.data(this, 'scrollTimer'));
				$.data(this, 'scrollTimer', setTimeout(function() {
				var xhr = null;
					if( (ref.scrollTop() + ref.height()) > 0.95 * ref[0].scrollHeight )
					{
						lastid = $('#remore_loadmore').attr('page-data');
                            //var lastID = 2;
						 // alert('==='+lastid);
						 if(lastid != undefined) {  
										$('#loaderimage_1').show();
										$('.full_loader').attr('id','bodydisabled_1');
										
						            if( xhr != null ) {
										xhr.abort();
										xhr = null;
									}
                        
						xhr =	$.ajax({
									url: 'xjax/ajax/loadmore_dispatchboard.php',
									type: 'POST',
									datatype: 'html',
									data: 'page='+lastid,
									success: function(response){
										
										if(response){
											$('.load_more').remove();
											$('.load-more').remove();
											$( "tr.parent_tr:last" ).after( response );
										}
										
										$('#loaderimage_1').hide();
										$('.full_loader').attr('id','');
									} 
							}); 
						}
					}
					
				}, 100));
			}); 
			 */
	</script>
	
</div>

