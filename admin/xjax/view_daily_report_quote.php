
<!-------Menu-------> 
<script>
$(document).on('click','.loadmore',function () {
  $(this).text('Loading...');
 //   var ele = $(this).parent('td');
   // alert(ele);
        $.ajax({
      url: 'xjax/ajax/daily_report_quote_loadmore.php',
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
$arg = "select * from quote_new where 1=1 ";


if($_SESSION['quote']['status']!=""){ 
	$arg.= " AND status='".mysql_real_escape_string($_SESSION['quote']['status'])."'";
	$cond.= " AND status='".mysql_real_escape_string($_SESSION['quote']['status'])."'";
}

if($_SESSION['quote']['date']!=""){ 
	$arg.= " AND date='".mysql_real_escape_string($_SESSION['quote']['date'])."'";
	$cond.= " AND date='".mysql_real_escape_string($_SESSION['quote']['date'])."'";
}

if($_SESSION['quote']['site_id']!="" && $_SESSION['quote']['site_id'] != 0){ 
	$arg.= " AND site_id=".mysql_real_escape_string($_SESSION['quote']['site_id'])." ";
	$cond.= " AND site_id=".mysql_real_escape_string($_SESSION['quote']['site_id'])." ";
}
//$cond.=' AND status = 0 ';
$arg.=" order by id desc limit 0,$resultsPerPage";

//echo $arg; 
$data = mysql_query($arg);
 $countResult = mysql_num_rows($data);

?>
<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
	<div class="left_text_box" style="margin-left: 30px;">
		<span class="add_jobs_text"> view <?php  if($_SESSION['quote']['status'] == 1){ ?> Booking <?php }else { echo "Quote"; } ?></span>        
	</div>

	<div class="right_text_box">
	  <div class="midle_staff_box"> <span class="midle_text">Total Records Found <?php echo  getTotalRecords('quote_new',$cond); ?> </span></div>
	</div>
<div class="usertable-overflow">
    <table class="user-table">
	  <thead>
	  <tr>
		<th>Id</th>
		<?php  //if($_SESSION['quote']['status'] == 1){ ?>
		<th>Job ID</th>
		<?php // } ?>
		<th>Site</th>
        <th>Ref</th>
		<th>Quote Date</th>
		<th>Quote Time</th>
		<th>Name</th>
		<!--<th>Email</th>
		<th>Phone</th>-->
		<th>Suburb</th>
        <th>Job Type</th>
		<th>Job Date</th>
		<th>SMS Quote</th>
        <th>Email Date</th>
		<th>Amount</th>
		<th>Called</th>
		<th>2nd Call</th>
		<th>7 Day Call</th>
        <th>Status</th>
	  </tr>
	  </thead>
	  <tbody id="get_loadmoredata">
	  <?php 
	  if (mysql_num_rows($data)>0){ 
	  $counter = 0;
	  while($r=mysql_fetch_assoc($data)){ 
	  
	   $counter++;
            $bgcolor = ($counter % 2 === 0) ? 'alert_even_tr' : 'alert_odd_tr';
			
			$quote_details = mysql_query("select * from quote_details where quote_id=".$r['id']);
			   
			      //  $rQdetails = mysql_fetch_array(mysql_query("select * from quote_details where id=".$quote_details['id'].""));
                      //print_r($rQdetails);
                    //  $desc1 = create_memberquote_desc_str($rQdetails);
                     // mysql_query("update quote_details set description='".$desc1."' where id=".$quote_details['id']."");
			   
		$startDatehours  = date('Y-m-d H:i:s');
        $endDatehours = $r['createdOn'];
        $minutes = round((strtotime($startDatehours) - strtotime($endDatehours))/60, 2);
        
            if($r['deleted'] == 1 && $r['step'] == 6) {    
                $style1 =  'opacity:0.4;pointer-events: none;';
            }else {
               $style1 =  '';
            }
			
			
	  ?>
		<tr class="parent_tr <?php if($r['step'] == 5 || $r['step'] == 6 ) { echo ' alert_danger_tr'; } ?><?php if($r['status'] == 1) { echo "alert_danger_success";} ?> <?php echo $bgcolor; ?>" style='<?php echo $style1; ?>'>
			<td class="bc_click_btn pick_row"><? echo $r['id'];?></td>
			<?php  if($_SESSION['quote']['status'] == 1){ ?>
			  <td class="bc_click_btn"><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<? echo $r['booking_id'];?>','1200','850')"><? echo $r['booking_id'];?></a></td>
			<?php  }else { ?>
			 <td class="bc_click_btn">--</td>
			<?php  } ?>
			<td class="bc_click_btn"><? echo get_rs_value("sites","name",$r['site_id']);?></td>
			<td class="bc_click_btn"><? echo $r['job_ref'];?></td>
			<td class="bc_click_btn"><? echo changeDateFormate($r['date'],'datetime');?></td>
		    <td class="bc_click_btn"><? echo date('h:i:s',strtotime($r['createdOn'])).'<br/>'.date('a',strtotime($r['createdOn'])); ?></td>
			<td class="bc_click_btn"><? echo $r['name'];?></td>
			<!--<td class="bc_click_btn"><a href="mailto:<?// echo $r['email'];?>"><? // echo substr($r['email'], 0, 10)."...";?></a></td>
			<td class="bc_click_btn"><a href="tel:<? //echo $r['phone'];?>"><? echo $r['phone'];?></a></td>-->
			<td class="bc_click_btn"><a title="<?php echo $r['address']; ?>"><? echo $r['suburb'];?></a></td>
			<td class="bc_click_btn"><? while($qd = mysql_fetch_assoc($quote_details)){ echo $qd['job_type']." "; }?></td>
			<td class="bc_click_btn"><? if($r['booking_date']!="0000-00-00"){ echo changeDateFormate($r['booking_date'],'datetime'); } ?>
			</td>
			<td class="bc_click_btn" id="quote_sms_<?=$r['id']?>"><? if($r['sms_quote_date']!="0000-00-00"){ echo date("d-m-Y",strtotime($r['sms_quote_date'])); } ?></td>
			<td class="bc_click_btn" ><? if($r['emailed_client']!="0000-00-00 00:00:00"){ echo date("d/m H:i:s",strtotime($r['emailed_client'])); }?></td>
			<td class="bc_click_btn" >$<? echo $r['amount'];?></td>
			<td class="bc_click_btn" id="quote_called_<?=$r['id']?>"><? if($r['called_date']!="0000-00-00 00:00:00"){ echo date("d/m H:i:s",strtotime($r['called_date'])); } else { echo "-"; }?></td>
			<td class="bc_click_btn" id="second_quote_called_<?=$r['id']?>"><? if($r['second_called_date']!="0000-00-00 00:00:00"){ echo date("d/m H:i:s",strtotime($r['second_called_date'])); } else { echo "-"; }?></td>
			<td class="bc_click_btn" id="seven_quote_called_<?=$r['id']?>"><? if($r['seven_called_date']!="0000-00-00 00:00:00"){ echo date("d/m H:i:s",strtotime($r['seven_called_date'])); } else { echo "-"; }?></td>
			<!--<td id="getstatus"><?php // if($r['deleted'] == 1) { echo "delete"; }else { if($r['status'] == 1) { echo "Approved"; }else { echo getquoteStepsByID($r['step']); } }  //$stepArray[$r['step']]; ?></td>-->	      
			<td id="getstatus"><?php if($r['deleted'] == 1) { echo "Delete"; }else { echo getSystemDDname($r['step'],31); } ?></td>	      
		</tr>
	  <? }?>
	  
		<?php if($countResult >= $resultsPerPage) { ?>
	       <tr class="load_more">
	         <td colspan="22"><button class="loadmore" data-page="2" >Load More</button></td>
	      </tr>
        <?php } }else { ?>  
	       <tr><td colspan="20">No Quotes Found</td></tr>
	<?php  } ?>
	</table>
</div>
<style>
	#container{width: 80%;margin: auto auto;}
	.news_list {
	list-style: none;
	}
	

</style>
