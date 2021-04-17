<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
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

function check_press_enter_quote(e) {
   if(e && e.keyCode == 13) {
      //document.forms[0].submit();
	  document.getElementById('comments_button').click();
   }
}

$(document).ready(function(){
      var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
        $('[href$="'+url+'"]').parent().css('background-color','#00b8d4');
});

</script>
<? 
 if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }Else If(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); }
 
unset($_SESSION['view_quote_field'],$_SESSION['view_quote_keyword'],$_SESSION['view_quote_action']);
?>
 
 <div class="view_quote_back_box">
	<div class="left_text_box">
		<span class="add_jobs_text">View Report</span>        
	</div>
     <ul class="bb_4tabs">
          <li><a href="/admin/index.php?task=view_report">All</a></li>
          <li><a href="/admin/index.php?task=view_report&action=1">No Info</a></li>
          <li><a href="/admin/index.php?task=view_report&action=2">Info</a></li>
          <li><a href="/admin/index.php?task=view_report&action=3">Admin Approved</a></li>
          <li><a href="/admin/index.php?task=view_report&action=4">Completed</a></li>
    </ul>
    
 
<div id="quote_view">
<? 
if(isset($_GET['action'])){ $_SESSION['view_quote_action'] = mres($_GET['action']); }
include("xjax/view_report.php"); ?>
</div>

<div id="myModal" class="modal">

</div>
