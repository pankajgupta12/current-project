<link href="../css/general.css" rel="stylesheet" type="text/css">
<br>
<?

$rights = get_rs_value("admin","rights",$_SESSION['admin']);

if($rights!="0"){ 

if(!isset($_SESSION['payment_report_all']['from_date'])){ $_SESSION['payment_report_all']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['payment_report_all']['to_date'])){ $_SESSION['payment_report_all']['to_date'] = date("Y-m-t"); }
//if(!isset($_SESSION['payment_report_all']['site_id'])){ $_SESSION['payment_report_all']['site_id'] = "0"; }
if(!isset($_SESSION['payment_report_all']['job_id'])){ $_SESSION['payment_report_all']['job_id'] = ""; }
if(!isset($_SESSION['payment_report_all']['job_status'])){ $_SESSION['payment_report_all']['job_status'] = "3"; }
if(!isset($_SESSION['payment_report_all']['payment_completed'])){ $_SESSION['payment_report_all']['payment_completed'] = "0"; }
if(!isset($_SESSION['payment_report_all']['pay_staff'])){ $_SESSION['payment_report_all']['pay_staff'] = "0"; }
if(!isset($_SESSION['payment_report_all']['acc_payment_check'])){ $_SESSION['payment_report_all']['acc_payment_check'] = "0"; }

if(!isset($_SESSION['payment_report_all']['quote_for'])){ $_SESSION['payment_report_all']['quote_for'] = "0"; }

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
						<?php echo create_dd("quote_for","quote_for_option","id","name","status=1","",$_SESSION['payment_report_all']['quote_for']) ;?>  
                         </span>
                     </li> 

                    <li>
                    	<label>From Date</label>
                        <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['payment_report_all']['from_date']?>" >                        
                    </li>
                	<li>
                    	<label>To Date</label>
                        <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['payment_report_all']['to_date']?>" >
                    </li>                    
                  
                   <li>
                    	<label>Job Id</label>
                        	
                        <input type="text" name="job_id" id="job_id" value="<?php echo $_SESSION['payment_report_all']['job_id']?>">

                     </li>
                  
                     <li>
                    	<label>Job Status</label>
                       	<span>
						<?php echo create_dd("job_status","system_dd","id","name","type=26","", $_SESSION['payment_report_all']); ?>
                         </span>
                     </li>   
                     <li>
                    	<label>Admin Check</label>
                       	<span>
						<?php echo create_dd("payment_completed","system_dd","id","name","type=29","", $_SESSION['payment_report_all']); ?>
                         </span>
                     </li>   
                     <li>
                    	<label>Pay Staff</label>
                       	<span>
						<?php echo create_dd("pay_staff","system_dd","id","name","type=29","", $_SESSION['payment_report_all']); ?>
                         </span>
                     </li>   

                     <li>
                    	<label>Acc Check</label>
                       	<span> 
						<?php echo create_dd("acc_payment_check","system_dd","id","name","type=29","", $_SESSION['payment_report_all']); ?>
                         </span>
                    </li> 
					 
                    <li>
					    <input type="button" id="payment_report_submit" onClick="search_payment_report_all(1);"  style="margin-top: 25px;" value="Search">
                     </li>  
                    <li>
					    <input type="reset" id="payment_report_submit" value="Reset" style="margin-top: 25px;" onClick="reset_payment_report_all('<?php echo date("Y-m-1"); ?>','<?php echo date("Y-m-t"); ?>');">
                    </li>						 
					 
                </ul><br>

            </div>
                
             <div class="table_dispatch_report scrollTable" id="payment_view" style="margin-top: 25px;height:100%;">
				<?php include("xjax/view_payment_all.php"); ?>
             </div>
        	</div>
            
        </div>
    </div>
	
</div>


<script src="../../jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="../../jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<link href="../../jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../../jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../../jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
 <script> 
        $(function() {
			  $("#from_date").datepicker({dateFormat:'yy-mm-dd'});
			  $("#to_date").datepicker({dateFormat:'yy-mm-dd'});
        });
    </script>
    
<? }else{ echo " You dont have permission in this module"; }   ?>
