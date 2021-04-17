<?php  
 	if(!isset($_SESSION['application_track']['from_date'])){ $_SESSION['application_track']['from_date'] = date("Y-m-1"); }
	if(!isset($_SESSION['application_track']['to_date'])){ $_SESSION['application_track']['to_date'] = date("Y-m-t"); }
	
//	print_r($_SESSION['application_track']);

 ?>
<style>
    .long_div .col-md-2 {
       width: 14.2%; 
    }
    .ui-datepicker th {
        padding: .7em .3em;
        text-align: center;
        font-weight: 700;
        font-size: 0px;
        border: 0;
    }
    
    .ui-datepicker td {
        border: 0;
        padding: 0px;
    }
</style>

        <div class="nav_form_main" id="searchreview" >
                   <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5" style="margin-top: -21px;">
                    
            		 <li>
                        <label>From Date</label>
                        <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['application_track']['from_date']; ?>" autocomplete="off">
                    </li>
                    <li>
                        
                        <label>To Date</label>
                        <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['application_track']['to_date']; ?>" autocomplete="off">
                    </li> 
            		 
                     <li>
            			<input type="button" style="margin-top:26px !important;cursor:pointer;" name="Search" value="Search" class="offsetZero btnSent a_search_box" onClick="javascript:trackApplicationsearch();">
            		</li>    		 
                    		
                     
                </ul>
				
       </div>

	<div class="content cnt_box long_div" id="re_page">
	   
	<div class="row">
    <div class="mrg_btm20 ">
     <?php  
	 
	 //print_r($jobicon); die;
	 
	 // $staffdetails1 =  getAllStaffname();
	 foreach($stagesdata as $stageskey=>$getsalesheding) 
	{  
		
		
		 ?>
        <div class="col-md-2 mrg_btm20 ">
	   
	    <?php  
	     
		    $applicationinfodata =   application_system_info($stageskey, $adminid , $_SESSION['application_track']['from_date'] , $_SESSION['application_track']['to_date']);
		     
             $count = count($applicationinfodata[$stageskey]); 	 
	    ?>
	   
		<h2><?php echo $getsalesheding;  if($count > 0) { ?> (<?php echo $count; ?>) <?php  } ?> </h2>
		<div class="scroll_c ui-droppable getdragg" id="container<?php echo $stageskey;?>">
		 
		<?php  
      //echo $arg;		
		//echo $fata;   
		 if($count > 0) {  
		   ?>
		   <?php  	 
			 $i = 1;
			 foreach($applicationinfodata[$stageskey] as $key=>$data) {
					
		?>	
		 
		
		   	<div   class="box panel panel-info box-item box_color_1 ui-draggable ui-draggable-handle  <?php //echo $boxcolor; ?> getresponse_data<?php echo $data['id']; ?>"  id ="<?php echo $data['id']; ?>" itemid="itm-<?php echo $i.'_'.$stageskey;?>" >
			   
			   
			    <div class="panel-heading td_back "  >
				  <div class="row"> 
				    <div class="col-md-12">
				
				   <h3><p class="glyphicon glyphicon-user geticone" title="<?php echo $data['first_name']; ?>">
				       <strong><?php echo $data['first_name'] .' '.$data['last_name']; ?></strong></p></h3>
				    <p class="glyphicon glyphicon-ok geticone">
					   ( A# <a href="javascript:scrollWindow('application_popup.php?task=appl&appl_id=<?php echo $data['id']; ?>','800','700')"><?php echo $data['id']; ?></a>)
				  </p>
				    <p class="glyphicon glyphicon-ok geticone" title="<?php echo $data['email']; ?>">A#<?php echo $data['email']; ?></p>

					
					 <p class="glyphicon glyphicon-earphone geticone"><a href="tel:<?php echo $data['phone']; ?>"><?php  if($data['phone'] != '') { echo $data['phone'];} else { $data['mobile']; } ?></a></p>
					 
			  	     <p class="glyphicon glyphicon-time geticone" title="<?php echo changeDateFormate($data['date_started'], 'datetime'); ?>"><?php echo changeDateFormate($data['date_started'], 'datetime'); ?></p>
			  	     
				   </p>
				  </div>
				
               
			    </div>
			    </div>
				
			</div>	  
			 <?php   }  $i++;   } else {?>	
			 
			<div class="box panel panel-info box_color">
			   <div class="panel-heading">
				  Not Found
			   </div>
			</div>  
	 <?php }  ?>
        </div>
	    <span id="updateed"></span>	 
		  </div>
		  <script>
		      $(document).ready(function() {

						 $("#container<?php echo $stageskey;?>").droppable({
							
							drop: function(event, ui) {
								var itemid = ui.draggable.attr("itemid");
								var id = ui.draggable.attr("id");
									
								console.log(id);
							  
							     checkFlag = true;
							     
							     var __THIS__ = $("div.getresponse_data" + id);
							     
							     // #### JUST ADD THIS BOX IN CONTAINER
							     //console.log($(this).attr('id'));
							     
							     if($("#container<?php echo $stageskey;?> div").hasClass('.box-item')) {
							         console.log('exists');
							     } else {
                                    $("#container<?php echo $stageskey;?>").append(__THIS__);
							     }
							     
							       send_data('<?php echo $stageskey;?>|'+id ,635, 'updateed');
							
							}
						}); 
				});
		    
		  </script> 
		 
		<?php 
		}  
		?>  
  
	<div id="myModal11">
		   
		   </div>   
	</div>
	</div>
	</div>
	
	 <!-- Modal -->
	                <span class="show_data">
						  <div class="modal fade" id="myModal" role="dialog">
						  
						      <div class="modal-content" id="getdata">
							    
							  </div>
						  </div>
						
					</span>	  
					 <span class="show_data_qus">
						  <div class="modal fade" id="myModal_data" role="dialog">
						  
						      <div class="modal-content" id="getdata_1">
							     
							  </div>
						  </div>
						
	
<span id="updateed"></span>

</div>
</div>
<style>

.box-item {
	z-index: 999;
}
.long_div .col-md-2 {
    z-index: 0;
}
</style>
<script>
  
    $(document).ready(function() {
		$('.box-item').draggable({
			cursor: 'move',
			helper: "clone"
		});
	});	
  
</script>

<script src="../adminsales_system/js/bootstrap.min.js"></script>