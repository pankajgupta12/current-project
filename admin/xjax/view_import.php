
<script>
  $( function() {
    $( "#date" ).datepicker();
  } );
  
  </script>
<!-------Menu-------> 
<script>

$(document).on('click','.loadmore',function () {
  $(this).text('Loading...');
 //   var ele = $(this).parent('td');
   // alert(ele);
        $.ajax({
      url: 'xjax/ajax/loadmore_view_import.php',
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
   //unset($_SESSION['c3cx_rowCount']);
	/* if( isset($_SESSION['c3cx_rowCount']) && $_SESSION['c3cx_rowCount'] != '')
	{
	  $resultsPerPage = $_SESSION['c3cx_rowCount'];
	}else{
	  $resultsPerPage = resultsPerPage;
	}  */
	
	$resultsPerPage = resultsPerPage;
	$importName = $_SESSION['import_name'];
	$dateFlag = false;

 /*$arg = "select * from 3cx_calls , 3cx_calls_details 
	WHERE 1=1 
	AND  ( 3cx_calls.id = 3cx_calls_details.calls_id
	AND  3cx_calls.import_name = '{$importName}'
	AND 3cx_calls_details.import_name = '{$importName}' ) 
	ORDER BY 3cx_calls.id ASC 
	LIMIT 0, 250";*/

   $arg = "select * from c3cx_calls 
	WHERE 1=1 
	";	
	if($_SESSION['call']['admin'] != '') {
	 $arg .= " AND c3cx_calls.from_type = '".$_SESSION['call']['admin']."'";
	 $cond .= " AND c3cx_calls.from_type = '".$_SESSION['call']['admin']."'";
	}
	
	//column_name BETWEEN value1 AND value2;
	if($_SESSION['call']['from_date'] != '' && $_SESSION['call']['to_date'] !='') {
		$arg .= " AND c3cx_calls.call_date BETWEEN '".$_SESSION['call']['from_date']."' AND '".$_SESSION['call']['to_date']."'";
		$cond .= " AND c3cx_calls.call_date BETWEEN '".$_SESSION['call']['from_date']."' AND '".$_SESSION['call']['to_date']."'";
	 $dateFlag = true;
	}
	
	if($_SESSION['call']['from_date'] != '' && $dateFlag == false) {
	 $arg .= " AND c3cx_calls.call_date = '".$_SESSION['call']['from_date']."'";
	 $cond .= " AND c3cx_calls.call_date = '".$_SESSION['call']['from_date']."'";
	}
	
	if($_SESSION['call']['to_date'] != ''  && $dateFlag == false) {
	  $arg .= " AND c3cx_calls.call_date = '".$_SESSION['call']['to_date']."'";
	  $cond .= " AND c3cx_calls.call_date = '".$_SESSION['call']['to_date']."'";
	}
	
	if($_SESSION['call']['quote_job_id'] != '') {
	  $arg .= " AND ( c3cx_calls.quote_id = '".$_SESSION['call']['quote_job_id']."' OR c3cx_calls.job_id = '".$_SESSION['call']['quote_job_id']."' )";
	  $cond .= " AND ( c3cx_calls.quote_id = '".$_SESSION['call']['quote_job_id']."' OR c3cx_calls.job_id = '".$_SESSION['call']['quote_job_id']."' )";
	}
	 $cond .= " AND c3cx_calls.approved_status = 0";
     $arg .=" AND c3cx_calls.approved_status = 0 ORDER BY c3cx_calls.id DESC 
    	LIMIT 0, $resultsPerPage";
 //echo $arg;		
$query = mysql_query($arg);

//rows count
$countResult = mysql_num_rows( $query );


?>
		<div class="right_text_box" style="margin-top: -42px;">
		 
		  <div class="midle_staff_box"> <span class="midle_text">Total Records Found <?php getTotalRecords('c3cx_calls',$cond); ?> </span></div>
		</div>
<link href="../admin/css/general.css" rel="stylesheet" type="text/css">

<style>
  .bc_click_btn.alert-danger {
    background-color: #f2dede;
    border-color: #ebccd1;
    color: #a94442;
}

tr.alert_danger_tr td{
	background-color: #f2dede;
    border-color: #ebccd1;
    color: #a94442;
}

tr td.alert_danger_tr{
	background-color: #f2dede;
    border-color: #ebccd1;
    color: #a94442;
}

</style>


<div class="usertable-overflow" id="usertable-overflow">	
	<table class="user-table" id="count_table_row">
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
		<th>Done</th>
	  </tr>
	  </thead>
	  <tbody id="get_loadmoredata">
	  <?php $class = '';
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
			
			<!-- quote id -->
			<td class="bc_click_btn <?php if($r['quote_status'] == 1){ echo "alert-success";}  ?>" id="hide_call_quoteid_<?php  echo $r['id']; ?>"><? //if( $r['quote_id'] !== '' ){ echo $r['quote_id']; } else { echo '--'; }?>
			  <input type="text" name="quote_id" value="<?php echo $r['quote_id']; ?>" onkeypress="return isNumberKey(event)"  onblur="update_incall(this.value,'<?php echo $r['id']; ?>|quote_id','quote_id_<?php echo $r['id']; ?>')" value="<? if( $r['quote_id'] !== '' ){ echo $r['quote_id']; } else { echo '--'; }?>" id="quote_id_<?php echo $r['id']; ?>">
			</td>
			
			<!-- job id -->
			<td class="bc_click_btn <?php if($r['job_status'] == 1){ echo "alert-success";}  ?>" id="hide_call_jobid_<?php  echo $r['id']; ?>">
			  <input type="text" name="job_id" value="<?php echo $r['job_id']; ?>"  onkeypress="return isNumberKey(event)"  onblur="update_incall(this.value,'<?php echo $r['id']; ?>|job_id','job_id_<?php echo $r['id']; ?>')" value="<? if($r['job_id'] !== ''){echo $r['job_id'];}else{ echo '--'; }?>" id="job_id_<?php echo $r['id']; ?>">
			</td>
		
			<td class="bc_click_btn" >
			  <input name="staff_id" type="text" placeholder="" class="input_search" id="staff_details_id_<?php  echo $r['id']; ?>" onKeyup="javascript:get_staffname(this,'staff_id_<?php  echo $r['id']; ?>','<?php  echo $r['id']; ?>')" autocomplete="off" value="<? if($r['staff_id'] !== '0'){echo get_rs_value("staff","name",$r['staff_id']);} ?>" />
			  <div class="clear"></div>
			  <div class="postcode_div_12" id="staff_id_<?php  echo $r['id']; ?>" style="display:none;"><div>
			</td>
			
			<td class="bc_click_btn" >
			  <!--<input name="admin_id" type="text" placeholder="" class="input_search" id="admin_id_id_<?php  echo $r['id']; ?>" autocomplete="off" value="<? if($r['admin_id'] !== '0'){echo get_rs_value("c3cx_users","3cx_user_name",$r['admin_id']);} ?>" />-->
                <? if($r['admin_id'] !== '0'){echo get_rs_value("c3cx_users","3cx_user_name",$r['admin_id']);} ?>			  
			</td>
			
			<!-- job id -->
			<td class="bc_click_btn <?php if($r['comment_status'] == 1){ echo "alert-success";}  ?>" id="hide_call_reasons_<?php  echo $r['id']; ?>" ><textarea name="reasons" onblur="update_incall(this.value,'<?php echo $r['id']; ?>|comments','reasons_<?php echo $r['id']; ?>')" id="reasons_<?php echo $r['id']; ?>"><? echo $r['comments'];?></textarea><? //echo $r['comments'];?></td>
			<!--<td class="bc_click_btn" ><a  style="cursor: pointer;" title="DELETE" Onclick="return call_c3cx('<?php echo $r['id']; ?>','deletecall_import_<?php echo $r['id']; ?>');" class="file_icon"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>-->
			<td class="bc_click_btn"><input type="checkbox" name="c32" Onclick="return call_c3cx('<?php echo $r['id']; ?>','deletecall_import_<?php echo $r['id']; ?>');"  value="<?php  echo $r['id']; ?>"></td>
		</tr>
	  <? }?>
	  
		<?php if($countResult >= $resultsPerPage) { ?>
	       <tr class="load_more">
	         <td colspan="18"><button class="loadmore" data-page="2" >Load More</button></td>
	      </tr>
		<?php  } ?> 
		<?php }else{ ?>  
            <tr><td colspan="20">No Import Found</td></tr>
		<?php  } ?>
    </tbody>		
	</table>
</div>


<style>
 #container{width: 80%;margin: auto auto;}
.news_list {
list-style: none;
}
.input_field{
	padding: 16px;
    width: 148px;
}

 .loadbutton{
    text-align: center;
}
</style>