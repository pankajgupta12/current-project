<?php
unset($_SESSION['sub_staff']); 
?>
 <div class="view_quote_back_box">
    	
    <ul class="bb_4tabs application_tabs">
		<li><a href="/admin/index.php?task=sub_staff">All</a></li>
		<li><a href="/admin/index.php?task=sub_staff&action=1">Added</a></li>
		<li><a href="/admin/index.php?task=sub_staff&action=2">Waiting Approval</a></li>
		<li><a href="/admin/index.php?task=sub_staff&action=3">Approved</a></li>
		<li><a href="/admin/index.php?task=sub_staff&action=4">Removed </a></li>
    </ul>
	
	           <ul class="dispatch_top_ul application_report_search"> 				
				
					
					<li>
						<label>Staff Name</label>
						<span id="dispatch_staff_div">
						<?php echo create_dd("staff_id","staff","id","name","status=1 AND allow_sub_staff = 2","", $_SESSION['search_sub_staff']); ?>
                         </span>
					</li>      
				
				<li>
					<label>Sub staff name</label>
                    <input  type="text" name="sub_staff" id="sub_staff" value="<?php echo $_SESSION['search_sub_staff']['sub_staff_name']?>" >
				</li>

				
				<li>
				<strong>&nbsp;</strong>
				  <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box"  onclick="search_sub_staff(1);">	
				</li>

				<li>
				<strong>&nbsp;</strong>
				    <input type="reset" name="reset" value="Reset" class="offsetZero btnSet a_search_box1" onclick="search_sub_staff(2);">	
				</li>
			</ul>
	
<script> 
     $(document).ready(function(){
          var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
            $('[href$="'+url+'"]').parent().css('background-color','#00b8d4');
    });
	
	
</script>
<div id="application_view">
<? 
unset($_SESSION['sub_staff']); 
if(isset($_GET['action'])){ $_SESSION['sub_staff'] = mres($_GET['action']); }
include("xjax/sub_staff_list.php"); ?>
</div>

	