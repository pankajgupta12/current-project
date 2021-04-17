<?php 
$quotenewdetails = mysql_fetch_object(mysql_query("select * from quote_new where ssecret ='".mysql_real_escape_string($_GET['secret'])."'"));
$qdetails = mysql_fetch_object(mysql_query("select * from quote_details where quote_id=".$quotenewdetails->id.""));

?>
<script>

		
	$(function() {
		
		var textfirst1 = $('#bedroom').find("option:first-child").text();
		var textfirst2 = $('#bathroom').find("option:first-child").text();
		var textfirst3 = $('#living_area').find("option:first-child").text();
		var textfirst4 = $('#furnished').find("option:first-child").text();
		var textfirst5 = $('#house_type').find("option:first-child").text();
		var textfirst6 = $('#blinds').find("option:first-child").text();
		var textfirst7= $('#number_of_houres').find("option:first-child").text();	
		var str = textfirst1 +','+ textfirst2 + ','+ textfirst3 +','+ textfirst4 + ','+ textfirst5 +','+ textfirst6 + ','+ textfirst7;
		$('#allselect').val(str);
		
	  $( ".job_date" ).datepicker({ minDate: 0,dateFormat:'yy-mm-dd'});
	  
	        $(window).resize(function(){
			  var width =  $( window ).width();
			        if(width <= 480) {
				  // alert(width+'if');
					var textfirst1 = $('#bedroom').find("option:first-child").text();
					var textfirst2 = $('#bathroom').find("option:first-child").text();
					var textfirst3 = $('#living_area').find("option:first-child").text();
					var textfirst4 = $('#furnished').find("option:first-child").text();
					var textfirst5 = $('#house_type').find("option:first-child").text();
					var textfirst6 = $('#blinds').find("option:first-child").text();
					var textfirst7= $('#number_of_houres').find("option:first-child").text();	
         
                  /*   var str = textfirst1 +','+ textfirst2 + ', '+ textfirst3 +','+ textfirst4 + ', '+ textfirst5 +','+ textfirst6 + ', '+ textfirst7; $('#allselect').val(str); */
					
					var res1 = textfirst1.replace("Select", "");
					var res2 = textfirst2.replace("Select", "");
					var res3 = textfirst3.replace("Select", "");
					var res4 = textfirst4.replace("Select", "");
					var res5 = textfirst5.replace("Select", "");
					var res6 = textfirst6.replace("Select", "");
					var res7 = textfirst7.replace("Select", "");
					
					$('#bedroom').find("option:first-child").text(res1);  
					$('#bathroom').find("option:first-child").text(res2);  
					$('#living_area').find("option:first-child").text(res3);  
					$('#furnished').find("option:first-child").text(res4);  
					$('#house_type').find("option:first-child").text(res5);  
					$('#blinds').find("option:first-child").text(res6);  
					$('#number_of_houres').find("option:first-child").text(res7);  
			    }else if(width >= 480){
					var getall = $('#allselect').val();
					var getselectval = getall.split(',');
					$('#bedroom').find("option:first-child").text(getselectval[0]);
					$('#bathroom').find("option:first-child").text(getselectval[1]);  
					$('#living_area').find("option:first-child").text(getselectval[2]);  
					$('#furnished').find("option:first-child").text(getselectval[3]);  
					$('#house_type').find("option:first-child").text(getselectval[4]);  
					$('#blinds').find("option:first-child").text(getselectval[5]);  
					$('#number_of_houres').find("option:first-child").text(getselectval[6]);  
				}
			});
			
			var width =  $( window ).width();
			        if(width <= 480) {
				  // alert(width+'if');
					var textfirst1 = $('#bedroom').find("option:first-child").text();
					var textfirst2 = $('#bathroom').find("option:first-child").text();
					var textfirst3 = $('#living_area').find("option:first-child").text();
					var textfirst4 = $('#furnished').find("option:first-child").text();
					var textfirst5 = $('#house_type').find("option:first-child").text();
					var textfirst6 = $('#blinds').find("option:first-child").text();
					var textfirst7= $('#number_of_houres').find("option:first-child").text();	
         
                  /*   var str = textfirst1 +','+ textfirst2 + ', '+ textfirst3 +','+ textfirst4 + ', '+ textfirst5 +','+ textfirst6 + ', '+ textfirst7; $('#allselect').val(str); */
					
					var res1 = textfirst1.replace("Select", "");
					var res2 = textfirst2.replace("Select", "");
					var res3 = textfirst3.replace("Select", "");
					var res4 = textfirst4.replace("Select", "");
					var res5 = textfirst5.replace("Select", "");
					var res6 = textfirst6.replace("Select", "");
					var res7 = textfirst7.replace("Select", "");
					
					$('#bedroom').find("option:first-child").text(res1);  
					$('#bathroom').find("option:first-child").text(res2);  
					$('#living_area').find("option:first-child").text(res3);  
					$('#furnished').find("option:first-child").text(res4);  
					$('#house_type').find("option:first-child").text(res5);  
					$('#blinds').find("option:first-child").text(res6);  
					$('#number_of_houres').find("option:first-child").text(res7);  
			    }else if(width >= 480){
					var getall = $('#allselect').val();
					var getselectval = getall.split(',');
					$('#bedroom').find("option:first-child").text(getselectval[0]);
					$('#bathroom').find("option:first-child").text(getselectval[1]);  
					$('#living_area').find("option:first-child").text(getselectval[2]);  
					$('#furnished').find("option:first-child").text(getselectval[3]);  
					$('#house_type').find("option:first-child").text(getselectval[4]);  
					$('#blinds').find("option:first-child").text(getselectval[5]);  
					$('#number_of_houres').find("option:first-child").text(getselectval[6]);  
				}
	 });
	
	
	$(document).ready(function(){
		$("#suburb").keyup(function(){
		var str = $('#suburb').val();
		//alert(str);
		var page = 'quote_create';
		if(str == ''){
			$("#suggesstion-box").hide();
		   return false;
		}
			if(str.length>=4){
					$.ajax({
					type: "POST",
					url: "../quote/ajax/getpost_code.php",
					//data:'keyword='+$(this).val(),
					data: 'keyword='+ str + '&page='+ page,
					beforeSend: function(){
						
						$("#suburb").css("background","#FFF url('<?php echo '../quote/images/LoaderIcon.gif'; ?>') no-repeat 175px");
					},
					success: function(data){
						if(data) {
							$("#suggesstion-box").show();
							$("#suggesstion-box").html(data);
							$("#suburb").css("background","#FFF");
						}
					}
					});
				return  true;
			}
		});
		
	});
	
	////suburb_spring  suggesstion-box_suburb_spring
	$(document).ready(function(){
		$("#suburb_spring").keyup(function(){
		var str = $('#suburb_spring').val();
		var page = 'quote_spring';
		//alert(str);
		if(str == ''){
			$("#suggesstion-box_suburb_spring").hide();
		   return false;
		}
			if(str.length>=4){
					$.ajax({
					type: "POST",
					url: "../quote/ajax/getpost_code.php",
					//data:'keyword='+$(this).val(),
					data: 'keyword='+ str + '&page='+ page,
					beforeSend: function(){
						
						$("#suburb_spring").css("background","#FFF url('<?php echo '../quote/images/LoaderIcon.gif'; ?>') no-repeat 175px");
					},
					success: function(data){
						if(data) {
							//alert(data);
							$("#suggesstion-box_suburb_spring").show();
							$("#suggesstion-box_suburb_spring").html(data);
							$("#suburb_spring").css("background","#FFF");
						}
					}
					});
				return  true;
			}
		});
		
	});

	function selectpostcodequote(val) {
		$("#suburb").val(val);
		$("#suggesstion-box").hide();
	}
	function selectpostcodespring(val) {
		$("#suburb_spring").val(val);
		$("#suggesstion-box_suburb_spring").hide();
	}
	
	    function jobType(id){
	        
				if(id == '1'){
					 $('#create_quote_div').show();
					 $('#create_spring_div').hide();
				 }else if(id == '2'){
					 $('#create_spring_div').show();
					 $('#create_quote_div').hide();
				 }
		}
		
		
		
		 var data = {};
		$(document).ready(function() {
		  $('input[id="quotecreate"]').on('click', function() {
		//$('.btn pull-lefts').click(function(){
		//$('button[type="submit"]').addClass('disabled');
		resetErrors();
		var url = '../quote/ajax/quote_create.php';
          
		var formData=$('#create_quote').serialize();
		//alert(formData);
		$.ajax({
		dataType: 'json',
		type: 'POST',
		url: url,
		data: formData,
		success: function(resp) {
		  if(resp.done==='success'){
			 location.reload();
		  } else {
			//  alert(resp);
			  $.each(resp, function(i, v) {
			  console.log(i + " => " + v); // view in console for error messages
				  var msg = '<p class="error" style="color:red" for="'+i+'">'+v+'</p>';
			//	  alert(msg);textarea css('border','solid 1px #ff0000');
				 // $('input[id="' + i + '"],textarea[id="' + i + '"], select[name="' + i + '"],select[id="' + i + '"]').addClass('inputTxtError').after(msg);
				   $('input[id="' + i + '"],textarea[id="' + i + '"], select[name="' + i + '"],select[id="' + i + '"]').addClass('inputTxtError').css('border','solid 1px #ff0000');
			  });
			  var keys = Object.keys(resp);
			  $('input[name="'+keys[0]+'"]').focus();
		  }
		  return false;
		},
		error: function() {
		  console.log('there was a problem checking the fields');
		}
		});
		  return false;
		});
		}); 
		
		
	 var data = {};
		$(document).ready(function() {
		  $('input[id="createspring"]').on('click', function() {
		//$('.btn pull-lefts').click(function(){
		//$('button[type="submit"]').addClass('disabled');
		resetErrors();
		var url = '../quote/ajax/create_quotespring.php';
           
		var formData=$('#create_spring').serialize();
		//alert(formData);
		$.ajax({
		dataType: 'json',
		type: 'POST',
		url: url,
		data: formData,
		success: function(resp) {
		  if(resp.done==='success'){
			 location.reload();
		  } else {
			//  alert(resp);
			  $.each(resp, function(i, v) {
			  console.log(i + " => " + v); // view in console for error messages
				  var msg = '<p class="error" style="color:red" for="'+i+'">'+v+'</p>';
			//	  alert(msg);
				  $('input[id="' + i + '"], select[name="' + i + '"],select[id="' + i + '"]').addClass('inputTxtError').css('border','solid 1px #ff0000');
			  });
			  var keys = Object.keys(resp);
			  $('input[name="'+keys[0]+'"]').focus();
		  }
		  return false;
		},
		error: function() {
		  console.log('there was a problem checking the fields');
		}
		});
		  return false;
		});
		}); 	
		
		function resetErrors() {
			$('form input, form select').removeClass('inputTxtError');
			$('form input, form select').css('border','');
			$('p.error').remove();
		} 
		
		
</script>

<style>
  .mandatory{color:red;font-size:17px;}
</style>

<section class="main-cont">
    	<div class="container">
            <div class="complete-quote">
            	<div class="heading">
                	<h1>Complete your Quote</h1>
                    <span><img src="images/title-icon.png" alt=""></span>
                </div>
				
			</div> 	
					<ul class="nav nav-tabs top_inputs">
						    <li class="active">
						     <!--<input type="radio" id="job_type"  onClick="jobType(1);" name="job_type" value="Bond Cleaning" checked> --> 
                            <div class="radio">
                                <label style="font-size: 1.2em">
                                    <input type="radio" id="job_type"  onClick="jobType(1);" name="job_type" value="Bond Cleaning" checked>
                                    <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                   Bond Cleaning
                                </label>
                            </div>
                            
							</li>
						    <li>
							
                             <div class="radio">
                                <label style="font-size: 1.2em">
                                    <input type="radio" id="job_type" onClick="jobType(2);" name="job_type" value="Spring Cleaning">
                                    <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                   Spring Cleaning
                                </label>
                            </div>
							</li>
					</ul>  
				  
				<input type="hidden" id="allselect">
        <div id="create_quote_div" class="complete-quote">    
		    <form name="create_quote" id="create_quote" method="post">
			 <input type="hidden" name="step" value="1">
			 <input type="hidden" name="quote_type" value="create_quote">
			 <input type="hidden" name="secret" value="<?php echo base64_encode($_GET['secret']); ?>">
                <div class="row">
                	<div class="col-md-12 col-sm-12">
						<div class="row">
						<div class="col-md-6 date_cade">
							<p class="top_form">
							  <label class="col-md-3">Post Code <span class="mandatory">*</span></label>
							  
                              <div class="suggesstion-box-spring col-md-9">
									<input type="text" class="form-field" id="suburb" name="suburb" value="<?php if($quotenewdetails->suburb != "") { echo $quotenewdetails->suburb; } ?>"  placeholder="Post code" />
									<div id="suggesstion-box"></div>
                                </div>
							  <!--<span class="form_slect_1 "></span>   -->                                               
							</p>
							</div>
							
							<div class="col-md-6 date_cade">
								<p class="top_form">
									<label class="col-md-3">Job Date  <span class="mandatory">*</span></label>
									 <span class="form_slect_1 col-md-9"> <input name="booking_date" type="text" class="job_date form-field"  id="booking_date" value="<?php if($quotenewdetails->booking_date != '0000-00-00') {  echo $quotenewdetails->booking_date; }else{ echo date('Y-m-d'); } ?>"><!--<span class="glyphicon glyphicon-calendar" ></span>--></span>
								</p>
							</div>
						
                        </div>
                     </div>
           		</div>
            
            
				<div class="job-details">
					<div class="heading">
						<h1>select job details </h1>
						<span><img src="images/title-icon.png" alt=""></span>
					</div>
				</div>   
				
            <div class="form-tabbing">
				
				<div class="tab-content" >    
					
						<div class="row">
						<div class="col-md-8 col-sm-8">
						
							<div class="row payment_row">	
							<div class="col-md-12 bedroom_select">
							
								<div class="col-md-6">
									<div class="row">
										<p class="quote_error_bd">
										<label class="col-md-4">Bedroom  <span class="mandatory">*</span> </label>
										<span class="form_slect_1 plain-select col-md-8">
												<select class="inp" id="bedroom" name="bedroom">
													<option value="">Select Bedroom</option>
													<?php for($i=1;$i<=10;$i++){ ?>
													<option value="<?php echo $i; ?>"<?php if($i == $qdetails->bed) {echo "selected"; } ?>><?php echo $i; ?></option>
													<?php  } ?>
												</select>
										</span>
										</p>
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="row">
										<p class="quote_error_bd">
											<label class="col-md-4">Bathroom  <span class="mandatory">*</span> </label>
											<span class="form_slect_1 plain-select col-md-8">
												<select class="inp" id="bathroom"  name="bathroom">
													<option value="">Select Bathroom</option>
													<?php for($j=1;$j<=5;$j++){ ?>
													<option value="<?php echo $j; ?>"<?php if($j == $qdetails->bath) {echo "selected"; } ?>><?php echo $j; ?></option>
													<?php  } ?>
												</select>
											</span>
										</p>
									</div>
								</div>
							</div>
							</div>
							
							<div class="row payment_row bedroom_select">	
								<div class="col-md-12">
								
									<div class="col-md-6">
										<div class="row">
											<p class="quote_error_bd">
											<label class="col-md-4">Living Area  <span class="mandatory">*</span> </label>
												<span class="form_slect_1 plain-select col-md-8">
													<select class="inp" id="living_area" name="living_area">
														<option value="">Select Living Area</option>
														<?php for($k=1;$k<=5;$k++){ ?>
														<option value="<?php echo $k; ?>"<?php if($k == $qdetails->living) {echo "selected"; } ?>><?php echo $k; ?></option>
														<?php  } ?>
													</select>
												</span>
											
											</p>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="row">
											<p class="quote_error_bd">
											  <label class="col-md-4">Furnished  <span class="mandatory">*</span>  </label>
											  <span class="form_slect_1 plain-select col-md-8">
												<select class="inp"  id="furnished" name="furnished">
														<option value="">Select Furnished </option>
														<option value="Yes"<?php if(ucfirst($qdetails->furnished) == 'Yes') {echo "selected"; } ?>>Yes</option>
														<option value="No"<?php if(ucfirst($qdetails->furnished) == 'No') {echo "selected"; } ?>>No</option>
												</select>
											  </span>                                                  
											</p>
										</div>
									</div>
									
									
								</div>
							</div>
							
							<div class="row payment_row bedroom_select">	
								<div class="col-md-12">
									<div class="col-md-6">
										<div class="row">
										<p class="quote_error_bd">
										  <label class="col-md-4">House Type<span class="mandatory">*</span> </label>
										  <span class="form_slect_1 plain-select col-md-8">
											<select class="inp" id="house_type" name="house_type">
													<option value="">Select House Type   </option>
													<option value="Unit"<?php if($qdetails->property_type == 'Unit') {echo "selected"; } ?>>Unit</option>
													<option value="House"<?php if($qdetails->property_type == 'House') {echo "selected"; } ?>>House</option>
													<option value="Two story"<?php if($qdetails->property_type == 'Two story') {echo "selected"; } ?>>Two story</option>
													<option value="Multi story"<?php if($qdetails->property_type == 'Multi story') {echo "selected"; } ?>>Multi story</option>
											</select>
										  </span>                                                  
										</p>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="row">
											<p class="quote_error_b1d">
											  <label class="col-md-4">Blinds  <span class="mandatory">*</span>  </label>
											  <span class="form_slect_1 plain-select col-md-8">
												<select class="inp" id="blinds" name="blinds">
														<option value="">Select Blinds  </option>
														<option value="No Blinds"<?php if($qdetails->blinds_type == 'No Blinds') {echo "selected"; } ?>>No Blinds</option>
														<option value="Vertical"<?php if($qdetails->blinds_type == 'Vertical') {echo "selected"; } ?>>Vertical</option>
														<option value="Venetians"<?php if($qdetails->blinds_type == 'Venetians') {echo "selected"; } ?>>Venetians</option>
														<option value="Rollers"<?php if($qdetails->blinds_type == 'Rollers') {echo "selected"; } ?>>Rollers</option>
														<option value="Shutters"<?php if($qdetails->blinds_type == 'Shutters') {echo "selected"; } ?>>Shutters</option>
												</select>
											  </span>                                                  
											</p>
										</div>
									</div>
									
								</div>
							</div>
							
							
							<div class="form-checkbox row payment_row">
								<div class="col-md-12">
									<div class="choose-label col-md-2"><label>Choose Option </label></div>
									<div class="col-md-10">
                                    	<ul class="chosse_check">
                                    	<li><div class="checkbox">
                                            <label style="font-size: 1.2em">
                                                <input type="checkbox" name="job_type[]" value="2">
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                Carpet
                                            </label>
                                        	</div>
                                          </li>
                                    
                                    
                                    	<li>
                                        <div class="checkbox">
                                            <label style="font-size: 1.2em">
                                                <input type="checkbox" name="job_type[]" value="3">
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                Pest
                                            </label>
                                        </div>
                                        </li>
                                    </ul>
                                    
                                    
                                    
									<!--<p><input type="checkbox" name="job_type[]" value="2" ><label>Carpet</label></p>
									<p><input type="checkbox" name="job_type[]" value="3"><label>Pest</label></p>-->
									</div>
								</div>
							</div>
							
							
						   <div class="row payment_row">	
								<div class="col-md-12">
								   <p style="clear:both;" class="quote_error_b2d"><label class="col-md-2">Address <span class="mandatory">*</span></label>
								   <span class="form_slect_1 col-md-10 ">
									 <textarea row="3" class="textform-field" type="text" name="address" id="address" placeholder="Address"></textarea></span>
								   </p>
								</div>
							</div>
						   
							<!--<div class="submit-btn"><a href="#">Submit</a></div>-->
							<div class="submit-btn">
								<input type="Submit" id="quotecreate" value="Submit">
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<!--<img src="images/quote-img.png" alt="" class="quote-img">-->
							<img src="images/quote-img1.png" alt="" class="quote-img">
						</div>  
					</div>
					</form>	
				</div>
			</div>
		</div>
		
        
        
        
    <div class="row">    
      <div class="col-md-12">  		
		<div class="tab-content complete-quote" id="create_spring_div" style="display:none;">
			<form name="create_spring" id="create_spring" method="post" class="col-md-8 col-sm-8">
			  <input type="hidden" name="step" value="2">
			   <input type="hidden" name="quote_type" value="create_spring">
			    <input type="hidden" name="secret" value="<?php echo base64_encode($_GET['secret']); ?>">
		          <div class="row">
                	<div class="col-md-12 col-sm-12">
					  <div class="row">
						<div class="col-md-6">
                        <p class="top_form top_form_new">
                           <label class="col-md-4 date_cade_new">Post Code  <span class="mandatory">*</span> </label>
                           <div class="col-md-8 suggesstion-box-spring">
						    <input type="text" class="form-field" id="suburb_spring" value="<?php if($quotenewdetails->suburb != "") { echo $quotenewdetails->suburb; } ?>" name="suburb_spring" placeholder="Post code" />
								<div id="suggesstion-box_suburb_spring"></div>
                          <!-- <span class="col-md-8 suggesstion-box-spring"> </span> -->
                            </div>                                                 
                        </p>
						</div>
						<div class="col-md-6">
							<p class="top_form">
							     <label class="col-md-4 date_cade_new">Job Date  <span class="mandatory">*</span> </label>
							     <span class="col-md-8 booking_date_new"> <input name="booking_date_spring" class="job_date form-field" type="text"  id="booking_date_spring" value="<?php if($quotenewdetails->booking_date != '0000-00-00') {  echo $quotenewdetails->booking_date; }else{ echo date('Y-m-d'); }  ?>"><!--<span class="glyphicon glyphicon-calendar"></span>--></span>
						    </p>
                        </div>
                       </div>
					   </div>
                     </div>
                    <!--<div class="col-md-6 col-sm-6">
					<div class="row">
						<div class="col-md-12">
						
						</div></div>
						
                    </div>-->            		
        
            
            
            <div class="job-details">
                <div class="heading">
                	<h1>select job details </h1>
                    <span><img src="images/title-icon.png" alt=""></span>
                </div>
            </div>   
				
				
						  <div class="row">
						<div class="col-md-12">                  	
						    <div class="row payment_row">
                            	<div class="col-md-3"></div>	
								<div class="col-md-6">
									<p class="num_hrs">
									  <label class="col-md-4">No. of hours  <span class="mandatory">*</span> </label>
									  <span class="form_slect_1 plain-select col-md-8">
										<select class="inp"  name="number_of_houres" id="number_of_houres">
												<option value="">Select number of hours</option>
												<?php for($x = 3; $x <= 20; $x++) { ?>
												 <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
												<?php } ?>
										</select>
									  </span>                                                  
									</p>
								</div>
                                
                                <div class="col-md-3"></div>	
                                
                                
                                
							</div>
							
							<div class="submit-btn">
								<input type="Submit" id="createspring" class="" value="Submit">
							</div>
							
						</div>
						           		
						</div>
			</form>	
            
		
        
        <div class="col-md-4 col-sm-4">
			<!--<img src="images/quote-img.png" alt="" class="quote-img">-->
			<img src="images/quote-img1.png" alt="" class="quote-img">
		</div> 
        
        </div>
        
        
        </div>
	 </div>
        
        
        
		</div>
		</div>
</section>		