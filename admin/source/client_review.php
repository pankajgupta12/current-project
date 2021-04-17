<?php 

if(!isset($_SESSION['client_review']['from_date'])){ $_SESSION['client_review']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['client_review']['to_date'])){ $_SESSION['client_review']['to_date'] = date("Y-m-t"); }
?>
 <div class="view_quote_back_box">
			<ul class="dispatch_top_ul application_report_search"> 				
				
					<li>
						<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['client_review']['from_date']?>">
					</li>
					
					<li>
						<label>To Date</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['client_review']['to_date']?>">
					</li>      
				
				<li>
					<label>Job id</label>
                    <input  type="text" name="job_id" id="job_id" value="<?php echo $_SESSION['client_review']['job_id']?>" >
				</li>

				
				<li>
				<strong>&nbsp;</strong>
				  <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box"  onclick="search_client_review(1,1,2);">	
				</li>

				<li>
				<strong>&nbsp;</strong>
				    <input type="reset" name="reset" value="Reset" class="offsetZero btnSet a_search_box1" onclick="search_client_review(2 , '<?php echo $_SESSION['client_review']['from_date']?>' , '<?php echo $_SESSION['client_review']['to_date']?>');">	
				</li>
			</ul>


<div id="client_review">
<? 
if(isset($_GET['action'])){ $_SESSION['client_review'] = mres($_GET['action']); }
include("xjax/view_client_review.php"); ?>
</div>

<div id="myModal" class="modal">

</div>
	