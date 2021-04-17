<?php  

  
  
  if(!isset($_SESSION['monthly_admin_roster']['from_date'])){ $_SESSION['monthly_admin_roster']['from_date'] = date('Y-m-1'); }
  if(!isset($_SESSION['monthly_admin_roster']['permanent_role'])){ $_SESSION['monthly_admin_roster']['permanent_role'] = 0; }
  // $permanent_id = $_SESSION['monthly_admin_roster']['permanent_role'];
  $adminname =  getAdminname($_SESSION['monthly_admin_roster']['permanent_role']);
   $getdate = $_SESSION['monthly_admin_roster']['from_date'];
  
   $month = date('m', strtotime($getdate));
  
    $getDateList = [];
  
    for($i = 1; $i<= date('t' , strtotime($getdate)); $i++) {
		$getDateList[] = date('Y-m-d', strtotime(date("Y-$month-$i")));
	} 
  
  $leaveType = array('1'=>'WO','2'=>'AL','3'=>'NS');
  
 ?>
  
 <br/>
 <br/>
		<div class="right_text_boxData right_text_box">
		  <div class="midle_staff_box"><span class="midle_text">Total Records <?php  //echo   $count; ?> </span></div>
		</div>
<br/>
     <h2>Monthly Roster Working<h2>
            <table class="user-table" border="1px">
					<thead>
					    <tr>
						<th>Date</th> 
						<?php    foreach($getDateList as $key=>$date) {  ?>
							<th><?php echo date('dS M ' , strtotime($date)); ?></th> 
						<?php  }   ?>
						</tr>
						
						 <tr>
						  <th></th> 
							<?php    foreach($getDateList as $key=>$date) {  ?>
							<th><?php echo date('D  ' , strtotime($date)); ?></th> 
							<?php  } ?>
						 </tr>
					</thead>
					
					<?php   foreach($adminname as $key=>$name) 
					{  
					  $adminroster =  getAdminRoster($key, $getdate, $permanent_id);
					  $permanent_role = '';
					  $permanent_role1 =  get_rs_value('admin','permanent_role',$key);
					if($permanent_role1 > 0) {
				    	$permanent_role = '( '.getSystemvalueByID($permanent_role1, 155).')';
					}
					?>
					
						<tr>
						  <td>
						  <?php  if(in_array($_SESSION['admin'] ,  array(1,17,12,66,91))) { ?>    
						      <a href="javascript:void(0);" onclick="javascript:scrollWindow('admin_popup.php?task=weekly_upcoming_work&action=modify&id=<?php echo $key; ?>','1200','850');">
						      <?php echo ucfirst($name); ?></a>
						  <?php  }else { ?>    
						  <?php echo ucfirst($name) .$permanent_role; ?>
						  <?php  } ?>
						  </td>
						    <?php  foreach($getDateList as $key=>$date) {  
						  
						      // getAdminRoster($adminid, $date);
							  
							  /* onClick="showdetails('<?php echo date('dS M Y (l)', strtotime($date)); ?>','<?php echo $name; ?>' , '<?php echo $adminroster[$date]['startau']; ?>', '<?php echo $adminroster[$date]['endau']; ?>', '<?php echo $adminroster[$date]['endau']; ?>', '<?php echo $adminroster[$date]['lunchstart']; ?>', '<?php echo $adminroster[$date]['lunchend']; ?>');" */
							  
							  
						    ?>
							<td id="box_<?php echo str_replace('-','_',$date); ?>" for='<?php  //echo   $adminroster[$date]['start_time_au'] . ' == '. date('l' , strtotime($date));  ?>' style="<?php  if(in_array(date('l' , strtotime($date)) ,  array('Saturday','Sunday') )) {  echo 'background: #f3f384;';  }else  {  if($adminroster[$date]['startau'] != '') { echo 'background: #c2e4c2;'; } else if(empty($adminroster[$date]) && $adminroster[$date]['startau'] == '') { echo 'background: #e2bdbd;'; } }  ?>">
							<?php  
							
							 
							
							if(in_array($_SESSION['admin'] ,  array(1,12,17,66,91))) {
							
							if(!empty($adminroster[$date])) {
							      
							     
							     
							?>    
							   <a class="button"  href="#popup1" onClick="showdetails('<?php echo $adminroster[$date]['id']; ?>', '<?php echo $name; ?>','<?php echo date('dS M Y (l)', strtotime($date)); ?>');" >
							       <?php 
							        if($adminroster[$date]['leave_type'] == 0) {
							       if($adminroster[$date]['roster_type'] == 1) {
							           if($adminroster[$date]['startau'] != '') {  echo $adminroster[$date]['startau'].'<hr style="width: 26px;margin-left: 13px;"/>'.$adminroster[$date]['endau'];  } else if($adminroster[$date]['id'] != '') {echo 'Click';} 
							       }else if($adminroster[$date]['roster_type'] == 2) {
							        if($adminroster[$date]['start_time_au'] != '') {  echo $adminroster[$date]['start_time_au'].'<hr style="width: 26px;margin-left: 13px;" />'.$adminroster[$date]['end_time_au'];  } else if($adminroster[$date]['id'] != '') {echo 'Click';} 
							       }
							       
							       ?>
							      
							   <?php }else {  echo $leaveType[$adminroster[$date]['leave_type']]; } ?> </a> <?php }else{echo '';}  } else { ?>
							    
							   <?php 
    							   	if(!empty($adminroster[$date])) {
    							   	    
        							   	if($adminroster[$date]['leave_type'] == 0) {    
        							     if($adminroster[$date]['roster_type'] == 1) {
        							         if($adminroster[$date]['startau'] != '') {  echo $adminroster[$date]['startau'].'<hr style="width: 26px;margin-left: 13px;"/>'.$adminroster[$date]['endau'];  } 
        							     }else if($adminroster[$date]['roster_type'] == 2) {
        							          if($adminroster[$date]['start_time_au'] != '') {  echo $adminroster[$date]['start_time_au'].'<hr style="width: 26px;margin-left: 13px;"/>'.$adminroster[$date]['end_time_au'];  } 
        							     }
        							   	}else{
        							   	  echo $leaveType[$adminroster[$date]['leave_type']];  
        							   	}
    							   	}
							   
							   ?>
							   <?php  } ?>
							</td> 
							
						  <?php  } ?>
						</tr>
					<?php  }  ?>
					   
						
					  
				<tbody>
				</tbody>
            </table>
			        <div class="monthly_roster_class"  >
			      	         <div id="popup1" class="overlay" style="display:none;">
							    <div class="popup" id="popupshowinfo">
								
								</div>
							</div>	
					   
					</div>  
		<script>
		  
		   /* function showdetails(date , name , start,end,lunchs,lunchend){
			   
			   //console.log(name , start,end,lunchs,lunchend);
			   $('#popup1').show();
			   $('#head').text(name+' Shift Time On '+date);
			   $('#shifttime').html('Start Time=> '+ start+'<br/> Lunch Time=> '+ lunchs+' <br/> End Lunch Time=> '+ lunchend+' <br/> End  Time=> '+ end);
		   } */
		 
		 
        function updateRoster(id, date, adminid){
			holdloader(1);
			
			var updateroster = $('#updateroster').val();
			var start_time_au = $('.content_'+ updateroster+' #start_time_au').val();
			var  lunch_time_au = $('.content_'+ updateroster+' #lunch_time_au').val();
			var  lunch_end_time_au = $('.content_'+ updateroster+' #lunch_end_time_au').val();
			var end_time_au = $('.content_'+ updateroster+' #end_time_au').val();
			var leave_type = $('#leave_type').val();
			
			    var parms = {
				  'start_time_au' :start_time_au,
				  'lunch_time_au' :lunch_time_au,
				  'lunch_end_time_au' :lunch_end_time_au,
				  'end_time_au' :end_time_au,
				  'date' :date,
				  'adminid' :adminid,
				  'id' :id,
				  'updateroster':updateroster,
				  'leave_type':leave_type
			    }
			
			 console.log(parms);
			
			    $.ajax({
					url:'xjax/update_roster_info.php',
					method:'POST',
					dataType: 'text',
					data:parms,
					
				    success:function(result){
					   if(result == 1) {
					     $('#update_roster').show();
						 holdloader(2);
					   }else{
					       $('#update_roster').hide();
						   holdloader(2);
					   }
				    }
		        }); 
		}
		 
	   function changeRoster(){
	       
				var updateroster = $('#updateroster').val();
				if(updateroster == 1) {
				    $('#auto_shifttime').show();
				    $('#custom_shifttime').hide();
				}else{
                    $('#auto_shifttime').hide();
                    $('#custom_shifttime').show();
				}
	   }	 
		 
	  function leaveCheck(id){
	      var updateroster = $('#updateroster').val();
	      if(id != 0) {
            $('.content_'+ updateroster+' #start_time_au').val(0);
            $('.content_'+ updateroster+' #lunch_time_au').val(0);
            $('.content_'+ updateroster+' #lunch_end_time_au').val(0);
            $('.content_'+ updateroster+' #end_time_au').val(0);
	      }
	      
	  }	 
		 
        function holdloader(typeid) {
			 if(typeid == 1) {
				$('#loaderimage_1').show();
				$('.full_loader').attr('id','bodydisabled_1'); 
			 }else{
				$('#loaderimage_1').hide();
				$('.full_loader').attr('id','');
			 }
			
		}
		   
		   
		function showdetails(id,name, date){  
				holdloader(1);
		      $('#popup1').show();
		        var parms = {
				  'id' :id,
				  'name' :name,
				  'date' :date
			    }
		
		        $.ajax({
                   url:'xjax/view_roster_info.php',
                   method:'POST',
                   dataType: 'text',
                   data:parms,
				   success:function(result){
					   $('#popupshowinfo').html(result);
					    holdloader(2);
				   }
			  
		        }); 
		}
		   
		  
		</script>					
					 
		<style>
		span .formfields {
			font-size: 16px;
			margin-left: 98px;
			margin: 8px;
		}
		
		.monthly_roster_class .overlay {
		  position: fixed;
		  top: 93px;
		  bottom: 0;
		  left: 0;
		  right: 0;
		  background: rgba(0, 0, 0, 0.7);
		  transition: opacity 500ms;
		  visibility: hidden;
		  opacity: 0;
		}
		.monthly_roster_class .overlay:target {
		  visibility: visible;
		  opacity: 1;
		}

		.popup {
		  margin: 70px auto;
		  padding: 20px;
		  background: #fff;
		  border-radius: 5px;
		  width: 35%;
		  position: relative;
		  transition: all 5s ease-in-out;
		}


		.popup .close {
		position: absolute;
		top: -4px;
		right: 15px;
		transition: all 200ms;
		font-size: 30px;
		font-weight: bold;
		text-decoration: none;
		color: #333;
		}
		.popup .close:hover {
		  color: #06D85F;
		}
		.popup .content {
			max-height: 30%;
			overflow: auto;
			font-size: 19px;
			padding: 12px;
			margin: 8px;
		}
		#shifttime p{
			margin: 7px;
		}
		.individual_roster_update {
			padding: 7px;
			width: 200px;
			float: right;
			cursor: pointer;
			background: #b8eae3;
			border: 0px solid #b8eae3;
			right: 33px;
			margin-top: -50px;
		}
        .user-table tbody, .user-table tbody tr {
            border: 1px solid #dcdcdc;
            text-align: center;
            font-size: 10px;
            font-family: 'OpenSans';
        }

		</style>	