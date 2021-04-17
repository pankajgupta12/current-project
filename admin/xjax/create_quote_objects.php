<?php 


if($type != 0) {
    if($type=="1"){ 
	    $cleaning_html = '<ul class="bci_creat_first_quote">
						<li>
							<label>Bed</label>
							<div class="br_plus">
								<div class="input-group">
								  <input type="text" id="bed" value="0" name="bed" class="form-control input-number" max="10">
								</div>
							</div>
						</li>						
						<li>
							<label>Bath</label>
							<div class="br_plus">
								<div class="input-group">
								  <input type="text" id="bath" value="0"  name="bath" class="form-control input-number" max="10">
								</div>
							</div>
						</li>
						<li>
							<label>Study</label>
							<div class="br_plus">
								<div class="input-group">
								  <input type="text" id="study" value="0" name="study" class="form-control input-number" max="10">
								</div>
							</div>
						</li>
						<li>
							<label>Toilet</label>
							<div class="br_plus">
								<div class="input-group">
								  <input type="text" id="toilet" value="0" name="toilet" class="form-control input-number" max="10">
								</div>
							</div>
						</li>
						<li>
							<label>Living Area</label>
							<div class="br_plus">
								<div class="input-group">                              
								  <input type="text" id="living" value="0" name="living" class="form-control input-number"  max="10">                             
								</div>
							</div>
						</li>
						<li>
                    	<label>Furnished</label>';
				   $cleaning_html.= create_dd("furnished","system_dd","name","name","type=18","",$details); 

                   $cleaning_html.='</li><li><label>House Type</label>';
				   $cleaning_html.= create_dd("property_type","dd_property_type","name","name","","",$details);
                        
                   $cleaning_html.='</li><li><label>Blinds</label>';
					
                   $cleaning_html.= create_dd("blinds","dd_blinds","name","name","","onChange=\"get_blinds_type(this.value);\"",$details);
                   $cleaning_html.= '</li>';
                   $cleaning_html.= '<li id="blinds_number_value" style="display:none;"><label>Blinds value</label> <input type="text" id="blinds_numbers" value="" placeholder=""  name="blinds_numbers" class="form-control input-number"  max="10"></li>';
                   $cleaning_html.= '</ul>';
				   
				   $cleaning_html.='<div class="bb_add"><input type="button" class="frm_btn" value="Add" onclick="javascript:add_quote_item('.$type.');"></div>';
				echo $cleaning_html;				
}elseif($type=="11"){ 
	$cleaning_html = '<ul class="bci_creat_first_quote bci_creat_first_quote_new">
						<li>
							<label>Bed</label>
							<div class="br_plus">
								<div class="input-group">
								  <input type="text" id="bed" value="0" name="bed" class="form-control input-number" max="10">
								</div>
							</div>
						</li>		
                        
						<li>
							<label>Study</label>
							<div class="br_plus">
								<div class="input-group">                              
								  <input type="text" id="study" value="0" name="study" class="form-control input-number"  max="10">                             
								</div>
							</div>
						</li> 
                        						
						<li>
							<label>Living Area</label>
							<div class="br_plus">
								<div class="input-group">
								  <input type="text" id="lounge_hall" value="0"  name="lounge_hall" class="form-control input-number" max="10">
								</div>
							</div>
						</li>
						<li>
							<label>Kitchen</label>
							<div class="br_plus">
								<div class="input-group">
								  <input type="text" id="kitchen" value="0" name="kitchen" class="form-control input-number" max="10">
								</div>
							</div>
						</li>
						<li>
							<label>Dining</label>
							<div class="br_plus">
								<div class="input-group">
								  <input type="text" id="dining_room" value="0" name="dining_room" class="form-control input-number" max="10">
								</div>
							</div>
						</li>';
						
				//ob_start(); // start buffer
				//include ('moving_details.php');
				//$cleaning_html .= ob_get_contents(); // assign buffer contents to variable
				//ob_end_clean(); // end buffer and remove buffer contents							
					
                   $cleaning_html.= '</ul>';
				   //$cleaning_html.='<div class="bb_add"><input type="button" class="frm_btn" value="Add" onclick="javascript:return add_quote_item('.$type.');"></div>';
				echo $cleaning_html;				
}else if ($type=="2"){
	echo '<ul class="bci_creat_first_quote" style="margin:25px 0 0">
                	<li>
                    	<label>Bedroom</label>
                       <input type="text" id="bed" name="bed" class="form-control input-number" max="10" value="'.$_SESSION['temp_quote']['cleaning']['bed'].'">                          
					</li>
                    <li>
                    	<label>Living Area & Dinning</label>
                         <input type="text" id="living" name="living" class="form-control input-number" max="10" value="'.$_SESSION['temp_quote']['cleaning']['living'].'">
                    </li>
                    <li>
                    	<label>Stairs</label>
                         <input type="text" id="carpet_stairs" name="carpet_stairs" class="form-control input-number" value="0">
                    </li>   
                    
                    <li>
                    	<label>Stains</label>
                        <span>'.create_dd("stains","system_dd","id","name","type = 29","",'').'</span> 
                    </li> 
                    
                    <li>
                    	<label>Floor</label>
                       <span>'.create_dd("quote_floor","system_dd","id","name","type = 156","onChange=\"javascript:floorcheck(this.value);\"",'').'</span> 
                    </li>   
                    
                    
                    
                    <li style="display:none;" class="showinfo">
                    	<label>lift at property </label>
                         <span>'.create_dd("lift_property","system_dd","id","name","type = 29","",'').'</span> 
                    </li>   
                     
                    
                      
                    
                    
                    
                    
                </ul>
				<div class="bb_add"><input type="button" class="frm_btn" value="Add" onclick="javascript:add_quote_item('.$type.');"></div>
				';
				
				
				
				
				
}else if ($type=="3"){
		echo '<ul class="bci_creat_first_quote" style="margin:25px 0 0">                	
				<li>
					<label>Inside</label>					
					<input type="checkbox" name="pest_inside" id="pest_inside" value="1">
				</li>
				<li>
					<label>Outside</label>
					<input type="checkbox" name="pest_outside" id="pest_outside" value="1">
				</li>
				<li>
					<label>Flea and Tick</label>
				   <input type="checkbox" name="pest_flee" id="pest_flee" value="1">
				</li>
			</ul>
			<div class="bb_add"><input type="button" class="frm_btn" value="Add" onclick="javascript:add_quote_item('.$type.');"></div>
			';
			
}else{
	echo '<ul class="bci_creat_first_quote" style="margin:25px 0 0">                	
				<li style="width:20%!important">
					<label style="width:100%!important">'.ucwords(get_rs_value("job_type","name",$type)).'</label>					
				</li>
				<li style="width:45%!important">
					<label style="width:15%!important">Desc</label>
					<input type="text" id="desc" name="desc" class="form-control input-number" style="width:70%!important; text-align:left!important;">					
				</li>
				<li style="width:25%!important">
					<label style="width:20%!important">Amount</label>
				   <input type="text" id="amount" name="amount" class="form-control input-number">
				</li>
			</ul>
			<div class="bb_add"><input type="button" class="frm_btn" value="Add" onclick="javascript:add_quote_item('.$type.');"></div>
			';
}

}else{
	
	echo 'Please Select Job type';
}
?>