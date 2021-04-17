<?php 
 
        if(($_GET) && $_GET['cid'] !='') {
			
		   	 $sql = mysql_query("SELECT * FROM `bcic_reports` WHERE id = ".$_GET['cid'].""); 
		     $countResult = mysql_num_rows($sql);
			 
			 $getdata = mysql_fetch_assoc($sql);
		   
	    }
 
  //$_SESSION['error_hr'] = '';
    if(isset($_POST['update'])) {
		
		$bool =  mysql_query("update bcic_reports set type = '".$_POST['email_type']."' , name = '".$_POST['name']."' , email_from = '".$_POST['email_from']."' , email_to = '".$_POST['email_to']."' , status = '".$_POST['status']."' , type_for = '".$_POST['type_for']."' where id = '".$_POST['uid']."'");
		 
		if($bool) {
		// header('Location :  ../admin/index.php?task=crons_report');
		 header("Location: ../admin/index.php?task=crons_report");
		 die;
		}
		  
		
    } 
   
   
 ?>


<form  method="post" action=""  enctype="">
   <div class="job_wrapper">
      <div class="job_back_box">
         <span class="add_jobs_text">Crons Report</span>
		    <span style="text-align: center;">
		    </span>
         <span class="add_jobs_text" style="margin-top: -76px;"><input onclick="javascript:window.location='../admin/index.php?task=crons_report';" type="button" class="staff_button" value="List Crons Files"></span>
         <ul class="add_lst">
            <li>
               <label> <font color="">Email Type</font> <font color="#FF0000" size="+1">*</font></label>
               <div> 
                  <input name="email_type" type="text" class="formfields" value="<?php if($getdata['type'] != '') { echo $getdata['type']; } ?>" size="35"> 
				   <p style="font-size: 11px;color: red;">1=>Daily, 2=> Weekly</p>
               </div>
			   
            </li>
			
			 <li>
               <label> <font color="">Name</font> </label>
               <div> 
                  <input name="name" type="text" class="formfields" value="<?php if($getdata['name'] != '') { echo $getdata['name']; } ?>" size="35"> 
               </div>
            </li>
			
			 <li>
               <label> <font color="">Email From</font> <font color="#FF0000" size="+1">*</font></label>
               <div> 
                  <input name="email_from" type="text" class="formfields" value="<?php if($getdata['email_from'] != '') { echo $getdata['email_from']; } ?>" size="35"> 
               </div>
            </li>
			 <li>
               <label> <font color="">Email To</font> <font color="#FF0000" size="+1">*</font></label>
               <div> 
                  <input name="email_to" type="text" class="formfields" value="<?php if($getdata['email_to'] != '') { echo $getdata['email_to']; } ?>" size="35"> 
               </div>
            </li>
            
			 <li>
               <label> <font color="">Status</font><font color="#FF0000" size="+1">*</font> </label>
			    
               <div> 
			        <span>
					  <?php echo create_dd("status","system_dd","id","name","type=57","", $getdata);?>
					</span>
                  <!--<input name="status" type="text" class="formfields" value="<?php if($getdata['status'] != '') { echo $getdata['status']; } ?>" size="35"> -->
               </div>
            </li>
			
			 <li>
               <label> <font color="">Emails For</font><font color="#FF0000" size="+1">*</font> </label>
               <div> 
                  <input name="type_for" type="text" class="formfields" value="<?php if($getdata['type_for'] != '') { echo $getdata['type_for']; } ?>" size="35"> 
                  <p style="font-size: 11px;color: red;">1=>BCIC, 2=> BBC , 3=>ALL</p>
			   </div>
            </li>
	     </ul>
         <span class="job_submit_main"><input type="submit" id="staff_add_data" name="update" class="job_submit" value="Update"></span>
        <input type="hidden" id="staff_add_data" name="uid" value="<?php if($getdata['id'] != '') { echo $getdata['id']; } ?>"></span>
      </div>
   </div>
</form>

