

<?php 
 $_SESSION['error_hr'] = '';
   if(isset($_POST['submit'])) {
		
		if(trim($_POST['tracks_id']) == '' || $_POST['tracks_id'] == 0) {
			$_SESSION['error_hr']['tracks_id'] = 'Track Type cannot be empty';
			$detailsdata['tracks_id'] = $_POST['tracks_id'];
		}
		
		if($_POST['track_heading'] == '' || $_POST['track_heading'] == 0) {
			$_SESSION['error_hr']['track_heading'] = 'Track Heading cannot be empty';
			$detailsdata['track_heading'] = $_POST['track_heading'];
		}
		
		
		if(trim($_POST['question']) == '') {
			
			$_SESSION['error_hr']['question'] = 'Question  cannot be empty';
			$detailsdata['question'] = $_POST['question'];
		}
		
	
		if(empty($_SESSION['error_hr'])) {
					
					 if($_POST['status'] == 0) {
						 $status = 1;
					 }	else{
						 $status = $_POST['status'];
					 }
						
	        $ins_arg = "insert into operation_checklist(tracks_id ,track_heading , qus,status) 
			value('".mres($_POST['tracks_id'])."','".mres($_POST['track_heading'])."','".mres($_POST['question'])."' , '".mres($status)."')";
			
		            //echo  $ins_arg;
					
			$ins = mysql_query($ins_arg);
			$app_id = mysql_insert_id();	
			$url = $_SERVER['SCRIPT_URI'].'?task=operation_question&action=Add';	  
			echo '<script>location.href="'.$url.'"</script>';	
			//header('Location : ../admin/?task=operation_question&action=Add');
			//die;
					
		}
	}
    if(isset($_POST['update'])) {
		
		// print_r($_POST); die;
		    $id = $_POST['id'];
			//echo "UPDATE operation_checklist SET tracks_id ='".$_POST['tracks_id']."' ,track_heading ='".$_POST['track_heading']."' ,qus ='".$_POST['question']."'  WHERE id = {$id}"; die; 
			
			        if($_POST['status'] == 0) {
						 $status = 1;
					 }	else{
						 $status = $_POST['status'];
					 }
			
			$qryBool = mysql_query("UPDATE operation_checklist SET tracks_id ='".$_POST['tracks_id']."' ,track_heading ='".$_POST['track_heading']."' ,qus ='".$_POST['question']."' ,status ='".$status."'  WHERE id = {$id}" );	
	       
		        //    echo  $ins_arg;
					
			$ins = mysql_query($qryBool);
		 $url = $_SERVER['SCRIPT_URI'].'?task=operations_list&action=List';	  
			echo '<script>location.href="'.$url.'"</script>';	 
	}
	
  if($_GET['opid']) {
	    $sql = mysql_query("SELECT * FROM `operation_checklist`   WHERE  id = ".mres($_GET['opid']).""); 
		$countResult = mysql_num_rows($sql);
		$detailsdata = mysql_fetch_assoc($sql);
  }	
	
	
	
	//print_r($detailsdata);
if(!empty($_SESSION['error_hr']) || !empty($detailsdata))  { 
 ?>

  <script>
        $(document).ready(function() {
			 <?php  if(!empty($detailsdata)) { ?>
			  get_sub_heading('<?php echo $detailsdata['tracks_id'];  ?>' , '<?php echo $detailsdata['track_heading'];  ?>');
			 <?php  }else { ?>
               get_sub_heading('<?php echo $_POST['tracks_id'];  ?>', '<?php echo $_POST['track_heading'];  ?>');
			 <?php  } ?>
        });
      </script>
<?php  } ?>
 
<form  method="post" action=""  enctype="">
   <div class="job_wrapper">
      <div class="job_back_box">
         <span class="add_jobs_text">Operation Question</span>
		    <span style="text-align: center;">
		  
					<?PHP if(!empty($_SESSION['error_hr']))  { 
						   foreach($_SESSION['error_hr'] as $key=>$value1) {
						?>
						  <p style="color:red;"><?php echo  $value1; ?></p>
					   <?php 
					   } 
					} 
					?>
		    </span>
         <span class="add_jobs_text" style="margin-top: -76px;"><input onclick="javascript:window.location='../admin/index.php?task=operations_list';" type="button" class="staff_button" value="List Application"></span>
         <ul class="add_lst">
            <li>
               <label> <font color="">Track Type</font> <font color="#FF0000" size="+1">*</font></label>
               <div> 
                        <span>
							<?php echo create_dd("tracks_id","system_dd","id","name","type = 112","onchange=\"javascript:get_sub_heading(this.value, 0);\"", $detailsdata);	?>
						</span>
               </div>
            </li>
			
			 <li>
               <label> <font color="">Track heading</font> </font> <font color="#FF0000" size="+1">*</font></label>
               <div> 
                      <span id="track_heading" >
							<?php // echo create_dd("track_heading","system_dd","id","name","type = 0","", $detailsdata);	?>
						</span>
               </div>
            </li>
			
			
            
			 <li>
               <label> <font color="">Question</font><font color="#FF0000" size="+1">*</font> </label>
               <div> 
                  <!--<input name="question" type="text" class="formfields" value="<?php if($detailsdata['qus'] != '') { echo $detailsdata['qus']; } ?>" size="35">--->
				  <textarea name="question" rows="10" cols="80" class="formfields"><?php if($detailsdata['qus'] != '') { echo $detailsdata['qus']; } ?></textarea>
               </div>
            </li>
			
			<!--<li>
               <label> <font color="">Conv Type</font> </label>
               <div> 
                        <span>
							<?php echo create_dd("status","system_dd","id","name","type = ","", $detailsdata);	?>
						</span>
               </div>
            </li>-->
			
			<li>
               <label> <font color="">Status</font> <font color="#FF0000" size="+1">*</font></label>
               <div> 
                        <span>
							<?php echo create_dd("status","system_dd","id","name","type = 57","", $detailsdata);	?>
						</span>
               </div>
            </li>
           
         </ul>
		 <?php  if(!empty($detailsdata)) { ?>
		    <input type="hidden" id="id" name="id" class="job_submit" value="<?php echo $detailsdata['id']; ?>">
			<span class="job_submit_main"><input type="submit" id="staff_add_data" name="update" class="job_submit" value="Update"></span>
			<?php  } else {?>
         <span class="job_submit_main"><input type="submit" id="staff_add_data" name="submit" class="job_submit" value="submit"></span>
			<?php  } ?>
      </div>
   </div>
</form>

<script>
	 function get_sub_heading(id , track_heading){
		
			if(track_heading == 0){
				track_heading = '';
			}else{
				track_heading = track_heading;
			}
			  var DataString = 'id='+id+'&track_heading='+track_heading+'&page=subhead';
			  
						$.ajax({
								url: 'xjax/get_trck_head.php',
								type: 'POST',
								datatype: 'html',
								data: DataString,
								success: function(resp){
									$('#track_heading').html(resp);
									
								} 
						});  
	 }
</script>