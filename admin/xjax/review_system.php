<?php  
 	if(!isset($_SESSION['review_data_track']['from_date'])){ $_SESSION['review_data_track']['from_date'] = date("Y-m-1"); }
	if(!isset($_SESSION['review_data_track']['to_date'])){ $_SESSION['review_data_track']['to_date'] = date("Y-m-t"); }

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
    
    .edit_review_button_show_1 {
    position: absolute;
    /* right: 0px!important; */
    bottom: 45px;
    top: inherit!important;
    width: auto!important;
    height: auto!important;
    border-radius: 4px!important;
    padding: 15px 15px!important;
    background-color: #00b8d4!important;
    color: #fff!important;
    text-transform: uppercase;
    font-weight: 600;
}

.box-item {
	z-index: 999;
}
.long_div .col-md-2 {
    z-index: 0;
}
    
</style>

         <div class="nav_form_main" id="searchreview" >
                   <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5" style="margin-top: -21px;">
                    
            		 <li>
                        <label>From Date</label>
                        <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['review_data_track']['from_date']; ?>" autocomplete="off">
                    </li>
                    <li>
                        
                        <label>To Date</label>
                        <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['review_data_track']['to_date']; ?>" autocomplete="off">
                    </li> 
            		 
                     <li>
            			<input type="button" style="margin-top:26px !important;cursor:pointer;" name="Search" value="Search" class="offsetZero btnSent a_search_box" onClick="javascript:trackReivewsearch();">
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
	     
		    $reviewinfodata =   review_system_info($stageskey, $adminid , $_SESSION['review_data_track']['from_date'] , $_SESSION['review_data_track']['to_date']);
		     
             $count = count($reviewinfodata[$stageskey]); 	 
	    ?>
	   
		<h2><?php echo $getsalesheding;  if($count > 0) { ?> (<?php echo $count; ?>) <?php  } ?> </h2>
		<div class="scroll_c ui-droppable" id="container<?php echo $stageskey;?>">
		 
		<?php  
		
		 if($count > 0) {  
			 $i = 1;
			foreach($reviewinfodata[$stageskey] as $key=>$data) {
		?>	
		 
		 
		
		   	<div   class="box panel panel-info box-item box_color_1 <?php //echo $boxcolor; ?> getresponse_data<?php echo $data['id']; ?>"  id="<?php echo $data['id']; ?>" itemid="itm-<?php echo $i.'_'.$stageskey;?>" >
			   
					 
			    <div class="panel-heading td_back "  >
				  <div class="row"> 
				    <div class="col-md-12">
				
				   <h3><p class="glyphicon glyphicon-user geticone" title="<?php echo $data['email']; ?>"><strong><?php echo $data['name']; ?></strong></p></h3>
				   
				   <p class="glyphicon glyphicon-ok geticone" title="<?php echo $data['id']; ?>">R#<a href="javascript:scrollWindow('client_review_popup.php?task=review&type=1&job_id=<?php echo $data['job_id']; ?>','1200','850')"><?php echo $data['id']; ?></a></p>
				   <p class="glyphicon glyphicon-ok geticone">
					
					   ( J# <a href="javascript:scrollWindow('popup.php?task=job_reclean&job_id=<?php echo $data['job_id']; ?>','1250','800')"><?php echo $data['job_id']; ?></a>)
				  
				  </p>

					
					 <p class="glyphicon glyphicon-earphone geticone"><a href="tel:<?php echo $data['phone']; ?>"><?php echo $data['phone']; ?></a></p>
					 
			  	     <p class="glyphicon glyphicon-time geticone" title="<?php echo changeDateFormate($data['review_date'], 'datetime'); ?>"><?php echo changeDateFormate($data['review_date'], 'datetime'); ?></p>
			  	     <ul class="review_ratting">
                           <li title="01st Dec 2020">
                            <?php  for($k= 1; $k<=5; $k++) { ?>   
                            <p class="glyphicon glyphicon-star <?php  if($k <= $data['overall_experience'] ) { ?> checked1 <?php  } ?>"></p>
                            <?php  } ?>				 
					       </li>
					  </ul>
				
		            	<span class="edit_review_button_show_1" onClick="getreviewsidepanel('<?php  echo $data['id']; ?>');">Info</span>
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
							     
							       send_data('<?php echo $stageskey;?>|'+id ,638, 'updateed');
							
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
<script>
   function saveCompliteInfo(lastid){
	   // who_fault refund_given gift_voucher insurance_case payning_invoice other
	   
	   var who_fault =   $('#who_fault').val();
	   var refund_given =   $('#refund_given').val();
	   var gift_voucher =   $('#gift_voucher').val();
	   var insurance_case =   $('#insurance_case').val();
	   var payning_invoice =   $('#payning_invoice').val();
	   var other =   $('#other').val();
	   
	   var str = who_fault +'__'+refund_given +'__'+gift_voucher +'__'+insurance_case +'__'+payning_invoice +'__'+other+'__'+lastid;
	   
	    // alert(str);
	   send_data(str , 609, 'getdata');
   }
   
   function getreviewsidepanel(qid){
       
      // console.log('test');
        $('.modal').html();
         send_data(qid,'636','myModal11');
        $('#myModal11').addClass('get_slide_data');
        $('.black_screen1').fadeIn(700);
        
                /*$('.modal').html();		
                send_data(qid,'53','myModal11');
                $('#myModal11').addClass('get_slide_data');
                $('.black_screen1').fadeIn(700);*/
   }
   
    $(document).ready(function(e){
		 
		    $('.black_screen1').click(function(e){
			   $('#myModal11').removeClass('get_slide_data');
			   $('.black_screen1').fadeOut(700);
		    });
    });
   
  
</script>


<script>
  
    $(document).ready(function() {
		$('.box-item').draggable({
			cursor: 'move',
			helper: "clone"
		});
	});	
  
</script>

<script src="../adminsales_system/js/bootstrap.min.js"></script>