<?php 

//print_r($_GET);

//echo "SELECT * FROM `bcic_review` where 1=1 AND job_id = ".$_GET['job_id']." AND job_type = ".$_GET['type']."";
$sql1 = mysql_query("SELECT * FROM `bcic_review` where 1=1 AND job_id = ".$_GET['job_id']." AND job_type = ".$_GET['type']."");

$countres = mysql_num_rows($sql1);


?>

<div class="body_container">
	<div class="body_back">
		<form method="post" id="form">
    	<div class="wrapper" style="width: 80%;">
    	    <div class="black_screen1"></div>
        		<span class="main_head"><?php echo $reviewDetails['name']; ?> Review Details</span>
				
		<?php  
		
		 if($countres > 0) {
		$reviewDetails = mysql_fetch_assoc($sql1); ?>		
				
        		<span class="last_login_date" style="margin-top: -37px;">Review date : <?php echo $reviewDetails['review_date']; ?></span>
                <ul class="create_quote_lst">
                    
					<li>
                    	<label>Job ID </label>
						<label><?php echo $reviewDetails['job_id']; ?></label>
                    </li>
					<li>
                    	<label>Name </label>
						<label><?php echo $reviewDetails['name']; ?></label>
                    </li>
					<li>
                    	<label>Email</label>
						<label><?php echo $reviewDetails['email']; ?></label>
                    </li>
					<li>
                    	<label>Phone Number</label>
						<label><?php echo $reviewDetails['phone']; ?></label>
                    </li>
					<li>
							<label>Overall Ratting </label>
							<label><?php print_r(json_decode($reviewDetails['overall_experience'] ,true)); ?></label>
					</li>
					
                  
                </ul>
				
				<span class="main_head">Negative/Positive  Experience</span>
					 <ul class="exp body_back_new">
					    <?php  if($reviewDetails['positive_comment'] != '') { ?>
							<li>
								<label><strong>Positive Experience :</strong></label>
								<label><?php echo $reviewDetails['positive_comment']; ?></label>
							</li>
						<?php  } ?>	
						
						 <?php  if($reviewDetails['negative_comment'] != '') { ?>
							<li>
								<label><strong>Negative Experience : </strong></label>
								<label><?php echo $reviewDetails['negative_comment']; ?></label>
							</li>
						<?php  } ?>
						
					 </ul>	
				
				<?php $rattingDetails =  json_decode($reviewDetails['rating'] ,true);

                  if(!empty($rattingDetails)) {
				?>
				
					<span class="main_head">Review Question & Rating </span>
					 <ul class="create_quote_lst1 ">
						<li style="padding: 7px;">
							<label><strong>Question </strong></label>
							<label><strong>Rating</strong></label>
						</li>
						
					   <?php foreach($rattingDetails as $key=>$value) { ?>
						<li>
							<label><?php echo get_rs_value("bcic_review_ques","ques",$key);?></label>
							<label><?php echo $value; ?></label>
						</li>
						<?php  } ?>
					</ul>	
				  <?php  } ?>	
			 <?php   }else { ?>		  
			 <span class="main_hea1d">Not Found data</span>
			 <?php  } ?>
        	</div>
		
            
            
            </form></div>
        </div>
	<style>
.create_quote_lst li label {
	font-weight:bold;
}
.create_quote_lst li label + label {
	font-weight:500;
}
.create_quote_lst > li label, .clean_lst li label, .frm_rght_lst > li label {
    font-size: 14px;
    white-space: nowrap;
}
.create_quote_lst1 li label + label {
	float:right;
}
.job_body_box {
    height: 100%;
	background:#FFF;
}
.body_back {
    background: transparent;
}
.wrapper .main_head {
    font-size: 16px;
    color: #fff;
    text-transform: capitalize;
    background: #00b8d4;
    padding: 10px;
    border-radius: 7px 7px 0 0;
    border: none;
    margin: 0;
}
.create_quote_lst {
    width: 100%;
    display: inline-block;
    padding: 0px;
    border: 1px solid #00b8d4;
    margin: 0 0 15px 0;
}
.body_back li {
    list-style: none;
    border: 1px solid #DDD;
    border-width: 0px 0px 1px 0;
    margin: 0;
    padding: 10px !important;
    width: 100%;
	list-style:none;
}
.create_quote_lst > li label, .clean_lst li label, .frm_rght_lst > li label {
    font-size: 14px;
    white-space: nowrap;
    color: #555;
    font-weight: 600;
    text-transform: capitalize;
    width: 48%;
    padding: 0px 10px;
    margin: 0;
}
.last_login_date {
    margin: 15px;
    color: #fff;
    position: relative;
    top: 4px;
    font-weight: 100;
}
.exp {
	width: 100%;
    display: inline-block;
    padding: 0px;
    border: 1px solid #00b8d4;
    margin: 0 0 15px 0;
}
.exp li label {
    font-size: 14px;
    white-space: nowrap;
    color: #555;
    font-weight: 600;
    text-transform: capitalize;
    width: 48%;
    padding: 0 10px;
    margin: 0;
    display: inline-block;
}
.body_back li {
    border: 1px solid #DDD;
    border-width: 0px 0px 1px 0;
    margin: 0;
    padding: 10px !important;
    width: 100%;
    display:flex;
	list-style:none;
}
.body_back_new li label {
    width:25% !Important;
    white-space: normal;
}
.body_back_new li label + label {
    width:75% !Important;
    font-size: 13px !important;
    line-height: 20px;
    font-weight:200;
    white-space: normal;
}
.create_quote_lst1 li:first-child label {
	font-size: 18px;
	font-weight: bold;
}
.create_quote_lst1 {
    border: 1px solid #00b8d4;
}
ul.create_quote_lst1 li label {
    width: 50%;
    display: inline-block;
    padding: 0 10px;
    font-size: 14px;
    color: #555;
    font-weight: normal;
}
</style>	