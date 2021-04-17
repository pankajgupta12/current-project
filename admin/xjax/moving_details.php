<ul class="create_quote_lst">
				
				    <li>
                    	<label>Moving From</label>
                       <input type="text" name="moving_from" id="moving_from" style="width: 70%;height: 74px;" value="<? echo get_field_value($details,"moving_from");?>">
						<input type="hidden" id="moving_from_lat_long">
                    </li>
					
					
					<li>
                    	<label>Moving To</label>
                       <input type="text" name="moving_to" id="moving_to" style="width: 70%;height: 74px;" value="<? echo get_field_value($details,"moving_to");?>">
							<input type="hidden" id="moving_to_lat_long">
                    </li>
					
					 
                    <li>
                    	<label>On Level From <em>*</em></label>
                        <span class="newSelectBox"><?php echo create_dd("is_flour_from","system_dd_br","id","name","type=1","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>On Level To<em>*</em></label>
                        <span class="newSelectBox"><?php echo create_dd("is_flour_to","system_dd_br","id","name","type=1","",$details) ;?></span>
                    </li>
                    
                    <li>
                    	<label>Has Lift/Elevator From</label>
                       <span class="newSelectBox"><?php echo create_dd("is_lift_from","system_dd_br","id","name","type=2","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Has Lift/Elevator To</label>
                       <span class="newSelectBox"><?php echo create_dd("is_lift_to","system_dd_br","id","name","type=2","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Home Type From<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("house_type_from","system_dd_br","id","name","type=3","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Home Type To<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("house_type_to","system_dd_br","id","name","type=3","",$details) ;?></span>
                    </li>
					
					
					<li>
                    	<label>Door Distance From<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("door_distance_from","system_dd_br","id","name","type=4","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Door Distance To<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("door_distance_to","system_dd_br","id","name","type=4","",$details) ;?></span>
                    </li>
					
                </ul>