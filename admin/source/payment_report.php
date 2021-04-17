<?php
if(!isset($_SESSION['payment_report']['from_date'])){ $_SESSION['payment_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['payment_report']['to_date'])){ $_SESSION['payment_report']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['payment_report']['job_id'])){ $_SESSION['payment_report']['job_id'] = "0"; }
if(!isset($_SESSION['payment_report']['job_status'])){ $_SESSION['payment_report']['job_status'] = "0"; }
if(!isset($_SESSION['payment_report']['payment_completed'])){ $_SESSION['payment_report']['payment_completed'] = "3"; }
if(!isset($_SESSION['payment_report']['pay_staff'])){ $_SESSION['payment_report']['pay_staff'] = "0"; }
if(!isset($_SESSION['payment_report']['acc_payment_check'])){ $_SESSION['payment_report']['acc_payment_check'] = "0"; }
if(!isset($_SESSION['payment_report']['job_type'])){ $_SESSION['payment_report']['job_type'] = "0"; }
if(!isset($_SESSION['payment_report']['quote_for'])){ $_SESSION['payment_report']['quote_for'] = "0"; }

?>

<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
<div class="body_container">
	<div class="body_back body_back_disp">
    	<div class="wrapper">
        	<div class="">
            <div class="nav_form_main">
            	<ul class="dispatch_top_ul dispatch_top_ul3 dispatch5">
                	
                	<li>
                    	<label>Quote For</label>
                       	<span>
						<?php echo create_dd("quote_for","quote_for_option","id","name","status=1","",$_SESSION['payment_report']['quote_for']) ;?>  
                         </span>
                     </li> 
                	
                    <li>
                    	<label>From Date</label>
                        <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['payment_report']['from_date']?>" >
                        
                    </li>
                	<li>
                    	<label>To Date</label>
                        <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['payment_report']['to_date']?>" >
                        
                    </li>                    
                     <li>
                    	<label>Job Id</label>
                        	
                        <input type="text" name="job_id" id="job_id" value="<?php echo $_SESSION['payment_report_all']['job_id']?>">

                     </li>
                     <li>
                    	<label>Job Status</label>
                       	<span>
						<?php echo create_dd("job_status","system_dd","id","name","type=26","", $_SESSION['payment_report']); ?>
                         </span>
                     </li>   
                     <li>
                    	<label>Admin Check</label>
                       	<span>
						<?php echo create_dd("payment_completed","system_dd","id","name","type=29","", $_SESSION['payment_report']); ?>
                         </span>
                     </li>   
                     <li>
                    	<label>Pay Staff</label>
                       	<span>
						<?php echo create_dd("pay_staff","system_dd","id","name","type=29","", $_SESSION['payment_report']); ?>
                         </span>
                     </li>   

                     <li>
                    	<label>Acc Check</label>
                       	<span>
						<?php echo create_dd("acc_payment_check","system_dd","id","name","type=29","", $_SESSION['payment_report']); ?>
                         </span>
                     </li>

					 <li>
						<label>Job Type</label>
						<span>
						<?php echo create_dd("job_type","system_dd","id","name","type=68","",$_SESSION['payment_report']);?> </span>
						</li>
					 
                     <li>
					    <input type="button" id="payment_report_submit" onClick="search_payment_report(1);" style="margin-top: 25px;" value="Search">
                     </li>  
                    <li>
					    <input type="reset" id="payment_report_submit" value="Reset"   style="margin-top: 25px;" onClick="reset_payment_report('<?php echo date("Y-m-1"); ?>','<?php echo date("Y-m-t"); ?>' , 1);">
                    </li>
                </ul><br>
            </div>
                
             <div class="table_dispatch_report scrollTable" id="payment_view" style="margin-top: 25px;height:100%;">
				<?php   include("xjax/view_payment.php"); ?>
             </div>
        	</div>
        </div>
    </div>
</div>