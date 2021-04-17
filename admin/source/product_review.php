<?php 
$_SESSION['page_type']['page_type'] = 1;
if(!isset($_SESSION['page_type']['cleaning_type'])){ $_SESSION['page_type']['cleaning_type'] = 1; }
if(!isset($_SESSION['dashboard_data']['from_date'])){ $_SESSION['dashboard_data']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['dashboard_data']['to_date'])){ $_SESSION['dashboard_data']['to_date'] = date("Y-m-t"); }
?>
    <!-- Bootstrap -->
    <link href="../admin/dashboard/bootstrap.min.css" rel="stylesheet">
	 <link href="../admin/dashboard/custom.min.css" rel="stylesheet">
      <div class="main_container">
       
        <!-- /top navigation -->

		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">
		        <div class="row x_title">
					  <div class="col-md-6">
						<h3>Product Review</small></h3>
					  </div>
				</div>
			    <div class="row x_title">	
                  <div class="col-md-8">
				  
				    <ul class="dispatch_top_ul dispatch_top_ul2">
					  <li>
						   <span>
							<?php echo create_dd("quote_for","quote_for_option","id","name","status = 1 AND id != 4","", $_SESSION['view_quote_aSearching'] ,'quote_a');	?>
							</span>
					  </li>	
						
					  <!--<li>	
						<div id="reportrange" class="pull-right"  style="background: #fff; cursor: pointer;">
						  <input class="date_class" type="text"  autocomplete="off" name="to_data" id="to_data" value="<?php echo $_SESSION['dashboard_data']['to_date']?>" >
						</div>
					 </li>-->	
					  <li>
						<div id="reportrange" class="pull-right"  style="background: #fff; cursor: pointer;">
						 <input type="button" style="cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="get_product_review();" >
						</div>
					 </li>	
				    </ul>	
				 
                  </div>
                </div>
			</div>	
			
		
		</div>	
		</div>
        <!-- page content -->
		
		<div id="getpage">
		<?php  
		 include('xjax/view_product_review.php');
		?>
		</div>
       
    </div>
        <?php  
		 include('product_review_js.php');
		?>
	




