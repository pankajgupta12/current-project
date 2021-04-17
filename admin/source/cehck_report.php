<?php  
if(!isset($_SESSION['cehck_report']['today'])){ $_SESSION['cehck_report']['today'] = date("Y-m-d"); }
//if(!isset($_SESSION['client_review']['from_date'])){ $_SESSION['client_review']['from_date'] = date("Y-m-1"); }
?>

<script>

$(document).ready(function(e){
	    $('.black_screen1').click(function(e)
		{
			$('.modal').removeClass('toggle');
			$('.black_screen1').fadeOut(700);

		});
	});

 
</script>


    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
	
	    <li>
            <label>Date</label>
            <input class="date_class" type="text" name="today" id="today" value="<?php echo $_SESSION['cehck_report']['today']?>" >
        </li>
        <li>
       
		
		<li>
			<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Search"  onClick="check_report();"  class="offsetZero btnSent a_search_box" >	 
			
		</li>  
		<li style="    margin-top: 28px;">
    		<input type="button" name="reset" value="Reset" onclick="reset_check_report('<?php echo date("Y-m-d"); ?>');" class="offsetZero btnSet a_search_box_two">
		</li> 
 
	</ul>

<div id="get_notes_div" class="modal">

</div>
	
<div id="daily_view">
  <?php  include('xjax/view_check_report.php'); ?>
</div>




