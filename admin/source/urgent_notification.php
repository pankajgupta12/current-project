<br/>
<?
if(!isset($_SESSION['urgent_notification']['login_id'])){ $_SESSION['urgent_notification']['login_id'] = 0; }
if(!isset($_SESSION['urgent_notification']['message_status'])){ $_SESSION['urgent_notification']['message_status'] = 0; }
if(!isset($_SESSION['urgent_notification']['p_order'])){ $_SESSION['urgent_notification']['p_order'] = 0; }

 //$totaldate = $_SESSION['urgent_notification']['from_date'] .'/'.$_SESSION['urgent_notification']['to_date'];

?>
<script language="javascript">
function urgent_notification_search(field){
	 var login_id = $('#login_id').val();
	 var message_status = $('#message_status').val();
	  var p_order = $('#p_order').val();
	 str = login_id+'|'+message_status+'|'+p_order;
	 send_data(str,621,'daily_view');
}

function urgent_notification_reset(){
	$('#login_id').val(0);
	$('#message_status').val('');
	$('#p_order').val(0);
	send_data('0||0',621,'daily_view');
}

</script>
<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        
        <li>
            <label>Admin Name</label>
            <span><?php echo create_dd("login_id","admin","id","name"," status = 1 AND is_call_allow = 1","",$_SESSION['urgent_notification']); ?> </span>
        </li>
        <li>
            
            <label>Status</label>
           <span> <?php echo create_dd("message_status","system_dd","id","name"," type = 135","",$_SESSION['urgent_notification']);?> </span>
        </li> 
       	
       	 <li> 
            <label>Priority</label>
            <span><?php echo create_dd("p_order","system_dd","id","name"," type = 151","",$_SESSION['urgent_notification']);?></span>
        </li>         
       	         
		<li>
				<strong>&nbsp;</strong>
				  <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onClick="urgent_notification_search();" >	
		</li>

		<li>
				<strong>&nbsp;</strong>
				    <input type="reset" name="reset" value="Reset" class="offsetZero btnSet a_search_box1"  onClick="urgent_notification_reset();">	
		</li>		 
         
    </ul>
				
</div>

<div id="daily_view">
  <? include("xjax/view_urgent_notification.php"); ?>
</div>