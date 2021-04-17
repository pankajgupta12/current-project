 <div  role="main">
		
		<?php  
		if(!isset($_SESSION['dashboard_data']['from_date'])){ $_SESSION['dashboard_data']['from_date'] = date("Y-m-1"); }
		if(!isset($_SESSION['dashboard_data']['to_date'])){ $_SESSION['dashboard_data']['to_date'] = date("Y-m-t"); }
		
		
		$quoteallinfo = getQuoteInfo($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date']);
		$allcancelledJobs = getCancelledJobs($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date'],1);
		
		$allcancelledmonthlyJobs = getCancelledJobs($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date'],2);
		
		print_r($allcancelledmonthlyJobs); 
		 
		?>
		  
          <!-- top tiles -->
          
           <div class="row tile_count">
              
               
            <div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Quote</span>
              <div class="count"><?php echo number_format_short($quoteallinfo['totalorder']); ?></div>
              <span class="count_bottom"><i class="green">100% </i> Quote </span>
            </div>
            <div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total Booked</span>
              <div class="count"><?php echo number_format_short($quoteallinfo['bookingid'] - $allcancelledJobs); ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?php // echo round(($quoteallinfo['bookingid']/$quoteallinfo['totalorder'])*100 , 2); ?>% </i><?php// echo $date; ?> Booked</span>
            </div>
            
            <div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total Cancceled</span>
              <div class="count"><?php echo number_format_short($allcancelledJobs); ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?php //echo round(($quoteallinfo['bookingid']/$quoteallinfo['totalorder'])*100 , 2); ?>% </i><?php// echo $date; ?> Booked</span>
            </div>
			
			 <div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i>Site Quote</span>
              <div class="count"><?php echo number_format_short($quoteallinfo['totalsites']); ?></div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i><?php echo round(($quoteallinfo['totalsites']/$quoteallinfo['totalorder'])*100 , 2); ?>% </i> Quote From Site</span>
            </div>
			
			<div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Admin Quote</span>
              <div class="count"><?php echo number_format_short($quoteallinfo['adminquote']); ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?php echo round(($quoteallinfo['adminquote']/$quoteallinfo['totalorder'])*100 , 2); ?>% </i> Quote From admin</span>
            </div>
			
            <div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total OTO (Q/B)</span>
              <div class="count green"><?php echo number_format_short($quoteallinfo['totalotobooking_id']); ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?php echo round(($quoteallinfo['totalotobooking_id']/$quoteallinfo['totalorder'])*100 , 2); ?> / <?php echo round(($totalotobooked/$totalquote)*100 , 2); ?>% </i> Quote Booked From OTO</span>
            </div>
           
            
             <div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i>Current Year Quote</span>
              <div class="count"><?php echo $quoteallinfo['currentquote']; ?></div>
              <span class="count_bottom"><i class="green">100% </i> Quote </span>
            </div>
            <div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Current Year Booked</span>
              <div class="count"><?php echo ($quoteallinfo['currentbooking_id'] -$allcancelledmonthlyJobs) ; ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?php echo round(($quoteallinfo['currentbooking_id']/$quoteallinfo['currentquote'])*100 , 2); ?>% </i><?php// echo $date; ?> Booked</span>
            </div>
			
			 <div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Current Cancceled</span>
              <div class="count"><?php echo number_format_short($allcancelledmonthlyJobs); ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?php //echo round(($quoteallinfo['bookingid']/$quoteallinfo['totalorder'])*100 , 2); ?>% </i><?php// echo $date; ?> Booked</span>
            </div>
			
			 <div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Current Year Quote Convert </span>
              <div class="count"><?php echo ($quoteallinfo['currentctodbooking']- $allcancelledmonthlyJobs) ; ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?php echo round(($quoteallinfo['currentctodbooking']/$quoteallinfo['currentquote'])*100 , 2); ?>% </i> <?php// echo $date; ?> Converted to Job</span>
            </div>
            <!--<div class="col-md-1 col-sm-4 col-xs-6 tile_stats_count">-->
            <!--  <span class="count_top"><i class="fa fa-user"></i> Total OTO (Q/B)</span>-->
            <!--  <div class="count green"><?php echo $totalotoquote.'/'.$totalotobooked; ?></div>-->
            <!--  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?php echo round(($totalotoquote/$totalquote)*100 , 2); ?> / <?php echo round(($totalotobooked/$totalquote)*100 , 2); ?>% </i> Quote Booked From OTO</span>-->
            <!--</div>-->
            <div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Current Year Quote From Site</span>
              <div class="count"><?php echo $quoteallinfo['currentsites']; ?></div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i><?php echo round(($quoteallinfo['currentsites']/$quoteallinfo['currentquote'])*100 , 2); ?>% </i> Quote From Site</span>
            </div>
            <div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Current Year Quote From Admin</span>
              <div class="count"><?php echo $quoteallinfo['currentadminquote']; ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?php echo round(($quoteallinfo['currentadminquote']/$quoteallinfo['currentquote'])*100 , 2); ?>% </i> Quote From admin</span>
            </div>
             <div class="col-md-1 col-sm-4 col-xs-4 tile_stats_count">
                
              </div>  
           
          </div>
        

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                  <div class="col-md-4 col-sm-6 col-xs-12">
                   <div  style="height: 450px;overflow: auto; font-size: 17px; background: #f7f1f1;">
                       
                        <?php //echo  '<pre>';  print_r(getTaskNotification());
                        
                       $infoUser =   getTaskNotification();
                       
                       // print_r($infoUser);
                       
                        ?>
                       
                        <td width="35%" style="font-weight: bold;margin: 11px;font-size: 15px;color: #00b8d4;" valign="top">
        			     <h3>Task Assigned (<?php echo $infoUser['total']; ?>)</h3>
        				<table width="100%" border="1" class="task_roles_table">
				<tbody>
				    
					<tr>
                            <td><b>Role</b></td>
                            <td><b>Name</b></td>
                            <td><b>Total</b></td>
                            <td style="background: #f08181;">P1</td>
                            <td style="background: #894b00;color: #fff;">P2</td>
                            <td style="background: rgb(255 165 0 / 52%);">P3</td>
                            <td style="background: #ffb66b;">P4</td>
                            <td style="background: #FFFF00;">P5</td>
                            
						</tr>    
				    
				  <?php  
				  
				  foreach($infoUser['infonoti'] as $key=>$value) { 
				  
				  ?>
						<tr>
						    <td><b><?php if($key > 0) { echo getSystemvalueByID($key, '102'); } else {echo 'Not assigned ';}?></b></td> 
						    <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            
						</tr>
						
						<?php  foreach($value as $key1=>$data1) { 
						
                            $count = 0;
                            foreach ($data1 as $type) {
                                 $total_count[] =  count($type);
                            }
						
						?>
						<tr>
							<td>&nbsp;</td>
							<td><?php  if($key1 > 0) { echo get_rs_value("admin","name",$key1); } ?></td>
							<td><?php  if($key1 > 0) { echo array_sum($total_count); } ?></td>
							<td><?php if(count($data1[1]) >0) { echo count($data1[1]); } ?></td>
							<td><?php if(count($data1[2]) >0) { echo count($data1[2]); } ?></td>
							<td><?php if(count($data1[3]) >0) { echo count($data1[3]); }  ?></td>
							<td><?php if(count($data1[4]) >0) { echo count($data1[4]); }  ?></td>
							<td><?php if(count($data1[5]) >0) { echo count($data1[5]); }  ?></td>
					    </tr>
						<?php unset($total_count); } 
						 ?>
						
				  <?php  } ?>
				</tbody>
				</table>

				</td>
                       
                       
                   </div>
                </div>
               
				<?php 
				//$sql = mysql_query("Select id , name , loggedin, login_status , auto_role  from admin WHERE    login_status = 1 Order by name asc");  
				//timeago
				$getautorole = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id) as id ,  GROUP_CONCAT(name) as name FROM `system_dd`  WHERE type = 102 ORDER BY `id_val` DESC"));
				$permanentrole = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id) as id ,  GROUP_CONCAT(name) as name FROM `system_dd`  WHERE type = 155 ORDER BY `id_val` DESC"));
				$sql = mysql_query("Select id , name , auto_role , login_status , role_manager , is_call_allow , loggedin, permanent_role , country_name  from admin where status = 1 Order by login_status desc , name asc");
         
		        $country = array('0'=>'Select Role' ,  '3'=>'Role',  '2'=>'Australia Team' , '1'=>'India Team');
			
			    while($getdata1 = mysql_fetch_assoc($sql)) {
					
					$allteamdata1[$getdata1['country_name']][] = $getdata1;
					
					if($getdata1['auto_role'] != 0) {
					  $getadminname[] = $getdata1;
					}
					
					if($getdata1['permanent_role'] != 0 && $getdata1['permanent_role'] != '') {
					  $getpermanent_role[] = $getdata1;
					}
			    }
			  
			       $getauoroleids = explode(',' ,$getautorole['id']);
			       $getauorolename = explode(',' ,$getautorole['name']);
			       
				   $getauorole = array_combine($getauoroleids , $getauorolename);
				  
			     if(count($allteamdata1) > 0){
				?>
				
				 <div class="col-md-8 col-sm-6 col-xs-12 bg-white " style="height: 450px;overflow: auto;">
                    <table  border="1" style="width: 100%;background: #efe3e37d;color: black;font-weight: 600;" >
                <tbody>
                    <tr>
                    <?php   foreach($country as $cid=>$cname) { 
					
					
					 if($cid == 0) {
					
					?>     
					 <td colspan="4" style="margin-right:10px; vertical-align: top; padding-top: 10px; width: 25%;" ><h3 style="text-align: center;font-size: 21px;"><?php echo $country[$cid]; ?></h3>
                               <table border="1" width="100%">
                                   <tbody>
                                         <?php   
                                          $k = 1;
									$columns = array_column($getadminname, 'auto_role');
									array_multisort($columns, SORT_ASC, $getadminname);
										  
										 if(!empty($getadminname)) { 
										 foreach($getadminname as $key=>$adminname ) { 
										    if($adminname['is_call_allow'] == 1 && $adminname['login_status'] == 1) {
                                         ?>
                                          <tr> 
                                              								  
                                               <td style="padding: 0px 0px;font-size: 13px;padding-left: 10px;"><?php  echo ucfirst(explode(' ', $adminname['name'])[0]); ?>
											   <span style="float: right;margin-right: 13px;"><?php echo $getauorole[$adminname['auto_role']]; ?></span>
											   </td>
											  
                                            </tr>
										  
										   
										   
										   <?php } $k++; } }else{  ?>  
										    <tr> 
										      <td style="padding: 0px 0px;font-size: 13px;padding-left: 10px;">Not Found</td>
                                            </tr>  
                                        <?php  }  ?>
                                   </tbody>
                                </table>
                        </td>
					
					 <?php  }elseif($cid == 3)  {
					 
                            $paramanetroleids = explode(',' ,$permanentrole['id']);
                            $paramanetrolename = explode(',' ,$permanentrole['name']);
                            $paramanetauorole = array_combine($paramanetroleids , $paramanetrolename);
					  
					 
					 ?>
                        
						 <td colspan="4" style="margin-right:10px; vertical-align: top; padding-top: 10px; width: 20%;" ><h3 style="text-align: center;font-size: 21px;"><?php echo $country[$cid]; ?></h3>
                               <table border="1" width="100%">
                                   <tbody>
                                         <?php   
                                          $k = 1;
									$columns = array_column($getpermanent_role, 'auto_role');
									array_multisort($columns, SORT_ASC, $getpermanent_role);
										  
										 foreach($getpermanent_role as $key=>$adminname ) { 
										     
										     if($paramanetauorole[$adminname['permanent_role']] !='' && $adminname['is_call_allow'] == 1) {
                                         ?>
                                           <tr> 
                                              								  
                                               <td style="padding: 0px 0px;font-size: 13px;padding-left: 10px;"><?php  echo ucfirst(explode(' ', $adminname['name'])[0]); ?>
											   <span style="float: right;margin-right: 13px;"><?php echo $paramanetauorole[$adminname['permanent_role']]; ?></span>
											   </td>
											  
                                            </tr>
										   <?php   } $k++; }   ?>    
                                       
                                   </tbody>
                                </table>
                        </td>
                        
                    <?php  }else { ?>    
						
						
                        <td colspan="4" style="margin-right:10px; vertical-align: top; padding-top: 10px; width: 22%;" ><h3 style="text-align: center;font-size: 21px;"> <?php echo  $cname; ?> (<?php echo count($allteamdata1[$cid]); ?>)</h3>
                               <table border="1" width="100%">
                                   <tbody>
                                         <?php   
                                         $j = 1;
										 foreach($allteamdata1[$cid] as $key=>$admin ) {
										     
										    
										     
                                         ?>
                                          <tr> 
                                               <?php  if($admin['login_status'] == 1)  { ?>										  
                                               <td style="padding: 0px 0px;font-size: 13px;padding-left: 10px;" class="posRelNewGreen"><span><?php  echo $admin['name']; ?></span>
                                               (<?php // if($admin['auto_role'] >  0) {
                                                   
                                                   if(in_array($_SESSION['admin'] , array(1,17,12,72))) {
                                               ?> 
                                               <span><?php echo create_dd("auto_role","system_dd","id","name","type=102 AND status = 1 AND id in (".$admin['role_manager'].") ORDER BY name ASC","onchange=\"javascript:edit_field(this,'admin.auto_role',".$admin['id'].");\"", $admin,'field_id'); ?></span>
                                               <?php }else if($admin['auto_role'] >  0) { echo $getauorole[$admin['auto_role']]; ?> <?php  }else { echo 'N/A';} ?> )
                                               <span class="greendata"></span></td>
											   <?php  }else { ?>
											   <td style="padding: 0px 0px;font-size: 11px;padding-left: 10px;" ><span><?php  echo $admin['name']; ?></span> <?php  if($admin['auto_role'] >  0) { ?>(<?php echo $getauorole[$admin['auto_role']]; ?>) <?php  } ?> <span style="float: right;margin-right: 5%;font-size: 10px;"><?php echo timeago($admin['loggedin']); ?></span></td>
											   <?php  } ?>
                                            </tr>
                                          <?php  $j++; }   ?>    
                                       
                                   </tbody>
                                </table>
                        </td>
					 <?php }  } ?>
                    </tr>
                </tbody>
            </table>

                </div>
				 <?php  } ?>

                <div class="clearfix"></div>
              </div>
            </div>

        </div>
		  
		   <hr/>
		   <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="dashboard_graph"> 
                     <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                         <div id="chartContainer1" style="height: 300px; width: 100%;"></div>
                        </div>
        				
                        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 bg-white">
                            <div id="chartContainer2" style="height: 300px; width: 100%;"></div>
        
                        </div>
                        
                         <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 bg-white">
                             
                            <div id="chartContainer8" style="height: 300px; width: 100%;"></div>
        
                        </div>
                        
                    
                     <!---<div class="col-md-6 col-sm-6 col-xs-12">
                       <div  style="height: 350px; width: 100%;"></div>
                    </div>-->

                <div class="clearfix"></div>
              </div>
            </div> 
          </div>     
		    <hr/>
		   
		  <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">
				
                 <div class="col-md-12 col-sm-12 col-xs-12">
                   <div id="chartContainer6" style="height: 300px; width: 100%;"></div>
                </div>

                <div class="clearfix"></div>
              </div>
            </div>

          </div> 
		     <div class="clearfix"></div>
		     <div class="clearfix"></div>
		  
		   <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">
				
					<div class="col-md-11 col-sm-11 col-xs-12">
					  <div id="chartContainer3" style="height: 300px; width: 100%;"></div>
					</div>

                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />
 
            <!--<div class="row">
                 <div class="col-md-12 col-sm-12 col-xs-12">
                   <div id="chartContainer6" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
             <br />-->
          <div class="row">


           

              <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
					 <div id="chartContainer7" style="height: 300px; width: 100%;"></div>
					</div>


            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                   <div id="chartContainer5" style="height: 300px; width: 100%;"></div>
              </div>
            </div>
          </div>
      </div>
	 <style>
	.dashboard_graph .posRelNewGreen:before {
	top: 0;
	right: 10px;
	left: auto;
	}
	 
        table.task_roles_table tr td {
        text-align: center;
        }
	 </style> 