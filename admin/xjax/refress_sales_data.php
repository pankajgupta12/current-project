<?php  
session_start();
include("../source/functions/functions.php");
include("../source/functions/config.php");

//print_r($_POST);
    if(isset($_POST)) {
		
		 $quoteid = get_rs_value("sales_task_track","quote_id",$_POST['qid']);
		
		$argsql1 = mysql_query("SELECT * FROM `sales_task_track`  WHERE quote_id = ".$quoteid." AND task_status = 1");
		
		$data = mysql_fetch_assoc($argsql1);
		
		//print_r($data); die;
		
		$arg = "select id , name ,response ,  booking_id , step , amount , denied_id , site_id , email , phone , date,booking_date , booking_id from quote_new  where 1 = 1  AND id = ".$data['quote_id']."";
		   
			 	$getquesql = mysql_query($arg);
			 
			if(mysql_num_rows($getquesql) > 0) {
				
				   while($getq = mysql_fetch_assoc($getquesql)) {

						if($getq['booking_id'] == '0') {
						$sql_icone = ("select job_type_id , job_type from quote_details where  status != 2 AND quote_id=".$getq['id']);
						}else{
						$sql_icone = ("select job_type_id , job_type from job_details where  status != 2 AND quote_id=".$getq['id']);  
						}
						$quote_details = mysql_query($sql_icone);		

$i =1;					 

 $getsite = getSite();
 $getStepData = system_dd_type(31);

		
?>
   <div class="box panel panel-info box-item box_color_1"  id="<?php echo $data['id']; ?>" itemid="itm-<?php echo $i.'_'.$stageskey;?>" <?php  if($getq['booking_id'] != 0) {  ?> style="background-color: #c1eddb;" <?php  } ?>>
			   
			   <?php  // if($data['check_complete'] != '0000-00-00 00:00:00') {  ?>
			   <span class="glyphicon glyphicon-pencil" onclick="openModal('<?php echo $data['id']; ?>')"></span>
			   <?php//  } ?>
			    <div class="panel-heading td_back " <?php if($getq['response'] == '3') { ?> style="background: #fcf8e3;" <?php  } ?> >
				  <div class="row"> 
				  <div class="col-md-6">
				
				   <h3><p class="glyphicon glyphicon-user geticone"><?php echo $getq['name'].' ('.$getq['id'].')'; ?></p></h3>
				    <?php  if($getq['booking_id'] != 0) {?>
				      <p class="internet_icon"><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $getq['booking_id']; ?>','1200','850')"><?php echo $getq['booking_id']; ?></a></p> 
					<?php  } ?>

					
					 
					 <p class="glyphicon glyphicon-envelope geticone"><?php echo $getq['email']; ?></p>
					 <p class="glyphicon glyphicon-earphone geticone"><a href="tel:<?php echo $getq['phone']; ?>"><?php echo $getq['phone']; ?></a></p>
					 
					
					<p class="glyphicon glyphicon-globe geticone"><?php echo $getsite[$getq['site_id']]; ?> </p>	   
				    <p class="glyphicon glyphicon-usd geticone"><?php echo  $getq['amount']; ?></p>
					
					  <?php    while($qd = mysql_fetch_assoc($quote_details)){      
			    	 $job_icon =  get_rs_value("job_type","job_icon",$qd['job_type_id']);
			          ?><img class="image_icone" src="icones/job_type32/<?php echo $job_icon." "; ?>" alt="<?php echo $qd['job_type']." "; ?>" title="<?php echo $qd['job_type']." "; ?>"><?php }   ?>	
				      
				   </p>
				  </div>
				
               <div class="col-md-5">	

                    <?php if($stageskey == 2) { ?>
					    <p class="glyphicon glyphicon-time geticone"><?php //echo $data['fallow_created_date']; ?> <?php echo $data['fallow_time']; ?></p>	
					<?php  } else { ?>
					<p class="glyphicon glyphicon-time geticone"><?php echo $data['fallow_created_date']; ?> <?php echo $data['fallow_time']; ?></p>	
					<?php  } ?>
					
					
					 <p class="placeholder_icon "><b>BD</b> : <?php if($getq['booking_date'] != '0000-00-00') { echo changeDateFormate($getq['booking_date'] , 'datetime');  } ?></p>
					 <p class="placeholder_icon "><b>QD : </b><?php echo changeDateFormate($getq['date'] , 'datetime'); ?></p>
					 
					
					
					  <p class="placeholder_icon">
				      <?php if(in_array($stageskey , $stagesdata)) {  ?>
					  
				      <?php    echo create_dd("step","system_dd","id","name","type=31","Onchange=\"return view_quote_status_change(this.value,".$getq['id']." , 3);\"",$getq);


							    if($getq['step'] == 6) {
								
								  echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=91","Onchange=\"return view_quote_admin_denied(this.value,".$getq['id']." , 1);\"",$getq);
								}else if($getq['step'] == 5){
									
									echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=93","Onchange=\"return view_quote_admin_denied(this.value,".$getq['id']." , 1);\"",$getq);
								}else if($getq['step'] == 7){
									
									echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=94","Onchange=\"return view_quote_admin_denied(this.value,".$getq['id']." , 1);\"",$getq);
								}
					  ?>
					   <?php  }else { echo $getStepData[$getq['step']]; } ?>  
					</p>
					
					<p> <?php  echo create_dd("response","system_dd","id","name","type=33","Onchange=\"view_quote_response(this.value,".$getq['id'].");\"",$getq);?>    </p>
	
	                
				    <p class="edit_button"><a class="edit_button_show" href="/admin/index.php?task=edit_quote&quote_id=<?php echo $getq['id']; ?>" target="_blank">Edit</a>
					
					<span class="edit_button_show_1" onClick="getsidepanel('<?php  echo $getq['id']; ?>');">Info</span>
					
					</p>
					
				</div>    
			    </div>
			    </div>
				
			</div>	  
			
	<?php  }  }
	} ?>		