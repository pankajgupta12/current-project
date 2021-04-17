<?php 
	session_start();
	include("../../source/functions/functions.php");
	include("../../source/functions/config.php");

	if(isset($_POST['page'])) {
		$pageid = $_POST['page'];
		
	$arg = "SELECT * FROM `c3cx_calls` where 1=1 ";

	if($_SESSION['call_report']['date'] !=""){ 
		$arg.= " AND call_date='".mysql_real_escape_string($_SESSION['call_report']['date'])."'";
		//$cond.= " AND call_date='".mysql_real_escape_string($_SESSION['call_report']['date'])."'";
	}

	if($_SESSION['call_report']['admin_id']!=""){ 
	    $fromname = get_rs_value("c3cx_users","3cx_user_name",$_SESSION['call_report']['admin_id']);
		$arg.= " AND admin_id=".mysql_real_escape_string($_SESSION['call_report']['admin_id'])." ";
		//$cond.= " AND admin_id=".mysql_real_escape_string($_SESSION['call_report']['admin_id'])." ";
    }
    
    if($_SESSION['call_report']['from_to'] == 1){ 
     $arg.= " AND from_type='".mysql_real_escape_string($fromname)."'";
    }
    
    if($_SESSION['call_report']['from_to'] == 2){ 
    //$fromname = get_rs_value("c3cx_users","3cx_user_name",$_SESSION['call_report']['admin_id']);
      $arg.= " AND to_type='".mysql_real_escape_string($fromname)."'";
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
	//	echo $arg;  die;
		$data = mysql_query($arg);
		$countResult = mysql_num_rows($data);
?>

			  <?php 
				  $class = '';
				if( $countResult > 0 )
			   {
				 $counter = 0;
			  while( $r = mysql_fetch_assoc( $data ) )
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
	       <tr>
	         <td colspan="20" class="load_more"><button class="loadmore" data-page="<?php echo  $pageid+1 ;?>">Load More</button></td>
	      </tr>
        <?php } else{ ?> 
 	     <tr><td colspan="18" >No result Found</td></tr>
<?php } } ?>