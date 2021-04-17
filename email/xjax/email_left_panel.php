            	<ul class="nav nav-pills nav-stacked">
				    <li>
					       <!--<a href="javascript:void(0);" <?php  if($_SESSION['sent_new_msg_type'] != '' && $_SESSION['sent_new_msg_type'] != '0') { ?> class="compose_button"  <?php  }else { ?> class="disabled_compose_button" <?php  } ?> ><span class="badge pull-right"></span> Compose </a>-->
						   
						   <a href="javascript:void(0);"  <?php if($_SESSION['new_message'] == 'new_message') {  ?> class="disabled_compose_button" <?php   } else { ?> class="compose_button"  onClick="send_data('new_message', 24,'quote_view')" <?php  } ?>><span class="badge pull-right"></span> Compose </a>
					</li> 
					
                        <?php 
						  
							    $getEmailFolder  = getEmailFolderName(); 
								 
								 foreach($getEmailFolder as $key=>$folderName) {
						     ?>
							<li <?php  if($_SESSION['email_folder'] == $folderName) { ?> class="active" <?php  } ?>>
							    <a href="javascript:void(0);" onClick="send_data('<?php echo $folderName; ?>','14','quote_view');">
								     <?php if($totalcount > 0 && $_SESSION['email_folder'] == $folderName) { ?>
									  <!--<span class="badge pull-right"><?php //echo $totalcount; ?></span>-->
									   
									  <?php  } ?><i class="fa fa-<?php echo $key; ?>" aria-hidden="true"></i> <?php echo $folderName; ?> 
							    </a>
							</li>
						<?php  }  ?>
				</ul>			 
				
				
		<style>
		.disabled_compose_button {
			border: 1px solid #00b8d4;
			cursor: not-allowed;	  
		}
		.compose_button {
			border: 1px solid #00b8d4;
		}
		</style>		