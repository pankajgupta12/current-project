function getemail_type(varid,caseid,div_id){
      
	send_data(varid,caseid,'quote_view');
	
}

function getcategory_type(varid,caseid,div_id){
      
	send_data(varid,caseid,'quote_view');
	
}

function check_fields(value,id,fields){
  //alert(value+"=="+id);
  var str = value+'|'+ id + '|' +fields;
  send_data(str,2,'quote_view');
}

function check_fields_dropdown(value,id,fields){
	
	console.log(id);
  var str = value+'|'+ id + '|' +fields;
  send_data(str,22,'quote_view');
}

  
   function changes_notification_status(value , notiid){
	
    	var str = value+'|'+notiid;
		var div = 'message_status_'+notiid;
		 send_data(str,240, div);
	}
   

    function searchstaffemail(obj,caseid,div_id , functionname)
		{
			var strcount = obj.length;
			if(strcount >= 3) {
			   //alert(str  + '=='+ obj+ '==' + caseid + '==' + div_id);
			   send_data(obj+'|'+functionname ,  caseid ,  div_id);
			}else{
				$('#'+div_id).hide();
			}
		}

    function select_staffname_email(id , email){
		document.getElementById('getemail').value=email;
		document.getElementById('getstaff_list').innerHTML="";
		document.getElementById('getstaff_list').style.display="none";
	} 
	function select_staffname_email_1(id , email){
		document.getElementById('bcc_email').value=email;
		document.getElementById('getstaff_list1').innerHTML="";
		document.getElementById('getstaff_list1').style.display="none";
	} 
	function select_staffname_email_2(id , email){
		document.getElementById('cc_email').value=email;
		document.getElementById('getstaff_list2').innerHTML="";
		document.getElementById('getstaff_list2').style.display="none";
	} 
	


function reloadPage(){
  location.reload();
}
function search_email(value,fields){
  var str = value +'|'+fields;
  send_data(str,3,'quote_view');
}

function email_details(id,mailtype,str)
{
  var str =id+'|'+mailtype+'|'+str;
  send_data(str,5,'quote_view');
  //alert(id + '==' +mailtype + '==' +str);
}
function email_edit_field(obj,field,id,emai_type){
	var res = field.split(".");
	
	if(obj.value == 0 || obj.value == '' || obj.value == undefined) {
		 alert('Please enter a '+res[1]);
	     return false;
	}
	
	var str = obj.value+"|"+field+"|"+id +'|'+emai_type;
     div_id = obj.id;
     send_data(str,10,'emails_notes');	
}

function remove_email(value,field,id,emai_type){
	
    if(confirm("Are You Sure Do You Want Remove value?")){
	   var str = value +"|"+field+"|"+id +'|'+emai_type;
	  // alert(str);
	   send_data(str,12,'emails_notes');
    }
   
}

function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
		//alert('only integer value allowed');
	   return false;
	} else {
	   return true;
	}      
}

function check_press_enter_notes(event){
				//alert(event.keyCode);
		if(event.keyCode == 13){
		  $("#email_comments_button").click();
		}
	}
			
function add_email_comment(obj,id,mail_type,msgno){
	//alert('sdsdsd');
	var str = obj.value+'|'+ id +'|'+mail_type +'|'+msgno;
	//alert(str); 
	send_data(str,11,'emails_notes');
}
function add_emails_notes(id,email_type){

	$( "#emails_notes" ).toggleClass( "toggle" );
	 $('.black_screen1').fadeIn(700);
	 $('.black_screen1').css('display','block');
	//alert(id + "=="+email_type);
	var str = id+'|'+email_type;
	send_data(str,9,'emails_notes');
}

function sent_message(type,mes_no,gettype,mailfoldertype){
	
	// Paramas (test_1, No, new|Forward|reply, div_id)
	
	var to = $('#to_email').val();
	var bcc_email = $('#bcc_email').val();
	var cc_email = $('#cc_email').val();
	var bcic_subject = $('#bcic_subject').val();
	var message = $('.note-editable').html();
	message_body = (message.replace(/(<([^>]+)>)/ig,""));
	/*  console.log(message_body);
	return false;  */
	
	if(to == '' || to == undefined || to == null)
	{
		 alert('Please specify at least one recipient. ');
		 return false;
	}
	
	var str = type + '|' +mes_no + '|' + to +'|'+bcc_email +'|'+cc_email+'|'+bcic_subject +'|'+ Base64.encode(message_body) +'|'+gettype;
	//
	if(mailfoldertype == 'forward_mail') {
		div_id = 'msg_show';
	}else if(mailfoldertype == 'email_reply') {
		div_id = 'msg_show';
	}else {
		div_id = 'quote_view';
	}
	
	send_data(str ,  13, div_id);
	//return false;
}

function new_mssage_sent(){
	
	var type = $('#new_message').attr('data-for');
	send_data(type,15,'quote_view');
	
}
					
function checkattachment(attchid,emailid,emaitype) {
	//alert('sdsds');
	//alert(attchid);
	    if($('#email_id_'+attchid).is(':checked'))
	     {	
           var checkstatus = 1;
		 }
        else 
		{
          var checkstatus = 0;
		}
	var str = attchid +'|'+ emailid +'|'+ emaitype + '|' + checkstatus;
	//alert(str);
	send_data(str,16,'email_id_'+attchid);	
}

function reclean_check_id(emailid,emaitype,job_id) {
	//alert('sdsds');
	//alert(attchid);
	    if($('#exampleCheck1').is(':checked'))
	     {	
           var checkstatus = 1;
		 }
        else 
		{
          var checkstatus = 0;
		}
	var str = emailid +'|'+ emaitype + '|' + checkstatus + '|'+ job_id;
	//alert(str);
	send_data(str,18,'exampleCheck1');	
}	
	
function prev_page(page_id){
	send_data(page_id,19,'quote_view');	
}	


function check_mail_type(value){
	if(value != 0 || value != undefined) {
		$('#new_message').show();			 
		$('#new_message').attr('data-for',value);	
		send_data(value,15,'quote_view');
	}
}

		function resetErrors() {
			$('form input, form select').removeClass('inputTxtError');
			$('p.error').remove();
		} 
		
		
	function CheckValidateEmail(inputText)  
	{  
		/*var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
		if(inputText.value.match(mailformat))  
		{  
		  return true;  
		}  
		else  
		{  
		 return false;  
		}  */
		 return true;  
	}  	
	
	function showmaildiv(divid){
		$("."+divid).toggle();
	}
			
		function send_new_email(){
				 
				var email = document.getElementById('to_email');
				//var sent_new_msg_type = document.getElementById('sent_new_msg_type').value;
				var emai_type  =$('#sent_new_msg_type').val();
				var job_id  =$('#job_id').val();
				
				var all_staff  =$('#all_staff').val();
				var staff_type  =$('#staff_type').val();
				
				if(job_id != '' || job_id != 0) {
				    job_id = job_id;
				}else{
				    job_id = 0;
				}
				
				if(emai_type == 0 || emai_type == '') {
					alert(" Please select mail type first");
					$('#sent_new_msg_type').focus();
					return false;
				}
				
				if(all_staff == 1) {
				    if(staff_type == 0) {
					  alert(" Please select Staff type");
					  $('#all_staff').focus();
					  return false;
				    }
				}
				
					Status = CheckValidateEmail(email);
				if(Status == false){
					alert(" You have entered an invalid email address \r\n");
					return false;
				}
				
				
				
				
			
			var formData = new FormData($('form')[0]);
			var message = $('.note-editable').html();
				formData.append("all_message_body", message);
			var url = location.protocol + "//" + location.hostname + "/mail/xjax/send_email.php";
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				async: false,
				success: function (resp) {
					
						/* $('#message_div').show();
						$('#message_div').html(resp);
						 document.getElementById("new_message").reset();
						 $('.note-editable').html('');
						
						$('#loaderimage_1').hide();
						$('.full_loader').attr('id',''); */
						
						console.log(resp);
						resp = jQuery.parseJSON(resp);
								
						 // $('#new_message').reset();  
						 // document.getElementById("new_message").reset();
						
							$('#message_div').show();
							$('#message_div').html(resp.message);
							
							//document.getElementById("new_message").reset();
							$('.note-editable').html('');
							
							$('#loaderimage_1').hide();
							$('.full_loader').attr('id','');
							
							//check the response if 1 then trigger all action to retreive all emails from server of all types
							
							$('#new_message')[0].reset();
							if( resp.status == 1 )
							{
								retreiveMailsByType(resp.type , job_id , 'New');
							}

				},
				cache: false,
				contentType: false,
				processData: false
			});

			return false; 
		}

		function send_reply_email(){	
                          
                    var email = document.getElementById('to_email');
					Status = CheckValidateEmail(email);
					
					if(Status == false){
						alert(" You have entered an invalid email address \r\n");
						return false;
				    }			
                    		 
							var formData = new FormData($('form')[0]);
							var message = $('.note-editable').html();
							formData.append("all_message_body", message);
						var url = location.protocol + "//" + location.hostname + "/mail/xjax/ajax_reply_send.php";
					
						$.ajax({
							url: url,
							type: 'POST',
							data: formData,
							async: false,  
							success: function (resp) {
								
								resp = jQuery.parseJSON(resp);
								
								 //// $('#new_message').reset();  
								  //document.getElementById("new_message").reset();
								
									$('#message_div').show();
									$('#message_div').html(resp.message);
									
									//check the response if 1 then trigger all action to retreive all emails from server of all types
									
									$('#new_message')[0].reset();
									if( resp.status == 1 )
									{
										retreiveMailsByType(resp.type , 0,'Reply');
									}

							},
							cache: false,
							contentType: false,
							processData: false
						});

						return false; 
		}
		
		
		
		function email_forward(){ 			  
		
					var email = document.getElementById('to_email');
					Status = CheckValidateEmail(email);
					
					if(Status == false){
						alert(" You have entered an invalid email address \r\n");
						return false;
				    }
                     
						var formData = new FormData($('form')[0]);
						var message = $('.note-editable').html();
						formData.append("all_message_body", message);
						
                    var url = location.protocol + "//" + location.hostname + "/mail/xjax/ajax_forward_email.php";
					$.ajax({
						url: url,
						type: 'POST',
						data: formData,
						async: false,
						success: function (resp) {
							
							 
								//$('#message_div').show();
								//$('#message_div').html(resp);
								
								resp = jQuery.parseJSON(resp);
								
							 // $('#new_message').reset();  
							  //document.getElementById("new_message").reset();
							
								$('#message_div').show();
								$('#message_div').html(resp.message);
								
								$('#new_message')[0].reset();
								
								
								
								//check the response if 1 then trigger all action to retreive all emails from server of all types
								if( resp.status == 1 )
								{
									retreiveMailsByType(resp.type,  0 , 'Forward');
								}

						},
						cache: false,
						contentType: false,
						processData: false
					});

					return false; 
	    }
		
		
		function reclean_send_new_email(){
				 
				var email = document.getElementById('to_email');
				//var sent_new_msg_type = document.getElementById('sent_new_msg_type').value;
				var emai_type  =$('#sent_new_msg_type').val();
				var job_id  =$('#job_id').val();
				
				if(job_id != '' || job_id != 0) {
				    job_id = job_id;
				}else{
				    job_id = 0;
				}
				
				if(emai_type == 0 || emai_type == '') {
					alert(" Please select mail type first");
					$('#sent_new_msg_type').focus();
					return false;
				}
				
					Status = CheckValidateEmail(email);
				if(Status == false){
					alert(" You have entered an invalid email address \r\n");
					return false;
				}
				
				
				
				
			
			var formData = new FormData($('form')[0]);
			var message = $('.note-editable').html();
				formData.append("all_message_body", message);
			var url = location.protocol + "//" + location.hostname + "/mail/xjax/reclean_send_email.php";
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				async: false,
				success: function (resp) {
					
						
						 console.log(resp);
						resp = jQuery.parseJSON(resp);
								
						
						
							$('#message_div').show();
							$('#message_div').html(resp.message);
							
							//document.getElementById("new_message").reset();
							$('.note-editable').html('');
							
							$('#loaderimage_1').hide();
							$('.full_loader').attr('id','');
							
							//check the response if 1 then trigger all action to retreive all emails from server of all types
							
							$('#reclen_new_message')[0].reset();
							if( resp.status == 1 )
							{
								retreiveMailsByType(resp.type , job_id, 'Re-Clean Reply');
							} 

				},
				cache: false,
				contentType: false,
				processData: false
			});

			return false; 
		}
		
		
		function reclen_complaint_send_new_email(){
				 
				var email = document.getElementById('to_email');
				//var sent_new_msg_type = document.getElementById('sent_new_msg_type').value;
				var emai_type  =$('#sent_new_msg_type').val();
				var job_id  =$('#job_id').val();
				
				if(job_id != '' || job_id != 0) {
				    job_id = job_id;
				}else{
				    job_id = 0;
				}
				
				if(emai_type == 0 || emai_type == '') {
					alert(" Please select mail type first");
					$('#sent_new_msg_type').focus();
					return false;
				}
				
					Status = CheckValidateEmail(email);
				if(Status == false){
					alert(" You have entered an invalid email address \r\n");
					return false;
				}
				
				
				
				
			
			var formData = new FormData($('form')[0]);
			var message = $('.note-editable').html();
				formData.append("all_message_body", message);
			var url = location.protocol + "//" + location.hostname + "/mail/xjax/reclen_complaint_send_new_email.php";
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				async: false,
				success: function (resp) {
					
						
						 console.log(resp);
						resp = jQuery.parseJSON(resp);
								
						
						
							$('#message_div').show();
							$('#message_div').html(resp.message);
							
							//document.getElementById("new_message").reset();
							$('.note-editable').html('');
							
							$('#loaderimage_1').hide();
							$('.full_loader').attr('id','');
							
							//check the response if 1 then trigger all action to retreive all emails from server of all types
							
							$('#reclen_new_message')[0].reset();
							if( resp.status == 1 )
							{
								retreiveMailsByType(resp.type , job_id, 'Re-clen Complaint');
							} 

				},
				cache: false,
				contentType: false,
				processData: false
			});

			return false; 
		}
		
		
		
		//########### ES6 ##########
		let retreiveMailsByType = (type , job_id = null, textdata = null) => {
			
			//trigger ajax one by one for INBOX | SENT
			var typeSplit = type.split(',');
			
			for( var i = 0; i < typeSplit.length; i++  )
			{
				
				var emailType = typeSplit[i];				
				//####### time to trigger ajax with promise
				
				console.log(emailType);
				console.log(job_id);
			
				if(job_id != '') {
				     var  var_job = job_id;
				}else{
				     var  var_job = 0;
				}
				
				/* //#####INBOX
				var url = location.protocol + "//" + location.hostname + "/admin/crons/mail/source/cron_bcic_email.php?all_params=" + emailType + "___INBOX";
				
				$.ajax({
					url: url,
					type: 'GET',				
					async: false,
					success: function (resp) {
						
					},
					cache: false,
					contentType: false,
					processData: false
				}); */
				
				//#####SENT
				var url = location.protocol + "//" + location.hostname + "/admin/crons/mail/source/cron_bcic_email.php?all_params=" + emailType + "___Sent___"+var_job+ "___"+textdata;
				
				$.ajax({
					url: url,
					type: 'GET',				
					async: false,
					success: function (resp) {
						
					},
					cache: false,
					contentType: false,
					processData: false
				});
				
				//#####SENT
				var url = location.protocol + "//" + location.hostname + "/admin/crons/mail/source/cron_bcic_email.php?all_params=" + emailType + "___Sent___"+var_job+ "___"+textdata;
				
				$.ajax({
					url: url,
					type: 'GET',				
					async: false,
					success: function (resp) {
						
					},
					cache: false,
					contentType: false,
					processData: false
				});
			
			}			
		}
		
		function triggerAjax( emailType )
		{
			
			//#####INBOX
			var url = location.protocol + "//" + location.hostname + "/admin/crons/mail/source/cron_bcic_email.php?all_params=" + emailType + "___INBOX";
			
			$.ajax({
				url: url,
				type: 'GET',				
				async: false,
				success: function (resp) {
					
				},
				cache: false,
				contentType: false,
				processData: false
			});
			
			//#####SENT
			var url = location.protocol + "//" + location.hostname + "/admin/crons/mail/source/cron_bcic_email.php?all_params=" + emailType + "___Sent";
			
			$.ajax({
				url: url,
				type: 'GET',				
				async: false,
				success: function (resp) {
					
				},
				cache: false,
				contentType: false,
				processData: false
			});
		}
		
	function text_edit_fields(value,fields,ids,div_id){
		
		// value|table.fields|totalids|div_id

  		var str = value + '|' + fields+ '|' +ids;
		
		send_data(str , 21 , div_id);
		
	}	
	
   function send_url(qid){
		 window.open('../admin/index.php?task=edit_quote&quote_id='+qid, '_blank');
   }
	
	
	

	let appendRows = () => {
		
		//if(response != 0){					
			//$( "ul.users_inline li:last" ).after( response );
		//}
		
		var str = $('table.tableResponsive thead.all-mail-list tr').length;		
		
		
		
		send_data(str , 295 , "");
		
	}
	
	function block_emails(value , emails , div_id){
		
		if(confirm("do you want to block this email (" + emails + ')')){
			send_data(value+'|'+emails , 52 , div_id);		
			return true;
		}else{
			return false;
		}
	}
	
		function templateType(id){
				
				 if(id != 0) {
					  send_data(id,55,'message_body');	
				 }
			}
		
			function CheckBBCManage()
			 	{
			 	    
			 	    	$('#cc_email').val('');
			 	    
        					/*	if ($("#bbc_manag").is(":checked")) 
        						{
        						    //michael@betterbondcleaning.com.au,leigh@betterbondcleaning.com.au
        							var str = 'collin@betterbondcleaning.com.au';
        							//$('#cc_email').val(str);
        						}
        						else
        						{
        							$('#cc_email').val('');
        						}*/
				}
		
		