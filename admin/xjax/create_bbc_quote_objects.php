<?php 


 if ($type=="2"){
	echo '<ul class="bci_creat_first_quote" style="margin:25px 0 0">
                	<li>
                    	<label>Bedroom</label>
                       <input type="text" id="bed" name="bed" class="form-control input-number" max="10" value="'.$_SESSION['temp_quote']['cleaning']['bed'].'">                          
					</li>
                    <li>
                    	<label>Living</label>
                         <input type="text" id="living" name="living" class="form-control input-number" max="10" value="'.$_SESSION['temp_quote']['cleaning']['living'].'">
                    </li>
                    <li>
                    	<label>Stairs</label>
                         <input type="text" id="carpet_stairs" name="carpet_stairs" class="form-control input-number" value="0">
                    </li>                    
                </ul>
				<div class="bb_add"><input type="button" class="frm_btn" value="BBC job Add" onclick="javascript:add_quote_item('.$type.');"></div>
				';
				
}else{
	echo "No found";
}


?>