<?php 
 $today = date('Y-m-d');
 $stagesdata = system_dd_type(104);
 $getsite = getSite();
 $getStepData = system_dd_type(31);
 	
?>

 
	<div class="content cnt_box" id="re_page">
	   
	<div class="row">
    <div class="mrg_btm20 ">
     <?php  
	 
	 if($_SESSION['adminid']['id'] != '' && $_SESSION['adminid']['id'] != 0) {
		 $adminid = $_SESSION['adminid']['id'];
	 }else{
		 $adminid = $_SESSION['admin'];
	 }
	 
	    foreach($stagesdata as $stageskey=>$getsalesheding) 
		{
		 ?>
        <div class="col-md-4 mrg_btm20 ">
	   
	    <?php  
		
		    $fromtoday = date('Y-m-d H:i:s' , strtotime('-30 minutes'));
			$lasttoday = date('Y-m-d H:i:s' , strtotime("+90 minutes")); 
			
			$argsql1 = "select * from sales_task_track  where 1 = 1 AND task_status = 1 AND track_type = 1 AND task_manage_id = ".$adminid."";
			$argsql1 .= " AND   quote_id in ( "; 
			$argsql1 .= " select id  from quote_new where 1 = 1 AND ( booking_date >= '".$today."'  OR booking_date = '0000:00:00' ) AND removal_enquiry_date = '00:00:00 00:00:00'";

			//$argsql1 .=  " AND booking_id = 0 AND step not in (8,9,10) AND  denied_id = 0 AND removal_enquiry_date = '0000-00-00 00:00:00'";
			$argsql1 .=  " AND booking_id = 0 AND step not in (8,9,10) AND  denied_id = 0 ";

			if($_SESSION['task_manage']['value'] != '')	 {
				
			    $argsql1 .=  " AND (  name Like '%".$_SESSION['task_manage']['value']."%' OR  phone Like '%".$_SESSION['task_manage']['value']."%' OR id = '".$_SESSION['task_manage']['value']."' ) ";
			}	 

			if($_SESSION['sales_data']['response'] != 0) {
    			 $argsql1.= " AND   response = '".$_SESSION['sales_data']['response']."'";
			}
			
			/* if($_SESSION['sales_data']['response'] != 0) {
    			 $argsql1.= " AND   response = '".$_SESSION['sales_data']['response']."'";
			} */
			
			if($_SESSION['sales_data']['fromdate'] != '' && $_SESSION['sales_data']['todate'] != '') {
			
				if($_SESSION['sales_data']['type'] == 1) {
					$argsql1.= " AND date >= '".$_SESSION['sales_data']['fromdate']."' and date <= '".$_SESSION['sales_data']['todate']."'";
				}elseif($_SESSION['sales_data']['type'] == 2) {
					$argsql1.= " AND  booking_date >= '".$_SESSION['sales_data']['fromdate']."' and booking_date <= '".$_SESSION['sales_data']['todate']."'";
				}	
			}
			
			
			$argsql1 .= " )"; 
		 
		   
		  if($stageskey == 1) {
			$argsql1 .=  " AND  fallow_date < '".$fromtoday."' AND (ans_date != '0000-00-00 00:00:00' OR left_sms_date != '0000-00-00 00:00:00')";
			$argsql1 .=  "  ORDER BY  fallow_date DESC";
		  }elseif($stageskey == 2) {
			//$argsql1 .=  " AND  fallow_date >= '".$fromtoday."' AND fallow_date <= '".$lasttoday."'";
			
			$argsql1 .=  " AND  ((fallow_date >= '".$fromtoday."' AND fallow_date <= '".$lasttoday."') OR (ans_date = '0000-00-00 00:00:00' AND left_sms_date = '0000-00-00 00:00:00'))";
			$argsql1 .=  "  ORDER BY  left_sms_date ,ans_date ASC";
		  }elseif($stageskey == 3) {
			$argsql1 .=  " AND  fallow_date >= '".$lasttoday."'";
			$argsql1 .=  "  ORDER BY  fallow_date ASC";
		  }
		  
	    // echo $argsql1; 
		
		  
		 $argsql = mysql_query($argsql1);
		 $count = mysql_num_rows($argsql);
		  ?>
	   
		<h2><?php echo $getsalesheding;  if($count > 0) { ?> (<?php echo $count; ?>) <?php  } ?> </h2>
		<div class="scroll_c ui-droppable" id="container<?php echo $stageskey;?>">
		 
		<?php   
		if($count > 0) {  
		   ?>
		   <?php  	 
			 $i = 1;
			while($data = mysql_fetch_assoc($argsql)) {
	   
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

						$today1 = date('Y-m-d');
                        $getphone = CheckDoublephoneNumber($today1);	



               //ans_date | left_sms_date
			   
			   $classstyle = '';
		//if($stageskey == 1) {	   
			
			//if($data['task_type'] == 'site') {
			
		    if($stageskey == 1) {
				if(($data['ans_date'] != '0000-00-00 00:00:00'  || $data['left_sms_date'] != '0000-00-00 00:00:00'))	 {
				   $classstyle= '';
				}else{
				    $classstyle= 'background: #eccfcf;';
				}
			}
			
			if($stageskey == 2 && date('Y-m-d' ,  strtotime($data['createOn'])) < date('Y-m-d')) {
				$classstyle= 'background: #eccfcf;';
			}
			
			if(in_array($getq['phone'] , $getphone) || in_array($getq['email'] , $getphone)) { 
                 $classstyle= 'background: #e5d1ac;';
			}
        //}
			
	    ?>	
		 
		 
		
		   	<div <?php echo  $data['task_type']; ?>   class="box panel panel-info box-item box_color_1 getresponse_data<?php echo $data['id']; ?>"  id="<?php echo $data['id']; ?>" itemid="itm-<?php echo $i.'_'.$stageskey;?>" style="<?php echo $classstyle;  ?>"   <?php /*  if((in_array($getq['phone'] , $getphone) || in_array($getq['email'] , $getphone))) {  ?> style="background: #e5d1ac;"  <?php   } */  /* if($getq['booking_id'] != 0) {  ?> style="background-color: #c1eddb;" <?php  } */ ?>>
			   
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
		<?php   } } $i++;  } } else {?>	
			 
			<div class="box panel panel-info box_color">
			   <div class="panel-heading">
				  Not Found
			   </div>
			</div>  
	 <?php }  ?>
        </div>
	    <span id="updateed"></span>	 
		  </div>
		  
		 
     <?php  } ?>  
			

		  <script>

		  
		   // alert(location.protocol + "//" + location.hostname);
			
		   function show_schedule(id){
			    if(id == 3){
			       $('#show_schedule').toggle();
				}else if(id == 2) {
					$('#quote_step').toggle();
				}
		   }
		    
			function openModal(id){
				 $('#myModal').modal();
			      var DataString = 'id='+id;
						$.ajax({
							url: 'xjax/ajax/call_task_popup.php',
							type: 'POST',
							datatype: 'html',
							data: DataString,
							success: function(resp){
								$('#getdata').html(resp);
							} 

						}); 
			}  
			
			function set_message_type_button(id , fname){
				
				 var DataString = 'id='+id+'&page=fdata&fname='+fname;
						$.ajax({
							url: 'xjax/ajax/sales_button_show.php',
							type: 'POST',
							datatype: 'html',
							data: DataString,
							success: function(resp){
								$('#getdata').html(resp);
								//get_task_page(id);
							} 

						});  
			}  
		  
		  
		   function savefallowdate(id,type , keyid){
			  
             if(type == 1) {			  
			  var fallowdate = $('#fallow_created_date').val();
			  var schedule_time = $('#schedule_time').val();
			 }else {
				var fallowdate = '';
				var  schedule_time = '';
			 }
			   
			    
			   var DataString = 'id='+id+'&fallowdate='+fallowdate+'&page=schedule&schedule_time='+schedule_time+'&scheduletype='+type+'&keyid='+keyid;
			   
						$.ajax({
							url: 'xjax/ajax/sales_button_show.php',
							type: 'POST',
							datatype: 'html',
							data: DataString,
							success: function(resp){
								$('#getdata').html(resp);
							} 

						});  
		   }
					
    function quote_step(value , qid , fname , id){
		  var DataString = 'id='+id+'&qid='+qid+'&fname='+fname+'&page=stepupdate&value='+value;
		   
		            $.ajax({
							url: 'xjax/ajax/sales_button_show.php',
							type: 'POST',
							datatype: 'html',
							data: DataString,
							success: function(resp){
								$('#getdata').html(resp);
								
								if(fname == 'step') {
								  $('#quote_step').show();
								}
							} 
					});  
	}
	
	function send_details_to_cl(id , fname , type, textid){
		  var DataString = 'id='+id+'&type='+type+'&fname='+fname+'&page=emailsms&textid='+textid;
		  
		            $.ajax({
							url: 'xjax/ajax/sales_button_show.php',
							type: 'POST',
							datatype: 'html',
							data: DataString,
							success: function(resp){
								$('#getdata').html(resp);
								
								
							} 
					});  
	}
	
	 function getsidepanel(qid){
	  
				$('.modal').html();		
				send_data(qid,'53','myModal11');
				$('#myModal11').addClass('get_slide_data');
				$('.black_screen1').fadeIn(700);
    }



    $(document).ready(function(e){
		 
		    $('.black_screen1').click(function(e){
			   $('#myModal11').removeClass('get_slide_data');
			   $('.black_screen1').fadeOut(700);
		    });
    });
	
	function get_task_page(qid){
		
		//alert(qid);
		  var DataString = 'qid='+qid;
		   
		            $.ajax({
							url: 'xjax/refress_sales_data.php',
							type: 'POST',
							datatype: 'html',
							data: DataString,
							success: function(resp){
								//alert(resp);
								$('.getresponse_data'+qid).html(resp);
							} 
					});   
		
	}

					
			</script>		
		
  
	<div id="myModal11">
		   
		   </div>   
	</div>
	</div>
	</div>
	
	 <!-- Modal -->
	                <span class="show_data">
						  <div class="modal fade" id="myModal" role="dialog">
						  
						      <div class="modal-content" id="getdata">
							    
							  </div>
						  </div>
						
					</span>	  
	
<span id="updateed"></span>

</div>
</div>

<script>

	
	function set_message_type(id , fname){
		 var str = id+'|'+fname;
		 //var div = fname+'_'+id;
		 send_data(str , 556 , 'quote_view');
	} 
	
</script>
<script src="../adminsales_system/js/bootstrap.min.js"></script>