<script>
function check_press_enter(e) {
   if(e && e.keyCode == 13) {
      //document.forms[0].submit();
	  search_dispatch_report();
   }
}
   $( function() {	  
      $( "#from_date" ).datepicker({ dateFormat:'yy-mm-dd'});
      $( "#to_date" ).datepicker({ dateFormat:'yy-mm-dd'});
   });
  

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

function resetfilter(backdate,toDate){
    $('#from_date').val(backdate);
    $('#to_date').val(toDate);
    $('#site_id').val('');
}

</script>
<? 
if(!isset($_SESSION['reclean']['reclean_from_date'])){ $_SESSION['reclean']['reclean_from_date'] = date("Y-m-01"); }
if(!isset($_SESSION['reclean']['to_date'])){ $_SESSION['reclean']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['reclean']['status'])){ $_SESSION['reclean']['status'] = 5; }
?>

<script>
 $(document).ready(function(){
      var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
        $('.heading_view_quote [href$="'+url+'"]').parent().css('background-color','#00b8d4');
});
</script>

<div class="body_container">
	<div class="body_back body_back_disp">
    	<div class="wrapper">
		
		<ul class="bb_4tabs heading_view_quote">
          <li><a href="/admin/index.php?task=reclean_report&action=1">Assigned Re-Clean</a></li>
          <li><a href="/admin/index.php?task=reclean_report&action=2">Unassigned Re-Clean</a></li>
          <li><a href="/admin/index.php?task=reclean_report&action=3">Failed Re-Clean</a></li>
        </ul>
		<br>
		<?php if($_GET['action'] != '2' && $_GET['action'] != '3')  { ?>
            <div class="nav_form_main">
				<form name="dispatch_report" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" name="task" value="dispatch_report">
				
				
				<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
					<li>
						<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php if( isset($_SESSION['reclean']['reclean_from_date']) && $_SESSION['reclean']['reclean_from_date']!= NULL  ) { echo $_SESSION['reclean']['reclean_from_date']; } else { echo  date("Y-m-01"); } ?>" onchange="javascript:show_data('from_date',177,'quote_view');">
					</li>
					
					<li>
						<label>To Date</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php if( isset($_SESSION['reclean']['to_date']) && $_SESSION['reclean']['to_date']!= NULL  ) { echo $_SESSION['reclean']['to_date']; } else { echo  date("Y-m-t"); } ?>" onchange="javascript:show_data('to_date',186,'quote_view');">
					</li>
					
					<li>
						<label>Status</label>
							<span>
                                <?php  echo create_dd("status","system_dd","id","name",'type=26 AND id in (3,4,5,6,8)',"onchange=\"javascript:show_data('status',187,'quote_view');\"",$_SESSION['reclean']); 	?>
                         </span>
					</li>
					
					<li>
						<label>Location</label>
						<span>
						<?php echo create_dd("site_id","sites","id","name","","onchange=\"send_data(this.value,'178','quote_view');\"", $_SESSION['reclean']);?>
						</span>
					</li>
					
					<li>					
					<label>&nbsp;</label>
				    	<input type="reset" onclick="javascript:send_data('reset',179,'quote_view'); resetfilter('<?php echo date("Y-m-01") ?>','<?php echo date("Y-m-t"); ?>');" name="reset" value="Reset" style="cursor: pointer;" />
					</li>
					
					
				</ul>
				</form>
				
			</div>
		<?php  } ?>	
  <br>  
  
			<div id="quote_view">
			   <?php 
			    if($_GET['action'] == '3')  { 
				
			       include("xjax/failed_reclean.php");
				   
			    } else if($_GET['action'] == '2')  { 
				   include("xjax/reclean_unassign.php");
				?>
			   <?php  }else{ 
			    if(isset($_GET['action'])){ 
				   $_SESSION['reclean_report'] = mres($_GET['action']); 
				   }
				   include("xjax/reclean_report.php");
                
			   } ?>
			</div>
</div>
</div>
</div>