<?

//print_r($_SESSION['application']);

$resultsPerPage = resultsPerPage;
$arg = "select * from staff_applications where 1=1 ";
    if(isset($_SESSION['application_report_action']))
    { 
        if($_SESSION['application_report_action']=="1")
    	{
    		
           $arg .= 'AND  step_status=1 ';  
        }
    	else if($_SESSION['application_report_action'] =="2")
    	{
    	 $arg .= ' AND  step_status=2';     
    	 
    	}else if($_SESSION['application_report_action'] =="3")
    	{
    	    $arg .= ' AND step_status=3';
    	    
    	}else if($_SESSION['application_report_action'] =="4")
    	{
    	    $arg .= ' AND step_status=4';
    	}else if($_SESSION['application_report_action'] =="5")
    	{
    	    $arg .= ' AND step_status=5';
    	}else if($_SESSION['application_report_action'] =="6")
    	{
    	    $arg .= ' AND step_status=6';
    	}else if($_SESSION['application_report_action'] =="7")
    	{
    	    $arg .= ' AND delete_status =2';
    	}
    }
	
	
	//print_r($_SESSION['application']);
	
		if($_SESSION['application']['site_id']!="" && $_SESSION['application']['site_id']!= 0){ 
		    $arg.= " AND site_id=".mysql_real_escape_string($_SESSION['application']['site_id'])." ";
		}
		
		/*if($_SESSION['application']['job_type'] == 1){ 
		    $arg.= " AND  !FIND_IN_SET ('services_removal' , job_types)";
		}
		if($_SESSION['application']['job_type'] == 2){ 
		    $arg.= " AND FIND_IN_SET ('services_removal' , job_types)";
		}*/
		
		$job_type = get_rs_value("job_type","name",$_SESSION['application']['job_type']);
		$service_job = 'services_'.strtolower($job_type);
		
		if($_SESSION['application']['job_type'] != 0){
			
			$arg.= " AND FIND_IN_SET ('".$service_job."' , job_types)";
			
		}
		
		if(($_SESSION['application']['search_value'] !="") && ($_SESSION['application']['search_value'] != "")){
		    
			$arg.= " AND (given_name  like '%".$_SESSION['application']['search_value']."%' OR id  like '%".$_SESSION['application']['search_value']."%' OR email  like '%".$_SESSION['application']['search_value']."%' OR mobile  like '%".$_SESSION['application']['search_value']."%' OR phone  like '%".$_SESSION['application']['search_value']."%')";
		}
		
	    if($_SESSION['application']['response_status'] != '' && $_SESSION['application']['response_status'] != 0){ 
		    $arg.= " AND response_status=".mysql_real_escape_string($_SESSION['application']['response_status'])." ";
		}
		
		 if($_SESSION['application']['application_reference'] != '' && $_SESSION['application']['application_reference'] != 0){ 
		    $arg.= " AND application_reference=".mysql_real_escape_string($_SESSION['application']['application_reference'])." ";
		}
		
		 if($_SESSION['application']['sutab_unsutab'] != '' && $_SESSION['application']['sutab_unsutab'] != 0){ 
		    $arg.= " AND sutab_unsutab=".mysql_real_escape_string($_SESSION['application']['sutab_unsutab'])." ";
		}
	
	$condi = $arg;
	
	$arg.=" order by id desc limit 0,$resultsPerPage";
	//echo $arg;
    $data = mysql_query($arg);
   
  
   
 $countResult = mysql_num_rows(mysql_query($condi));
 
?>

<style>
 .textfields{
     border:1px solid #ddd !important;
    width: 89% !important;
    height: 43px;
    border-radius: 5px;
 }
 
 tr.alert_orange_tr11 td {
    background-color: #e8cda7 !important;
   /* border-color: #000 !important;*/
    color: #000 !important;
}


 tr.alert_yellow_purpule td {
    background-color: #f1ead3 !important;
   /* border-color: #000 !important;*/
    color: #000 !important;
}
tr.alert_green_purpule td {
    background-color: #4fe878e0 !important;
   /* border-color: #000 !important;*/
    color: #000 !important;
}
tr.alert_dark_green_purpule td {
    background-color: #7ceca494  !important;
   /* border-color: #000 !important;*/
    color: #000 !important;
}
tr.alert_dark_red_purpule td {
    background-color: #c5132394 !important;
    /*border-color: #dca9f1 !important;*/
    color: #000 !important;
}

tr.alert_orange_purpule td {
    background-color: #dca9f1 !important;
   /* border-color: #dca9f1 !important;*/
    color: #000 !important;
}
 
</style>

 <div class="right_text_box" style="margin-top: -21px;">
     <div class="midle_staff_box"> <span class="midle_text" style="margin-left: 475px;">Total Records <?php echo  $countResult; ?> </span></div>
</div>
 <input type="hidden" class="date_class_new" />
<div class="usertable-overflow">
	<table class="user-table">
	  <thead>
	  <tr>
		<th>Id</th>
		<th>Site</th>
		<th>Post Code</th>
		<th>Name</th>
	    <th>Email</th>
		<th>Mobile</th>
		<th>DOB</th>
		<th>job types</th>
		<th>App Status</th>
		<th>Created</th>
		<th>Submited</th>
		<th>Last Login</th>
		<!--<th>Step</th>-->
		<th>First Email</th>
		<th>Docs Required</th>
		<th>Welcome Email</th>
		<th>Reference</th>
		<th>Resp Status</th>
		<th>S/US Status</th>
		<!--<th>S/Us Reason</th>-->
		<th>Admin Name</th>
		<th>Info From</th>
		<!--<th>Delete</th>-->
	  </tr>
	  </thead>
	   <tbody id="get_loadmoredata">
			  <?php 
			   if (mysql_num_rows($data)>0){ 
			       $counter = 0;
			     while($r=mysql_fetch_assoc($data)){ 
			          $counter++;
			          $bgcolor = '';
				    // $bgcolor = ($counter % 2 === 0) ? 'alert_even_tr' : 'alert_odd_tr';
					 
					 $jobType =  ucwords(str_replace('services_',' ',$r['job_types']));
					 //echo $jobType;
					 
					$jobtype1 = explode(',',str_replace('_' , ' ' ,$jobType)); 
					
					//print_r($jobtype1);
					 foreach($jobtype1 as $jobvalue) {
					      $getjobdetails[] = "'".trim($jobvalue)."'";
					 }
					
					//rint_r($getjobdetails); 
					  $val =   implode(",",$getjobdetails); 
				    $getjobIcone = mysql_query("SELECT *  FROM `job_type` WHERE `name` IN (".$val.")"); 
				   
				   if($r['site_id'] != 0) {  $siteid = $r['site_id']; }
                $getsite = mysql_fetch_array(mysql_query("SELECT count(*) as id,site_id   FROM `postcodes` WHERE `postcode` = '".mres($r['post_code'])."' and site_id = '".$siteid."'"));
                
               // echo $getsite['site_id'];
                if($getsite['site_id'] != $r['site_id'] && $r['post_code'] != ''){
                   
                   $style="background: #efc1c1;";
                  // $
                }else{
                   $style = '';
                }
                
            
                $bg1 = '';
                if($r['step_status'] == 1 ) {
                    $bg1 = 'alert_orange_purpule';
                }elseif($r['step_status'] == 7) {
                    $bg1 = 'alert_orange_tr11';
                }elseif($r['step_status'] == 2) {
                    $bg1 = 'alert_yellow_purpule';
                }elseif($r['step_status'] == 3) {
                    $bg1 = 'alert_green_purpule';
                }elseif($r['step_status'] == 5) {
                    $bg1 = 'alert_dark_green_purpule';
                }elseif($r['step_status'] == 6 || $r['sutab_unsutab'] == 3 || $r['delete_status'] == 2) {
                    $bg1 = 'alert_dark_red_purpule';
                }
                
               
			 ?>
				<tr class="parent_tr <?php if($bg1 != '') {  echo $bg1; } else  {  ?>  <?php  if($r['response_status'] == '4') { echo  'alert_orange_tr11'; }else { if($r['staff_is_added'] == 1) {echo 'alert_danger_success'; } } }    ?>" id="<?php echo $r['id']; ?>" >
					<td class=" pick_row"><a href="javascript:scrollWindow('application_popup.php?task=appl&appl_id=<?php echo $r['id']; ?>','800','700')"><?php echo $r['id'] ?></a></td>
					
					<td class=" pick_row" title="<?php if($r['site_id'] == 0) {  echo "-";   }else { echo get_rs_value("sites","name",$r['site_id']); }?>"><?php if($r['site_id'] == 0) {  echo "-";   }else { echo get_rs_value("sites","abv",$r['site_id']); }?></td>
					
					<td class="bc_click_btn pick_row" style="<?php echo $style; ?>"><?php if($r['post_code'] == '') {  echo "-";   }else { echo $r['post_code']; }  ?></td>
					
				 <td class="bc_click_btn pick_row" title="<? if($r['first_name']){ echo $r['first_name']; }else { echo  $r['given_name']; }?>"><? if($r['first_name']) { echo $r['first_name']; }else { echo  $r['given_name']; }?></td>
					
					<td class=" pick_row" title="<? echo $r['email'];?>"><a href="mailto:<? echo $r['email'];?>"><?php if($r['email'] != "") {  echo substr($r['email'], 0, 10)."...";  } else { echo "-";} ?></a></td>
					
					<td class=" pick_row"><a href="tel:<?php if($r['mobile'] != "") { echo $r['mobile']; } ?>"><?php if($r['mobile'] != "") { echo $r['mobile']; } else { echo "-"; } ?></a>
					<!--<br/>-->
					<!--<a href="javascript:scrollWindow('send_hr_sms.php?sms_task=send_sms&app_id=<?php echo $r['id']; ?>','400','400')">Send SMS</a>-->
					
					</td>
					<td class="bc_click_btn pick_row" title="">  <?php if($r['date_of_birth'] != '') { echo changeDateFormate($r['date_of_birth'] , 'datetime'); } ?></td>
					
				   	<td class="bc_click_btn pick_row">
						<? while($qd = mysql_fetch_assoc($getjobIcone)){  ?>
							 <img class="image_icone" src="icones/job_type32/<?php echo $qd['job_icon']." "; ?>" alt="<?php echo $qd['job_icon']." "; ?>" title="<?php echo $qd['name']." "; ?>"><?php }    ?>
					</td>
					
					<td class=" pick_row" id="step_status_<?php echo $r['id']; ?>"><?php echo create_dd("step_status","system_dd","id","name","type=55 order by ordering asc","onchange=\"javascript:edit_fields_applications(this,'staff_applications.step_status',".$r['id'].");\"",$r);?> </td>
					
				    <td class="bc_click_btn pick_row" title="<?php echo changeDateFormate($r['date_started'],'datetime'); ?>"><?php echo changeDateFormate($r['date_started'],'dm'); ?></td>
					
				    
				    <td class="bc_click_btn pick_row" title="<?php if($r['date_submission'] != '0000-00-00') { echo changeDateFormate($r['date_submission'],'datetime');  } ?>"><?php if($r['date_submission'] != '0000-00-00') { echo changeDateFormate($r['date_submission'],'datetime');  }else {echo "--";} ?></td>
					
					<td class="bc_click_btn pick_row"  title="<?php echo changeDateFormate($r['last_login_date'],'timestamp');  ?>"><?php echo changeDateFormate($r['last_login_date'],'dt');  ?></td>
				    
				    <!--<td class="bc_click_btn pick_row"><?php echo getApplicationStatus($r['step_status']); ?></td>-->
					
				    <td class="bc_click_btn pick_row" id="first_<?php echo $r['id']; ?>" title="<?php if($r['first_email_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['first_email_date'], 'timestamp');} ?>">
					 <?php if($r['first_email_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['first_email_date'], 'dt');} ?><br/>
					    <!--<a href="javascript:scrollWindow('application_emails.php?email_task=first_email&app_id=<?php echo $r['id']; ?>','800','600')"><img src="../admin/icones/ref/email.png" style="width: 24px;" alt="send email"/></a>-->
					</td>
					
				    <td class="bc_click_btn pick_row"  id="email_doc_<?php echo $r['id']; ?>"   title="<?php if($r['email_doc_required_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['email_doc_required_date'], 'timestamp');} ?>">
					  <?php if($r['email_doc_required_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['email_doc_required_date'], 'dt');} ?> <br/>
  					     <!-- <a href="javascript:scrollWindow('application_emails.php?email_task=docs_required&app_id=<?php echo $r['id']; ?>','800','600')"><img src="../admin/icones/ref/email.png" style="width: 24px;" alt="send email"/></a>-->
					 </td>
					 
				    <td class="bc_click_btn pick_row" id="welcom_<?php echo $r['id']; ?>"  title="<?php if($r['welcome_email_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['welcome_email_date'], 'timestamp');} ?>">
					  <?php if($r['welcome_email_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['welcome_email_date'], 'dt');} ?> <br/>
					  <!--<a href="javascript:scrollWindow('application_emails.php?email_task=welcome_email&app_id=<?php echo $r['id']; ?>','800','600')"><img src="../admin/icones/ref/email.png" alt="send email" style="width: 24px;"/></a>-->
					</td>
					
					<td class=" pick_row" id="application_reference<?php echo $r['id']; ?>"> <?php echo create_dd("application_reference","system_dd","id","name","type=56","onchange=\"javascript:edit_fields_applications(this,'staff_applications.application_reference',".$r['id'].");\"",$r);?>   </td>
					
					<td class=" pick_row" id="response_status_<?php echo $r['id']; ?>"> 
					    <?php // echo create_dd("sutab_unsutab","system_dd","id","name","type=38","onchange=\"javascript:edit_fields_applications(this,'staff_applications.sutab_unsutab',".$r['id'].");\"",$r);?>   
					    <?php echo create_dd("response_status","system_dd","id","name","type=71","onchange=\"javascript:edit_fields_applications(this,'staff_applications.response_status',".$r['id'].");\"",$r);?>   
					</td>
					<td class=" pick_row" id="sutab_unsutab_<?php echo $r['id']; ?>"> 
					    <?php echo create_dd("sutab_unsutab","system_dd","id","name","type=38","onchange=\"javascript:edit_fields_applications(this,'staff_applications.sutab_unsutab',".$r['id'].");\"",$r);?>   
					    <?php // echo create_dd("response_status","system_dd","id","name","type=71","onchange=\"javascript:edit_fields_applications(this,'staff_applications.response_status',".$r['id'].");\"",$r);?>   
					</td>
					
				<!--	<td class="bc_click_btn pick_row">
					   <input type="text" class="textfields" id="suitable_unsuitable_reason<?php echo $r['id'] ?>" value="<?php if($r['suitable_unsuitable_reason'] != "") { echo $r['suitable_unsuitable_reason']; } else { echo " "; } ?>" onblur="javascript:edit_fields_applications(this,'staff_applications.suitable_unsuitable_reason',<?php echo $r['id']?>);"/>
					</td>-->
					
					
					 <td class=" pick_row" title="">
					     <?php // if($r['admin_id'] != 0) { echo get_rs_value("admin","name",$r['admin_id']);}else { echo 'NA'; }
					     //getRole($role)
					      if(in_array($_SESSION['admin'] , explode(',', getRole(16)))) {
					     ?>
					     <span><?php echo create_dd("admin_id","admin","id","name","is_call_allow=1 AND status = 1 AND auto_role = 16","onchange=\"javascript:edit_fields_applications(this,'staff_applications.admin_id',".$r['id'].");\"",$r);?></span>
					    <?php  }else {  echo get_rs_value("admin","name",$r['admin_id']);  }  ?>
					</td>
					 
					 <td class="bc_click_btn pick_row" title=""><?php if($r['admin_type'] != '') { echo $r['admin_type']; }   ?></td>
					
				   <!-- <td class=" pick_row" id="delete_app_<?php echo $r['id']; ?>">
					   <a title="DELETE" href="javascript:delete_application('<?=$r['id']?>','application_<?php echo $r['id']; ?>');" class="file_icon"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
					</td>-->
				</tr>
			  <?php  
                   unset($getjobdetails);
			     } 
			  ?>	
		</tbody>
		<?php if($countResult >= $resultsPerPage) { ?>
	       <tr class="load_more">
	         <td colspan="18"><button class="loadmore" data-page="2" >Load More</button></td>
	      </tr>
	     <?php  } ?> 
	</table>

    <?php }else{ ?> 
    <table class="user-table">
	  <tr><td colspan="20">No results found</td></tr>
	</table>
	<?php }?>
</div>
<script>
  
    $(document).on('click','.loadmore',function () {
      $(this).text('Loading...');
     //   var ele = $(this).parent('td');
       // alert(ele);
            $.ajax({
          url: 'xjax/ajax/loadmore_application_report.php',
          type: 'POST',
          datatype: 'html',
          data: {
                  page:$(this).data('page'),
                },
          success: function(response){
               if(response){
                  //alert(response);
                  console.log(response); 

                  $('.load_more').remove();
                  $( "tr.parent_tr:last" ).after( response );
                  
                  
                    //$("#get_loadmoredata").html(response);
                  }
                } 
                 
       }); 
    });
    
    function send_sop_email(str, caseid){
      
      
      
      if (confirm('Are you sure do you want send SOP manual email?')) {
        
          send_data(str, caseid, 'manual_email');
          return  true;
          
      }else{
           return  false;
      }
    }
    
</script>

