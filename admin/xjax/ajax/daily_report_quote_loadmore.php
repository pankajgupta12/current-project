<?php 
session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

if(isset($_POST['page'])) {
	$pageid = $_POST['page'];
	
//$arg = "select * from quote_new where deleted=0 and status=0 ";
$arg = "select * from quote_new where 1=1";

if($_SESSION['quote']['status']!=""){ 
	$arg.= " AND status='".mysql_real_escape_string($_SESSION['quote']['status'])."'";
	$cond.= " AND status='".mysql_real_escape_string($_SESSION['quote']['status'])."'";
}


if($_SESSION['quote']['date']!=""){ 
	$arg.= " AND date='".mysql_real_escape_string($_SESSION['quote']['date'])."'";
	$cond.= " AND date='".mysql_real_escape_string($_SESSION['quote']['date'])."'";
}

if($_SESSION['quote']['site_id']!=""){ 
	$arg.= " AND site_id=".mysql_real_escape_string($_SESSION['quote']['site_id'])." ";
	$cond.= " AND site_id=".mysql_real_escape_string($_SESSION['quote']['site_id'])." ";
}

//$cond.=' AND status = 0 ';
$arg.="  order by id desc ";
$resultsPerPage = resultsPerPage;
 if($pageid>0){
     //   echo 'test'; die;
          // $page_limit=$resultsPerPage*($pageid-1);
           $page_limit=$resultsPerPage*($pageid - 1);
           $arg.=" LIMIT  $page_limit , $resultsPerPage";
           }else{
        //  echo 'test11'; die;
        $arg.=" LIMIT 0 , $resultsPerPage";
     }
     
//echo $arg;  die;
$data = mysql_query($arg);

if (mysql_num_rows($data)>0){ 
?>

	  <?php 
	  $counter = 1;
	  while($r=mysql_fetch_assoc($data)){ 
	      $counter++;
            $bgcolor = ($counter % 2 === 0) ? 'alert_even_tr' : 'alert_odd_tr';
	  // echo "<pre>";  print_r($r);
	      
	      
			$quote_details = mysql_query("select * from quote_details where quote_id=".$r['id']);
			   
			      //  $rQdetails = mysql_fetch_array(mysql_query("select * from quote_details where id=".$quote_details['id'].""));
                      //print_r($rQdetails);
                    //  $desc1 = create_memberquote_desc_str($rQdetails);
                     // mysql_query("update quote_details set description='".$desc1."' where id=".$quote_details['id']."");
			   
		$startDatehours  = date('Y-m-d H:i:s');
        $endDatehours = $r['createdOn'];
        $minutes = round((strtotime($startDatehours) - strtotime($endDatehours))/60, 2);
        
         if($r['deleted'] == 1) {    
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
			<td id="getstatus"><?php if($r['deleted'] == 1) { echo "Delete"; }else { echo getSystemDDname($r['step'],31); } ?></td>     
		</tr>
	  
	  <? } ?>
	       <tr>
	         <td colspan="20" class="load_more"><button class="loadmore" data-page="<?php echo  $pageid+1 ;?>">Load More</button></td>
	      </tr>
    <?php } else{ ?> 
 	  <tr><td colspan="18" >No Quotes Found</td></tr>
	<?php } } ?>