<?php 
 $today = date('Y-m-d');
 $stagesdata = system_dd_type(103);
 $getsite = getSite();
 $getStepData = system_dd_type(31);
// print_r($stagesdata);
?>

<br/>
<br/>
	<div class="content cnt_box" id="re_page">
	<div class="row">
    <div class="mrg_btm20 ">
     <?php  foreach($stagesdata as $stageskey=>$getsalesheding) { ?>
       <div class="col-md-2 mrg_btm20 ">
	    
		<h2><?php echo $getsalesheding; ?></h2>
		<div class="scroll_c ui-droppable" id="container<?php echo $stageskey;?>">
		<?php  
	   
	   
	        $arg = "select id , name , step ,denied_id , site_id , email , phone , date,booking_date , booking_id from quote_new  where 1 = 1";
		    
			$arg .= " AND booking_date >= '".$today."' ";
			
	        if($stageskey == 1) {
				$arg .= " AND job_ref = 'Site' AND  stages = ".$stageskey." AND booking_id = '0'";
			}elseif($stageskey == 2){
				$arg .= " AND booking_id = '0' AND stages = ".$stageskey." ";
			}elseif($stageskey == 3 || $stageskey == 4 || $stageskey == 5){
				$arg .= "  AND step in (1,2,3,4) AND  stages = ".$stageskey." AND booking_id = '0'";
			}elseif($stageskey == 6){
				$arg .= "  AND  booking_id != '0'";
			}elseif($stageskey == 7){
				$arg .= " AND booking_id = '0' AND  step in (5,6,7,8,9,10 ,11,12)";
			}
		
			$arg .=  " order by id desc Limit 0 , 100";
			  echo  $arg;
			//echo $arg1;
			
			
			 $getquesql = mysql_query($arg);
			 
			if(mysql_num_rows($getquesql) > 0) {
		    $i = 1;
		    while($getq = mysql_fetch_assoc($getquesql)) { 
			
	    ?>	
		   	<div class="box panel panel-info box-item box_color_1 ui-draggable ui-draggable-handle"  id="<?php echo $getq['id']; ?>" itemid="itm-<?php echo $i.'-'.$stageskey;?>" <?php  if($getq['booking_id'] != 0) {  ?> style="background-color: #c1eddb;" <?php  } ?>>
			    <div class="panel-heading">
				   <h3><?php echo $getq['name'].'('.$getq['id'].')'; ?></h3>
				    <?php  if($getq['booking_id'] != 0) {?>
				      <p class="internet_icon"><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $getq['booking_id']; ?>','1200','850')"><?php echo $getq['booking_id']; ?></a></p> 
					<?php  } ?>
				   <p class="internet_icon"><?php echo $getsite[$getq['site_id']]; ?></p>
				   <p class="phone_icon"><a href="tel:<?php echo $getq['phone']; ?>"><?php echo $getq['phone']; ?></a></p>
				   <p class="envelope_icon"><?php echo $getq['email']; ?></p>
				   <p class="placeholder_icon"><?php echo $getq['booking_date']; ?></p>
				   
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
				
				   <p class="edit_icon"><a href="/admin/index.php?task=edit_quote&quote_id=<?php echo $getq['id']; ?>" target="_blank">Edit</a></p>
			    </div>
			</div>	  
			 <?php  $i++;  } } else {?>	
			 
			<div class="box panel panel-info box_color">
			   <div class="panel-heading">
				  Not Found
			   </div>
			</div>  
			 <?php  } ?>
        </div>
	<span id="updateed"></span>	 
		  </div>
		  
		  <script>

            $(document).ready(function() {
	 
						$('.box-item').draggable({
							cursor: 'move',
							helper: "clone"
						});
			  
						 
						$("#container<?php echo $stageskey;?>").droppable({
							
							drop: function(event, ui) {
								var itemid = ui.draggable.attr("itemid");
								var id = ui.draggable.attr("id");
									
								console.log(id);
							  
							     checkFlag = true;
							  
								$('.box-item').each(function() {
									if ($(this).attr("itemid") === itemid) {
										$(this).appendTo("#container<?php echo $stageskey;?>");
										//console.log('1');
										
										if(checkFlag == true) {
										   checkFlag = false;
										   send_data('<?php echo $stageskey;?>|'+id ,555, 'updateed');
										}
										
									}
								}); 
							}
						});
			});		
					  
			</script>		
		<?php  } ?>
  
	
	</div>
	</div>
	</div>
<span id="updateed"></span>
<style>

.box-item {
	z-index: 1000
}
</style>
</div>
</div>
<script>

     $(document).ready(function() {
	 
			$('.box-item').draggable({
				cursor: 'move',
				helper: "clone"
			});
  
			  
			    });				 
					
</script>
<script src="../adminsales_system/js/bootstrap.min.js"></script>
