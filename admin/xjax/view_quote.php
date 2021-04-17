
<!-------Menu-------> 
<script>

 
function uncheck() {
	  $('.user-table tbody td').css('background-color',''); 
	  $( ".bc_click" ).prop( "checked" , false );
}

$(document).on('click','.loadmore',function () {
  $(this).text('Loading...');
        $.ajax({
      url: 'xjax/ajax/loadmore_viewquote.php',
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
$arg = "select * from quote_new where 1=1 AND step != 10 AND bbcapp_staff_id = 0";

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
				$arg.= " and  step ='1' "; 
				
			}
		}
		else if($_SESSION['view_quote_action'] =="2")
		{
			$arg .= ' AND deleted=0 and status=0';
		//	$condcount .= ' AND deleted=0 and status=0';
			
			if( (isset( $_SESSION['view_quote_keyword'] ) && $_SESSION['view_quote_keyword'] != '') && $_SESSION['view_quote_field'] == 'step' )
			{
				$arg.= " and step ={$_SESSION['view_quote_keyword']} ";	
			}
			else		
			{
				$arg.= " AND step ='2' ";
			}
		}
		else if($_SESSION['view_quote_action'] =="3")	{	$arg .= ' AND deleted=0 and status=1';	}
		else if($_SESSION['view_quote_action'] =="4")	{	$arg .= " AND deleted=0 and status=0 AND step = '3' ";}
		else if($_SESSION['view_quote_action'] =="9")   {   $arg .= " AND deleted=0 and status=1 AND step = '4' ";}
		else if($_SESSION['view_quote_action'] =="5")   {   $arg.= " AND step = '5' ";	}
		else if($_SESSION['view_quote_action'] =="10")  {   $arg.= " AND step = '8' ";	}
		else if($_SESSION['view_quote_action'] =="11")  {   $arg.= " AND step = '9' ";	}
		else if($_SESSION['view_quote_action'] =="6")   {   $arg.= " AND step = '6' ";	}
		else if($_SESSION['view_quote_action'] =="7")   {   $arg.= " AND   login_id ='".$_SESSION['admin']."' "; }
		else if($_SESSION['view_quote_action'] =="8")   {   $arg.= " AND   deleted = 1 "; }
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
				if($value != '' &&  $value != 'undefined') {
					if(($key == 'second_called_date' || $key == 'seven_called_date' ||  $key == 'called_date')) 
					{
					    
						$date = '0000-00-00 00:00:00';
						
						if($value == 1)
						{
						  $arg.= " AND   ".$key."  != '".$date."'";
						}else{
						   $arg.= " AND   ".$key."  = '".$date."'";
						}
						
					}else 
					{
						if($key == 'quote_for' || $key == 'job_ref' || $key == 'site_id' || $key == 'step' ||  $key == 'response'  || $key == 'login_id' || $key == 'real_estate_id'|| $key == 'have_removal' || $key == 'production_id') { 
						  
						  if($key == 'response') {
						        
    						   $arg.= " AND   ".$key."  = '".$value."'";
    						   
						    }else{
						         $arg.= " AND   ".$key."  = '".$value."'";
						    }
						  
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
		
    // echo $arg;
  // select * from quote_new where 1=1 AND step != 10 AND   job_ref  = 'Site' AND   quote_for  = '1' AND   real_estate_id  = 'undefined'
	
	$countsql = 	$arg;
	
$arg.=" order by id desc limit 0,$resultsPerPage";
//echo $arg;
  $data = mysql_query($arg);
 $countResult = mysql_num_rows(mysql_query($countsql));
 
     $jobIcone =  jobIcone();
	 $getAllSiteData = getAllSiteData();
	 
	$today = date('Y-m-d');
	$getphone =  CheckDoublephoneNumber($today);

?>

     <div class="right_text_boxData right_text_box">
	  <div class="midle_staff_box"><span class="midle_text" style="margin-top: 39px;">Total Records <?php  echo $countResult; //echo  getTotalRecords('quote_new',$condcount); ?></span></div>
	  
	 
	</div>
 <?php // print_r($getphone); ?>
<div class="usertable-overflow">
    <!--<table class="user-table fixed_headers">-->
		
    <table class="user-table unselectable">
	  <thead class="myTable table-head-fixed">
	  <tr>
		<th>Id</th>
		<th>Job Id</th>
		<th>#Q For</th>
		<!--<th>RE</th>-->
		<th>Site</th>
        <th>Ref</th>
        <th>#Q Date</th>
		<th>#Q Time</th>
		<th>Name</th>
		<th>Email</th>
		<th>Phone</th>
		<th>Suburb</th>
        <th>#J Type</th>
		<th>#J Date</th>
		<th>SMS Quote</th>
        <th>Email Date</th>
		<th>Amt</th>
		<th>1st Call</th>
		<th>2nd Call</th>
		<th>3rd Call</th>
        <th>Status</th>
        <th>Response</th>
        <th>Pending</th>
        <!--<th>C Type</th>
        <th>C Mode</th>-->
        <th>Send enquiry</th>
        <th>OTO</th>
        <th>Have Removal</th>
        <th>Admin<?php if($_SESSION['view_quote_action'] =="8") { echo "/ <br/>Deleted By"; } ?></th>
		<?php if($_SESSION['view_quote_action'] !="8") { ?>
		 <th>Action</th> 
		<?php  } ?>
		
	  </tr>
	  </thead>
	  <tbody id="get_loadmoredata">
	  <?php 
	  
	  
	  
	  if (mysql_num_rows($data)>0){ 
	  while($r=mysql_fetch_assoc($data)){
		  
		  $icondata = GetQuoteDetailsIconData($r['booking_id'] , $r['id']);
		  $tr_removal = $icondata['tr_removal'];
		  // print_r($icondata['icondetais']);
		
		  
		$startDatehours  = date('Y-m-d H:i:s');
        $endDatehours = $r['createdOn'];
        $minutes = round((strtotime($startDatehours) - strtotime($endDatehours))/60, 2);
           
	 
	      $siteDetails = $getAllSiteData[$r['site_id']];
		 
		$current_time = date('Y-m-d H:i:s');
		$minute =  round(abs(strtotime($r['oto_time']) - strtotime($current_time)) / 60,2);
		$show_minute =  30 - $minute;
		
		 $bbcapp_staff_id = $r['bbcapp_staff_id'];
		 
		 
	// print_r($getphone);	
		
	  ?>
	  
	  
		<tr <?php if($bbcapp_staff_id > 0) {  ?>  disabled  style="cursor: not-allowed;opacity: 0.5;background-color: grey;pointer-events: none;"  <?php  } ?> class="parent_tr <?php if($bbcapp_staff_id > 0) {  echo ' alert_danger_staff_tr  ';  }else { if((in_array($r['phone'] , $getphone) || in_array($r['email'] , $getphone)) && $r['booking_id'] == 0 ) { echo " alert_duplicate_danger_tr"; }else { if($r['booking_id'] != 0 ) { echo " alert_danger_success";} else if($r['step'] == 5 || $r['step'] == 6 || $r['step'] == 7 || $r['deleted'] == 1) { echo ' alert_danger_tr'; }else if($r['response'] == '3') { echo 'alert_warning'; } } } ?> ">
		
			<td class="bc_click_btn pick_row <?php if($_SESSION['view_quote_field'] == 'id'){ echo "search_field_value"; } ?>"><? echo $r['id'];?></td>
			
			<td class="pick_row">
			<?php if($r['booking_id'] != '0') { ?>
			    <a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $r['booking_id']; ?>','1200','850')"><?  echo $r['booking_id']; ?></a>	
			<?php  } else {echo "-";} ?>
            </td>	
			
			<td class="bc_click_btn pick_row "><?  echo get_rs_value("quote_for_option","name",$r['quote_for']);?></td>
			<!--<td class="bc_click_btn pick_row "><?php if($r['real_estate_id'] > 0) { echo get_rs_value("real_estate_agent","name",$r['real_estate_id']); } ?></td>-->
			
			<td class="bc_click_btn " title="<? echo $siteDetails['name'];?><?php //if($r['real_estate_id'] > 0) { echo '/'.get_rs_value("real_estate_agent","name",$r['real_estate_id']); } ?>"><? echo $siteDetails['abv'];?>
			
			<?php //if($r['real_estate_id'] > 0) { echo '/RE'; } ?>			</td>
			
			<td class="bc_click_btn" title="<?php //if($r['job_ref'] == 'Crm') {  echo get_rs_value("admin","company_name",$r['login_id']);  }else { if($r['job_ref'] != '0') { echo $r['job_ref']; } } ?>"><img class="image_icone" src="icones/ref/<?php echo getRefIcons($r['job_ref']); ?>" alt="<?php echo $r['job_ref']; ?>"></td>
			
			<td class="bc_click_btn <?php if($_SESSION['view_quote_field'] == 'date'){ echo "search_field_value"; } ?>" title="<? echo changeDateFormate($r['date'],'datetime'); ?>"><? echo changeDateFormate($r['date'],'dm'); ?></td>
			
				<?php  if($r['step'] == 1) { $class = ' alert-danger';  if($minutes > 15) { $class = ' alert-danger';  if( $r['check_sms_initial'] == 0 )  { $msgstatus = ''; $class = ' alert-danger';    }else{$msgstatus = 'Sent'; $class = '';  }   ?>
		    	<td class="bc_click_btn <?php print $class; ?>"><? echo date('h:i A',strtotime($r['createdOn'])). '<br />' . $msgstatus; ?></td>
			<?php  }else { ?>
			    <td class="bc_click_btn"><? echo date('h:i A',strtotime($r['createdOn'])); ?></td>
			    <?php } }else { ?>
		    	<td class="bc_click_btn"><? echo date('h:i A',strtotime($r['createdOn'])); ?></td>
			<?php  } ?>
			<td class="bc_click_btn <?php if($_SESSION['view_quote_field'] == 'name'){ echo "search_field_value"; } ?>"><? echo $r['name'];?></td>
			<td class="bc_click_btn <?php if($_SESSION['view_quote_field'] == 'email'){ echo "search_field_value"; } ?>" title="<? echo $r['email'];?>"><a href="mailto:<? echo $r['email'];?>"><? echo substr($r['email'], 0, 10)."...";?></a></td>
			
			<td class="bc_click_btn <?php if($_SESSION['view_quote_field'] == 'phone'){ echo "search_field_value"; } ?>">
			<a href="tel:<?php if($tr_removal > 0){ echo $siteDetails['br_area_code'].$r['phone'];}else{ echo $siteDetails['area_code'].$r['quote_for'].$r['phone'];}?>">
					<?   echo $r['phone']; //substr($r['phone'] ,0 ,6 ).'XXXX';?>
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
			 
			<td class="bc_click_btn <?php if($_SESSION['view_quote_field'] == 'booking_date'){ echo "search_field_value"; } ?>"  title="<? if($r['booking_date']!="0000-00-00"){ echo changeDateFormate($r['booking_date'],'datetime'); } ?>"><? if($r['booking_date']!="0000-00-00") { echo changeDateFormate($r['booking_date'],'dm'); } ?>
			</td>
			
			<td class="bc_click_btn" title="<? echo date('d-m-Y',strtotime($r['sms_quote_date'])); ?>" id="quote_sms_<?=$r['id']?>"><? if($r['sms_quote_date']!="0000-00-00"){ echo changeDateFormate($r['sms_quote_date'],'dm'); } ?></td>
			
			<td class="bc_click_btn" ><? if($r['emailed_client']!="0000-00-00 00:00:00"){ echo date("d/m H:i",strtotime($r['emailed_client'])); }?></td>
			
			<td class="bc_click_btn" <?php if($r['oto_time'] != '0000-00-00 00:00:00') { if($r['oto_flag'] == 1) { ?> style="font-weight: 600;" <?php  } } ?> >$<? echo $r['amount'];?></td>
			
			<td class="bc_click_btn" id="quote_called_<?=$r['id']?>"><? if($r['called_date']!="0000-00-00 00:00:00"){ echo date("d/m H:i",strtotime($r['called_date'])); } else { echo "-"; }?></td>
			
			<td class="bc_click_btn" id="second_quote_called_<?=$r['id']?>">
			   <? if($r['second_called_date']!="0000-00-00 00:00:00"){ echo date("d/m H:i",strtotime($r['second_called_date'])); } else { echo "-"; }?>
			</td>
			
			<td class="bc_click_btn" id="seven_quote_called_<?=$r['id']?>">
			   <? if($r['seven_called_date']!="0000-00-00 00:00:00"){ echo date("d/m H:i",strtotime($r['seven_called_date'])); } else { echo "-"; }?>
			</td>
			
			<td id="getstatus">
			  <?php 
			     echo create_dd("step","system_dd","id","name","type=31","Onchange=\"return view_quote_status_change(this.value,".$r['id']." , 1);\"",$r);
               if($tr_removal > 0){
				   	if($r['step'] == 6) {
				       echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=99","Onchange=\"return view_quote_admin_denied(this.value,".$r['id']." , 1);\"",$r);
					}
			    }else {
					if($r['step'] == 6) {
					  echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=91","Onchange=\"return view_quote_admin_denied(this.value,".$r['id']." , 1);\"",$r);
					}else if($r['step'] == 5){
						echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=93","Onchange=\"return view_quote_admin_denied(this.value,".$r['id']." , 1);\"",$r);
					}else if($r['step'] == 7){
						echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=94","Onchange=\"return view_quote_admin_denied(this.value,".$r['id']." , 1);\"",$r);
					}
				}
			?>
			</td>	
			
            <td id="response">
			  <?php echo create_dd("response","system_dd","id","name","type=33","Onchange=\"view_quote_response(this.value,".$r['id'].");\"",$r);?>    
			</td>
			
            <td id="pending">
			  <?php echo create_dd("pending","system_dd","id","name","type=34","Onchange=\"view_quote_pending(this.value,".$r['id'].");\"",$r);?>    
			</td>	 	
			
            <!--<td class="" ><? // echo getContactType($r['contact_type']);?></td>			
			<td class="" ><? // echo getmodeOFContact($r['mode_of_contact']);?></td>-->
			 
			<td class="" id="send_enquiry_<?php echo $r['id']; ?>" >
			 
			   <?php if($tr_removal > 0){ ?>
     			  
				    <br/><p title='<?php if($r['removal_enquiry_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['removal_enquiry_date'] , 'timestamp'); } ?>'><?php if($r['removal_enquiry_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['removal_enquiry_date'] , 'dm'); } else { ?> </p>
				   <a title="Send enquiry" href="javascript:send_data('<?=$r['id']?>' ,540, 'send_enquiry_<?php echo $r['id']; ?>');" >Send enquiry </a>
			   <?php  } } else { echo 'N/A'; }?>
			</td>
		      
			<td id="oto_flag1">
			   <?php 
			       if($r['oto_time'] != '0000-00-00 00:00:00') {
				     if($r['oto_flag'] == 1) {
				         if($r['booking_id'] == 0) { 
					 echo create_dd("oto_flag","system_dd","id","name","type=58","Onchange=\"view_quote_oto_flag(this.value,".$r['id'].");\"",$r); }else{ echo 'OTO Booked'; } }else {echo "Exp";  } }else { echo "N/A"; } ?>
			</td>
			
			<td class="" ><? if($r['have_removal'] > 0) {  echo getSystemvalueByID($r['have_removal'],90); } ?></td>	
		  	<td class="bc_click_btn" ><?  if($r['login_id'] != 0) { echo get_rs_value("admin","name",$r['login_id']); }else { echo "N/A"; }?><?php //if($_SESSION['view_quote_action'] =="8") { echo "<br/>".get_rs_value("admin","name",$r['is_deleted']);  }?></td>
			
			
			<?php if($_SESSION['view_quote_action'] != "8") {  ?>	
			<td>
				<a title="DELETE" href="javascript:delete_quote('<?=$r['id']?>');" class="file_icon"><i class="fa fa-trash-o" aria-hidden="true"></i></a>		                           
			</td>
			<?php  } ?>	
		</tr>
		
	  <? }?>
	  
		<?php if($countResult >= $resultsPerPage) { ?>
	       <tr class="load_more">
	         <td colspan="30"><button class="loadmore" data-page="2" >Load More</button></td>
	      </tr>
		<?php } ?>  
	     
	</table>

    <?php }else{ ?> 
   <table class="user-table">
	  <tr><td colspan="30">No Quotes Found</td></tr>
	</table>
	<?php }?>
</div>

<style>
     .unselectable {
        -webkit-user-select: none;
        -webkit-touch-callout: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        color: #cc0000;
      }
</style>