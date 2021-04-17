<? 

//if($_SERVER['REMOTE_ADDR']=="110.142.231.92"){
	
///////////////log refrence  on business2sell.com.au //

/// if this user is not refred from any other website and he is coming directly then log him too 

////////////if($_SERVER['HTTP_REFERER']==""){ log_noref(); }else{ logReferer(); }

////////////// track user which is entered on website which pages does he surf ///////
//echo "this is wid ".$_SESSION['wid']."and we are shooting the function ";

//////////ipuser_track(); 


//unset($_SESSION['wid']);


// if the 
	//echome($_SERVER['HTTP_FROM']);
	
	if($_SERVER['HTTP_FROM']!=""){ 
		// this one will decide if this is from google BOT or any other BOT <br>
		// BOT should have one 	record per day 
		
			$data_id = get_sql("website_tracking","id"," where bot='".mysql_real_escape_string($_SERVER['HTTP_FROM'])."' and date='".date("Y-m-d")."'");
			if($data_id==""){ 
				$sql ="insert into website_tracking(ip_address,session,time,date,site,url_from,description,bot) ";
				$sql.=" values ('".mres($_SERVER['REMOTE_ADDR'])."','".mysql_real_escape_string(session_id())."','".time()."','".date("Y-m-d")."','".mysql_real_escape_string($_SERVER['HTTP_HOST'])."',
				'".mres($_SERVER['HTTP_REFERER'])."','".mres($_SERVER['REQUEST_URI'])."','".$_SERVER['HTTP_FROM']."')"; 
			}else{
				$data_desc = get_rs_value("website_tracking","description",$data_id);
				$sql ="update website_tracking set description='".mres($data_desc)."\r\n".mres($_SERVER['REQUEST_URI'])."' where id=".mres($data_id);
			}
			//echome($sql);
			$ins = mysql_query($sql);
	}else{ 
		
		//if($_SESSION['wid']==""){ 

			$parse = parse_url($_SERVER['HTTP_REFERER']);
			$domain = $parse['host'];
			$currentURL = $_SERVER['REQUEST_URI']; 
			$fullCurrentURL = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; 
			$info = print_r($_SERVER,true);
			
			if(strpos($_SERVER['REQUEST_URI'],"/xjax/xjax.php")>-1){
				// truned it on as this is getting counted in pagecount pickup email 
				return;
			}else if(strpos($_SERVER['REQUEST_URI'],".css")>0){
				return;
			/*}else if(strpos($_SERVER['REQUEST_URI'],"/management/")>-1){
				return;
			*/}else if(strpos($_SERVER['REQUEST_URI'],"/jquery-inc/menu2.php?ts=")>-1){
				return; 
			}else if(strpos($_SERVER['REQUEST_URI'],"/jquery-inc/")>-1){				
				return;
			}else if(strpos($_SERVER['REQUEST_URI'],"PageSpeed=noscript")>-1){				
				return;
			}
			
			$data_ip_check = get_sql("live_ips","count"," where ip='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'");
			if($data_ip_check==""){ 			
				$bool = mysql_query("insert into live_ips(ip,datetime,count) values('".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."','".mysql_real_escape_string(date("Y-m-d h:s:i"))."',1)");
			}else{
				$count = $data_ip_check+1;
				$bool = mysql_query("update live_ips set count=".$count." where ip='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'");
				if($count>50){					
						$strx_err = $_SERVER['REMOTE_ADDR']."-".$page_count."-".$_SESSION['page_count_ts_last']."-".$_SESSION['page_count_ts_new']."<hr><br>";
						$strx_err.= print_r($_SERVER,true);
						//sendmail("manish","manish@business2sell.com.au","Error : pagecount is pickedup ",$strx_err,"support@business2sell.com.au");
					//send_sms($mobile,$code)
					//if($_SERVER['REMOTE_ADDR']==$myipaddress){ 
							/*$username = "manish.khanna"; 
							$password = "466934"; 
							$destination = "0421188972";
							$message = "Count picked up ".$_SERVER['REMOTE_ADDR']; 
							$fromNumber = "0410722533";
							$content = 'Username='.rawurlencode($username). 
							'&Pwd='.rawurlencode($password). 
							'&PhoneNumber='.rawurlencode($destination). 
							'&PhoneMessage='.rawurlencode($message);
								
							$ch = curl_init('http://api.messagenet.com.au/lodge.asmx/LodgeSMSMessage'); 
							curl_setopt($ch, CURLOPT_POST, true); 
							curl_setopt($ch, CURLOPT_POSTFIELDS, $content); 
							$output = curl_exec ($ch); 
							curl_close ($ch); */
							
					//}					
				}
			}
			
			
			$timex = date("h:i:s");
			
			$data_id = get_sql("website_tracking","id"," where ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."' and date='".mres(date("Y-m-d"))."' ");
			//$data_id = get_sql("website_tracking","id"," where session='".session_id()."'");

			if($data_id==""){ 
				if($_GET['gclid']!=""){ 
					$_SESSION['gclid'] = mres($_GET['gclid']);
					$sql ="insert into website_tracking(ip_address,session,time,date,site,url_from,description,gcid) ";
					$sql.=" values ('".mres($_SERVER['REMOTE_ADDR'])."','".session_id()."','".time()."','".date("Y-m-d")."','".mres($_SERVER['HTTP_HOST'])."','".mres($_SERVER['HTTP_REFERER'])."','".$timex."->".mres($_SERVER['REQUEST_URI'])."','".mres($_GET['gclid'])."')"; 
					
				}else{
					$sql ="insert into website_tracking(ip_address,session,time,date,site,url_from,description) ";
					$sql.=" values ('".mres($_SERVER['REMOTE_ADDR'])."','".mres(session_id())."','".mres(time())."','".mres(date("Y-m-d"))."','".mres($_SERVER['HTTP_HOST'])."','".mres($_SERVER['HTTP_REFERER'])."','".mres($timex)."->".mres($_SERVER['REQUEST_URI'])."')"; 
				}
				$_SESSION['page_count'] = 1;
				$_SESSION['page_count_ts_new'] = time();
				$_SESSION['bad_page_count'] = 0;
			}else{
				$data_desc = get_rs_value("website_tracking","description",$data_id);
				
				$timex_n = time()-3;
				if($_SESSION['page_count']!=""){ 
					$page_count = $_SESSION['page_count'];				
					$page_count++;
				}else{
					$_SESSION['page_count'] = 1;
				}
				$wt_user_id ="";
				$wt_type ="";
				if($_SESSION['user_id']!=""){ 
					$wt_user_id = 	$_SESSION['user_id'];
					$wt_type = "4";
				}else if ($_SESSION['seller_id']!=""){ 
					$wt_user_id = 	$_SESSION['seller_id'];
					$wt_type = "1";
				}else if ($_SESSION['broker_id']!=""){ 
					$wt_user_id = 	$_SESSION['broker_id'];
					$wt_type = "2";
				}else if ($_SESSION['franchise_id']!=""){ 
					$wt_user_id = 	$_SESSION['broker_id'];
					$wt_type = "3";
				}else if ($_SESSION['buyer_id']!=""){ 
					$wt_user_id = 	$_SESSION['buyer_id'];
					$wt_type = "0";
				}
								
					
				//if($_SERVER['REMOTE_ADDR']!="110.142.231.92"){ 
					if($wt_user_id==""){
						//echome($page_count."-".date("Y-m-d h:i:s",$_SESSION['page_count_ts_last']).">".date("Y-m-d h:i:s",$timex_n)."- currently ".date("Y-m-d h:i:s"));
						if(($_SESSION['page_count_ts_last'])>$timex_n){
							//echome(" I am in here now".$_SESSION['bad_page_count']);
							// this means user is clicking page after page in less then a sec where page load time is more then a sec
							if($_SESSION['bad_page_count']>20){ 
							
								$blocked_ip_check = get_sql("block_ip_temp","id"," where ip_address='".mres($_SERVER['REMOTE_ADDR'])."' ");
								
								if($blocked_ip_check==""){ 
									$strx_err = $_SERVER['REMOTE_ADDR']."-".$page_count."-".$_SESSION['page_count_ts_last']."-".$_SESSION['page_count_ts_new']."<hr><br>";
									$strx_err.= print_r($_SERVER,true);
									sendmail("manish","manish@business2sell.com.au","Error : pagecount is pickedup ",$strx_err,"support@business2sell.com.au");
									//header("HTTP/1.0 404 Gone");
				
									$ins = mysql_query("insert into `block_ip_temp`(ip_address,count) value('".mres($_SERVER['REMOTE_ADDR'])."',".mres($_SESSION['bad_page_count']).")");
									
									$ndesc = $data_desc."\r\n".$timex."->".mres($_SERVER['REQUEST_URI'])."\r\n".$timex."->/default.php";
									$bool = mysql_query("update website_tracking set count=".$_SESSION['bad_page_count'].",description='".mres($ndesc)."' where id=".mres($data_id));
									
									$block_ip_arg = "/usr/sbin/csf -td ".$_SERVER['REMOTE_ADDR']." 600";
									//$block_ip_arg = "csf -d 105.156.2.48";
									exec($block_ip_arg);
	
									echo "Your Ip Address have been identified doing suspicous activity, for security reasons we have blocked your ipaddress access for next 10 min.<br>";
									echo "If you think this is incorrect, Please email us at support@business2sell.com.au with your ip address ".$_SERVER['REMOTE_ADDR']." and we will unblock it for you";

									die();
								}
	
							}else{
									$_SESSION['bad_page_count'] = ($_SESSION['bad_page_count']+1);							
							}// page count > 20 
						}else{
							$_SESSION['bad_page_count'] = 1;	
						}// if time if getting more 
					}// if($wt_user_id==""){
				//} // if office up address 
				
				$_SESSION['page_count'] = $page_count;
				$_SESSION['page_count_ts_last'] = $_SESSION['page_count_ts_new'];
				$_SESSION['page_count_ts_new'] = time();	
			
				$_SESSION['logref_id'] = $data_id;
				if($wt_user_id!=""){ 
					$sql ="update website_tracking set count=".mres($page_count).",description='".mres($data_desc)."\r\n".$timex."->".mres($_SERVER['REQUEST_URI'])."',user_id=".mres($wt_user_id).",user_type=".mres($wt_type)." where id=".mres($data_id);
				}else{
					$sql ="update website_tracking set count=".mres($page_count).",description='".mres($data_desc)."\r\n".$timex."->".mres($_SERVER['REQUEST_URI'])."' where id=".mres($data_id);
				}
				
			}
			
			//echome("2".$sql);
			$ins = mysql_query($sql);
			if($ins){  
				$_SESSION['wid']=mysql_insert_id();
			}
	}


	
?>