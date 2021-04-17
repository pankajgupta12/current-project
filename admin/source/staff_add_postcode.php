

<!--LightBox--------->		

	<div id="tab-5" >
		<form name="form1" method="post" action="">
			<div class="tab5_main_new tab5_main">
	      	<h4>Primary</h4>
			   <input class="formControl" name="name" type="text" id="primary_code" size="10" onkeypress="return isNumberKey(event)" autocomplete="off" maxlength="4" pattern="[0-9]{10}" required title="Please enter 4 digits"  value=""> 
			   <input type="button" class="myBtn" name="buttone_primary" value="Add PostCode" onClick="add_post_code('primary_code','<?php echo $_REQUEST['id'];?>','primary');">
			 
			<h4>Secondary</h4>
			  <input class="formControl" name="name" type="text" id="secondary_code" onkeypress="return isNumberKey(event)" autocomplete="off" maxlength="4" pattern="[0-9]{10}" required title="Please enter 4 digits"  size="10" value=""> 
			  <input type="button" class="myBtn" name="buttone_secondary" value="Add PostCode" onClick="add_post_code('secondary_code','<?php echo $_REQUEST['id'];?>','secondary');">
		    </div>
		</form>
	</div>
	
	<div  id="get_post_code">
	   <?php  include('xjax/get_postcode_data.php'); ?>
	</div>

	
	
	