<?php  

session_start();
include_once("../source/functions/functions.php");
include_once("../source/functions/config.php");
  
		$pageid = $_POST['page'];
		$id = $_POST['id'];
		if($pageid == 'subhead'){
			
			 if($id == 1) {
				 echo create_dd("track_heading","system_dd","id","name","type = 113 order by id asc","", $_POST);
			 }else if($id == 2) {
				 echo create_dd("track_heading","system_dd","id","name","type = 116 order by id asc","", $_POST);
			 }else if($id == 3) {
				 echo create_dd("track_heading","system_dd","id","name","type = 117 order by id asc","", $_POST);
			 }else if($id == 4) {
				 echo create_dd("track_heading","system_dd","id","name","type = 123 order by id asc","", $_POST);
			 }else if($id == 5) {
				 echo create_dd("track_heading","system_dd","id","name","type = 131 order by id asc","", $_POST);
			 }else if($id == 6) {
				 echo create_dd("track_heading","system_dd","id","name","type = 137 order by id asc","", $_POST);
			 }else if($id == 7) {
				 echo create_dd("track_heading","system_dd","id","name","type = 138 order by id asc","", $_POST);
			 }else{
				 echo 'Not found';
			 }
		}
		

?>