<?php 
 
  $_SESSION['error_hr'] = '';
   if(isset($_POST['submit'])) {
		
		if($_POST['firstname'] == '') {
			$_SESSION['error_hr']['firstname'] = 'First name cannot be empty';
		}
		
		/* if($_POST['lastname'] == '') {
			
			$_SESSION['error_hr']['lastname'] = 'Please enter last name';
		} */
		
		
// 		if($_POST['email']==""){
// 		    $_SESSION['error_hr']['email'] = "Email Address cannot be empty";
// 		}elseif(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$_POST['email']))
// 		{ 
// 		   $_SESSION['error_hr']['email'] = "Invalid email";
// 		}
		
		if($_POST['mobile'] == '') {
			
			$_SESSION['error_hr']['mobile'] = 'Mobile number  cannot be empty';
		}
		
// 		if($_POST['date_of_birth'] == '') {
			
// 			$_SESSION['error_hr']['date_of_birth'] = 'Date of birth cannot be empty';
// 		}
		
		//  abn bsb account_number		
		
		/* if($_POST['abn'] == '') {
			
			$_SESSION['error_hr']['abn'] = 'Please enter ABN';
		}
		
		if($_POST['bsb'] == '') {
			
			$_SESSION['error_hr']['bsb'] = 'Please enter BSB';
		}
		
		if($_POST['account_number'] == '') {
			
			$_SESSION['error_hr']['account_number'] = 'Please Enter Account Number';
		} */
		
		
		/*if($_POST['post_code'] == '') {
			
			$_SESSION['error_hr']['post_code'] = 'Post Code  cannot be empty';
		}*/
		
	
	/*	echo '<pre>'; print_r($_POST);
		 die;*/
		 //	$_SESSION['error_hr']['already'] = "Email id & phone number already exists";
	//	 echo  "SELECT * FROM `staff_applications`   WHERE 1 = 1 AND  ( email = '".mres($_POST['email'])."' OR mobile  = '".mres($_POST['mobile'])."' ) "; die;
		 
		if($_POST['email'] != '') { 
		 
    		$sql = mysql_query("SELECT id FROM `staff_applications`   WHERE  email = '".mres($_POST['email'])."' "); 
    		$countResult = mysql_num_rows($sql);
    		
    		if($countResult > 0) {
    			
    				$_SESSION['error_hr']['already'] = "Email id already exists";
    			
    		}
		}
		
			if($_POST['mobile'] != '') {
			    
    			$sql1 = mysql_query("SELECT id FROM `staff_applications`   WHERE  mobile = '".mres($_POST['mobile'])."' "); 
        	     $countResult1 = mysql_num_rows($sql1);
        	     
        	   	if($countResult1 > 0) {
        			
        				$_SESSION['error_hr']['already'] = "Phone number already exists";
        			
        		}
			}
    	     
		
		if(empty($_SESSION['error_hr'])) {
					$getsite = mysql_fetch_array(mysql_query("SELECT count(*) as id,site_id   FROM `postcodes` WHERE `postcode` = '".mres($_POST['post_code'])."'"));

					if($getsite['id'] > 0 && $getsite['site_id'] != '') {
					    $site_id = $getsite['site_id'];
					}else{
				    	$site_id = $_POST['site_id'];
					}
					
					
					$services = array("services_cleaning","services_oven","services_bbq","services_gardening", "services_removal", "services_cleaner", "services_carpet", "services_pest", "services_handymen");
					$job_types = "";			
					
					foreach($services as $item)
					{ 
					    if ($_POST[$item]=="1")
						{ 
						   $job_types.=$item.","; 
						} 
					}		

					if($job_types!="")
					{ 
						$job_types = substr($job_types,0,-1);
						$_POST['job_types'] = $job_types;
					}
					
			$mobile = str_replace(" ","",$_POST['mobile']); 
						
						
	        $ins_arg = "insert into staff_applications(first_name ,last_name , application_reference , date_of_birth, email,mobile,date_started,step_status,post_code,site_id,job_types,admin_type,created_admin_id) 
			value('".mres($_POST['firstname'])."','".mres($_POST['lastname'])."','".mres($_POST['application_reference'])."', '".mres($_POST['date_of_birth'])."','".mres($_POST['email'])."','".mres($mobile)."','".date("Y-m-d")."','1','".mres($_POST['post_code'])."','".$site_id."', '".$job_types."', 'admin', '".$_SESSION['admin']."')";
			
		            //echo  $ins_arg;
					
			$ins = mysql_query($ins_arg);
			$app_id = mysql_insert_id();	
			$url = $_SERVER['SCRIPT_URI'].'?task=application_report';	  
			echo '<script>location.href="'.$url.'"</script>';	
					
		}
		 
			
		
    } 
   
 ?>


<form  method="post" action=""  enctype="">
   <div class="job_wrapper">
      <div class="job_back_box">
         <span class="add_jobs_text">Add Application</span>
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
         <span class="add_jobs_text" style="margin-top: -76px;"><input onclick="javascript:window.location='../admin/index.php?task=application_report';" type="button" class="staff_button" value="List Application"></span>
         <ul class="add_lst">
            <li>
               <label> <font color="">First Name</font> <font color="#FF0000" size="+1">*</font></label>
               <div> 
                  <input name="firstname" type="text" class="formfields" value="<?php if($_POST['firstname'] != '') { echo $_POST['firstname']; } ?>" size="35"> 
               </div>
            </li>
			
			 <li>
               <label> <font color="">Last Name</font> </label>
               <div> 
                  <input name="lastname" type="text" class="formfields" value="<?php if($_POST['lastname'] != '') { echo $_POST['lastname']; } ?>" size="35"> 
               </div>
            </li>
			
			 <li>
               <label> <font color="">Email</font> </label>
               <div> 
                  <input name="email" type="text" class="formfields" value="<?php if($_POST['email'] != '') { echo $_POST['email']; } ?>" size="35"> 
               </div>
            </li>
            
			 <li>
               <label> <font color="">Phone</font><font color="#FF0000" size="+1">*</font> </label>
               <div> 
                  <input name="mobile" type="text" class="formfields" value="<?php if($_POST['mobile'] != '') { echo $_POST['mobile']; } ?>" size="35"> 
               </div>
            </li>
            
            <li>
               <label> <font color="">Date Of Birth </font></label>
               <div> 
                  <input name="date_of_birth" type="text" id="job_date" class="date_class  formfields" value="<?php if($_POST['date_of_birth'] != '') { echo $_POST['date_of_birth']; } ?>" size="35"> 
               </div>
            </li>
			
			 <!--<li>-->
    <!--           <label> <font color="">ABN</font> </label>-->
    <!--           <div> -->
    <!--              <input name="abn" type="text" class="formfields" value="<?php if($_POST['abn'] != '') { echo $_POST['abn']; } ?>" size="35"> -->
    <!--           </div>-->
    <!--        </li>-->
			
			
			 <!--<li>-->
    <!--           <label> <font color="">BSB</font> </label>-->
    <!--           <div> -->
    <!--              <input name="bsb" type="text" class="formfields" value="<?php if($_POST['bsb'] != '') { echo $_POST['bsb']; } ?>" size="35"> -->
    <!--           </div>-->
    <!--        </li>-->
			
			 <!--<li>-->
    <!--           <label> <font color="">Account Number</font> </label>-->
    <!--           <div> -->
    <!--              <input name="account_number" type="text" class="formfields" value="<?php if($_POST['account_number'] != '') { echo $_POST['account_number']; } ?>" size="35"> -->
    <!--           </div>-->
    <!--        </li>-->
			
			
			
			 <li>
               <label> <font color="">PostCode</font></label>
               <div> 
                  <input name="post_code" type="text" class="formfields" value="<?php if($_POST['post_code'] != '') { echo $_POST['post_code']; } ?>" size="35"> 
               </div>
            </li>
           
            <li>
               <label> <font color="">Reference</font> </label>
               <div> 
                  <span>
                      
                      <?php echo create_dd("application_reference","system_dd","id","name","type=56","",$_POST);?>
							<?php // echo create_dd("site_id","sites","id","name","","", $_POST);?>
				 </span>
               </div>
            </li>
            
            <li>
               <label> <font color="">Site id</font> </label>
               <div> 
                  <span>
							<?php echo create_dd("site_id","sites","id","name","","", $_POST);?>
				 </span>
               </div>
            </li>
			
		<li>
		    <label>
			<font color="">Job Type</font> 
		  	 </label>
		    <div> 
			    <ul class="hr_application">			  
					<li> <input type="checkbox" name="services_removal" id="services_removal" value="1" <?php if($_POST['services_removal'] == 1) {echo 'checked';}  ?>> Removal </li>
					<li> <input type="checkbox" name="services_cleaning" id="services_cleaning" value="1"  <?php if($_POST['services_cleaning'] == 1) {echo 'checked';}  ?>>Cleaning</li>
					<li>  <input type="checkbox" name="services_carpet" id="services_carpet" value="1"  <?php if($_POST['services_carpet'] == 1) {echo 'checked';}  ?>>Carpet</li>
					<li>  <input type="checkbox" name="services_bbq" id="services_bbq" value="1"  <?php if($_POST['services_bbq'] == 1) {echo 'checked';}  ?>>BBQ </li>
					<li>  <input type="checkbox" name="services_pest" id="services_pest" value="1"  <?php if($_POST['services_pest'] == 1) {echo 'checked';}  ?>>Pest</li>
					<li>  <input type="checkbox" name="services_handymen" id="services_handymen" value="1"  <?php if($_POST['services_handymen'] == 1) {echo 'checked';}  ?>>Handymen</li>
					<li>  <input type="checkbox" name="services_gardening" id="services_gardening" value="1"  <?php if($_POST['services_gardening'] == 1) {echo 'checked';}  ?>>Gardening</li>
				</ul>		
			   
		    </div>
		</li>
		<!--<li>
		
			<label for="inputEmail3">Code = <?php echo get_calc(); ?></label>
			 <div> 
			   	<input type="hidden" name="captcha_phrase" value="<?php echo $_SESSION['captcha_phrase']; ?>">
				     <input name="code" type="text" class="formfields" value="" size="35"> 
		 </div> 
				  
		</li>-->		  
			
			
           
         </ul>
         <span class="job_submit_main"><input type="submit" id="staff_add_data" name="submit" class="job_submit" value="submit"></span>
      </div>
   </div>
</form>

<style>

 .hr_application > li {
	     font-size: 19px;
   list-style-type: none;
    float: left;
    display: inline-block;
    width: auto;
    font-size: 14px;
    margin: 5px;
}

    #ui-datepicker-div{
        z-index: 999 !important;
    }
    
</style>