<?php

function listings_tracking_email($listing_id){ 
		
		$listing_tracking = mysql_query("select * from listing_tracking where listing_id='".$listing_id."' and date='".date("Y-m-d")."'");
		
		if(mysql_num_rows($listing_tracking)==0){
			// 100% this shouldnt work again ";
			$ins_arg = "insert into listing_tracking(listing_id,date,visits,views,phone_clicks,email) ";
			$ins_arg.=" values('".$listing_id."','".date("Y-m-d")."',1,1,0,1)";
			$ins = mysql_query($ins_arg);			
		}else{
			// edit current record for today 
			$listing_trow = mysql_fetch_array($listing_tracking);	
			$email = $listing_trow['email'];
			$email++;
			$uarg = "update listing_tracking set email=".$email." where id=".$listing_trow['id']."";
			//echo $uarg;
			$bool = mysql_query($uarg);
		}
}

function listings_tracking_phone($listing_id){ 
// phone_click is managed in this view 
// add this func in xjax for phone click 
		
		$listing_tracking = mysql_query("select * from listing_tracking where listing_id='".$listing_id."' and date='".date("Y-m-d")."'");
		
		if(mysql_num_rows($listing_tracking)==0){
			// 100% this shouldnt work again ";
			$user_id = get_rs_value("listings","user_id",mres($listing_id));
			$ins_arg = "insert into listing_tracking(user_id,listing_id,date,visits,views,phone_clicks,email) ";
			$ins_arg.=" values('".mres($user_id)."','".mres($listing_id)."','".date("Y-m-d")."',1,1,1,0)";
			//echome($ins_arg);
			$ins = mysql_query($ins_arg);			
		}else{
			// edit current record for today 
			$listing_trow = mysql_fetch_array($listing_tracking);	
			$phone_click = $listing_trow['phone_clicks'];
			$phone_click++;
			$uarg = "update listing_tracking set phone_clicks = ".$phone_click." where id=".$listing_trow['id']."";
			//echome($uarg);
			$bool = mysql_query($uarg);
		}
		
		
}


function listings_tracking_visit($listing_id){ 
// visit and View is managed in this view 
// add this function on top of details page 

	//$check_session = get_sql("temp_listing_session","id","where session_id='".session_id()."' and listing_id=".$listing_id." and date='".date("Y-m-d")."'");

	$check_arg ="select * from temp_listing_session where session_id='".session_id()."' and listing_id=".$listing_id." and date='".date("Y-m-d")."'";
	//echo $check_arg."<br>";
	$check_session = mysql_query($check_arg); 
	
	//echo "this is the view ".mysql_num_rows($check_session)."<br>";
	if(mysql_num_rows($check_session)=="0"){ 
		$ins_arg = "insert into temp_listing_session(session_id,listing_id,date) values('".session_id()."','".$listing_id."','".date("Y-m-d")."')";
		$ins = mysql_query($ins_arg);
		
		$listing_tracking = mysql_query("select * from listing_tracking where listing_id='".$listing_id."' and date='".date("Y-m-d")."'");
		$user_id = get_rs_value("listings","user_id",$listing_id);
		
		if(mysql_num_rows($listing_tracking)==0){
			// 100% this shouldnt work again ";
			$ins_arg = "insert into listing_tracking(listing_id,user_id,date,visits,views,phone_clicks,email) ";
			$ins_arg.=" values('".$listing_id."','".$user_id."','".date("Y-m-d")."',1,1,0,0)";
			//echome("1".$ins_arg);
			$ins = mysql_query($ins_arg);			
		}else{
			// edit current record for today 
			$listing_trow = mysql_fetch_array($listing_tracking);
			$visit = $listing_trow['visits'];
			$visit++;
			$views = $listing_trow['views'];
			$views++;
			$uarg = "update listing_tracking set visits=".$visit.", views=".$views." where id=".$listing_trow['id']."";
			//echome("3".$uarg);
			$bool = mysql_query($uarg);
		}
	
	}else{
		// means tyhis user has clicked this listing before 
		// view++; 
		//$check_lilsting = get_sql("listing_tracking","id","where listing-id='".$listing_id."' and date='".date("Y-m-d")."'");
		$listing_tracking = mysql_query("select * from listing_tracking where listing_id='".$listing_id."' and date='".date("Y-m-d")."'");
		$user_id = get_rs_value("listings","user_id",$listing_id);
		if(mysql_num_rows($listing_tracking)==0){
			// 100% this shouldnt work again ";
			$ins_arg = "insert into listing_tracking(listing_id,user_id,date,visits,views,phone_clicks,email) ";
			$ins_arg.=" values('".$listing_id."','".$user_id."','".date("Y-m-d")."',1,1,0,0)";
			
			//echo "2".$ins_arg;
			$ins = mysql_query($ins_arg);			
		}else{
			// edit current record for today 
			$listing_trow = mysql_fetch_array($listing_tracking);	
			$views = $listing_trow['views'];
			$views++;
			$uarg = "update listing_tracking set views=".$views." where id=".$listing_trow['id']."";
			//echo "4".$uarg;
			$bool = mysql_query($uarg);
		}
		
	}


}?>