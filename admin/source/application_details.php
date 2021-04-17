<?php 
  $services = array("services_cleaning","services_oven","services_bbq","services_gardening", "services_removal", "services_cleaner", "services_carpet", "services_pest", "services_handymen");
    $applicationID = $_GET['appl_id'];
	 $argx = "select * from staff_applications where id='".mysql_real_escape_string($applicationID)."'"; 
	//echo $argx; echo $a;	
	$datax = mysql_query($argx);
	$getAppdata = mysql_fetch_assoc($datax); 
//	echo "<pre>"; print_r($getAppdata); die;
	
	
	$jobType = $getAppdata['job_types'];
	
	//echo "<pre>"; print_r($jobType); 
	
// 			$jobType =  ucwords(str_replace('services_',' ',$getAppdata['job_types']));
// 				$jobtype1 = explode(',',str_replace('_' , ' ' ,$jobType));  
			
// 			foreach($jobtype1 as $jobvalue) {
// 		    //	$getjobdetails[] = "'".$jobvalue."'";
// 		    	$getjobdetails[] = "'".trim($jobvalue)."'";
// 			}
            
             $val =   implode(",",$getjobdetails); 
			   //$getjobIcone = mysql_query("SELECT job_icon,name  FROM `job_type` WHERE `name` IN (".str_replace(' ','',implode(",",$getjobdetails)).")"); 
			   
			   //echo "SELECT job_icon,name  FROM `job_type` WHERE `name` IN (".$val.")"; 
			 	// $getjobIcone = mysql_query("SELECT job_icon,name  FROM `job_type` WHERE `name` IN (".$val.")"); 
	
	
	?>
	<style>
	    .create_quote_lst > li label, .clean_lst li label, .frm_rght_lst > li label{
			  width: 40%;
		}
		
	.create_quote_lst > li input, .frm_rght_lst > li input {
		width: 110%;
		display: inline-block;
		border: 1px solid #e8e7e7;
		background: #fff;
		border-radius: 5px;
		height: 31px;
		font-size: 14px;
		color: #6c6c6c;
		padding: 0 10px;
		float: right;
	}
		
	</style>
<div class="body_container">
	<div class="body_back">
		<form method="post" id="form">
    	<div class="wrapper" style="width: 80%;">
    	    <div class="black_screen1"></div>
        		<span class="main_head" >Application Details</span>
        		<span class="sub_main_head">Application Status :<?php echo getSystemvalueByID($getAppdata['step_status'],55); ?></span>
				
				<span class="last_login_date">Last login date : <?php echo date('dS M Y H:i:s A',strtotime($getAppdata['last_login_date'])); ?></span>
                <ul class="create_quote_lst">
                    <li>
                    	<label>Application ID </label>
						<label><?php echo $getAppdata['id']; ?></label>
                    </li>
					
                    <li>
                    	<label>Site ID </label>
						<label><?  //if($getAppdata['site_id'] != '0') { echo get_rs_value("sites","name",$getAppdata['site_id']);}else{echo "N/A"; } ?>
						<?php echo create_dd("site_id","sites","id","name","","onChange=\"javascript:edit_field(this,'staff_applications.site_id','".$getAppdata['id']."');\"",$getAppdata);?>
						</label>
                    </li>
					
                    <li>        
   					   <label>First Name</label>
						<!--<label><?php if($getAppdata['first_name'] != "") { echo ucwords($getAppdata['first_name']); }else{echo "N/A";} ?></label>-->
						<label><input name="first_name" type="text" id="first_name" size="45" value="<?php if($getAppdata['first_name'] != "") { echo $getAppdata['first_name']; } ?>" onblur="javascript:edit_field(this,'staff_applications.first_name','<?php echo $getAppdata['id']; ?>');"></label>
                    </li>
					
					 <li>
                    	<label>Last Name</label>
						<!--<label><?php if($getAppdata['last_name'] != "") { echo ucwords($getAppdata['last_name']);}else{echo "N/A";} ?></label>-->
						<label><input name="last_name" type="text" id="last_name" size="45" value="<?php if($getAppdata['last_name'] != "") { echo $getAppdata['last_name']; } ?>" onblur="javascript:edit_field(this,'staff_applications.last_name','<?php echo $getAppdata['id']; ?>');"></label>
                    </li>
					
                    <li>
                    	<label>Email</label>
						<!--<label><?php echo $getAppdata['email']; ?></label>-->
						<label><input name="email" type="text" id="email" size="45" value="<?php if($getAppdata['email'] != "") { echo $getAppdata['email']; } ?>" onblur="javascript:edit_field(this,'staff_applications.email','<?php echo $getAppdata['id']; ?>');"></label>
                    </li>
					
                    <li>        
   					   <label>Secret</label>
						<label><?php if($getAppdata['secret'] != "") {  echo $getAppdata['secret']; } else { echo "N/A"; } ?></label>
                    </li>
					
					 <li>
                    	<label>Mobile</label>
						<!--<label><?php if($getAppdata	['mobile'] != "") {  echo $getAppdata['mobile']; } else { echo "N/A"; } ?></label>-->
						<label><input name="mobile" type="text" id="mobile" size="45" value="<?php if($getAppdata['mobile'] != "") { echo $getAppdata['mobile']; } ?>" onblur="javascript:edit_field(this,'staff_applications.mobile','<?php echo $getAppdata['id']; ?>');"></label>
                    </li>
					
					 <li>
                    	<label>DOB</label>
						<label><input name="date_of_birth" type="text" id="date_of_birth" class="date_class" size="45" value="<?php if($getAppdata['date_of_birth'] != "") { echo $getAppdata['date_of_birth']; } ?>" onChange="javascript:edit_field(this,'staff_applications.date_of_birth','<?php echo $getAppdata['id']; ?>');"></label>
                    </li>
					
                    <li>
                    	<label>Phone</label>
						<!--<label><?php if($getAppdata['phone'] != "") { echo $getAppdata['phone']; } else { echo "N/A"; } ?></label>-->
						<label><input name="phone" type="text" id="phone" size="45" value="<?php if($getAppdata['phone'] != "") { echo $getAppdata['phone']; } ?>" onblur="javascript:edit_field(this,'staff_applications.phone','<?php echo $getAppdata['id']; ?>');"></label>
                    </li>
					
					
                    <li>        
   					   <label>Account Number</label>
						<!--<label><?php if($getAppdata['account_number'] != "") {  echo $getAppdata['account_number']; } else { echo "N/A"; } ?></label>-->
						<label><input name="account_number" type="text" id="account_number" size="45" value="<?php if($getAppdata['account_number'] != "") { echo $getAppdata['account_number']; } ?>" onblur="javascript:edit_field(this,'staff_applications.account_number','<?php echo $getAppdata['id']; ?>');"></label>
                    </li>
					
					 <li>
                    	<label>BSB</label>
						<!--<label><?php if($getAppdata['bsb'] != "") {  echo $getAppdata['bsb']; } else { echo "N/A"; } ?></label>-->
						<label><input name="bsb" type="text" id="bsb" size="45" value="<?php if($getAppdata['bsb'] != "") { echo $getAppdata['bsb']; } ?>" onblur="javascript:edit_field(this,'staff_applications.bsb','<?php echo $getAppdata['id']; ?>');"></label>
                    </li>
					
                    <li>
                    	<label>GST</label>
						<label><?php if($getAppdata['staff_gst'] == 1) { echo 'Yes'; } else { echo "No"; } ?></label>
						<!--<label><input name="staff_gst" type="text" id="staff_gst" size="45" value="<?php if($getAppdata['staff_gst'] != "") { echo $getAppdata['staff_gst']; } ?>" onblur="javascript:edit_field(this,'staff_applications.staff_gst','<?php echo $getAppdata['id']; ?>');"></label>-->
                    </li>
					
                    <li>        
   					   <label>Business Name</label>
						<!--<label><?php if($getAppdata['business_name'] != "") {  echo ucwords($getAppdata['business_name']);} else { echo "N/A"; }  ?></label>-->
						
						<label><input name="business_name" type="text" id="business_name" size="45" value="<?php if($getAppdata['business_name'] != "") { echo $getAppdata['business_name']; } ?>" onblur="javascript:edit_field(this,'staff_applications.business_name','<?php echo $getAppdata['id']; ?>');"></label>
						
                    </li>    
					
                    <li>
                    	<label>Address</label>
						<!--<label><?php if($getAppdata['address'] != "") {  echo ucwords($getAppdata['address']);} else { echo "N/A"; } ?></label>-->
						<label><input name="address" type="text" id="address" size="45" value="<?php if($getAppdata['address'] != "") { echo $getAppdata['address']; } ?>" onblur="javascript:edit_field(this,'staff_applications.address','<?php echo $getAppdata['id']; ?>');"></label>
                    </li>
					
					<li>
                    	<label>Post Code</label>
						<!--<label><?php if($getAppdata['post_code'] != "") {  echo ucwords($getAppdata['post_code']);} else { echo "N/A"; } ?></label>-->
						<label><input name="post_code" type="text" id="post_code" size="45" value="<?php if($getAppdata['post_code'] != "") { echo $getAppdata['post_code']; } ?>" onblur="javascript:edit_field(this,'staff_applications.post_code','<?php echo $getAppdata['id']; ?>');"></label>
                    </li>
					
					<li>
					 <label>ABN</label>
						<!--<label><?php if($getAppdata['abn'] != "") {  echo strtoupper($getAppdata['abn']); } else { echo "N/A"; } ?></label>-->
						<label><input name="abn" type="text" id="abn" size="45" value="<?php if($getAppdata['abn'] != "") { echo $getAppdata['abn']; } ?>" onblur="javascript:edit_field(this,'staff_applications.abn','<?php echo $getAppdata['id']; ?>');"></label>
                    </li>
					
					
                    <li>
                    	<label>Team of</label>
						<label><?php  // if($getAppdata['team_of'] != "") { echo $getAppdata['team_of']; } else { echo "N/A"; }?>
						  <?php echo create_dd("team_of","system_dd","id","name","type = 48","onChange=\"javascript:edit_field(this,'staff_applications.team_of','".$getAppdata['id']."');\"",$getAppdata);?>
						</label>
                    </li>
					
                    <li>        
   					   <label>Days Available</label>
						<label><?php if($getAppdata['days_available'] != "") { echo ucwords(str_replace('avail_',' ',$getAppdata['days_available']));} else { echo "N/A"; } ?></label>
                    </li> 
					
                    <li>
                    	<label>Date Submission</label>
						<label><?php if($getAppdata['date_submission'] != "0000-00-00") { echo date("dS M Y",strtotime($getAppdata['date_submission']));} else { echo "N/A"; } ?></label>
                    </li>
					
                    <li>        
   					   <label>Date Started</label>
						<label><?php echo date("dS M Y",strtotime($getAppdata['date_started'])); ?></label>
                    </li>
                    
                    	<li style="width: 100%;float: right; margin-top: 31px;">
                    	    
                    	<label>Job Types</label>
						    <ul class="job_typesinfo" style="margin-left: 108px;padding-left: revert;margin-top: -21px;">
						        
						    <?php 
						    foreach($services as $key=>$val) { ?>
						       <li>    <input type="checkbox" name="job_type" id="job_type_<?php echo $key; ?>" onClick="updateJobTypes(this , '<?php echo $key; ?>' , '<?php   echo  $getAppdata['id']; ?>');" value="<?php echo $val; ?>"  <?php  if(in_array($val ,  explode(',',$jobType))) { echo 'checked'; } ?>> <?php echo ucfirst(str_replace('services_' , '' ,$val)); ?></li>
						      <?php }  ?>
						  </ul>    
						   <? 
						    /* while($qd = mysql_fetch_assoc($getjobIcone)){  
							?>
							<img class="image_icone" src="icones/job_type32/<?php echo $qd['job_icon']." "; ?>" alt="<?php echo $qd['job_icon']." "; ?>" title="<?php echo $qd['name']." "; ?>">
							<?php }   */   ?>
                    </li>
                      					
                </ul>
        	</div>
            
            
            </div>
        </div>
		</form>
    </div>
</div>

<script>

 function updateJobTypes(obj , key , id){
     
     
     
   // var last_quote_id = $('#last_quote_id').val();
    
    var checkValue = $('#job_type_'+key).prop("checked");
    if(checkValue == true) {
    var checkValueData = 1;
    }else if(checkValue == false){
    var checkValueData = 0;
    } 
       
    str = obj.value+'|'+checkValueData+'|'+id;
    
   // console.log(str);
    
    divid = 'job_type_'+key;
    
    send_data(str, 642, divid);
    
   // console.log(checkValueData);
 }


</script>
<style>
 .job_typesinfo li {
     float: right;
    display: inline-block;
    width: 100%;
    font-size: 19px;
    list-style-type: none;
    float: left;
    display: inline-block;
    width: auto;
    font-size: 14px;
    margin: 5px;

}
 }
</style>