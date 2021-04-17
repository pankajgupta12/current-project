
<link rel="stylesheet" href="chat/style.css" type="text/css">

<br/>
<br/>


<div id="frame">
	<div id="sidepanel">
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input type="text" id="searchname" placeholder="Search contacts..."  onkeypress="return searchchatlist(event);"  />
		
		</div>
		
		<div class="user_table">
    			<ul id="message_counterdata">
    				  <li class="class-txt " id="class_txt_1" > 
    				    <label style="color:#000">Cleaner</label> 
    				       <input value="staff" data-id="1" class="default_option" onClick="getChatType(1);" type="radio" checked="checked" name="invoke_lst">
    													  </li>
    				  <li class="class-txt" id="class_txt_2" >
    				    <label style="color:#000">Admin</label> <input value="quote" onClick="getChatType(2);"  data-id="2" class="default_option" type="radio" name="invoke_lst">
    													  </li>
    				  <li class="class-txt active" id="class_txt_3" >
    				    <label style="color:#000">All</label> <input value="jobs" onClick="getallgroupchat();"  data-id="3" class="default_option" type="radio" name="invoke_lst">
    						
    				 </li>	
    		</ul>
		</div>
		
		<div id="contacts">
		
		</div>
	</div>
		<div class="content">
		    
            		   <div id="message_list"> 
                    	
                		
                		
                		<div class="messages" id="dashboard_text">
                			
                		</div>	
            	    </div>		
    		
    		<div class="message-input">
    			<div class="wrap">
    			    <span id="nameshow" style="display:none;"></span>
    		        <input type="text" id="message_data" data-id="3"  onkeyup="searchName();"  onkeypress="return check_press_enter_chat(event);"  placeholder="Write your message..." />
    		   
    		   <!--	 <span><textarea rows="2" cols="100" id="message_data" data-id="1"  onkeyup="searchName();"  ></textarea> </span>-->
    			<input type="hidden" id="hidden_id" value="">
    			<!--<i class="fa fa-paperclip attachment" aria-hidden="true"></i>-->
    			<button class="submit"><i class="fa fa-paper-plane" onClick="sendmessageinfo();" aria-hidden="true"></i></button>
    			</div>
    			
    			<span id="get_listdata" style="display:none;"></span>
    			
    		</div>
    	</div>
</div>


<script>

//$('li.menu').hasClass('active');

     function searchchatlist(e){
          if(e && e.keyCode == 13) {
           // sendmessageinfo();
             //alert('sdsds');
             if($('li.class-txt').hasClass('active') == true) {
                  var tabid = $('li.active').find('input').attr('data-id');
                  
                   if(tabid != 3) {
                     var searchval = $('#searchname').val();
                        //alert($('#searchname').val());
                        getOnlineChatListing(tabid,'' , '' , searchval);
                   }
             }
         }
     }

  function check_press_enter_chat(e)
     {
        //alert('test');   
        // console.log(e);
         if(e && e.keyCode == 13) {
            sendmessageinfo();
         }
     }
	 getallgroupchat();	 	
       function getChatType(id) {
		       
		         /*if(id == 1) {
		             var chatname = '<h4 style="text-align: center;margin: 200px;font-size: 50px;">Chat into Cleaners</h4>';
		         }else{
		               var chatname = '<h4 style="text-align: center;margin: 200px;font-size: 50px;">Chat into Admin Staff</h4>';
		         }*/
		    
		        chatname = '';
		        $('#searchname').val('');
                $('.class-txt').removeClass('active');
                $('#class_txt_'+id).addClass('active');
                $('#message_data').attr('data-id',id);
                getOnlineChatListing(id,'' , chatname , '');
			
		}
		
		
		function getOnlineChatListing(pageid, searchText, pagetype, searchval = ''){
		       // loaderShowHide(1);
               var params = 'page='+pageid+'&searchText='+searchText+'&searchval='+searchval;
               
                // alert(params);
               
                     $.ajax({ //Process the form using $.ajax()
                            type      : 'POST', //Method type
                             url       : '../../admin/chat/chatonline.php', //Your form processing file URL
                            data      : params, //Forms name
                            dataType  : 'html',
                        success   : function(data) 
                          {
                              $('#contacts').html(data);
                              $('#message_data').attr('data-id',pageid);
                              $('#message_list').html('');
                              $('#message_list').html(pagetype);
                              $('#message_data').attr('disabled','disabled');
                              console.log(pagetype);
                                   
                          }
                    });
        }	
        
        
        function chatOpeninfo(chatid, pageid, name) {
            
              var pagename = 'chatlist';
              var message_data = '';
              var params = 'chatid='+chatid+'&pageid='+pageid+'&name='+name+'&pagename='+pagename+'&message_data='+message_data;
               
                     $.ajax({ //Process the form using $.ajax()
                            type      : 'POST', //Method type
                             url       : '../../admin/chat/chat_message.php', //Your form processing file URL
                            data      : params, //Forms name
                            dataType  : 'html',
                        success   : function(data) 
                          {
                              $('#message_list').html(data);
                              $('#hidden_id').val(chatid);
                              $('#hidden_id').attr('name', name);
                              $('#message_data').attr('disabled',false);
                              loadbutton();
                                   
                          }
                    });
        }
		
		
		function sendmessageinfo() {
		    
		    var message_data = $('#message_data').val();
		    var pageid =$('#message_data').attr('data-id');
		    var pagename = 'messagelist';
		    var chatid = $('#hidden_id').val();
		    var name = $('#hidden_id').attr('name');
		    
    		  if(message_data != '') {  
    		    
    		     var params = 'chatid='+chatid+'&pageid='+pageid+'&name='+name+'&pagename='+pagename+'&message_data='+message_data;
    		         $.ajax({ //Process the form using $.ajax()
                                type      : 'POST', //Method type
                                 url       : '../../admin/chat/chat_message.php', //Your form processing file URL
                                data      : params, //Forms name
                                dataType  : 'html',
                            success   : function(data) 
                              {
                                  $('#message_list').html(data);
                                  $('#message_data').val('');
                                  loadbutton();
                                       
                              }
                        });
    		  }
		}
		
		
		function searchName() {
		 
		 
    		    //console.log($('#get_listdata ul li').length);
    		    //console.log($('#get_listdata').html());
    		      var searchType =   $('#message_data').attr('data-id');
    		      var value =  $('#message_data').val();
    		     // $('#nameshow').hide();
    		      //console.log(value);
    		      
    		      //alert(searchType + ' = 11 = '+val);
    		      strlength  = value.length;
    		      searchtexttype = 0;
    		      matchstr =  value.slice(-1);
    		      
    		      if(matchstr == '@') {
    		          var searchtexttype = 1;
    		      }
    		      var pagename = 'search';
    		      // $('#nameshow').html('');
    		      
    		  if(searchtexttype > 0) {    
    		      if($('#get_listdata ul li').length == 0) {
    		          
            		           var params = 'searchval='+value+'&pagename='+pagename;
            		         $.ajax({ //Process the form using $.ajax()
                                        type      : 'POST', //Method type
                                         url       : '../../admin/chat/searchname.php', //Your form processing file URL
                                        data      : params, //Forms name
                                        dataType  : 'html',
                                        success   : function(data) 
                                        {
                                          $('#nameshow').show();
                                          $('#nameshow').html(data);
                                          $('#get_listdata').html(data);
                                          searchByFilter();
                                           //searchByFilter();
                                         // searchByname(); 
                                          //$('#message_data').val('');
                                               
                                        }
                                });
                                
                            }else{
                                  $('#nameshow').html($('#get_listdata').html());
                                 
                               
                                  
                        }
    		  }else{
    		      $('#nameshow').hide();
    		  }
    		   searchByFilter();
    		   
    		   searchtexttype = 0;
                        
    		    
		}
		
		function getAdminListData(){
		     var pagename = 'search';
		     var params = 'searchval=ok&pagename='+pagename;
		     /* $('#nameshow').html($('#get_listdata').html());
		      searchByFilter();*/
		      
		     $.ajax({ //Process the form using $.ajax()
                                        type      : 'POST', //Method type
                                         url       : '../../admin/chat/searchname.php', //Your form processing file URL
                                        data      : params, //Forms name
                                        dataType  : 'html',
                                        success   : function(data) 
                                        {
                                           $('#nameshow').html(data);
                                           //$('#get_listdata').html(data);
                                            searchByFilter();
                                               
                                       }
                                });
                                
		}
		
		
		function searchByFilter() {
		  //  console.log(event);
		     flag = 0;
		    var key = event.keyCode;
              // console.log('uuuuuuu=====> '+key);  
            var input, filter, ul, li, a, i, txtValue;
            
            input = document.getElementById("message_data");
            
            filter = input.value;
		    
		     if(key == 8)
		     {
		         $('#nameshow').show();  
		         getAdminListData();
		        
		     }
		      else 
		     {
		     
                     
                    
                    if(filter.lastIndexOf('@') > 0 || filter.lastIndexOf('@') == 0 ) 
                    {
                          $('#nameshow').show();
                        //  filteredArray = []; 
                        //var myArray = [];
                        var textToSearch = filter.split('@');
                        var lastCountIndex = textToSearch.length;
                        
                         
                        if(textToSearch[lastCountIndex-1] != undefined || textToSearch[lastCountIndex-1] != '') {
                             
                          
                            filteredArray = FilterArrayList(textToSearch[lastCountIndex-1]);
                            
                           // console.log(filteredArray);  
        
                		    console.log('okkk =====NO BACK SPACE===============');  
                		    countlenght = filteredArray.length;  
                		     
                		     //console.log(countlenght);
                		     
                		    if(countlenght > 0) {
                		       AfterSearchString(filteredArray);
                		       filteredArray = [];
                		    }
                		    
                		    
                        }
                        
                    }
		    }
		}
		
		
		function FilterArrayList(filterval){
		     var myArray =  arrayListdata();
		     var filteredArray = myArray.filter((str)=>{
                      return str.lastIndexOf(filterval) >= 0; 
                    });
                    
            
            return filteredArray;        
		}
		
		
		
		function AfterSearchString(filteredArray){
		    
		    var params = 'arraydata='+filteredArray;
		     
		         $.ajax({ //Process the form using $.ajax()
                            type      : 'POST', //Method type
                             url       : '../../admin/chat/array_data_list.php', //Your form processing file URL
                            data      : params, //Forms name
                            dataType  : 'html',
                        success   : function(data) 
                          {
                              $('#nameshow').html(data);
                             /* $('#contacts').html('');
                              $('#message_data').attr('data-id',3);*/
                              //loadbutton();
                          }
                    });
		    
		}
		
		
		function  arrayListdata(){
		    ul = document.getElementById("nameshow");
            li = ul.getElementsByTagName("li");
            
           // console.log(li);
            
             var arr = [];
            for (i = 0; i < li.length; i++) {
                
                 a = li[i];
                txtValue = a.textContent || a.innerText;
                
                 arr.push(txtValue.toLowerCase());
                
            }
            
            return arr;    
		}
		
		/*function searchByname() {
		    
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("message_data");
            filter = input.value.toUpperCase();
            ul = document.getElementById("nameshow");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                
                a = li[i];
                
                
                txtValue = a.textContent || a.innerText;
                
                   console.log(txtValue.toUpperCase().indexOf(filter));
                
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a.style.display = "";
                } else {
                   // a.style.display = "none";
                }
            }
        }*/
		
		
		
		
		function getallgroupchat(){
		    
        $('.class-txt').removeClass('active');
        $('#class_txt_3').addClass('active');
		    
		    var pagename = 'groupchat';
		    var name = 'BCIC GROUP CHAT';
		    
		     var params = 'name='+name+'&pagename='+pagename;
		     
		         $.ajax({ //Process the form using $.ajax()
                            type      : 'POST', //Method type
                             url       : '../../admin/chat/group_chat_page.php', //Your form processing file URL
                            data      : params, //Forms name
                            dataType  : 'html',
                           success   : function(data) 
                            {
								  $('#message_list').html(data);
								  $('#contacts').html('');
								  $('#message_data').attr('data-id',3);
								  $('#message_data').attr('disabled',false);
								  loadbutton();
                            }
                    });
		}			
		
		function addTask(id, to_id){	
		    var r =  confirm("Are you sure do you want add notification!");
             if (r == true) {
    		      var str = id+'|'+to_id;		
    		      send_data(str, 625,'task_added_'+id);  
             }
		  } 
		  
		  
		
	/*	setInterval(function(){
		    getallgroupchat();
		    var time =   new Date();
		    console.log(time.toLocaleTimeString());
		} ,120000);*/
		 
</script>
<script>
	 function loadbutton(){	
		 $('.messages').animate({
			scrollTop: $('.messages').get(0).scrollHeight
			}, 100);
	 }
</script>