<?php 
session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

if(isset($_POST['page'])) {
	$pageid = $_POST['page'];
	
//$arg = "select * from quote_new where deleted=0 and status=0 ";
  $arg = "SELECT * FROM `bcic_review` where 1=1 ";
  
  if($_SESSION['client_review']['from_date']  != ''  && $_SESSION['client_review']['to_date'] != '') {
	   $arg .=" AND review_date>= '".date('Y-m-d' ,strtotime($_SESSION['client_review']['from_date']))."' and review_date <='".$_SESSION['client_review']['to_date']."'";
	} 
	
	if(isset($_SESSION['client_review']['job_id'])){
		$arg .=" AND  job_id ='".$_SESSION['client_review']['job_id']."'";
	}
	
	$arg.=" order by id desc ";
	
 $resultsPerPage = resultsPerPage;
//$resultsPerPage = 10;
 if($pageid>0){
     //   echo 'test'; die;
          // $page_limit=$resultsPerPage*($pageid-1);
           $page_limit=$resultsPerPage*($pageid - 1);
           $arg.=" LIMIT  $page_limit , $resultsPerPage";
           }else{
        //  echo 'test11'; die;
        $arg.=" LIMIT 0 , $resultsPerPage";
     }
     
//echo $arg;  
$data = mysql_query($arg);	
if (mysql_num_rows($data)>0){ 

	 while($getreviewData = mysql_fetch_assoc($data)) { 
	 
	  //$job_details = mysql_query("select * from job_details where job_id=".$getreviewData['job_id']." and status!=2");
					$staffdetails = mysql_fetch_assoc(mysql_query("select GROUP_CONCAT(staff_id) as staffid ,  GROUP_CONCAT(job_type) as jobtype , job_date from job_details where job_id=".$getreviewData['job_id']."  and status!=2 order by job_type_id asc"));
					
					$staffdetailsname = mysql_fetch_assoc(mysql_query("select GROUP_CONCAT(name) as sname from staff where id in  (".$staffdetails['staffid'].") order by id asc" ));
	  
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
					<!--<td class="pick_row"><?php //if($getreviewData['job_type'] == '1') { echo "Job";}else{ echo "Re-Clean";} ?></td>-->
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
				</tr>
			<? } ?>
	       <tr>
	         <td colspan="25" class="load_more"><button class="loadmore" data-page="<?php echo  $pageid+1 ;?>">Load More</button></td>
	      </tr>
    <?php } else{ ?> 
 	  <tr><td colspan="25" >No review Found</td></tr>
	<?php } } ?>	