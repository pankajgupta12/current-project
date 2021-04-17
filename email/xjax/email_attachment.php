
<?php  

         $getAttchment = mysql_query("SELECT *  FROM `bcic_email_attach` WHERE email_id = ".$emaildetails['id']." AND mail_type = '".$emaildetails['mail_type']."'");
			  $countmails = mysql_num_rows($getAttchment);      
			   
			   if($countmails > 0) { 
			   ?>

                <div class="mail-attachment" >
                        <p>
                            <span><i class="fa fa-paperclip"></i> <?php echo $countmails; ?> attachments - </span>
                        </p>
					<ul class="">	
                       <?php  
                        while($getAttchfile = mysql_fetch_assoc($getAttchment)) {
                             //print_r($getAttchfile);
                             $exetention =   end(explode('.',$getAttchfile['email_attach']));
                             $exetention  =  strtolower($exetention);
							if($exetention == 'png' || $exetention == 'jpg' || $exetention == 'jpeg' || $exetention == 'gif' || $exetention == 'bmp')
							{								
								$galleryClass = 'data-fancybox';
								$targetBlank = '';
							}
							else
							{
								$galleryClass = '';
								$targetBlank = "target='_blank'";
							}
                    
                        ?>

                        
                            <li class="file-box" style="list-style: none;">
                                <div class="fileNew file">
                                    
                                    <?php  if($getAttchfile['mail_type'] == 'team') { 
                                       $path  = $_SERVER["DOCUMENT_ROOT"];
                                       	$pathname = $path.'/mail/mail_attachments/'.$getAttchfile['email_folder'];
                                    
                                     if(file_exists($pathname)) { 
                                     //  echo 'Ok';
                                     ?>
                                         <a  href="../mail/mail_attachments/<?php  echo $getAttchfile['email_folder']; ?>/<?php echo $getAttchfile['email_attach']; ?>" <?php echo $galleryClass; ?> <?php echo $targetBlank; ?> >      
                                          
                                         
                                    <?php 
                                     }else { 
                                     
                                     //echo 'Not Ok';
                                     ?>
                                     
                                         <a  href="https://team-email.s3.amazonaws.com/<?php echo $getAttchfile['email_msgno']; ?>/<?php echo $getAttchfile['email_attach']; ?>" <?php echo $galleryClass; ?> <?php echo $targetBlank; ?> >      
                                                                  
                                <?php      }  } else { ?>
                                    
                                    <a  href="../mail/mail_attachments/<?php  echo $getAttchfile['email_folder']; ?>/<?php echo $getAttchfile['email_attach']; ?>" <?php echo $galleryClass; ?> <?php echo $targetBlank; ?> >
                                    <?php  } ?>
                                        <span class="corner"></span>

                                        <div class="image">
                                            <img alt="image" class="img-responsive" src="../mail/images/mail_img/defult_img.png">
                                         
                                        </div>
                                        
                                    </a>
									<div class="file-name">
                                            <?php //echo $getAttchfile['email_attach']; ?>
                                            <small> <?php echo  date('dS M',strtotime($emaildetails['email_date']));  ?></small>
											<span><input type="checkbox" onChange="checkattachment('<?php echo $getAttchfile['id']; ?>','<?php echo $emaildetails['id']; ?>','<?php echo $emaildetails['mail_type']; ?>');" id="email_id_<?php echo $getAttchfile['id']; ?>" value="" <?php  if($getAttchfile['image_status'] == '1') { echo "checked"; } ?>></span>
                                        </div>

                                </div>
                            </li>
                         <?php  } ?>
					</ul>
						
					<!--<?php //include('attach.php'); ?>-->
					
                </div>
		<?php  } ?>		
			<div class="clearfix"></div>