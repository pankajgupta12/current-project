 <div  role="main">
		
		<?php  
		if(!isset($_SESSION['dashboard_data']['from_date'])){ $_SESSION['dashboard_data']['from_date'] = date("Y-m-1"); }
		if(!isset($_SESSION['dashboard_data']['to_date'])){ $_SESSION['dashboard_data']['to_date'] = date("Y-m-t"); }
		
		
		//$date = date('Y-m-d');
		
	/* 	$quoteinfo = getTotalQuoteInfo($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date']);
		$totalOTo = getTotalOTOBooked($_SESSION['dashboard_data']['from_date'] , $_SESSION['dashboard_data']['to_date']); */
		
		//print_r($totalOTo);
		/* $quoteinfo = '';
		$totalOTo = ''; */
		
		/* $totalquote = $quoteinfo['totalquote'];
		$totalbooked = $quoteinfo['booked'];
		$sitequote = $quoteinfo['site'];
		$adminquote = $quoteinfo['adminquote'];
		$converttobooked = $totalOTo['QuoteconvertBOoked'];
		$totalotobooked = $totalOTo['totalotobooked'];
		$totalotoquote = $totalOTo['totalotoquote']; */
		
		
		 //print_r(WeeklyviewData(1));
		 
		?>
		  
        

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">


                <div class="col-md-5 col-sm-5 col-xs-12">
                 <div id="chartContainer1" style="height: 300px; width: 100%;"></div>
                </div>
				
                <div class="col-md-5 col-sm-5 col-xs-12 bg-white">
                    <div id="chartContainer2" style="height: 300px; width: 100%;"></div>

                </div>
			    <div class="clearfix"></div>	
				<br/>
				<br/>
				<br/>
				<center><h3>Product Review</h3></center>
				<br/>	
				
              <table class="table" border="1" style="font-size: 22px;text-align:center;width: 90%;margin-left: 80px;">
				  <thead class="thead-light">
					<tr>
					
					 
					  <th scope="col">Staff Name</th>
					<?php  
					
					  for($i=3; $i>0; $i--) { 
					
					   $mont = '-'.$i.'month';
					   $monthdate =  date("F Y",strtotime($mont)); 
					   
					   ?>
					   <th scope="col"><?php echo $monthdate; ?></th>
                    <?php } ?>
					 <th scope="col"><?php echo date("F Y"); ?></th>
					  <th scope="col">Percentages</th>
					  
					</tr>
				  </thead>
				  <tbody>
				  <?php  
				 
				 // print_r(getStaff());
				  
				   foreach(getStaff() as $staffid=>$staffname) {
					    
					   
					   ?>
					<tr>
					
					   
					  <td><?php echo $staffname['name']; ?></td>
					   <?php  
					     for($i=3; $i>0; $i--) { 
					
					   $mont = '-'.$i.'month';
					   $monthdate =  date("F Y",strtotime($mont)); 
					   $year = date('Y', strtotime($monthdate));
					   $month = date('m', strtotime($monthdate));
					  $gettota =  getReviewData($year , $month, $staffname['id']);
					  
					  $gettotal['count'][] = $gettota['count'];
					  $gettotal['experienceReview'][] = $gettota['experienceReview'];
					   
					   ?>
					  <td><?php if($gettota['count'] != 0) { echo  $gettota['count'];  }else {echo '-'; } //print_r($gettotal); //echo $monthdate; ?></td>
						 <?php  } ?>
					
					  <td>
					  <?php   $gettotal1 =  getReviewData(date('Y') , date('m'), $staffid);
					  if($gettotal1['count'] != 0) { echo  $gettotal1['count'];  }else {echo '-'; }
					  
					   $gettotal['count'][] = $gettotal1['count'];
					   $gettotal['experienceReview'][] = $gettotal1['experienceReview'];
					   
					  
					  
					  ?></td>
					  
					   <td>
					  <?php   
					 // print_r($gettotal);
					// echo 'Count=> ' .array_sum($gettotal['count']) . ' == experienceReview=> ' .array_sum($gettotal['experienceReview']);
					$total = array_sum($gettotal['experienceReview'])/array_sum($gettotal['count']);
					if($total > 0) {
					  echo number_format(array_sum($gettotal['experienceReview'])/array_sum($gettotal['count']) , 2).'%';
					}
					  unset($gettotal);
					  ?></td>
					  
					</tr>
				<?php  }  ?>	
				  </tbody>
				</table>
			
                <div class="clearfix"></div>
            </div>
            </div>
            </div>
			
			 <br/>
			 <br/>
			 
			 
		  
		 
      </div>
	  
	  
	 <style>
	.dashboard_graph .posRelNewGreen:before {
	top: 0;
	right: 10px;
	left: auto;
	}
	 </style> 