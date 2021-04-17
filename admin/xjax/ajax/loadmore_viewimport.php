<?
//print_r($_POST); die;
 session_start();
  include("../../source/functions/functions.php");
  include("../../source/functions/config.php");
   if(isset($_POST['page'])) {	
   
	$resultsPerPage = resultsPerPage;
	 $pageid = $_POST['page'];
	//$_SESSION['import_id'] = $_GET['import_id'];
	 $arg = "select * from c3cx_calls 
	WHERE 1=1 AND c3cx_calls.import_id = '".$_SESSION['import_id']."'
	";	
	
    $arg .=" ORDER BY c3cx_calls.id Desc ";
	 if($pageid > 0)
        {
            $page_limit=$resultsPerPage*($pageid - 1);
            $arg.=" LIMIT  $page_limit , $resultsPerPage";
        }
        else
        {	
           $arg.=" LIMIT 0 , $resultsPerPage";
        }
		$arg;
 // echo $arg; die;
$query = mysql_query($arg);
//rows count
//$countResult = mysql_num_rows( $query );

	   if(mysql_num_rows( $query ) > 0) { 
		  while( $r = mysql_fetch_assoc( $query ) )
		   { 
         
	  ?>
		<tr  class="parent_tr" id="deletecall_import_<? echo $r['id'];?>">
		
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
		   <td class="bc_click_btn">
			  <input type="text" name="quote_id" value="<?php echo $r['quote_id']; ?>" onkeypress="return isNumberKey(event)"  onblur="update_incall(this.value,'<?php echo $r['id']; ?>|quote_id','quote_id_<?php echo $r['id']; ?>')" value="<? if( $r['quote_id'] !== '' ){ echo $r['quote_id']; } else { echo '--'; }?>" id="quote_id_<?php echo $r['id']; ?>">
			 
				<? //echo $r['quote_id'];?>
			</td>
			<td class="bc_click_btn">
			<input type="text" name="job_id" value="<?php echo $r['job_id']; ?>"  onkeypress="return isNumberKey(event)"  onblur="update_incall(this.value,'<?php echo $r['id']; ?>|job_id','job_id_<?php echo $r['id']; ?>')" value="<? if($r['job_id'] !== ''){echo $r['job_id'];}else{ echo '--'; }?>" id="job_id_<?php echo $r['id']; ?>">
				<?// echo $r['job_id'];?>
			</td>
			<td class="bc_click_btn">
			  <input name="staff_id" type="text" placeholder="" class="input_search" id="staff_details_id_<?php  echo $r['id']; ?>" onKeyup="javascript:get_staffname(this,'staff_id_<?php  echo $r['id']; ?>','<?php  echo $r['id']; ?>')" autocomplete="off" value="<? if($r['staff_id'] !== '0'){echo get_rs_value("staff","name",$r['staff_id']);} ?>" />
			  <div class="clear"></div>
			  <div class="postcode_div_12" id="staff_id_<?php  echo $r['id']; ?>" style="display:none;"></div>
				<? // echo $r['staff_id'];?>
			</td>
			<td class="bc_click_btn">
			<? if($r['admin_id'] !== '0'){echo get_rs_value("c3cx_users","3cx_user_name",$r['admin_id']);} ?>
				<? // echo $r['admin_id'];?>
			</td>
			<!--<td class="bc_click_btn">
				<? echo $r['comments'];?>
			</td>-->
			<td class="bc_click_btn <?php if($r['comment_status'] == 1){ echo "alert-success";}  ?>" id="hide_call_reasons_<?php  echo $r['id']; ?>" ><textarea name="reasons" onblur="update_incall(this.value,'<?php echo $r['id']; ?>|comments','reasons_<?php echo $r['id']; ?>')" id="reasons_<?php echo $r['id']; ?>"><? echo $r['comments'];?></textarea><? //echo $r['comments'];?></td>
			
			<td class="bc_click_btn"><input type="checkbox" name="c32" Onclick="return call_c3cx('<?php echo $r['id']; ?>','deletecall_import_<?php echo $r['id']; ?>');"  <?php if($r['approved_status'] == 1) { echo "checked";} ?> value="<?php  echo $r['id']; ?>"><p id="call_message_<?php  echo $r['id']; ?>"></p></td>
			
		</tr> 
	   <? }?>
		 <tr class="load_more">
	         <td colspan="18"><button class="loadmore" data-page="<?php echo  $pageid+1 ;?>">Load More</button></td>
	      </tr>
	 <?php  } else { ?>         <tr><td colspan="20">No Records Found</td></tr>
	 <?php  } } ?>
		