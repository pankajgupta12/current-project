<?php  
if(!isset($_SESSION['re_payment_report']['from_date'])){ $_SESSION['re_payment_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['re_payment_report']['to_date'])){ $_SESSION['re_payment_report']['to_date'] = date("Y-m-t"); }

?>
<div class="body_container">
	<div class="body_back body_back_disp">
    	<div class="wrapper">
        	<div class="">
            <div class="nav_form_main">
            	<ul class="dispatch_top_ul dispatch_top_ul3 dispatch5">
                    <li>
                    	<label>From Date</label>
                        <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['re_payment_report']['from_date']?>" >
                        
                    </li>
                	<li>
                    	<label>To Date</label>
                        <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['re_payment_report']['to_date']?>" >
                        
                    </li>                    
                     
                     <li>
                    	<label>Location</label>
                       	<span>
						 <?php echo create_dd("site_id","sites","id","name","","", $_SESSION['re_payment_report']);?>
                         </span>
                     </li>   
                     <li>
                    	<label>RE Name</label>
                         <input name="real_estate_id" type="text" placeholder="Enter real estate name..." class="input_search" id="real_estate_id" onKeyup="javascript:search_real_agent_name(this);" autocomplete="off" value="" />
                         <div class="clear"></div>
                        <div id="search_real_agent_name_div" style="display:none;"></div>
                     </li>   
                    
                     <li>
					    <input type="button" id="re_payment_report_submit" onClick="re_search_payment_report();" style="margin-top: 25px;" value="Search">
                     </li>  
                    <li>
					    <input type="reset" id="re_payment_report_submit" value="Reset"   style="margin-top: 25px;" onClick="re_reset_payment_report('<?php echo date("Y-m-1"); ?>','<?php echo date("Y-m-t"); ?>');">
                    </li>					
					 
                </ul><br>

            </div>
                
             <div class="table_dispatch_report scrollTable" id="payment_view" style="margin-top: 25px;height:100%;">
				<?php  include("xjax/view_real_estate_payment.php"); ?>
             </div>
        	</div>
            
        </div>
    </div>
	
</div>


