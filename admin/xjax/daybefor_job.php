 <div class="col-md-2 mrg_btm20 ">
  <?php 
         /*  if($_SESSION['op_adminid']['task_manage_type'] != '' && $_SESSION['op_adminid']['task_manage_type'] != 0) {
		    	$adminid = $_SESSION['op_adminid']['task_manage_type'];
			}else{
			    $adminid = $_SESSION['admin'];
			} */
			
			if($_SESSION['op_adminid']['task_manage_type'] == 'all' &&  $_SESSION['op_adminid']['task_manage_type'] != '' && $_SESSION['op_adminid']['task_manage_type'] != '0'){
				$adminid = 'all';
			}elseif($_SESSION['op_adminid']['task_manage_type'] != 'all' && $_SESSION['op_adminid']['task_manage_type'] != '' && $_SESSION['op_adminid']['task_manage_type'] != '0') {
				
				if($_SESSION['op_adminid']['task_manage_type'] != '' && $_SESSION['op_adminid']['task_manage_type'] != 0) {
					$adminid = $_SESSION['op_adminid']['task_manage_type'];
				}else{
					$adminid = $_SESSION['admin'];
				}
		    }else{
				$adminid = $_SESSION['admin'];
			}
  
   $nextjobDateDetails =  getOpr_Payment($stageskey , $adminid); 
   $count = count($nextjobDateDetails[$stageskey]);
  ?>
 
 
<h2><?php echo  $getsalesheding; ?>(<?php echo ($count); ?>) </h2>
<div class="scroll_c ui-droppable" id="container4">
		 <?php 
		 if($count > 0) {
			
            foreach($nextjobDateDetails[$stageskey] as $datakey=>$tjdata){
   
   			  $sql_icone = ("select job_type_id , staff_id ,  job_type from job_details where  status != 2 AND job_id=".$tjdata['jid']); 
				 $quote_details = mysql_query($sql_icone);
						
						   $date1=date_create(date('Y-m-d'));
							$date2=date_create($tjdata['jdate']);
							$boxcol = '';
							$diff=date_diff($date1,$date2);
							if($diff->format("%a") < 4) {
								$boxcol =  'orange_box';
							}elseif($diff->format("%a") > 4 && $diff->format("%a") < 8){
							   $boxcol =  'grey_box';
							}elseif($diff->format("%a") > 8){
							   $boxcol =  '';
							}
							
		   $sql_track = mysql_fetch_assoc(mysql_query("select id from sales_task_track  where 1 = 1 AND track_type = 2 AND job_id = ".$tjdata['jid'])); 
			  $estamt = $tjdata['job_amt'] - $tjdata['paid_amt'];
            
			$boxcol =  'green_box';
			if($estamt > 0) {
				 $boxcol =  'red_box';
			}			  
			   
		 ?>
				   	
		 
		 
		
		<div class="box panel panel-info box-item box_color_1  <?php echo $boxcol; ?> getresponse_data<?php echo $tjdata['qid']; ?>"  id="<?php echo $tjdata['qid']; ?>" itemid="itm-<?php echo $i.'_'.$stageskey;?>">
			  
			  <?php if($sql_track['id']  != 0 && $sql_track['id']  != '') { ?>
			  <span class="glyphicon glyphicon-pencil" onclick="OprationsopenModal('<?php echo $sql_track['id']; ?>|1|<?php echo $stageskey;?>')"></span>
			  <?php  } ?>
			  
			    <div class="panel-heading td_back " >
				  <div class="row"> 
					<div class="col-md-12">
					<?php if($sql_track['id']  != 0 && $sql_track['id']  != '') { ?>
                        <span class="glyphicon glyphicon-check que_pencil" onclick="OprationsopenQuesModal('<?php echo $sql_track['id']; ?>' , '1', '<?php echo $stageskey; ?>' )"></span>
					<?php  } ?>	
						<h3><p class="glyphicon glyphicon-user geticone"><?php echo $tjdata['cx_name']; ?></p></h3>

						 <p class="glyphicon glyphicon-ok geticone"><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $tjdata['jid']; ?>','1200','850')"><?php echo $tjdata['jid']; ?></a></p>	
						 
						<!--<p class="glyphicon glyphicon-time geticone"><?php  echo changeDateFormate($data['fallow_created_date'] , 'datetime'); ?> <?php echo $data['fallow_time']; ?></p>-->	

						<p class="glyphicon glyphicon-earphone geticone"><a href="tel:<?php echo $tjdata['cphone']; ?>"><?php echo $tjdata['cphone']; ?></a> ( <?php echo $getsite[$tjdata['siteid']]; ?> )</p>

						<p class="glyphicon glyphicon-usd geticone"><?php echo  $tjdata['job_amt']. ' (T) '.'-'. $tjdata['paid_amt'].' (P) '; echo ' = ' .($tjdata['job_amt'] - $tjdata['paid_amt']).' (R)'; ?> </p>

						<?php    
						
					while($qd = mysql_fetch_assoc($quote_details)){
							
							$job_icon =  $jobicon[$qd['job_type_id']];
							if($qd['staff_id'] != 0) {
								 $iconfol = 'job_type32';
								 $smobile =  get_rs_value("staff","mobile",$qd['staff_id']);
								 $staff_name = $staffdetails[$qd['staff_id']];
							}else{
								 $iconfol = 'job_type_red';
								 $smobile = 'N/A';
								 $staff_name = 'N/A';
							}
						 
						?><?php  if($smobile != 'N/A') { ?><a  href="tel:<?php echo $smobile; ?>" ><?php  }  ?> <img class="image_icone" src="icones/<?php echo $iconfol; ?>/<?php echo $job_icon." "; ?>" alt="<?php echo $qd['job_type']." "; ?>"  title="<?php echo $staff_name.' '.$smobile.' ('.$qd['job_type'].')'; ?>"><?php  if($smobile != 'N/A') { ?></a><?php }
					}   ?>	

					</div>
               
			    </div>
			    </div>
		</div>
			
    <?php  } }else { ?>	 
			   <div class="box panel panel-info box_color">
				   <div class="panel-heading">
					  Not Found
				   </div>
				</div>  
	<?php  } ?>					
		 
		
		        </div>
	 </div>