<?php 
if($_SESSION['job_avail']['job_type_id'] == "") { $_SESSION['job_avail']['job_type_id'] = 1;} 
?>
<div class="body_container">
	<div class="body_back body_back_disp">
    	<div class="wrapper">
		        <ul class="dispatch_top_ul job_avail_check">
                        <li>
						<label>Job Type</label>
							<span>
                              <?php echo create_dd("job_type_id","job_type","id","name","id in (1,2,3)","", $_SESSION['job_avail']);?>
                         </span>
					    </li>
					   <li>
					     <label></label>
							<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box_one" onclick="javascript:search_job_avail(1);">	
						</li>
					    <li>
						   <label></label>
							<input type="reset" name="reset" value="Reset" onclick="search_job_avail(2);" class="offsetZero btnSet a_search_box">	
						</li>	
				</ul>	
			<div id="daily_view">
			  <?  include("xjax/view_job_available.php"); ?>
			</div>
        </div>
    </div>
</div>
<style>
 .job_avail_check li label {
    font-size: 17px;
    color: #848484;
    min-height: 30px;
    display: inline-block;
}
</style>