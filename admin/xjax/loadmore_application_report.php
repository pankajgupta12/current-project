<?php  
 session_start();
  include("../../source/functions/functions.php");
  include("../../source/functions/config.php");
   if(isset($_POST['page'])) {	
       
       $pageid = $_POST['page'];
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
				}
        }
		if($_SESSION['application']['site_id']!="" && $_SESSION['application']['site_id']!= 0){ 
		    $arg.= " AND site_id=".mysql_real_escape_string($_SESSION['application']['site_id'])." ";
		}
		
		
		$job_type = get_rs_value("job_type","name",$_SESSION['application']['job_type']);
		$service_job = 'services_'.strtolower($job_type);
		
		if($_SESSION['application']['job_type'] != 0){
			
			$arg.= " AND FIND_IN_SET ('".$service_job."' , job_types)";
			
		}
		
		
		if(($_SESSION['application']['search_value'] !="") && ($_SESSION['application']['search_value'] != "")){
		    
			$arg.= " AND (given_name  like '%".$_SESSION['application']['search_value']."%' OR id  like '%".$_SESSION['application']['search_value']."%' OR email  like '%".$_SESSION['application']['search_value']."%' OR mobile  like '%".$_SESSION['application']['search_value']."%' OR phone  like '%".$_SESSION['application']['search_value']."%')";
		}
        
        $arg.=" order by id desc ";
   
        if($pageid>0)
        {
            $page_limit=$resultsPerPage*($pageid - 1);
            $arg.=" LIMIT  $page_limit , $resultsPerPage";
        }
        else
        {	
           $arg.=" LIMIT 0 , $resultsPerPage";
        }
         $query = mysql_query($arg); 
    
           if( mysql_num_rows($query) > 0 )
        {
             $counter = 0;
        	  while( $r = mysql_fetch_assoc( $query ) )
        	  { 	
        	     $counter++;
				    $bgcolor = ($counter % 2 === 0) ? 'alert_even_tr' : 'alert_odd_tr';
					 
					 $jobType =  ucwords(str_replace('services_',' ',$r['job_types']));
					 //echo $jobType;
					 
					$jobtype1 = explode(',',$jobType); 
					
					//print_r($jobtype1);
					 foreach($jobtype1 as $jobvalue) {
						$getjobdetails[] = "'".$jobvalue."'";
					 }
					
					
					 //$val =   implode(", ",$getjobdetails);
				   $getjobIcone = mysql_query("SELECT *  FROM `job_type` WHERE `name` IN (".str_replace(' ','',implode(",",$getjobdetails)).")"); 
				   
				   if($r['site_id'] != 0) {  $siteid = $r['site_id']; }
                $getsite = mysql_fetch_array(mysql_query("SELECT count(*) as id,site_id   FROM `postcodes` WHERE `postcode` = '".mres($r['post_code'])."' and site_id = '".$siteid."'"));
                
               // echo $getsite['site_id'];
               if($getsite['site_id'] != $r['site_id'] && $r['post_code'] != ''){
                   
                   $style="background: #efc1c1;";
                  // $
               }else{
                   $style = '';
               }
                
				    
?> 
	           <tr class="parent_tr <?php echo $bgcolor; ?>  <?php  if($r['staff_is_added'] == 1) {echo 'alert_danger_success';} else if($r['delete_status'] == 2) {echo 'alert_danger_tr';} ?>" id="application_<?php echo $r['id']; ?>">
			   
					<td class="bc_click_btn pick_row"><a href="javascript:scrollWindow('application_popup.php?task=appl&appl_id=<?php echo $r['id']; ?>','800','700')"><?php echo $r['id'] ?></a></td>
					
					<td class="bc_click_btn pick_row" title="<?php if($r['site_id'] == 0) {  echo "-";   }else { echo get_rs_value("sites","name",$r['site_id']); }?>"><?php if($r['site_id'] == 0) {  echo "-";   }else { echo get_rs_value("sites","abv",$r['site_id']); }?></td>
					
					<td class="bc_click_btn pick_row" style="<?php echo $style; ?>"><?php if($r['post_code'] == '') {  echo "-";   }else { echo $r['post_code']; }  ?></td>
					 <td class="bc_click_btn pick_row" title="<? if($r['first_name']){ echo $r['first_name']; }else { echo  $r['given_name']; }?>"><? if($r['first_name']) { echo $r['first_name']; }else { echo  $r['given_name']; }?></td>
					
					<!--<td class="bc_click_btn pick_row" title="<? echo $r['given_name'];?>"><? echo $r['given_name'];?></td>-->
					
					<td class="bc_click_btn pick_row" title="<? echo $r['email'];?>"><a href="mailto:<? echo $r['email'];?>"><?php if($r['email'] != "") {  echo substr($r['email'], 0, 10)."...";  } else { echo "-";} ?></a></td>
					
					<td class="bc_click_btn pick_row"><a href="tel:<?php if($r['mobile'] != "") { echo $r['mobile']; } ?>"><?php if($r['mobile'] != "") { echo $r['mobile']; } else { echo "-"; } ?></a></td>
					
					<td class="bc_click_btn pick_row" title="">  <?php if($r['date_of_birth'] != '') { echo changeDateFormate($r['date_of_birth'] , 'datetime'); } ?></td>
				   	<td class="bc_click_btn pick_row">
						<? while($qd = mysql_fetch_assoc($getjobIcone)){  ?>
							 <img class="image_icone" src="icones/job_type32/<?php echo $qd['job_icon']." "; ?>" alt="<?php echo $qd['job_icon']." "; ?>" title="<?php echo $qd['name']." "; ?>"><?php }    ?>
					</td>
					
					<td class="bc_click_btn pick_row" id="step_status_<?php echo $r['id']; ?>"><?php echo create_dd("step_status","system_dd","id","name","type=55","onchange=\"javascript:edit_fields_applications(this,'staff_applications.step_status',".$r['id'].");\"",$r);?> </td>
					
				    <td class="bc_click_btn pick_row" title="<?php echo changeDateFormate($r['date_started'],'datetime'); ?>"><?php echo changeDateFormate($r['date_started'],'dm'); ?></td>
					
				    
				    <td class="bc_click_btn pick_row" title="<?php if($r['date_submission'] != '0000-00-00') { echo changeDateFormate($r['date_submission'],'datetime');  } ?>"><?php if($r['date_submission'] != '0000-00-00') { echo changeDateFormate($r['date_submission'],'datetime');  }else {echo "--";} ?></td>
					
					<td class="bc_click_btn pick_row"  title="<?php echo changeDateFormate($r['last_login_date'],'timestamp');  ?>"><?php echo changeDateFormate($r['last_login_date'],'dt');  ?></td>
				    
				    <!--<td class="bc_click_btn pick_row"><?php echo getApplicationStatus($r['step_status']); ?></td>-->
					
				    <td class="bc_click_btn pick_row" title="<?php if($r['first_email_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['first_email_date'], 'timestamp');} ?>">
					 <?php if($r['first_email_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['first_email_date'], 'dt');} ?><br/>
					    <a href="javascript:scrollWindow('application_emails.php?email_task=first_email&app_id=<?php echo $r['id']; ?>','800','600')"><img src="../admin/icones/ref/email.png" style="width: 24px;" alt="send email"/></a>
					</td>
					
				    <td class="bc_click_btn pick_row"  title="<?php if($r['email_doc_required_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['email_doc_required_date'], 'timestamp');} ?>">
					  <?php if($r['email_doc_required_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['email_doc_required_date'], 'dt');} ?> <br/>
  					      <a href="javascript:scrollWindow('application_emails.php?email_task=docs_required&app_id=<?php echo $r['id']; ?>','800','600')"><img src="../admin/icones/ref/email.png" style="width: 24px;" alt="send email"/></a>
					 </td>
					 
				    <td class="bc_click_btn pick_row" title="<?php if($r['welcome_email_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['welcome_email_date'], 'timestamp');} ?>">
					  <?php if($r['welcome_email_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($r['welcome_email_date'], 'dt');} ?> <br/>
					  <a href="javascript:scrollWindow('application_emails.php?email_task=welcome_email&app_id=<?php echo $r['id']; ?>','800','600')"><img src="../admin/icones/ref/email.png" alt="send email" style="width: 24px;"/></a>
					</td>
					
					<td class="bc_click_btn pick_row" id="application_reference<?php echo $r['id']; ?>"> 
					    <?php echo create_dd("application_reference","system_dd","id","name","type=56","onchange=\"javascript:edit_fields_applications(this,'staff_applications.application_reference',".$r['id'].");\"",$r);?>   
					</td>
					
					<td class="bc_click_btn pick_row" id="response_status_<?php echo $r['id']; ?>"> 
					    <?php // echo create_dd("sutab_unsutab","system_dd","id","name","type=38","onchange=\"javascript:edit_fields_applications(this,'staff_applications.sutab_unsutab',".$r['id'].");\"",$r);?>   
					    <?php echo create_dd("response_status","system_dd","id","name","type=71","onchange=\"javascript:edit_fields_applications(this,'staff_applications.response_status',".$r['id'].");\"",$r);?>   
					</td>
					
					<td class="bc_click_btn pick_row" id="sutab_unsutab_<?php echo $r['id']; ?>"> 
					    <?php  echo create_dd("sutab_unsutab","system_dd","id","name","type=38","onchange=\"javascript:edit_fields_applications(this,'staff_applications.sutab_unsutab',".$r['id'].");\"",$r);?>   
					    <?php //echo create_dd("response_status","system_dd","id","name","type=71","onchange=\"javascript:edit_fields_applications(this,'staff_applications.response_status',".$r['id'].");\"",$r);?>   
					</td>
					
					<td class="bc_click_btn pick_row">
					   <input type="text" class="textfields" id="suitable_unsuitable_reason<?php echo $r['id'] ?>" value="<?php if($r['suitable_unsuitable_reason'] != "") { echo $r['suitable_unsuitable_reason']; } else { echo " "; } ?>" onblur="javascript:edit_fields_applications(this,'staff_applications.suitable_unsuitable_reason',<?php echo $r['id']?>);"/>
					</td>
					
					 <td class="bc_click_btn pick_row" title=""><?php if($r['admin_id'] != 0) { echo get_rs_value("admin","name",$r['admin_id']);}else { echo 'NA'; } ?></td>
					 <td class="bc_click_btn pick_row" title=""><?php if($r['admin_type'] != '') { echo $r['admin_type']; }   ?></td>
					
				    <td class="bc_click_btn pick_row" id="delete_app_<?php echo $r['id']; ?>">
					   <a title="DELETE" href="javascript:delete_application('<?=$r['id']?>','application_<?php echo $r['id']; ?>');" class="file_icon"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
					</td>
				</tr>
			  <?php } ?>
	       <tr class="load_more">
	         <td colspan="18"><button class="loadmore" data-page="<?php echo  $pageid+1 ;?>">Load More</button></td>
	      </tr>
	 <?php  } else { ?>         <tr><td colspan="20">No Records Found</td></tr>
	 <?php  } } ?>