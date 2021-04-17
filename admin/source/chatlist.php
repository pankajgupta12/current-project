<?php 
   
    	include("functions/functions.php");
		include("functions/config.php");
		
		//print_r($_POST); die;
		
	if($_POST) {
		  $pagename = '';
		  $searchText = trim($_POST['searchText']);
		  
		if($_POST['page'] == 1) {
 
            // Staff Query
			$sql = "SELECT  S.id as id , S.mobile as mobile ,  S.name as sname,  concat('S-' ,S.name) as name, M.messagesUnread as unread , M.from_address as frommobile , M.snippet as message, M.dateLastMessage as messageTime  from staff S left JOIN mysms_parents_conversation M  on  S.mobile = M.from_address where  S.status = 1 AND M.message_type = 'staff' ";
			
			
			
			if($searchText != '' && $searchText !='') {
			   $sql.= " AND ( S.mobile LIKE '%".$searchText."%' OR S.name LIKE '%".$searchText."%' ) ";			
			}
			
			$pagename = 'Staff List';
			$Page = 'Staff';
			
		} else if ($_POST['page'] == 2) {
			
			 // Quote Query
			
			$sql = "SELECT Q.id as id, concat('Q-' ,Q.name  ,' - ', Q.id ) as name  ,  Q.name as sname, Q.phone as mobile  , M.snippet as message, M.messagesUnread as unread , M.from_address as frommobile , M.snippet as message, M.dateLastMessage as messageTime  FROM `quote_new` Q  JOIN mysms_parents_conversation M On  Q.phone = M.from_address AND Q.booking_id = 0 AND Q.step != 10 AND M.message_type = 'quote'";
			
			if($searchText != '' && $searchText !='') {
			   $sql.= " AND ( Q.phone LIKE '%".$searchText."%' OR Q.name LIKE '%".$searchText."%' OR  Q.id LIKE '%".$searchText."%' ) ";			
			}
				
				$pagename = 'Quote List';
				$Page = 'Quote';
			
		} else if ($_POST['page'] == 3) {
			
			 // Jobs Query
			 
			$sql = "SELECT Q.booking_id as id, concat('J-' ,Q.name  ,' - ', Q.booking_id ) as name ,  Q.name as sname, Q.phone as mobile  , M.snippet as message, M.messagesUnread as unread , M.from_address as frommobile , M.snippet as message, M.dateLastMessage as messageTime  FROM `quote_new` Q  JOIN mysms_parents_conversation M On  Q.phone = M.from_address where Q.booking_id > 0 AND Q.step != 10 AND M.message_type = 'jobs'";
			
			if($searchText != '' && $searchText !='') {
			   $sql .= " AND ( Q.phone LIKE '%".$searchText."%' OR  Q.name LIKE '%".$searchText."%' OR Q.booking_id LIKE '%".$searchText."%' ) ";			
			}
			
			$pagename = 'Job List';
			$Page = 'Job';
		}else if ($_POST['page'] == 4) {
			
			 // Jobs Query
			 
			$sql = "SELECT  H.id as id , H.mobile as mobile ,  H.first_name as sname,  concat('H-' ,H.first_name) as name, M.messagesUnread as unread , M.from_address as frommobile , M.snippet as message, M.dateLastMessage as messageTime  from staff_applications H left JOIN mysms_parents_conversation M  on  H.mobile = M.from_address AND M.message_type = 'hr'";
			
			if($searchText != '' && $searchText !='') {
			   $sql .= " where ( H.mobile LIKE '%".$searchText."%' OR H.first_name LIKE '%".$searchText."%' ) ";			
			}
			
			$pagename = 'HR List';
			$Page = 'HR';
		}else if ($_POST['page'] == 5) {
			
			 // Jobs Query
			 
			$sql = "SELECT id as id, from_address as mobile , snippet as message , from_address as name ,from_address as sname,  dateLastMessage as messageTime , messagesUnread as unread  FROM `mysms_parents_conversation` WHERE message_type = 'nothing' ";
			
			if($searchText != '' && $searchText !='') {
			   $sql .= " where ( mysms_parents_conversation.from_address LIKE '%".$searchText."%' ) ";			
			}
			
			$pagename = 'New List';
			$Page = 'New';
		}
		
		 $sql .= "  GROUP by mobile  ORDER by dateLastMessage desc, messagesUnread Desc ";
		 if(in_array($_POST['page'], array(2,3))) {
		   $sql .= "  limit 0 , 500 ";
		 }
		
     //	echo $sql;
		
	     $query = mysql_query($sql);
		 
		 $countchat = mysql_num_rows($query);
		 
       		 
            if($countchat > 0) { 
					$i = 0;
					while($data = mysql_fetch_assoc($query)) {
						
						$i++;
            ?>  
            
                <div class="getboxClass<?php echo $i; ?> chat_list <?php  if($i == 1) { ?> active_chat <?php  } ?>" onclick="getMessageDetails('<?php echo $data['mobile']; ?>','<?php echo ucfirst(mysql_real_escape_string($data['sname'])); ?>','<?php echo $i; ?>')">
                  <div class="chat_people">
                    <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                    <div class="chat_ib">
                      <h5><?php echo $data['name']; ?><span class="chat_date"><?php if($data['messageTime'] != '') { echo Date('M d h:i A' ,strtotime($data['messageTime'])); }?></span></h5>
                      <p><?php if(strlen($data['message']) >= 30) { echo substr($data['message'] , 0, 30).'...';  }  else { echo $data['message']; }?></p>
					    
						<?php  if($data['unread'] > 0) { ?>
					        <span class="notification_message" ><?php echo $data['unread']; ?></span>
					    <?php  } ?>
					     
                    </div>
                  </div>
                </div>
            <?php   } }else { ?> 
			
			
			   <div class="chat_list" >
                  <div class="chat_people">
                    <div class="chat_ib">
                      <p>No <?php echo $pagename; ?></p>
                    </div>
                  </div>
                </div>
			
			<?php  }   } ?>