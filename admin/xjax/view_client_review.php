<?

if(!isset($_SESSION['client_review']['from_date'])){ $_SESSION['client_review']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['client_review']['to_date'])){ $_SESSION['client_review']['to_date'] = date("Y-m-t"); }

  $resultsPerPage = resultsPerPage;
 // $resultsPerPage = 10;
  $arg = "SELECT * FROM `bcic_review` where 1=1 ";
  
	if($_SESSION['client_review']['from_date']  != ''  && $_SESSION['client_review']['to_date'] != '') {
	  $arg .=" AND review_date>= '".date('Y-m-d' ,strtotime($_SESSION['client_review']['from_date']))."' and review_date <='".$_SESSION['client_review']['to_date']."'";
	} 
	
	if(isset($_SESSION['client_review']['job_id'])){
		$arg .=" AND  job_id ='".$_SESSION['client_review']['job_id']."'";
	}
	//review_date >='2018-05-01' AND review_date <= '2018-05-31'
	$cond = $arg;
	$arg.=" order by id desc limit 0,$resultsPerPage";
	
	//echo $cond;
	
    $data = mysql_query($arg);
   
  
   $countResult = mysql_num_rows(mysql_query($cond));
 
?>

<style>
 .textfields{
     border:1px solid #ddd !important;
    width: 89% !important;
    height: 43px;
    border-radius: 5px;
 }
</style>

 <div class="right_text_box">
     <div class="midle_staff_box"> <span class="midle_text">Total Records <?php echo  $countResult; ?> </span></div>
</div>

<div class="usertable-overflow">
	<table class="user-table">
	  <thead>
	  <tr>
		<th>Job id</th>
		<th>Review Date</th>
		<th>Job Date</th>
		<th>Staff Name</th>
		<!--<th>Job Type</th>-->
		<th>Client Name</th>
		<th>Email</th>
		<th>Phone</th>
	    <!--<th>Job Type</th>-->
	    <!--<th>Positive Comment</th>
	    <th>Negative Comment</th>-->
	    <th>Over All Rating</th>
	    <th>Positive feedback</th>
	    <th>Negative feedback</th>
	    <th>Qestion Rating</th>
	    <th>Email Send Date</th>
	    <th>Voucher Emails</th>
		
	  </tr>
	  </thead>
	    <tbody id="get_loadmoredata">
			 
			<?php  
			    if(mysql_num_rows($data) > 0) {
			    while($getreviewData = mysql_fetch_assoc($data)) {
					
					//$job_details = mysql_query("select * from job_details where job_id=".$getreviewData['job_id']." and status!=2");
					$staffdetails = mysql_fetch_assoc(mysql_query("select GROUP_CONCAT(staff_id) as staffid ,  GROUP_CONCAT(job_type) as jobtype , job_date from job_details where job_id=".$getreviewData['job_id']."  and status!=2 order by job_type_id asc"));
					
					$staffdetailsname = mysql_fetch_assoc(mysql_query("select GROUP_CONCAT(name) as sname from staff where id in  (".$staffdetails['staffid'].") order by id asc" ));
					
					//$array = array_merge($staffdetails,$staffdetailsname);
					
			?>
				<tr class="parent_tr <?php if(in_array($getreviewData['overall_experience'] , array(4,5))) { echo  'alert_danger_success';  } ?>">
					<td class="pick_row"><a href="javascript:scrollWindow('client_review_popup.php?task=review&type=<?php echo $getreviewData['job_type']; ?>&job_id=<?php  echo $getreviewData['job_id']; ?>','1200','850')"><?php  echo $getreviewData['job_id']; ?></a></td>
					<td class="pick_row"><?php  echo changeDateFormate($getreviewData['review_date']  , 'datetime'); ?></td>
					<td class="pick_row"><?php  echo changeDateFormate($staffdetails['job_date'], 'datetime'); ?></td>
					<td class="pick_row"><?php echo $staffdetailsname['sname']; ?> <br/><?php // echo $staffdetails['jobtype']; ?></td>
					<!--<td class="pick_row"><?php  echo $staffdetails['jobtype']; ?></td>-->
					<td class="pick_row"><?php  echo $getreviewData['name']; ?></td>
					<td class="pick_row"><a href="mailto:<?php  echo $getreviewData['email']; ?>"><?php  echo $getreviewData['email']; ?></a></td>
					<td class="pick_row"><a href="tel:<?php  echo $getreviewData['phone']; ?>"><?php  echo $getreviewData['phone']; ?></a></td>
					<!--<td class="pick_row"><?php if($getreviewData['job_type'] == '1') { echo "Job";}else{ echo "Re-Clean";} ?></td>-->
					<td class="pick_row"><?php  echo ($getreviewData['overall_experience']); ?></td>
					<td class="pick_row" title="<?php if($getreviewData['positive_comment'] != '') {  echo $getreviewData['positive_comment']; } ?>"><?php if($getreviewData['positive_comment'] != '') {  echo substr($getreviewData['positive_comment'] , 0, 100).'...'; } ?></td>
					<td class="pick_row" title="<?php if($getreviewData['negative_comment'] != '') {  echo $getreviewData['negative_comment']; } ?>"><?php if($getreviewData['negative_comment'] != '') {  echo substr($getreviewData['negative_comment'] ,0, 100).'...'; } ?></td>
					<td class="pick_row"><?php  $rattingDetails =  json_decode($getreviewData['rating'] ,true);
                    // print_r($rattingDetails);
					 foreach($rattingDetails as $key=>$value) {
						$ques = get_rs_value("bcic_review_ques","ques",$key);

						 echo '<p title="'.$ques.'" style="white-space: pre;">Ques'.$key.' =>'.$value.', </p> ';
					 }
					?></td>
			        <td class="pick_row"><?php if(in_array($getreviewData['overall_experience'] , array(4,5))) { if($getreviewData['send_email_status'] == '1') { echo changeDateFormate($getreviewData['send_email_date'],'timestamp'); }else {echo 'Not send'; } } ?></td>
					
					<td class="pick_row" id="send_voucher_date_<?php echo $getreviewData['id']; ?>" title="<?php if($getreviewData['send_voucher_date'] != '0000-00-00 00:00:00') {  changeDateFormate($getreviewData['send_voucher_date']  , 'datetime'); } ?>">
					<?php if(in_array($getreviewData['overall_experience'] , array(4,5))) { ?>
					<?php if($getreviewData['send_voucher_date'] != '0000-00-00 00:00:00') {  echo changeDateFormate($getreviewData['send_voucher_date']  , 'datetime'); }else { ?> <a  href="javascript:send_data('<?=$getreviewData['job_id']?>' ,581, 'send_voucher_date_<?php echo $getreviewData['id']; ?>');">Send voucher Emails</a><?php  } ?><?php  } ?></td>
				</tr>
			 <?php  } ?>
			  
			    <?php if($countResult >= $resultsPerPage) { ?>
					  <tr class="load_more">
						 <td colspan="25"><button class="loadmore" data-page="2" >Load More</button></td>
					  </tr>
				 <?php } }else { ?>  
				  <tr class="">
					 <td colspan="25">No Found  Result</td>
				  </tr>
				 <?php  } ?> 
		</tbody>
		
	</table>

   
</div>

<script>
  $(document).on('click','.loadmore',function () {
  $(this).text('Loading...');
 //   var ele = $(this).parent('td');
   // alert(ele);
        $.ajax({
      url: 'xjax/ajax/loadmore_viewclient_review.php',
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
