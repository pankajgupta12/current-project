<div class="body_container">
	<div class="body_back">

    	<div class="wrapper">
			<div class="view_quote_back_box">
            	<?php  
				$getadminDetails =  mysql_fetch_array(mysql_query("SELECT * FROM `admin` where id= ".$_SESSION['admin'].""));
				?>
                <span class="main_head">Personal Details</span>
				<span class="" style="float:right;margin-top: -39px;">Welcome :- <?php echo ucfirst($getadminDetails['username']); ?></span>
                <ul class="create_quote_lst">
				
                    <li>
                    	<label>Name</label>
                        <input name="name" type="text" id="name" size="45" value="<?php echo $getadminDetails['name'] ?>">
                    </li>
                    <li>
                    	<label>Phone </label>
                        <input name="phone" type="text" id="phone" onkeypress="return isNumberKey(event)" autocomplete="off" maxlength="10" pattern="[0-9]{10}" required title="Please enter 10 digits"  value="<?php echo $getadminDetails['phone'] ?>" size="45">
                    </li>
                    <li>
                    	<label>Email </label>
                        <input name="email" type="text" id="email" value="<?php echo $getadminDetails['email'];?>" size="55">
                    </li>
                    <li>
                    	<label>Address</label>
                        <textarea name="address" cols="45" rows="3" id="address"><?php echo $getadminDetails['address'] ?></textarea>
                    </li>
                </ul>
				
				<span class="main_head">Theme Change</span>
				
                <!--<ul class="create_quote_lst">
                    <li>
                    	<label><p class="sub_head">Theme Change</p> </label>
							<span class="heading_area">
								<?php echo create_dd("theme_id","system_dd","id","name","type=39","Onchange=\"theme_change(this.value,".$getadminDetails['id'].");\"",$getadminDetails);?>                     
							</span>
                    </li>
					
					 <li><label><div class="theme_bg_color"></div></label>
					
					</li>
					
                </ul>-->
        	</div>
        </div>
    </div>
</div>
<script>
   function theme_change(themeid,userid){
	   var str = themeid+'|'+userid;
	   send_data(str,211,'theme_id');
	    location.reload();
   }
</script>