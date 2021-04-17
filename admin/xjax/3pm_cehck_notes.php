
<span style="text-align:left;">
<? 


  $getdata = mysql_fetch_assoc(mysql_query("SELECT Q.name  as name , J.staff_id as staffid ,   J.job_id as jid ,J.quote_id as qid , Q.email as email , Q.phone as phone , J.job_type as jtype  FROM `job_details` J, quote_new Q WHERE  J.quote_id = Q.id AND J.id = ".$id.""));
//INSERT INTO `system_dd` (`id_val`, `id`, `name`, `type`) VALUES (NULL, '3', 'Re-Clean Jobs', '101');
  $staffDetails = mysql_fetch_array(mysql_query("Select name , email , mobile from staff where id = ".$getdata['staffid'].""));
  
   $typeNotes = mysql_fetch_array(mysql_query("Select name , id from system_dd where type = 101 AND id = ".$type.""));
  
  
	echo  '<h3 style="text-align: center;padding: 10px;">'.$typeNotes['name'].'</h3>';
	echo '<hr>';
	echo '<br/>';
	echo 'Quote id:'.$getdata['qid'].'<br />
	Job ID '.$getdata['jid'].'<br />
	'.$getdata['name'].'<br />
	<a href="mailto:'.$getdata['email'].'">'.$getdata['email'].'</a><br />
	<a href="tel:'.$getdata['phone'].'">'.$getdata['phone'].'</a><br />';

	echo '<br/>';
	echo   '<hr>'; 
	echo   '<hr>';
	echo '<br/>';	
	
	echo 'Staff Details:<br />
	'.$staffDetails['name'].'<br />
	<a href="mailto:'.$staffDetails['email'].'">'.$staffDetails['email'].'</a><br />
	<a href="tel:'.$staffDetails['mobile'].'">'.$staffDetails['mobile'].'</a><br />';   
	
?>
</span>
<div class="modal-content">


<div id="q_notes_content">
<?
 include("3pm_report_addlist_notes.php"); 
 
?>
<style>
  .called_details {
    list-style-type: none;
   
}
 .called_details li {
    float: left;
}

#quote_notes_div {
    display: inline-block;
}
</style>
</div>
</div>