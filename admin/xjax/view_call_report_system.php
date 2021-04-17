
<!-------Menu-------> 
<script>
$(document).on('click','.loadmore',function () {
  $(this).text('Loading...');
 //   var ele = $(this).parent('td');
   // alert(ele);
        $.ajax({
      url: 'xjax/ajax/call_report_system_loadmore.php',
      type: 'POST',
      datatype: 'html',
      data: {
              page:$(this).data('page'),
            },
        success: function(response){
            if(response){
                $('.load_more').remove();
                $( "tr.parent_tr:last" ).after( response );
             }
            } 
             
   }); 
});

</script>

<?

 
$resultsPerPage = resultsPerPage;
$arg = "SELECT * FROM `c3cx_calls` where 1=1 ";

if($_SESSION['call_report']['date'] !=""){ 
	$arg.= " AND call_date='".mysql_real_escape_string($_SESSION['call_report']['date'])."'";
	$cond.= " AND call_date='".mysql_real_escape_string($_SESSION['call_report']['date'])."'";
}

if($_SESSION['call_report']['admin_id']!=""){ 
   $fromname = get_rs_value("c3cx_users","3cx_user_name",$_SESSION['call_report']['admin_id']);
	$arg.= " AND admin_id=".mysql_real_escape_string($_SESSION['call_report']['admin_id'])." ";
	$cond.= " AND admin_id=".mysql_real_escape_string($_SESSION['call_report']['admin_id'])." ";
}
if($_SESSION['call_report']['from_to'] == 1){ 
    
	$arg.= " AND from_type='".mysql_real_escape_string($fromname)."'";
	 $cond.= " AND from_type='".mysql_real_escape_string($fromname)."'";
}
if($_SESSION['call_report']['from_to'] == 2){ 
    //$fromname = get_rs_value("c3cx_users","3cx_user_name",$_SESSION['call_report']['admin_id']);
	$arg.= " AND to_type='".mysql_real_escape_string($fromname)."'";
	$cond.= " AND to_type='".mysql_real_escape_string($fromname)."'";
}


	//echo $cond; 
//$cond.=' AND status = 0 ';
$arg.=" order by id desc limit 0,$resultsPerPage";

//echo $arg; 
$query = mysql_query($arg);
 $countResult = mysql_num_rows($query);

?>
<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
	<div class="right_text_box">
	  <div class="midle_staff_box"> <span class="midle_text">Total Records Found <?php echo  getTotalRecords('c3cx_calls',$cond); ?> </span></div>
	</div>
<div class="usertable-overflow">
    <table class="user-table">
	  <thead>
	  <tr>
		<th>Id</th>
		<th>Call Date</th>
        <th>Call Time</th>		
		<th>From</th>		
		<th>To</th>
		<th>Ivr Option</th>
		<th>Terminated By</th>
		<th>Duration</th>
        <th>Quote Id</th>
		<th>Job Id</th>
		<th>Staff ID</th>
		<th>Admin ID</th>
		<th>Reason</th>
	  </tr>
	  </thead>
	  <tbody id="get_loadmoredata">
	  <?php 
	      $class = '';
        if( $countResult > 0 )
       {
         $counter = 0;
	  while( $r = mysql_fetch_assoc( $query ) )
	  { 
            $counter++;
            $bgcolor = ($counter % 2 === 0) ? 'alert_even_tr' : 'alert_odd_tr';
			
			if( $r['approved_status'] == 0 )
			{
				$class = ' alert_danger_tr';
			}
			else
			{
				$class = '';
			}
			
			
	  ?>
		<tr  class="parent_tr <?php echo $bgcolor; ?>" id="deletecall_import_<? echo $r['id'];?>">
		
			<!-- row id -->
			<td class="bc_click_btn"><? echo $r['id'];?></td>

			<!-- call date -->
			<td class="bc_click_btn"><? echo changeDateFormate($r['call_date'],'datetime');?></td>

			<!-- call time -->
			<td class="bc_click_btn"><? echo $r['call_time'];?></td>
			
			<!-- from number -->
			<td class="bc_click_btn"><? echo $r['from_type'];?></td>

			<!-- to number -->
			<td class="bc_click_btn"><? echo $r['to_type'];?></td>
			
			<!-- to number -->
			<td class="bc_click_btn  <?php  echo $class;?>"><? echo $r['ivr_option'];?></td> 
			
			<td class="bc_click_btn"><? echo $r['terminated_by'];?></td>  

			<!-- duration -->
			<td class="bc_click_btn"><? if( $r['duration'] != '' ){echo $r['duration'];}else{ echo '--'; }?></td>
			
			<td class="bc_click_btn"><? echo $r['quote_id'];?></td>  
			
			<td class="bc_click_btn"><? echo $r['job_id'];?></td>  
			
			<td class="bc_click_btn"><? echo $r['staff_id'];?></td>  
			
			<td class="bc_click_btn"><?  echo  get_rs_value("c3cx_users","3cx_user_name",$r['admin_id']);?></td>  
			
			<td class="bc_click_btn"><? echo $r['comment_status'];?></td>  
			
		</tr>
	  <? }?>
	  
		<?php if($countResult >= $resultsPerPage) { ?>
	       <tr class="load_more">
	         <td colspan="22"><button class="loadmore" data-page="2" >Load More</button></td>
	      </tr>
        <?php } }else { ?>  
	       <tr><td colspan="20">No result Found</td></tr>
	<?php  } ?>
	</table>
</div>
<style>
	#container{width: 80%;margin: auto auto;}
	.news_list {
	list-style: none;
	}

</style>
