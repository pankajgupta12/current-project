<?php  
session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

 $get = explode(',', getRole(24));
 $get[count($get)] = 12;

if(isset($_POST['page'])) {
	$pageid = $_POST['page'];
//$resultsPerPage = resultsPerPage;
 $sql = "SELECT R.id as id , R.job_id as Rjobid ,R.re_quote_admin_id as adminid ,  R.est_sqm as est_sqm , R.sqm as sqm , Q.date as quoteDate, Q.booking_date as QjobDate,  (SELECT total_img_before from jobs WHERE jobs.id = Q.booking_id) as beforimg ,   Q.address as address, R.createdOn as createdDate,   (SELECT GROUP_CONCAT(CONCAT('<b>' ,job_type, '</b> => ', description,'<br/>')) as descrp from quote_details WHERE quote_id = R.quote_id  GROUP by quote_id) as descrp,   R.re_quote as re_quote, R.re_quote_status as re_quote_status FROM `re_quoteing` R, quote_new Q WHERE Q.booking_id = R.job_id AND  Q.bbcapp_staff_id = 0 ";


 $falge = FALSE;
if($_SESSION['re_quote']['quote_type'] == 1) {
    $fieldname = ' DATE(Q.date)';
    $falge = TRUE;
}else if($_SESSION['re_quote']['quote_type'] == 2) {
     $fieldname = ' DATE(Q.booking_date) ';
      $falge = TRUE;
} else if($_SESSION['re_quote']['quote_type'] == 3) {
     $fieldname = ' DATE(Q.quote_to_job_date) ';
      $falge = TRUE;
}

if(in_array($_SESSION['admin'], $get)) {  
    $sql .= ' ';
}else{
	$sql .= " AND R.re_quote_admin_id  = '".$_SESSION['admin']."'";
}

 
if($_SESSION['re_quote']['from_date'] != '' && $_SESSION['re_quote']['to_date'] != '' && $falge == TRUE) {
 $sql .= " AND $fieldname >= '".date('Y-m-d', strtotime($_SESSION['re_quote']['from_date']))."' AND $fieldname <= '".date('Y-m-d', strtotime($_SESSION['re_quote']['to_date']))."'";
}

if($_SESSION['re_quote']['re_quote_id'] != '' && $_SESSION['re_quote']['re_quote_id'] > 0) {
 $sql .= " AND R.re_quote = '".$_SESSION['re_quote']['re_quote_id']."'";
}

if($_SESSION['re_quote']['re_quote_status'] != '' && $_SESSION['re_quote']['re_quote_status'] > 0) {
 $sql .= " AND R.re_quote_status = '".$_SESSION['re_quote']['re_quote_status']."'";
}

//$arg = $sql ." order by R.id  desc limit 0,$resultsPerPage";

 //echo $sql;
$sql.=" order by  R.createdOn desc ";
$resultsPerPage = resultsPerPage;
 if($pageid>0){
           $page_limit=$resultsPerPage*($pageid - 1);
           $sql.=" LIMIT  $page_limit , $resultsPerPage";
           }else{
        //  echo 'test11'; die;
        $sql.=" LIMIT 0 , $resultsPerPage";
     }
     
//echo $arg;  die;
$query = mysql_query($sql);
 
  if (mysql_num_rows($query)>0){ 
?>

	  <?php 
	  while($data=mysql_fetch_assoc($query)){ 
  
        ?>
				    
						<tr class="parent_tr" id="<?php echo  $data['id']; ?>">
							 <td class=" "><?php echo $data['id']; ?></td>
							 <td class=" "><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $data['Rjobid']; ?>','1200','850')"><?php echo $data['Rjobid']; ?></a></td>
							 <td class="bc_click_btn pick_row "><?php echo changeDateFormate($data['quoteDate'], 'datetime'); ?></td>
							 <td><?php echo changeDateFormate($data['createdDate'], 'datetime');   ?></td>
							 <td class="bc_click_btn pick_row  "><?php echo changeDateFormate($data['QjobDate'], 'datetime');  ?></td>
							 <td class="bc_click_btn pick_row "  style="width: 44%;"><?php echo $data['descrp']; ?></td>
							 <td class="bc_click_btn pick_row "><?php echo $data['address']; ?></td>
							 <td class=" "><input type="text" name="est_sqm" id="est_sqm_<?php echo  $data['id']; ?>" style="background: white;height: 25px;" value="" onblur="javascript:edit_field(this,'re_quoteing.est_sqm','<?php echo  $data['id']; ?>')"></td>
							 <td class=" "><input type="text" name="sqm" id="sqm_<?php echo  $data['id']; ?>" style="background: white;height: 25px;" value="" onblur="javascript:edit_field(this,'re_quoteing.sqm','<?php echo  $data['id']; ?>')"></td>
							 <td class="bc_click_btn "><?php echo $data['beforimg']; ?></td>
							 <td ><?php echo create_dd("re_quote","system_dd","id","name","type=150","onChange=\"javascript:edit_field(this,'re_quoteing.re_quote','" . $data['id'] . "');\"",$data,'field_id');?></td>
							 <?php  if(in_array($_SESSION['admin'], array(12,17,1,31,66))) {  ?>
							 <td><?php echo create_dd("adminid","admin","id","name","is_call_allow=1 AND status = 1","onChange=\"javascript:edit_field(this,'re_quoteing.re_quote_admin_id','" . $data['id'] . "');\"",$data,'field_id');?></td>
							 <?php  }else { ?>
							 <td class="bc_click_btn "><?php echo get_rs_value('admin','name' ,$data['adminid']); ?></td>
							 <?php  } ?>
							 <td><?php echo create_dd("re_quote_status","system_dd","id","name","type=149","onChange=\"javascript:edit_field(this,'re_quoteing.re_quote_status','" . $data['id'] . "');\"",$data,'field_id');?></td>
							 
						</tr> 
            		<? } ?>
                    <tr>
                        <td colspan="30" class="load_more"><button class="loadmore" data-page="<?php echo  $pageid+1 ;?>">Load More</button></td>
                    </tr>
            <?php } else{ ?> 
               <tr><td colspan="30" >No Quotes Found</td></tr>
            <?php } } ?>