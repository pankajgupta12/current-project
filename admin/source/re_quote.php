<?php  
if(!isset($_SESSION['re_quote']['quote_type'])){ $_SESSION['re_quote']['quote_type'] = 0; }
if(!isset($_SESSION['re_quote']['from_date'])){ $_SESSION['re_quote']['from_date'] = date("Y-m-01"); }
if(!isset($_SESSION['re_quote']['to_date'])){ $_SESSION['re_quote']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['re_quote']['re_quote_id'])){ $_SESSION['re_quote']['re_quote_id'] = 0; }
if(!isset($_SESSION['re_quote']['re_quote_status'])){ $_SESSION['re_quote']['re_quote_status'] = 0; }

?>

<script>
 $(document).ready(function(e)
{  
	var global_pick_id = null;
	
	$('body').on('click','td.bc_click_btn',function(e)
	{  
		
		
		$(this).closest('tr').find('td').css('background-color','#00b8d4');
	
		if($(this).closest('tr.parent_tr').find('td.pick_row').hasClass('pick_row')){ 
		    
		    
		    
			global_pick_id = $(this).closest('tr.parent_tr').attr('id');
			$('.modal').html();			
			 //alert(global_pick_id);
			 //	console.log($(this).closest('tr.parent_tr').find('td.pick_row').hasClass('pick_row'));
			send_data(global_pick_id,'617','myModal');
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
</script>


    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5" id="get_page">
        
         <li> 
            <label>Quote Type</label>
							<span>
							    <?php echo create_dd("quote_type","system_dd","id","name","type=63","",$_SESSION['re_quote']);?>
							</span>
			</li>
	
	    <li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php  echo $_SESSION['re_quote']['from_date'];?>" >
        </li>
		
		<li>
            <label>To  Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date_1" value="<?php  echo trim($_SESSION['re_quote']['to_date']);?>" >
        </li>
		
		
		<li>
            <label>Re Quote</label>
            <span><?php echo create_dd("re_quote_1","system_dd","id","name","type=150","",$_SESSION['re_quote']);?></span>
        </li>
		
		<li>
            <label>Status</label>
            <span><?php echo create_dd("re_quote_status","system_dd","id","name","type=149","",$_SESSION['re_quote']);?></span>
        </li>
		
		<li>
			<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="button" value="Search"  onClick="check_re_quote();"  class="offsetZero btnSent a_search_box" >	 
		</li>  
		
		<li style="margin-top: 28px;">
    		<input type="button" name="reset" value="Reset" onClick="reset_check_re_quote('<?php echo date("Y-m-01"); ?>' ,'<?php echo date("Y-m-t"); ?>');" class="offsetZero btnSet a_search_box_two">
		</li> 
 
	</ul>


    <div id="myModal" class="modal"></div>

<div id="daily_view_1">
  <?php include('xjax/view_re_quote.php'); ?>
</div>

<script>
  
   function check_re_quote() {
      var quote_type = $('#quote_type').val();
	  var from_date = $('#from_date').val();
	  var to_date =  $('#to_date_1').val(); 
	  var re_quote =  $('#re_quote_1').val();
	  var re_quote_status =  $('#re_quote_status').val();
	  var str1 = quote_type+'|'+from_date+'|'+to_date+'|'+re_quote+'|'+re_quote_status; 
	  
	  send_data(str1 ,616,'daily_view_1');
   }
   
   function reset_check_re_quote(fromdatde,todate) {
        $('#quote_type').val(0);
	   $('#from_date').val(fromdatde);
	   $('#to_date_1').val(todate); 
	   $('#re_quote_1').val(0);
	   $('#re_quote_status').val(0);
	  var str1 = '0|'+fromdatde+'|'+todate+'|0|0'; 
	  send_data(str1 ,616,'daily_view_1');
	
   }
</script>




