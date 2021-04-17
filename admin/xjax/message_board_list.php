<?php   $getSql = mysql_query('Select * from message_board where status = 0'); ?>
                <ul class="qulist1">
                   <?php if(mysql_num_rows($sql)>0) { 
				   
				   while($getmsg = mysql_fetch_assoc($getSql)) {
				     $to =   get_rs_value("admin","name",$getmsg['message_to']);
				     $from =  get_rs_value("admin","name",$getmsg['message_from']);
				   ?>
					<li class="quote_notification ">
					    <span class="bd_list_border"><span class="toUser"><strong>To : </strong> <?php echo $to ?></span>
                            <span onclick="hideMe()" class="hideIt">X</span>

							<span class="subjectUser"><strong>Subject : <span class="nameFrom"><?php echo $getmsg['subject']; ?> </span></strong></span>
                              <p class="timeUser offsetRight"><?php echo changeDateFormate($getmsg['createdOn'],'datetime');  ?></p><b class="fs13"><?php echo $getmsg['message']; ?></b>
						</span>
					<span class="formUser"><strong>From : <span class="nameFrom"><?php echo $from; ?> </span></strong></span>
					</li>
				   <?php }} else { 
				    //echo "OKkkkkk";
				   ?>
				   <li class="quote_notification ">
					   No Record found.
					</li>
				   <?php  } ?>
				</ul>
							