	<div style="width: 100%;">
		<div class="">
			<link href="source/mysms_style.css" rel="stylesheet" >
			<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<?php  

//$sql = mysql_query("SELECT * FROM `mysms_parents_conversation` ORDER by dateLastMessage  DESC");
$sql = mysql_query("SELECT  S.id as id , S.mobile as mobile ,  S.name as sname,  concat('S-' ,S.name) as name, M.messagesUnread as unread , M.from_address as frommobile , M.snippet as message, M.dateLastMessage as messageTime  from staff S left JOIN mysms_parents_conversation M  on  S.mobile = M.from_address where  S.status = 1 AND M.message_type = 'staff' GROUP by mobile  ORDER by dateLastMessage desc");
$countchat = mysql_num_rows($sql);


$getUnread = getUnreadMessage();
//print_r($getUnread);

?>


<br/>
<div class="container-fluid">
<!--<h3 class=" text-center">Messaging</h3>-->
<div class="messaging">
    <div class="inbox_msg">
        <div class="inbox_people col-md-3">
			<div class="headind_srch">
				
				
				<div class="srch_bar">
				  <div class="stylish-input-group">
					<!--<input type="text" class="search-bar" onkeyup="SearchName(this);" id="searchid"  data-id="" placeholder="Search" >-->
					<input type="text" class="search-bar" id="searchid"  data-id="1" placeholder="Search" >
					<span class="input-group-addon">
					<button type="button"  class="buttoneClass" style="cursor: pointer;">
                     <i class="fa fa-search" id="searchIcon"  data-id = '' aria-hidden="true"></i> </button>
					</span> </div>
				</div>
						
							
							<ul id="message_counterdata">
							  <li class="class-txt active" id="class_txt_1" onClick="getMessageType(1);">
							    <label style="color:#000">S#</label> 
							       <input value="staff" data-id='1' class="default_option" type="radio" checked="checked" name="invoke_lst">
									<?php if($getUnread['staff']['message_type'] == 'staff') { ?>
									  <div class="cnt_staff" id="sms_counter_message_1" ><?php echo $getUnread['staff']['unreadmessage']; ?></div>
									<?php  } ?>
							  </li>
							  <li class="class-txt" id="class_txt_2" onClick="getMessageType(2);">
							    <label style="color:#000">Q#</label> <input value="quote"   data-id='2' class="default_option" type="radio" name="invoke_lst">
									<?php if($getUnread['quote']['message_type'] == 'quote') { ?>
									  <div class="cnt_staff" id="sms_counter_message_2"><?php echo $getUnread['quote']['unreadmessage']; ?></div>
									<?php  } ?>
							  </li>
							  <li class="class-txt" id="class_txt_3" onClick="getMessageType(3);">
							    <label style="color:#000">J#</label> <input value="jobs"  data-id='3' class="default_option" type="radio" name="invoke_lst">
									
									<?php if($getUnread['jobs']['message_type'] == 'jobs') { ?>
									  <div class="cnt_staff" id="sms_counter_message_3" ><?php echo $getUnread['jobs']['unreadmessage']; ?></div>
									<?php  } ?>
							  </li>
							  <li class="class-txt" id="class_txt_4" onClick="getMessageType(4);">
							    <label style="color:#000">H#</label> <input value="hr"  data-id='4' class="default_option" type="radio" name="invoke_lst">
									<?php if($getUnread['hr']['message_type'] == 'hr') { ?>
									  <div class="cnt_staff" id="sms_counter_message_4"><?php echo $getUnread['hr']['unreadmessage']; ?></div>
									<?php  } ?>
							  </li>
							  <li class="class-txt" id="class_txt_5" onClick="getMessageType(5);">
							    <label style="color:#000">N#</label> <input value="new"  data-id='3' class="default_option" type="radio" name="invoke_lst">
									
									<?php if($getUnread['nothing']['message_type'] == 'nothing') { ?>
									  <div class="cnt_staff" id="sms_counter_message_5"><?php echo $getUnread['nothing']['unreadmessage']; ?></div>
									<?php  } ?>
							  </li>
							  <li class="class-txt1">
							  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" style="margin-top: 3px;">
								   <span class="glyphicon glyphicon-plus"></span>
								</button>
							  </li>
							</ul>
							
			</div>
			
			
		
			
          <div class="inbox_chat" id="onlinechatList">
            <?php   if($countchat > 0) { 
					$i = 0;
					while($data = mysql_fetch_assoc($sql)) {
						
						$i++;
						//echo timeago($data['messageTime']);
            ?>  
            
                <div class="getboxClass<?php echo $i; ?> chat_list <?php  if($i == 1) { ?> active_chat <?php  } ?>" onclick="getMessageDetails('<?php echo $data['mobile']; ?>', '<?php echo ucfirst(mysql_real_escape_string($data['sname'])); ?>',<?php echo $i; ?>)">
                  <div class="chat_people">
                    <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                    <div class="chat_ib">
                      <h5><?php echo $data['name']; ?><span class="chat_date"><?php if($data['messageTime'] != '') {   echo Date('M d h:i A' ,strtotime($data['messageTime'])); }?></span></h5>
                      <p><?php if(strlen($data['message']) >= 30) { echo substr($data['message'] , 0, 30).'...';  }  else { echo str_replace("\r\n","",$data['message']); }?>
					  </p>
					   <?php  if($data['unread'] > 0) { ?>
					    <span class="notification_message"><?php echo $data['unread']; ?></span>
					   <?php  } ?>
					   
                    </div>
					
                  </div>
                </div>
            <?php   } } ?>   
          </div>
        </div>
        
        <div class="mesgs col-md-9" >
          <div class="msg_history" id="messageappend">
		       <h3>Welcome <?php echo get_rs_value('admin' , 'name', $_SESSION['admin']); ?> </h3>
           
            
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg" id="sendid" data-id ="" placeholder="Type a message" />
              <input type="hidden" class="sender_name" id="sender_name"/>
			  
              <button class="msg_send_btn"  onClick="sendMessage();" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
		
			
		   
		
    </div>
      
      	<div class="mesgs col-md-12" >		 
							 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">New SMS</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
								<div class="form-group">
								   <label for="usr">Mobile :</label>
								       <input type="text" class="form-control checkformData" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onKeyDown="if(this.value.length==10 && event.keyCode!=8) return false;" autocomplete="off" placeholder="Please enter mobile number ..."  id="mobilenumber" value="" name="mobilenumber">
								</div>
								<div class="form-group">
									<label for="pwd">Message:</label>
									<textarea rows="5" cols="25" class="checkformData" id="message_id"  placeholder="Please type here.."></textarea>
								</div>
								<button type="submit" class="btn btn-success" disabled  id="NewMessageSend" onClick="sendNewMessage();">Submit</button>
							
						  </div>
						</div>
					  </div>
					</div>
				</div>
     <!-- <p class="text-center top_spac"> Design by <a target="_blank" href="#">Pankaj Gupta</a></p>-->
      
    </div></div>
<script>

	 
				
        function sendMessage()
        {
                loaderShowHide(1);
                var sendid =  $('#sendid').attr('data-id');
                var message =  $('#sendid').val();
                var sender_name =  $('#sender_name').val();
				 
				 
						if(message == '' && message == 'undefined' || message == 'Null') {
							return false;
						}
						
                    var params = 'sendid='+sendid+'&message='+message+'&page=sendpage&name='+sender_name;
                    
                    $.ajax({ //Process the form using $.ajax()
                            type      : 'POST', //Method type
                            url       : 'source/showmessageList.php', //Your form processing file URL
                            data      : params, //Forms name
                            dataType  : 'html',
                         success   : function(data) 
                          {
                              $('#sendid').val('');
                              $('#messageappend').html(data);
							  loaderShowHide(2);
                              /* $('.msg_history').animate({
									scrollTop: $('.msg_history').get(0).scrollHeight
								}, 100);      */
                          }
                    });
          
        }
		
		
		function loaderShowHide(type){
			/* $(document).ready(function(){
                $('.msg_history_one').animate({ scrollTop: $(document).height() }, 1200);
            }); */
			
			if(type == 1) {
			    $('#loaderimage_1').show();
				$('.full_loader').attr('id','bodydisabled_1');
			}else if(type == 2) {
			
			   $('#loaderimage_1').hide();
		        $('.full_loader').attr('id','');
			}
			
			$('.msg_history').animate({
									scrollTop: $('.msg_history').get(0).scrollHeight
								}, 100);
		}
		
 
        function getMessageDetails(messgaeaddress, name, counter){
            
				 
			   loaderShowHide(1);
				$('.chat_list').removeClass('active_chat');
                $('#sendid').attr('data-id' , '');
                $('#sender_name').val('');
				
				var id = 1;
				
				if($("#message_counterdata .class-txt").hasClass('active')) {
				  var  id =  $("#message_counterdata .active").attr('id');
				}
				
			
               var params = 'addressmessage='+messgaeaddress+'&page=getdata&name='+name;
                     $.ajax({ //Process the form using $.ajax()
                            type      : 'POST', //Method type
                            url       : 'source/showmessageList.php', //Your form processing file URL
                            data      : params, //Forms name
                            dataType  : 'html',
                        success   : function(data) 
                        {
                              $('#messageappend').html(data);
                              $('#sendid').attr('data-id',messgaeaddress);
                              $('#sender_name').val(name);
							  $('.getboxClass'+counter).addClass('active_chat');
							  
							  
							  ShowCOunterMessage(id, 'countermessage', 2);
							  $('.getboxClass'+counter).find('.notification_message').remove();
							  loaderShowHide(2);
				             // $('.getboxClass'+counter).find('span').find('.notification_message').text('');
							  
							 // ShowCOunterMessage(id, 'countermessage');
							       
                        }
                     });
        }
		
		
		function getMessageType(id) {
		    
                $('#searchid').val('');
                ShowCOunterMessage(id, 'countermessage', 1);
                $('.class-txt').removeClass('active');
                $('#class_txt_'+id).addClass('active');
                $('#searchid').attr('data-id',id);
                getOnlineChatList(id,'');
			
		}


    function ShowCOunterMessage(id, pagename, type){
        
			   loaderShowHide(1);
               var params = 'page='+pagename;
                     $.ajax({ //Process the form using $.ajax()
                            type      : 'POST', //Method type
                            url       : 'source/showmessageList.php', //Your form processing file URL
                            data      : params, //Forms name
                            dataType  : 'html',
                         success   : function(data) 
                          {
                                $('#message_counterdata').html(data);
                                $('.class-txt').removeClass('active');
                                if(type == 2) {
                                    $('#'+id).addClass('active');
                                }else{
                                   $('#class_txt_'+id).addClass('active');
                                }
                                
                          }
                     });
        }

        function getOnlineChatList(pageid, searchText){
		        loaderShowHide(1);
               var params = 'page='+pageid+'&searchText='+searchText;
                     $.ajax({ //Process the form using $.ajax()
                            type      : 'POST', //Method type
                            url       : 'source/chatlist.php', //Your form processing file URL
                            data      : params, //Forms name
                            dataType  : 'html',
                         success   : function(data) 
                          {
                              $('#onlinechatList').html(data);
                             // $('#sendid').attr('data-id',messgaeaddress);
							 loaderShowHide(2);
                                   
                          }
                     });
        }		
		
		
		$(".input-group-addon").click(function(event) {
			 stext =  $('#searchid').attr('data-id');
			 searchStr =  $('#searchid').val();
			 getOnlineChatList(stext,searchStr);
		});
		
     $('.checkformData').keyup(function(event){
		  
           var message_id = $('#message_id').val();
           var mobilenumber = $('#mobilenumber').val();
		    $('#NewMessageSend').prop( "disabled", true );
			
			// console.log(mobilenumber.length + ' === '+message_id.length);
			
		   if(message_id.length != '' && mobilenumber.length == 10) {
			   $('#NewMessageSend').prop( "disabled", false );
		   }
		
	 });
   
        function sendNewMessage(){
			 loaderShowHide(1);
				var mobilenumber = $('#mobilenumber').val();
				var message_id = $('#message_id').val();
				

				if(mobilenumber == '' || mobilenumber == 'undefined' || mobilenumber == 0) {
				       return false;
				}else if(mobilenumber == 'Null') {
					  return false;
				}else if(mobilenumber.length != 10) {
					  return false;
				}
				
				if((message_id == '' || message_id == 'undefined')) {
				       return false;
				}else if(message_id == 'Null') {
					  return false;
				}
             // alert(message_id + ' =  '+mobilenumber+' == '+mobilenumber.length);
				var params = 'mobilenumber='+mobilenumber+'&message_id='+message_id+'&page=sendnewmessage';
                    
                    $.ajax({ //Process the form using $.ajax()
                            type      : 'POST', //Method type
                            url       : 'source/showmessageList.php', //Your form processing file URL
                            data      : params, //Forms name
                            dataType  : 'html',
                         success   : function(data) 
                          {
                             $('#sendid').val('');
                              $('#messageappend').html(data); 
							getOnlineChatList(5,'');
							  
							$('#class_txt_1').removeClass('active');
							$('#class_txt_2').removeClass('active');
							$('#class_txt_3').removeClass('active');
							$('#class_txt_4').removeClass('active');
							$('#class_txt_5').addClass('active');
							$("#exampleModal").modal('hide');
							loaderShowHide(2); 
                                   
                          }
                    });
          
        }		
		
</script>
		    
		</div>
    </div>			 