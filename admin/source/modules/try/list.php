<?php

	$r=0;
	//print_r($_POST);
	$match_arr = array("user_id","category_id");
	
	// you need any task perfonrmed before showing list on any section add code in here 
	include("source/list_task.php");
		
		
	//echo $_POST['search_form_new'];
	if($t=="36" && $a=="list"){
		
		if ($_POST['search_form']==1){ 
				$arg = "select * from $table where status=2 and ". $_POST['search_field_name'] ." like '%".$_POST['search_keyword'] ."%'";
		}else{
			$arg = "select * from $table  where status=2  ";
		}
			
	}else{
		if ($_POST['search_form']==1){ 
		    
			if(in_array($_POST['search_field_name'],$match_arr)){ 
			    
				$arg = "select * from $table where status=2 and ". $_POST['search_field_name'] ." ='".trim($_POST['search_keyword']) ."'";
			}else{
				$arg = "select * from $table where ". $_POST['search_field_name'] ." like '%".trim($_POST['search_keyword']) ."%'";
			}
		}else if($_POST['search_form_new']=="1"){ 
			//echo "I am here ";
			$arg = "select * from $table ";
			$flagy = false;
			foreach($listname as $valuey){
				if($_POST[$valuey]!=""){ 
					if($flagy==true){ $arg.=" and "; }else{ $arg.=" where "; $flagy=true; } 
					
					if(in_array($valuey,$match_arr)){ 
						$arg.= "`".$valuey."` ='".trim($_POST[$valuey])."' ";
					}else{
						$arg.= "`".$valuey."` like '%".trim($_POST[$valuey])."%' ";
					}
					
					$_SESSION['new_search'][$valuey]= trim($_POST[$valuey]);
				}else{
					$_SESSION['new_search'][$valuey]="";
				}
			}
			//$arg = "select * from $table where ". $_POST['search_field_name'] ." like '%".$_POST['search_keyword'] ."%'";
			
		}else{
			$arg = "select * from $table";
		}
	}
	
	//echo $arg;
	
	if($_GET['offset']!=""){
		$arg=$_SESSION['search_arg'];
	}else{
		$_SESSION['search_arg']=$arg;
	}
	
	
	if ($listopt=="order"){ $colspan=3; }else{ $colspan=2; }
	//$row = mysql_fetch_array(mysql_query($arg ));
	$data = mysql_query( $arg);
	$listings = mysql_num_rows($data);
	
	if(!isset($_GET['limit'])){	$limit=25; }

	if(!isset($_GET['offset'])){ $offset = 0;}else{ $offset= $_GET['offset']; }

	if ($offset==""){ $offset=0; }
	
	if($limit > $listings){ $limit = $listings; }

	$back = $offset-$limit;
	$forth = $offset+$limit;
	$pages = @ceil($listings / $limit);
	$current_page = @($offset / $limit)+1;
	if($current_page>10){
		$lastpage=$current_page+10;
		$firstpage=$current_page-0;
	}else{
		$lastpage=10;
		$firstpage=1;
	}
	if($lastpage>=$pages){$lastpage=$pages;}
	//echo $firstpage ."--".$lastpage;
	if ($listopt=="order"){  $arg.= " order by order_id "; }else{ $arg.= " order by id desc "; }
	$arg .= " LIMIT $offset, $limit";
//	echo ($arg);
	$data = mysql_query($arg);
?>
<form name="form1" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']?>" onSubmit="return valid_form(this);">
  <div class="staff_back_box"> <span class="staff_text">List <?php echo $title?></span>
   <span id="remove_staff_journal" style="color: red; margin-top: -29px; float: right; margin-right: 201px;"></span>
    <div class="left_staff_box">
      <ul class="pagination_bar">
      <li><a href="">Page 1  to <?php echo $lastpage;?></a></li>
      <?php 
		$xoffset=($firstpage-1)*$limit;
		for ($i=$firstpage;$i<=$lastpage;$i++)
		{
			
			if($xoffset==$offset){	
				//echo "<li>".$i."</li>";
				echo "<li><a href='".$_SERVER['SCRIPT_NAME']."?task=".$t."&action=".$a."&offset=".$xoffset."'><strong>".$i."</strong></a></li>";
			}else{
				
				echo "<li><a href='".$_SERVER['SCRIPT_NAME']."?task=".$t."&action=".$a."&offset=".$xoffset."'>".$i."</a></li>";
				
			}
			
			$xoffset	=	$xoffset+$limit;
			
		} ?>
        
        
      <?php if ($current_page<$pages && $current_page!=1){?>
      &nbsp;
      <?php } ?>
      <?php if ($current_page!=$pages){?>
      <li><a href="<?php echo "".$_SERVER['SCRIPT_NAME']."?task=".$t."&action=".$a."&offset=".$forth; ?>">&gt;&gt;</a></li></strong>
      <?php } ?>
		
     </ul></div>
    <div class="midle_staff_box"> <span class="midle_text" style="right: -19px;">Total Records Found <?php echo $listings;?></span></div>
    <div class="right_staff_box">
      <input onClick="javascript:window.location='../admin/index.php?task=<?php echo $task;?>&action=add';" type="button" class="staff_button" value="+&nbsp;<? echo $title?>">
    </div>
    <div class="usertable-overflow">
      <table class="staff-table">
        <thead>
          <tr>
            <?php 
					   if (strpos($listopt,"|")>0){
						   $listopt_arr = explode("|",$listopt);
						   $listoptionscode = $listopt_arr[0];
					   }else{
							$listoptionscode = $listopt;
					   }
					   
				//	echo $listoptionscode;    
					   
						   if ($listoptionscode=="order"){  ?>
            <th>Order</th>
            <?php }else if($listoptionscode=="open_close"){ ?>
            <th>Open/Close</th>
            <?php } ?>
            <?php
			    if(rw("task")=="25"){	
				//echo count($listheading) + 1;
				  $listheading[count($listheading) + 1] = 'Site name';
			    }
				
					//$listheading  = str_replace('Price Match' , 'Accept OTO' , $listheading);	
					
					//print_r($listheading);	
					
			foreach ($listheading as $valuex) { ?>
            <th><?php if(rw("task")=="4" && $valuex == 'Price Match')  {	 echo str_replace('Price Match' , 'Accept OTO' , $valuex); }else if($valuex == 'apikey') {  echo 'Default  Roster'; } else { echo $valuex;  } ?></th>
            <?php }?>
            <th>Modify</th>
            <th><input name="checkall" type="checkbox" id="checkall" value="checkbox" onClick="clickcheck();"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
                <?php
					$_SESSION['search']['listname'] = $listname;
					foreach($listname as $valuey) { 
				?>
                <td><input type="text" name="<?php echo $valuey;?>" id="<?php echo $valuey?>" value="<?php echo $_SESSION['new_search'][$valuey];?>"></td>
            <?php } ?>
           <?php /*?> <td>
              <input name="search_form_new" type="hidden" id="search_form_new" value="1">
              <input name="task" type="hidden" value="<?php echo $t;?>">
              <input name="action" type="hidden"  value="list">
              <input type="text" class="search_field_box search_field_box5">
              <input type="submit" name="" value="" class="search_img">
              </td>              
              </form>
			  <form name="form1" method="post" action="<? echo $_SERVER['SCRIPT_NAME']?>" onSubmit="return valid_form(this);">
            <td><input type="checkbox" name="" value=""></td>
          </tr><?php */?>
          
          <td width="10%" colspan="2">
    <input type="submit" name="Search" id="Search" value="Search">
      <input name="search_form_new" type="hidden" id="search_form_new" value="1">
      <input name="task" type="hidden" value="<? echo $t;?>">
      <input name="action" type="hidden"  value="list"> </td>
    
  </tr>
  </form>
    <form name="form1" id="list_form" method="post" action="<? echo $_SERVER['SCRIPT_NAME']?>" onSubmit="return valid_form(this);">
          <?php 		
					  if (mysql_num_rows($data)>0){ 
					  
							  while($r < (mysql_num_rows($data))){
								  
								  
									$j=0;
									foreach($listname as $value) { 
									
									
									      
									
												$id=mysql_result($data,$r,"id");
												$details = mysql_fetch_array($data);
												
									  //	echo $listtype[$j];
									
												if ($listtype[$j]=="fdate"){
													$new[$value]=rotatedate(mysql_result($data,$r,$value));
												}else if($table == 'admin_time_shift') {
												    $new[$value] = mysql_result($data,$r,$value);
												}else if ($listtype[$j]=="xjax_dd_div"){
												    
													if($listtypevalue[$j]!=""){
													    
													// print_r(mysql_result($data,$r,$value));
													
														if($listtypevalue[$j]!=""){ 
															if(strpos($listtypevalue[$j],",")>0){ 
																$dd_values = explode(",",$listtypevalue[$j]);
																
																//$new[$value]= get_rs_value($dd_values[1],$dd_values[3],mysql_result($data,$r,$value));
																
																if($dd_values[2]=="id"){
																	if($dd_values[4]!=""){
																		//$new[$value]= get_sql($dd_values[1],$dd_values[3],"where id=".mysql_result($data,$r,$value)." and ".$dd_values[4]);	
																		// eg : state = state;
																		$q1=explode("=",$dd_values[4]);
																		$q1field_val = mysql_result($data,$r,$q1[1]);
																		$new_query= $q1[0]."='".$q1field_val."'";
																	//	echo "<br>".$new_query."<br>";
																		$new[$value]= get_sql($dd_values[1],$dd_values[3],"where ".$new_query);	
																	}else{
																		$new[$value]= get_sql($dd_values[1],$dd_values[3]," where ".$dd_values[2]."='".mysql_result($data,$r,$value)."'");
																	}
																}else{
																	$new[$value]=mysql_result($data,$r,$value);
																}
															}else{
																$new[$value]=mysql_result($data,$r,$value);
															}
														}else{
															$new[$value]=mysql_result($data,$r,$value);	
														}
													}
												}else if($listtype[$j]=="dd"){
													
												//	echo  $listtype[$j];
													
													//$dd_values = explode(",",$listtypevalue[$j]);
													//$new[$value]= get_rs_value($dd_values[1],$dd_values[3],mysql_result($data,$r,$value));
													$dd_values = explode(",",$listtypevalue[$j]);
													//print_r($dd_values);
													//echo $listtypevalue[$j]. '<br/>';
													if (strpos($dd_values[4],"{")>0){
														$cond = $dd_values[4] ; // course_id={course_id}
														$pos1= strpos($cond,"{");
														$pos2 = strpos($cond,"}");
														$word_length = $pos2 - ($pos1+1);
														//echo $pos1."-".$pos2."-".$pos3."-".$cond;
														$cond_field = substr($dd_values[4],$pos1+1,$word_length);
														//echo "<br>".$cond_field;
														$new_cond = substr($dd_values[4],0,$pos1)."'".$details[$cond_field]."'";
														//echo "<br>".$new_cond."<br>";
														$dd_values[4] = $new_cond;
														$new[$value]= get_sql($dd_values[1],$dd_values[3]," where ".$dd_values[2]."='".mysql_result($data,$r,$value)."'");
														
													}else{ 
													
														if($dd_values[4]!=""){
															$new[$value]= get_sql($dd_values[1],$dd_values[3],"where ".$dd_values[2]."='".mysql_result($data,$r,$value)."' and ".$dd_values[4]);	
														}else{
															$new[$value]= get_sql($dd_values[1],$dd_values[3]," where ".$dd_values[2]."='".mysql_result($data,$r,$value)."'");
														}
													}
												}else if (strpos($value,"email")>-1 && rw("task")!= "28"){
													
													$new[$value]="<a href=\"mailto:".mysql_result($data,$r,$value)."\">".mysql_result($data,$r,$value)."</a>";
												}else if (strpos($value,"datetime")>-1){
												    
													$new[$value]=mysql_result($data,$r,$value);
														//echo 'ff11111';
												}else if (strpos($value,"time")>-1){
												    
												    if($value == 'schedule_time') {
												        $new[$value] = mysql_result($data,$r,$value);
												    }else {
												    	$new[$value]=date("H:i:s",mysql_result($data,$r,$value));
												    }
												
												}else if ($listtype[$j]=="doc"){
													$new[$value]="<a href=\"javascript:scrollWindow('".mysql_result($data,$r,$value)."','300','350')\">View Document</a>";
												}else if(($listtype[$j]=="file") || (strpos($value,"images")>-1)){
													$new[$value]="<a href=\"javascript:scrollWindow('details.php?img=".mysql_result($data,$r,$value)."','300','350')\">
													<img src=\"".mysql_result($data,$r,$value)."\" width=\"100\" border=\"0\"></a>";
												}else{
													
												//	echo $value;
													
														if(($value=="user_id") || ($value=="broker_id") || ($value=="franchise_id") || ($value=="to_user_id")){ 
															
															$new[$value]="<a href=\"javascript:scrollWindow('summary.php?t=users&f=id&k=".mysql_result($data,$r,$value)."','600','650')\" class=\"text12\">".mysql_result($data,$r,$value)."</a> 
					<a href=\"javascript:scrollWindow('/management/notes.php?user_id=".mysql_result($data,$r,$value)."','750','600')\" class=\"text12\"><img src=\"/images/general/notes.jpg\" width=16></a>";
														}else if(($value=="agent1")){ 
															$new[$value]="<a href=\"javascript:scrollWindow('summary.php?t=agents&f=id&k=".mysql_result($data,$r,$value)."','600','650')\" class=\"text12\">".mysql_result($data,$r,$value)."</a>";
														}else if(($value=="buyer_id") || ($value=="from_buyer_id")){ 
															$new[$value]="<a href=\"javascript:scrollWindow('summary.php?t=buyers&f=id&k=".mysql_result($data,$r,$value)."','600','650')\" class=\"text12\">".mysql_result($data,$r,$value)."</a> <a href=\"javascript:scrollWindow('/management/buyer_notes.php?buyer_id=".mysql_result($data,$r,$value)."','750','600')\"><img src=\"/images/general/notes.jpg\" width=\"16\"></a>";
														}else if($value=="listing_id"){ 
															if(mysql_result($data,$r,$value)!=""){ 
																$geturl = get_rs_value("listings","page_url",mysql_result($data,$r,$value));
																$new[$value]="<a href=\"".Site_url.$geturl."\" class=\"text12\" target=\"_blank\">".mysql_result($data,$r,$value)."</a>";
															}else{
																$new[$value]=mysql_result($data,$r,$value);
															}
														}else if(($value=="page_url")){ 
															if(mysql_result($data,$r,$value)!=""){ 
																
																$new[$value]="<a href=\"".mysql_result($data,$r,$value)."\" class=\"text12\" target=\"_blank\">View</a>";
																if(rw("task")=="9"){ 
																	$new[$value].="<br><a href=\"javascript:scrollWindow('othersites.php?id=".mysql_result($data,$r,"id")."','600','650')\" class=\"text12\" target=\"_blank\">Other Sites</a>";
																}
																//$new[$value]="<a href=\"http://www.johnstonmarketing.com.au/listing1.php?url=".str_replace("http://","",mysql_result($data,$r,$value))."\" class=\"text12\" target=\"_blank\">View</a>";
															}else{
																$new[$value]=mysql_result($data,$r,$value);
															}
															
														//echo mysql_result($data,$r,$value);	
															
														}else if(($task=="111") && ($value=="url")){ 
															if(mysql_result($data,$r,$value)!=""){ 
																
																$new[$value]="<a href=\"http://www.businesses2sell.com.au".mysql_result($data,$r,$value)."\" class=\"text12\" target=\"_blank\">View</a>";
																
																//$new[$value]="<a href=\"http://www.johnstonmarketing.com.au/listing1.php?url=".str_replace("http://","",mysql_result($data,$r,$value))."\" class=\"text12\" target=\"_blank\">View</a>";
															}else{
																$new[$value]=mysql_result($data,$r,$value);
															}
														}else if(($value=="b4s") ||($value=="domain") ||($value=="b4sale_uk")||($value=="commview")||($value=="bsale") ||($value=="br_domain")){ 
															if(mysql_result($data,$r,$value)!=""){ 
																
																$new[$value]="<a href=\"".mysql_result($data,$r,$value)."\" class=\"text12\" target=\"_blank\">View</a>";
																/* $url = str_replace("http://","",mysql_result($data,$r,$value));
																$url = str_replace("https://","",$url);
																
																$new[$value]="<a href=\"http://www.johmar.com.au/listing1.php?sec=thisisaverybigsecret&url=".$url."\" class=\"text12\" target=\"_blank\">View</a>"; */
																
															}else{
																$new[$value]=mysql_result($data,$r,$value);
															}
														}else if(($value=="comment")){ 
															$new[$value]=mysql_result($data,$r,$value);
														}else if(($value=="permission")){ 
															$new[$value]=mysql_result($data,$r,$value);
															
															if($new[$value] != '') {
																$getadminname = mysql_fetch_array(mysql_query("SELECT GROUP_CONCAT(name) as name  FROM `system_dd` WHERE `id` IN (".$new[$value].") AND `type` = 74"));
																$new[$value] = $getadminname['name'];
															}else{
																$new[$value] = '';
															}
															
														}else if(($value=="admin_type")){ 
															$new[$value]=mysql_result($data,$r,$value);
															
															if($new[$value] != '') {
																$getadminname = mysql_fetch_array(mysql_query("SELECT GROUP_CONCAT(name) as name  FROM `system_dd` WHERE `id` IN (".$new[$value].") AND `type` = 92"));
																$new[$value] = $getadminname['name'];
															}else{
																$new[$value] = '';
															}
															
														}else{
														//	echo $value;
															//if($t==119){ 
															//echo strlen($new[$value]);
																//$new[$value] = $nval_sml;
															//	$new[$value]=str_replace("\r\n","<br>",mysql_result($data,$r,$value));
															//}else{ 
																$new[$value]=mysql_result($data,$r,$value);
																if(strlen($new[$value])>150){ 
																	//$nval_sml = '<a href="javascipt:show_div(smalldiv'.$id.')">'.substr($new[$value],0,50).'...</a>';
																	//$nval_sml.= '<div id="smalldiv'.$id.'" onclick="show_div(smalldiv'.$id.')" style="display:none">'.$new[$value].'</div>';
																	$nval_sml= substr($new[$value],0,50);
																	//echo $nval_sml."<br>";
																	$new[$value] = $nval_sml;
																}
															//}
														}
													
												}
												
												
												$j++;
									}
									if ($cc=="#cccccc") { $cc="#ebebeb"; }else{ $cc="#cccccc"; }
									
					if(($table=="admin")){ 				
					//	echo '<pre>';	print_r($new);
						 $rosterdata = getrosterdefault($new['id']);
						 $new['apikey'] = $rosterdata;
						 //	echo ($rosterdata);
						//select  day , (SELECT start_time_au FROM `admin_time_shift` WHERE id = A.start_time_au ) as startau, (SELECT end_time_au FROM `admin_time_shift` WHERE id = A.end_time_au ) as endau  FROM `admin_roster_default` as A WHERE admin_id = 15
						
					}
						
			//	echo $new['apikey']; 		
						
							  ?>
          <tr  <?php if(($_GET['task'] == 4 && $new['no_work'] == 'Yes') || ($_GET['task'] == 21 && $new['status'] == 'Deactivate')) {  ?> style="background-color:#cab3b3;" <?php  } ?>> 
            <!-- first rows for order, open_close div etc starts here -->
            <?php if ($listoptionscode=="order"){ ?>
            <td ><a href="javascript:send_data('<?php echo $id?>',13,'auot_list_div')"> <img src="/management/images/up.gif" width="18" height="16" border="0"/></a> <a href="javascript:send_data('<?php echo $id?>',14,'auot_list_div')"><img src="/management/images/down.gif" width="18" height="16" border="0"/></a></td>
            <?php }else if ($listoptionscode=="open_close"){ 
								
								?>
            <td ><a href="javascript:change_image_op(<?php echo$id;?>,<?php echo $listopt_arr[1]?>);"> <img src="/management/images/open.bmp" width="18" height="16" border="0" id="opimg_<?php echo$id;?>"/></a></td>
            <?php } ?>
            
            <!-- data rows start here -->
            <?php 
			
			    if($new['job_types'] && rw("task")=="4") {
					  $getJobtype = explode(",", $new['job_types']);
					  $getJobtype_data = implode("','" , $getJobtype);
				      $getJobtype = mysql_fetch_assoc(mysql_query("SELECT group_concat(job_icon) as jobicon , group_concat(name) as jname  FROM `job_type` WHERE `name` IN ('".$getJobtype_data."')"));
					
					if($getJobtype['jobicon'] != '') {
					   $jobicon = '';
					   $getJobtype1 = explode(",", $getJobtype['jobicon']);
					   $jobjname = explode(",", $getJobtype['jname']);
						$z = 0;
					    foreach($getJobtype1 as $key1=>$jobvalue){
						  $jobicon .= '<img class="image_icone" src="icones/job_type32/'.$jobvalue.'" alt='.$jobvalue.' title='.$jobjname[$z].'>';
						  $z++;
					    }
						
					   $new['job_types'] = $jobicon; 
					}
			    }
				
				
			        if($new['Avaibility']  && rw("task")=="4"){
						$availstring = explode(",", $new['Avaibility']);
						
						$acronym = "";
						$getaval = array();
						foreach($availstring as $avil_value) {
							$getaval[] = $avil_value[0];
						}
						
						$availstring_data = implode(',' , $getaval);
						
						$new['Avaibility'] =  $availstring_data;
					}
			if(rw("task")=="25"){		
				//print_r($new);
                       $staff_id = get_rs_value("staff_trucks","staff_id",$new['id']);				
                       $site_id = get_rs_value("staff","site_id",$staff_id);				
                       $sites_name = get_rs_value("sites","name",$site_id);		
                       $new['site_name']	= 	$sites_name;		   
			}
			
			if(rw("task")=="12" && $new['adminid'] == ''){
				//echo '<pre>';  print_r($new);
				$adminid = get_rs_value("c3cx_users","adminid",$new['id']);		
				$new['adminid'] = get_rs_value("admin","name",$adminid);		
				
			}
			
     //echo rw("task");				
				
			foreach ($new as $valuen) { ?>
            <td <?php if(rw("task")=="25" && $sites_name != '') { ?> title="<?php echo $sites_name;  ?>" <?php } if($new['job_types'] !='') { ?>style="white-space: nowrap;" <?php  } ?>><?php if(rw("task")=="21" && $valuen == 'No') { ?><img src="../admin/images/no_icon.png" style="height: 23px;padding: 2px;"><?php }elseif(rw("task")=="21" && $valuen == 'Yes') { ?> <img src="../admin/images/check_agree.png" style="height: 23px;padding: 2px;"><?php  }else { echo "$valuen";?> <?php  } ?></td>
            <?php } ?>
            <td>
			 <?php if(rw("task")=="21"){ ?>
               <input type="button" onclick="javascript:scrollWindow('admin_popup.php?task=<?php echo "$t";?>&action=modify&id=<?php echo "$id";?>','1200','850')";  class="inner_btn" value="Modify"><br>
			   
			<?php }else  if(rw("task")=="4"){ ?>
              <input type="button" onclick="window.location='<?php echo $_SERVER['SCRIPT_NAME'];?>?task=journal&staff_id=<?php echo "$id";?>';" class="inner_btn" value="Journal Rep"><br>
               <input type="button" onclick="javascript:scrollWindow('staff_details.php?task=<?php echo "$t";?>&action=modify&id=<?php echo "$id";?>','1200','850')"; class="inner_btn" value="Modify"><br>
			   
			   <input type="button" onclick="javascript:scrollWindow('staff_details.php?task=staff_location&id=<?php echo "$id";?>','1200','850')"; class="inner_btn" value="Staff Location">
			   <?php   if($new['bbc_leads'] == 'Yes') { ?>
					   <br>
					   <input type="button" onclick="javascript:scrollWindow('staff_details.php?task=42&action=modify&id=<?php echo "$id";?>','1200','850')"; class="inner_btn" value="BBC Leads ">
			   
			   <?php } }elseif(rw("task")=="23") { 
			 
		
			
			?>
			
			  <input type="button" onclick="javascript:scrollWindow('real_staff_details.php?task=<?php echo "$t";?>&action=modify&id=<?php echo "$id";?>','1200','850')";  class="inner_btn" value="Modify"> <br/>
			
			<?php } else if(rw("task")=="15"){ ?>
             
			  <input type="button" onclick="window.location='<?php echo $_SERVER['SCRIPT_NAME'];?>?task=<?php echo "$t";?>&action=modify&id=<?php echo "$id";?>'" class="inner_btn" value="Modify"> <br/>
			  
			  <?php  if($new['is_cron_added'] == 1) { ?>
                  <input type="button"  style="background-color: #ce9696; cursor: not-allowed;" class="inner_btn" value="Created Crons">
			  <?php  }else { ?> 
			     <input type="button" id="create_crons" onClick="send_data('<?php echo "$id";?>' , 263 , 'create_crons');" class="inner_btn" value="Cron Create"><br> 
			  <?php  } ?>
			 
			<?php  } else { ?>
			
              <input type="button" onclick="window.location='<?php echo $_SERVER['SCRIPT_NAME'];?>?task=<?php echo "$t";?>&action=modify&id=<?php echo "$id";?>'" class="inner_btn" value="Modify">
              <?php   if(rw("task")=="7" && in_array($_SESSION['admin'],array('1','4'))){ ?>
                  <input type="button" onclick="delete_journal('<?php echo $id;?>', this);" class="inner_btn" value="Delete">
			  <?php }?> 

             <?php } ?>
              </td>

            <td><input type="checkbox" name="c<?php echo $id?>" value="checkbox"></td>
          </tr>
          <?php 
							   if ($listoptionscode=="open_close"){ 
								echo "<tr><td colspan=\"". (count($listheading)+2)."\"><div id=\"opdiv_". $id."\" style=\"display:none\"></div></td></tr>";
							   }
							  $r++; 
							  }
						}else{?>
          <tr class="boldtext">
            <td colspan="<?php echo (count($listheading)+2)?>" height="50" align="center"><font color="<?php echo $table_fontcolor;?>">No Rows Found</font></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <?php if (mysql_num_rows($data)>0){  ?>
    <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
      <tr bgcolor="<?php echo $td_bgcolor; ?>" class="text12">
        <td><div align="right">
            <!--<input name="Submit" type="submit" class="delete_btn" value="Delete">-->
            <a onclick="delete_id()" class="delete_btn">Delete</a>
            <input type="hidden" name="task" value="<?php echo $t?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="step" value="1">
          </div>
		</td>
      </tr>
    </table>
    <?php } ?>
	
  </div>
</form>

 <script>
     function delete_id(){
		 
		 if(confirm('Are you sure you want to delete this item?'))
			 {
				// alert('sdsd');
				document.getElementById("list_form").submit();
				//window.location.href='index.php?delete_id='+id;
			 }
		 
	 }
  </script>