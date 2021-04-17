<div class="aniimated-thumbnials">   
   <?php  
	while($getAttchfile = mysql_fetch_assoc($getAttchment)) {
		 //print_r($getAttchfile);
		 $exetention =   end(explode('.',$getAttchfile['email_attach']));
		 $exetention  =  strtolower($exetention);
	?>
		<!--<li class="file-box" style="list-style: none;">
			<div class="fileNew file">
				<a  href="../mail/mail_attachments/<?php  echo $getAttchfile['email_folder']; ?>/<?php echo $getAttchfile['email_attach']; ?>" class="group1" target="_blank" >
					<span class="corner"></span>

					<div class="image">
						<img alt="image" class="img-responsive" src="../mail/images/mail_img/defult_img.png">
					 
					</div>
					<div class="file-name">
						<?php //echo $getAttchfile['email_attach']; ?>
						<small> <?php echo  date('dS M',strtotime($emaildetails['email_date']));  ?></small>
						<span><input type="checkbox" onChange="checkattachment('<?php echo $getAttchfile['id']; ?>','<?php echo $emaildetails['id']; ?>','<?php echo $emaildetails['mail_type']; ?>');" id="email_id_<?php echo $getAttchfile['id']; ?>" value="" <?php  if($getAttchfile['image_status'] == '1') { echo "checked"; } ?>></span>
					</div>
				</a>

			</div>
		</li>-->
		
		<a href="../mail/mail_attachments/<?php  echo $getAttchfile['email_folder']; ?>/<?php echo $getAttchfile['email_attach']; ?>">
			<img src="../mail/mail_attachments/<?php  echo $getAttchfile['email_folder']; ?>/<?php echo $getAttchfile['email_attach']; ?>" />
		</a>
		
	 <?php  } ?>
</div>	 