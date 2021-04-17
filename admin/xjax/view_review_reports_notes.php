<?
if(!isset($_SESSION['review_report_notes']['from_date'])){ $_SESSION['review_report_notes']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['review_report_notes']['to_date'])){ $_SESSION['review_report_notes']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['review_report_notes']['fault_type'])){ $_SESSION['review_report_notes']['fault_type'] = 0; }

//print_r($_SESSION['review_report_notes']);
 
  $resultsPerPage = resultsPerPage;
 // $resultsPerPage = 10;
  $arg = "SELECT * FROM `bcic_review` where 1=1 ";
   //echo 'dsfsd';
	if($_SESSION['review_report_notes']['from_date']  != ''  && $_SESSION['review_report_notes']['to_date'] != '') {
	  $arg .=" AND review_date >= '".date('Y-m-d' ,strtotime($_SESSION['review_report_notes']['from_date']))."' and review_date <='".$_SESSION['review_report_notes']['to_date']."'";
	} 
	
	if(isset($_SESSION['review_report_notes']['job_id'])){
		$arg .=" AND  job_id ='".$_SESSION['review_report_notes']['job_id']."'";
	}
	
	
	if(isset($_SESSION['review_report_notes']['fault_type']) && $_SESSION['review_report_notes']['fault_type'] > 0){
		$arg .=" AND  fault_type ='".$_SESSION['review_report_notes']['fault_type']."'";
	}
	if($_SESSION['review_report_notes']['rating'] != ''){
		$arg .=" AND  overall_experience ='".$_SESSION['review_report_notes']['rating']."'";
	}
	
	if($_SESSION['review_report_notes']['staff_type'] != 0 && $_SESSION['review_report_notes']['staff_id'] == 0){
		$arg .=" and job_id in (SELECT job_id from job_details where staff_id in (SELECT id from staff WHERE better_franchisee = ".$_SESSION['review_report_notes']['staff_type'].")) ";
	}
	
	if($_SESSION['review_report_notes']['staff_id'] != 0){
		$arg .=" AND job_id in (SELECT job_id FROM job_details WHERE staff_id = ".$_SESSION['review_report_notes']['staff_id']." )";
	}
	
	$cond = $arg;
	$arg.=" order by id desc limit 0,$resultsPerPage";
	
	//echo $arg; 
	
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
 .send_review_email_tpl{
		border: 1px solid;
		float: right;
		margin-top: -42px;
		/* margin-right: 204px; */
		padding: 8px;
		background: #00b8d4;
		text-align: center;
		color: white;
		cursor: pointer;
 }
</style>

 <div class="right_text_box">
     <div class="midle_staff_box"> <span class="midle_text">Total Records <?php echo  $countResult; ?> </span></div>
</div>

<!--<span ><a href="#" onclick="printpopup('<?php echo changeDateFormate($_SESSION['review_report_notes']['from_date'] , 'datetime'); ?>' , '<?php echo changeDateFormate($_SESSION['review_report_notes']['to_date'] , 'datetime'); ?>'); return false;"><img src="http://www.granneman.com/files/8313/3079/2922/printFriendly.gif" height="23" width="22" alt="Print-friendly"></a></span>-->

<span class="send_review_email_tpl" onclick="send_data('<?php  echo $_SESSION['review_report_notes']['from_date'].'|'.$_SESSION['review_report_notes']['to_date'].'|'.$_SESSION['review_report_notes']['fault_type']; ?>' , 549 , 'send_review_data');">Send Email</span>

<span id="send_review_data"></span>

<div class="usertable-overflow">
	<table class="user-table" id="reviewTbale">
	  <thead>
	  <tr>
		<th>Job id</th>
		<th>Review Date</th>
		<th>Staff Name</th>
		<th>Client Name</th>
	    <th>Over All Rating</th>
	    <th>Positive feedback</th>
	    <th>Negative feedback</th>
	    <th>Fault</th>
	    <th>Fault Notes</th>
	  </tr>
	  </thead>
	  
	    <tbody id="get_loadmoredata">
			 
			<?php  
			    if(mysql_num_rows($data) > 0) {
			    while($getreviewData = mysql_fetch_assoc($data)) {
					
					$staffdetails = mysql_fetch_assoc(mysql_query("select GROUP_CONCAT(staff_id) as staffid ,  GROUP_CONCAT(job_type) as jobtype , job_date from job_details where job_id=".$getreviewData['job_id']."  and status!=2 order by job_type_id asc"));
					
					$staffdetailsname = mysql_fetch_assoc(mysql_query("select GROUP_CONCAT(name) as sname from staff where id in  (".$staffdetails['staffid'].") order by id asc" ));
					
			?>
				<tr class="parent_tr <?php if(in_array($getreviewData['overall_experience'] , array(4,5))) { echo  'alert_danger_success';  } ?>">
					<td class="pick_row" ><a href="javascript:scrollWindow('client_review_popup.php?task=review&type=<?php echo $getreviewData['job_type']; ?>&job_id=<?php  echo $getreviewData['job_id']; ?>','1200','850')"><?php  echo $getreviewData['job_id']; ?></a></td>
					<td class="pick_row" style="width:2%" ><?php  echo changeDateFormate($getreviewData['review_date']  , 'datetime'); ?></td>
					<td class="pick_row" style="width:3%"><?php echo $staffdetailsname['sname']; ?> <br/><?php // echo $staffdetails['jobtype']; ?></td>
					<td class="pick_row" style="width:3%"><?php  echo $getreviewData['name']; ?></td>
					<td class="pick_row"><?php  echo ($getreviewData['overall_experience']); ?></td>
					<td class="pick_row"  style="width:25%;text-align: justify;" title="<?php //if($getreviewData['positive_comment'] != '') {  echo $getreviewData['positive_comment']; } ?>"><?php if($getreviewData['positive_comment'] != '') {  echo ($getreviewData['positive_comment']); } ?></td>
					<td class="pick_row" style="width:25%;text-align: justify;" title="<?php  //if($getreviewData['negative_comment'] != '') {  echo $getreviewData['negative_comment']; } ?>"><?php if($getreviewData['negative_comment'] != '') {  echo ($getreviewData['negative_comment']); } ?></td>
					
					<td class="pick_row hide_table"> <?php echo create_dd("fault_type","system_dd","id","name","type=97","onChange=\"javascript:edit_field(this,'bcic_review.fault_type','".$getreviewData['id']."');\"",$getreviewData);?></td>
					
					<td class="pick_row hide_table">
					   <?php //if(trim($getreviewData['fault_notes']) != '') { echo  $getreviewData['fault_notes'];  }else {  ?>
					     <textarea id="fault_notes_<? echo $getreviewData['id'];?>" style="text-align: left;" onblur="javascript:edit_field(this,'bcic_review.fault_notes','<? echo $getreviewData['id'];?>');" name="fault_notes" cols="45" rows="7">
					     <? echo  trim($getreviewData['fault_notes']);  //echo get_field_value($getreviewData,"fault_notes");?></textarea>
					 <?php  //}?>
					</td>
					
					
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
 function printpopup(fromdate , todate) {
        var divToPrint=document.getElementById("reviewTbale");
		var htmlToPrint = '' +
        '<style type="text/css">' +
			'table th, table td {' +
			'border:1px solid #000;' +
			'padding:0.5em;' +
			'}' +
        '</style>';
		var newWin = window.open('');
		newWin.document.write('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>Review Notes</title>');
		newWin.document.write('<h2 style="text-align:center;">Review Notes '+fromdate+' To '+todate+'</h2>');
        newWin.document.write(divToPrint.outerHTML);
		 newWin.document.write(htmlToPrint);
		 newWin.document.write(htmlToPrint);
        newWin.print();
        newWin.close();
    }

  $(document).on('click','.loadmore',function () {
  $(this).text('Loading...');
 //   var ele = $(this).parent('td');
   // alert(ele);
        $.ajax({
      url: 'xjax/ajax/loadmore_viewclient_review_notes.php',
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