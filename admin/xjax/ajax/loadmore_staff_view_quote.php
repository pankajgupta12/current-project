<?php 
session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

if(isset($_POST['page'])) {
	$pageid = $_POST['page'];
	
//$arg = "select * from quote_new where deleted=0 and status=0 ";
$arg = "select * from quote_new where 1=1 AND step != 10 AND bbcapp_staff_id != 0";

if(isset($_SESSION['view_quote_action']))
{ 
	
	if($_SESSION['view_quote_action']=="1")
	{
		
		$arg .= ' AND deleted=0 and status=0';
		
		if( (isset( $_SESSION['view_quote_keyword'] ) && $_SESSION['view_quote_keyword'] != '') && $_SESSION['view_quote_field'] == 'step' )
		{
			$arg.= " and ( amount ='' OR amount = 0) and step ={$_SESSION['view_quote_keyword']} ";	
		}
		else
		{
			$arg.= " and step ='1' ";
		}
	}
	else if($_SESSION['view_quote_action'] =="2")
	{
		
		$arg .= ' AND deleted=0 and status=0';
		
		if( (isset( $_SESSION['view_quote_keyword'] ) && $_SESSION['view_quote_keyword'] != '') && $_SESSION['view_quote_field'] == 'step' )
		{
			$arg.= " and step ={$_SESSION['view_quote_keyword']} ";	
		}
		else		
		{
			$arg.= " and step ='2' ";
		}
	}
	else if($_SESSION['view_quote_action'] =="3")
	{
		$arg .= ' AND deleted=0 and status=1';
		//$arg.= " and step='4' "; //today change
	}
	else if($_SESSION['view_quote_action'] =="4")
	{
		$arg .= " AND deleted=0  AND step = '3' ";
	}
	else if($_SESSION['view_quote_action'] =="9")
	{
		$arg .= " AND deleted=0 and status=1 AND step = '4' ";
	
	}
	else if($_SESSION['view_quote_action'] =="5")
	{
		//$arg .= ' AND deleted=0 and status=0';
		$arg.= " AND step = '5' ";	
		
	}else if($_SESSION['view_quote_action'] =="6")
	{
		//$arg .= ' AND deleted=0 and status=0';
		$arg.= " AND step = '6' ";	
		
	}
	else if($_SESSION['view_quote_action'] =="7")
	{
		//$arg .= ' AND deleted=0 and status=0';
		$arg.= " AND   login_id ='".$_SESSION['admin']."' ";
		
	}
	else if($_SESSION['view_quote_action'] =="8")
	{
		//$arg .= ' AND deleted=0 and status=0';
		$arg.= " AND   deleted = 1 ";
		
	}
	//https://beta.bcic.com.au
}
if(($_SESSION['view_quote_field']!="") && ($_SESSION['view_quote_keyword']!="")){
	$arg.= " and ".$_SESSION['view_quote_field']." like '%".$_SESSION['view_quote_keyword']."%'";
}

if($_SESSION['site_id']!=""){ 
	$arg.= " and site_id=".mysql_real_escape_string($_SESSION['site_id'])." ";
}

    if(count($_SESSION['view_quote_aSearching']) > 0 )
		{
			foreach($_SESSION['view_quote_aSearching'] as $key=>$value){
				if($value != '') {
					
					
					if(($key == 'second_called_date' || $key == 'seven_called_date' ||  $key == 'called_date' )) {
						
						$date = '0000-00-00 00:00:00';
						
						if($value == 1)
						{
						  $arg.= " AND   ".$key."  != '".$date."'";
						}else{
						   $arg.= " AND   ".$key."  = '".$date."'";
						}
						
					}else {
							if($key == 'quote_for' || $key == 'job_ref' || $key == 'site_id' || $key == 'step' ||  $key == 'response'  || $key == 'login_id' || $key == 'real_estate_id'|| $key == 'have_removal' || $key == 'production_id') { 
							    
							    if($key == 'response') {
						        
    						   $arg.= " AND   ".$key."  = '".$value."' AND booking_id = 0 ";
    						  // $condcount.= " AND   ".$key."  = '".$value."'  AND booking_id = 0  ";
    						   
						       }else{
						         $arg.= " AND   ".$key."  = '".$value."'";
    						   //$condcount.= " AND   ".$key."  = '".$value."'";
						       }
							    
						   // $arg.= " AND   ".$key."  = '".$value."'";
						}
					}
				  
				  
				}
			}
			
			
			if($_SESSION['view_quote_aSearching']['from_date'] != '' && $_SESSION['view_quote_aSearching']['to_date']) {
			
					if($_SESSION['view_quote_aSearching']['quote_type'] == 1) {
						
						  $arg.= " AND date >= '".$_SESSION['view_quote_aSearching']['from_date']."' and date <= '".$_SESSION['view_quote_aSearching']['to_date']."'";
						  
						  
					}elseif($_SESSION['view_quote_aSearching']['quote_type'] == 2) {
						   
						   $arg.= " AND  booking_date >= '".$_SESSION['view_quote_aSearching']['from_date']."' and booking_date <= '".$_SESSION['view_quote_aSearching']['to_date']."'";
						   
					}elseif($_SESSION['view_quote_aSearching']['quote_type'] == 3) {
						   
						   $arg.= " AND  quote_to_job_date  >= '".$_SESSION['view_quote_aSearching']['from_date']."' and quote_to_job_date  <= '".$_SESSION['view_quote_aSearching']['to_date']."'";
					}		
			}
		}	
		       
		       if($_SESSION['view_quote_aSearching_job_type']['job_type'] == 1) {
					//$arg.=  " AND id in (SELECT quote_id from quote_details WHERE job_type_id != 11 )";
					$arg.=  " AND moving_from = '' AND is_flour_from = 0 AND is_lift_from = 0 ";
					 
				}else if($_SESSION['view_quote_aSearching_job_type']['job_type'] == 2) {
				    $arg.=  " AND id in (SELECT quote_id from quote_details WHERE job_type_id = 11 )";
				 
				}else if($_SESSION['view_quote_aSearching_job_type']['job_type'] == 3) {
				    $arg.=  " AND real_estate_id != 0";
				 
				}					
			
			

$arg.=" order by id desc ";


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

$jobIcone =  jobIcone();

	 $today = date('Y-m-d');
	$getphone =  CheckDoublephoneNumber($today);

if (mysql_num_rows($data)>0){ 
?>

	  <?php 
	  while($r=mysql_fetch_assoc($data)){ 
	      
		    $icondata = GetQuoteDetailsIconData($r['booking_id'] , $r['id']);
		    $tr_removal = $icondata['tr_removal'];
			   
		$startDatehours  = date('Y-m-d H:i:s');
        $endDatehours = $r['createdOn'];
        $minutes = round((strtotime($startDatehours) - strtotime($endDatehours))/60, 2);
        
         if($r['deleted'] == 1) {    
                //$style1 =  'opacity:0.4;pointer-events: none;';
                $style1 =  '';
            }else {
               $style1 =  '';
            }
			
			 $bbcapp_staff_id = $r['bbcapp_staff_id'];	
			
		 $siteDetails = mysql_fetch_array(mysql_query("Select name ,abv,area_code , br_area_code from sites where id = ".$r['site_id'].""));	
        
	  ?>
         <tr class="parent_tr <?php  if((in_array($r['phone'] , $getphone) || in_array($r['email'] , $getphone)) && $r['booking_id'] == 0 ) { echo " alert_duplicate_danger_tr"; }else { if($r['booking_id'] != 0 ) { echo " alert_danger_success";} else if($r['step'] == 5 || $r['step'] == 6 || $r['step'] == 7 || $r['deleted'] == 1) { echo ' alert_danger_tr'; }else if($r['response'] == '3') { echo 'alert_warning'; } }  ?> ">
			<td class="bc_click_btn pick_row <?php if($_SESSION['view_quote_field'] == 'id'){ echo "search_field_value"; } ?>"><? echo $r['id'];?></td>
			
			<td class="pick_row">
			<?php if($r['booking_id'] != '0') { ?>
			    <a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $r['booking_id']; ?>','1200','850')"><?  echo $r['booking_id']; ?></a>	
			<?php  } else {echo "-";} ?>
            </td>
			<td class="bc_click_btn pick_row "><?  echo get_rs_value("quote_for_option","name",$r['quote_for']);?></td>
			
			<!--<td class="bc_click_btn pick_row "><?php if($r['real_estate_id'] > 0) { echo get_rs_value("real_estate_agent","name",$r['real_estate_id']); } ?></td>-->
			
			<td class="bc_click_btn"><? echo get_rs_value("sites","abv",$r['site_id']);?></td>
			<td class="bc_click_btn" title="<?php //if($r['job_ref'] == 'Crm') {  echo get_rs_value("admin","company_name",$r['login_id']);  }else { if($r['job_ref'] != '0') { echo $r['job_ref']; } } ?>"><img class="image_icone" src="icones/ref/<?php echo getRefIcons($r['job_ref']); ?>" alt="<?php echo $r['job_ref']; ?>"></td>
			<td class="bc_click_btn <?php if($_SESSION['view_quote_field'] == 'date'){ echo "search_field_value"; } ?>" title="<? echo changeDateFormate($r['date'],'datetime'); ?>"><? echo changeDateFormate($r['date'],'dm'); ?></td>
				<?php  if($r['step'] == 1) { $class = ' alert-danger';  if($minutes > 15) { $class = ' alert-danger';  if( $r['check_sms_initial'] == 0 )  { $msgstatus = ''; $class = ' alert-danger';    }else{$msgstatus = 'Sent'; $class = '';  }   ?>
		    	<td class="bc_click_btn <?php print $class; ?>"><? echo date('h:iA',strtotime($r['createdOn'])). '<br />' . $msgstatus; ?></td>
			<?php  }else { ?>
			    <td class="bc_click_btn"><? echo date('h:iA',strtotime($r['createdOn'])); ?></td>
			    <?php } }else { ?>
		    	<td class="bc_click_btn"><? echo date('h:iA',strtotime($r['createdOn'])); ?></td>
			<?php  } ?>
			<td class="bc_click_btn <?php if($_SESSION['view_quote_field'] == 'name'){ echo "search_field_value"; } ?>"><? echo $r['name'];?></td>
			<td class="bc_click_btn <?php if($_SESSION['view_quote_field'] == 'email'){ echo "search_field_value"; } ?>" title="<? echo $r['email'];?>"><a href="mailto:<? echo $r['email'];?>"><? echo substr($r['email'], 0, 10)."...";?></a></td>
			
			<td class="bc_click_btn <?php if($_SESSION['view_quote_field'] == 'phone'){ echo "search_field_value"; } ?>">
			<a href="tel:<?php if($tr_removal > 0){ echo $siteDetails['br_area_code'].$r['phone'];}else{ echo $siteDetails['area_code'].$r['quote_for'].$r['phone'];}?>">
				<? echo $r['phone']; //substr($r['phone'] ,0 ,6 ).'XXXX';?>
			</a>
			</td>
			
			<td class="bc_click_btn"><a title="<?php echo $r['address']; ?>"><? echo $r['suburb'];?></a></td>
			<td class="bc_click_btn" style="width: 90px;">
			  <?   
			        foreach($icondata['icondetais'] as $jobtypeid=>$jobtype) {
			         $job_icon =  $jobIcone[$jobtype['job_type_id']];
			  ?>
					
					<img class="image_icone" src="icones/job_type32/<?php echo $job_icon." "; ?>" alt="<?php echo $jobtype['job_type']." "; ?>" title="<?php echo $jobtype['job_type']." "; ?>">
					
				 <?php  }  ?>
			</td>
			<td class="bc_click_btn <?php if($_SESSION['view_quote_field'] == 'booking_date'){ echo "search_field_value"; } ?>" title="<? if($r['booking_date']!="0000-00-00"){ echo changeDateFormate($r['booking_date'],'datetime'); } ?>"><? if($r['booking_date']!="0000-00-00"){ echo changeDateFormate($r['booking_date'],'dm'); } ?>
			</td>
			<td class="bc_click_btn" title="<? echo changeDateFormate($r['sms_quote_date'],'datetime'); ?>" id="quote_sms_<?=$r['id']?>"><? if($r['sms_quote_date']!="0000-00-00"){ echo changeDateFormate($r['sms_quote_date'],'dm'); } ?></td>
			
			<td class="bc_click_btn" ><? if($r['emailed_client']!="0000-00-00 00:00:00"){ echo date("d/m H:i",strtotime($r['emailed_client'])); }?></td>
			<td class="bc_click_btn" >$<? echo $r['amount'];?></td>
			<td class="bc_click_btn" id="quote_called_<?=$r['id']?>"><? if($r['called_date']!="0000-00-00 00:00:00"){ echo date("d/m H:i",strtotime($r['called_date'])); } else { echo "-"; }?></td>
			<td class="bc_click_btn" id="quote_called_<?=$r['id']?>"><? if($r['second_called_date']!="0000-00-00 00:00:00"){ echo date("d/m H:i",strtotime($r['second_called_date'])); } else { echo "-"; }?></td>
			<td class="bc_click_btn" id="quote_called_<?=$r['id']?>"><? if($r['seven_called_date']!="0000-00-00 00:00:00"){ echo date("d/m H:i",strtotime($r['seven_called_date'])); } else { echo "-"; }?></td>
			
			<td id="getstatus">
			  <?php 
			     echo create_dd("step","system_dd","id","name","type=31","Onchange=\"return view_quote_status_change(this.value,".$r['id']." , 1);\"",$r);
           
					if($r['step'] == 6) {
					  echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=91","Onchange=\"return view_quote_admin_denied(this.value,".$r['id'].");\"",$r);
					}else if($r['step'] == 5){
						echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=93","Onchange=\"return view_quote_admin_denied(this.value,".$r['id'].");\"",$r);
					}else if($r['step'] == 7){
						echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=94","Onchange=\"return view_quote_admin_denied(this.value,".$r['id'].");\"",$r);
					}
			?>
			</td>	
			
		
			
            <td class="bc_click_btn" ><?  if($r['bbcapp_staff_id'] != 0) { echo get_rs_value("staff","name",$r['bbcapp_staff_id']); }else { echo "N/A"; }?></td>	
           	
			<td class="bc_click_btn" ><?  if($r['login_id'] != 0) { echo get_rs_value("admin","name",$r['login_id']); }else { echo "N/A"; }?></td>
		</tr>
	  <? } ?>
	       <tr>
	         <td colspan="30" class="load_more"><button class="loadmore" data-page="<?php echo  $pageid+1 ;?>">Load More</button></td>
	      </tr>
    <?php } else{ ?> 
 	  <tr><td colspan="30" >No Quotes Found</td></tr>
	<?php } } ?>
	<style>
		#navigation li 
		{
		display: inline;
		list-style: none;
		}
		#navigation li a, #navigation li a:link, #navigation li a:visited
		{
		display: block;
		padding: 2px 5px 2px 5px;
		float: left;
		margin: 0 5px 0 0;
		}
	</style>