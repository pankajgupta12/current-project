<?php 

if($type != 0) {
	
	//echo "SELECT * FROM `removal_item_chart` WHERE item_type_id = ".$type."";
	
$sql  = mysql_query("SELECT * FROM `removal_item_chart` WHERE item_type_id = ".$type."");

if(mysql_num_rows($sql) >0) {
	
	//echo mysql_num_rows($sql);
$typename = get_rs_value("br_inventory_type","name",$type);		
$cleaning_html = '<ul class="bci_creat_first_quote">
						<li>
							<label>'.$typename.'</label>
							   <div class="input-group">     
									<select name="br_item_name"  id="br_item_name"  style="height: 200px;" multiple>';
										while($getdata = mysql_fetch_assoc($sql)) {
										     $cleaning_html .="<option value='".$getdata['id']."'>".$getdata['item_name']."</option>";
										}
									$cleaning_html .='</select>
								</div>
						</li>
						
						<li>
							<label>Qty</label>
								<div class="input-group">                              
								  <input type="text" id="qty" value="1" name="qty" onkeypress="return isNumberKey(event)" class="form-control input-number" >                             
								</div>
						</li>
						
						
                    </ul>';	
					
		echo '<div class="bb_add"><input type="button" class="frm_btn" value="Add" onclick="javascript:return add_br_quote_item('.$type.');"></div>
			';			
					
	     echo $cleaning_html;				
    }					
}			
	?>			