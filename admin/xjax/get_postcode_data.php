<?php  
if($_REQUEST['id'] != '') {
$staffid = $_REQUEST['id'];
}

$checkPostCode = mysql_fetch_array(mysql_query("SELECT site_id,site_id2,primary_post_code,secondary_post_code from staff where id= '".$staffid."'"));
//print_r($checkPostCode['primary_post_code']);
?>

                        <div class="mainSection" id="primary_div">
				
					       <h4>Primary</h4>	   
						   <div>
						   <?php   if($checkPostCode['primary_post_code'] != '') { ?>
						     <ul>
							 <?php  foreach(explode(',',$checkPostCode['primary_post_code']) as $key=>$value) {?>
							    <li><?php echo $value; ?><span id="p_<?php echo $value; ?>" onClick="send_data('<?php echo $value; ?>|<?php  echo $staffid; ?>|primary_post_code','232','get_post_code');">X</span></li>
							    
							 <?php }   ?>
						     </ul>
							<?php  }else{ ?> 
							<p style="padding: 4px;margin-left: 77px;">No Record Found</p>
							<?php  } ?>
						   </div>
						</div>
						
						<div class="mainSection" id="secondary_div">
						<h4>Secondary</h4>	  
						    <div>
							 <?php  if($checkPostCode['secondary_post_code'] != '') { ?>
						     <ul>
							  <?php 
							   foreach(explode(',',$checkPostCode['secondary_post_code']) as $key=>$value1) { ?>
							    <li><?php  echo $value1; ?><span id="s_<?php echo $value1; ?>" onClick="send_data('<?php echo $value1; ?>|<?php  echo $staffid; ?>|secondary_post_code','232','get_post_code');">X</span></li>
							  <?php }  ?>
						     </ul>
							 <?php  } else{ ?> 
							<p style="padding: 4px;margin-left: 77px;">No Record Found</p>
							<?php  } ?>
						    </div>
						    <!--<textarea type="text" id="secondary_code_value" value="<?php  //if($checkPostCode['secondary_post_code'] != '') { echo $checkPostCode['secondary_post_code']; } ?>" />-->
						</div>